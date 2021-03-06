<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "insumo".
 *
 * @property integer $idprodutoVenda
 * @property integer $idprodutoInsumo
 * @property double $quantidade
 * @property string $unidade
 *
 * @property Produto $idprodutoVenda0
 */
class Insumo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'insumo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idprodutoVenda', 'idprodutoInsumo', 'quantidade', 'unidade', 'idprodutoInsumo[]'], 'required'],
            [['idprodutoVenda', 'idprodutoInsumo'], 'integer'],
            [['quantidade'], 'number'],
            [['unidade'], 'string', 'max' => 15]
        ];
    }

    public function validateIdsProdutosInsumos($attribute, $params)
    {
        if (!in_array($this->$attribute, ['USA', 'Web'])) {
            $this->addError($attribute, 'The country must be either "USA" or "Web".');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idprodutoVenda' => Yii::t('app', 'Produto Venda'),
            'idprodutoInsumo' => Yii::t('app', 'Insumo'),
            'quantidade' => Yii::t('app', 'Quantidade'),
            'unidade' => Yii::t('app', 'Unidade'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdprodutoVenda()
    {
        return $this->hasOne(Produto::className(), ['idProduto' => 'idprodutoVenda']);
    }

    public function getProdutoInsumo()
    {
        return $this->hasOne(Produto::className(), ['idProduto' => 'idprodutoInsumo']);
    }

    public function getNomeinsumo()
    {
        return Produto::find()->where(['idProduto' => $this->idprodutoInsumo])->one()->nome;
    }

    public function getNomeprodutovenda()
    {
        return Produto::find()->where(['idProduto' => $this->idprodutoVenda])->one()->nome;
    }

    /**
     * Atualiza a quantidade de estoque do Produto
     * @param $idProdVnd
     * @param int $qtdProdVnd
     */
    public function atualizaQtdNoEstoqueInsert($idProdVnd, $qtdProdVnd = 1)
    {
        $insumos = Insumo::find()->where(['idProdutoVenda' => $idProdVnd])->all();

        $produto = new Produto();

        foreach ($insumos as $key => $ins) {

            $qtdInsumo = $ins->quantidade * $qtdProdVnd;

            $qtdEstoque = $produto::find()->where(['idProduto' => $ins->idprodutoInsumo])->one()->quantidadeEstoque;

            if (($qtdEstoque - $qtdInsumo) > 0) {

                Yii::$app->db->createCommand(
                    "UPDATE produto SET quantidadeEstoque =
                (quantidadeEstoque - :qtd_insumo)
                where idProduto = :idprodutoInsumo", [
                    ':qtd_insumo' => $qtdInsumo,
                    ':idprodutoInsumo' => $ins->idprodutoInsumo,
                ])->execute();

            }
        }

    }

    /**
     * Atualiza a quantidade de estoque do Produto
     * @param $idProdVnd
     * @param int $qtdProdVnd
     * @return bool
     */
    public function atualizaQtdNoEstoqueDelete($idProdVnd, $qtdProdVnd = 1)
    {
        $insumos = Insumo::find()->where(['idProdutoVenda' => $idProdVnd])->all();

        $itensDeletados = true;

        foreach ($insumos as $key => $ins) {

            $qtdInsumo = $ins->quantidade * $qtdProdVnd;

            $produto = Produto::find()->where(['idProduto' => $ins->idprodutoInsumo])->one();

            $produto->quantidadeEstoque += $qtdInsumo;

            if (!$produto->save()) {
                $itensDeletados = false;

            }
        }

        if ($itensDeletados) {
            return true;
        }
        return false;
    }

    /**
     * Atualiza a quantidade de estoque do Produto
     * @param $newIdProdVnd
     * @param $oldIdProdVnd
     * @param int $qtdProdVnd
     * @param $oldQtdProdVnd
     */
    public function atualizaQtdNoEstoqueUpdate($newIdProdVnd, $oldIdProdVnd, $qtdProdVnd = 1, $oldQtdProdVnd)
    {
        $produto = new Produto();

        if ($newIdProdVnd != $oldIdProdVnd) {

            $insumos = Insumo::find()->where(['idProdutoVenda' => $oldIdProdVnd])->all();

            foreach ($insumos as $key => $ins) {

                $qtdInsumo = $ins->quantidade * $qtdProdVnd;

                $qtdEstoque = $produto::find()->where(['idProduto' => $ins->idprodutoInsumo])->one()->quantidadeEstoque;

                Yii::$app->db->createCommand(
                    "UPDATE produto SET quantidadeEstoque =
            (quantidadeEstoque + :qtd_insumo)
            where idProduto = :idprodutoInsumo", [
                    ':qtd_insumo' => $qtdInsumo,
                    ':idprodutoInsumo' => $ins->idprodutoInsumo,
                ])->execute();

            }

            $insumos = Insumo::find()->where(['idProdutoVenda' => $newIdProdVnd])->all();

            foreach ($insumos as $key => $ins) {

                $qtdInsumo = $ins->quantidade * $qtdProdVnd;

                $qtdEstoque = $produto::find()->where(['idProduto' => $ins->idprodutoInsumo])->one()->quantidadeEstoque;

                if (($qtdEstoque - $qtdInsumo) > 0) {

                    Yii::$app->db->createCommand(
                        "UPDATE produto SET quantidadeEstoque =
            (quantidadeEstoque - :qtd_insumo)
            where idProduto = :idprodutoInsumo", [
                        ':qtd_insumo' => $qtdInsumo,
                        ':idprodutoInsumo' => $ins->idprodutoInsumo,
                    ])->execute();

                }
            }

        } else {

            $insumos = Insumo::find()->where(['idProdutoVenda' => $newIdProdVnd])->all();

            if ($qtdProdVnd > $oldQtdProdVnd) {

                foreach ($insumos as $key => $ins) {

                    $aux = $qtdProdVnd - $oldQtdProdVnd;

                    $qtdInsumo = $ins->quantidade * $aux;

                    $qtdEstoque = $produto::find()->where(['idProduto' => $ins->idprodutoInsumo])->one()->quantidadeEstoque;

                    if (($qtdEstoque - $qtdInsumo) > 0) {

                        Yii::$app->db->createCommand(
                            "UPDATE produto SET quantidadeEstoque =
                (quantidadeEstoque - :qtd_insumo)
                where idProduto = :idprodutoInsumo", [
                            ':qtd_insumo' => $qtdInsumo,
                            ':idprodutoInsumo' => $ins->idprodutoInsumo,
                        ])->execute();
                    }
                }
            } else {

                foreach ($insumos as $key => $ins) {

                    $aux = $oldQtdProdVnd - $qtdProdVnd;

                    $qtdInsumo = $ins->quantidade * $aux;

                    $qtdEstoque = $produto::find()->where(['idProduto' => $ins->idprodutoInsumo])->one()->quantidadeEstoque;

                    if (($qtdEstoque - $qtdInsumo) > 0) {

                        Yii::$app->db->createCommand(
                            "UPDATE produto SET quantidadeEstoque =
                (quantidadeEstoque + :qtd_insumo)
                where idProduto = :idprodutoInsumo", [
                            ':qtd_insumo' => $qtdInsumo,
                            ':idprodutoInsumo' => $ins->idprodutoInsumo,
                        ])->execute();
                    }
                }
            }
        }

    }


}

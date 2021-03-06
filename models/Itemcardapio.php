<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "itemcardapio".
 *
 * @property integer $idCardapio
 * @property integer $idProduto
 * @property integer $status
 * @property integer $ordem
 *
 * @property Cardapio $idCardapio0
 * @property Produto $idProduto0
 */
class Itemcardapio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'itemcardapio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['idCardapio', 'idProduto'], 'required'],
        [['idCardapio', 'idProduto', 'status', 'ordem'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'idCardapio' => 'Cardápio',
        'idProduto' => 'Produto',
        'status' => 'Status',
        'ordem' => 'Ordem',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardapio()
    {
        return $this->hasOne(Cardapio::className(), ['idCardapio' => 'idCardapio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::className(), ['idProduto' => 'idProduto']);
    }
}

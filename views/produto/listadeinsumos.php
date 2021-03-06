<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelProduto app\models\Produto */
/* @var $produtosVenda array */

$this->title = 'Lista de insumos de um Produto';

?>
<div class="produto-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin(); ?>
    <?= '<label class="control-label">Produto Venda</label>'; ?>
    <?= Select2::widget([
        'name' => 'produtovenda',
        'data' => $produtosVenda,
        'options' => [
            'required' => true,
            'placeholder' => 'Digite o produto venda',
            //  'multiple' => true
        ],
    ]); ?>
    </br>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary btn-block',
            'title' => 'Clique para listar os insumos do Produto selecionado',]) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="panel panel-default">

        <?php
        if (isset($insumos)) {
            ?>
            <div class="panel-heading">Insumos de <?= $modelProduto->nome ?></div> <?php
            foreach ($insumos as $insumo) {
                ?>
                <div class="panel-body"><?= Html::a($insumo->nome, Url::toRoute(['/insumo/view',
                        'idprodutoVenda' => $modelProduto->idProduto, 'idprodutoInsumo' => $insumo->idProduto,
                       ])) ?>
                </div>
                <?php
            }
        }

        ?>
    </div>
</div>

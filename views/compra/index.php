<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CompraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Compras');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Compras'), 'url' => ['index']];
?>
<div class="compra-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}', ['model' => 'Compra']), ['create'], ['class' => 'btn btn-success',
            'title'=>'Clique aqui para cadastrar uma nova Compra']) ?>

        <?= Html::a(Yii::t('app', 'Orçamento de Compra de Insumos', ['model' => 'OrcamentoCompra']),
            ['/orcamentocompra/orcamentocomprainsumos'], ['class' => 'btn btn-success',
                'title'=>'Clique aqui para gerar um orçamento de uma Compra']) ?>
    </p>

    <div class="table-responsive">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' =>  'dataCompra',
                    'format' => 'raw',
                    'value' => function ($modelCompra) {

                        return Html::a(date('d/m/Y',
                                strtotime($modelCompra->dataCompra))
                            , ['view', 'id' => $modelCompra->idconta]);
                    }
                ],


               [
                   'attribute'=> 'conta.valor',
                   'value'=>function($modelCompra){
                        return isset( $modelCompra->conta->valor) ? 'R$ ' . $modelCompra->conta->valor: null;
                   }
               ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
<?php
if (isset($mensagem) && !empty($mensagem)) {
    ?>
    <script type="text/javascript">alert('<?= $mensagem; ?>');</script>
    <?php
}
?>
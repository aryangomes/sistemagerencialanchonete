<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FormapagamentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Forma de Pagamentos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="formapagamento-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}', ['model' => 'Forma de Pagamento']), ['create'], ['class' => 'btn btn-success']) ?>

    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            [
                'attribute' => 'titulo',
                'format'=>'raw',
                'value' => function ($modelFormapagamento) {
                    return Html::a($modelFormapagamento->titulo, ['view' ,
                        'id' => $modelFormapagamento->idTipoPagamento]);
                },
            ],

            'descricao:ntext',

            ['class' => 'yii\grid\ActionColumn',

            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

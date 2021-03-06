<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $modelRelatorio app\models\Relatorio */
/* @var $form yii\widgets\ActiveForm */
/* @var $valoresContasAReceber array */
/* @var $tiposRelatorio array */
/* @var $tipoRelatorio string */


$this->title = $modelRelatorio->isNewRecord ? Yii::t('app', 'Create {model}', ['model' => 'Relatório']) :
    Yii::t('app', 'View {model}', ['model' => 'Relatório']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Relatorios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <h1><?= Html::encode($this->title) ?></h1>
    <div class="relatorio-form">

        <?php $form = ActiveForm::begin(); ?>



        <?= $form->field($modelRelatorio, 'datageracao')->hiddenInput(['value' => date('Y-m-d')])->label(false); ?>

        <?=
        $form->field($modelRelatorio, 'tipo')->textInput(
            ['disabled' => true,'value'=>$tipoRelatorio])
        ?>



        <?=
        $form->field($modelRelatorio, 'inicio_intervalo')->widget(DateControl::classname(), [
            'type' => DateControl::FORMAT_DATE,
            'ajaxConversion' => false,
            'options' => [

                'pluginOptions' => [
                    'autoclose' => true
                ]
            ],
            'displayFormat' => 'dd/MM/yyyy',
            'language' => 'pt',
        ]);
        ?>

        <?=
        $form->field($modelRelatorio, 'fim_intervalo')->widget(DateControl::classname(), [
            'type' => DateControl::FORMAT_DATE,
            'ajaxConversion' => false,
            'options' => [

                'pluginOptions' => [
                    'autoclose' => true
                ]
            ],
            'displayFormat' => 'dd/MM/yyyy',
            'language' => 'pt',
        ]);
        ?>
        <?= $form->field($modelRelatorio, 'usuario_id')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>

        <div class="form-group">
            <?= Html::submitButton($modelRelatorio->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'),
                ['class' => $modelRelatorio->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'title'=>'Clique para ir para a tela de alteração dos dados de Relatório']) ?>
            <?=
            Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $modelRelatorio->idrelatorio], [
                'class' => 'btn btn-danger',
                'title' => 'Clique para apagar esse relatório',
                'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'method' => 'post',

                ],
            ])
            ?>
            <?=
            Html::a('Gerar PDF', ['pdfcontasareceber', 'id' => $modelRelatorio->idrelatorio], [
                'class' => 'btn btn-danger',
                'target' => '_blank',
                'data-toggle' => 'tooltip',
                'title' => 'Clique para gerar um PDF',
                'disabled' =>
                    (isset($modelRelatorio->idrelatorio) && count($valoresContasAReceber) > 0) ?
                        false : true,
            ]);
            ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

<?php
if (isset($modelRelatorio->idrelatorio) && count($valoresContasAReceber) > 0) {
    HighchartsAsset::register($this)->withScripts(['highstock', 'modules/exporting', 'modules/drilldown']);
    echo Highcharts::widget([

        'options' => [
            'chart' => [
                'type' => 'column'],
            'title' => ['text' => 'Valores recebidos  de <b>' .
                $modelRelatorio->formatarDataDiaMesAno($modelRelatorio->inicio_intervalo) . ' até ' .
                $modelRelatorio->formatarDataDiaMesAno($modelRelatorio->fim_intervalo)],
            'xAxis' => [
                'categories' => ['Data']
            ],
            'yAxis' => [
                'title' => ['text' => 'Valor(R$)']
            ],
            'credits' => false,
            'series' => $valoresContasAReceber
        ]
    ]);
} else {
    ?>
    <div class="alert alert-warning">
        <strong>Informação!</strong> Não há registros de Contas a Receber.
    </div>
    <?php
}
?>
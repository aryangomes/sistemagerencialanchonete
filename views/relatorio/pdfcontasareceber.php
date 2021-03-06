<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $modelRelatorio app\models\Relatorio */
/* @var $form yii\widgets\ActiveForm */
/* @var $dadosContasAReceber array */
$this->title = 'Relatório de Contas A Receber';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Relatorios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<h1><?= '<p>' . Html::encode($this->title) . '</p>' ?></h1>
<div class="relatorio-form">

    <?=
    '<h4><p>Valores recebidos  de <b>' .
    $modelRelatorio->formatarDataDiaMesAno($modelRelatorio->inicio_intervalo) . ' até ' .
    $modelRelatorio->formatarDataDiaMesAno($modelRelatorio->fim_intervalo) . '</p></h4>'
    ?>

    <?php
    if (isset($modelRelatorio->idrelatorio)) {
        ?>
        <table class="table table-bordered">
            <thead>
            <tr>

                <th>Data</th>
                <th>Valor</th>

            </tr>
            </thead>
            <tbody>
            <?php
            for ($i = 0; $i < count($dadosContasAReceber[0]); $i++) {
                ?>

                <tr>
                    <td><?= $dadosContasAReceber[0][$i] ?></td>
                    <td><?= 'R$ ' . $dadosContasAReceber[1][$i]['data'][0] ?></td>
                </tr>
                <?php
            }
            ?>

            </tbody>
        </table>
        <?php
    }
    ?>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $modelContasareceber app\models\Contasareceber */

$this->title =isset($modelContasareceber->conta->descricao)?
    $modelContasareceber->conta->descricao:
    "Conta sem descrição";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Conta a receber'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contasareceber-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $modelContasareceber->idconta], ['class' => 'btn btn-primary',
            'title'=>'Clique para ir para a tela de alteração dos dados da Conta a Receber']) ?>
        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $modelContasareceber->idconta], [
            'class' => 'btn btn-danger',
            'title' => 'Clique para apagar essa Conta a Receber',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $modelContasareceber,
        'attributes' => [
            'idconta',
            ['attribute' => 'dataHora',
                'format' => 'text',
                'value' => isset($modelContasareceber->dataHora) ?
                    date("d/m/Y H:i", strtotime($modelContasareceber->dataHora)) : null,
            ],
        ],
    ]) ?>

</div>

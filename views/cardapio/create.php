<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cardapio */

$this->title = 'Criar Cardapio';
$this->params['breadcrumbs'][] = ['label' => 'Cardapios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cardapio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelItemCardapio'=>$modelItemCardapio,
        'mensagem' => $mensagem,
        'produtos'=>$produtos,
    ]) ?>

</div>

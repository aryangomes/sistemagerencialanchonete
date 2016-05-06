<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pedido */

$this->title = Yii::t('app', 'Create {model}',['model'=>'Pedido']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pedidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedido-create">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
		'situacaopedido'=>$situacaopedido,
		
		]) ?>

	</div>

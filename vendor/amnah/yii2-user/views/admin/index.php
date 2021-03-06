<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\AuthItem;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\search\UserSearch $searchModel
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\Role $role
 */

$module = $this->context->module;
$user = $module->model("User");
$role = $module->model("Role");

$this->title = Yii::t('user', 'Users');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}', ['model' => 'Usuário']), ['create'], ['class' => 'btn btn-success',
            'title'=>'Clique aqui para cadastrar um novo Usuário']) ?>
    </p>

    <div class="table-responsive">
        <?php \yii\widgets\Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

//                'id',
                [
                    'attribute' => 'email',
                    'format' => 'raw',
                    'value' => function ($model) {

                        return Html::a($model->email, ['view', 'id' => $model->id]);
                    }
                ],
                'profile.full_name',


                [
                    'attribute' => 'status',
                    'label' => Yii::t('user', 'Status'),
                    'filter' => $user::statusDropdown(),
                    'value' => function ($model, $index, $dataColumn) use ($user) {

                        return $model->status ? 'Ativo' : 'Não ativo';
                    },
                ],


                [
                    'attribute' => 'role_id',
                    'label' => 'Permissões',

                    'value' => function ($data) {
                        return $data->permissoes;

                    }
                ],

                [

                    'attribute' => 'created_at',

                    'value' => function ($model) {
                        return isset($model->created_at) ?
                            Yii::$app->formatter->asDate($model->created_at, 'dd/M/Y à\s H:i:s'):null;
                    },
                ],

                // 'username',
                // 'password',
                // 'auth_key',
                // 'access_token',
                // 'logged_in_ip',
                // 'logged_in_at',
                // 'created_ip',
                // 'updated_at',
                // 'banned_at',
                // 'banned_reason',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php \yii\widgets\Pjax::end(); ?>

    </div>
</div>

<?php
if (isset($mensagem) && !empty($mensagem)) {
    ?>
    <script type="text/javascript">alert('<?= $mensagem; ?>');</script>
    <?php
}
?>
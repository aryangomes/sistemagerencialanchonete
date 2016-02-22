<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\sortinput\SortableInput;
/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\User $profile
 * @var string $userDisplayName
 */

$module = $this->context->module;

$this->title = Yii::t('user', 'Register');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-default-register">

  <h1><?= Html::encode($this->title) ?></h1>

  <?php if ($flash = Yii::$app->session->getFlash("Register-success")): ?>

  <div class="alert alert-success">
    <p><?= $flash ?></p>
  </div>

<?php else: ?>

  <?php $form = ActiveForm::begin([
    'id' => 'register-form',
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
    'labelOptions' => ['class' => 'col-lg-2 control-label'],
    ],
    'enableAjaxValidation' => true,
    ]); ?>

    <?php if ($module->requireEmail): ?>
    <?= $form->field($user, 'email') ?>
  <?php endif; ?>

  <?php if ($module->requireUsername): ?>
  <?= $form->field($user, 'username') ?>
<?php endif; ?>

<?= $form->field($user, 'newPassword')->passwordInput() ?>

</div>
<div class="user-default-register">
  <?php // $form->field($user, 'role_id')->dropDownList($permissoes, ['prompt'=>'Escolha o tipo de usuário'])  ?>


  <?php

 // $form->field($user, 'role_id')->checkboxList($permissoes)  ?>

 <?php /* echo $form->field($user, 'role_id')->widget(Select2::classname(), [
  'data' => $permissoes,
  'size'=>'lg',

  'options' => ['placeholder' => 'Selecione as permissões'],
  'pluginOptions' => [
  'allowClear' => true,
  'multiple'=>true,

  ],
  'pluginEvents'=>[
  "select2:select" => "function() {
   /*
   console.log('select');
   var elements = [];
   $(document).ready(function(){




    var foo = []; 



    $('#user-role_id :selected').each(function(i, selected){ 

      foo[i] = $(selected).val(); 
      console.log( 'foo[i]: ' +  foo[i]);
      console.log( 'i: ' +  i);
      console.log( 'selected: ' +  $(selected).val());
    });

console.log( foo.length);


var opcaoselecionada ;
opcaoselecionada =foo[(foo.length - 1)];



console.log('opcaoselecionada: ' + opcaoselecionada);




switch(opcaoselecionada) {
  case 'despesa':

  if ( $(\" [value='despesa']\" ).is(':selected')) {
   console.log('despesa cliked1');
   $(\" [value='create-despesa']\" ).prop('selected',true);
   $(\" [value='index-despesa']\" ).prop('selected',true);
   $(\" [value='update-despesa']\" ).prop('selected',true);
   $(\" [value='delete-despesa']\" ).prop('selected',true);

 }
 else{
  console.log('despesa cliked2');
  $(\" [value='create-despesa']\" ).prop('selected',false);
  $(\" [value='index-despesa']\" ).prop('selected',false);
  $(\" [value='update-despesa']\" ).prop('selected',false);
  $(\" [value='delete-despesa']\" ).prop('selected',false);
}
break;
case 'fornecedor':
console.log('fornecedor cliked1');
if ( $([value='fornecedor']).is(':selected')) {
  $([value='create-fornecedor']).prop('selected',true);
  $([value='index-fornecedor']).prop('selected',true);
  $([value='update-fornecedor']).prop('selected',true);
  $([value='delete-fornecedor']).prop('selected',true);

}
else{

  $([value='create-fornecedor']).prop('selected',false);
  $([value='index-fornecedor']).prop('selected',false);
  $([value='update-v']).prop('selected',false);
  $([value='delete-fornecedor']).prop('selected',false);
}
break;
default:
break;
}
});

}",

],
]); */ ?>

<?php 

for ($i=0; $i < count($permissoes) ; $i++) { 

 echo Html::label($macroauthitems[$i])
 . '</br>';
 echo SortableInput::widget([
  'name'=>'kv-conn-' . $i,
  'items' => $permissoes[$i],

  'hideInput' => true,
  'sortableOptions' => [
  'connected'=>true,
  'pluginOptions'=>[
  'dropOnEmpty'=>true,
  ],
  ],

  'options' => ['class'=>'form-control', 'readonly'=>true , 
  'id'=>$macroauthitems[$i]]
  ]);
 echo '</div>';

 echo '<div class="col-sm-6">';
}

echo Html::label('Permissões')
. '</br>';
echo SortableInput::widget([
  'name'=>'User[role_id]',
  'items' => [
  ],
  'hideInput' => true,
  'sortableOptions' => [
  'itemOptions'=>['class'=>'alert alert-warning'],
  'connected'=>true,
  'pluginOptions'=>[
  'dropOnEmpty'=>true,
  ],
  'pluginEvents' => [
  'sortstart' => "function() { 
    console.log('sortstart'); 
  }",
  'sortupdate' => "

  function(e, ui) {


    if (ui.item.data().name == 'despesa') {
     var arraydespesavalues = ['index-despesa','view-despesa',
     'create-despesa','update-despesa','delete-despesa'];
     var arraydespesatext = ['Listar','Visualizar','Criar','Editar','Deletar'];

     for (i = 0; i < arraydespesavalues.length; i++) { 
      $(this).append('<li data-name='+'arraydespesavalues[i]'+'  data-key='+'arraydespesavalues[i]'+'  > '+arraydespesatext[i] + ' Despesa'+'</li>');
      arrayvalues.push(arraydespesavalues[i]);
    }

   // $('input[name=\"User[role_id]\"]').val(arraydespesavalues);
  //  $('#despesa-sortable').parent().remove(); 
    $(this).closest('li').remove();
  }


  else if (ui.item.data().name == 'caixa') {
   var arraycaixavalues = ['index-caixa','view-caixa',
   'create-caixa','update-caixa','delete-caixa'];
   var arraycaixatext = ['Listar','Visualizar','Criar','Editar','Deletar'];

   for (i = 0; i < arraycaixavalues.length; i++) { 
    $(this).append('<li data-name='+'arraycaixavalues[i]'+'  data-key='+'arraycaixavalues[i]'+'  > '+arraycaixatext[i] + ' Caixa'+'</li>');
    arrayvalues.push(arraycaixavalues[i]);
  }

  
//  $('input[name=\"User[role_id]\"]').val(arraycaixavalues);
//  $('#caixa-sortable').parent().remove(); 
  $(this).closest('li').remove();
}

else if (ui.item.data().name == 'compra') {
 var arraycompravalues = ['index-compra','view-compra',
 'create-compra','update-compra','delete-compra'];
 var arraycompratext = ['Listar','Visualizar','Criar','Editar','Deletar'];

 for (i = 0; i < arraycompravalues.length; i++) { 
  $(this).append('<li data-name='+'arraycompravalues[i]'+'  data-key='+'arraycompravalues[i]'+'  > '+arraycompratext[i] + ' Compra'+'</li>');
  arrayvalues.push(arraycompravalues[i]);
}

//$('input[name=\"User[role_id]\"]').val(arraycompravalues);
//$('#compra-sortable').parent().remove(); 
$(this).closest('li').remove();
}

else if (ui.item.data().name == 'relatorio') {
 var arrayrelatoriovalues = ['index-relatorio','view-relatorio',
 'create-relatorio','update-relatorio','delete-relatorio'];
 var arrayrelatoriotext = ['Listar','Visualizar','Criar','Editar','Deletar'];

 for (i = 0; i < arrayrelatoriovalues.length; i++) { 
  $(this).append('<li data-name='+'arrayrelatoriovalues[i]'+'  data-key='+'arrayrelatoriovalues[i]'+'  > '+arrayrelatoriotext[i] + ' Relatório'+'</li>');
  arrayvalues.push(arrayrelatoriovalues[i]);
}

//$('input[name=\"User[role_id]\"]').val(arrayrelatoriovalues);
//$('#relatorio-sortable').parent().remove(); 
$(this).closest('li').remove();
}

else if (ui.item.data().name == 'fornecedor') {
 var arrayfornecedorvalues = ['index-fornecedor','view-fornecedor',
 'create-fornecedor','update-fornecedor','delete-fornecedor'];
 var arrayfornecedortext = ['Listar','Visualizar','Criar','Editar','Deletar'];

 for (i = 0; i < arrayfornecedorvalues.length; i++) { 
  $(this).append('<li data-name='+'arrayfornecedorvalues[i]'+'  data-key='+'arrayfornecedorvalues[i]'+'  > '+arrayfornecedortext[i] + ' Fornecedor'+'</li>');
  arrayvalues.push(arrayfornecedorvalues[i]);
}

//$('input[name=\"User[role_id]\"]').val(arrayfornecedorvalues);
//$('#fornecedor-sortable').parent().remove(); 
$(this).closest('li').remove();
}

else if (ui.item.data().name == 'user') {
 console.log('ok-user'); 
 /*     $(this).appendTo($('#w6 li').text('Listar Usuário'));
 $(this).appendTo($('#w6 li').text('Visualizar Usuário'));
 $(this).append('<li data-name='+'index-user'+'  data-key='+'index-user'+'  >'+'Listar Usuários'+'</li>');
 $(this).append('<li data-name='+'view-user'+'  data-key='+'view-user'+'  >'+'Visualizar Usuário'+'</li>');
 $(this).append('<li data-name='+'create-user'+'  data-key='+'create-user'+'  >'+'Criar Usuário'+'</li>');
 $(this).append('<li data-name='+'update-user'+'  data-key='+'update-user'+'  >'+'Editar Usuário'+'</li>');
 $(this).append('<li data-name='+'delete-user'+'  data-key='+'delete-user'+'  >'+'Deletar Usuário'+'</li>');
 */
 var arrayuservalues = ['index-user','view-user','create-user','update-user','delete-user'];
 var arrayusertext = ['Listar','Visualizar','Criar','Editar','Deletar'];

 console.log(arrayvalues);
 var aux = [];
 for (i = 0; i < arrayuservalues.length; i++) { 
  if (arrayvalues.indexOf(arrayuservalues[i]) >= 0) {
    console.log(arrayuservalues[i]);
    aux.push(arrayuservalues[i]);
  //  arrayuservalues.splice(arrayvalues.indexOf(arrayuservalues[i]), 1);
    console.log('arrayuservalues: '+ arrayuservalues);
  }
}
for (i = 0; i < arrayuservalues.length; i++) { 
 // console.log(arrayuservalues[i]);
//  console.log(arrayusertext[i]);
  $(this).append('<li data-name='+'arrayuservalues[i]'+'  data-key='+'arrayuservalues[i]'+'  >'+arrayusertext[i] + ' Usuário'+'</li>');
  arrayvalues.push(arrayuservalues[i]);
}
console.log('arrayuservalues: '+ arrayuservalues);
//$('input[name=\"User[role_id]\"]').val(arrayuservalues);
//$('#user-sortable').parent().remove(); 
$(this).closest('li').remove();

}else{

  if (arrayvalues.indexOf(ui.item.data().name) < 0) {
  //  console.log(arrayuservalues[i]);
    arrayvalues.push(ui.item.data().name);
  }
  
//  arrayvalues.push(ui.item.data().name);

}


$('input[name=\"User[role_id]\"]').val(arrayvalues);
/*console.log(arrayvalues); 
console.log(ui.item.data().name); */
$(this).sortable('refresh');


var sortedIDs = $( this ).sortable( 'toArray' );
//console.log(sortedIDs); 

}",
'forcePlaceholderSize'=>'true',
],
],
'options' => ['class'=>'form-control',
'readonly'=>true, 'placeholder'=>'Arraste para cá'],


]);

?>

<?php /* uncomment if you want to add profile fields here
<?= $form->field($profile, 'full_name') ?>
        */ ?>

        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <?= Html::submitButton(Yii::t('user', 'Register'), ['class' => 'btn btn-primary']) ?>

            <br/><br/>
            <?= Html::a(Yii::t('user', 'Login'), ["/user/login"]) ?>
          </div>
        </div>

        <?php ActiveForm::end(); ?>

        <?php if (Yii::$app->get("authClientCollection", false)): ?>
        <div class="col-lg-offset-2 col-lg-10">
          <?= yii\authclient\widgets\AuthChoice::widget([
            'baseAuthUrl' => ['/user/auth/login']
            ]) ?>
          </div>
        <?php endif; ?>

      <?php endif; ?>

    </div>
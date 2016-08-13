<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Pedido */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pedido-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
            $form->field($model, 'idSituacaoAtual')
            ->dropDownList($situacaopedido, ['prompt' => 'Selecione a situação do pedido'])
    ?>  
    <?php
    if ($model->isNewRecord) {
        //Cadastrar
        ?>


        <?=
        $form->field($itemPedido, 'idProduto[]')->widget(Select2::classname(), [
            'data' => $produtosVenda,
            'options' => ['placeholder' => 'Selecione o produto'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);
        ?>

        <?=
        $form->field($itemPedido, 'quantidade[]')->textInput([ 'type' => 'number', 'value' => 1, 'min' => 0]);
        ?>


        <?php
    } else {
        //Atualizar
        echo $form->field($model,'idPedido')->hiddenInput(['id'=>'idpedido'])
                ->label(false);
        for ($i = 0; $i < count($itemPedido); $i++) {
            ?><div class="form-group field-insumos-idprodutoinsumo required" id="<?= 'inputinsumo' . $i ?>"> 
            <?php
            echo Html::activeLabel($itemPedido[$i], 'idProduto', ['class' => 'control-label']);
            echo Select2::widget([
                'model' => $itemPedido[$i],
                'name' => 'Itempedido[idProduto][]',
                'value' => $itemPedido[$i]->idProduto,
                'data' => $produtosVenda,
                'options' => ['placeholder' => 'Selecione o insumo',
                    'id' => 'idinsumo' . $i,
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
                'pluginEvents' => [
                    "change" => "function() {
    	var s = $(\"#idinsumo" . $i . "\").val();
    	console.log(s); 
    	if (s == \"\" || s == null) {
    		$(\".help-block-insumo" . $i . "\").append('</br><div class=\"alert alert-danger\">\"Insumo\" não pode ficar em branco.</div>');
    		//alert('Escolha um insumo ou remova-o');
    	}else{
    		$(\".help-block-insumo" . $i . "\").remove();
    	}
    }",
                ],
            ]);
            ?><div class="help-block-insumo<?= $i ?>"> </div><?php
                echo "</br>";

                echo $form->field($itemPedido[$i], 'quantidade[]')->textInput([ 'type' => 'number', 'value' => $itemPedido[$i]->quantidade, 'min' => 0]);
                ?>
                <input class="btn btn-danger" onclick="removeins(<?= $i ?>)" type='button' value="Remover Item Pedido"> </div></br><?php
        }
    }
    ?>

    <div class="table-responsive" id="input-dinamico">

    </div>

    <?php
    $options = array();
    $opt = "<option value=\"\">Selecione um produto</option>";
    array_push($options, $opt);
    foreach ($produtosVenda as $k => $v) {
        $opt = "<option value=\"" . $k . "\">" . $v . "</option>";
        array_push($options, $opt);
    }
    $o = implode("", $options);

    $this->registerJs('var i = 1; $("#btnadprodutocompra").on("click",function(){'
            . '$("#input-dinamico").append(\'<div id="inputinsumo\'+i+\'" ><div class="form-group field-itempedido-idprodutoinsumo required"><label class="control-label" for="itempedido-idprodutoinsumo">Produto</label><select id="itempedido-idproduto" class="form-control" name="Itempedido[idProduto][]" >' . $o . '</select><div class="help-block"></div></div><div class="form-group field-itempedido-quantidade required"><label class="control-label" for="quantidade\'+i+\'">Quantidade</label><input type="number" id="quantidade\'+i+\'" class="form-control" name="Itempedido[quantidade][]" value="1" min="0" step="1"><div class="help-block"></div></div><input class="btn btn-danger" onclick="removeins(\'+i+\')" type="button" value="Remover Item Pedido"></div><hr></div>\');'
            . '$("[name=\'Itempedido[idProduto][]\']").select2();i = i+1;'
            . '$("span[class=\'select2 select2-container select2-container--default select2-container--focus\']")'
            . '.addClass("select2 select2-container select2-container--krajee select2-container--focus")'
            . '.removeClass("select2 select2-container select2-container--default select2-container--focus");'
            . '})');
    ?>

    <?php
    $this->registerJsFile(\Yii::getAlias("@web") . '/js/pedido_form.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    ?>
    <div class="form-group">
        <?php
        
       echo 
        ($model->situacaopedido->titulo != 'Concluído') ?
        Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) :
           ''?>
<?php if($model->situacaopedido->titulo != 'Concluído'){?>
        <input class="btn btn-primary" type='button' id='btnadprodutocompra' value="Adicionar Item Pedido">
<?php } ?>
        <!--   ---------------------------   BEGIN Finalizar Pedido  ---------------------------  -->
        <?php
        Modal::begin([
            'header' => '<h2>Finalizar Pedido</h2>',
            'id' => 'modalfinalizarpedido',
            'toggleButton' => ($model->situacaopedido->titulo != 'Concluído') ?
            ['label' => 'Finalizar Pedido',
                'class' => 'btn btn-warning',
                'disabled' => isset($model->datadevolucao) ? true : false] : false,
        ]);
        ?>
        <div class="row">
            <div class="col-lg-6">
                <?= Html::label("Forma Pagamento", ['class' => 'form-control'])
                ?>
                <div class="input-group">

                    <?=
                    Html::dropDownList("Formapagamento", null, $formasPagamento, ['class' => 'form-control',
                        'id' => 'formapagamento',
                        'prompt'=>'Escolha uma forma de pagamento'])
                    ?>
                    <span class="input-group-btn">
                        <?=
                        Html::Button("Finalizar Pedido", ['class' => 'btn btn-success',
                            'id' => 'btFinalizarPedido'])
                        ?>
                    </span>


                </div>
                <?= Html::label("Valor Total", ['class' => 'form-control'])
                ?>
                <?=
                Html::input('text', null, isset($model->totalPedido)?'R$ '. $model->totalPedido : ''
                        , ['class' => 'form-control',
                    'disabled' => true,])
                 
                ?>
            </div>

        </div>


        <?php
        Modal::end();
        ?>

        <!--   ---------------------------   END Finalizar Pedido  ---------------------------  -->
    </div>


    <?php ActiveForm::end(); ?>

                <div id="mensagem-finalizar-pedido"></div>

</div>



<script type="text/javascript">
    function removeins(id) {
        $('#inputinsumo' + id).empty();
    }


</script>
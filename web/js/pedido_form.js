/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$("input[class='btn btn-danger']:first").hide();


$('#btFinalizarPedido').click(function () {

    var formaPagamento = $('#formapagamento').val();
    var situacaoPedido = $('#pedido-idsituacaoatual');
    var idPedido = $('#idpedido').val();
    console.log("formaPagamento :" + formaPagamento + " / idPedido : " + idPedido);
    if (formaPagamento > 0) {


        $.get('finalizar-pedido', {formaPagamento: formaPagamento,
            idPedido: idPedido
        }, function (data) {

//            var data = $.parseJSON(data);
            console.log(data);
            if (data != 'false') {
                situacaoPedido.val(data);
                $('#mensagem-finalizar-pedido').html("<div class=\"alert alert-success\" role=\"alert\">" +
                        "Pedido finalizado com sucesso.</div>");
                $('#mensagem-finalizar-pedido').show();

                $('#modalfinalizarpedido').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();


            } else {
                $('#mensagem-finalizar-pedido').show();
                $('#mensagem-finalizar-pedido').html("<div class=\"alert alert-danger\" role=\"alert\">" +
                        "Pedido não finalizado com sucesso.</div>");

            }

        });
    } else {
        alert('Escolha a forma de pagamento!');
    }
});


function mudarFoto(element) {

    var idProduto =+element.value;

    var elementoImg = $(element).parent().parent().parent();

    console.log(elementoImg);
    $.get('../pedido/get-foto-produto', {idProduto: idProduto
    }, function (data) {

        var data = $.parseJSON(data);

        if (data != 'false') {
            if(data[1] != ""){
                console.log(data);
                $("div:last img",elementoImg).attr("src",
                    'data:image/jpeg;base64,'+data[1]);
                $("div:last img",elementoImg).attr("alt",
                    data[0]);
            }else{
                $("div:last img",elementoImg).attr("src",
                    "/applanchonete/web/imgs/semfoto.jpg");
                $("div:last img",elementoImg).attr("alt","Sem foto cadastrada");
            }


        } else {


        }

    });
}
var amount = $('#amount').val();
//var amount = "600.00";
pagamento();

exibircobranca();
exibirPagar();
Aguardar();

//Função que desabilita a Mensagem de Aguardar.
function Aguardar () {
	//$('.aguardar').hide();
	document.getElementById('aguardar').style.display = "none";
	
}

//Função que desabilita o botão submit após 1 click, evitando mais de um envio de formulário.
function DesabilitaBotao (valor) {
	document.getElementById('aguardar').style.display = "";
    if (valor) {
        document.getElementById('submeter').style.display = "none";
        document.getElementById('aguardar').style.display = "";
    }
    else {
        document.getElementById('submeter').style.display = "";
        document.getElementById('aguardar').style.display = "none";
    }

}

function pagamento() {
    $('.bankName').hide();
    $('.creditCard').hide();

    //Endereco padrão do projeto
    var endereco = jQuery('.endereco').attr("data-endereco");
    $.ajax({

        //URL completa do local do arquivo responsável em buscar o ID da sessão
        url: endereco + "pagamento.php",
        type: 'POST',
        dataType: 'json',
        success: function (retorno) {

            //ID da sessão retornada pelo PagSeguro
            PagSeguroDirectPayment.setSessionId(retorno.id);
        },
        complete: function (retorno) {
            listarMeiosPag();
        }
    });
}

function listarMeiosPag() {
    PagSeguroDirectPayment.getPaymentMethods({
        amount: amount,
        success: function (retorno) {
            //console.log(retorno);
            //Recuperar as bandeiras do cartão de crédito
            $('.meio-pag').append("<div>Cartão de Crédito</div>");
            $.each(retorno.paymentMethods.CREDIT_CARD.options, function (i, obj) {
                $('.meio-pag').append("<span class='img-band'><img src='https://stc.pagseguro.uol.com.br" + obj.images.SMALL.path + "'></span>");
            });

            //Recuperar as bandeiras do boleto
            $('.meio-pag').append("<div>Boleto</div>");
            $('.meio-pag').append("<span class='img-band'><img src='https://stc.pagseguro.uol.com.br" + retorno.paymentMethods.BOLETO.options.BOLETO.images.SMALL.path + "'><span>");

            //Recuperar as bandeiras do débito online
            $('.meio-pag').append("<div>Débito Online</div>");
            $.each(retorno.paymentMethods.ONLINE_DEBIT.options, function (i, obj) {
                $('.meio-pag').append("<span class='img-band'><img src='https://stc.pagseguro.uol.com.br" + obj.images.SMALL.path + "'></span>");
                $('#bankName').show().append("<option value='" + obj.name + "'>" + obj.displayName + "</option>");
                $('.bankName').hide();
            });
        },
        error: function (retorno) {
            // Callback para chamadas que falharam.
        },
        complete: function (retorno) {
            // Callback para todas chamadas.
            //recupTokemCartao();
        }
    });
}

//Receber os dados do formulário, usando o evento "keyup" para receber sempre que tiver alguma alteração no campo do formulário
$('#numCartao').on('keyup', function () {

    //Receber o número do cartão digitado pelo usuário
    var numCartao = $(this).val();

    //Contar quantos números o usuário digitou
    var qntNumero = numCartao.length;

    //Validar o cartão quando o usuário digitar 6 digitos do cartão
    if (qntNumero == 6) {

        //Instanciar a API do PagSeguro para validar o cartão
        PagSeguroDirectPayment.getBrand({
            cardBin: numCartao,
            success: function (retorno) {
                $('#msg').empty();

                //Enviar para o index a imagem da bandeira
                var imgBand = retorno.brand.name;
                $('.bandeira-cartao').html("<img src='https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/42x20/" + imgBand + ".png'>");
                $('#bandeiraCartao').val(imgBand);
                recupParcelas(imgBand);
            },
            error: function (retorno) {

                //Enviar para o index a mensagem de erro
                $('.bandeira-cartao').empty();
                $('#msg').html("Cartão inválido");
            }
        });
    }
});

//Recuperar a quantidade de parcelas e o valor das parcelas no PagSeguro
function recupParcelas(bandeira) {
    var noIntInstalQuantity = $('#noIntInstalQuantity').val();
    //$('#qntParcelas').html('');
    $('#qntParcelas').html('<option value="">Selecione</option>');
	PagSeguroDirectPayment.getInstallments({
        
        //Valor do produto
        amount: amount,

        //Quantidade de parcelas sem juro        
        maxInstallmentNoInterest: noIntInstalQuantity,

        //Tipo da bandeira
        brand: bandeira,
        success: function (retorno) {
            $.each(retorno.installments, function (ia, obja) {
                $.each(obja, function (ib, objb) {

                    //Converter o preço para o formato real com JavaScript
                    var valorParcela = objb.installmentAmount.toFixed(2).replace(".", ",");

                    //Acrecentar duas casas decimais apos o ponto
                    var valorParcelaDouble = objb.installmentAmount.toFixed(2);
                    //Apresentar quantidade de parcelas e o valor das parcelas para o usuário no campo SELECT
                    $('#qntParcelas').show().append("<option value='" + objb.quantity + "' data-parcelas='" + valorParcelaDouble + "'>" + objb.quantity + " parcelas de R$ " + valorParcela + "</option>");
                });
            });
        },
        error: function (retorno) {
            // callback para chamadas que falharam.
        },
        complete: function (retorno) {
            // Callback para todas chamadas.
        }
    });
}

//Enviar o valor parcela para o formulário
$('#qntParcelas').change(function () {
    $('#valorParcelas').val($('#qntParcelas').find(':selected').attr('data-parcelas'));
});

//Recuperar o token do cartão de crédito
$("#formPagamento").on("submit", function (event) {
    $("#btnComprar").prop('disabled', true);
	document.getElementById('btnComprar').style.display = "none";
	document.getElementById('aguardar').style.display = "";	
	event.preventDefault();
    var paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
    //console.log(paymentMethod);

    if (paymentMethod == 'creditCard') {
        PagSeguroDirectPayment.createCardToken({
            cardNumber: $('#numCartao').val(), // Número do cartão de crédito
            brand: $('#bandeiraCartao').val(), // Bandeira do cartão
            cvv: $('#cvvCartao').val(), // CVV do cartão
            expirationMonth: $('#mesValidade').val(), // Mês da expiração do cartão
            expirationYear: $('#anoValidade').val(), // Ano da expiração do cartão, é necessário os 4 dígitos.
            success: function (retorno) {
                $('#tokenCartao').val(retorno.card.token);

				recupHashCartao();
            },
            error: function (retorno) {
                // Callback para chamadas que falharam.
            },
            complete: function (retorno) {
                // Callback para todas chamadas.                
            }
        });
    } else if (paymentMethod == 'boleto') {
		$('#numCartao').val('0000000000000000');
		$('#bandeiraCartao').val('0');
		$('#cvvCartao').val('0');
		$('#anoValidade').val('0');
		$('#mesValidade').val('0');
		$('#creditCardHolderName').val('0');
		$('#creditCardHolderCPF').val('0');
		$('#creditCardHolderBirthDate').val('0');
		
		$('#billingAddressPostalCode').val('00000000');
		$('#billingAddressStreet').val('nao informado');
		$('#billingAddressNumber').val('nao informado');
		$('#billingAddressComplement').val('nao informado');
		$('#billingAddressDistrict').val('nao informado');
		$('#billingAddressCity').val('nao informado');
		$('#billingAddressState').val('RJ');
		
		recupHashCartao();
    } else if (paymentMethod == 'eft') {
		$('#numCartao').val('0000000000000000');
		$('#bandeiraCartao').val('0');
		$('#cvvCartao').val('0');
		$('#anoValidade').val('0');
		$('#mesValidade').val('0');
		$('#creditCardHolderName').val('0');
		$('#creditCardHolderCPF').val('0');
		$('#creditCardHolderBirthDate').val('0');
		
		$('#billingAddressPostalCode').val('00000000');
		$('#billingAddressStreet').val('nao informado');
		$('#billingAddressNumber').val('nao informado');
		$('#billingAddressComplement').val('nao informado');
		$('#billingAddressDistrict').val('nao informado');
		$('#billingAddressCity').val('nao informado');
		$('#billingAddressState').val('RJ');
		
		recupHashCartao();
    }

});

//Recuperar o hash do cartão
function recupHashCartao() {
    PagSeguroDirectPayment.onSenderHashReady(function (retorno) {
        if (retorno.status == 'error') {
            //console.log(retorno.message);
            return false;
        } else {
            $("#hashCartao").val(retorno.senderHash);
            var dados = $("#formPagamento").serialize();
            //console.log(dados);

            var endereco = jQuery('.endereco').attr("data-endereco");
            //console.log(endereco);
            $.ajax({
                method: "POST",
                url: endereco + "proc_pag.php",
                data: dados,
                dataType: 'json',
                success: function (retorna) {
                    //console.log("Sucesso " + JSON.stringify(retorna));
                    $("#msg").html('<p style="color: green">Transação realizada com sucesso</p>');

					window.location = 'compra_realizada.php?code=' + retorna['dados']['code'] + '&type=' + retorna['dados']['paymentMethod']['type'];
					/*
					if(retorna['dados']['paymentMethod']['type'] == "1"){
						window.location = 'compra_cartao.php?code=' + retorna['dados']['code'] + '&type=' + retorna['dados']['paymentMethod']['type'];
					}
					if(retorna['dados']['paymentMethod']['type'] == "2"){
						window.location = 'compra_boleto.php?code=' + retorna['dados']['code'] + '&type=' + retorna['dados']['paymentMethod']['type'];
					}
					if(retorna['dados']['paymentMethod']['type'] == "3"){
						window.location = 'compra_debito.php?code=' + retorna['dados']['code'] + '&type=' + retorna['dados']['paymentMethod']['type'];
					}
					*/
                },
                error: function (retorna) {
					//console.log("Erro" + JSON.stringify(retorna));
					$("#msg").html('<p style="color: #FF0000">Erro ao realizar a transação</p>')
					window.location = 'meus_pedidos.php';
                }
            });
        }
    });
}

function exibirPagar() {
	$('.comprar').hide();
	$('.boleto').hide();
	$('.creditCard').hide();
	$('.bankName').hide();
}

function tipoPagamento(paymentMethod){
	
	var RecarregaCepDestino = $('#RecarregaCepDestino').val();
	var RecarregaLogradouro = $('#RecarregaLogradouro').val();
	var RecarregaNumero = $('#RecarregaNumero').val();
	var RecarregaComplemento = $('#RecarregaComplemento').val();
	var RecarregaBairro = $('#RecarregaBairro').val();
	var RecarregaCidade = $('#RecarregaCidade').val();
	var RecarregaEstado = $('#RecarregaEstado').val();    
	
    if(paymentMethod == "boleto"){
        $('.comprar').show();
		$('.boleto').show();
		$('.creditCard').hide();
        $('.bankName').hide();
		$('#billingAddressPostalCode').val('00000000');
		$('#billingAddressStreet').val('nao informado');
		$('#billingAddressNumber').val('nao informado');
		$('#billingAddressComplement').val('nao informado');
		$('#billingAddressDistrict').val('nao informado');
		$('#billingAddressCity').val('nao informado');
		$('#billingAddressState').val('RJ');
		$('#numCartao').val('0000000000000000');
		$('#bandeiraCartao').val('0');
		$('#cvvCartao').val('0');
		$('#anoValidade').val('0');
		$('#mesValidade').val('0');
		$('#creditCardHolderName').val('0');
		$('#creditCardHolderCPF').val('0');
		$('#creditCardHolderBirthDate').val('0');
    }
	
    if(paymentMethod == "eft"){
        $('.comprar').show();
		$('.boleto').hide();        
		$('.creditCard').hide();
        $('.bankName').show();
		$('#billingAddressPostalCode').val('00000000');
		$('#billingAddressStreet').val('nao informado');
		$('#billingAddressNumber').val('nao informado');
		$('#billingAddressComplement').val('nao informado');
		$('#billingAddressDistrict').val('nao informado');
		$('#billingAddressCity').val('nao informado');
		$('#billingAddressState').val('RJ');
		$('#numCartao').val('0000000000000000');
		$('#bandeiraCartao').val('0');
		$('#cvvCartao').val('0');
		$('#anoValidade').val('0');
		$('#mesValidade').val('0');
		$('#creditCardHolderName').val('0');
		$('#creditCardHolderCPF').val('0');
		$('#creditCardHolderBirthDate').val('0');		
    }
	
	if(paymentMethod == "creditCard"){
        $('.comprar').show();
		$('.boleto').hide();        
		$('.creditCard').show();
        $('.bankName').hide();
		/*
		$('#billingAddressPostalCode').val('');
		$('#billingAddressStreet').val('');
		$('#billingAddressNumber').val('');
		$('#billingAddressComplement').val('');
		$('#billingAddressDistrict').val('');
		$('#billingAddressCity').val('');
		$('#billingAddressState').val('');
		*/
		$('#billingAddressPostalCode').val(RecarregaCepDestino);
		$('#billingAddressStreet').val(RecarregaLogradouro);
		$('#billingAddressNumber').val(RecarregaNumero);
		$('#billingAddressComplement').val(RecarregaComplemento);
		$('#billingAddressDistrict').val(RecarregaBairro);
		$('#billingAddressCity').val(RecarregaCidade);
		$('#billingAddressState').val(RecarregaEstado);		
		
		$('#numCartao').val('');
		$('#bandeiraCartao').val('');
		$('#cvvCartao').val('');
		$('#anoValidade').val('');
		$('#mesValidade').val('');
		$('#creditCardHolderName').val('');
		$('#creditCardHolderCPF').val('');
		$('#creditCardHolderBirthDate').val('');		
    }	
	
}

function exibircobranca() {	
	$('#numCartao').val('0000000000000000');
	$('#bandeiraCartao').val('0');
	$('#cvvCartao').val('0');
	$('#anoValidade').val('0');
	$('#mesValidade').val('0');
	$('#creditCardHolderName').val('0');
	$('#creditCardHolderCPF').val('0');
	$('#creditCardHolderBirthDate').val('0');	
}

function tipoEndereco(tipoendereco){
	var RecarregaCepDestino = $('#RecarregaCepDestino').val();
	var RecarregaLogradouro = $('#RecarregaLogradouro').val();
	var RecarregaNumero = $('#RecarregaNumero').val();
	var RecarregaComplemento = $('#RecarregaComplemento').val();
	var RecarregaBairro = $('#RecarregaBairro').val();
	var RecarregaCidade = $('#RecarregaCidade').val();
	var RecarregaEstado = $('#RecarregaEstado').val();

	if(tipoendereco == "1"){
		$('.Liga').show();
		$('.Desliga').hide();
		$('.Correios').hide();
		$('.Combinar').hide();
		$('.Retirada').show();
		$('#billingAddressPostalCode').val(RecarregaCepDestino);
		$('#billingAddressStreet').val(RecarregaLogradouro);
		$('#billingAddressNumber').val(RecarregaNumero);
		$('#billingAddressComplement').val(RecarregaComplemento);
		$('#billingAddressDistrict').val(RecarregaBairro);
		$('#billingAddressCity').val(RecarregaCidade);
		$('#billingAddressState').val(RecarregaEstado);			
	}		

	if(tipoendereco == "2"){
		$('.Liga').hide();
		$('.Desliga').show();
		$('.Correios').hide();
		$('.Combinar').show();
		$('.Retirada').hide();
		$('#billingAddressPostalCode').val('');
		$('#billingAddressStreet').val('');
		$('#billingAddressNumber').val('');
		$('#billingAddressComplement').val('');
		$('#billingAddressDistrict').val('');
		$('#billingAddressCity').val('');
		$('#billingAddressState').val('');
	}
	
}

function Procuraendereco() {
	var Dados=$(this).serialize();
	var billingAddressPostalCode=$('#billingAddressPostalCode').val();

	$.ajax({
		url: 'https://viacep.com.br/ws/'+billingAddressPostalCode+'/json/',
		method:'get',
		dataType:'json',
		data: Dados,
		success:function(Dados){
			$('.ResultCep').html('').append('<div>'+Dados.logradouro+','+Dados.bairro+'-'+Dados.localidade+'-'+Dados.uf+'</div>');			
			//$('#billingAddressPostalCode').val(billingAddressPostalCode);
			$('#billingAddressStreet').val(Dados.logradouro);
			$('#billingAddressNumber').val('');
			$('#billingAddressComplement').val('');
			$('#billingAddressDistrict').val(Dados.bairro);
			$('#billingAddressCity').val(Dados.localidade);
			$('#billingAddressState').val(Dados.uf);

		},
		error:function(Dados){
			alert('Cep não encontrado. Tente Novamente');
			$('#billingAddressPostalCode').val('');
		}
	});
}

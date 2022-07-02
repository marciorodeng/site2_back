
exibir();
exibir_confirmar();
Copia();

function exibir(){
	$('.Mostrar').show();
	$('.NMostrar').hide();
}

function exibir_confirmar(){
	$('.Open').show();
	$('.Close').hide();
}

function mostrarSenha(){
	var tipo = document.getElementById("senha");
	if(tipo.type == "password"){
		tipo.type = "text";
		$('.Mostrar').hide();
		$('.NMostrar').show();
	}else{
		tipo.type = "password";
		$('.Mostrar').show();
		$('.NMostrar').hide();
	}
}

function confirmarSenha(){
	var tipo = document.getElementById("confirmar");
	if(tipo.type == "password"){
		tipo.type = "text";
		$('.Open').hide();
		$('.Close').show();
	}else{
		tipo.type = "password";
		$('.Open').show();
		$('.Close').hide();
	}
}

function Copia() {
	$('.Copiar').show();
	$('.Copiado').hide();
	$('.Copiar_Associado').show();
	$('.Copiado_Associado').hide();
	$('.Copiar_Vendedor').show();
	$('.Copiado_Vendedor').hide();
}

/*
document.getElementById("botao").addEventListener("click", function(){
	//alert('Copiando');
	document.getElementById("texto").select();
	document.execCommand('copy');
	$('.Copiar').hide();
	$('.Copiado').show();
});
*/
/*
$('#botao').on('click', copiar);
function copiar(){
	//alert('Copiando');
	document.getElementById("texto").select();
	document.execCommand('copy');
	$('.Copiar').hide();
	$('.Copiado').show();
}
*/
if($('#id_empresa').val()){
	var id_empresa = $('#id_empresa').val();
	//console.log('id_empresa = '+id_empresa);
}else{
	var id_empresa = false;
	//console.log('id_empresa = '+id_empresa);
}
if($('#sistema').val()){
	var sistema = $('#sistema').val();
	//console.log('sistema = '+sistema);
}else{
	var sistema = false;
	//console.log('sistema = '+sistema);
}
if($('#usuario_vend').val()){
	var usuario_vend = $('#usuario_vend').val();
	var nivel_vend = $('#nivel_vend').val();
	//console.log('usuario_vend = '+usuario_vend);
	//console.log('nivel_vend = '+nivel_vend);
}else{
	var usuario_vend = false;
	var nivel_vend = false;
	//console.log('usuario_vend = '+usuario_vend);
	//console.log('nivel_vend = '+nivel_vend);
}

function url_Vendedor() {	
	$('.Copiar_Vendedor').hide();
	$('.Copiado_Vendedor').show();
	var id_vendedor = $('#id_Vendedor').val();
	//console.log('id_vendedor = '+id_vendedor);
	var x = document.URL;
	
	var substr = "?";
	
	var result = x.indexOf(substr) > -1;
	//var result = x.search(substr) > -1;
	
	if(result == true){
		//console.log('existe "?"');
		var link_vendedor = x+'&emp='+id_empresa+'&usuario='+id_vendedor;
	}else{
		//console.log('Não existe "?"');
		var link_vendedor = x+'?&emp='+id_empresa+'&usuario='+id_vendedor;
	}
	
	//console.log('link_vendedor = '+link_vendedor);
	
	document.getElementById("texto_vendedor").innerHTML = link_vendedor;
	link_Vendedor();
}

function link_Vendedor() {
	document.getElementById("texto_vendedor").select();
	document.execCommand('copy');
	$('.Copiar_Vendedor').hide();
	$('.Copiado_Vendedor').show();	
}

function url_Associado() {	
	$('.Copiar_Associado').hide();
	$('.Copiado_Associado').show();
	var id_associado = $('#id_Associado').val();
	//console.log('id_associado = '+id_associado);
	var x = document.URL;
	
	var substr = "?";
	
	var result = x.indexOf(substr) > -1;
	//var result = x.search(substr) > -1;
	
	if(result == true){
		//console.log('existe "?"');
		var link_associado = x+'&emp='+id_empresa+'&associado='+id_associado;
	}else{
		//console.log('Não existe "?"');
		var link_associado = x+'?&emp='+id_empresa+'&associado='+id_associado;
	}
	
	//console.log('link_associado = '+link_associado);
	
	document.getElementById("texto_associado").innerHTML = link_associado;
	link_Associado();
}

function link_Associado() {
	document.getElementById("texto_associado").select();
	document.execCommand('copy');
	$('.Copiar_Associado').hide();
	$('.Copiado_Associado').show();	
}

$('#botao').on('click', function () {
	//alert('Copiando');
	document.getElementById("texto").select();
	document.execCommand('copy');
	$('.Copiar').hide();
	$('.Copiado').show();
});

//função autocomplete Cliente
// função para limpeza dos campos do Cliente
$('#id_Cliente_Auto').on('input', limpaCampos_Cliente);
$("#NomeClienteAuto1").html('<label>Nenhum Cliente Selecionado!</label>');
$('.CliSim').hide();
$('.CliNao').show();
	
// função que busca os nomes do Cliente		
$("#id_Cliente_Auto").autocomplete({

	source: '../../site2_back/pesquisar/Cliente_Autocomplete.php?id_empresa='+ id_empresa + '&usuario_vend='+ usuario_vend + '&nivel_vend=' +nivel_vend,

	select: function(event, ui){
		var pegar = ui.item.value;
		//console.log('pegar = '+pegar);
		var pegarSplit = pegar.split('#');
		var id_Cliente = pegarSplit[0];
		
		//console.log('id cliente Autocomplete = '+id_Cliente);
		
		$.ajax({
			url: '../../site2_back/pesquisar/Cliente.php?id=' + id_Cliente,
			dataType: "json",
			success: function (data) {
				
				var idcliente = data[0]['id'];
				var nomecliente = data[0]['nome'];
				var celularcliente = data[0]['celular'];
				var telefone = data[0]['telefone'];
				var telefone2 = data[0]['telefone2'];
				var telefone3 = data[0]['telefone3'];
				
				$("#NomeClienteAuto1").html('<label>'+idcliente+ ' | ' + nomecliente + ' | Cel: ' + celularcliente + ' | Tel1: ' + telefone + ' | Tel2: ' + telefone2 + ' | Tel3: ' + telefone3 + '</label>');
				$('.CliSim').show();
				$('.CliNao').hide();
				$("#NomeClienteAuto").val(+idcliente+ ' | ' + nomecliente + ' | Cel: ' + celularcliente + ' | Tel1: ' + telefone + ' | Tel2: ' + telefone2 + ' | Tel3: ' + telefone3);
				
			},
			error:function(data){
				$("#NomeClienteAuto1").html('<label>Nenhum Cliente Selecionado!</label>');
				$('.CliSim').hide();
				$('.CliNao').show();
				$("#NomeClienteAuto").val('Nenhum Cliente Selecionado!');
			}
			
		});
		
		$('#idApp_Cliente').val(id_Cliente);
		/*
		clienteDep(id_Cliente);
		clientePet(id_Cliente);
		calculacashback(id_Cliente);
		buscaEnderecoCliente(id_Cliente);
		clienteOT(id_Cliente);
		*/
	}	
	
});

// Função para limpar os campos caso a busca esteja vazia
function limpaCampos_Cliente(){
   var busca = $('#id_Cliente_Auto').val();

   if(busca == ""){
		
		$('#idApp_Cliente').val('');
		/*
		$('#idApp_ClienteDep').val('0');
		$('#idApp_ClienteDep').hide();
		$('#Dep').val('');
		$('#Dep').hide();
		$('#idApp_ClientePet').val('0');
		$('#idApp_ClientePet').hide();
		$('#Pet').val('');
		$('#Pet').hide();
		
		$('#CashBackOrca').val('0,00');
		$('#ValidadeCashBackOrca').val('');
		*/
		$("#NomeClienteAuto1").html('<label>Nenhum Cliente Selecionado!</label>');
		$('.CliSim').hide();
		$('.CliNao').show();
		$("#NomeClienteAuto").val('Nenhum Cliente Selecionado!');
		/*
		$('#Cep').val('');
		$('#Logradouro').val('');
		$('#Numero').val('');
		$('#Complemento').val('');
		$('#Bairro').val('');
		$('#Cidade').val('');
		$('#Estado').val('');
		$('#Referencia').val('');
		*/
   }
}

$('.input-produto').show();
$('.input-promocao').hide();

$('#SetProduto').on('click', function () {
	//alert('Copiando');
	$('.input-produto').show();
	$('.input-promocao').hide();
	$(".input_fields_produtos").empty();
	$('#Produto').val('');
	$(".input_fields_promocao").empty();
	$('#Promocao').val('');	
});

$('#SetPromocao').on('click', function () {
	//alert('Copiando');
	$('.input-produto').hide();
	$('.input-promocao').show();
	$(".input_fields_produtos").empty();
	$('#Produto').val('');
	$(".input_fields_promocao").empty();
	$('#Promocao').val('');	
});

// função que LIMPA busca de Produto da empresa
function limpaBuscaProduto(){
	$(".input_fields_produtos").empty();
	$('#Produto').val('');
}

// função que LIMPA busca de Promocao da empresa
function limpaBuscaPromocao(){
	$(".input_fields_promocao").empty();
	$('#Promocao').val('');
}

// função que busca Produtos da empresa
$('#Produto').on('keyup', function () {
	//alert('produto');
	var produto = $('#Produto').val();
	//console.log('id_empresa = '+id_empresa);
	//console.log('produto = '+produto);
	$.ajax({
		url: '../../site2_back/pesquisar/Produto.php?id_empresa='+id_empresa+'&produto='+produto,
		dataType: "json",
		success: function (data) {
			//console.log(data);
			//console.log(data.length);

			$(".input_fields_produtos").empty();
            // executo este laço para acessar os itens do objeto javaScript
            for (i = 0; i < data.length; i++) {
					
				data[i].ver 		= 'href="produto.php?id='+data[i].id_valor+'"';
				//console.log( data[i].contarestoque +' - '+ data[i].estoque);	
				if(data[i].contarestoque == "S"){
					data[i].contar = "S";
					if(data[i].estoque > 0){
						data[i].liberar = 'href="meu_carrinho.php?carrinho=produto&id='+data[i].id_valor+'"';
						data[i].carrinho = "carrinho_inserir.png";
						data[i].texto = "";
					}else{
						data[i].liberar = '';
						data[i].carrinho = "carrinho_indisp.png";
						data[i].texto = " | indisp. no momento";
					}
				}else{
					data[i].contar = "N";
					data[i].liberar = 'href="meu_carrinho.php?carrinho=produto&id='+data[i].id_valor+'"';
					data[i].carrinho = "carrinho_inserir.png";
					data[i].texto = "";
				}
				
				$(".input_fields_produtos").append('\
					<div class="form-group">\
						<div class="row">\
							<div class="container-2">\
								<div class="col-xs-4 col-sm-2 col-md-2 col-lg-2">\
									<a '+data[i].ver+'>\
										<img class="team-img img-responsive" src="'+id_empresa+'/produtos/miniatura/'+data[i].arquivo+'" alt="" width="80" >\
									</a>\
								</div>\
								<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 ">\
									<div class="row">\
										<span class="card-title" style="color: #000000">\
											'+data[i].nomeprod+'\
										</span>\
									</div>\
									<div class="row">\
										<span class="card-title" style="color: #000000">\
											'+data[i].qtdinc+' Unid | R$ '+data[i].valor+'\
										</span>\
									</div>\
									<div class="row">\
										<span class="card-title busca-fonte3" style="color: #000000">\
											'+data[i].codprod+'\
										</span>\
										<span class="card-title busca-fonte3" style="color: #FF0000">\
											'+' | ' +data[i].codbarra+'\
										</span>\
									</div>\
								</div>\
								<div class="col-xs-4 col-sm-2 col-md-2 col-lg-2">\
									<a '+data[i].liberar+'>\
										<img class="team-img img-responsive" src="../sistema/arquivos/imagens/'+data[i].carrinho+'" alt="" width="80" >\
									</a>\
								</div>\
							</div>\
						</div>\
					</div>\
					<hr>'
				);						

            }//fim do laço		

		},
		error:function(data){
			//console.log('erro');
			$(".input_fields_produtos").empty();
		}
	});	
});

// função que busca Promocoes da empresa
$('#Promocao').on('keyup', function () {
	//alert('promocao');
	var promocao = $('#Promocao').val();
	//console.log('id_empresa = '+id_empresa);
	//console.log('promocao = '+promocao);
	
	$.ajax({
		url: '../../site2_back/pesquisar/Promocao.php?id_empresa='+id_empresa+'&promocao='+promocao,
		dataType: "json",
		success: function (data) {
			//console.log(data);
			//console.log(data.length);
			$(".input_fields_promocao").empty();
            // executo este laço para acessar os itens do objeto javaScript
            for (i = 0; i < data.length; i++) {
	
				//console.log( data[i].id_promocao +' - '+ data[i].promocao);
				data[i].liberar 	= 'href="meu_carrinho.php?carrinho=promocao&id='+data[i].id_promocao+'"';	
				data[i].ver 		= 'href="produtospromocao.php?promocao='+data[i].id_promocao+'"';
				data[i].carrinho 	= "carrinho_inserir.png";
				/*
				if(data[i].contarestoque == "S"){
					data[i].contar = "S";
					if(data[i].estoque > 0){
						data[i].liberar = 'href="meu_carrinho.php?carrinho=promocao&id='+data[i].id_promocao+'"';
						data[i].texto = "";
					}else{
						data[i].liberar = '';
						data[i].texto = " | indisp. no momento";
					}
				}else{
					data[i].contar = "N";
					data[i].liberar = 'href="meu_carrinho.php?carrinho=promocao&id='+data[i].id_promocao+'"';
					data[i].texto = "";
				}
				*/
				$(".input_fields_promocao").append('\
					<div class="form-group">\
						<div class="row">\
							<div class="container-2">\
								<div class="col-xs-4 col-sm-2 col-md-2 col-lg-2">\
									<a '+data[i].ver+'>\
										<img class="team-img img-responsive" src="'+id_empresa+'/promocao/miniatura/'+data[i].arquivo+'" alt="" width="80" >\
									</a>\
								</div>\
								<div class="col-xs-8 col-sm-10 col-md-10 col-lg-10">\
									<div class="row">\
										<span class="card-title" style="color: #000000">\
											'+data[i].promocao+'\
										</span>\
									</div>\
									<div class="row">\
										<span class="card-title" style="color: #000000">\
											'+data[i].descricao+'\
										</span>\
									</div>\
									<div class="row">\
										<span class="card-title" style="color: #000000">\
											'+data[i].total+'\
										</span>\
									</div>\
								</div>\
								<div class="col-xs-4 col-sm-2 col-md-2 col-lg-2">\
									<a '+data[i].liberar+'>\
										<img class="team-img img-responsive" src="../sistema/arquivos/imagens/'+data[i].carrinho+'" alt="" width="80" >\
									</a>\
								</div>\
							</div>\
						</div>\
					</div>\
					<hr>'
				);				
				
            }//fim do laço	
		},
		error:function(data){
			//console.log('erro');
			//console.log(data);
			$(".input_fields_promocao").empty();
		}
	});	
	
});


$(document).ready(function () {

    $(".Date").mask("99/99/9999");
	$(".Cnpj").mask("99.999.999/9999-99");
    $(".Time").mask("99:99");
    $(".Cpf").mask("99999999999");
	$(".senderCPF").mask("999.999.999-99");
    $(".Cep").mask("99999999");
	$(".Rg").mask("999999999");
    $(".TituloEleitor").mask("9999.9999.9999");
    $(".Valor").mask("#.##0,00", {reverse: true});
    $(".ValorPeso").mask("#.##0,000", {reverse: true});
	$(".Peso").mask("#.##0,000", {reverse: true});
    $('.Numero').mask('0#');
	$(".DDD").mask("99");
    $(".senderCelular").mask("999999999");
    $(".Celular").mask("99999999999");
    $(".CelularVariavel").on("blur", function () {
        var last = $(this).val().substr($(this).val().indexOf("-") + 1);

        if (last.length == 3) {
            var move = $(this).val().substr($(this).val().indexOf("-") - 1, 1);
            var lastfour = move + last;

            var first = $(this).val().substr(0, 9);

            $(this).val(first + '-' + lastfour);
        }
    });
	
});
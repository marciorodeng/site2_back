	
	exibirentrega();

	/*Atualiza o somatório do Qtd Devolvido no Orcatrata*/
	function calculaCarrinhoSubtotal(item) {
		
		var valor = $('#Valor'+item).html();
		var qtd = $('#Qtd').val();
		
				var Subtotal 	= parseFloat(valor) * parseFloat(qtd);
				
				$('#Subtotal').html(Subtotal);
				
		console.log('teste' + valor + ' ' + qtd);

	}

	function calculaSubtotal(valor, campo, num) {
				
		var valor = $('#Valor'+num).html();
		
		var qtd = $('#Qtd'+num).val();
				
		var Subtotal 	= parseFloat(valor) * parseFloat(qtd);
		
		$('#Subtotal'+num).html(Subtotal);
		
		console.log('teste' + valor + ' ' + qtd);
		
	}	
	
	function calculaSubtotal_Original(valor, campo, num, tipo, tabela) {
		
		if (tipo == 'VP') {
			//variável valor recebe o valor do produto selecionado
			var data = $("#Qtd"+tabela+num).val();

			//o subtotal é calculado como o produto da quantidade pelo seu valor
			var subtotal = (valor.replace(".","").replace(",",".") * data);
			//alert('>>>'+valor+' :: '+campo+' :: '+num+' :: '+tipo+'<<<');
		} else if (tipo == 'QTD') {
			//variável valor recebe o valor do produto selecionado
			var data = $("#idTab_"+tabela+num).val();

			//o subtotal é calculado como o produto da quantidade pelo seu valor
			var subtotal = (valor * data.replace(".","").replace(",","."));
		} else {
			//o subtotal é calculado como o produto da quantidade pelo seu valor
			var subtotal = (valor.replace(".","").replace(",",".") * campo.replace(".","").replace(",","."));
		}

		subtotal = mascaraValorReal(subtotal);
		//o subtotal é escrito no seu campo no formulário
		$('#Subtotal'+tabela+num).val(subtotal);

		//para cada vez que o subtotal for calculado o orçamento e o total restante
		//também serão atualizados
		calculaOrcamento();

	}

	function exibirentrega() {
		$('.Liga').show();
		$('.Desliga').hide();
		$('.Correios').hide();
		$('.Combinar').hide();
		$('.Retirada').show();
		$('.Calcular').show();
		$('.Recalcular').hide();		
	}
	
	function tipoFrete(tipofrete){
		var RecarregaCepDestino = $('#RecarregaCepDestino').val();
		var RecarregaLogradouro = $('#RecarregaLogradouro').val();
		var RecarregaNumero = $('#RecarregaNumero').val();
		var RecarregaComplemento = $('#RecarregaComplemento').val();
		var RecarregaBairro = $('#RecarregaBairro').val();
		var RecarregaCidade = $('#RecarregaCidade').val();
		var RecarregaEstado = $('#RecarregaEstado').val();

		if(tipofrete == "1"){
			$('.Liga').show();
			$('.Desliga').hide();
			$('.Correios').hide();
			$('.Combinar').hide();
			$('.Retirada').show();
			$('#Cep').val('00000000');
			$('#CepDestino').val(RecarregaCepDestino);
			$('#Logradouro').val(RecarregaLogradouro);
			$('#Numero').val(RecarregaNumero);
			$('#Complemento').val(RecarregaComplemento);
			$('#Bairro').val(RecarregaBairro);
			$('#Cidade').val(RecarregaCidade);
			$('#Estado').val(RecarregaEstado);
			$('#valorfrete').val('0.00');
			$('#prazoentrega').val('0');
			
		}		

		if(tipofrete == "2"){
			$('.Liga').hide();
			$('.Desliga').show();
			$('.Correios').hide();
			$('.Combinar').show();
			$('.Retirada').hide();
			$('#Cep').val('00000000');
			$('#CepDestino').val('');
			$('#Logradouro').val('');
			$('#Numero').val('');
			$('#Complemento').val('');
			$('#Bairro').val('');
			$('#Cidade').val('');
			$('#Estado').val('');
			$('#valorfrete').val('0.00');
			$('#prazoentrega').val('0');			
		}
		
		if(tipofrete == "3"){
			$('.Liga').hide();
			$('.Desliga').show();
			$('.Correios').show();
			$('.Combinar').hide();
			$('.Retirada').hide();
			$('.Calcular').show();
			$('.Recalcular').hide();			
			$('.finalizar').hide();
			$('#Cep').val('');
			$('#CepDestino').val('');
			$('#Logradouro').val('');
			$('#Numero').val('');
			$('#Complemento').val('');
			$('#Bairro').val('');
			$('#Cidade').val('');
			$('#Estado').val('');
			$('#valorfrete').val('');
			$('#prazoentrega').val('');
			$('#valor_total').val('');
			$('#msg').html('');
		}		

	}	

	//Busca do CEP

	function Procuraendereco() {
		var Dados=$(this).serialize();
		var CepDestino=$('#CepDestino').val();

		$.ajax({
			url: 'https://viacep.com.br/ws/'+CepDestino+'/json/',
			method:'get',
			dataType:'json',
			data: Dados,
			success:function(Dados){
				$('.ResultCep').html('').append('<div>'+Dados.logradouro+','+Dados.bairro+'-'+Dados.localidade+'-'+Dados.uf+'</div>');			
				//$('#CepDestino').val(CepDestino);
				$('#Logradouro').val(Dados.logradouro);
				$('#Numero').val('');
				$('#Complemento').val('');
				$('#Bairro').val(Dados.bairro);
				$('#Cidade').val(Dados.localidade);
				$('#Estado').val(Dados.uf);

			},
			error:function(Dados){
				alert('Cep não encontrado. Tente Novamente');
				$('#CepDestino').val('');
			}
		});
	}	

	function LoadFrete() {
		//alert('botão funcionando!!');
		
		var CepDestino = $('#CepDestino').val();
		var CepOrigem = $('#CepOrigem').val();
		var Peso = $('#Peso').val();
		var Formato = $('#Formato').val();
		var Comprimento = $('#Comprimento').val();
		var Altura = $('#Altura').val();
		var Largura = $('#Largura').val();
		var MaoPropria = $('#MaoPropria').val();
		var ValorDeclarado = $('#ValorDeclarado').val();
		var AvisoRecebimento = $('#AvisoRecebimento').val();
		var Codigo = $('#Codigo').val();
		var Diametro = $('#Diametro').val();

		$.ajax({
			url: '../site2_back/application/models/calcula-frete_model.php',
			type:'POST',
			dataType:'html',
			cache: false,
			data: {CepDestino: CepDestino, 
					CepOrigem: CepOrigem, 
					Peso: Peso, 
					Formato: Formato,
					Comprimento: Comprimento,
					Altura: Altura,
					Largura: Largura,
					MaoPropria: MaoPropria,
					ValorDeclarado: ValorDeclarado,
					AvisoRecebimento: AvisoRecebimento,
					Codigo: Codigo,
					Diametro: Diametro},
			success:function(data){
				/*
					console.log(data);
				*/
				$('.ResultadoPrecoPrazo').html(data);
				
				var prazo_entrega = $('#prazo_entrega').val();
				$('#prazoentrega').val(prazo_entrega);
				
				var valor_frete = $('#valor_frete').val();				
				valor_frete 	= valor_frete.replace(',','.');								
				
				var valor_prod = $('#valor_prod').val();
				valor_prod 	= valor_prod.replace(',','.');				
				
				var total 	= parseFloat(valor_frete) + parseFloat(valor_prod);
				$('#valor_total').val(total);				
				
				$('#valorfrete').val(valor_frete);
				
				if(valor_frete > "0.00"){
					$('#msg').html('<p style="color: green">Cálculo realizada com Sucesso!!</p>');
					$('.finalizar').show();
				}else{
					$('#msg').html('<p style="color: #FF0000">Erro ao realizar o Cálculo!!</p>');
					$('.finalizar').hide();
					window.location = 'meu_carrinho.php';
				}
				
				$('#Cep').val(CepDestino);
				

			}, beforeSend: function(){
			
			}, error: function(jqXHR, textStatus, errorThrown){
				console.log('Erro');
				$('#msg').html('<p style="color: #FF0000">Erro ao realizar o Cálculo!!</p>');
				window.location = 'meu_carrinho.php';				
			}
		});
		
	}
	
	function Calcular() {
		$('.Calcular').hide();
		$('.Recalcular').show();
	}
	
	function Recalcular() {
		$('.Calcular').show();
		$('.Recalcular').hide();
		$('.finalizar').hide();
		$('#CepDestino').val('');
		$('#Logradouro').val('');
		$('#Numero').val('');
		$('#Complemento').val('');
		$('#Bairro').val('');
		$('#Cidade').val('');
		$('#Estado').val('');		
		$('#valorfrete').val('');
		$('#prazoentrega').val('');
		$('#valor_total').val('');
		$('#msg').html('');
	}
	
	function Limpar() {
		$('#msg').html('');
	}	
	
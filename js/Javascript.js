	
	exibirentrega();
	Aguardar();

//Função que desabilita a Mensagem de Aguardar.
function Aguardar () {
	//$('.aguardar').hide();
	document.getElementById('aguardar').style.display = "none";
	
}	
	
//Função que desabilita o botão submit após 1 click, evitando mais de um envio de formulário.
function DesabilitaBotao (valor) {
	//$('.aguardar').show();
    document.getElementById('aguardar').style.display = "";
	if (valor) {
        document.getElementById('submeter').style.display = "none";
		document.getElementById('submeter2').style.display = "none";
        //document.getElementById('aguardar').style.display = "";
    }
    else {
        document.getElementById('submeter').style.display = "";
		document.getElementById('submeter2').style.display = "";
        //document.getElementById('aguardar').style.display = "none";
    }
}

$("#FormularioEntrega").on("submit", function (event) {
    $("#btnComprar").prop('disabled', true);
	document.getElementById('btnComprar').style.display = "none";
	document.getElementById('aguardar').style.display = "";
});

	function calculaSubtotal(valor, campo, item, num) {
		
		var estoque = $('#Estoque'+item).html();
		
		var valor = $('#Valor'+item).html();
		//var valor = $('#Valor'+num).html();
		
		var qtd = $('#Qtd'+item).val();
		//var qtd = $('#Qtd'+num).val();
		
		var estoque_edit = estoque.replace(".","").replace(",",".");
		var qtd_edit = qtd.replace(".","").replace(",",".");
		/*
		if(qtd_edit > estoque_edit){
			$('#msg'+item).html('<p style="color: #FF0000">Quantidade superior ao estoque!!</p>');
			//$('.finalizar').show();
		}else{
			$('#msg').html('<p style="color: #FF0000">Erro ao realizar o Cálculo!!</p>');
			//$('.finalizar').hide();
		}		
		*/
		//var Subtotal 	= parseFloat(valor) * parseFloat(qtd);
		var Subtotal = (valor.replace(".","").replace(",",".") * qtd.replace(".","").replace(",","."));
		
		var valorsubtotal = Subtotal.toFixed(2).replace(".", ",");
		
		$('#Subtotal'+item).html(valorsubtotal);
		//$('#Subtotal'+num).html(valorsubtotal);
		
		//var pc = $('#PCount').html();
		//var pc = parseFloat($('#PCount').html().replace(".","").replace(",","."));
		//console.log('teste' + ' '  + item + ' '  + num + ' '  + qtd + ' ' + valor + ' ' + Subtotal+ ' ' + estoque);
		calculaOrcamento();
	}
	
	function calculaOrcamento() {

    //captura o número incrementador do formulário, que controla quantos campos
    //foram acrescidos tanto para serviços quanto para produtos
    //var sc = parseFloat($('#SCount').val().replace(".","").replace(",","."));
    var pc = parseFloat($('#PCount').html().replace(".","").replace(",","."));
    //define o subtotal inicial em 0.00
    var total = 0.00;
/*
    //variável incrementadora
    var i = 0;
    //percorre todos os campos de serviço, somando seus valores
    while (i <= sc) {

        //soma os valores apenas dos campos que existirem, o que forem apagados
        //ou removidos são ignorados
        if ($('#SubtotalServico'+i).val())
            //subtotal += parseFloat($('#idTab_Servico'+i).val().replace(".","").replace(",","."));
            subtotal -= parseFloat($('#SubtotalServico'+i).val().replace(".","").replace(",","."));

        //incrementa a variável i
        i++;
    }
*/
    //faz o mesmo que o laço anterior mas agora para produtos
    var i = 1;
    while (i <= pc) {

        if ($('#Subtotal'+i).html())
            total += parseFloat($('#Subtotal'+i).html().replace(".","").replace(",","."));

        i++;
    }

    //calcula o subtotal, configurando para duas casas decimais e trocando o
    //ponto para o vírgula como separador de casas decimais
    //subtotal = mascaraValorReal(subtotal);
	var valortotal = total.toFixed(2).replace(".", ",");
    //escreve o subtotal no campo do formulário
    $('#ValorTotal').html(valortotal);
    //calculaResta($("#ValorEntradaOrca").val());
	//console.log('ValorTotal' +  ' '  + pc + ' '  + total + ' '  + valortotal);
}	

	function exibirentrega() {
		//$('.Liga').show();
		$('.Liga').hide();
		$('.Desliga').hide();
		$('.Correios').hide();
		$('.Combinar').hide();
		$('.Retirada').hide();
		$('.OnLine').hide();
		$('.NaEntrega').hide();
		$('.NaLoja').hide();
		$('.Calcular').show();
		$('.Recalcular').hide();
		$('.finalizar').hide();
		$('.finalizar2').hide();
		$('.FormaPag').hide();
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
			$('.finalizar').show();			
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
			$('.finalizar').show();			
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
			$('.finalizar').show();
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
	
	function localPagamento(localpagamento){
		var RecarregaCepDestino = $('#RecarregaCepDestino').val();
		var RecarregaLogradouro = $('#RecarregaLogradouro').val();
		var RecarregaNumero = $('#RecarregaNumero').val();
		var RecarregaComplemento = $('#RecarregaComplemento').val();
		var RecarregaBairro = $('#RecarregaBairro').val();
		var RecarregaCidade = $('#RecarregaCidade').val();
		var RecarregaEstado = $('#RecarregaEstado').val();
		
		if(localpagamento == "V"){
			//$('.Liga').show();
			//$('.Desliga').hide();
			$('.OnLine').hide();
			$('.NaEntrega').hide();
			$('.NaLoja').show();
			$('.finalizar2').show();
			$('.FormaPag').show();
			$('.DEPOSITO').hide();
			$('.BOLETO').hide();
			$('.CHEQUE').hide();
			$('.OUTROS').hide();
		}		

		if(localpagamento == "P"){
			//$('.Liga').hide();
			//$('.Desliga').show();
			$('.OnLine').hide();
			$('.NaEntrega').show();
			$('.NaLoja').hide();
			$('.finalizar2').show();
			$('.FormaPag').show();
			$('.DEPOSITO').hide();
			$('.BOLETO').hide();
			$('.CHEQUE').hide();
			$('.OUTROS').hide();
		}
		
		if(localpagamento == "O"){
			//$('.Liga').hide();
			//$('.Desliga').show();
			$('.OnLine').show();
			$('.NaEntrega').hide();
			$('.NaLoja').hide();			
			$('.finalizar2').show();
			$('.FormaPag').show();
			$('.DEPOSITO').hide();
			$('.BOLETO').hide();
			$('.CHEQUE').hide();
			$('.OUTROS').hide();
			//$('#msg').html('');
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
				
					//console.log(data);
					
				$('.ResultadoPrecoPrazo').html(data);
				
				var prazo_entrega = $('#prazo_entrega').val();
				$('#prazoentrega').val(prazo_entrega);
				
				var d = new Date();
				var data_entrega    = new Date(d.getTime() + (prazo_entrega * 24 * 60 * 60 * 1000));
				
				var mes = (data_entrega.getMonth() + 1);
				if(mes < 10){
					var novo_mes = "0" + mes;
				}else{
					var novo_mes = mes;
				}
				
				var dia = (data_entrega.getDate());
				if(dia < 10){
					var novo_dia = "0" + dia;
				}else{
					var novo_dia = dia;
				}
				
				var data_aparente = novo_dia + "/" + novo_mes + "/" + data_entrega.getFullYear();
				$('#dataaparente').val(data_aparente);
				
				var dia_entrega = data_entrega.getFullYear() + "-" + novo_mes + "-" + novo_dia;
				$('#dataentrega').val(dia_entrega);
				
				var valor_frete = $('#valor_frete').val();				
				$('#valorfreteaparente').val(valor_frete);
				valor_frete 	= valor_frete.replace(',','.');								
				
				var valor_prod = $('#valor_prod').val();
				valor_prod 	= valor_prod.replace(',','.');				
				
				var total 	= parseFloat(valor_frete) + parseFloat(valor_prod);
				$('#valor_total').val(total);				
				var totalaparente	= total.toFixed(2);
				totalaparente = totalaparente.replace('.',',');
				$('#valor_total_aparente').val(totalaparente);
				$('#valorfrete').val(valor_frete);
				
				if(valor_frete > "0.00"){
					$('#msg').html('<p style="color: green">Cálculo realizada com Sucesso!!</p>');
					$('.finalizar').show();
				}else{
					$('#msg').html('<p style="color: #FF0000">Erro ao realizar o Cálculo!!</p>');
					$('.finalizar').hide();
					window.location = 'entrega.php';
				}
				
				$('#Cep').val(CepDestino);
				

			}, beforeSend: function(){
			
			}, error: function(jqXHR, textStatus, errorThrown){
				console.log('Erro');
				$('#msg').html('<p style="color: #FF0000">Erro ao realizar o Cálculo!!</p>');
				window.location = 'entrega.php';				
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
	
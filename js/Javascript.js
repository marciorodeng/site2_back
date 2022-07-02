	
	exibirentrega();
	Aguardar();

	var date = new Date();	
	var data_hoje = new Date(date.getFullYear(), date.getMonth(), date.getDate());
	$('.UsarCupom').hide();
	$('.UsarCashBack').hide();
		
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
		$('#Cupom').mask("99999999");
		//$('#Cupom').mask('00000#');
		$('.Numero2').mask("99999999");
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
	
	if($('#id_empresa').val()){
		var id_empresa = $('#id_empresa').val();
	}

	function mascaraValorReal(value) {

		var r;

		r = value.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
		r = r.replace(/[,.]/g, function (m) {
			// m is the match found in the string
			// If `,` is matched return `.`, if `.` matched return `,`
			return m === ',' ? '.' : ',';
		});

		return r;

	}

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
		console.log('ValorTotal' +  ' '  + pc + ' '  + total + ' '  + valortotal);
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
		$('.LocalFormaPag').hide();
		$('.ExibirCashBack').hide();
	}
	
	function tipoFrete(tipofrete){
		
		$('#Hidden_TipoFrete').val(tipofrete);
		
		$('.LocalFormaPag').show();
		var valortotalorca 	= $('#ValorTotal').val();
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
			$('.locpagloja').show();
			$('.locpagcasa').hide();
			$('.locpagonline').show();			
			$('#Cep').val('00000000');
			$('#CepDestino').val(RecarregaCepDestino);
			$('#Logradouro').val(RecarregaLogradouro);
			$('#Numero').val(RecarregaNumero);
			$('#Complemento').val(RecarregaComplemento);
			$('#Bairro').val(RecarregaBairro);
			$('#Cidade').val(RecarregaCidade);
			$('#Estado').val(RecarregaEstado);
			$('#valorfrete').val('0.00');
			$('#valorfreteaparente').val('0,00');
			$('#PrazoCorreios').val('0');
			$('#prazoentrega').val($('#PrazoPrdServ').val());
			$('#valor_total').val(valortotalorca);
			$('#NaLoja').prop('checked', true);
			$('#NaEntrega').prop('checked', false);
			$('#OnLine').prop('checked', false);
			$('#Hidden_tipofrete').val('1');
			$('#Hidden_localpagamento').val('V');
			localPagamento('V');
			calculaDataEntrega();
			$('#dataaparente').val($('#DataEntrega2').val());
			//usarcashback();
			cupom();
		}else if(tipofrete == "2"){
			$('.Liga').hide();
			$('.Desliga').show();
			$('.Correios').hide();
			$('.Combinar').show();
			$('.Retirada').hide();
			$('.finalizar').show();
			$('.locpagloja').hide();
			$('.locpagcasa').show();
			$('.locpagonline').show();			
			$('#Cep').val('00000000');
			$('#CepDestino').val('');
			$('#Logradouro').val('');
			$('#Numero').val('');
			$('#Complemento').val('');
			$('#Bairro').val('');
			$('#Cidade').val('');
			$('#Estado').val('');
			$('#valorfrete').val('0.00');
			$('#valorfreteaparente').val('0,00');
			$('#PrazoCorreios').val('0');
			$('#prazoentrega').val($('#PrazoPrdServ').val());
			$('#valor_total').val(valortotalorca);
			$('#NaLoja').prop('checked', false);
			$('#NaEntrega').prop('checked', true);
			$('#OnLine').prop('checked', false);
			$('#Hidden_tipofrete').val('2');
			$('#Hidden_localpagamento').val('P');
			localPagamento('P');
			calculaDataEntrega();
			$('#dataaparente').val($('#DataEntrega2').val());			
			//usarcashback();
			cupom();
		} else if(tipofrete == "3"){
			$('.Liga').hide();
			$('.Desliga').show();
			$('.Correios').show();
			$('.Combinar').hide();
			$('.Retirada').hide();
			$('.Calcular').show();
			$('.Recalcular').hide();			
			$('.finalizar').show();
			$('.locpagloja').hide();
			$('.locpagcasa').hide();
			$('.locpagonline').show();
			$('#Cep').val('');
			$('#CepDestino').val('');
			$('#Logradouro').val('');
			$('#Numero').val('');
			$('#Complemento').val('');
			$('#Bairro').val('');
			$('#Cidade').val('');
			$('#Estado').val('');
			$('#valorfrete').val('0.00');
			$('#valorfreteaparente').val('0,00');
			$('#PrazoCorreios').val('0');
			$('#prazoentrega').val($('#PrazoPrdServ').val());
			$('#valor_total').val(valortotalorca);
			$('#msg').html('');
			$('#NaLoja').prop('checked', false);
			$('#NaEntrega').prop('checked', false);
			$('#OnLine').prop('checked', true);
			$('#Hidden_tipofrete').val('3');
			$('#Hidden_localpagamento').val('O');
			localPagamento('O');
			calculaDataEntrega();
			$('#dataaparente').val($('#DataEntrega2').val());
			//usarcashback();
			LoadFrete();
			//cupom();
		}		

	}
	
	function localPagamento(localpagamento){
		
		var Hidden_UsarCupom	= $('#Hidden_UsarCupom').val();
		var Hidden_UsarCashBack	= $('#Hidden_UsarCashBack').val();
		var Hidden_Ativo_Pagseguro	= $('#Hidden_Ativo_Pagseguro').val();
		var RecarregaCepDestino = $('#RecarregaCepDestino').val();
		var RecarregaLogradouro = $('#RecarregaLogradouro').val();
		var RecarregaNumero = $('#RecarregaNumero').val();
		var RecarregaComplemento = $('#RecarregaComplemento').val();
		var RecarregaBairro = $('#RecarregaBairro').val();
		var RecarregaCidade = $('#RecarregaCidade').val();
		var RecarregaEstado = $('#RecarregaEstado').val();
		//Na Loja
		if(localpagamento == "V"){
			$('#Hidden_localpagamento').val('V');
			//$('.Liga').show();
			//$('.Desliga').hide();
			$('.OnLine').hide();
			$('.NaEntrega').hide();
			$('.NaLoja').show();
			$('.finalizar2').show();
			$('.FormaPag').show();
			$('.CARTAO').show();
			$('.DEBITO').show();
			$('.DINHEIRO').show().prop('selected', true);
			$('.DEPOSITO').show();
			$('.BOLETODALOJA').hide();
			$('.BOLETOPAGSEGURO').hide();
			$('.CHEQUE').hide();
			$('.OUTROS').hide();
		}else if(localpagamento == "P"){
			$('#Hidden_localpagamento').val('P');
			//$('.Liga').hide();
			//$('.Desliga').show();
			$('.OnLine').hide();
			$('.NaEntrega').show();
			$('.NaLoja').hide();
			$('.finalizar2').show();
			$('.FormaPag').show();
			$('.CARTAO').show();
			$('.DEBITO').show();
			$('.DINHEIRO').show().prop('selected', true);
			$('.DEPOSITO').show();
			$('.BOLETODALOJA').hide();
			$('.BOLETOPAGSEGURO').hide();
			$('.CHEQUE').hide();
			$('.OUTROS').hide();
		}else if(localpagamento == "O"){
			$('#Hidden_localpagamento').val('O');
			//$('.Liga').hide();
			//$('.Desliga').show();
			$('.OnLine').show();
			$('.NaEntrega').hide();
			$('.NaLoja').hide();			
			$('.finalizar2').show();
			$('.FormaPag').show();
			$('.DINHEIRO').hide();
			$('.BOLETODALOJA').show();
			$('.CHEQUE').hide();
			$('.OUTROS').hide();
			$('.DEPOSITO').show().prop('selected', true);
			if(Hidden_UsarCashBack == "S"){
				$('.UsarCashBack').show();
				$('.CARTAO').hide();
				$('.DEBITO').hide();
				$('.BOLETOPAGSEGURO').hide();
			}else{
				$('.UsarCashBack').hide();
				if(Hidden_UsarCupom == "S"){
					$('.UsarCupom').show();
					$('.CARTAO').hide();
					$('.DEBITO').hide();
					$('.BOLETOPAGSEGURO').hide();			
				}else{
					$('.UsarCupom').hide();
					if(Hidden_Ativo_Pagseguro == "S"){	
						$('.CARTAO').show();
						$('.DEBITO').show();
						$('.BOLETOPAGSEGURO').show();
					}else{	
						$('.CARTAO').hide();
						$('.DEBITO').hide();
						$('.BOLETOPAGSEGURO').hide();
					}
				}
			}
		}
	}	

	function calculaDataEntrega() {
		//alert('calculaDataEntrega!!');
		var prazo_prdperv = $('#PrazoPrdServ').val();
		var prazo_entrega = prazo_prdperv;

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
		
		var data_loja = data_entrega.getFullYear() + "-" + novo_mes + "-" + novo_dia;
		$('#DataEntrega1').val(data_loja);		
		
		var data_loja_aparente = novo_dia + "/" + novo_mes + "/" + data_entrega.getFullYear();
		$('#DataEntrega2').val(data_loja_aparente);

	}
	
	//Busca do CEP
	function Procuraendereco() {
		//alert('Procuraendereco!!');
		var Hidden_TipoFrete = $('#Hidden_TipoFrete').val();
		
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
				if(Hidden_TipoFrete == 3){
					LoadFrete();
				}else{
					cupom();
				}
			},
			error:function(Dados){
				alert('Cep não encontrado. Confira o Cep digitado e Tente Novamente');
				$('#CepDestino').val('');
				cupom();
			}
		});
	
	}	
	
	function LoadFrete() {
		//alert('botão funcionando!!');
		$('#valor_frete').val('0,00');
		$('.ResultadoPrecoPrazo').html('');
		var valortotalorca 	= $('#ValorTotal').val();
		var prazo_prdperv = $('#PrazoPrdServ').val();
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

				$('.ResultadoPrecoPrazo').html(data);
				
				var prazo_correios = $('#prazo_correios').val();
				var prazo_entrega = - (-prazo_prdperv -prazo_correios);
				//console.log(prazo_prdperv);
				//console.log(prazo_correios);
				//console.log(prazo_entrega);
				$('#PrazoCorreios').val(prazo_correios);
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
				
				if($('#valor_frete').val()){				
					$('#valorfreteaparente').val($('#valor_frete').val());
					valor_frete_bruto = $('#valor_frete').val();
					valor_frete_bruto 	= valor_frete_bruto.replace('.','').replace(',','.');
					valor_frete_bruto 	= parseFloat(valor_frete_bruto);
					$('#valorfrete').val(valor_frete_bruto);
				}
				
				valor_frete = $('#valorfreteaparente').val();
				valor_frete 	= valor_frete.replace('.','').replace(',','.');
				valor_frete 	= parseFloat(valor_frete);							
		
				valortotalorca 		= valortotalorca.replace(".","").replace(",",".");
				valortotalorca		= parseFloat(valortotalorca);
				
				var total 	= valor_frete + valortotalorca;
				total 		= parseFloat(total);
				total 		= mascaraValorReal(total);

				$('#valor_total').val(total);				

				$('#valor_total_aparente').val(total);
				$('#valorfrete').val(valor_frete);
				
				if(valor_frete > "0.00"){
					$('#msg').html('<p style="color: green">Cálculo realizada com Sucesso!!</p>');
					$('.finalizar').show();
				}else{
					$('#msg').html('<p style="color: #FF0000">Erro ao realizar o Cálculo!!</p>');
					$('.finalizar').hide();
					//window.location = 'entrega.php';
				}
				
				$('#Cep').val(CepDestino);
				cupom();
				//usarcashback();
				

			}, beforeSend: function(){
			
			}, error: function(jqXHR, textStatus, errorThrown){
				//console.log('Erro');
				$('#msg').html('<p style="color: #FF0000">Erro ao realizar o Cálculo!!</p>');
				//window.location = 'entrega.php';
				$('.ResultadoPrecoPrazo').html('');
				$('#valor_total').val(valortotalorca);
				cupom();
			}
		});
	}	
	
	function usarcupom(UsarCupom) {

		$('#Hidden_UsarCupom').val(UsarCupom);
		$('#Cupom').val('');

		var Hidden_Ativo_Pagseguro	= $('#Hidden_Ativo_Pagseguro').val();
		var usarcash = $('#Hidden_UsarCashBack').val();
		var Hidden_localpagamento = $('#Hidden_localpagamento').val();
		var valortotalorca 	= $('#ValorTotal').val();
		valortotalorca 		= valortotalorca.replace(".","").replace(",",".");
		valortotalorca		= parseFloat(valortotalorca);

		if(usarcash == "S"){
			$('.UsarCashBack').show();
			if(Hidden_localpagamento == "O"){
				$('.DEPOSITO').show().prop('selected', true);
				$('.CARTAO').hide();
				$('.DEBITO').hide();
				$('.BOLETOPAGSEGURO').hide();
			}else{
				$('.DINHEIRO').show().prop('selected', true);
				$('.DEPOSITO').show();
				if(Hidden_Ativo_Pagseguro == "S"){	
					$('.CARTAO').show();
					$('.DEBITO').show();
					$('.BOLETOPAGSEGURO').show();
				}else{	
					$('.CARTAO').hide();
					$('.DEBITO').hide();
					$('.BOLETOPAGSEGURO').hide();
				}
			}
		}else{
			$('.UsarCashBack').hide();
			if(UsarCupom == "S"){
				$('.UsarCupom').show();
				if(Hidden_localpagamento == "O"){
					$('.DEPOSITO').show().prop('selected', true);
					$('.CARTAO').hide();
					$('.DEBITO').hide();
					$('.BOLETOPAGSEGURO').hide();
				}else{
					$('.DINHEIRO').show().prop('selected', true);
					$('.DEPOSITO').show();
					if(Hidden_Ativo_Pagseguro == "S"){	
						$('.CARTAO').show();
						$('.DEBITO').show();
						$('.BOLETOPAGSEGURO').show();
					}else{	
						$('.CARTAO').hide();
						$('.DEBITO').hide();
						$('.BOLETOPAGSEGURO').hide();
					}						
				}				
			}else{
				$('.UsarCupom').hide();
				if(Hidden_localpagamento == "O"){
					$('.DEPOSITO').show().prop('selected', true);
					if(Hidden_Ativo_Pagseguro == "S"){	
						$('.CARTAO').show();
						$('.DEBITO').show();
						$('.BOLETOPAGSEGURO').show();
					}else{	
						$('.CARTAO').hide();
						$('.DEBITO').hide();
						$('.BOLETOPAGSEGURO').hide();
					}
				}else{
					$('.DINHEIRO').show().prop('selected', true);
					$('.DEPOSITO').show();
					if(Hidden_Ativo_Pagseguro == "S"){	
						$('.CARTAO').show();
						$('.DEBITO').show();
						$('.BOLETOPAGSEGURO').show();
					}else{	
						$('.CARTAO').hide();
						$('.DEBITO').hide();
						$('.BOLETOPAGSEGURO').hide();
					}						
				}
			}
		}

		if(UsarCupom == "S"){
			$('.UsarCupom').show();
			cupom();	
		}else{
			$('.UsarCupom').hide();
			$('#ValorCupom').val(0);
			$('#DescPercOrca').val('0,00');
			$('#DescValorOrca').val('0,00');
			$('#Hidden_ValorCupom').val('');
			$('#Hidden_TipoDescOrca').html('');
			$('#TipoDescOrca').val('V');
			$("#CodigoCupom").html('');
			$('#ValidaCupom').val(0);
			//console.log('ValidaCupom = '+$('#ValidaCupom').val());
			$('#Cupom').val(0);
			$("#Hidden_MensagemCupom").html('');		
			usarcashback();
		}
	}

	function cupom(Cupom){

		var UsarCupom = $('#Hidden_UsarCupom').val();

		var valortotalorca 	= $('#ValorTotal').val();
		valortotalorca 		= valortotalorca.replace(".","").replace(",",".");
		valortotalorca		= parseFloat(valortotalorca);		
		
		var Hidden_tipofrete = $('#Hidden_tipofrete').val();

		if(Hidden_tipofrete == 1){
			var valor_frete = '0,00';
		}else if(Hidden_tipofrete == 2){
			var valor_frete = '0,00';
		}else if(Hidden_tipofrete == 3){
			var valor_frete = $('#valorfreteaparente').val();
		}else{
			var valor_frete = '0,00';
		}

		valor_frete 	= valor_frete.replace('.','').replace(',','.');	
		valor_frete		= parseFloat(valor_frete);

		var valorcfrete = valortotalorca + valor_frete;
		valorcfrete		= parseFloat(valorcfrete);

		if(UsarCupom == "S"){
			if(!Cupom){
				Cupom = $('#Cupom').val();
			}		

			$.ajax({
				
				url: '../site2_back/pesquisar/Cupom.php?id_empresa='+id_empresa+'&Cupom='+Cupom,
				
				dataType: "json",
				success: function (data) {
					//console.log('data = '+data);
					
					if(data != null){
						//console.log('diferente');
						var tipo	= data[0]['tipo'];
						var tipodesc	= data[0]['tipodesc'];
						var valorcupom	= data[0]['valorcupom'];
						var valorminimo	= data[0]['valorminimo'];
						var datacampanha	= data[0]['datacampanha'];
						var datacampanhalimite	= data[0]['datacampanhalimite'];
						var campanha	= data[0]['campanha'];
						var desccampanha	= data[0]['desccampanha'];

						var partesData = datacampanha.split("-");
						var dia = parseInt(partesData[2]);
						var mes = parseInt(partesData[1]);
						var ano = parseInt(partesData[0]);
						var validade1 	= partesData[2]+'/'+partesData[1]+'/'+partesData[0];
						var validade_1 	= new Date(ano, mes - 1, dia);
						//console.log('validade_1 = '+validade_1);
						
						var partesData_2 = datacampanhalimite.split("-");
						var dia_2 = parseInt(partesData_2[2]);
						var mes_2 = parseInt(partesData_2[1]);
						var ano_2 = parseInt(partesData_2[0]);
						var validade2 	= partesData_2[2]+'/'+partesData_2[1]+'/'+partesData_2[0];
						var validade_2 	= new Date(ano_2, mes_2 - 1, dia_2);
						//console.log('validade_2 = '+validade_2);
						usarcashback();						
						//console.log('data_hoje = '+data_hoje);
						
						if(validade_2 >= data_hoje && data_hoje >= validade_1  ){
							//console.log('data do Cupom = Válida');
							
							ValorCupom	= parseFloat(valorcupom);
							//console.log('ValorCupom = '+ValorCupom);
							
							ValorMinimo	= parseFloat(valorminimo);
							if(valorcfrete >= ValorMinimo){
								//console.log('Valor c/Frete >= Mínimo "Tudo certo"');
								
								$('#ValorCupom').val(ValorCupom);
								Hidden_ValorCupom 	= mascaraValorReal(ValorCupom);
								$('#Hidden_ValorCupom').val(Hidden_ValorCupom);
								$("#Hidden_MensagemCupom").html('<span style="color: #0000FF">'+campanha+'<br>'+desccampanha+'</span>');					
								$('#TipoDescOrca').val(tipodesc);
								$("#CodigoCupom").html('<span style="color: #0000FF">Válido!</span>');
								$('#ValidaCupom').val(1);
								if(tipodesc == 'V'){
									$('#Hidden_TipoDescOrca').html('R$');
									descValorOrca();
								}else{
									$('#Hidden_TipoDescOrca').html('%');
									descPercOrca();
								}
								valorcfrete 	= mascaraValorReal(valorcfrete);				
								$('#valor_total').val(valorcfrete);
							}else{
								//console.log('Valor c/Frete < Mínimo "Ajustar valor"');
								ValorMinimo 	= mascaraValorReal(ValorMinimo);
								ValorCupom	= 0;
								$('#ValorCupom').val(ValorCupom);
								Hidden_ValorCupom 	= mascaraValorReal(ValorCupom);
								$('#Hidden_ValorCupom').val(Hidden_ValorCupom);
								$("#CodigoCupom").html('<span style="color: #F0E68C">Válido! Mas Atenção!</span>');
								$('#ValidaCupom').val(0);
								$("#Hidden_MensagemCupom").html('<span style="color: #F0E68C">Cupom Válido para compra Mínima de R$'+ValorMinimo+'</span>');
								if(tipodesc == 'V'){
									$('#Hidden_TipoDescOrca').html('R$');
									descValorOrca();
								}else{
									$('#Hidden_TipoDescOrca').html('%');
									descPercOrca();
								}
								valorcfrete 	= mascaraValorReal(valorcfrete);				
								$('#valor_total').val(valorcfrete);
							}
						}else{
							//console.log('data do Cupom = Inválida');
							$('#ValorCupom').val(0);
							$('#DescPercOrca').val('0,00');
							$('#DescValorOrca').val('0,00');
							$('#Hidden_ValorCupom').val('');
							$('#Hidden_TipoDescOrca').html('');
							$('#TipoDescOrca').val('V');
							valorcfrete 	= mascaraValorReal(valorcfrete);
							$('#valor_total').val(valorcfrete);
							$('#SubValorFinal').val(valorcfrete);
							$("#CodigoCupom").html('<span style="color: #FF0000">Inválido!</span>');
							$('#ValidaCupom').val(0);
							$("#Hidden_MensagemCupom").html('<span style="color: #FF0000">Digite outro Cupom</span>');
							usarcashback();
						}
						
					}else{
						//console.log('data do Cupom = Inválida');
						$('#ValorCupom').val(0);
						$('#DescPercOrca').val('0,00');
						$('#DescValorOrca').val('0,00');
						$('#Hidden_ValorCupom').val('');
						$('#Hidden_TipoDescOrca').html('');
						$('#TipoDescOrca').val('V');
						valorcfrete 	= mascaraValorReal(valorcfrete);
						$('#valor_total').val(valorcfrete);
						$('#SubValorFinal').val(valorcfrete);
						$("#CodigoCupom").html('<span style="color: #FF0000">Inválido!</span>');
						$('#ValidaCupom').val(0);
						$("#Hidden_MensagemCupom").html('<span style="color: #FF0000">Digite outro Cupom</span>');
						usarcashback();
					}
				},
				error:function(data){
					//console.log('ERRO Nada encontrado');
					$('#ValorCupom').val(0);
					$('#DescPercOrca').val('0,00');
					$('#DescValorOrca').val('0,00');
					$('#Hidden_ValorCupom').val('');
					$('#Hidden_TipoDescOrca').html('');
					$('#TipoDescOrca').val('V');
					valorcfrete 	= mascaraValorReal(valorcfrete);
					$('#valor_total').val(valorcfrete);
					$('#SubValorFinal').val(valorcfrete);
					$("#CodigoCupom").html('<span style="color: #FF0000">Inválido!</span>');
					$('#ValidaCupom').val(0);
					$("#Hidden_MensagemCupom").html('<span style="color: #FF0000">Digite outro Cupom</span>');
					usarcashback();
				}
				
			});//termina o ajax
		}else{
			//console.log('Não Vai Usar Cupom');
			valorcfrete 	= mascaraValorReal(valorcfrete);
			$('#valor_total').val(valorcfrete);
			$('#SubValorFinal').val(valorcfrete);
			$("#CodigoCupom").html('');
			$('#ValidaCupom').val(0);
			$("#Hidden_MensagemCupom").html('');
			$('#ValorCupom').val(0);
			$('#TipoDescOrca').val('V');
			$('#DescPercOrca').val('0,00');
			$('#DescValorOrca').val('0,00');
			usarcashback();
		}			
	}

	function descPercOrca(){
		
		var valortotalorca = $('#valor_total').val();
		valortotalorca 	= valortotalorca.replace(".","").replace(",",".");
		valortotalorca	= parseFloat(valortotalorca);

		var descpercorca = $('#ValorCupom').val();
		if(!descpercorca){
			descpercorca	= 0;
		}	
		descpercorca	= parseFloat(descpercorca);	
		
		if(valortotalorca > 0){

			if(descpercorca <= 100){	
				var descvalororca = descpercorca*valortotalorca/100;
				descvalororca	= parseFloat(descvalororca);			
				
				var subvalorfinal 	= (valortotalorca - descvalororca);
			}else{
				var descvalororca = valortotalorca;
				descvalororca	= parseFloat(descvalororca);
				var descpercorca = 100;
				var subvalorfinal = 0.00;
			}

			descpercorca 	= mascaraValorReal(descpercorca);
			descvalororca 	= mascaraValorReal(descvalororca);
			
			subvalorfinal		= parseFloat(subvalorfinal);
			subvalorfinal 		= mascaraValorReal(subvalorfinal);

			$('#DescPercOrca').val(descpercorca);
			$('#DescValorOrca').val(descvalororca);
			$('#SubValorFinal').val(subvalorfinal);
			
		}else{
			descpercorca 	= mascaraValorReal(descpercorca);
			$('#DescPercOrca').val(descpercorca);
			$('#DescValorOrca').val('0,00');
			$('#SubValorFinal').val('0,00');
		}
		
		usarcashback();

	}

	function descValorOrca(){
		
		var valortotalorca 	= $('#valor_total').val();
		valortotalorca 		= valortotalorca.replace(".","").replace(",",".");
		valortotalorca		= parseFloat(valortotalorca);

		if($('#ValorCupom').val() == ''){
			var descvalororca = 0;
		}else{
			var descvalororca = $('#ValorCupom').val();
		}

		descvalororca	= parseFloat(descvalororca);
	
		if(valortotalorca > 0){
		
			if(valortotalorca >= descvalororca){
				var subvalorfinal = (valortotalorca - descvalororca);
				subvalorfinal	= parseFloat(subvalorfinal);
				var descpercorca = (valortotalorca - subvalorfinal)*100/valortotalorca;
			}else{
				var subvalorfinal = 0.00;
				subvalorfinal	= parseFloat(subvalorfinal);
				var descpercorca = 100;
			}

			descpercorca	= parseFloat(descpercorca);
			descpercorca 	= mascaraValorReal(descpercorca);
			descvalororca 	= mascaraValorReal(descvalororca);
			subvalorfinal 	= mascaraValorReal(subvalorfinal);

			$('#DescPercOrca').val(descpercorca);
			$('#DescValorOrca').val(descvalororca);
			$('#SubValorFinal').val(subvalorfinal);	
			
		}else{
			$('#DescPercOrca').val('0,00');
			descvalororca 	= mascaraValorReal(descvalororca);
			$('#DescValorOrca').val(descvalororca);
			$('#SubValorFinal').val('0,00');
		}
		
		usarcashback();
	}
	
	function usarcashback(usarcash) {
		
		var Hidden_Ativo_Pagseguro	= $('#Hidden_Ativo_Pagseguro').val();
		var Hidden_localpagamento = $('#Hidden_localpagamento').val();
		var Hidden_tipofrete = $('#Hidden_tipofrete').val();
		var UsarCupom = $('#Hidden_UsarCupom').val();
		$('.ExibirCashBack').show();

		if(!usarcash){
			usarcash = $('#Hidden_UsarCashBack').val();
		}

		if(usarcash){
			if(usarcash == "S"){
				$('.UsarCashBack').show();
				if(Hidden_localpagamento == "O"){
					$('.DEPOSITO').show().prop('selected', true);
					$('.CARTAO').hide();
					$('.DEBITO').hide();
					$('.BOLETOPAGSEGURO').hide();
				}else{
					$('.DINHEIRO').show().prop('selected', true);
					$('.DEPOSITO').show();
					if(Hidden_Ativo_Pagseguro == "S"){	
						$('.CARTAO').show();
						$('.DEBITO').show();
						$('.BOLETOPAGSEGURO').show();
					}else{	
						$('.CARTAO').hide();
						$('.DEBITO').hide();
						$('.BOLETOPAGSEGURO').hide();
					}
				}
			}else{
				$('.UsarCashBack').hide();
				if(UsarCupom == "S"){
					$('.UsarCupom').show();
					if(Hidden_localpagamento == "O"){
						$('.DEPOSITO').show().prop('selected', true);
						$('.CARTAO').hide();
						$('.DEBITO').hide();
						$('.BOLETOPAGSEGURO').hide();
					}else{
						$('.DINHEIRO').show().prop('selected', true);
						$('.DEPOSITO').show();
						if(Hidden_Ativo_Pagseguro == "S"){	
							$('.CARTAO').show();
							$('.DEBITO').show();
							$('.BOLETOPAGSEGURO').show();
						}else{	
							$('.CARTAO').hide();
							$('.DEBITO').hide();
							$('.BOLETOPAGSEGURO').hide();
						}						
					}				
				}else{
					$('.UsarCupom').hide();
					if(Hidden_localpagamento == "O"){
						$('.DEPOSITO').show().prop('selected', true);
						if(Hidden_Ativo_Pagseguro == "S"){	
							$('.CARTAO').show();
							$('.DEBITO').show();
							$('.BOLETOPAGSEGURO').show();
						}else{	
							$('.CARTAO').hide();
							$('.DEBITO').hide();
							$('.BOLETOPAGSEGURO').hide();
						}
					}else{
						$('.DINHEIRO').show().prop('selected', true);
						$('.DEPOSITO').show();
						if(Hidden_Ativo_Pagseguro == "S"){	
							$('.CARTAO').show();
							$('.DEBITO').show();
							$('.BOLETOPAGSEGURO').show();
						}else{	
							$('.CARTAO').hide();
							$('.DEBITO').hide();
							$('.BOLETOPAGSEGURO').hide();
						}						
					}
				}
			}
			var Hidden_UsarCashBack	= usarcash;
			$('#Hidden_UsarCashBack').val(usarcash);
		}else{
			var Hidden_UsarCashBack	= $('#Hidden_UsarCashBack').val();
		}

		var cashbackorca 	= $('#ValorCashBack').val();
		cashbackorca 		= cashbackorca.replace(".","").replace(",",".");
		cashbackorca		= parseFloat(cashbackorca);		

		var subvalortotal = $('#SubValorFinal').val();
		subvalortotal 		= subvalortotal.replace(".","").replace(",",".");
		subvalortotal		= parseFloat(subvalortotal);	

		var valorcfrete 	= $('#valor_total').val();
		valorcfrete 		= valorcfrete.replace(".","").replace(",",".");
		valorcfrete			= parseFloat(valorcfrete);

		if(UsarCupom == "S"){
			valorconta = subvalortotal;
		}else{
			valorconta = valorcfrete;
		}

		if(Hidden_UsarCashBack == 'S'){
			if(valorconta >= cashbackorca){
				var valorfinalorca = (valorconta - cashbackorca);
			}else{
				var valorfinalorca = 0;
			}	
		}else{
			var valorfinalorca = valorconta;
		}
		
		valorfinalorca	= parseFloat(valorfinalorca);
		valorfinalorca 	= mascaraValorReal(valorfinalorca);
		$('#ValorFinalOrca').val(valorfinalorca);

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
		$('#valorfrete').val('0.00');
		$('#valorfreteaparente').val('0,00');
		$('#PrazoCorreios').val('0');
		$('#prazoentrega').val($('#PrazoPrdServ').val());
		$('#valor_total').val($('#ValorTotal').val());
		$('#valor_total_aparente').val($('#ValorTotal').val());
		$('#dataaparente').val($('#DataEntrega2').val());
		$('#msg').html('');
		cupom();
	}
	
	function Limpar() {
		$('#msg').html('');
	}	
	
<?php 
	if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]) && isset($_SESSION['Site_Back']['carrinho'.$idSis_Empresa])){
		
		$cliente = $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];
		//pego o Usuário que cadastrou esse cliente.
		$result_usu_cli = 'SELECT 
					idSis_Usuario
				FROM
					App_Cliente
				WHERE
					idApp_Cliente = "' . $cliente . '"
				LIMIT 1
			';

		$resultado_usu_cli = mysqli_query($conn, $result_usu_cli);
		foreach($resultado_usu_cli as $resultado_usu_cli_view){
			$usu_cli = $resultado_usu_cli_view['idSis_Usuario'];
		}		

		$usarcashback = filter_input(INPUT_POST,'UsarCashBack');
		$localpagamento = filter_input(INPUT_POST,'localpagamento');
		$formapagamento = filter_input(INPUT_POST,'formapagamento');
		$tipofrete = filter_input(INPUT_POST,'tipofrete');
		$descricao = filter_input(INPUT_POST,'Descricao');
		$valordinheiro = filter_input(INPUT_POST,'ValorDinheiro');
		$prazo_prdperv = filter_input(INPUT_POST,'PrazoPrdServ');
		$comissaoenkontraki = $row_empresa['ComissaoEnkontraki'];
		$dia = date('Y-m-d');
		$hora = date('H:i:s');
		$hora_mais1 = date('H:i:s', strtotime('+1 hour'));
		//$hora_mais1 = date($hora, strtotime('+1 hour'));
		//$dia_hora = date('Y-m-d H:i:s');
		$dia_hora = $dia . ' ' . $hora;
		
		$Produtos 			= filter_input(INPUT_POST,'ValorTotal');
		$Frete 				= filter_input(INPUT_POST,'valorfreteaparente');
		$ProdutosFrete 		= filter_input(INPUT_POST,'valor_total');
		$Hidden_UsarCupom 	= filter_input(INPUT_POST,'Hidden_UsarCupom');
		$Cupom 				= filter_input(INPUT_POST,'Cupom');
		$ValidaCupom 		= filter_input(INPUT_POST,'ValidaCupom');
		$TipoDescOrca 		= filter_input(INPUT_POST,'TipoDescOrca');
		$DescValorOrca 		= filter_input(INPUT_POST,'DescValorOrca');
		$DescPercOrca 		= filter_input(INPUT_POST,'DescPercOrca');
		$SubValorFinal 		= filter_input(INPUT_POST,'SubValorFinal');
		$Hidden_UsarCashBack = filter_input(INPUT_POST,'Hidden_UsarCashBack');
		$ValorCashBack 		= filter_input(INPUT_POST,'ValorCashBack');
		$ValorFinalOrca 	= filter_input(INPUT_POST,'ValorFinalOrca');		
		
		if(empty($valordinheiro)){
			$valordinheiro = "0.00";
		}else{
			$valordinheiro 	= str_replace(',', '.', str_replace('.', '', $valordinheiro));
		}
		
		if(empty($Produtos)){
			$Produtos = "0.00";
		}else{
			$Produtos 	= str_replace(',', '.', str_replace('.', '', $Produtos));
		}

		if(empty($Frete)){
			$Frete = "0.00";
		}else{
			$Frete 	= str_replace(',', '.', str_replace('.', '', $Frete));
		}

		if(empty($ProdutosFrete)){
			$ProdutosFrete = "0.00";
		}else{
			$ProdutosFrete 	= str_replace(',', '.', str_replace('.', '', $ProdutosFrete));
		}

		if(empty($DescValorOrca)){
			$DescValorOrca = "0.00";
		}else{
			$DescValorOrca 	= str_replace(',', '.', str_replace('.', '', $DescValorOrca));
		}

		if(empty($DescPercOrca)){
			$DescPercOrca = "0.00";
		}else{
			$DescPercOrca 	= str_replace(',', '.', str_replace('.', '', $DescPercOrca));
		}		
		
		if(empty($SubValorFinal)){
			$SubValorFinal = "0.00";
		}else{
			$SubValorFinal 	= str_replace(',', '.', str_replace('.', '', $SubValorFinal));
		}		
		
		if(empty($ValorCashBack)){
			$ValorCashBack = "0.00";
		}else{
			$ValorCashBack 	= str_replace(',', '.', str_replace('.', '', $ValorCashBack));
		}		
		
		if(empty($ValorFinalOrca)){
			$ValorFinalOrca = "0.00";
		}else{
			$ValorFinalOrca 	= str_replace(',', '.', str_replace('.', '', $ValorFinalOrca));
		}

		if($ValidaCupom == 0 || empty($Cupom)){
			$Cupom = "0";
		}
		
		if(empty($TipoDescOrca)){
			$TipoDescOrca = "V";
		}		
		
		if(isset($tipofrete)) {

			if($tipofrete == 1){
				//$pagar = "O";
				$tipofretepagseguro = "3";
				$combinadofrete = "S";
				$valorfrete = "0.00";
				$prazo_correios = "0";
				$prazoentrega = $prazo_prdperv;
				//$dataentrega = date('Y-m-d');
				$dataentrega = filter_input(INPUT_POST,'DataEntrega1');
				$cep = filter_input(INPUT_POST,'RecarregaCepDestino');
				$logradouro = filter_input(INPUT_POST,'RecarregaLogradouro');
				$numero = filter_input(INPUT_POST,'RecarregaNumero');
				$complemento = filter_input(INPUT_POST,'RecarregaComplemento');
				$bairro = filter_input(INPUT_POST,'RecarregaBairro');
				$cidade = filter_input(INPUT_POST,'RecarregaCidade');
				$estado = filter_input(INPUT_POST,'RecarregaEstado');
				$referencia = filter_input(INPUT_POST,'RecarregaReferencia');
			}		
			
			if($tipofrete == 2){
				//$pagar = "O";
				$tipofretepagseguro = "3";
				$combinadofrete = "N";
				$valorfrete = "0.00";
				$prazo_correios = "0";
				$prazoentrega = $prazo_prdperv;
				//$dataentrega = date('Y-m-d');
				$dataentrega = filter_input(INPUT_POST,'DataEntrega1');
				$cep = filter_input(INPUT_POST,'CepDestino');
				$logradouro = filter_input(INPUT_POST,'Logradouro');
				$numero = filter_input(INPUT_POST,'Numero');
				$complemento = filter_input(INPUT_POST,'Complemento');
				$bairro = filter_input(INPUT_POST,'Bairro');
				$cidade = filter_input(INPUT_POST,'Cidade');
				$estado = filter_input(INPUT_POST,'Estado');
				$referencia = filter_input(INPUT_POST,'Referencia');			
			}

			if($tipofrete == 3){
				$codigo = filter_input(INPUT_POST,'Codigo');
					if($codigo == "41106"){
						$tipofretepagseguro = "1";
					}elseif($codigo == "40010"){
						$tipofretepagseguro = "2";
					}			
				//$pagar = "O";
				$combinadofrete = "S";
				$valorfrete = filter_input(INPUT_POST,'valorfrete');
				$prazo_correios = filter_input(INPUT_POST,'PrazoCorreios');
				$prazoentrega = filter_input(INPUT_POST,'prazoentrega');
				$dataentrega = filter_input(INPUT_POST,'dataentrega');
				$cep = filter_input(INPUT_POST,'Cep');
				$logradouro = filter_input(INPUT_POST,'Logradouro');
				$numero = filter_input(INPUT_POST,'Numero');
				$complemento = filter_input(INPUT_POST,'Complemento');
				$bairro = filter_input(INPUT_POST,'Bairro');
				$cidade = filter_input(INPUT_POST,'Cidade');
				$estado = filter_input(INPUT_POST,'Estado');
				$referencia = filter_input(INPUT_POST,'Referencia');			
			}		
		}

		$caracteres_sem_acento = array(
			'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
			'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
			'Ï'=>'I', 'Ñ'=>'N', 'N'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
			'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
			'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
			'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'n'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
			'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
			'a'=>'a', 'î'=>'i', 'â'=>'a', 'ș'=>'s', 'ț'=>'t', 'A'=>'A', 'Î'=>'I', 'Â'=>'A', 'Ș'=>'S', 'Ț'=>'T',
		);

		$logradouro = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($logradouro, $caracteres_sem_acento));
		$logradouro = trim(mb_strtoupper($logradouro, 'ISO-8859-1'));

		$cep = preg_replace("/[^0-9]/", " ", strtr($cep, $caracteres_sem_acento));
		$cep = trim(mb_strtoupper($cep, 'ISO-8859-1'));

		$numero = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($numero, $caracteres_sem_acento));
		$numero = trim(mb_strtoupper($numero, 'ISO-8859-1'));

		$complemento = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($complemento, $caracteres_sem_acento));
		$complemento = trim(mb_strtoupper($complemento, 'ISO-8859-1'));

		$bairro = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($bairro, $caracteres_sem_acento));
		$bairro = trim(mb_strtoupper($bairro, 'ISO-8859-1'));

		$cidade = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($cidade, $caracteres_sem_acento));
		$cidade = trim(mb_strtoupper($cidade, 'ISO-8859-1'));

		$estado = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($estado, $caracteres_sem_acento));
		$estado = trim(mb_strtoupper($estado, 'ISO-8859-1'));

		$referencia = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($referencia, $caracteres_sem_acento));
		$referencia = trim(mb_strtoupper($referencia, 'ISO-8859-1'));

		$logradouro1 = trim(mb_strtoupper($logradouro, 'UTF-8'));
		$complemento1 = trim(mb_strtoupper($complemento, 'ISO-8859-1'));

		/*
		echo "<pre>";
		print_r($usarcashback);
		echo "<br>";
		print_r($cashtotal_conta);
		echo "<br>";
		print_r($contagem);
		echo "<br>";
		print_r($resultado_view);
		echo "<br>";
		echo "</pre>";
		exit();
		*/
		
		$associado = "0";
		$usuario_vend = "0";
		$nivel_vend = "1";
		$comissao_func = 0;
		if(isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa])){
			$usuario_vend = $_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa];
			if($_SESSION['Site_Back']['Nivel_Usuario_vend'.$idSis_Empresa] == 2){
				$nivel_vend = 2;
			}else{
				$nivel_vend = 1;
			}
			$comissao_func = $_SESSION['Site_Back']['Comissao_Usuario_vend'.$idSis_Empresa];
		}else{
			if(isset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa])){
				$usuario_vend = $_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa];
				if($_SESSION['Site_Back']['Nivel_Vendedor'.$idSis_Empresa] == 2){
					$nivel_vend = 2;
				}else{
					$nivel_vend = 1;
				}
				$comissao_func = $_SESSION['Site_Back']['Comissao_Vendedor'.$idSis_Empresa];		
			}else{		
				if(isset($_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa])){
					$associado = $_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa];
				}else{
					if(isset($usu_cli) && $usu_cli != 0 ){
						$usuario_vend = $usu_cli;
					}
				}
			}
		}	
		/*	
		echo "<br>";
		echo "<pre>";
		print_r(count($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]));
		echo "<br>";
		print_r($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]);
		echo "<br>";
		print_r($usuario_vend);
		echo "<br>";
		print_r('nivel da venda = '.$nivel_vend);
		echo "<br>";
		print_r($associado);
		echo "<br>";
		print_r($idSis_Empresa);
		echo "<br>";
		print_r($dia);
		echo "<br>";
		print_r($hora);
		echo "<br>";
		print_r($dia_hora);
		echo "<br>";
		print_r($formapagamento);
		echo "<br>";
		print_r($localpagamento);
		echo "<br>";
		print_r($tipofrete);
		echo "<br>";
		print_r($tipofretepagseguro);
		echo "<br>";
		print_r($combinadofrete);
		echo "<br>";
		print_r($valorfrete);
		echo "<br>";
		print_r($prazoentrega);
		echo "<br>";
		print_r($dataentrega);
		echo "<br>";
		print_r($hora_mais1);
		echo "<br>";
		print_r($cep);
		echo "<br>";
		print_r($logradouro);
		echo "<br>";
		print_r($numero);
		echo "<br>";
		print_r($complemento);
		echo "<br>";
		print_r($bairro);
		echo "<br>";
		print_r($referencia);
		echo "<br>";
		print_r($cidade);
		echo "<br>";
		print_r($estado);
		echo "<br>";
		print_r($descricao);
		echo "<br>";
		print_r('valordinheiro = ' . $valordinheiro);
		echo "<br>";
		print_r($prazo_prdperv);
		echo "<br>";
		print_r($prazo_correios);
		echo "<br>";
		print_r($usarcashback);

		echo "<br>";
		print_r('Produtos = '.$Produtos);
		echo "<br>";
		print_r('Frete = '.$Frete);
		echo "<br>";
		print_r('Produtos+Frete = '.$ProdutosFrete);
		echo "<br>";
		print_r('Hidden_UsarCupom = '.$Hidden_UsarCupom);
		echo "<br>";
		print_r('Cupom = '.$Cupom);
		echo "<br>";
		print_r('ValidaCupom = '.$ValidaCupom);
		echo "<br>";
		print_r('TipoDescOrca = '.$TipoDescOrca);
		echo "<br>";
		print_r('DescValorOrca = '.$DescValorOrca);
		echo "<br>";
		print_r('DescPercOrca = '.$DescPercOrca);
		echo "<br>";
		print_r('SubValorFinal = '.$SubValorFinal);
		echo "<br>";
		print_r('Hidden_UsarCashBack = '.$Hidden_UsarCashBack);
		echo "<br>";
		print_r('ValorCashBack = '.$ValorCashBack);
		echo "<br>";
		print_r('ValorFinalOrca = '.$ValorFinalOrca);		

		echo "</pre>";
		exit();		
		*/
		
		if(count($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]) == '0'){
			echo "<script>alert('Não existem produtos no carrinho de compras')</script>";
			echo "<script>window.location = 'meu_carrinho.php'</script>";
		}else{
			$insert_pedido = "INSERT INTO App_OrcaTrata(idTab_Modulo,idTab_TipoRD,idApp_Cliente,idSis_Usuario,Associado,idSis_Empresa,DataOrca,HoraOrca,DataVencimentoOrca,pedido_data_hora, 
														ValorOrca,ValorRestanteOrca,QtdParcelasOrca,pedido_status,TipoFinanceiro,Modalidade,FormaPagamento,AVAP,Tipo_Orca,TipoFrete,
														TipoFretePagSeguro,CombinadoFrete,ValorFrete,PrazoEntrega,DataEntregaOrca,HoraEntregaOrca,Cep,Logradouro,Numero,Complemento,
														Bairro,Referencia,Cidade,Estado,Descricao,ValorDinheiro,ValorExtraOrca,Cli_Forn_Orca,Prd_Srv_Orca,PrazoProdServ,PrazoCorreios,
														RecorrenciasOrca,RecorrenciaOrca,UsarCashBack,AprovadoOrca,TipoDescOrca,Cupom,UsarCupom,DescValorOrca,DescPercOrca,NivelOrca) 
												VALUES(	'1','2','".$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]."','".$usuario_vend."','".$associado."','".$idSis_Empresa."',
														'".$dia."','".$hora."','".$dia."','".$dia_hora."','0.00','0.00','1','0','31','P','".$formapagamento."','".$localpagamento."',
														'O','".$tipofrete."','".$tipofretepagseguro."','".$combinadofrete."','".$Frete."','".$prazoentrega."','".$dataentrega."',
														'".$hora_mais1."','".$cep."','".$logradouro."','".$numero."','".$complemento."','".$bairro."','".$referencia."','".$cidade."',
														'".$estado."','".$descricao."','".$valordinheiro."','0.00','S','S','".$prazo_prdperv."','".$prazo_correios."','1','1/1',
														'".$usarcashback."','N','".$TipoDescOrca."','".$Cupom."','".$Hidden_UsarCupom."','".$DescValorOrca."','".$DescPercOrca."','".$nivel_vend."')";
			
			$result_insert_pedido = mysqli_query($conn, $insert_pedido);
			
			$id_pedido = mysqli_insert_id($conn);
				
			if ($id_pedido == 0) {
				echo "<script>alert('Ocorreu um erro ao finalizar o pedido')</script>";                
				echo "<script>window.location = 'meu_carrinho.php'</script>";
			} else {
	
				if(isset($usarcashback) && $usarcashback == "S") {

					$result_CashBack = 'SELECT 
								CashBackCliente,
								ValidadeCashBack
							FROM
								App_Cliente
							WHERE
								idSis_Empresa = ' . $idSis_Empresa . ' AND
								idApp_Cliente = "' . $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa] . '"
							LIMIT 1	
						';

					$resultado_CashBack = mysqli_query($conn, $result_CashBack);
					foreach($resultado_CashBack as $resultado_CashBack_view){
						$cashtotal 	= 	$resultado_CashBack_view['CashBackCliente'];
						$validade 	=	$resultado_CashBack_view['ValidadeCashBack'];
					}

					$validade_explode = explode('-', $validade);
					$validade_dia = $validade_explode[2];
					$validade_mes = $validade_explode[1];
					$validade_ano = $validade_explode[0];
					
					$validade_visao 	= $validade_dia . '/' . $validade_mes . '/' . $validade_ano;
					
					$data_hoje = date('Y-m-d', time());

					if(strtotime($validade) >= strtotime($data_hoje)){
						$cashtotal_visao 	= number_format($cashtotal,2,",",".");
					}else{
						$cashtotal_visao 	= '0,00';
					}
					$cashtotal_conta 	= str_replace(',', '.', str_replace('.', '', $cashtotal_visao));					
					$validade_conta 	= $validade;
					
					$update_cliente = " UPDATE 
											App_Cliente 
										SET 
											CashBackCliente = '0.00'
										WHERE
											idSis_Empresa = '" . $idSis_Empresa . "' AND
											idApp_Cliente = '".$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]."'
									";
					$result_update_cliente = mysqli_query($conn, $update_cliente);
				}else{
					$cashtotal_conta = "0.00";
					$validade_conta = "0000-00-00";
				}				
				
				$valor_comissao = '0';
				$total_venda_produto = '0';
				$valor_comissao_produto = '0';
				$valor_comissao_produto_func = '0';
				$valor_comissao_produto_assoc = '0';
				
				$qtd_produtoorca_produto = '0';
				$prazo_carrinho_prod = '0';
				$total_venda_servico = '0';
				$valor_comissao_servico = '0';
				$valor_comissao_servico_func = '0';
				$valor_comissao_servico_assoc = '0';
				
				$qtd_produtoorca_servico = '0';
				$prazo_carrinho_serv = '0';
				$valor_comissao_total = '0';
				$valor_comissao_total_func = '0';
				$valor_comissao_total_assoc = '0';
				
				foreach($_SESSION['Site_Back']['carrinho'.$idSis_Empresa] as $id_produto => $qtd_produto){

					$read_prsr_carrinho = mysqli_query($conn, "
					SELECT 
						TPS.idTab_Produtos AS idProduto,
						TPS.Nome_Prod,
						TPS.NomeProdutos,
						TPS.Arquivo,
						TPS.Comissao,
						TPS.Prod_Serv,
						TOP2.Opcao AS Opcao2,
						TOP1.Opcao AS Opcao1,
						TV.idTab_Valor,
						TV.Convdesc,
						TV.TempoDeEntrega,
						TV.ComissaoVenda,
						TV.ComissaoServico,
						TV.ComissaoCashBack,
						TV.QtdProdutoDesconto,
						TV.QtdProdutoIncremento,
						TV.ValorProduto
					FROM 
						Tab_Produtos AS TPS
							LEFT JOIN Sis_Empresa AS EMP ON EMP.idSis_Empresa = TPS.idSis_Empresa
							LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produtos = TPS.idTab_Produtos
							LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
							LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2
					WHERE 
						TV.idTab_Valor = '".$id_produto."' 
					ORDER BY 
						TV.idTab_Valor ASC
					");
					
					$read_produto_carrinho = mysqli_query($conn, "
					SELECT 
						TPS.idTab_Produtos AS idProduto,
						TPS.Nome_Prod,
						TPS.NomeProdutos,
						TPS.Arquivo,
						TPS.Comissao,
						TPS.Prod_Serv,
						TOP2.Opcao AS Opcao2,
						TOP1.Opcao AS Opcao1,
						TV.idTab_Valor,
						TV.Convdesc,
						TV.TempoDeEntrega,
						TV.ComissaoVenda,
						TV.ComissaoServico,
						TV.ComissaoCashBack,
						TV.QtdProdutoDesconto,
						TV.QtdProdutoIncremento,
						TV.ValorProduto
					FROM 
						Tab_Produtos AS TPS
							LEFT JOIN Sis_Empresa AS EMP ON EMP.idSis_Empresa = TPS.idSis_Empresa
							LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produtos = TPS.idTab_Produtos
							LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
							LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2
					WHERE 
						TV.idTab_Valor = '".$id_produto."' AND
						TPS.Prod_Serv = 'P'
					ORDER BY 
						TV.idTab_Valor ASC
					");
					
					$read_servico_carrinho = mysqli_query($conn, "
					SELECT 
						TPS.idTab_Produtos AS idProduto,
						TPS.Nome_Prod,
						TPS.NomeProdutos,
						TPS.Arquivo,
						TPS.Comissao,
						TPS.Prod_Serv,
						TOP2.Opcao AS Opcao2,
						TOP1.Opcao AS Opcao1,
						TV.idTab_Valor,
						TV.Convdesc,
						TV.TempoDeEntrega,
						TV.ComissaoVenda,
						TV.ComissaoServico,
						TV.ComissaoCashBack,
						TV.QtdProdutoDesconto,
						TV.QtdProdutoIncremento,
						TV.ValorProduto
					FROM 
						Tab_Produtos AS TPS
							LEFT JOIN Sis_Empresa AS EMP ON EMP.idSis_Empresa = TPS.idSis_Empresa
							LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produtos = TPS.idTab_Produtos
							LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
							LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2
					WHERE 
						TV.idTab_Valor = '".$id_produto."' AND
						TPS.Prod_Serv = 'S' 
					ORDER BY 
						TV.idTab_Valor ASC
					");
					if(mysqli_num_rows($read_prsr_carrinho) > '0'){
						foreach($read_prsr_carrinho as $read_prsr_carrinho_view){
							$prod_serv = $read_prsr_carrinho_view['Prod_Serv'];
							$nome_produtos = $read_prsr_carrinho_view['Nome_Prod'];
							$opicao2 = $read_prsr_carrinho_view['Opcao2'];
							$opicao1 = $read_prsr_carrinho_view['Opcao1'];
							$nome_convdesc = $read_prsr_carrinho_view['Convdesc'];
							$prazo_prsr = $read_prsr_carrinho_view['TempoDeEntrega'];
							$qtd_incremento = $read_prsr_carrinho_view['QtdProdutoIncremento'];
							$nome_produto = $nome_produtos.' - '.$nome_convdesc;
							$id_produto_tab_produto = $read_prsr_carrinho_view['idProduto'];
							$sub_total_qtd = $qtd_produto * $qtd_incremento;
							//$qtd_produtoorca += $sub_total_qtd_produto;
							$sub_total_valor = $qtd_produto * $read_prsr_carrinho_view['ValorProduto'];
							//$total_venda_produto += $sub_total_produto_carrinho_produto;
							$sub_total_comissao_func = $qtd_produto * $read_prsr_carrinho_view['ValorProduto'] * $comissao_func / 100;
							$sub_total_comissao = $qtd_produto * $read_prsr_carrinho_view['ValorProduto'] * $read_prsr_carrinho_view['ComissaoVenda'] / 100;
							$sub_total_comissao_assoc = $qtd_produto * $read_prsr_carrinho_view['ValorProduto'] * $read_prsr_carrinho_view['ComissaoServico'] / 100;
							$sub_total_cashback = $qtd_produto * $read_prsr_carrinho_view['ValorProduto'] * $read_prsr_carrinho_view['ComissaoCashBack'] / 100;
							$valor_comissao += $sub_total_comissao;
						}
					}
					if(mysqli_num_rows($read_produto_carrinho) > '0'){
						foreach($read_produto_carrinho as $read_produto_carrinho_view){
							$prazo_produto = $read_produto_carrinho_view['TempoDeEntrega'];
							$qtd_incremento_produto = $read_produto_carrinho_view['QtdProdutoIncremento'];
							$sub_total_qtd_produto_produto = $qtd_produto * $qtd_incremento_produto;
							$qtd_produtoorca_produto += $sub_total_qtd_produto_produto;
							$sub_total_produto_carrinho_produto = $qtd_produto * $read_produto_carrinho_view['ValorProduto'];
							$total_venda_produto += $sub_total_produto_carrinho_produto;
							//$sub_total_comissao = $qtd_produto * $read_produto_carrinho_view['ValorProduto'] * $read_produto_carrinho_view['Comissao'] / 100;
							$sub_total_comissao_produto = $qtd_produto * $read_produto_carrinho_view['ValorProduto'] * $read_produto_carrinho_view['ComissaoVenda'] / 100;
							
							$sub_total_comissao_produto_func = $qtd_produto * $read_produto_carrinho_view['ValorProduto'] * $comissao_func / 100;
							
							$sub_total_servico_produto = $qtd_produto * $read_produto_carrinho_view['ValorProduto'] * $read_produto_carrinho_view['ComissaoServico'] / 100;
							$sub_total_cashback_produto = $qtd_produto * $read_produto_carrinho_view['ValorProduto'] * $read_produto_carrinho_view['ComissaoCashBack'] / 100;
							$valor_comissao_produto += $sub_total_comissao_produto;
							
							$valor_comissao_produto_func += $sub_total_comissao_produto_func;
							$valor_comissao_produto_assoc += $sub_total_servico_produto;
							
							
							if($prazo_produto >= $prazo_carrinho_prod){
								$prazo_carrinho_prod = $prazo_produto;
							}else{
								$prazo_carrinho_prod = $prazo_carrinho_prod;
							}
						
						}
						
					}
					
					if(mysqli_num_rows($read_servico_carrinho) > '0'){
						foreach($read_servico_carrinho as $read_servico_carrinho_view){
							$prazo_servico = $read_servico_carrinho_view['TempoDeEntrega'];
							$qtd_incremento_servico = $read_servico_carrinho_view['QtdProdutoIncremento'];
							$sub_total_qtd_produto_servico = $qtd_produto * $qtd_incremento_servico;
							$qtd_produtoorca_servico += $sub_total_qtd_produto_servico;
							$sub_total_produto_carrinho_servico = $qtd_produto * $read_servico_carrinho_view['ValorProduto'];
							$total_venda_servico += $sub_total_produto_carrinho_servico;
							//$sub_total_comissao = $qtd_produto * $read_servico_carrinho_view['ValorProduto'] * $read_servico_carrinho_view['Comissao'] / 100;
							$sub_total_comissao_servico = $qtd_produto * $read_servico_carrinho_view['ValorProduto'] * $read_servico_carrinho_view['ComissaoVenda'] / 100;
							
							$sub_total_comissao_servico_func = $qtd_produto * $read_servico_carrinho_view['ValorProduto'] * $comissao_func / 100;
							
							$sub_total_servico_servico = $qtd_produto * $read_servico_carrinho_view['ValorProduto'] * $read_servico_carrinho_view['ComissaoServico'] / 100;
							$sub_total_cashback_servico = $qtd_produto * $read_servico_carrinho_view['ValorProduto'] * $read_servico_carrinho_view['ComissaoCashBack'] / 100;
							$valor_comissao_servico += $sub_total_comissao_servico;
						
							$valor_comissao_servico_func += $sub_total_comissao_servico_func;
							
							$valor_comissao_servico_assoc += $sub_total_servico_servico;
						
							if($prazo_servico >= $prazo_carrinho_serv){
								$prazo_carrinho_serv = $prazo_servico;
							}else{
								$prazo_carrinho_serv = $prazo_carrinho_serv;
							}
						
						}
					}
					
					$insert_itens_pedido_produto = "INSERT INTO App_Produto(idApp_Cliente,idSis_Usuario,idSis_Empresa,idApp_OrcaTrata,idTab_Produto,idTab_Valor_Produto,idTab_Produtos_Produto,
																	QtdProduto,QtdIncrementoProduto,ValorProduto,PrazoProduto,NomeProduto,ComissaoProduto,ComissaoServicoProduto,ComissaoCashBackProduto,
																	ValorComissaoVenda,ValorComissaoFuncionario,ValorComissaoAssociado,ValorComissaoCashBack,DataValidadeProduto,DataConcluidoProduto,HoraConcluidoProduto,
																	ConcluidoProduto,idTab_TipoRD,idTab_Modulo,Prod_Serv_Produto,itens_pedido_valor_total,NivelProduto) 
															VALUES('".$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]."','".$usuario_vend."','".$idSis_Empresa."','".$id_pedido."',
																	'".$id_produto."','".$id_produto."','".$id_produto_tab_produto."','".$qtd_produto."','".$qtd_incremento."',
																	'".$read_prsr_carrinho_view['ValorProduto']."','".$read_prsr_carrinho_view['TempoDeEntrega']."','".$nome_produto."',
																	'".$read_prsr_carrinho_view['ComissaoVenda']."','".$read_prsr_carrinho_view['ComissaoServico']."',
																	'".$read_prsr_carrinho_view['ComissaoCashBack']."','".$sub_total_comissao."','".$sub_total_comissao_func."','".$sub_total_comissao_assoc."','".$sub_total_cashback."',
																	'".$dia."','".$dataentrega."','".$hora_mais1."','N','2','1','".$prod_serv."','".$sub_total_valor."','".$nivel_vend."')";
																	
					$result_insert_itens_pedido_produto = mysqli_query($conn, $insert_itens_pedido_produto);					
				}

				$total_venda_prsr = $total_venda_produto + $total_venda_servico;
				
				$valor_soma = $total_venda_prsr + $valorfrete;
				
				$subtotal = $valor_soma - $DescValorOrca;
				
				//$valor_final = $valor_soma - $cashtotal_conta;

				$valor_final = $subtotal - $cashtotal_conta;
				
				if($valor_final >= 0){
					$valor_fatura = $valor_final;
				}else{
					$valor_fatura = 0.00;
				}
				
				$valor_troco = $valordinheiro - $valor_fatura;
				if($valor_troco > 0){
					$valor_troco_final = $valor_troco;
				}else{
					$valor_troco_final = 0.00;
				}
				if($formapagamento == "1" || $formapagamento == "2" || $formapagamento == "3"){
					$valor_gateway = ($valor_fatura * 0.04) + 0.40;
				}else{
					$valor_gateway = 0.00;
				}
				$valor_enkontraki = $total_venda_prsr * $comissaoenkontraki / 100;
				$valor_comissao_total = $valor_comissao_produto + $valor_comissao_servico;
				
				$valor_comissao_total_func = $valor_comissao_produto_func + $valor_comissao_servico_func;
				
				$valor_comissao_total_assoc = $valor_comissao_produto_assoc + $valor_comissao_servico_assoc;
				
				//$valor_empresa = $valor_fatura - $valor_comissao_produto - $valor_comissao_servico - $valor_gateway - $valor_enkontraki;
				$valor_empresa = $valor_fatura - $valor_comissao_total - $valor_gateway - $valor_enkontraki;				

				
				if($valor_final > 0){
					$insert_parcela = "INSERT INTO App_Parcelas(idTab_Modulo,idTab_TipoRD,Quitado,DataVencimento,ValorParcela,FormaPagamentoParcela,
																Parcela,idApp_Cliente,idSis_Usuario,idSis_Empresa,idApp_OrcaTrata,NivelParcela) 
														VALUES('1','2','N','".$dia."','".$valor_fatura."','".$formapagamento."','1/1',
																'".$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]."','".$usuario_vend."',
																'".$idSis_Empresa."','".$id_pedido."','".$nivel_vend."')";
																
					$result_insert_parcela = mysqli_query($conn, $insert_parcela);
				}

				$update_pedido = "UPDATE 
									App_OrcaTrata 
								SET 
									RepeticaoOrca = '".$id_pedido."',
									QtdPrdOrca = '".$qtd_produtoorca_produto."',
									PrazoProdutos = '".$prazo_carrinho_prod."',
									ValorOrca = '".$total_venda_produto."',
									QtdSrvOrca = '".$qtd_produtoorca_servico."',
									PrazoServicos = '".$prazo_carrinho_serv."',
									ValorDev = '".$total_venda_servico."',
									ValorRestanteOrca = '".$total_venda_prsr."',
									ValorSomaOrca = '".$Produtos."',
									ValorTotalOrca = '".$ProdutosFrete."',
									SubValorFinal = '".$SubValorFinal."',
									CashBackOrca = '".$ValorCashBack."',
									ValidadeCashBackOrca = '".$validade_conta."',
									ValorFinalOrca = '".$ValorFinalOrca."',
									ValorTroco = '".$valor_troco_final."',
									ValorFatura = '".$valor_fatura."',
									ValorGateway = '".$valor_gateway."',
									ValorComissao = '".$valor_comissao_total."',
									ValorComissaoAssoc = '".$valor_comissao_total_assoc."',
									ComissaoFunc = '".$comissao_func."',
									ValorComissaoFunc = '".$valor_comissao_total_func."',
									ValorEnkontraki = '".$valor_enkontraki."',
									ValorEmpresa = '".$valor_empresa."'
								WHERE 
									idApp_OrcaTrata = '".$id_pedido."'
								";
								
				$result_update_pedido = mysqli_query($conn, $update_pedido);
			
				unset($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]); 
				unset($_SESSION['Site_Back']['item_carrinho'.$idSis_Empresa]);	
				unset($_SESSION['Site_Back']['total_produtos'.$idSis_Empresa]);				
			}
			/*
			echo "<pre>";
			print_r($id_pedido);
			echo "</pre>";
			exit();
			*/

			
			//session_destroy($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]);
			//header("Location: meus_pedidos.php");
			//echo "<script>alert('Pedido Finalizado')</script>";
			//echo '<script> window.location = "entrega.php?id='.$id_pedido.'" </script>';			
			
			if($localpagamento == "O" && ($tipofrete == "1" || $tipofrete == "3")){
				if($formapagamento == "1" || $formapagamento == "2" || $formapagamento == "3"){
					echo '<script> window.location = "pagar.php?id='.$id_pedido.'" </script>';
				}elseif($formapagamento == "9"){
					//Depósito ou Transferência (falta criar a tela com o número da conta ou pix)
					echo "<script>window.location = 'meus_pedidos.php'</script>";
				}elseif($formapagamento == "11"){
					//boleto da loja (Falta criar a tela para por o boleto da loja com a frase: O Boleto)
					echo "<script>window.location = 'meus_pedidos.php'</script>";
				}
			}else{
				echo "<script>window.location = 'meus_pedidos.php'</script>";			
			}
		}
	}else{
		echo "<script>window.location = 'meu_carrinho.php'</script>";
	}
?>
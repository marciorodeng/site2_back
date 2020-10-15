<?php 
	$localpagamento = filter_input(INPUT_POST,'localpagamento');
	$formapagamento = filter_input(INPUT_POST,'formapagamento');
	$tipofrete = filter_input(INPUT_POST,'tipofrete');
	$descricao = filter_input(INPUT_POST,'Descricao');
	$valordinheiro = filter_input(INPUT_POST,'ValorDinheiro');
	/*
	echo "<pre>";
	print_r($tipofrete);
	echo "<br>";
	print_r($localpagamento);
	echo "<br>";
	print_r($formapagamento);
	echo "<br>";
	echo "</pre>";
	exit();
	*/
	if(isset($tipofrete)) {

		if($tipofrete == 1){
			//$pagar = "O";
			$tipofretepagseguro = "3";
			$combinadofrete = "S";
			$valorfrete = "0.00";
			$prazoentrega = "0";
			$dataentrega = date('Y-m-d');
			$cep = filter_input(INPUT_POST,'RecarregaCepDestino');
			$logradouro = filter_input(INPUT_POST,'RecarregaLogradouro');
			$numero = filter_input(INPUT_POST,'RecarregaNumero');
			$complemento = filter_input(INPUT_POST,'RecarregaComplemento');
			$bairro = filter_input(INPUT_POST,'RecarregaBairro');
			$cidade = filter_input(INPUT_POST,'RecarregaCidade');
			$estado = filter_input(INPUT_POST,'RecarregaEstado');
		}		
		
		if($tipofrete == 2){
			//$pagar = "O";
			$tipofretepagseguro = "3";
			$combinadofrete = "N";
			$valorfrete = "0.00";
			$prazoentrega = "0";
			$dataentrega = date('Y-m-d');
			$cep = filter_input(INPUT_POST,'CepDestino');
			$logradouro = filter_input(INPUT_POST,'Logradouro');
			$numero = filter_input(INPUT_POST,'Numero');
			$complemento = filter_input(INPUT_POST,'Complemento');
			$bairro = filter_input(INPUT_POST,'Bairro');
			$cidade = filter_input(INPUT_POST,'Cidade');
			$estado = filter_input(INPUT_POST,'Estado');			
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
			$prazoentrega = filter_input(INPUT_POST,'prazoentrega');
			$dataentrega = filter_input(INPUT_POST,'dataentrega');
			$cep = filter_input(INPUT_POST,'Cep');
			$logradouro = filter_input(INPUT_POST,'Logradouro');
			$numero = filter_input(INPUT_POST,'Numero');
			$complemento = filter_input(INPUT_POST,'Complemento');
			$bairro = filter_input(INPUT_POST,'Bairro');
			$cidade = filter_input(INPUT_POST,'Cidade');
			$estado = filter_input(INPUT_POST,'Estado');			
		}		
	}
	
	$logradouro1 = trim(mb_strtoupper($logradouro, 'UTF-8'));
	$complemento1 = trim(mb_strtoupper($complemento, 'ISO-8859-1'));

	if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['id_Cliente'.$idSis_Empresa];
	}
	
	if(isset($_SESSION['id_Usuario'.$idSis_Empresa])){
		$usuario = $_SESSION['id_Usuario'.$idSis_Empresa];
	}else{
		$usuario = "1";
	}
	
	if(count($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) == '0'){
		echo "<script>alert('Não existem produtos no carrinho de compras')</script>";
		echo "<script>window.location = 'meu_carrinho.php'</script>";
		}else{
			$insert_pedido = "INSERT INTO App_OrcaTrata(idTab_Modulo,
														idTab_TipoRD,
														idApp_Cliente,
														idSis_Usuario,
														Associado,
														idSis_Empresa,
														DataOrca, 
														DataVencimentoOrca, 
														pedido_data_hora, 
														ValorOrca, 
														ValorRestanteOrca,
														QtdParcelasOrca,
														pedido_status,
														TipoFinanceiro,
														Modalidade,
														FormaPagamento,
														AVAP,
														Tipo_Orca,
														TipoFrete,
														TipoFretePagSeguro,
														CombinadoFrete,
														ValorFrete,
														PrazoEntrega,
														DataEntregaOrca,
														HoraEntregaOrca,
														Cep,
														Logradouro,
														Numero,
														Complemento,
														Bairro,
														Cidade,
														Estado,
														Descricao,
														ValorDinheiro,
														AprovadoOrca) 
												VALUES(	'1',
														'2',
														'".$_SESSION['id_Cliente'.$idSis_Empresa]."',
														'".$usuario."',
														'".$usuario."',
														'".$idSis_Empresa."',
														'".date('Y-m-d')."',
														'".date('Y-m-d')."',
														'".date('Y-m-d H:i:s')."',
														'0',
														'0',
														'1',
														'0',
														'31',
														'P',
														'".$formapagamento."',
														'".$localpagamento."',
														'O',
														'".$tipofrete."',
														'".$tipofretepagseguro."',
														'".$combinadofrete."',
														'".$valorfrete."',
														'".$prazoentrega."',
														'".$dataentrega."',
														'".date('H:i:s', strtotime('+1 hour'))."',
														'".$cep."',
														'".$logradouro1."',
														'".$numero."',
														'".$complemento1."',
														'".$bairro."',
														'".$cidade."',
														'".$estado."',
														'".$descricao."',
														'".$valordinheiro."',
														'N')";
			mysqli_query($conn, $insert_pedido);
			
			$id_pedido = mysqli_insert_id($conn);
			
            if ($id_pedido === FALSE) {
				echo "<script>alert('Ocorreu um erro ao finalizar o pedido')</script>";                
				echo "<script>window.location = 'meu_carrinho.php'</script>";
            } else {			
				$total_venda = '0';
				$valor_comissao = '0';
				$qtd_produtoorca = '0';
				foreach($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]] as $id_produto => $qtd_produto){
					/*
					echo "<pre>";
					print_r($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]);
					echo "</pre>";
					exit();
					*/
					$read_produto_carrinho = mysqli_query($conn, "
					SELECT 
						EMP.ComissaoEnkontraki,
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
						TV.ComissaoVenda,
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
					if(mysqli_num_rows($read_produto_carrinho) > '0'){
						foreach($read_produto_carrinho as $read_produto_carrinho_view);
							$prod_serv = $read_produto_carrinho_view['Prod_Serv'];
							$nome_produtos = $read_produto_carrinho_view['NomeProdutos'];
							$opicao2 = $read_produto_carrinho_view['Opcao2'];
							$opicao1 = $read_produto_carrinho_view['Opcao1'];
							$nome_convdesc = $read_produto_carrinho_view['Convdesc'];
							$qtd_incremento = $read_produto_carrinho_view['QtdProdutoIncremento'];
							$nome_produto = $nome_produtos.' - '.$opicao2.' - '.$opicao1.' - '.$nome_convdesc;
							$id_produto_tab_produto = $read_produto_carrinho_view['idProduto'];
							$sub_total_qtd_produto = $qtd_produto * $qtd_incremento;
							$qtd_produtoorca += $sub_total_qtd_produto;
							$sub_total_produto_carrinho = $qtd_produto * $read_produto_carrinho_view['ValorProduto'];
							$total_venda += $sub_total_produto_carrinho;
							//$sub_total_comissao = $qtd_produto * $read_produto_carrinho_view['ValorProduto'] * $read_produto_carrinho_view['Comissao'] / 100;
							$sub_total_comissao = $qtd_produto * $read_produto_carrinho_view['ValorProduto'] * $read_produto_carrinho_view['ComissaoVenda'] / 100;
							$valor_comissao += $sub_total_comissao;
							$valor_fatura = $total_venda + $valorfrete;
							$valor_troco = $valordinheiro - $valor_fatura;
							if($valor_troco > 0){
								$valor_troco_final = $valor_troco;
							}else{
								$valor_troco_final = 0.00;
							}
							$valor_gateway = ($valor_fatura * 0.04) + 0.40;
							$comissaoenkontraki = $read_produto_carrinho_view['ComissaoEnkontraki'];
							//$valor_enkontraki = $total_venda * 0.04;
							$valor_enkontraki = $total_venda * $comissaoenkontraki;
							$valor_empresa = $valor_fatura - $valor_comissao - $valor_gateway - $valor_enkontraki;
					
					}
					$insert_itens_pedido = "INSERT INTO App_Produto(idApp_Cliente,
																	idSis_Usuario,
																	idSis_Empresa,
																	idApp_OrcaTrata,
																	idTab_Produto,
																	idTab_Valor_Produto,
																	idTab_Produtos_Produto,
																	QtdProduto,
																	QtdIncrementoProduto,
																	ValorProduto,
																	NomeProduto,
																	ComissaoProduto,
																	DataValidadeProduto,
																	ConcluidoProduto,
																	idTab_TipoRD,
																	Prod_Serv_Produto,
																	itens_pedido_valor_total) 
															VALUES('".$_SESSION['id_Cliente'.$idSis_Empresa]."',
																	'".$usuario."',
																	'".$idSis_Empresa."',
																	'".$id_pedido."',
																	'".$id_produto."',
																	'".$id_produto."',
																	'".$id_produto_tab_produto."',
																	'".$qtd_produto."',
																	'".$qtd_incremento."',
																	'".$read_produto_carrinho_view['ValorProduto']."',
																	'".$nome_produto."',
																	'".$read_produto_carrinho_view['ComissaoVenda']."',
																	'".date('Y-m-d')."',
																	'N',
																	'2',
																	'".$prod_serv."',
																	'".$sub_total_produto_carrinho."')";
					mysqli_query($conn, $insert_itens_pedido);
				}
				$insert_parcela = "INSERT INTO App_Parcelas(idTab_Modulo,
															idTab_TipoRD,
															Quitado,
															DataVencimento,
															ValorParcela,
															Parcela,
															idApp_Cliente,
															idSis_Usuario,
															idSis_Empresa,
															idApp_OrcaTrata) 
													VALUES('1',
															'2',
															'N',
															'".date('Y-m-d')."',
															'".$valor_fatura."',
															'1/1',
															'".$_SESSION['id_Cliente'.$idSis_Empresa]."',
															'".$usuario."',
															'".$idSis_Empresa."',
															'".$id_pedido."')";
				mysqli_query($conn, $insert_parcela);			
				$update_pedido = "UPDATE 
									App_OrcaTrata 
								SET 
									QtdPrdOrca = '".$qtd_produtoorca."',
									ValorOrca = '".$total_venda."', 
									ValorRestanteOrca = '".$total_venda."',
									ValorTotalOrca = '".$valor_fatura."',
									ValorTroco = '".$valor_troco_final."',
									ValorFatura = '".$valor_fatura."',
									ValorGateway = '".$valor_gateway."',
									ValorComissao = '".$valor_comissao."',
									ValorEnkontraki = '".$valor_enkontraki."',
									ValorEmpresa = '".$valor_empresa."'
								WHERE 
									idApp_OrcaTrata = '".$id_pedido."'
								";
				mysqli_query($conn, $update_pedido);
			}
			unset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]); 
			unset($_SESSION['total_produtos'.$_SESSION['id_Cliente'.$idSis_Empresa]]);			
			//session_destroy($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]);
			//header("Location: meus_pedidos.php");
			//echo "<script>alert('Pedido Finalizado')</script>";
			//echo '<script> window.location = "entrega.php?id='.$id_pedido.'" </script>';			
			if($localpagamento == "O" && ($tipofrete == 1 || $tipofrete == 3)){
				echo '<script> window.location = "pagar.php?id='.$id_pedido.'" </script>';
			}else{
				echo "<script>window.location = 'meus_pedidos.php'</script>";			
			}			

		}
	
?>
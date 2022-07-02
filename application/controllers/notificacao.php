<?php

if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){	


	$notificationCode = preg_replace('/[^[:alnum:]-]/','',$_POST["notificationCode"]);
	
	$data['email'] = EMAIL_PAGSEGURO;	
	$data['token'] = TOKEN_PAGSEGURO;
	

	$data = http_build_query($data);

	$url = URL_NOTIFICACAO_PAGSEGURO.$_POST["notificationCode"].'?'.$data;
	
	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
	//curl_setopt($curl, CURLOPT_URL, $url);
	//curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

	$Retorno = curl_exec($curl);

	curl_close($curl);

	$xml = simplexml_load_string($Retorno);

	if(isset($xml->reference) && isset($xml->status)){
		
		$query_pedido = "SELECT * FROM App_OrcaTrata WHERE idApp_OrcaTrata = '" . $xml->reference . "' ";

		$resultado_pedido = $pdo->prepare($query_pedido);
		$resultado_pedido->execute();

		$row_pedido = $resultado_pedido->fetch(PDO::FETCH_ASSOC);
		$canceladoorca = $row_pedido['CanceladoOrca'];
		$combinadofrete = $row_pedido['CombinadoFrete'];
		$aprovadoorca = $row_pedido['AprovadoOrca'];
		$quitadoorca = $row_pedido['QuitadoOrca'];
		$id_cliente = $row_pedido['idApp_Cliente'];
		$id_empresa = $row_pedido['idSis_Empresa'];
	
	
		if(isset($canceladoorca) && $canceladoorca == "N"){
			
			$curl=$pdo->prepare("update App_OrcaTrata set status=? where idApp_OrcaTrata=?");
			$curl->bindValue(1,$xml->status);
			$curl->bindValue(2,$xml->reference);	
			$curl->execute();
			
			if($xml->status == '3' || $xml->status == '4' || $xml->status == '5'){	
					
				$curl2=$pdo->prepare("update App_OrcaTrata set AprovadoOrca=?, QuitadoOrca=?  where idApp_OrcaTrata=?");
				$curl2->bindValue(1,S);
				$curl2->bindValue(2,S);
				$curl2->bindValue(3,$xml->reference);	
				$curl2->execute();
				
				$curl3=$pdo->prepare("update App_Parcelas set Quitado=?, DataPago=?, DataLanc=?  where idApp_OrcaTrata=?");
				$curl3->bindValue(1,S);
				$curl3->bindValue(2,date('Y-m-d', strtotime('+1 month')));
				$curl3->bindValue(3,date('Y-m-d'));
				$curl3->bindValue(4,$xml->reference);	
				$curl3->execute();				
				
				if(isset($quitadoorca) && $quitadoorca == "N"){
					
					$result_cashback = "SELECT 
											ValorComissaoCashBack
										FROM 
											App_Produto 
										WHERE 
											idApp_OrcaTrata = '" . $xml->reference . "' 
										";
					$resultado_cashback = $pdo->prepare($result_cashback);
					$resultado_cashback->execute();
					$valor_cashback_pedido = 0;
					while ($row_cashback = $resultado_cashback->fetch(PDO::FETCH_ASSOC)) {
						$valor_cashback_produto = $row_cashback['ValorComissaoCashBack'];
						$valor_cashback_pedido += $valor_cashback_produto;
					}
					
					$result_cliente = "SELECT 
											CashBackCliente,
											ValidadeCashBack
										FROM 
											App_Cliente 
										WHERE 
											idApp_Cliente = '" . $id_cliente . "'
										";
					$resultado_cliente = $pdo->prepare($result_cliente);
					$resultado_cliente->execute();
					$row_cliente = $resultado_cliente->fetch(PDO::FETCH_ASSOC);
					
					$validade = $row_cliente['ValidadeCashBack'];
					$data_hoje = date('Y-m-d', time());
					
					if(strtotime($validade) >= strtotime($data_hoje)){
						$valor_cashback_cliente = $row_cliente['CashBackCliente'];
					}else{
						$valor_cashback_cliente	= 0.00;
					}
					
					$valor_cashback_final = $valor_cashback_pedido + $valor_cashback_cliente;
					
					$result_empresa = "SELECT 
											PrazoCashBackEmpresa
										FROM 
											Sis_Empresa 
										WHERE 
											idSis_Empresa = '" . $id_empresa . "'
										LIMIT 1
										";
					$resultado_empresa = $pdo->prepare($result_empresa);
					$resultado_empresa->execute();
					$row_empresa = $resultado_empresa->fetch(PDO::FETCH_ASSOC);					
					
					$prazo_validade = $row_empresa['PrazoCashBackEmpresa'];
					
					$nova_validade = date('Y-m-d', strtotime('+' . $prazo_validade . ' day'));
					
					$update_id_cliente = "UPDATE 
											App_Cliente 
										SET 
											CashBackCliente 	= '".$valor_cashback_final."',
											ValidadeCashBack 	= '".$nova_validade."'
										WHERE 
											idApp_Cliente = '".$id_cliente."'
										";
					$retorna_id_cliente = $pdo->prepare($update_id_cliente);
					$retorna_id_cliente->execute();
				}
				
				if(isset($aprovadoorca) && $aprovadoorca == "N"){
				
					if(isset($combinadofrete) && $combinadofrete == "S"){
					
						$result_produtos = "SELECT * 
											FROM 
												App_Produto 
											WHERE 
												idApp_OrcaTrata = '" . $xml->reference . "' AND 
												ConcluidoProduto = 'N'
											";
						$resultado_produtos = $pdo->prepare($result_produtos);
						$resultado_produtos->execute();
						//$count_produtos = $resultado_produtos->fetchAll();
						//$contagem_produtos = count($count_produtos);
						
						$cont_item = 1;
						while ($row_produtos = $resultado_produtos->fetch(PDO::FETCH_ASSOC)) {
							$id_produto = $row_produtos['idTab_Produtos_Produto'];
							$qtd_vendida = $row_produtos['QtdProduto'] * $row_produtos['QtdIncrementoProduto'];
							
							
							$result_id_produto = "SELECT * 
													FROM 
														Tab_Produtos
													WHERE 
														idTab_Produtos = '" . $id_produto . "'
													LIMIT 1";						
							
							$resultado_id_produto = $pdo->prepare($result_id_produto);
							$resultado_id_produto->execute();
							//$count_id_produto = $resultado_id_produto->fetchAll();
							//$contagem_id_produto = count($count_id_produto);
							
							
								$row_id_produto = $resultado_id_produto->fetch(PDO::FETCH_ASSOC);
								if($row_id_produto['ContarEstoque'] == "S"){
									$qtd_estoque = $row_id_produto['Estoque'];
									$dif_estoque = $qtd_estoque - $qtd_vendida;
									if($dif_estoque > 0){
										$atual_estoque = $dif_estoque;
									}else{
										$atual_estoque = 0;
									}
								
									$update_id_produto = "UPDATE 
															Tab_Produtos 
														SET 
															Estoque = '".$atual_estoque."'
														WHERE 
															idTab_Produtos = '".$id_produto."'
														";
									$retorna_id_produto = $pdo->prepare($update_id_produto);
									$retorna_id_produto->execute();
									
								}
								
							$cont_item++;
						}
							
					}
				}
				
			}else if($xml->status == '1' || $xml->status == '2' || $xml->status == '6' || $xml->status == '7' || $xml->status == '8' || $xml->status == '9'){
				
				$curl2=$pdo->prepare("update App_OrcaTrata set AprovadoOrca=?, QuitadoOrca=? where idApp_OrcaTrata=?");
				$curl2->bindValue(1,N);
				$curl2->bindValue(2,N);
				$curl2->bindValue(3,$xml->reference);	
				$curl2->execute();
				
				$curl3=$pdo->prepare("update App_Parcelas set Quitado=? where idApp_OrcaTrata=?");
				$curl3->bindValue(1,N);
				$curl3->bindValue(2,$xml->reference);	
				$curl3->execute();		
			}
		}
			
	}
}
<?php 

	if(isset($_GET['tipo']) && isset($_GET['id']) ){	
		
		$id_valor = addslashes($_GET['id']);
		
		$id_promocao = addslashes($_GET['promocao']);
		
		$qtd_carrinho = addslashes($_GET['qtd']);
		
		$somar = addslashes($_GET['somar']);
			
		if($_GET['tipo'] > '1'){
			


			$read_id_valor = mysqli_query($conn, "
			SELECT 
				TV.idTab_Promocao,
				TV.QtdProdutoDesconto,
				TV.QtdProdutoIncremento,
				TV.idTab_Valor
			FROM 
				Tab_Valor AS TV
			WHERE 
				TV.idTab_Valor = '".$id_valor."' AND
				TV.AtivoPreco = 'S' AND
				TV.VendaSitePreco = 'S'

			");
			
			if(mysqli_num_rows($read_id_valor) > '0'){
				foreach($read_id_valor as $read_id_valor_view){
					$qtd_promocao_id_valor 	= $read_id_valor_view['QtdProdutoDesconto'];
					$qtd_incremento_id_valor 	= $read_id_valor_view['QtdProdutoIncremento'];
				}	

				$read_produto = mysqli_query($conn, "
				SELECT 
					TV.idTab_Promocao,
					TV.QtdProdutoDesconto,
					TV.QtdProdutoIncremento,
					TV.idTab_Valor
				FROM 
					Tab_Valor AS TV
				WHERE 
					TV.idTab_Promocao = '".$id_promocao."' 

				");
				
				//Adicionando Produto
				if(mysqli_num_rows($read_produto) > '0'){
					foreach($read_produto as $read_produto_view){
						$id_produto 	= $read_produto_view['idTab_Valor']; 
						$qtd_promocao 	= $read_produto_view['QtdProdutoDesconto'];//quantidade , mínima, do produto, no carrinho
						$qtd_incremento = $read_produto_view['QtdProdutoIncremento'];
						if($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]][$id_produto]){
							
							if($somar == '0'){
								
								unset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]][$id_produto]);
							
							}else if($somar == '2'){	
								
								$_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]][$id_produto] += 1;
							
							}else if($somar == '1'){

								if($qtd_carrinho <= $qtd_promocao_id_valor){
									unset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]][$id_produto]);
								}else{
									$_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]][$id_produto] -= 1;
								}
							} 
						}
						header("Location: meu_carrinho.php");
					}
					
				} else {
					header("Location: meu_carrinho.php");
				}
				
			}else{
				header("Location: meu_carrinho.php");
			}	
		
		}else{
			

			$read_id_valor = mysqli_query($conn, "
			SELECT 
				TV.idTab_Promocao,
				TV.QtdProdutoDesconto,
				TV.QtdProdutoIncremento,
				TV.idTab_Valor
			FROM 
				Tab_Valor AS TV
			WHERE 
				TV.idTab_Valor = '".$id_valor."' AND
				TV.AtivoPreco = 'S' AND
				TV.VendaSitePreco = 'S'

			");
			
			if(mysqli_num_rows($read_id_valor) > '0'){
				foreach($read_id_valor as $read_id_valor_view){
					$qtd_promocao_id_valor 	= $read_id_valor_view['QtdProdutoDesconto'];//quantidade , mínima, do produto, no carrinho
					$qtd_incremento_id_valor 	= $read_id_valor_view['QtdProdutoIncremento'];
				}
			
				if($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]][$_GET['id']]){	
					
					if($somar == '0'){
						
						unset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]][$_GET['id']]);
					
					}else if($somar == '2'){	
						
						$_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]][$_GET['id']] += 1;
					
					}else if($somar == '1'){

						if($qtd_carrinho <= $qtd_promocao_id_valor){
							unset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]][$_GET['id']]);
						}else{
							$_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]][$_GET['id']] -= 1;
						}
					} 
				} 
				
				header("Location: meu_carrinho.php");
			}
			header("Location: meu_carrinho.php");
		}
	} else {
		header("Location: meu_carrinho.php");
	}

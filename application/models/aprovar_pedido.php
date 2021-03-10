<?php 
	if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){
		
		$cliente = $_SESSION['id_Cliente'.$idSis_Empresa];
		
		if($_GET['id']){
			
			$id_pedido = addslashes($_GET['id']);
			
			$result_pedido = "SELECT *
								FROM 
									App_OrcaTrata 
								WHERE 
									idApp_OrcaTrata = '".$id_pedido."' AND
									idApp_Cliente = '".$cliente."' AND
									idSis_Empresa = '" .$idSis_Empresa. "'
								LIMIT 1";
			$resultado_pedido = mysqli_query($conn, $result_pedido);
			$row_pedido = mysqli_fetch_array($resultado_pedido, MYSQLI_ASSOC);
			$count = mysqli_num_rows($resultado_pedido);
			
			if($count ==0){
				header("Location: meus_pedidos.php");
			}else{
				
				$update_pedido = "UPDATE 
									App_OrcaTrata 
								SET 
									AprovadoOrca = 'S'
								WHERE 
									idApp_OrcaTrata = '".$id_pedido."'
								";
				$retorna_pedido = mysqli_query($conn, $update_pedido);

				$result_produtos = 'SELECT * 
									FROM 
										App_Produto 
									WHERE 
										idApp_OrcaTrata = ' . $id_pedido . ' AND 
										ConcluidoProduto = "N"
									';
				$resultado_produtos = mysqli_query($conn, $result_produtos);
				$count_produtos = mysqli_num_rows($resultado_produtos);
				
				if($count_produtos > '0'){
					foreach($resultado_produtos as $resultado_produtos_view){
						$qtd_vendida = $resultado_produtos_view['QtdProduto'] * $resultado_produtos_view['QtdIncrementoProduto'];
						$id_produto = $resultado_produtos_view['idTab_Produtos_Produto'];
						$result_id_produto = 'SELECT * 
												FROM 
													Tab_Produtos
												WHERE 
													idTab_Produtos = ' . $id_produto . '
												LIMIT 1';
						$resultado_id_produto = mysqli_query($conn, $result_id_produto);
						$row_id_produto = mysqli_fetch_array($resultado_id_produto, MYSQLI_ASSOC);
						$count_id_produto = mysqli_num_rows($resultado_id_produto);
						
						if($count_id_produto > 0){
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
								$retorna_id_produto = mysqli_query($conn, $update_id_produto);
							}
						}
						/*
						if(mysqli_affected_rows($conn) != 0){
							echo true;
						}else{
							echo false;
						}						
						*/
						/*
						echo '<br>';
						echo "<pre>";
						print_r($id_produto);
						echo '<br>';
						print_r($qtd_vendida);
						echo '<br>';
						print_r($qtd_estoque);
						echo '<br>';
						print_r($atual_estoque);
						echo "</pre>";		
						*/
					}
				}
				

				//exit ();
				
				echo "<script>window.location = 'meus_pedidos.php'</script>";
			}
		}else{
			$_SESSION['msg'] = "Página não encontrada";
			header("Location: meus_pedidos.php");
		}	
	}else{
		$_SESSION['msg'] = "Página não encontrada";
		header("Location: login_cliente.php");
	}
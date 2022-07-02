<?php
	if(isset($_GET['id_Session'])){	
		$id_Session = addslashes($_GET['id_Session']);
		if (empty($_SESSION['Site_Back']['cart'][$id_Session])) {
			$_SESSION['Site_Back']['cart'][$id_Session] = [];
		}
		array_push($_SESSION['Site_Back']['cart'][$id_Session], $_POST);
		/*
		echo "<pre>";
		   print_r($_SESSION['Site_Back']['cart']);
		echo "</pre>";
		
		foreach ($_SESSION['Site_Back']['cart'] as $key => $value) :
		  // echo "INSERT INTO teste (nome, dinheiro) VALUES (" . $value["name"] . ", " . $value["money"] . ")";
			
			echo "<pre>";
				echo $value['qtd'];
			echo "</pre>";
			
		endforeach;
		
		foreach ($_SESSION['Site_Back']['cart'][$id_Session] as $value) :
		  // echo "INSERT INTO teste (nome, dinheiro) VALUES (" . $value["name"] . ", " . $value["money"] . ")";
			
			echo "<pre>";
				echo $value['qtd'];
				echo $value['valor'];
			echo "</pre>";
			
		endforeach;		
		*/
	}
   
   
	if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){	
		
		if(!isset($_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]])){
			//$_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]] = array();
			$_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]] = [];
		}
	
		$cliente = $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];
	}
	
	if(isset($_GET['carrinho']) && isset($_GET['id'])){	
		
		if($_GET['carrinho'] == 'produto'){
			$id_valor = addslashes($_GET['id']);
			
			$read_produto = mysqli_query($conn, "
			SELECT 
				TP.idTab_Produtos,
				TP.Nome_Prod,
				TP.idSis_Empresa,
				TP.Arquivo,
				TP.VendaSite,
				TP.ValorProdutoSite,
				TV.idTab_Valor,
				TV.QtdProdutoDesconto,
				TV.QtdProdutoIncremento,
				TV.ValorProduto
			FROM 
				Tab_Produtos AS TP
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produtos = TP.idTab_Produtos
					WHERE 
				TV.idTab_Valor = '".$id_valor."' AND
				TV.AtivoPreco = 'S' AND
				TV.VendaSitePreco = 'S'
			ORDER BY 
				TV.idTab_Valor ASC	
			");
			
			//Adicionando Produto
			if(mysqli_num_rows($read_produto) > '0'){
				foreach($read_produto as $read_produto_view){
					$id_produto 	= $read_produto_view['idTab_Produtos']; 
					$qtd_produto 	= $read_produto_view['QtdProdutoDesconto']; // Passo a quantidade , mínima, que vem junto com o produto
					$qtd_incremento 	= $read_produto_view['QtdProdutoIncremento'];// Passo a quantidade, da embalagem,  que vem junto com o produto
					$valor_prod		= $read_produto_view['ValorProduto'];
				}
				if($_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]][$id_valor]){
					$_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]][$id_valor] += 1;
				}else{
					$_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]][$id_valor] = $qtd_produto;
				}
				header("Location: meu_carrinho.php");
				//header("Location: produtos.php");
			}			
		}

		if($_GET['carrinho'] == 'promocao'){
			$id_promocao = addslashes($_GET['id']);

			$read_promocao = mysqli_query($conn, "
			SELECT 
				TPM.idTab_Promocao,
				TPM.Promocao,
				TPM.Arquivo,
				TPM.Desconto,
				TV.idTab_Valor
			FROM 
				Tab_Promocao AS TPM
				LEFT JOIN Tab_Valor AS TV ON TV.idTab_Promocao = TPM.idTab_Promocao
			WHERE 
				TPM.idTab_Promocao = '".$id_promocao."' 
			ORDER BY 
				TPM.Desconto ASC	
			");
			if(mysqli_num_rows($read_promocao) > '0'){
				foreach($read_promocao as $read_promocao_view){
					$id_valor 	= $read_promocao_view['idTab_Valor']; 
					$read_produto = mysqli_query($conn, "
					SELECT 
						TP.idTab_Produtos,
						TP.Nome_Prod,
						TP.idSis_Empresa,
						TP.Arquivo,
						TP.VendaSite,
						TP.ValorProdutoSite,
						TV.idTab_Promocao,
						TV.idTab_Valor,
						TV.QtdProdutoDesconto,
						TV.QtdProdutoIncremento,
						TV.ValorProduto
					FROM 
						Tab_Produtos AS TP
							LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produtos = TP.idTab_Produtos
					WHERE 
						TV.idTab_Valor = '".$id_valor."' AND
						TV.AtivoPreco = 'S' AND
						TV.VendaSitePreco = 'S' 
					ORDER BY 
						TV.idTab_Valor ASC	
						");
				
					//Adicionando Produto
					if(mysqli_num_rows($read_produto) > '0'){
						foreach($read_produto as $read_produto_view){
							$id_produto 	= $read_produto_view['idTab_Produtos']; 
							$qtd_produto 	= $read_produto_view['QtdProdutoDesconto']; 
							$qtd_incremento 	= $read_produto_view['QtdProdutoIncremento'];// Passo a quantidade que vem junto com o produto
						}
						if($_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]][$id_valor]){
							$_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]][$id_valor] += 1;
						}else{
							$_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]][$id_valor] = $qtd_produto;
						}
						header("Location: meu_carrinho.php");
						//header("Location: promocao.php");
					}
				}
			}
		}
	}	
	
	if(isset($_GET['acao'])){
		//ALTERAR Quantidade
		if($_GET['acao'] == 'up-produtos'){
			
			if(is_array($_POST['prod'])){
				
				foreach($_POST['prod'] as $id_produto_carrinho => $quantidade_produto_carrinho ){
					
					$id_produto_carrinho = intval($id_produto_carrinho);
					
					$quantidade_produto_carrinho = intval($quantidade_produto_carrinho);
					
					if(!empty($quantidade_produto_carrinho) || $quantidade_produto_carrinho <> 0){
						
						$_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]][$id_produto_carrinho] = $quantidade_produto_carrinho;
					
					}else{
						unset($_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]][$id_produto_carrinho]);
					
					}
					header("Location: produtos.php"); // Preciso redirecionar para o para os produtos, porque senão a quantidade não é atualizada.
					//header("Location: entrega.php"); // vou pensar numa forma de separar os bot~es, separando as funções.
				}
			}
		}
		
		if($_GET['acao'] == 'up-entrega'){
			
			if(is_array($_POST['prod'])){
				
				foreach($_POST['prod'] as $id_produto_carrinho => $quantidade_produto_carrinho ){
					
					$id_produto_carrinho = intval($id_produto_carrinho);
					
					$quantidade_produto_carrinho = intval($quantidade_produto_carrinho);
					
					if(!empty($quantidade_produto_carrinho) || $quantidade_produto_carrinho <> 0){
						
						$_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]][$id_produto_carrinho] = $quantidade_produto_carrinho;
					
					}else{
						unset($_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]][$id_produto_carrinho]);
					
					}
					//header("Location: produtos.php"); // Preciso redirecionar para o para os produtos, porque senão a quantidade não é atualizada.
					header("Location: entrega.php"); // vou pensar numa forma de separar os bot~es, separando as funções.
				}
			}
		}
	}
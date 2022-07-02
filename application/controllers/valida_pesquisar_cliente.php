<?php
if(isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa]) && !isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){
	$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);
	if($btnLogin){
		
		$id_cliente = filter_input(INPUT_POST, 'idApp_Cliente', FILTER_SANITIZE_STRING);

		if(empty($id_cliente)){
			$erro = true;
			$msg = "Nenhum Cliente Selecionado";
		}elseif (!is_numeric($id_cliente)) {
			$erro = true;
			$msg = "Nenhum Cliente Selecionado";
		}else{
			$erro = false;
		}
		
		if($erro == false){
			/*
			echo "<br>";
			echo "<pre>";
			print_r($id_cliente);
			echo "</pre>";
			*/
			//Pesquiso se existe o cliente na empresa
			$result_cliente = "SELECT 
									idApp_Cliente,
									idSis_Associado,
									NomeCliente,
									Email,
									CelularCliente,
									CepCliente,
									EnderecoCliente,
									NumeroCliente,
									ComplementoCliente,
									BairroCliente,
									CidadeCliente,
									EstadoCliente,
									Arquivo	
								FROM 
									App_Cliente 
								WHERE
									idSis_Empresa = '" .$idSis_Empresa. "' AND
									idApp_Cliente = '" .$id_cliente. "'
								LIMIT 1";
			$resultado_cliente = mysqli_query($conn, $result_cliente);
			$row_cliente = mysqli_fetch_array($resultado_cliente, MYSQLI_ASSOC);
			$count_cliente = mysqli_num_rows($resultado_cliente);
			
			if($count_cliente == 0){	
				//Cliente Encontrado? NÃO.
				//Cadastrar o cliente na Plataforma
				$_SESSION['Site_Back']['msg'] = "Cliente Não Cadastrado na Plataforma!";
				header("Location: cadastrar_cliente_pesquisar.php");
				
			}else{

				$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa] = $row_cliente['idApp_Cliente'];
				$_SESSION['Site_Back']['id_Associado'.$idSis_Empresa] = $row_cliente['idSis_Associado'];
				$_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa] = $row_cliente['NomeCliente'];
				$_SESSION['Site_Back']['Email_Cliente'.$idSis_Empresa] = $row_cliente['Email'];
				$_SESSION['Site_Back']['CelularCliente'.$idSis_Empresa] = $row_cliente['CelularCliente'];
				$_SESSION['Site_Back']['Cep_Cliente'.$idSis_Empresa] = $row_cliente['CepCliente'];
				$_SESSION['Site_Back']['Endereco_Cliente'.$idSis_Empresa] = $row_cliente['EnderecoCliente'];
				$_SESSION['Site_Back']['Numero_Cliente'.$idSis_Empresa] = $row_cliente['NumeroCliente'];
				$_SESSION['Site_Back']['Complemento_Cliente'.$idSis_Empresa] = $row_cliente['ComplementoCliente'];
				$_SESSION['Site_Back']['Bairro_Cliente'.$idSis_Empresa] = $row_cliente['BairroCliente'];
				$_SESSION['Site_Back']['Cidade_Cliente'.$idSis_Empresa] = $row_cliente['CidadeCliente'];
				$_SESSION['Site_Back']['Estado_Cliente'.$idSis_Empresa] = $row_cliente['EstadoCliente'];
				$_SESSION['Site_Back']['Arquivo_Cliente'.$idSis_Empresa] = $row_cliente['Arquivo'];
				
				//como estou buscando um cliente pelo vendedor, então garanto que não vai existir assocoado
				if(isset($_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa])){
					unset($_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa], 
							$_SESSION['Site_Back']['Nome_Usuario'.$idSis_Empresa], 
							$_SESSION['Site_Back']['Arquivo_Usuario'.$idSis_Empresa]);
				}else{
					//Não faço nada
				}					
									 
				if(isset($_SESSION['Site_Back']['carrinho'.$idSis_Empresa])){
					header("Location: meu_carrinho.php");			
				}else{	
					//header("Location: produtos.php");
					header("Location: index.php");
				}
					
			}
			
		}else{
			
			$_SESSION['Site_Back']['msg'] = $msg;
			header("Location: pesquisar_cliente.php");
		}
		
	}else{
		$_SESSION['Site_Back']['msg'] = "Página não encontrada";
		header("Location: pesquisar_cliente.php");
	}
}else{
	$_SESSION['Site_Back']['msg'] = "Página não encontrada";
	//header("Location: produtos.php");
	header("Location: index.php");
}	
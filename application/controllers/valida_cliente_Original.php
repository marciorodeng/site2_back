<?php

$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);
if($btnLogin){
	//$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
	$celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
	//echo "$usuario - $senha";
	if((!empty($usuario)) AND (!empty($senha))){
		//Gerar a senha criptografa
		//echo password_hash($senha, PASSWORD_DEFAULT);
		//Pesquisar o usuário no BD
		$result_usuario = "SELECT *

							FROM 
								App_Cliente 
							WHERE 
								CelularCliente = '".$celular."' AND
								senha = '".md5($senha)."' AND
								idSis_Empresa = '" .$idSis_Empresa. "'
							LIMIT 1";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		$row_usuario = mysqli_fetch_array($resultado_usuario, MYSQLI_ASSOC);
		
		$count = mysqli_num_rows($resultado_usuario);
		
		if($count ==0){
			$_SESSION['msg'] = "Login e/ou Senha incorretos!";
			header("Location: login_cliente.php");
		}else{
			$_SESSION['id_Cliente'.$idSis_Empresa] = $row_usuario['idApp_Cliente'];
			$_SESSION['Nome_Cliente'.$idSis_Empresa] = $row_usuario['NomeCliente'];
			$_SESSION['Email_Cliente'.$idSis_Empresa] = $row_usuario['Email'];
			$_SESSION['CelularCliente'.$idSis_Empresa] = $row_usuario['CelularCliente'];
			$_SESSION['Cep_Cliente'.$idSis_Empresa] = $row_usuario['CepCliente'];
			$_SESSION['Endereco_Cliente'.$idSis_Empresa] = $row_usuario['EnderecoCliente'];
			$_SESSION['Numero_Cliente'.$idSis_Empresa] = $row_usuario['NumeroCliente'];
			$_SESSION['Complemento_Cliente'.$idSis_Empresa] = $row_usuario['ComplementoCliente'];
			$_SESSION['Bairro_Cliente'.$idSis_Empresa] = $row_usuario['BairroCliente'];
			$_SESSION['Cidade_Cliente'.$idSis_Empresa] = $row_usuario['CidadeCliente'];
			$_SESSION['Estado_Cliente'.$idSis_Empresa] = $row_usuario['EstadoCliente'];
			
			//header("Location: produtos_cliente.php");
			if(isset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]])){
				header("Location: meu_carrinho.php");			
			}else{	
				//header("Location: index.php");
				//header("Location: inicial.php");
				header("Location: produtos.php");
			}
			
		}		
		/*
		if($resultado_usuario){
			$row_usuario = mysqli_fetch_assoc($resultado_usuario);
			if(password_verify($senha, $row_usuario['senha'])){
				$_SESSION['id_Cliente'.$idSis_Empresa] = $row_usuario['idApp_Cliente'];
				$_SESSION['Nome_Cliente'.$idSis_Empresa] = $row_usuario['NomeCliente'];
				$_SESSION['Email_Cliente'.$idSis_Empresa] = $row_usuario['Email'];
				header("Location: produtos_cliente.php");
			}else{
				$_SESSION['msg'] = "Login e senha incorreto!";
				header("Location: login.php");
			}
		}
		*/
		
	}else{
		$_SESSION['msg'] = "Login e/ou Senha incorretos!";
		header("Location: login_cliente.php");
	}
}else{
	$_SESSION['msg'] = "Página não encontrada";
	header("Location: login_cliente.php");
}

<?php

$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);
if($btnLogin){
	$CelularUsuario = filter_input(INPUT_POST, 'CelularUsuario', FILTER_SANITIZE_STRING);
	$Senha = filter_input(INPUT_POST, 'Senha', FILTER_SANITIZE_STRING);
	//echo "$usuario - $senha";
	if((!empty($CelularUsuario)) AND (!empty($Senha))){
		//Gerar a senha criptografa
		//echo password_hash($senha, PASSWORD_DEFAULT);
		//Pesquisar o usuário no BD
		$result_usuario = "SELECT *

							FROM 
								Sis_Usuario 
							WHERE 
								idSis_Empresa = '5' AND
								CelularUsuario = '".$CelularUsuario."' AND
								Senha = '".md5($Senha)."' 
								
							LIMIT 1";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		$row_usuario = mysqli_fetch_array($resultado_usuario, MYSQLI_ASSOC);
		
		$count = mysqli_num_rows($resultado_usuario);
		
		if($count ==0){
			$_SESSION['msg'] = "Login e/ou Senha incorretos!";
			header("Location: login_associado.php");
		}else{
			$_SESSION['id_Associado'] = $row_usuario['idSis_Usuario'];
			$_SESSION['Nome_Associado'] = $row_usuario['Nome'];
			$_SESSION['Email_Associado'] = $row_usuario['Email'];
			/*
			$_SESSION['Cep_Cliente'.$idSis_Empresa], = $row_usuario['Cep'];
			$_SESSION['Endereco_Cliente'.$idSis_Empresa] = $row_usuario['Endereco'];
			$_SESSION['Numero_Cliente'.$idSis_Empresa] = $row_usuario['Numero'];
			$_SESSION['Complemento_Cliente'.$idSis_Empresa] = $row_usuario['Complemento'];
			$_SESSION['Bairro_Cliente'.$idSis_Empresa] = $row_usuario['Bairro'];
			$_SESSION['Cidade_Cliente'.$idSis_Empresa] = $row_usuario['Cidade'];
			$_SESSION['Estado_Cliente'.$idSis_Empresa] = $row_usuario['Estado'];
			if(isset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]])){
				header("Location: meu_carrinho.php");			
			}else{	
				//header("Location: index.php");
				header("Location: inicial.php");
			}			
			*/
			header("Location: cadastrar_associado.php");
		}
		
	}else{
		$_SESSION['msg'] = "Login e/ou senha incorretos!";
		header("Location: login_associado.php");
	}
}else{
	$_SESSION['msg'] = "Página não encontrada";
	header("Location: login_associado.php");
}

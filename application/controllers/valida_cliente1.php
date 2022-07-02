<?php

$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);
if($btnLogin){
	$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
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
								usuario = '".$usuario."' AND
								senha = '".md5($senha)."' AND
								idSis_Empresa = '5'
							LIMIT 1";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		$row_usuario = mysqli_fetch_array($resultado_usuario, MYSQLI_ASSOC);
		
		$count = mysqli_num_rows($resultado_usuario);
		
		if($count ==0){
			$_SESSION['msg'] = "Login e Senha incorreto!";
			header("Location: login_cliente.php");
		}else{
			$_SESSION['id_Cliente'] = $row_usuario['idApp_Cliente'];
			$_SESSION['Nome_Cliente'] = $row_usuario['NomeCliente'];
			$_SESSION['Email_Cliente'] = $row_usuario['Email'];
			
			$_SESSION['Cep_Cliente'] = $row_usuario['Cep'];
			$_SESSION['Endereco_Cliente'] = $row_usuario['Endereco'];
			$_SESSION['Numero_Cliente'] = $row_usuario['Numero'];
			$_SESSION['Complemento_Cliente'] = $row_usuario['Complemento'];
			$_SESSION['Bairro_Cliente'] = $row_usuario['Bairro'];
			$_SESSION['Cidade_Cliente'] = $row_usuario['Cidade'];
			$_SESSION['Estado_Cliente'] = $row_usuario['Estado'];
			
			//header("Location: produtos_cliente.php");
			if(isset($_SESSION['carrinho'])){
				header("Location: meu_carrinho.php");			
			}else{	
				//header("Location: index.php");
				header("Location: inicial.php");
			}
			
		}		
		/*
		if($resultado_usuario){
			$row_usuario = mysqli_fetch_assoc($resultado_usuario);
			if(password_verify($senha, $row_usuario['senha'])){
				$_SESSION['id_Cliente'] = $row_usuario['idApp_Cliente'];
				$_SESSION['Nome_Cliente'] = $row_usuario['NomeCliente'];
				$_SESSION['Email_Cliente'] = $row_usuario['Email'];
				header("Location: produtos_cliente.php");
			}else{
				$_SESSION['msg'] = "Login e senha incorreto!";
				header("Location: login.php");
			}
		}
		*/
		
	}else{
		$_SESSION['msg'] = "Login e senha incorreto!";
		header("Location: login_cliente.php");
	}
}else{
	$_SESSION['msg'] = "Página não encontrada";
	header("Location: login_cliente.php");
}

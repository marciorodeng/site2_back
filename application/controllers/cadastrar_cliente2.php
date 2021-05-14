<?php
	
ob_start();
$btnCadUsuario = filter_input(INPUT_POST, 'btnCadUsuario', FILTER_SANITIZE_STRING);
if($btnCadUsuario){
	
	
	$dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	
	$erro = false;
	
	$dados_st = array_map('strip_tags', $dados_rc);
	$dados = array_map('trim', $dados_st);
	
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

	$cliente0 = $dados['NomeCliente'];
	$cliente1 = preg_replace("/[^a-zA-Z]/", " ", strtr($cliente0, $caracteres_sem_acento));
	$cliente = trim(mb_strtoupper($cliente1, 'ISO-8859-1'));
	
	if(in_array('',$dados)){
		$erro = true;
		$_SESSION['msg'] = "Necessário preencher todos os campos";
	}elseif((strlen($dados['senha'])) < 4){
		$erro = true;
		$_SESSION['msg'] = "A senha deve ter no minímo 4 caracteres";
	}elseif($dados['senha'] != $dados['confirmar']){
		$erro = true;
		$_SESSION['msg'] = "Confira a senha digitada";
	}elseif(stristr($dados['senha'], "'")) {
		$erro = true;
		$_SESSION['msg'] = "Caracter ( ' ) utilizado na senha é inválido";
	}elseif (!is_numeric($dados['CelularCliente'])) {
		$erro = true;
		$_SESSION['msg'] = "O Celular só pode conter Números";
	}elseif((strlen($dados['CelularCliente'])) != 11){
		$erro = true;
		$_SESSION['msg'] = "O Celular deve conter 11 Números";
	}else{
		/*
			$result_usuario = "SELECT idApp_Cliente FROM App_Cliente WHERE usuario='". $dados['usuario'] ."' AND idSis_Empresa = '" .$idSis_Empresa. "'";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
			$erro = true;
			$_SESSION['msg'] = "Este usuário já está sendo utilizado";
		}
		
		$result_usuario = "SELECT idApp_Cliente FROM App_Cliente WHERE Email='". $dados['Email'] ."'";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
			$erro = true;
			$_SESSION['msg'] = "Este e-mail já está cadastrado";
		}
		*/
		$result_usuario = "SELECT * FROM App_Cliente WHERE CelularCliente='". $dados['CelularCliente'] ."' AND idSis_Empresa = '" .$idSis_Empresa. "'";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
			$erro = true;
			$_SESSION['msg'] = "Este Telefone já está cadastrado na nossa empresa. Entre em contato conosco e solicite o reenvio da sua Senha";
		}
	}
	
	
	//var_dump($dados);
	if(!$erro){
		//var_dump($dados);
		//$dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
		
		$dados['NomeCliente'] = trim(mb_strtoupper($dados['NomeCliente'], 'ISO-8859-1'));
		//$dados['senha'] = md5($dados['senha']);
		$CodInterno = md5(time() . rand());
		$DataCadastroCliente = date('Y-m-d', time());
		$result_usuario = "INSERT INTO App_Cliente (idSis_Empresa, idTab_Modulo, idSis_Usuario_5, NomeCliente, CelularCliente, CodInterno, DataCadastroCliente, LocalCadastroCliente, usuario, senha, Codigo) VALUES (
						'" .$idSis_Empresa. "',
						'1',
						'" .$dados['idSis_Usuario_5']. "',
						'" .$cliente. "',
						'" .$dados['CelularCliente']. "',
						'" .$CodInterno. "',
						'" .$DataCadastroCliente. "',
						'O',
						'" .$dados['CelularCliente']. "',
						'" .$dados['senha']. "',
						'" .$dados['Codigo']. "'
						)";
		$resultado_usario = mysqli_query($conn, $result_usuario);
		if(mysqli_insert_id($conn)){
			unset($_SESSION['Usuario_5'.$idSis_Empresa]); 
			$_SESSION['msgcad'] = "Cliente cadastrado com sucesso";
			header("Location: login_cliente.php");
		}else{
			unset($_SESSION['Usuario_5'.$idSis_Empresa]); 
			$_SESSION['msg'] = "Erro ao cadastrar o Cliente";
		}
	}
	
}	
?>
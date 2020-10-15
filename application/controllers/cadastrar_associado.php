<?php
	
ob_start();
$btnCadUsuario = filter_input(INPUT_POST, 'btnCadUsuario', FILTER_SANITIZE_STRING);
if($btnCadUsuario){
	
	
	$dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	
	$erro = false;
	
	$dados_st = array_map('strip_tags', $dados_rc);
	$dados = array_map('trim', $dados_st);
	
	if(in_array('',$dados)){
		$erro = true;
		$_SESSION['msg'] = "Necessário preencher todos os campos";
	}else{
		$result_usuario = "SELECT idSis_Usuario_Online FROM Sis_Usuario_Online WHERE idSis_Empresa='". $dados['idSis_Empresa'] ."' AND idSis_Usuario = '". $dados['idSis_Usuario'] ."'";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
			
			$erro = true;
			$_SESSION['msg'] = "Este usuário já está cadastrado nesta empresa!";
			header("Location: cadastro_realizado.php?emp=".$dados['idSis_Empresa']."&usuario=".$dados['idSis_Usuario']."");
		}
	}
	
	//var_dump($dados);
	if(!$erro){
		$codigo = md5(uniqid(time() . rand()));
		$result_usuario = "INSERT INTO Sis_Usuario_Online (Inativo, idSis_Empresa, idSis_Usuario, Codigo, DataCriacao) VALUES (
						'1',
						'" .$dados['idSis_Empresa']. "',
						'" .$dados['idSis_Usuario']. "',
						'" .$codigo. "',
						NOW()
						)";
		$resultado_usario = mysqli_query($conn, $result_usuario);
		if(mysqli_insert_id($conn)){
			$_SESSION['msgcad'] = "Solicitação realizada com sucesso";
			/*
			unset(	$_SESSION['id_Associado'], 
					$_SESSION['Nome_Associado'], 
					$_SESSION['Email_Associado']
					);
					*/
			//header("Location: inicial.php");
			header("Location: cadastro_realizado.php?emp=".$dados['idSis_Empresa']."&usuario=".$dados['idSis_Usuario']."");
		}else{
			$_SESSION['msg'] = "Erro ao realizar a solicitação! Entre em contato com a empresa!";
		}
	}
	
}	
?>
<?php
	
ob_start();
$btnCadAssociado = filter_input(INPUT_POST, 'btnCadAssociado', FILTER_SANITIZE_STRING);
if($btnCadAssociado){
	
	
	$dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	
	$erro = false;
	
	$dados_st = array_map('strip_tags', $dados_rc);
	$dados = array_map('trim', $dados_st);
	
	if(in_array('',$dados)){
		$erro = true;
		$_SESSION['Site_Back']['msg'] = "Necessário preencher todos os campos";
	}else{
		$result_usuario = "SELECT idApp_Cliente FROM App_Cliente WHERE idSis_Empresa='". $dados['idSis_Empresa'] ."' AND idSis_Associado = '". $dados['idSis_Associado'] ."'";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
			
			$erro = true;
			$_SESSION['Site_Back']['msg'] = "Este Associado já está cadastrado nesta empresa!";
			header("Location: cadastro_realizado.php?emp=".$dados['idSis_Empresa']."&usuario=".$dados['idSis_Associado']."");
		} else {
		
			$erro = true;
			$_SESSION['Site_Back']['msg'] = "Este usuário ainda não é cliente desta empresa!";
		}
	}
	/*
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
			$_SESSION['Site_Back']['msgcad'] = "Solicitação realizada com sucesso";
			
			unset(	$_SESSION['Site_Back']['id_Associado'], 
					$_SESSION['Site_Back']['Nome_Associado'], 
					$_SESSION['Site_Back']['Email_Associado']
					);
					
			//header("Location: inicial.php");
			header("Location: cadastro_realizado.php?emp=".$dados['idSis_Empresa']."&usuario=".$dados['idSis_Usuario']."");
		}else{
			$_SESSION['Site_Back']['msg'] = "Erro ao realizar a solicitação! Entre em contato com a empresa!";
		}
	}
	*/
	
}	
?>
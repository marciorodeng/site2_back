<?php

$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);
if($btnLogin){
	$CelularUsuario = filter_input(INPUT_POST, 'CelularUsuario', FILTER_SANITIZE_STRING);
	$Senha = filter_input(INPUT_POST, 'Senha', FILTER_SANITIZE_STRING);
	//echo "$usuario - $senha";
	if((!empty($CelularUsuario)) AND (!empty($Senha))){
		//Pesquisar o usuário no BD
		$result_usuario = "SELECT 
								idSis_Usuario
							FROM 
								Sis_Usuario 
							WHERE 
								idSis_Empresa = '".$idSis_Empresa."' AND
								Usuario = '".$CelularUsuario."' AND
								Senha = '".md5($Senha)."'AND
								Inativo = '0' AND
								Vendas = 'S' AND 
								Cad_Orcam = 'S'
							LIMIT 1";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		$row_usuario = mysqli_fetch_array($resultado_usuario, MYSQLI_ASSOC);
		
		$count = mysqli_num_rows($resultado_usuario);
		
		if($count ==0){
			$_SESSION['Site_Back']['msg'] = "Login ou Senha incorretos!<br> Ou o Usuário não tem permissão para adquirir Link!";
			header("Location: login_vendedor.php");
		}else{
			header("Location: link_vendedor.php?emp=".$idSis_Empresa."&usuario=".$row_usuario['idSis_Usuario']."");
		}
	}else{
		$_SESSION['Site_Back']['msg'] = "Login e/ou senha incorretos!";
		header("Location: login_vendedor.php");
	}
}else{
	$_SESSION['Site_Back']['msg'] = "Página não encontrada";
	header("Location: login_vendedor.php");
}

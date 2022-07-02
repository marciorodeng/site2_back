<?php

$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);
if($btnLogin){
	$CelularAssociado = filter_input(INPUT_POST, 'CelularAssociado', FILTER_SANITIZE_STRING);
	$Senha = filter_input(INPUT_POST, 'Senha', FILTER_SANITIZE_STRING);
	//echo "$usuario - $senha";
	if((!empty($CelularAssociado)) AND (!empty($Senha))){
		//Gerar a senha criptografa
		//echo password_hash($senha, PASSWORD_DEFAULT);
		//Pesquisar o usuário no BD
		$result_usuario = "SELECT *
							FROM 
								Sis_Associado 
							WHERE 
								Associado = '".$CelularAssociado."' AND
								Senha = '".md5($Senha)."'
							LIMIT 1";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		$row_usuario = mysqli_fetch_array($resultado_usuario, MYSQLI_ASSOC);
		
		$count = mysqli_num_rows($resultado_usuario);
		
		if($count ==0){
			$_SESSION['Site_Back']['msg'] = "Login e/ou Senha incorretos!";
			header("Location: login_associado.php");
		}else{
			$_SESSION['Site_Back']['id_Associado'] = $row_usuario['idSis_Associado'];
			$_SESSION['Site_Back']['Nome_Associado'] = $row_usuario['Nome'];
			$_SESSION['Site_Back']['Email_Associado'] = $row_usuario['Email'];
			header("Location: cadastrar_associado.php");
		}
		
	}else{
		$_SESSION['Site_Back']['msg'] = "Login e/ou senha incorretos!";
		header("Location: login_associado.php");
	}
}else{
	$_SESSION['Site_Back']['msg'] = "Página não encontrada";
	header("Location: login_associado.php");
}

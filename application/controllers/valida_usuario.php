<?php

$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);
if($btnLogin){
	//$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
	$celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

	if((!empty($celular)) AND (!empty($senha))){

		$result_usuario_senha = "
							SELECT 
								idSis_Usuario,
								Nome,
								Nivel,
								Comissao,
								QuemCad,
								Arquivo
							FROM 
								Sis_Usuario 
							WHERE 
								idSis_Empresa = '" .$idSis_Empresa. "' AND
								Usuario = '".$celular."' AND
								Senha = '".md5($senha)."' AND
								Inativo = '0' AND
								Vendas = 'S' AND 
								Cad_Orcam = 'S'
							LIMIT 1";
		$resultado_usuario_senha = mysqli_query($conn, $result_usuario_senha);
		
		$count_usuario_senha = mysqli_num_rows($resultado_usuario_senha);
		
		if($count_usuario_senha == 0){
			//Senha Usuario correta? NÃO 
			$_SESSION['Site_Back']['msg'] = "Login ou Senha incorretos!<br> Ou o Usuário não tem permissão para logar!";
			header("Location: login_usuario.php");
		
		} else {
			//Senha Usuario correta? SIM 
			$row_usuario_senha = mysqli_fetch_array($resultado_usuario_senha, MYSQLI_ASSOC);
			
			$_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa] = $row_usuario_senha['idSis_Usuario'];
			$_SESSION['Site_Back']['Nome_Usuario_vend'.$idSis_Empresa] = $row_usuario_senha['Nome'];
			$_SESSION['Site_Back']['Nivel_Usuario_vend'.$idSis_Empresa] = $row_usuario_senha['Nivel'];
			$_SESSION['Site_Back']['Arquivo_Usuario_vend'.$idSis_Empresa] = $row_usuario_senha['Arquivo'];

			if($row_usuario_senha['Nivel'] != 2){
				$_SESSION['Site_Back']['Comissao_Usuario_vend'.$idSis_Empresa] = $row_usuario_senha['Comissao'];
			}else{
				$result_funcionario = "
									SELECT 
										idSis_Usuario,
										Nome,
										Nivel,
										Comissao,
										QuemCad,
										Arquivo
									FROM 
										Sis_Usuario 
									WHERE 
										idSis_Empresa = '" .$idSis_Empresa. "' AND
										idSis_Usuario = '".$row_usuario_senha['QuemCad']."' AND
										Inativo = '0' AND
										Vendas = 'S' AND 
										Cad_Orcam = 'S'
									LIMIT 1";
				$resultado_funcionario = mysqli_query($conn, $result_funcionario);
				
				$count_funcionario = mysqli_num_rows($resultado_funcionario);
				
				if($count_funcionario == 0){
					//NÃO Retornou nenhum funcionario
					$_SESSION['Site_Back']['Comissao_Usuario_vend'.$idSis_Empresa] = $row_usuario_senha['Comissao'];
				} else {
					//Retornou funcionario
					$row_funcionario = mysqli_fetch_array($resultado_funcionario, MYSQLI_ASSOC);
					
					$_SESSION['Site_Back']['Comissao_Usuario_vend'.$idSis_Empresa] = $row_funcionario['Comissao'];
				}
			}
				
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
				header("Location: index.php");
			}
		}	
	}else{
		$_SESSION['Site_Back']['msg'] = "Login e/ou Senha incorretos!";
		header("Location: login_usuario.php");
	}
}else{
	$_SESSION['Site_Back']['msg'] = "Página não encontrada";
	header("Location: login_usuario.php");
}

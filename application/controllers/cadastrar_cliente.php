<?php
	
ob_start();
$btnCadUsuario = filter_input(INPUT_POST, 'btnCadUsuario', FILTER_SANITIZE_STRING);
if($btnCadUsuario){
	
	
	$dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	
	$erro = false;
	$cadastrar = 0;
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
		//$erro = true;
		$_SESSION['Site_Back']['msg'] = "Necessário preencher todos os campos";
	}elseif((strlen($dados['senha'])) < 4){
		//$erro = true;
		$_SESSION['Site_Back']['msg'] = "A senha deve ter no minímo 4 caracteres";
	}elseif($dados['senha'] != $dados['confirmar']){
		//$erro = true;
		$_SESSION['Site_Back']['msg'] = "Confira a senha digitada";
	}elseif(stristr($dados['senha'], "'")) {
		//$erro = true;
		$_SESSION['Site_Back']['msg'] = "Caracter ( ' ) utilizado na senha é inválido";
	}elseif (!is_numeric($dados['CelularCliente'])) {
		//$erro = true;
		$_SESSION['Site_Back']['msg'] = "O Celular só pode conter Números";
	}elseif((strlen($dados['CelularCliente'])) != 11){
		//$erro = true;
		$_SESSION['Site_Back']['msg'] = "O Celular deve conter 11 Números";
	}else{
		/*
			$result_cliente = "SELECT idApp_Cliente FROM App_Cliente WHERE usuario='". $dados['usuario'] ."' AND idSis_Empresa = '" .$idSis_Empresa. "'";
		$resultado_cliente = mysqli_query($conn, $result_cliente);
		if(($resultado_cliente) AND ($resultado_cliente->num_rows != 0)){
			$erro = true;
			$_SESSION['Site_Back']['msg'] = "Este usuário já está sendo utilizado";
		}
		
		$result_cliente = "SELECT idApp_Cliente FROM App_Cliente WHERE Email='". $dados['Email'] ."'";
		$resultado_cliente = mysqli_query($conn, $result_cliente);
		if(($resultado_cliente) AND ($resultado_cliente->num_rows != 0)){
			$erro = true;
			$_SESSION['Site_Back']['msg'] = "Este e-mail já está cadastrado";
		}
		*/
		$result_usuario = "SELECT * FROM Sis_Associado WHERE Associado='". $dados['CelularCliente'] ."'";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		$row_resultado_usuario = mysqli_fetch_array($resultado_usuario, MYSQLI_ASSOC);
		
		$result_cliente = "SELECT * FROM App_Cliente WHERE idSis_Empresa = '" .$idSis_Empresa. "' AND (usuario = '". $dados['CelularCliente'] ."' OR CelularCliente = '". $dados['CelularCliente'] ."')";
		$resultado_cliente = mysqli_query($conn, $result_cliente);
		$row_resultado_cliente = mysqli_fetch_array($resultado_cliente, MYSQLI_ASSOC);
		
		if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
			//  Encontrou o Associado da empresa 5
			
			if(($resultado_cliente) AND ($resultado_cliente->num_rows != 0)){
				//  Encontrou o Cliente da empresa em questão
				$cadastrar = 1;
				//$erro = true;
				//$_SESSION['Site_Back']['msg'] = "Associado Sim, Cliente Sim";
			} else {
				// Não Encontrou o Cliente da empresa em questão
				$cadastrar = 2;
				//$erro = true;
				//$_SESSION['Site_Back']['msg'] = "Associado Sim, Cliente Não";
			}
		} else {
			//Não Encontoru o Associado da Empresa 5
			
			if(($resultado_cliente) AND ($resultado_cliente->num_rows != 0)){
				// Encontrou o Cliente da empresa em questão
				$cadastrar = 3;
				//$erro = true;
				//$_SESSION['Site_Back']['msg'] = "Associado Não, Cliente Sim";
			} else {
				// Não Encontrou o Cliente da empresa em questão
				$cadastrar = 4;
				//$erro = true;
				//$_SESSION['Site_Back']['msg'] = "Associado Não, Cliente Não";
			}		
		}

		if(isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa])){
			$usuario_vend = $_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa];
			$nivel_vend = $_SESSION['Site_Back']['Nivel_Usuario_vend'.$idSis_Empresa];
		}else{
			if(isset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa])){
				$usuario_vend = $_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa];
				$nivel_vend = $_SESSION['Site_Back']['Nivel_Vendedor'.$idSis_Empresa];
			}else{	
				$usuario_vend = 0;
				$nivel_vend = 1;
			}
		}

			
		if($cadastrar == 1){
			//Encontrou o Associado e Encontrou o  Cliente!! Não Cadastra Ninguém

			$_SESSION['Site_Back']['msg'] = "Cliente Já cadastrado.<br>Digite o Celular e a Senha";
			$_SESSION['Site_Back']['msgcad'] = "Cliente Já cadastrado.<br>Digite o Celular e a Senha";
			header("Location: login_cliente.php");	
		}elseif($cadastrar == 2){
			//Encontrou o Associado e Não Encontrou o  Cliente!! Pega os Dados do Usuário e Cadastra o Cliente

			//$_SESSION['Site_Back']['msg'] = "2 - Usuário Já cadastrado.<br> Vamos Cadastrar o Cliente";
			//$_SESSION['Site_Back']['msgcad'] = "2 - Associado Já cadastrado na Plataforma Enkontraki!<br> Para cadastrá-lo na " . utf8_encode($row_empresa['NomeEmpresa']) . ",<br> digite a senha já cadastrada";
			//header("Location: login_cliente.php");
			$CodInterno = md5(time() . rand());
			$DataCadastroCliente = date('Y-m-d', time());
			
			$result_cliente = "INSERT INTO App_Cliente (idSis_Empresa, idTab_Modulo, idSis_Usuario, NivelCliente, idSis_Associado, NomeCliente, CelularCliente, CodInterno, Codigo, DataCadastroCliente, LocalCadastroCliente, usuario, senha) VALUES (
							'" .$idSis_Empresa. "',
							'1',
							'" .$usuario_vend. "',
							'" .$nivel_vend. "',
							'" .$row_resultado_usuario['idSis_Associado']. "',
							'" .$row_resultado_usuario['Nome']. "',
							'" .$row_resultado_usuario['CelularAssociado']. "',
							'" .$CodInterno. "',
							'" .$row_resultado_usuario['Codigo']. "',
							'" .$DataCadastroCliente. "',
							'O',
							'" .$row_resultado_usuario['CelularAssociado']. "',
							'" .$row_resultado_usuario['Senha']. "'
							)";
			$resultado_cliente = mysqli_query($conn, $result_cliente);
			$id_cliente = mysqli_insert_id($conn);
			
			if($id_cliente){
				
				$_SESSION['Site_Back']['msgcad'] = "Cliente Cadastrado com Sucesso!<br>Utilize a senha de Associado";
				header("Location: login_cliente.php");
				
			}else{
				$_SESSION['Site_Back']['msg'] = "Erro ao cadastrar o Cliente";
			}
		}elseif($cadastrar == 3){
			// Não Encontrou o Associado e Encontrou o  Cliente!! Pega os Dados do Cliente e Cadastra o Associado. Depois faço Update no cliente
			$Codigo = md5(time() . rand());
			$DataCriacao = date('Y-m-d', time());
			$senha = md5($dados['CelularCliente']);
			$CodInterno = md5(time() . rand());
	
			$result_usuario = "INSERT INTO Sis_Associado (idSis_Empresa, idTab_Modulo, NomeEmpresa, Nome, CelularAssociado, Codigo, DataCriacao, Associado, Senha, Inativo) VALUES (
							'5',
							'1',
							'CONTA PESSOAL',
							'" .$row_resultado_cliente['NomeCliente']. "',
							'" .$row_resultado_cliente['CelularCliente']. "',
							'" .$Codigo. "',
							'" .$DataCriacao. "',
							'" .$row_resultado_cliente['CelularCliente']. "',
							'" .$senha. "',
							
							'0'
							)";
			$resultado_usuario = mysqli_query($conn, $result_usuario);		
			$id_usuario_5 = mysqli_insert_id($conn);
			
			if($id_usuario_5){
			
				$result_agenda = "INSERT INTO App_Agenda (idSis_Empresa, idSis_Associado, NomeAgenda) VALUES (
								'5',
								'" .$id_usuario_5. "',
								'Associado'
								)";
				$resultado_agenda = mysqli_query($conn, $result_agenda);
				$id_agenda = mysqli_insert_id($conn);		
			
				$update_cliente = "UPDATE 
										App_Cliente 
									SET 
										idSis_Associado = '".$id_usuario_5."',
										usuario = '".$row_resultado_cliente['CelularCliente']."',
										senha = '".$senha."',
										CodInterno = '".$CodInterno."',
										Codigo = '".$Codigo."'
									WHERE 
										idApp_Cliente = '".$row_resultado_cliente['idApp_Cliente']."'
									";
									mysqli_query($conn, $update_cliente);					
			
			
				$_SESSION['Site_Back']['msgcad'] = "Cliente cadastrado com sucesso";
				header("Location: login_cliente.php");
			}else{
				$_SESSION['Site_Back']['msg'] = "Erro ao cadastrar o Cliente";
			}
		}elseif($cadastrar == 4){
			//Não Encontrou o Associado e Não Encontrou o Cliente!!Então Cadastra os Dois
			//$_SESSION['Site_Back']['msg'] = "4 - Vamos Cadastrar o Associado e o Cliente";
			//$_SESSION['Site_Back']['msgcad'] = "4 - Criar Menssagem";
			
			
			$dados['NomeCliente'] = trim(mb_strtoupper($dados['NomeCliente'], 'ISO-8859-1'));
			$dados['senha'] = md5($dados['senha']);
			$CodInterno = md5(time() . rand());
			$DataCadastroCliente = date('Y-m-d', time());
			$Codigo = md5(time() . rand());
			
			$result_usuario = "INSERT INTO Sis_Associado (idSis_Empresa, idTab_Modulo, NomeEmpresa, Nome, CelularAssociado, Codigo, DataCriacao, Associado, Senha, Inativo) VALUES (
							'5',
							'1',
							'CONTA PESSOAL',
							'" .$cliente. "',
							'" .$dados['CelularCliente']. "',
							'" .$Codigo. "',
							'" .$DataCadastroCliente. "',
							'" .$dados['CelularCliente']. "',
							'" .$dados['senha']. "',
							
							'0'
							)";
			$resultado_usuario = mysqli_query($conn, $result_usuario);		
			$id_usuario_5 = mysqli_insert_id($conn);
			
			if($id_usuario_5){
			
				$result_agenda = "INSERT INTO App_Agenda (idSis_Empresa, idSis_Associado, NomeAgenda) VALUES (
								'5',
								'" .$id_usuario_5. "',
								'Associado'
								)";
				$resultado_agenda = mysqli_query($conn, $result_agenda);
				$id_agenda = mysqli_insert_id($conn);
				
				$result_cliente = "INSERT INTO App_Cliente (idSis_Empresa, idTab_Modulo, idSis_Usuario, NivelCliente, idSis_Associado, NomeCliente, CelularCliente, CodInterno, Codigo, DataCadastroCliente, LocalCadastroCliente, usuario, senha) VALUES (
								'" .$idSis_Empresa. "',
								'1',
								'" .$usuario_vend. "',
								'" .$nivel_vend. "',
								'" .$id_usuario_5. "',
								'" .$cliente. "',
								'" .$dados['CelularCliente']. "',
								'" .$CodInterno. "',
								'" .$Codigo. "',
								'" .$DataCadastroCliente. "',
								'O',
								'" .$dados['CelularCliente']. "',
								'" .$dados['senha']. "'
								)";
				$resultado_cliente = mysqli_query($conn, $result_cliente);
				$id_cliente = mysqli_insert_id($conn);
				
				if($id_cliente){
					
					$_SESSION['Site_Back']['msgcad'] = "Cliente cadastrado com sucesso";
					header("Location: login_cliente.php");
					
				}else{
					$_SESSION['Site_Back']['msg'] = "Erro ao cadastrar o Cliente";
				}
			}else{
				$_SESSION['Site_Back']['msg'] = "Erro ao cadastrar o Cliente";
			}
			
		}else{
			$_SESSION['Site_Back']['msg'] = "Erro ao cadastrar o Cliente";
			
		}
	}
}	
?>
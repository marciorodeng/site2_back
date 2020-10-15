<?php
	
ob_start();
$btnCadUsuario = filter_input(INPUT_POST, 'btnCadUsuario', FILTER_SANITIZE_STRING);
if($btnCadUsuario){
	
	
	$dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	
	$erro = false;
	$cadastrar = 0;
	$dados_st = array_map('strip_tags', $dados_rc);
	$dados = array_map('trim', $dados_st);
	
	if(in_array('',$dados)){
		//$erro = true;
		$_SESSION['msg'] = "Necessário preencher todos os campos";
	}elseif((strlen($dados['senha'])) < 4){
		//$erro = true;
		$_SESSION['msg'] = "A senha deve ter no minímo 4 caracteres";
	}elseif($dados['senha'] != $dados['confirmar']){
		//$erro = true;
		$_SESSION['msg'] = "Confira a senha digitada";
	}elseif(stristr($dados['senha'], "'")) {
		//$erro = true;
		$_SESSION['msg'] = "Caracter ( ' ) utilizado na senha é inválido";
	}elseif (!is_numeric($dados['CelularCliente'])) {
		//$erro = true;
		$_SESSION['msg'] = "O Celular só pode conter Números";
	}elseif((strlen($dados['CelularCliente'])) != 11){
		//$erro = true;
		$_SESSION['msg'] = "O Celular deve conter 11 Números";
	}else{
		/*
			$result_cliente = "SELECT idApp_Cliente FROM App_Cliente WHERE usuario='". $dados['usuario'] ."' AND idSis_Empresa = '" .$idSis_Empresa. "'";
		$resultado_cliente = mysqli_query($conn, $result_cliente);
		if(($resultado_cliente) AND ($resultado_cliente->num_rows != 0)){
			$erro = true;
			$_SESSION['msg'] = "Este usuário já está sendo utilizado";
		}
		
		$result_cliente = "SELECT idApp_Cliente FROM App_Cliente WHERE Email='". $dados['Email'] ."'";
		$resultado_cliente = mysqli_query($conn, $result_cliente);
		if(($resultado_cliente) AND ($resultado_cliente->num_rows != 0)){
			$erro = true;
			$_SESSION['msg'] = "Este e-mail já está cadastrado";
		}
		*/
		$result_usuario = "SELECT * FROM Sis_Usuario WHERE CelularUsuario='". $dados['CelularCliente'] ."' AND idSis_Empresa = '5'";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		$row_resultado_usuario = mysqli_fetch_array($resultado_usuario, MYSQLI_ASSOC);
		
		$result_cliente = "SELECT * FROM App_Cliente WHERE CelularCliente='". $dados['CelularCliente'] ."' AND idSis_Empresa = '" .$idSis_Empresa. "'";
		$resultado_cliente = mysqli_query($conn, $result_cliente);
		$row_resultado_cliente = mysqli_fetch_array($resultado_cliente, MYSQLI_ASSOC);
		
		if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
			//  Encontrou o Usuario da empresa 5
			
			if(($resultado_cliente) AND ($resultado_cliente->num_rows != 0)){
				//  Encontrou o Cliente da empresa em questão
				$cadastrar = 1;
				//$erro = true;
				//$_SESSION['msg'] = "Usuario Sim, Cliente Sim";
			} else {
				// Não Encontrou o Cliente da empresa em questão
				$cadastrar = 2;
				//$erro = true;
				//$_SESSION['msg'] = "Usuario Sim, Cliente Não";
			}
		} else {
			//Não Encontoru o Usuario da Empresa 5
			
			if(($resultado_cliente) AND ($resultado_cliente->num_rows != 0)){
				// Encontrou o Cliente da empresa em questão
				$cadastrar = 3;
				//$erro = true;
				//$_SESSION['msg'] = "Usuario Não, Cliente Sim";
			} else {
				// Não Encontrou o Cliente da empresa em questão
				$cadastrar = 4;
				//$erro = true;
				//$_SESSION['msg'] = "Usuario Não, Cliente Não";
			}		
		}
	}

	if($cadastrar == 1){
		//Encontrou o Usuario e Encontrou o  Cliente!! Não Cadastra Ninguém

		$_SESSION['msg'] = "1 - Cliente Já cadastrado.<br>Digite o Celular e a Senha";
		$_SESSION['msgcad'] = "1 - Cliente Já cadastrado.<br>Digite o Celular e a Senha";
		header("Location: login_cliente.php");	
	}

	if($cadastrar == 2){
		//Encontrou o Usuario e Não Encontrou o  Cliente!! Pega os Dados do Usuário e Cadastra o Cliente

		//$_SESSION['msg'] = "2 - Usuário Já cadastrado.<br> Vamos Cadastrar o Cliente";
		//$_SESSION['msgcad'] = "2 - Associado Já cadastrado na Plataforma Enkontraki!<br> Para cadastrá-lo na " . utf8_encode($row_empresa['NomeEmpresa']) . ",<br> digite a senha já cadastrada";
		//header("Location: login_cliente.php");
		$CodInterno = md5(time() . rand());
		$DataCadastroCliente = date('Y-m-d', time());
		
		$result_cliente = "INSERT INTO App_Cliente (idSis_Empresa, idTab_Modulo, idSis_Usuario_5, NomeCliente, CelularCliente, CodInterno, Codigo, DataCadastroCliente, LocalCadastroCliente, usuario, senha) VALUES (
						'" .$idSis_Empresa. "',
						'1',
						'" .$row_resultado_usuario['idSis_Usuario']. "',
						'" .$row_resultado_usuario['Nome']. "',
						'" .$row_resultado_usuario['CelularUsuario']. "',
						'" .$CodInterno. "',
						'" .$row_resultado_usuario['Codigo']. "',
						'" .$DataCadastroCliente. "',
						'O',
						'" .$row_resultado_usuario['CelularUsuario']. "',
						'" .$row_resultado_usuario['Senha']. "'
						)";
		$resultado_cliente = mysqli_query($conn, $result_cliente);
		$id_cliente = mysqli_insert_id($conn);
		
		if($id_cliente){
			
			$_SESSION['msgcad'] = "Cliente Cadastrado com Sucesso!<br>Utilize a senha de Associado";
			header("Location: login_cliente.php");
			
		}else{
			$_SESSION['msg'] = "Erro ao cadastrar o Cliente";
		}
	}

	if($cadastrar == 3){
		// Não Encontrou o Usuario e Encontrou o  Cliente!! Pega os Dados do Cliente e Cadastra o Usuario. Depois faço Update no cliente
		$Codigo = md5(time() . rand());
		$DataCriacao = date('Y-m-d', time());
		
		$result_usuario = "INSERT INTO Sis_Usuario (idSis_Empresa, idTab_Modulo, NomeEmpresa, Nome, CelularUsuario, Codigo, DataCriacao, Usuario, Senha, Permissao, Inativo) VALUES (
						'5',
						'1',
						'CONTA PESSOAL',
						'" .$row_resultado_cliente['NomeCliente']. "',
						'" .$row_resultado_cliente['CelularCliente']. "',
						'" .$Codigo. "',
						'" .$DataCriacao. "',
						'" .$row_resultado_cliente['CelularCliente']. "',
						'" .$row_resultado_cliente['senha']. "',
						'3',
						'0'
						)";
		$resultado_usuario = mysqli_query($conn, $result_usuario);		
		$id_usuario_5 = mysqli_insert_id($conn);
		
		if($id_usuario_5){
		
			$result_agenda = "INSERT INTO App_Agenda (idSis_Empresa, idSis_Usuario, NomeAgenda) VALUES (
							'5',
							'" .$id_usuario_5. "',
							'Cliente'
							)";
			$resultado_agenda = mysqli_query($conn, $result_agenda);
			$id_agenda = mysqli_insert_id($conn);		
		
			$update_cliente = "UPDATE 
									App_Cliente 
								SET 
									idSis_Usuario_5 = '".$id_usuario_5."',
									Codigo = '".$Codigo."'
								WHERE 
									idApp_Cliente = '".$row_resultado_cliente['idApp_Cliente']."'
								";
								mysqli_query($conn, $update_cliente);					
		
		
			$_SESSION['msgcad'] = "Cliente cadastrado com sucesso";
			header("Location: login_cliente.php");
		}else{
			$_SESSION['msg'] = "Erro ao cadastrar o Cliente";
		}
	}

	if($cadastrar == 4){
		//Não Encontrou o Usuario e Não Encontrou o Cliente!!Então Cadastra os Dois
		//$_SESSION['msg'] = "4 - Vamos Cadastrar o Usuario e o Cliente";
		//$_SESSION['msgcad'] = "4 - Criar Menssagem";
		
		
		$dados['NomeCliente'] = trim(mb_strtoupper($dados['NomeCliente'], 'ISO-8859-1'));
		$dados['senha'] = md5($dados['senha']);
		$CodInterno = md5(time() . rand());
		$DataCadastroCliente = date('Y-m-d', time());
		$Codigo = md5(time() . rand());
		
		$result_usuario = "INSERT INTO Sis_Usuario (idSis_Empresa, idTab_Modulo, NomeEmpresa, Nome, CelularUsuario, Codigo, DataCriacao, Usuario, Senha, Permissao, Inativo) VALUES (
						'5',
						'1',
						'CONTA PESSOAL',
						'" .$dados['NomeCliente']. "',
						'" .$dados['CelularCliente']. "',
						'" .$Codigo. "',
						'" .$DataCadastroCliente. "',
						'" .$dados['CelularCliente']. "',
						'" .$dados['senha']. "',
						'3',
						'0'
						)";
		$resultado_usuario = mysqli_query($conn, $result_usuario);		
		$id_usuario_5 = mysqli_insert_id($conn);
		
		if($id_usuario_5){
		
			$result_agenda = "INSERT INTO App_Agenda (idSis_Empresa, idSis_Usuario, NomeAgenda) VALUES (
							'5',
							'" .$id_usuario_5. "',
							'Cliente'
							)";
			$resultado_agenda = mysqli_query($conn, $result_agenda);
			$id_agenda = mysqli_insert_id($conn);
			
			$result_cliente = "INSERT INTO App_Cliente (idSis_Empresa, idTab_Modulo, idSis_Usuario_5, NomeCliente, CelularCliente, CodInterno, Codigo, DataCadastroCliente, LocalCadastroCliente, usuario, senha) VALUES (
							'" .$idSis_Empresa. "',
							'1',
							'" .$id_usuario_5. "',
							'" .$dados['NomeCliente']. "',
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
				
				$_SESSION['msgcad'] = "Cliente cadastrado com sucesso";
				header("Location: login_cliente.php");
				
			}else{
				$_SESSION['msg'] = "Erro ao cadastrar o Cliente";
			}
		}else{
			$_SESSION['msg'] = "Erro ao cadastrar o Cliente";
		}
		
	}
}	
?>
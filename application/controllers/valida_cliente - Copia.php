<?php

$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);
if($btnLogin){
	//$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
	$celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

	if((!empty($usuario)) AND (!empty($senha))){
		//Pesquisar o Usuário na plataforma
		
		$result_celular = "SELECT *
							FROM 
								Sis_Usuario 
							WHERE 
								CelularUsuario = '".$celular."' AND
								idSis_Empresa = '5'
							LIMIT 1";
		$resultado_celular = mysqli_query($conn, $result_celular);
		$row_celular = mysqli_fetch_array($resultado_celular, MYSQLI_ASSOC);
		
		$count_celular = mysqli_num_rows($resultado_celular);		
		
		if($count_celular == 0){
			//Usuario Encontrado? NÃO.
			//Pesquiso se existe o celular do cliente na empresa
			
			//$_SESSION['Site_Back']['msg'] = "Usuário Não Encontrado!";
			//header("Location: login_cliente.php");
			$result_cliente = "SELECT *
								FROM 
									App_Cliente 
								WHERE
									CelularCliente = '" .$celular. "' AND
									idSis_Empresa = '" .$idSis_Empresa. "'
								LIMIT 1";
			$resultado_cliente = mysqli_query($conn, $result_cliente);
			$row_cliente = mysqli_fetch_array($resultado_cliente, MYSQLI_ASSOC);
			$count_cliente = mysqli_num_rows($resultado_cliente);
			
			if($count_cliente == 0){	
				//Cliente Encontrado? NÃO.
				//Cadastrar o cliente na Plataforma
				$_SESSION['Site_Back']['msg'] = "Cliente Não Cadastrado na Plataforma!";
				header("Location: cadastrar_cliente.php");
			}else{
				//Cliente Encontrado? SIM.
				//Confiro a Senha
				$result_cliente_senha = "SELECT *
								FROM 
									App_Cliente 
								WHERE
									CelularCliente = '" .$celular. "' AND
									senha = '".md5($senha)."' AND
									idSis_Empresa = '" .$idSis_Empresa. "'
								LIMIT 1";
				$resultado_cliente_senha = mysqli_query($conn, $result_cliente_senha);
				$row_cliente_senha = mysqli_fetch_array($resultado_cliente_senha, MYSQLI_ASSOC);
				
				$count_cliente_senha = mysqli_num_rows($resultado_cliente_senha);
				
				if($count_cliente_senha == 0){	
					//Senha correta do Cliente? NÃO.
					
					$_SESSION['Site_Back']['msg'] = "Senha do Cliente Incorreta!";
					header("Location: login_cliente.php");
				}else{
					//Senha correta do Cliente? SIM .
					//Cadastro o Cliente como um usuario na Plataforma.
					//$_SESSION['Site_Back']['msg'] = "Pego os dados do Cliente e cadastro o Usuário. Retorno os dados do usuario e faço um update no cliente. Depois faço o log do cliente!";
					//header("Location: login_cliente.php");
					$Codigo = md5(time() . rand());
					$DataCriacao = date('Y-m-d', time());
					
					$result_usuario = "INSERT INTO Sis_Usuario (idSis_Empresa, idTab_Modulo, NomeEmpresa, Nome, CelularUsuario, Codigo, DataCriacao, Usuario, Senha, Permissao, Inativo) VALUES (
									'5',
									'1',
									'CONTA PESSOAL',
									'" .$row_cliente_senha['NomeCliente']. "',
									'" .$row_cliente_senha['CelularCliente']. "',
									'" .$Codigo. "',
									'" .$DataCriacao. "',
									'" .$row_cliente_senha['CelularCliente']. "',
									'" .$row_cliente_senha['senha']. "',
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
												idApp_Cliente = '".$row_cliente_senha['idApp_Cliente']."'
											";
											mysqli_query($conn, $update_cliente);					
					
					}
											
					$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa] = $row_cliente_senha['idApp_Cliente'];
					$_SESSION['Site_Back']['id_Usuario_5'.$idSis_Empresa] = $row_cliente_senha['idSis_Usuario_5'];
					$_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa] = $row_cliente_senha['NomeCliente'];
					$_SESSION['Site_Back']['Email_Cliente'.$idSis_Empresa] = $row_cliente_senha['Email'];
					$_SESSION['Site_Back']['CelularCliente'.$idSis_Empresa] = $row_cliente_senha['CelularCliente'];
					$_SESSION['Site_Back']['Cep_Cliente'.$idSis_Empresa] = $row_cliente_senha['CepCliente'];
					$_SESSION['Site_Back']['Endereco_Cliente'.$idSis_Empresa] = $row_cliente_senha['EnderecoCliente'];
					$_SESSION['Site_Back']['Numero_Cliente'.$idSis_Empresa] = $row_cliente_senha['NumeroCliente'];
					$_SESSION['Site_Back']['Complemento_Cliente'.$idSis_Empresa] = $row_cliente_senha['ComplementoCliente'];
					$_SESSION['Site_Back']['Bairro_Cliente'.$idSis_Empresa] = $row_cliente_senha['BairroCliente'];
					$_SESSION['Site_Back']['Cidade_Cliente'.$idSis_Empresa] = $row_cliente_senha['CidadeCliente'];
					$_SESSION['Site_Back']['Estado_Cliente'.$idSis_Empresa] = $row_cliente_senha['EstadoCliente'];
					$_SESSION['Site_Back']['Arquivo_Cliente'.$idSis_Empresa] = $row_cliente_senha['Arquivo'];
					unset($_SESSION['Site_Back']['Usuario_5'.$idSis_Empresa]); 

					if(isset($_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa])){
						if($_SESSION['Site_Back']['id_Usuario_5'.$idSis_Empresa] != $_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa]){
							//Não faço nada
						}else{
							unset($_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa], $_SESSION['Site_Back']['Nome_Usuario'.$idSis_Empresa], $_SESSION['Site_Back']['Arquivo_Usuario'.$idSis_Empresa]);			
						}
					}else{
						//Não faço nada
					}					
					
					//header("Location: produtos_cliente.php");
					if(isset($_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]])){
						header("Location: meu_carrinho.php");			
					}else{	
						//header("Location: index.php");
						//header("Location: inicial.php");
						header("Location: produtos.php");
					}
				}
			}
				
		}else{
			//Usuario Encontrado? SIM. 
			//Confiro a senha de usuário da plataforma
			$result_usuario_senha = "SELECT *
								FROM 
									Sis_Usuario 
								WHERE 
									CelularUsuario = '".$celular."' AND
									Senha = '".md5($senha)."' AND
									idSis_Empresa = '5'
								LIMIT 1";
			$resultado_usuario_senha = mysqli_query($conn, $result_usuario_senha);
			$row_usuario_senha = mysqli_fetch_array($resultado_usuario_senha, MYSQLI_ASSOC);
			
			$count_usuario_senha = mysqli_num_rows($resultado_usuario_senha);
			
			if($count_usuario_senha == 0){
				//Senha Usuario correta? NÃO .
				$_SESSION['Site_Back']['msg'] = "Senha incorreta!";
				header("Location: login_cliente.php");
			
			} else {
				//Senha Usuario correta? SIM. 
				//Pesquiso o usuário da plataforma na empresa em questão
				
				$_SESSION['Site_Back']['Usuario_5'.$idSis_Empresa]['idSis_Usuario_5'] = $row_usuario_senha['idSis_Usuario'];
				$_SESSION['Site_Back']['Usuario_5'.$idSis_Empresa]['Nome'] = $row_usuario_senha['Nome'];
				$_SESSION['Site_Back']['Usuario_5'.$idSis_Empresa]['Sexo'] = $row_usuario_senha['Sexo'];
				$_SESSION['Site_Back']['Usuario_5'.$idSis_Empresa]['Codigo'] = $row_usuario_senha['Codigo'];
				$_SESSION['Site_Back']['Usuario_5'.$idSis_Empresa]['Celular'] = $row_usuario_senha['CelularUsuario'];
				$_SESSION['Site_Back']['Usuario_5'.$idSis_Empresa]['Senha'] = $row_usuario_senha['Senha'];
				
				//Pesquisar o Cliente na Empresa
				$result_cliente = "SELECT *
									FROM 
										App_Cliente 
									WHERE
										idSis_Usuario_5 = '" .$_SESSION['Site_Back']['Usuario_5'.$idSis_Empresa]['idSis_Usuario_5']. "' AND
										idSis_Empresa = '" .$idSis_Empresa. "'
									LIMIT 1";
				$resultado_cliente = mysqli_query($conn, $result_cliente);
				$row_cliente = mysqli_fetch_array($resultado_cliente, MYSQLI_ASSOC);
				
				$count_cliente = mysqli_num_rows($resultado_cliente);
				
				if($count_cliente == 0){
					//Cliente Encontrado na empresa em questão? NÃO.
					//Pesquisar o Celular do Cliente na Empresa
					
					$result_cliente_celular = "SELECT *
										FROM 
											App_Cliente 
										WHERE
											CelularCliente = '" .$celular. "' AND
											idSis_Empresa = '" .$idSis_Empresa. "'
										LIMIT 1";
					$resultado_cliente_celular = mysqli_query($conn, $result_cliente_celular);
					$row_cliente_celular = mysqli_fetch_array($resultado_cliente_celular, MYSQLI_ASSOC);
					
					$count_cliente_celular = mysqli_num_rows($resultado_cliente_celular);					
					
					if($count_cliente_celular == 0){
						//Celular do Cliente na Empresa encontrado? Não.
						//Cadastro o Cliente na Empresa
						
						$_SESSION['Site_Back']['msg'] = "Este Cliente já está cadastrado na plataforma Enkontraki,<br> mas ainda não está cadastrado na Empresa " . $row_empresa['NomeEmpresa'] . "!<br>Para inserí-lo nesta empresa, basta confirmar o cadstro!<br><br>Confirmar o Cadastro?";
						header("Location: cadastrar_cliente2.php");
					}else{
						//Celular do Cliente na Empresa encontrado? Sim.
						//Fazer um Update no Cliente, com os dados do usuario, antes de logar o cliente;
						
						$id_cliente = $row_cliente_celular['idApp_Cliente'];
						
						$update_cliente = "UPDATE 
												App_Cliente 
											SET 
												idSis_Usuario_5 = '".$_SESSION['Site_Back']['Usuario_5'.$idSis_Empresa]['idSis_Usuario_5']."',
												senha = '".$_SESSION['Site_Back']['Usuario_5'.$idSis_Empresa]['Senha']."',
												Codigo = '".$_SESSION['Site_Back']['Usuario_5'.$idSis_Empresa]['Codigo']."'
											WHERE 
												idApp_Cliente = '".$id_cliente."'
											";
											mysqli_query($conn, $update_cliente);
											
						$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa] = $row_cliente_celular['idApp_Cliente'];
						$_SESSION['Site_Back']['id_Usuario_5'.$idSis_Empresa] = $row_cliente_celular['idSis_Usuario_5'];
						$_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa] = $row_cliente_celular['NomeCliente'];
						$_SESSION['Site_Back']['Email_Cliente'.$idSis_Empresa] = $row_cliente_celular['Email'];
						$_SESSION['Site_Back']['CelularCliente'.$idSis_Empresa] = $row_cliente_celular['CelularCliente'];
						$_SESSION['Site_Back']['Cep_Cliente'.$idSis_Empresa] = $row_cliente_celular['CepCliente'];
						$_SESSION['Site_Back']['Endereco_Cliente'.$idSis_Empresa] = $row_cliente_celular['EnderecoCliente'];
						$_SESSION['Site_Back']['Numero_Cliente'.$idSis_Empresa] = $row_cliente_celular['NumeroCliente'];
						$_SESSION['Site_Back']['Complemento_Cliente'.$idSis_Empresa] = $row_cliente_celular['ComplementoCliente'];
						$_SESSION['Site_Back']['Bairro_Cliente'.$idSis_Empresa] = $row_cliente_celular['BairroCliente'];
						$_SESSION['Site_Back']['Cidade_Cliente'.$idSis_Empresa] = $row_cliente_celular['CidadeCliente'];
						$_SESSION['Site_Back']['Estado_Cliente'.$idSis_Empresa] = $row_cliente_celular['EstadoCliente'];
						$_SESSION['Site_Back']['Arquivo_Cliente'.$idSis_Empresa] = $row_cliente_celular['Arquivo'];
						unset($_SESSION['Site_Back']['Usuario_5'.$idSis_Empresa]);

						if(isset($_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa])){
							if($_SESSION['Site_Back']['id_Usuario_5'.$idSis_Empresa] != $_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa]){
								//Não faço nada
							}else{
								unset($_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa], $_SESSION['Site_Back']['Nome_Usuario'.$idSis_Empresa], $_SESSION['Site_Back']['Arquivo_Usuario'.$idSis_Empresa]);			
							}
						}else{
							//Não faço nada
						}					
						 
						//header("Location: produtos_cliente.php");
						if(isset($_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]])){
							header("Location: meu_carrinho.php");			
						}else{	
							//header("Location: index.php");
							//header("Location: inicial.php");
							header("Location: produtos.php");
						}
					}
				}else{
					//Cliente Encontrado na empresa em questão? SIM.
					//Pego os dados do Cliente
					
					$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa] = $row_cliente['idApp_Cliente'];
					$_SESSION['Site_Back']['id_Usuario_5'.$idSis_Empresa] = $row_cliente['idSis_Usuario_5'];
					$_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa] = $row_cliente['NomeCliente'];
					$_SESSION['Site_Back']['Email_Cliente'.$idSis_Empresa] = $row_cliente['Email'];
					$_SESSION['Site_Back']['CelularCliente'.$idSis_Empresa] = $row_cliente['CelularCliente'];
					$_SESSION['Site_Back']['Cep_Cliente'.$idSis_Empresa] = $row_cliente['CepCliente'];
					$_SESSION['Site_Back']['Endereco_Cliente'.$idSis_Empresa] = $row_cliente['EnderecoCliente'];
					$_SESSION['Site_Back']['Numero_Cliente'.$idSis_Empresa] = $row_cliente['NumeroCliente'];
					$_SESSION['Site_Back']['Complemento_Cliente'.$idSis_Empresa] = $row_cliente['ComplementoCliente'];
					$_SESSION['Site_Back']['Bairro_Cliente'.$idSis_Empresa] = $row_cliente['BairroCliente'];
					$_SESSION['Site_Back']['Cidade_Cliente'.$idSis_Empresa] = $row_cliente['CidadeCliente'];
					$_SESSION['Site_Back']['Estado_Cliente'.$idSis_Empresa] = $row_cliente['EstadoCliente'];
					$_SESSION['Site_Back']['Arquivo_Cliente'.$idSis_Empresa] = $row_cliente['Arquivo'];
					unset($_SESSION['Site_Back']['Usuario_5'.$idSis_Empresa]); 

					if(isset($_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa])){
						if($_SESSION['Site_Back']['id_Usuario_5'.$idSis_Empresa] != $_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa]){
							//Não faço nada
						}else{
							unset($_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa], $_SESSION['Site_Back']['Nome_Usuario'.$idSis_Empresa], $_SESSION['Site_Back']['Arquivo_Usuario'.$idSis_Empresa]);			
						}
					}else{
						//Não faço nada
					}					
					
					//header("Location: produtos_cliente.php");
					if(isset($_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]])){
						header("Location: meu_carrinho.php");			
					}else{	
						//header("Location: index.php");
						//header("Location: inicial.php");
						header("Location: produtos.php");
					}
				}
			}
		}	
	}else{
		$_SESSION['Site_Back']['msg'] = "Login e/ou Senha incorretos!";
		header("Location: login_cliente.php");
	}
}else{
	$_SESSION['Site_Back']['msg'] = "Página não encontrada";
	header("Location: login_cliente.php");
}

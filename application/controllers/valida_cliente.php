<?php

$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);
if($btnLogin){
	//$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
	$celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

	if((!empty($usuario)) AND (!empty($senha))){
		//Pesquisar o Usuário no BD
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
			//Usuario NÃO Encontrado
			
			//$_SESSION['msg'] = "Usuário Não Encontrado!";
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
				//Cliente NÃO Encontrado
				$_SESSION['msg'] = "Cliente Não Cadastrado na Plataforma!";
				header("Location: cadastrar_cliente.php");
			}else{
				//Cliente SIM Encontrado
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
					//Senha NÃO correta do Cliente
					
					$_SESSION['msg'] = "Senha do Cliente Incorreta!";
					header("Location: login_cliente.php");
				}else{
					//Senha SIM correta do Cliente
					//$_SESSION['msg'] = "Pego os dados do Cliente e cadastro o Usuário. Retorno os dados do usuario e faço um update no cliente. Depois faço o log do cliente!";
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
											
					$_SESSION['id_Cliente'.$idSis_Empresa] = $row_cliente_senha['idApp_Cliente'];
					$_SESSION['Nome_Cliente'.$idSis_Empresa] = $row_cliente_senha['NomeCliente'];
					$_SESSION['Email_Cliente'.$idSis_Empresa] = $row_cliente_senha['Email'];
					$_SESSION['CelularCliente'.$idSis_Empresa] = $row_cliente_senha['CelularCliente'];
					$_SESSION['Cep_Cliente'.$idSis_Empresa] = $row_cliente_senha['CepCliente'];
					$_SESSION['Endereco_Cliente'.$idSis_Empresa] = $row_cliente_senha['EnderecoCliente'];
					$_SESSION['Numero_Cliente'.$idSis_Empresa] = $row_cliente_senha['NumeroCliente'];
					$_SESSION['Complemento_Cliente'.$idSis_Empresa] = $row_cliente_senha['ComplementoCliente'];
					$_SESSION['Bairro_Cliente'.$idSis_Empresa] = $row_cliente_senha['BairroCliente'];
					$_SESSION['Cidade_Cliente'.$idSis_Empresa] = $row_cliente_senha['CidadeCliente'];
					$_SESSION['Estado_Cliente'.$idSis_Empresa] = $row_cliente_senha['EstadoCliente'];
					unset($_SESSION['Usuario_5'.$idSis_Empresa]); 
					//header("Location: produtos_cliente.php");
					if(isset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]])){
						header("Location: meu_carrinho.php");			
					}else{	
						//header("Location: index.php");
						//header("Location: inicial.php");
						header("Location: produtos.php");
					}
				}
			}
				
		}else{
			//Usuario SIM Encontrado
			
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
				//Senha Usuario NÃO correta
				$_SESSION['msg'] = "Senha incorreta!";
				header("Location: login_cliente.php");
			
			} else {
				//Senha Usuario SIM correta
				
				$_SESSION['Usuario_5'.$idSis_Empresa]['idSis_Usuario_5'] = $row_usuario_senha['idSis_Usuario'];
				$_SESSION['Usuario_5'.$idSis_Empresa]['Nome'] = $row_usuario_senha['Nome'];
				$_SESSION['Usuario_5'.$idSis_Empresa]['Sexo'] = $row_usuario_senha['Sexo'];
				$_SESSION['Usuario_5'.$idSis_Empresa]['Codigo'] = $row_usuario_senha['Codigo'];
				$_SESSION['Usuario_5'.$idSis_Empresa]['Celular'] = $row_usuario_senha['CelularUsuario'];
				$_SESSION['Usuario_5'.$idSis_Empresa]['Senha'] = $row_usuario_senha['Senha'];
				
				//Pesquisar o Cliente na Empresa
				$result_cliente = "SELECT *
									FROM 
										App_Cliente 
									WHERE
										idSis_Usuario_5 = '" .$_SESSION['Usuario_5'.$idSis_Empresa]['idSis_Usuario_5']. "' AND
										idSis_Empresa = '" .$idSis_Empresa. "'
									LIMIT 1";
				$resultado_cliente = mysqli_query($conn, $result_cliente);
				$row_cliente = mysqli_fetch_array($resultado_cliente, MYSQLI_ASSOC);
				
				$count_cliente = mysqli_num_rows($resultado_cliente);
				
				if($count_cliente == 0){
					//Cliente NÃO Encontrado na empresa em questão
					
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
						$_SESSION['msg'] = "Este Cliente ainda não está cadastrado na " . utf8_encode($row_empresa['NomeEmpresa']) . "!<br>Confirmar o Cadastro?";
						header("Location: cadastrar_cliente2.php");
					}else{
						$id_cliente = $row_cliente_celular['idApp_Cliente'];
						//$_SESSION['msg'] = "Fazer um Update no Cliente, com os dados do usuario, antes de logar o cliente!";
						//header("Location: login_cliente.php");
						
						$update_cliente = "UPDATE 
												App_Cliente 
											SET 
												idSis_Usuario_5 = '".$_SESSION['Usuario_5'.$idSis_Empresa]['idSis_Usuario_5']."',
												senha = '".$_SESSION['Usuario_5'.$idSis_Empresa]['Senha']."',
												Codigo = '".$_SESSION['Usuario_5'.$idSis_Empresa]['Codigo']."'
											WHERE 
												idApp_Cliente = '".$id_cliente."'
											";
											mysqli_query($conn, $update_cliente);
											
						$_SESSION['id_Cliente'.$idSis_Empresa] = $row_cliente_celular['idApp_Cliente'];
						$_SESSION['Nome_Cliente'.$idSis_Empresa] = $row_cliente_celular['NomeCliente'];
						$_SESSION['Email_Cliente'.$idSis_Empresa] = $row_cliente_celular['Email'];
						$_SESSION['CelularCliente'.$idSis_Empresa] = $row_cliente_celular['CelularCliente'];
						$_SESSION['Cep_Cliente'.$idSis_Empresa] = $row_cliente_celular['CepCliente'];
						$_SESSION['Endereco_Cliente'.$idSis_Empresa] = $row_cliente_celular['EnderecoCliente'];
						$_SESSION['Numero_Cliente'.$idSis_Empresa] = $row_cliente_celular['NumeroCliente'];
						$_SESSION['Complemento_Cliente'.$idSis_Empresa] = $row_cliente_celular['ComplementoCliente'];
						$_SESSION['Bairro_Cliente'.$idSis_Empresa] = $row_cliente_celular['BairroCliente'];
						$_SESSION['Cidade_Cliente'.$idSis_Empresa] = $row_cliente_celular['CidadeCliente'];
						$_SESSION['Estado_Cliente'.$idSis_Empresa] = $row_cliente_celular['EstadoCliente'];
						unset($_SESSION['Usuario_5'.$idSis_Empresa]); 
						//header("Location: produtos_cliente.php");
						if(isset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]])){
							header("Location: meu_carrinho.php");			
						}else{	
							//header("Location: index.php");
							//header("Location: inicial.php");
							header("Location: produtos.php");
						}
					}
				}else{
					$_SESSION['id_Cliente'.$idSis_Empresa] = $row_cliente['idApp_Cliente'];
					$_SESSION['Nome_Cliente'.$idSis_Empresa] = $row_cliente['NomeCliente'];
					$_SESSION['Email_Cliente'.$idSis_Empresa] = $row_cliente['Email'];
					$_SESSION['CelularCliente'.$idSis_Empresa] = $row_cliente['CelularCliente'];
					$_SESSION['Cep_Cliente'.$idSis_Empresa] = $row_cliente['CepCliente'];
					$_SESSION['Endereco_Cliente'.$idSis_Empresa] = $row_cliente['EnderecoCliente'];
					$_SESSION['Numero_Cliente'.$idSis_Empresa] = $row_cliente['NumeroCliente'];
					$_SESSION['Complemento_Cliente'.$idSis_Empresa] = $row_cliente['ComplementoCliente'];
					$_SESSION['Bairro_Cliente'.$idSis_Empresa] = $row_cliente['BairroCliente'];
					$_SESSION['Cidade_Cliente'.$idSis_Empresa] = $row_cliente['CidadeCliente'];
					$_SESSION['Estado_Cliente'.$idSis_Empresa] = $row_cliente['EstadoCliente'];
					unset($_SESSION['Usuario_5'.$idSis_Empresa]); 
					//header("Location: produtos_cliente.php");
					if(isset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]])){
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
		$_SESSION['msg'] = "Login e/ou Senha incorretos!";
		header("Location: login_cliente.php");
	}
}else{
	$_SESSION['msg'] = "Página não encontrada";
	header("Location: login_cliente.php");
}

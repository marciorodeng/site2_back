<?php

	$result_doc = "SELECT * FROM App_Documentos WHERE idSis_Empresa = '".$idSis_Empresa."'  ORDER BY idApp_Documentos ASC";
	$resultado_documento = $pdo->prepare($result_doc);
	$resultado_documento->execute();
	$row_documento = $resultado_documento->fetch(PDO::FETCH_ASSOC);
	
	$result_empresa = "SELECT * FROM Sis_Empresa WHERE idSis_Empresa = '".$idSis_Empresa."'";
	$resultado_empresa = $pdo->prepare($result_empresa);
	$resultado_empresa->execute();
	$row_empresa = $resultado_empresa->fetch(PDO::FETCH_ASSOC);

	$dia_da_semana = date('N');
	$horario = date('H:i:s');
	$result_atend = "SELECT * FROM App_Atendimento WHERE idSis_Empresa = '".$idSis_Empresa."' AND id_Dia = '".$dia_da_semana."' AND Aberto = 'S'";
	$resultado_atend = mysqli_query($conn, $result_atend);
	if(mysqli_num_rows($resultado_atend) > '0'){
		foreach($resultado_atend as $resultado_atend_view){
			//$aberto 	= $resultado_atend_view['Aberto'];
			$hora_abre 	= $resultado_atend_view['Hora_Abre'];
			$hora_fecha = $resultado_atend_view['Hora_Fecha'];
			if($horario >= $hora_abre && $horario <= $hora_fecha){
				$loja_aberta = true;
			}else{
				$loja_aberta = false;
			}
		}
	}else{
		$loja_aberta = false;
	}

	if((isset($_GET['emp'])) && (isset($_GET['usuario']))){

		$emp = addslashes($_GET['emp']);
		$usuario = addslashes($_GET['usuario']);
		
		$result_usuario = "SELECT 
								TSU.idSis_Usuario,
								TSU.Codigo,
								TSU.Nome,
								TSU.Nivel,
								TSU.Comissao,
								TSU.QuemCad,
								TSU.Arquivo,
								TSU.Email
							FROM 
								Sis_Usuario AS TSU
							WHERE
								'".$idSis_Empresa."' = '".$emp."' AND
								TSU.idSis_Empresa = '".$emp."' AND
								TSU.idSis_Usuario = '".$usuario."' AND
								Inativo = '0' AND
								Vendas = 'S' AND 
								Cad_Orcam = 'S'
							LIMIT 1";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		$count_usuario = mysqli_num_rows($resultado_usuario);

		if($count_usuario == 0){
			//Não faço nada
		}else{
			$row_usuario = mysqli_fetch_array($resultado_usuario, MYSQLI_ASSOC);
			//$row_usuario = mysqli_fetch_assoc($resultado_usuario);
			
			if(empty($row_usuario['Codigo'])){
				//Não faço nada
			}else{

				unset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa], 
						$_SESSION['Site_Back']['Nome_Vendedor'.$idSis_Empresa],
						$_SESSION['Site_Back']['Nivel_Vendedor'.$idSis_Empresa],  
						$_SESSION['Site_Back']['Arquivo_Vendedor'.$idSis_Empresa],
						$_SESSION['Site_Back']['Comissao_Vendedor'.$idSis_Empresa]);
						
				unset($_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa], 
						$_SESSION['Site_Back']['Nome_Usuario'.$idSis_Empresa],				
						$_SESSION['Site_Back']['Arquivo_Usuario'.$idSis_Empresa]);
				
				if(!isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa])){
					$_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa] = $row_usuario['idSis_Usuario'];
					$_SESSION['Site_Back']['Nome_Vendedor'.$idSis_Empresa] = $row_usuario['Nome'];
					$_SESSION['Site_Back']['Nivel_Vendedor'.$idSis_Empresa] = $row_usuario['Nivel'];
					$_SESSION['Site_Back']['Arquivo_Vendedor'.$idSis_Empresa] = $row_usuario['Arquivo'];
					
					if($row_usuario['Nivel'] != 2){
						$_SESSION['Site_Back']['Comissao_Vendedor'.$idSis_Empresa] = $row_usuario['Comissao'];
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
												idSis_Usuario = '".$row_usuario['QuemCad']."' AND
												Inativo = '0' AND
												Vendas = 'S' AND 
												Cad_Orcam = 'S'
											LIMIT 1";
						$resultado_funcionario = mysqli_query($conn, $result_funcionario);
						
						$count_funcionario = mysqli_num_rows($resultado_funcionario);
						
						if($count_funcionario == 0){
							//NÃO Retornou nenhum funcionario
							$_SESSION['Site_Back']['Comissao_Vendedor'.$idSis_Empresa] = $row_usuario['Comissao'];
						} else {
							//Retornou funcionario
							$row_funcionario = mysqli_fetch_array($resultado_funcionario, MYSQLI_ASSOC);
							
							$_SESSION['Site_Back']['Comissao_Vendedor'.$idSis_Empresa] = $row_funcionario['Comissao'];
						}
					}
				}
			}
		}
	}
	
	if(isset($row_empresa['AssociadoAtivo']) && $row_empresa['AssociadoAtivo'] == "S"){ 
		if((isset($_GET['emp'])) && (isset($_GET['associado']))){

			$emp = addslashes($_GET['emp']);
			$associado = addslashes($_GET['associado']);
			
			$result_cliente = "SELECT 
									TSUO.idSis_Empresa,
									TSUO.Codigo,
									TSUO.idSis_Associado,
									TSUO.ClienteConsultor
								FROM 
									App_Cliente AS TSUO
								WHERE 
									'".$idSis_Empresa."' = '".$emp."' AND
									TSUO.idSis_Associado = '".$associado."' AND
									TSUO.ClienteConsultor = 'S'
								LIMIT 1";
								//TSUO.Codigo = '".$associado."' AND//		
			$resultado_cliente = mysqli_query($conn, $result_cliente);		
			$row_cliente = mysqli_fetch_array($resultado_cliente, MYSQLI_ASSOC);
			$count_cliente = mysqli_num_rows($resultado_cliente);
			
			$result_associado = "SELECT 
									TSU.idSis_Associado,
									TSU.Codigo,
									TSU.Nome,
									TSU.Arquivo,
									TSU.Email
								FROM 
									Sis_Associado AS TSU
								WHERE 
									TSU.idSis_Associado = '".$associado."'
								LIMIT 1";
			$resultado_associado = mysqli_query($conn, $result_associado);
			$row_associado = mysqli_fetch_array($resultado_associado, MYSQLI_ASSOC);
			//$row_associado = mysqli_fetch_assoc($resultado_associado);
			$count_associado = mysqli_num_rows($resultado_associado);
			
			if($count_cliente == 0 || $count_associado == 0 || empty($row_cliente['Codigo']) || empty($row_associado['Codigo']) || ($row_cliente['Codigo'] != $row_associado['Codigo'])){
				//Não faço nada
			}else{
				unset($_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa], 
						$_SESSION['Site_Back']['Nome_Usuario'.$idSis_Empresa], 
						$_SESSION['Site_Back']['Arquivo_Usuario'.$idSis_Empresa]);
				
				if(!isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa])){
					if(!isset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa])){
						if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]) && isset($_SESSION['Site_Back']['id_Associado'.$idSis_Empresa])){
							if($_SESSION['Site_Back']['id_Associado'.$idSis_Empresa] != $associado){
								
								$_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa] = $row_associado['idSis_Associado'];
								$_SESSION['Site_Back']['Nome_Usuario'.$idSis_Empresa] = $row_associado['Nome'];
								$_SESSION['Site_Back']['Arquivo_Usuario'.$idSis_Empresa] = $row_associado['Arquivo'];
							}else{
								//Não faço nada		
							}
						}else{
							//unset($_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa], $_SESSION['Site_Back']['Nome_Usuario'.$idSis_Empresa], $_SESSION['Site_Back']['Arquivo_Usuario'.$idSis_Empresa]);
							
							$_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa] = $row_associado['idSis_Associado'];
							$_SESSION['Site_Back']['Nome_Usuario'.$idSis_Empresa] = $row_associado['Nome'];
							$_SESSION['Site_Back']['Arquivo_Usuario'.$idSis_Empresa] = $row_associado['Arquivo'];			
						}
					}
				}
			}
		}
	}	
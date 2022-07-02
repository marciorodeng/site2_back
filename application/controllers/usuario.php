<?php

	if((isset($_GET['emp'])) && (isset($_GET['usuario']))){
		
		$emp = addslashes($_GET['emp']);
		$usuario = addslashes($_GET['usuario']);
		$result_usuario = "SELECT 
								TSUO.idSis_Empresa,
								TSUO.Codigo,
								TSUO.idSis_Usuario,
								TSU.Nome,
								TSU.Arquivo,
								TSU.Email
							FROM 
								Sis_Usuario_Online AS TSUO
									LEFT JOIN Sis_Usuario AS TSU ON TSU.idSis_Usuario = TSUO.idSis_Usuario
							WHERE 
								'".$idSis_Empresa."' = '".$emp."' AND
								TSUO.Codigo = '".$usuario."'
							LIMIT 1";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		
		//$row_usuario = mysqli_fetch_assoc($resultado_usuario);
		
		$row_usuario = mysqli_fetch_array($resultado_usuario, MYSQLI_ASSOC);
		
		$count = mysqli_num_rows($resultado_usuario);
		
		if($count ==0){
			unset(	$_SESSION['id_Usuario'],
					$_SESSION['Nome_Usuario'],
					$_SESSION['Arquivo_Usuario']
					);
			$_SESSION['id_Usuario'] = 1;		
		}else{		
			$_SESSION['id_Usuario'] = $row_usuario['idSis_Usuario'];
			$_SESSION['Nome_Usuario'] = $row_usuario['Nome'];
			$_SESSION['Arquivo_Usuario'] = $row_usuario['Arquivo'];
		}
	}else if(isset($_SESSION['id_Usuario'])){
		$id_usuario_online = $_SESSION['id_Usuario'];
	} else{
		unset(	$_SESSION['id_Usuario'],
				$_SESSION['Nome_Usuario'],
				$_SESSION['Arquivo_Usuario']
				);		
		$_SESSION['id_Usuario'] = 1;		
	}
	
?>
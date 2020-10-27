<?php

	if((isset($_GET['emp'])) && (isset($_GET['usuario']))){
		
		$emp = addslashes($_GET['emp']);
		$usuario = addslashes($_GET['usuario']);
		$result_usuario = "SELECT 
								TSUO.idSis_Empresa,
								TSUO.Codigo,
								TSUO.idSis_Usuario_5,
								TSUO.ClienteConsultor,
								TSU.Nome,
								TSU.Arquivo,
								TSU.Email
							FROM 
								App_Cliente AS TSUO
									LEFT JOIN Sis_Usuario AS TSU ON TSU.idSis_Usuario = TSUO.idSis_Usuario_5
							WHERE 
								'".$idSis_Empresa."' = '".$emp."' AND
								TSUO.Codigo = '".$usuario."' AND
								TSUO.ClienteConsultor = 'S'
							LIMIT 1";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		
		//$row_usuario = mysqli_fetch_assoc($resultado_usuario);
		
		$row_usuario = mysqli_fetch_array($resultado_usuario, MYSQLI_ASSOC);
		
		$count = mysqli_num_rows($resultado_usuario);
		
		if($count ==0){
			//unset($_SESSION['id_Usuario'.$idSis_Empresa], $_SESSION['Nome_Usuario'.$idSis_Empresa], $_SESSION['Arquivo_Usuario'.$idSis_Empresa], $_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]);
			//$_SESSION['id_Usuario'.$idSis_Empresa] = 1;
			//header("Location: ../inicial.php");
			header("Location: ../produtos.php");
		}else{		
			unset($_SESSION['id_Usuario'.$idSis_Empresa], $_SESSION['Nome_Usuario'.$idSis_Empresa], $_SESSION['Arquivo_Usuario'.$idSis_Empresa]);
			$_SESSION['id_Usuario'.$idSis_Empresa] = $row_usuario['idSis_Usuario_5'];
			$_SESSION['Nome_Usuario'.$idSis_Empresa] = $row_usuario['Nome'];
			$_SESSION['Arquivo_Usuario'.$idSis_Empresa] = $row_usuario['Arquivo'];
			header("Location: ../produtos.php");
		}
	} else{
		//unset($_SESSION['id_Usuario'.$idSis_Empresa],$_SESSION['Nome_Usuario'.$idSis_Empresa],$_SESSION['Arquivo_Usuario'.$idSis_Empresa], $_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]);		
		//$_SESSION['id_Usuario'.$idSis_Empresa] = 1;
		//echo '<script> window.location = "../inicial.php" </script>';
		//header("Location: ../inicial.php");
		header("Location: ../produtos.php");
	}
	
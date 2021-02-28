<?php

	if((isset($_GET['emp'])) && (isset($_GET['usuario']))){

		$emp = addslashes($_GET['emp']);
		$usuario = addslashes($_GET['usuario']);
		
		$result_cliente = "SELECT 
								TSUO.idSis_Empresa,
								TSUO.Codigo,
								TSUO.idSis_Usuario_5,
								TSUO.ClienteConsultor
							FROM 
								App_Cliente AS TSUO
							WHERE 
								'".$idSis_Empresa."' = '".$emp."' AND
								TSUO.idSis_Usuario_5 = '".$usuario."' AND
								TSUO.ClienteConsultor = 'S'
							LIMIT 1";
							//TSUO.Codigo = '".$usuario."' AND//		
		$resultado_cliente = mysqli_query($conn, $result_cliente);		
		$row_cliente = mysqli_fetch_array($resultado_cliente, MYSQLI_ASSOC);
		$count_cliente = mysqli_num_rows($resultado_cliente);

		
		$result_usuario = "SELECT 
								TSU.idSis_Usuario,
								TSU.Codigo,
								TSU.Nome,
								TSU.Arquivo,
								TSU.Email
							FROM 
								Sis_Usuario AS TSU
							WHERE 
								TSU.idSis_Empresa = '5' AND
								TSU.idSis_Usuario = '".$usuario."'
							LIMIT 1";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		$row_usuario = mysqli_fetch_array($resultado_usuario, MYSQLI_ASSOC);
		//$row_usuario = mysqli_fetch_assoc($resultado_usuario);
		$count_usuario = mysqli_num_rows($resultado_usuario);
		/*
		echo "<pre>";
		print_r($_GET['emp']);
		echo '<br>';
		print_r($_GET['usuario']);
		echo '<br>';
		print_r($count_cliente);
		echo '<br>';
		print_r($count_usuario);
		echo '<br>';
		print_r($row_cliente['Codigo']);
		echo '<br>';
		print_r($row_usuario['Codigo']);
		echo "</pre>";
		exit();		
		*/
		if($count_cliente == 0 || $count_usuario == 0 || empty($row_cliente['Codigo']) || empty($row_usuario['Codigo']) || ($row_cliente['Codigo'] != $row_usuario['Codigo'])){
			//unset($_SESSION['id_Usuario'.$idSis_Empresa], $_SESSION['Nome_Usuario'.$idSis_Empresa], $_SESSION['Arquivo_Usuario'.$idSis_Empresa], $_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]);
			//$_SESSION['id_Usuario'.$idSis_Empresa] = 1;
			//header("Location: ../inicial.php");
			header("Location: ../produtos.php");
		}else{		
			unset($_SESSION['id_Usuario'.$idSis_Empresa], $_SESSION['Nome_Usuario'.$idSis_Empresa], $_SESSION['Arquivo_Usuario'.$idSis_Empresa]);
			$_SESSION['id_Usuario'.$idSis_Empresa] = $row_usuario['idSis_Usuario'];
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
	
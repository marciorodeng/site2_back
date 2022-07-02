<?php

	if((isset($_GET['emp'])) && (isset($_GET['usuario']))){

		$emp = addslashes($_GET['emp']);
		$usuario = addslashes($_GET['usuario']);
		
		$result_usuario = "SELECT 
								TSU.idSis_Usuario,
								TSU.Codigo,
								TSU.Nome,
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
		if($count_usuario == 0 || empty($row_usuario['Codigo'])){
			//Não faço nada
		}else{
			unset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa], $_SESSION['Site_Back']['Nome_Vendedor'.$idSis_Empresa], $_SESSION['Site_Back']['Arquivo_Vendedor'.$idSis_Empresa]);
			if(!isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa])){
				$_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa] = $row_usuario['idSis_Usuario'];
				$_SESSION['Site_Back']['Nome_Vendedor'.$idSis_Empresa] = $row_usuario['Nome'];
				$_SESSION['Site_Back']['Arquivo_Vendedor'.$idSis_Empresa] = $row_usuario['Arquivo'];
			}
		}
		header("Location: ../produtos.php");
		
	}else{
		//echo '<script> window.location = "../inicial.php" </script>';
		header("Location: produtos.php");
	}
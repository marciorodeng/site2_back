<?php

	unset(	$_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa], 
			$_SESSION['Site_Back']['Nome_Usuario'.$idSis_Empresa], 
			$_SESSION['Site_Back']['Arquivo_Usuario'.$idSis_Empresa]
			
			/*
			$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa], 
			$_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa], 
			$_SESSION['Site_Back']['Email_Cliente'.$idSis_Empresa],
			$_SESSION['Site_Back']['Cep_Cliente'.$idSis_Empresa],
			$_SESSION['Site_Back']['Endereco_Cliente'.$idSis_Empresa],
			$_SESSION['Site_Back']['Numero_Cliente'.$idSis_Empresa],
			$_SESSION['Site_Back']['Complemento_Cliente'.$idSis_Empresa],
			$_SESSION['Site_Back']['Bairro_Cliente'.$idSis_Empresa],
			$_SESSION['Site_Back']['Cidade_Cliente'.$idSis_Empresa],
			$_SESSION['Site_Back']['Estado_Cliente']
			*/
			
	);
	If(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]) && isset($_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]])){
		unset(
			$_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]]	
		);
	}	
	$_SESSION['Site_Back']['id_Usuario'.$idSis_Empresa] = 1;		
	//echo '<script> window.location = "inicial.php" </script>';
	//header("Location: inicial.php");
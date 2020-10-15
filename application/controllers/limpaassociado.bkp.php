<?php

	unset(	$_SESSION['id_Usuario'.$idSis_Empresa], 
			$_SESSION['Nome_Usuario'.$idSis_Empresa], 
			$_SESSION['Arquivo_Usuario'.$idSis_Empresa]
			
			/*
			$_SESSION['id_Cliente'.$idSis_Empresa], 
			$_SESSION['Nome_Cliente'.$idSis_Empresa], 
			$_SESSION['Email_Cliente'.$idSis_Empresa],
			$_SESSION['Cep_Cliente'.$idSis_Empresa],
			$_SESSION['Endereco_Cliente'.$idSis_Empresa],
			$_SESSION['Numero_Cliente'.$idSis_Empresa],
			$_SESSION['Complemento_Cliente'.$idSis_Empresa],
			$_SESSION['Bairro_Cliente'.$idSis_Empresa],
			$_SESSION['Cidade_Cliente'.$idSis_Empresa],
			$_SESSION['Estado_Cliente']
			*/
			
	);
	If(isset($_SESSION['id_Cliente'.$idSis_Empresa]) && isset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]])){
		unset(
			$_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]	
		);
	}	
	$_SESSION['id_Usuario'.$idSis_Empresa] = 1;		
	//echo '<script> window.location = "inicial.php" </script>';
	//header("Location: inicial.php");
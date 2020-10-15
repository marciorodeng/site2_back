<?php
unset(	$_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]], 
		$_SESSION['total_produtos'.$_SESSION['id_Cliente'.$idSis_Empresa]],
		$_SESSION['id_Cliente'.$idSis_Empresa], 
		$_SESSION['Nome_Cliente'.$idSis_Empresa], 
		$_SESSION['Email_Cliente'.$idSis_Empresa],
		$_SESSION['Cep_Cliente'.$idSis_Empresa],
		$_SESSION['Endereco_Cliente'.$idSis_Empresa],
		$_SESSION['Numero_Cliente'.$idSis_Empresa],
		$_SESSION['Complemento_Cliente'.$idSis_Empresa],
		$_SESSION['Bairro_Cliente'.$idSis_Empresa],
		$_SESSION['Cidade_Cliente'.$idSis_Empresa],
		$_SESSION['Estado_Cliente'.$idSis_Empresa]	
		);

//$_SESSION['msg'] = "Deslogado com sucesso";
//header("Location: index.php");
header("Location: inicial.php");
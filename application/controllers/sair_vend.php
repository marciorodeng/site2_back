<?php
unset(	$_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa],
		$_SESSION['Site_Back']['Nome_Usuario_vend'.$idSis_Empresa],
		$_SESSION['Site_Back']['Arquivo_Usuario_vend'.$idSis_Empresa],
		$_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa],
		$_SESSION['Site_Back']['Nome_Vendedor'.$idSis_Empresa],
		$_SESSION['Site_Back']['Arquivo_Vendedor'.$idSis_Empresa]
	);

$_SESSION['Site_Back']['msg'] = "Deslogado com sucesso";
//header("Location: index.php");
header("Location: login_usuario.php");
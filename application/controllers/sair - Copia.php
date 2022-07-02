<?php
unset(	$_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]], 
		$_SESSION['Site_Back']['total_produtos'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]],
		$_SESSION['Site_Back']['Arquivo_Cliente'.$idSis_Empresa],
		$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa], 
		$_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa], 
		$_SESSION['Site_Back']['Email_Cliente'.$idSis_Empresa],
		$_SESSION['Site_Back']['Cep_Cliente'.$idSis_Empresa],
		$_SESSION['Site_Back']['Endereco_Cliente'.$idSis_Empresa],
		$_SESSION['Site_Back']['Numero_Cliente'.$idSis_Empresa],
		$_SESSION['Site_Back']['Complemento_Cliente'.$idSis_Empresa],
		$_SESSION['Site_Back']['Bairro_Cliente'.$idSis_Empresa],
		$_SESSION['Site_Back']['Cidade_Cliente'.$idSis_Empresa],
		$_SESSION['Site_Back']['Estado_Cliente'.$idSis_Empresa]	
		);

$_SESSION['Site_Back']['msg'] = "Deslogado com sucesso";
//header("Location: index.php");
if(isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa])){
	header("Location: pesquisar_cliente.php");
}else{
	header("Location: login_cliente.php");
}

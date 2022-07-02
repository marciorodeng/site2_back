<?php
	
	$emp = addslashes($_GET['emp']);
	$usuario = addslashes($_GET['usuario']);
	
	$result_link = "SELECT * FROM App_Cliente WHERE idSis_Empresa = '".$emp."' AND idSis_Associado = '".$usuario."'";
	$resultado_link = mysqli_query($conn, $result_link);
	$row_link = mysqli_fetch_assoc($resultado_link);
	

	
	if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];
	}	
?>
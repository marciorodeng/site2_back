<?php
	
	$emp = addslashes($_GET['emp']);
	$usuario = addslashes($_GET['usuario']);
	
	$result_link = "SELECT * FROM Sis_Usuario_Online WHERE idSis_Empresa = '".$emp."' AND idSis_Usuario = '".$usuario."'";
	$resultado_link = mysqli_query($conn, $result_link);
	$row_link = mysqli_fetch_assoc($resultado_link);
	

	
	if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['id_Cliente'.$idSis_Empresa];
	}	
?>
<?php
	
	$code_pedido = addslashes($_GET['code']);
	$type_pedido = addslashes($_GET['type']);
	
	$result_link = "SELECT * FROM App_Pag_Online WHERE cod_trans = '".$code_pedido."'  ORDER BY idApp_Pag_Online ASC";
	$resultado_link = mysqli_query($conn, $result_link);
	$row_link = mysqli_fetch_assoc($resultado_link);
	

	
	if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['id_Cliente'.$idSis_Empresa];
	}	
?>
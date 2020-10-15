<?php 
	
	$id_pedido = addslashes($_GET['id']);	
	
	if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['id_Cliente'.$idSis_Empresa];
	}
	
	$result_cliente = "SELECT * FROM App_Cliente WHERE idApp_Cliente = '".$cliente."'";
	$resultado_cliente = mysqli_query($conn, $result_cliente);
	$row_cliente = mysqli_fetch_assoc($resultado_cliente);
		

	
	if(!isset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]])){
		$_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]] = array();
	}

?>
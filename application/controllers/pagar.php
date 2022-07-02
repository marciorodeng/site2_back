<?php 
	
	$id_pedido = addslashes($_GET['id']);	
	
	if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];
	}else{
		$cliente = FALSE;
		echo "<script>window.location = 'index.php'</script>";
		exit();
	}
	
	$result_cliente = "SELECT * FROM App_Cliente WHERE idApp_Cliente = '".$cliente."'";
	$resultado_cliente = mysqli_query($conn, $result_cliente);
	$row_cliente = mysqli_fetch_assoc($resultado_cliente);

	if(!isset($_SESSION['Site_Back']['carrinho'.$idSis_Empresa])){
		$_SESSION['Site_Back']['carrinho'.$idSis_Empresa] = array();
	}
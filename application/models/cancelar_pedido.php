<?php 
	if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){
		
		$cliente = $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];
		
		if($_GET['id']){
			
			$id_pedido = addslashes($_GET['id']);
			
			$result_pedido = "SELECT *
								FROM 
									App_OrcaTrata 
								WHERE 
									idApp_OrcaTrata = '".$id_pedido."' AND
									idApp_Cliente = '".$cliente."' AND
									idSis_Empresa = '" .$idSis_Empresa. "'
								LIMIT 1";
			$resultado_pedido = mysqli_query($conn, $result_pedido);
			$row_pedido = mysqli_fetch_array($resultado_pedido, MYSQLI_ASSOC);
			$count = mysqli_num_rows($resultado_pedido);
			
			if($count ==0){
				header("Location: meus_pedidos.php");
			}else{
				$update_pedido = "UPDATE 
									App_OrcaTrata 
								SET 
									AprovadoOrca = 'N',
									CanceladoOrca = 'S',
									ObsOrca = 'Cancelado pelo Cliente, na hora da confirmacao.'
								WHERE 
									idApp_OrcaTrata = '".$id_pedido."'
								";
				mysqli_query($conn, $update_pedido);

				echo "<script>window.location = 'meus_pedidos.php'</script>";
			}
		}else{
			$_SESSION['Site_Back']['msg'] = "Página não encontrada";
			header("Location: meus_pedidos.php");
		}	
	}else{
		$_SESSION['Site_Back']['msg'] = "Página não encontrada";
		header("Location: login_cliente.php");
	}
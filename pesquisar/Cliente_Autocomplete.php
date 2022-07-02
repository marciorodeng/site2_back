<?php
include_once '../application/config/conexao.php';
if ($_GET['id_empresa']) {
	$id_empresa = $_GET['id_empresa'];
}
if ($_GET['usuario_vend']) {
	$usuario_vend = $_GET['usuario_vend'];
}else{
	$usuario_vend = false;
}
if ($_GET['nivel_vend']) {
	$nivel_vend = $_GET['nivel_vend'];
}else{
	$nivel_vend = 1;
}
$cliente = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

$clientex = explode(' ', $cliente);

if (isset($clientex[2]) && $clientex[2] != ''){
	
	$cliente2 = $clientex[2];
	
	if (isset($cliente2)){
	
		if(is_numeric($cliente2)){
			
			$query2 = '(CelularCliente like "%' . $cliente2 . '%" OR '
						. 'Telefone like "%' . $cliente2 . '%" OR '
						. 'Telefone2 like "%' . $cliente2 . '%" OR '
						. 'Telefone3 like "%' . $cliente2 . '%" )';
					
		}else{
		
			$query2 = '(NomeCliente like "%' . $cliente2 . '%" )';
		}
	}	
	$filtro2 = ' AND ' . $query2 ;
} else {
	$filtro2 = FALSE ;
}

if (isset($clientex[1]) && $clientex[1] != ''){
	$cliente0 = $clientex[0];
	$cliente1 = $clientex[1];
	
	if (isset($cliente1)){	
		if(is_numeric($cliente1)){
			
			$query1 = '(CelularCliente like "%' . $cliente1 . '%" OR '
						. 'Telefone like "%' . $cliente1 . '%" OR '
						. 'Telefone2 like "%' . $cliente1 . '%" OR '
						. 'Telefone3 like "%' . $cliente1 . '%" )';
					
		}else{
			$query1 = '(NomeCliente like "%' . $cliente1 . '%" )';
		}
	}	
	$filtro1 = ' AND ' . $query1 ;
	
}else{
	$cliente0 = $cliente;
	$filtro1 = FALSE;
}

if(is_numeric($cliente0)){
	
	$query0 = '(CelularCliente like "%' . $cliente0 . '%" OR '
				. 'Telefone like "%' . $cliente0 . '%" OR '
				. 'Telefone2 like "%' . $cliente0 . '%" OR '
				. 'Telefone3 like "%' . $cliente0 . '%" )';
			
}else{
	$query0 = '(NomeCliente like "%' . $cliente0 . '%" )';
}

if($usuario_vend){
	if($nivel_vend == 2){
		$revendedor = '(NivelCliente = "1" OR idSis_Usuario = ' . $usuario_vend . ') AND ';
	}else{
		$revendedor = FALSE;
	}	
}else{
	$revendedor = FALSE;
}		

//SQL para selecionar os registros
$result_msg_cont = '
					SELECT 
						idApp_Cliente, 
						NomeCliente,
						CelularCliente,
						Telefone,
						Telefone2,
						Telefone3
					FROM 
						App_Cliente
					WHERE
						idSis_Empresa = ' . $id_empresa . ' AND
						' . $revendedor . '
						(' . $query0 . ' ' . $filtro1 . ' ' . $filtro2 . ')
					ORDER BY NomeCliente ASC 
					LIMIT 7
				';

//Seleciona os registros
$resultado_msg_cont = $pdo->prepare($result_msg_cont);
$resultado_msg_cont->execute();

while($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)){
	
    //$data[] = $row_msg_cont['NomeCliente'];
	//$data[] = $row_msg_cont['CelularCliente'];
	//$data[$row_msg_cont['CelularCliente']] = $row_msg_cont['CelularCliente'];
	$data[$row_msg_cont['idApp_Cliente']] = $row_msg_cont['idApp_Cliente'] . '# ' . $row_msg_cont['NomeCliente']
											. ' | Cel:' . $row_msg_cont['CelularCliente'] . ' | Tel1:' . $row_msg_cont['Telefone']
											. ' | Tel2:' . $row_msg_cont['Telefone2'] . ' | Tel3:' . $row_msg_cont['Telefone3'];
	
	//$data[$row_msg_cont['idSis_Usuario']] = $row_msg_cont['idSis_Usuario'] . '#' . $row_msg_cont['NomeCliente'] . ' | Cel:' . $row_msg_cont['CelularCliente'];
	//$data[$row_msg_cont['NomeCliente']] = $row_msg_cont['idSis_Usuario'];
	
	
}

echo json_encode($data);
<?php
	/*
	$result_doc = "SELECT * FROM App_Documentos WHERE idSis_Empresa = '".$idSis_Empresa."'  ORDER BY idApp_Documentos ASC";
	$resultado_documento = mysqli_query($conn, $result_doc);
	$row_documento = mysqli_fetch_assoc($resultado_documento);
	
	$result_empresa = "SELECT * FROM Sis_Empresa WHERE idSis_Empresa = '".$idSis_Empresa."'";
	$resultado_empresa = mysqli_query($conn, $result_empresa);
	$row_empresa = mysqli_fetch_assoc($resultado_empresa);
	*/
?>

<?php

	$result_doc = "SELECT * FROM App_Documentos WHERE idSis_Empresa = '".$idSis_Empresa."'  ORDER BY idApp_Documentos ASC";
	$resultado_documento = $pdo->prepare($result_doc);
	$resultado_documento->execute();
	$row_documento = $resultado_documento->fetch(PDO::FETCH_ASSOC);
	
	$result_empresa = "SELECT * FROM Sis_Empresa WHERE idSis_Empresa = '".$idSis_Empresa."'";
	$resultado_empresa = $pdo->prepare($result_empresa);
	$resultado_empresa->execute();
	$row_empresa = $resultado_empresa->fetch(PDO::FETCH_ASSOC);
	
	$dia_da_semana = date('N');
	$horario = date('H:i:s');
	$result_atend = "SELECT * FROM App_Atendimento WHERE idSis_Empresa = '".$idSis_Empresa."' AND id_Dia = '".$dia_da_semana."' AND Aberto = 'S'";
	$resultado_atend = mysqli_query($conn, $result_atend);
	if(mysqli_num_rows($resultado_atend) > '0'){
		foreach($resultado_atend as $resultado_atend_view){
			//$aberto 	= $resultado_atend_view['Aberto'];
			$hora_abre 	= $resultado_atend_view['Hora_Abre'];
			$hora_fecha = $resultado_atend_view['Hora_Fecha'];
			if($horario >= $hora_abre && $horario <= $hora_fecha){
				$loja_aberta = true;
			}else{
				$loja_aberta = false;
			}
		}
	}else{
		$loja_aberta = false;
	}
?>


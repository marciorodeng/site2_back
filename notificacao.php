<?php
	//session_start();
	//require 'php/conn.php';
	include './configuracao.php';
	include './application/config/conexao.php';

if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){	


	//$id_pedido = addslashes($_GET['id']);

	$notificationCode = preg_replace('/[^[:alnum:]-]/','',$_POST["notificationCode"]);

	$data['token'] = 'A058483B1624431FB344C5FB79A44A4E';
	$data['email'] = 'marciorodeng@gmail.com';

	$data = http_build_query($data);

	$url = 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/'.$_POST["notificationCode"].'?'.$data;
	//$url = 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/'.$_POST["notificationCode"].'?'.$data;
	//$url = 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/'.$notificationCode.'?'.$data;
	//$url = 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/{$_POST["notificationCode"]}?email="marciorodeng@gmail.com"&token="A058483B1624431FB344C5FB79A44A4E"';

	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
	//curl_setopt($curl, CURLOPT_URL, $url);
	//curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

	$Retorno = curl_exec($curl);

	curl_close($curl);

	$xml = simplexml_load_string($Retorno);

	$curl=$pdo->prepare("update App_OrcaTrata set status=? where idApp_OrcaTrata=?");
	$curl->bindValue(1,$xml->status);
	$curl->bindValue(2,$xml->reference);	
	$curl->execute();
	
	if(isset($xml->status) && ($xml->status == '3' || $xml->status == '4' || $xml->status == '5')){	
		$curl2=$pdo->prepare("update App_OrcaTrata set AprovadoOrca=? where idApp_OrcaTrata=?");
		$curl2->bindValue(1,S);
		$curl2->bindValue(2,$xml->reference);	
		$curl2->execute();	
	}else if(isset($xml->status) && ($xml->status == '1' || $xml->status == '2' || $xml->status == '6' || $xml->status == '7' || $xml->status == '8' || $xml->status == '9')){
		$curl2=$pdo->prepare("update App_OrcaTrata set AprovadoOrca=? where idApp_OrcaTrata=?");
		$curl2->bindValue(1,N);
		$curl2->bindValue(2,$xml->reference);	
		$curl2->execute();	
	}
	
	if(isset($xml->status) && ($xml->status == '3' || $xml->status == '4' || $xml->status == '5')){	
		$curl3=$pdo->prepare("update App_Parcelas set Quitado=? where idApp_OrcaTrata=?");
		$curl3->bindValue(1,S);
		$curl3->bindValue(2,$xml->reference);	
		$curl3->execute();	
	}else if(isset($xml->status) && ($xml->status == '1' || $xml->status == '2' || $xml->status == '6' || $xml->status == '7' || $xml->status == '8' || $xml->status == '9')){
		$curl3=$pdo->prepare("update App_OrcaTrata set Quitado=? where idApp_OrcaTrata=?");
		$curl3->bindValue(1,N);
		$curl3->bindValue(2,$xml->reference);	
		$curl3->execute();	
	}	
	
}	
?>
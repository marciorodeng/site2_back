<?php
/*
	// ""Servidor na Nuvem""
	$servidor = "159.89.138.173";
	$usuario = "usuario";
	$senha = "20UtpJ15";
*/	
	// ""Servidor Local""
	$servidor = "localhost";
	$usuario = "root";
	$senha = "";
	

	//Ambiente de Testes 
	//$dbname = "app.testes3";	
	
	//Ambiente de Produção 
	$dbname = "app";	
	
	//Criar a conexao
	$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

?>

<?php
/*
	// ""Servidor na Nuvem""
	//$servidor = "159.89.138.173";
	$servidor = "191.252.200.10";
	$usuario = "usuario";
	$senha = "20UtpJ15";
	$sistema = "sistema";
	//$sistema = "sistematestes3";
*/		
	// ""Servidor Local""
	$servidor = "localhost";
	$usuario = "root";
	$senha = "";
	$sistema = "sistema";
	//$sistema = "sistemaantigo";
	//$sistema = "sistematestes3";	

	// ""Ambiente de Testes"" 
	//$dbname = "app";
	//$dbname = "app.testes3";
	//$sandbox = true;	
	
	// ""Ambiente de Produção""
	$dbname = "app";
	//$sistema = "sistema";
	$sandbox = false;
	
	$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
	$pdo = new PDO('mysql:host=' . $servidor . ';dbname=' . $dbname . ';', $usuario, $senha);
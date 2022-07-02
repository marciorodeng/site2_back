<?php
/*
// Servidor Local	
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
*/
/*
// Servidor Nuvem
define('HOST', '159.89.138.173');
define('USER', 'usuario');
define('PASS', '20UtpJ15');
*/
/*
// AMbiente de Produção
define('DBNAME', 'app');
*/
// Ambiente de Testes
//define('DBNAME', 'app.testes3');

/*	
	// Servidor Local
	$servidor = "localhost";
	$usuario = "root";
	$senha = "";
*/
	
	// Servidor na Nuvem
	$servidor = "159.89.138.173";
	$usuario = "usuario";
	$senha = "20UtpJ15";
	
	//Ambiente de Testes 
	$dbname = "app.testes3";	
	
	//Ambiente de Produção 
	//$dbname = "app";	

//$pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME . ';', USER, PASS);
$pdo = new PDO('mysql:host=' . $servidor . ';dbname=' . $dbname . ';', $usuario, $senha);
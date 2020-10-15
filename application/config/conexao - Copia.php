<?php
/*
// Servidor Local	
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
*/

// Servidor Nuvem
define('HOST', '159.89.138.173');
define('USER', 'usuario');
define('PASS', '20UtpJ15');

/*
// AMbiente de Produção
define('DBNAME', 'app');
*/
// Ambiente de Testes
define('DBNAME', 'app.testes3');

$pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME . ';', USER, PASS);
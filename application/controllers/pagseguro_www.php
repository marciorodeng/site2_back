<?php

define("URL", "https://www.enkontraki.com.br/". $row_empresa['Site']."/");
define("URL_NOTIFICACAO", "https://www.enkontraki.com.br/".$row_empresa['Site']."/notificacao.php");
define("EMAIL_LOJA", $row_documento['Email_Loja']);
define("EMAIL_PAGSEGURO", $row_documento['Email_Pagseguro']);
define("MOEDA_PAGAMENTO", "BRL");

$prod_pagseguro = $row_documento['Prod_PagSeguro'];

if($prod_pagseguro == "N"){
    //Credenciais do SandBox
	define("TOKEN_PAGSEGURO", $row_documento['Token_Sandbox']);
	define("URL_PAGSEGURO", "https://ws.sandbox.pagseguro.uol.com.br/v2/");
    define("SCRIPT_PAGSEGURO", "https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js");
	define("URL_NOTIFICACAO_PAGSEGURO", "https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/");
}elseif($prod_pagseguro == "S"){
    //Credenciais do PagSeguro
	define("TOKEN_PAGSEGURO", $row_documento['Token_Producao']);
	define("URL_PAGSEGURO", "https://ws.pagseguro.uol.com.br/v2/");
    define("SCRIPT_PAGSEGURO", "https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js");
	define("URL_NOTIFICACAO_PAGSEGURO", "https://ws.pagseguro.uol.com.br/v3/transactions/notifications/");
}
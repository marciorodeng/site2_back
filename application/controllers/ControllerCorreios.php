<?php
	
include("ClassCorreios.php");

$CepOrigem=filter_input(INPUT_POST,'CepOrigem',FILTER_SANITIZE_SPECIAL_CHARS);
$CepDestino=filter_input(INPUT_POST,'CepDestino',FILTER_SANITIZE_SPECIAL_CHARS);
$Peso=filter_input(INPUT_POST,'Peso',FILTER_SANITIZE_SPECIAL_CHARS);
$Formato=filter_input(INPUT_POST,'Formato',FILTER_SANITIZE_SPECIAL_CHARS);
$Comprimento=filter_input(INPUT_POST,'Comprimento',FILTER_SANITIZE_SPECIAL_CHARS);
$Altura=filter_input(INPUT_POST,'Altura',FILTER_SANITIZE_SPECIAL_CHARS);
$Largura=filter_input(INPUT_POST,'Largura',FILTER_SANITIZE_SPECIAL_CHARS);
$MaoPropria=filter_input(INPUT_POST,'MaoPropria',FILTER_SANITIZE_SPECIAL_CHARS);
$ValorDeclarado=filter_input(INPUT_POST,'ValorDeclarado',FILTER_SANITIZE_SPECIAL_CHARS);
$AvisoRecebimento=filter_input(INPUT_POST,'AvisoRecebimento',FILTER_SANITIZE_SPECIAL_CHARS);
$Codigo=filter_input(INPUT_POST,'Codigo',FILTER_SANITIZE_SPECIAL_CHARS);
$Diametro=filter_input(INPUT_POST,'Diametro',FILTER_SANITIZE_SPECIAL_CHARS);

$Correios=new ClassCorreios();
$Correios->pesquisaPrecoPrazo($CepOrigem,$CepDestino,$Peso,$Formato,$Comprimento,$Altura,$Largura,$MaoPropria,$ValorDeclarado,$AvisoRecebimento,$Codigo,$Diametro);	
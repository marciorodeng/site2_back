<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Calcula Frete</title>
        <?php require_once ("application/views/head.php"); ?>		
    </head>
    <body>
		<br>
		Cep Destino = <input id="cep_destino" type="text" value="" maxlength="8"/><br>
		
		Valor do Produto = <input id="valor_prod" type="text" value="55,00"/><br>
		
		Valor do Frete = <input id="valor_frete" type="text" value=""/><br>
		
		Valor Total = <input id="valor_total" type="text" value=""/><br>
		
		<form>
			<button type="button" onclick="LoadFrete();">Calcular Frete</button>
		</form>

		<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
        <!--<script src="js/frete2.js"></script>-->
		<script src="js/Javascript2.js"></script>
    </body>
</html>	
	
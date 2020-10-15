<?php	


    public function calcula_frete($CepOrigem,$CepDestino,$Peso,$Formato,$Comprimento,$Altura,$Largura,$MaoPropria,$ValorDeclarado,$AvisoRecebimento,$Codigo,$Diametro)
    {
        $Url="http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem={$CepOrigem}&sCepDestino={$CepDestino}&nVlPeso={$Peso}&nCdFormato={$Formato}&nVlComprimento={$Comprimento}&nVlAltura={$Altura}&nVlLargura={$Largura}&sCdMaoPropria={$MaoPropria}&nVlValorDeclarado={$ValorDeclarado}&sCdAvisoRecebimento={$AvisoRecebimento}&nCdServico={$Codigo}&nVlDiametro={$Diametro}&StrRetorno=xml&nIndicaCalculo=3";
        
		//$this->Retorno=simplexml_load_string(file_get_contents($Url));
       
	   //var_dump($this->Retorno);

		//echo $Url;
		$xml = simplexml_load_file($Url);
		
		return $xml;
    }
		//calcula_frete($CepOrigem,$CepDestino,$Peso,$Formato,$Comprimento,$Altura,$Largura,$MaoPropria,$ValorDeclarado,$AvisoRecebimento,$Codigo,$Diametro);
		echo '<pre>';
		print_r(calcula_frete('24445360','24320040','1','1','30','5','15','N','2000','N','41106','0'));
		echo '</pre>';
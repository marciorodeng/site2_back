<?php	

class ClassCorreios{

    public $Retorno;

    #Pesquisa de preço e prazo de encomendas do correio
    public function pesquisaPrecoPrazo($CepOrigem,$CepDestino,$Peso,$Formato,$Comprimento,$Altura,$Largura,$MaoPropria,$ValorDeclarado,$AvisoRecebimento,$Codigo,$Diametro)
    {
        $Url="http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem={$CepOrigem}&sCepDestino={$CepDestino}&nVlPeso={$Peso}&nCdFormato={$Formato}&nVlComprimento={$Comprimento}&nVlAltura={$Altura}&nVlLargura={$Largura}&sCdMaoPropria={$MaoPropria}&nVlValorDeclarado={$ValorDeclarado}&sCdAvisoRecebimento={$AvisoRecebimento}&nCdServico={$Codigo}&nVlDiametro={$Diametro}&StrRetorno=xml&nIndicaCalculo=3";
        
		$this->Retorno=simplexml_load_string(file_get_contents($Url));
       
	   //var_dump($this->Retorno);
		
		$valor_frete = $this->Retorno->cServico->Valor;
		$prazo_entrega = $this->Retorno->cServico->PrazoEntrega;
		
		echo "Valor do Frete: R$ ".$valor_frete;
        echo "<br>";
        echo "Prazo de Entrega: ".$prazo_entrega."  "."dias úteis";		
		
		/*
		echo "Valor: R$ ".$this->Retorno->cServico->Valor;
        echo "<br>";
        echo "Prazo: ".$this->Retorno->cServico->PrazoEntrega."  "."dias úteis";
		*/
		
		//return $this->Retorno->cServico;
    }
}	
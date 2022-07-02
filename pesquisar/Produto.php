<?php
	
include_once '../application/config/conexao.php';

if (isset($_GET['id_empresa']) && isset($_GET['produto'])) {
	
	$id_empresa = $_GET['id_empresa'];
	$produto 	= $_GET['produto'];
	//echo json_encode($produto);

	$produtox = explode(' ', $produto);

	if (isset($produtox[2]) && $produtox[2] != ''){
		
		$produto2 = $produtox[2];
		
		if (isset($produto2)){
		
			$query2 = '(TPS.Nome_Prod like "%' . $produto2 . '%"  OR '
						. 'TPS.Produtos_Descricao like "%' . $produto2 . '%"  OR '
						. 'TPS.Cod_Prod like "%' . $produto2 . '%"  OR '
						. 'TPS.Cod_Barra like "%' . $produto2 . '%" )';
			
		}	
		$filtro2 = ' AND ' . $query2 ;
	} else {
		$filtro2 = FALSE ;
	}

	if (isset($produtox[1]) && $produtox[1] != ''){
		$produto0 = $produtox[0];
		$produto1 = $produtox[1];
		
		if (isset($produto1)){	
			
			$query1 = '(TPS.Nome_Prod like "%' . $produto1 . '%"  OR '
						. 'TPS.Produtos_Descricao like "%' . $produto1 . '%"  OR '
						. 'TPS.Cod_Prod like "%' . $produto1 . '%"  OR '
						. 'TPS.Cod_Barra like "%' . $produto1 . '%"  )';
			
		}	
		$filtro1 = ' AND ' . $query1 ;
		
	}else{
		$produto0 = $produto;
		$filtro1 = FALSE;
	}

	$query0 = '(TPS.Nome_Prod like "%' . $produto0 . '%"  OR '
				. 'TPS.Produtos_Descricao like "%' . $produto0 . '%"  OR '
				. 'TPS.Cod_Prod like "%' . $produto0 . '%"  OR '
				. 'TPS.Cod_Barra like "%' . $produto0 . '%"  )';
	
	if(!empty($produto) && $id_empresa != 0){
			
		$result = ('
			SELECT 
				TV.idTab_Valor,
				TV.idTab_Produto,
				TV.ValorProduto,
				TV.QtdProdutoDesconto,
				TV.QtdProdutoIncremento,
				TV.Convdesc,
				TV.idTab_Promocao,
				TV.Desconto,
				TV.ComissaoVenda,
				TV.ComissaoCashBack,
				TV.TempoDeEntrega,
				TPR.Promocao,
				TPR.Descricao,
				TPR.Ativo,
				TPR.VendaSite,
				TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TPS.idSis_Empresa,
				TPS.Nome_Prod,
				TPS.Arquivo,
				TPS.Valor_Produto,
				TPS.ContarEstoque,
				TPS.Estoque,
				IFNULL(TPS.Produtos_Descricao,"") AS DescProd,
				TPS.Cod_Prod,
				TPS.Cod_Barra,
				TOP2.Opcao AS Opcao2,
				TOP1.Opcao AS Opcao1,
				TP.idTab_Catprod,
				TP.Produtos
			FROM 
				Tab_Valor AS TV
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TV.idTab_Produtos
					LEFT JOIN Tab_Promocao AS TPR ON TPR.idTab_Promocao = TV.idTab_Promocao
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TPS.idTab_Produto
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_2
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_1

			WHERE 
				TPS.idSis_Empresa = ' . $id_empresa . ' AND
				(' . $query0 . ' ' . $filtro1 . ' ' . $filtro2 . ') AND
				TV.Desconto = "1" AND
				TP.Ativo = "S" AND
				TP.VendaSite = "S" AND
				TV.AtivoPreco = "S" AND
				TV.VendaSitePreco = "S"
			ORDER BY 
				TPS.Nome_Prod ASC
			LIMIT 50
		');	
			
		//echo json_encode($result);
		//Seleciona os registros com $conn
		$read_produto = mysqli_query($conn, $result);
		foreach($read_produto as $row){		
			
			$data[] 	= array(
				
				'id_produto' 		=> $row['idTab_Produtos'],
				'nomeprod' 			=> utf8_encode ($row['Nome_Prod']),
				'descprod' 			=> utf8_encode ($row['DescProd']),
				'arquivo' 			=> $row['Arquivo'],
				'contarestoque' 	=> $row['ContarEstoque'],
				'estoque' 			=> $row['Estoque'],
				'id_valor' 			=> $row['idTab_Valor'],
				'qtdinc' 			=> $row['QtdProdutoIncremento'],
				'valor' 			=> str_replace(".", ",", $row['ValorProduto']),
				'codprod' 			=> $row['Cod_Prod'],
				'codbarra' 			=> $row['Cod_Barra'],
				
			);			
		}
		
		/*
		//Seleciona os registros com PDO
		$resultado = $pdo->prepare($result);
		$resultado->execute();

		while($row = $resultado->fetch(PDO::FETCH_ASSOC)){

			$data[] 	= array(
				
				'id_produto' => $row['idTab_Produtos'],
				'nomeprod' => $row['Nome_Prod'],
				'arquivo' => $row['Arquivo'],
				'contarestoque' => $row['ContarEstoque'],
				'estoque' => $row['Estoque'],
				'id_valor' => $row['idTab_Valor'],
				'qtdinc' => $row['QtdProdutoIncremento'],
				'valor' => str_replace(".", ",", $row['ValorProduto']),
				'codprod' => $row['Cod_Prod'],
				'codbarra' => $row['Cod_Barra'],
				
			);		
			
		}
		*/
		echo json_encode($data);
		
	}else{
	
		//echo json_encode($data);
		echo false;
	}
	
}else{
	
	//echo json_encode('socorro');
	echo false;
	
}

mysqli_close($conn);

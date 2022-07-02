<?php
	
include_once '../application/config/conexao.php';

if (isset($_GET['id_empresa']) && isset($_GET['promocao'])) {
	$dataatual = date('Y-m-d', time());
	$dia_da_semana = date('N');
	$id_empresa = $_GET['id_empresa'];
	$promocao 	= $_GET['promocao'];
	//echo json_encode($promocao);
	
	$promocaox = explode(' ', $promocao);

	if (isset($promocaox[2]) && $promocaox[2] != ''){
		
		$promocao2 = $promocaox[2];
		
		if (isset($promocao2)){
		
			$query2 = '(TPS.Nome_Prod like "%' . $promocao2 . '%"  OR '
						. 'TPR.Promocao like "%' . $promocao2 . '%"  OR '
						. 'TPR.Descricao like "%' . $promocao2 . '%"  OR '
						. 'TPS.Cod_Prod like "%' . $promocao2 . '%"  OR '
						. 'TPS.Cod_Barra like "%' . $promocao2 . '%" )';
			
		}	
		$filtro2 = ' AND ' . $query2 ;
	} else {
		$filtro2 = FALSE ;
	}

	if (isset($promocaox[1]) && $promocaox[1] != ''){
		$promocao0 = $promocaox[0];
		$promocao1 = $promocaox[1];
		
		if (isset($promocao1)){	
			
			$query1 = '(TPS.Nome_Prod like "%' . $promocao1 . '%"  OR '
						. 'TPR.Promocao like "%' . $promocao1 . '%"  OR '
						. 'TPR.Descricao like "%' . $promocao1 . '%"  OR '
						. 'TPS.Cod_Prod like "%' . $promocao1 . '%"  OR '
						. 'TPS.Cod_Barra like "%' . $promocao1 . '%"  )';
			
		}	
		$filtro1 = ' AND ' . $query1 ;
		
	}else{
		$promocao0 = $promocao;
		$filtro1 = FALSE;
	}

	$query0 = '(TPS.Nome_Prod like "%' . $promocao0 . '%"  OR '
				. 'TPR.Promocao like "%' . $promocao0 . '%"  OR '
				. 'TPR.Descricao like "%' . $promocao0 . '%"  OR '
				. 'TPS.Cod_Prod like "%' . $promocao0 . '%"  OR '
				. 'TPS.Cod_Barra like "%' . $promocao0 . '%"  )';
	
	if(!empty($promocao) && $id_empresa != 0){
			
		$result = ('
			SELECT 
				TPR.idTab_Promocao,
				TPR.Promocao,
				TPR.Descricao,
				TPR.Arquivo,
				TPS.Nome_Prod,
				TPS.Cod_Prod,
				TPS.Cod_Barra
			FROM 
				Tab_Promocao AS TPR
					LEFT JOIN Tab_Dia_Prom AS TD ON TD.idTab_Promocao = TPR.idTab_Promocao
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Promocao = TPR.idTab_Promocao
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TV.idTab_Produtos
			WHERE 
				TPR.idSis_Empresa = ' . $id_empresa . ' AND
				(' . $query0 . ' ' . $filtro1 . ' ' . $filtro2 . ') AND
				TPR.DataInicioProm <= "'.$dataatual.'" AND 
				TPR.DataFimProm >= "'.$dataatual.'" AND 
				TD.id_Dia_Prom = "'.$dia_da_semana.'" AND
				TD.Aberto_Prom = "S" AND
				TPR.VendaSite = "S"
			GROUP BY
				TPR.idTab_Promocao
			ORDER BY 
				TPS.Nome_Prod ASC
			LIMIT 50
		');
		
		//echo json_encode($result);
				
		//Seleciona os registros com $conn
		$read_promocao = mysqli_query($conn, $result);
		foreach($read_promocao as $row){
			$id_promocao 		= $row['idTab_Promocao'];

			$result_produtos = ('
				SELECT 
					TPR.idTab_Promocao,
					SUM(TV.QtdProdutoDesconto * TV.ValorProduto) AS Total
				FROM 
					Tab_Promocao AS TPR
						LEFT JOIN Tab_Valor AS TV ON TV.idTab_Promocao = TPR.idTab_Promocao
				WHERE 
					TPR.idTab_Promocao = '.$id_promocao.'
			');	
			$read_produtos = mysqli_query($conn, $result_produtos);			
			$total = 0;
			foreach($read_produtos as $row_produtos){
				$total 		= $row_produtos['Total'];
			}
			$data[] 	= array(
					
					'id_promocao' 	=> $row['idTab_Promocao'],
					'promocao' 		=> utf8_encode ($row['Promocao']),
					'descricao' 	=> utf8_encode ($row['Descricao']),
					'arquivo' 		=> $row['Arquivo'],
					'total' 		=> $total,

			);
		}
		
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

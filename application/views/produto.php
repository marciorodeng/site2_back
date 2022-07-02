<?php
	if(!isset($_GET['id']) || (isset($row_empresa['EComerce']) && $row_empresa['EComerce'] == "N")){
		echo "<script>window.location = 'index.php'</script>";
		exit();
	}

	if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];
	}else{
		unset(	$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa],
				$_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa]
				);	
	}	
	$id_valor = addslashes($_GET['id']);

	$result ="
		SELECT 
			TPS.idTab_Produtos,
			TPS.Nome_Prod,
			TPS.idSis_Empresa,
			TPS.Arquivo,
			TPS.ContarEstoque,
			TPS.Estoque,
			TPS.Produtos_Descricao,
			TV.idTab_Valor,
			TV.QtdProdutoDesconto,
			TV.QtdProdutoIncremento,
			TV.Convdesc,		
			TV.ValorProduto
		FROM 
			Tab_Produtos AS TPS
				LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produtos = TPS.idTab_Produtos
		WHERE 
			TV.idTab_Valor = '".$id_valor."' AND
			TPS.idSis_Empresa = '".$idSis_Empresa."'
	";

	$read_produto = mysqli_query($conn, $result);

	$contagem = mysqli_num_rows($read_produto);
	/*
	echo "<pre>";
	echo "<br>";
	print_r('$contagem = ' .$contagem );
	echo "</pre>";
	exit();
	*/
	if(isset($contagem) && $contagem > 0){
		foreach($read_produto as $read_produto_view){
			$id_valor_produto 	= $read_produto_view['idTab_Valor'];
			$id_produto 		= $read_produto_view['idTab_Produtos'];
			$qtd_produto 		= $read_produto_view['QtdProdutoDesconto'];
			$qtd_incremento 	= $read_produto_view['QtdProdutoIncremento'];
			$valor_produto 		= $read_produto_view['ValorProduto'];
			$arquivo 			= $read_produto_view['Arquivo'];
			$contar_estoque 		= $read_produto_view['ContarEstoque'];
			$qtd_estoque 		= $read_produto_view['Estoque'];
		}
	}else{
		echo "<script>window.location = 'index.php'</script>";
		exit();
	}
?>

<section id="produto" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h1 class="title-h1">Produto</h1>
				<hr class="traco-h1">
			</div>
			
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
					<br>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
						<img class="img-responsive" width='500' src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produto_view['Arquivo']; ?>" alt="" >
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">	
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
								<?php if($qtd_estoque > 0){ ?>
									<!--<h5 class="card-title">Qtd Estoque: <?php #echo $qtd_estoque;?></h5>-->
								<?php } ?>
								<h3 class="card-title"><?php echo utf8_encode($read_produto_view['Nome_Prod']);?><br> 
														<?php echo utf8_encode ($read_produto_view['Convdesc']);?><br>
														<?php echo utf8_encode ($read_produto_view['QtdProdutoIncremento']);?> Unid.
								</h3>

								<h4>R$ <?php echo number_format($valor_produto,2,",",".");?></h4>
								<p class="card-text"><?php echo utf8_encode ($read_produto_view['Produtos_Descricao']);?></p>
							</div>
						</div>
						<div class="row">	
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
								<?php if($loja_aberta){ ?>
									<div class="card-body">
										<?php if($row_empresa['EComerce'] == 'S'){ ?>
												<?php if($contar_estoque == "S"){ ?>
													<?php if($qtd_estoque >= $qtd_incremento){ ?>
														<a href="meu_carrinho.php?carrinho=produto&id=<?php echo $read_produto_view['idTab_Valor'];?>" class="btn btn-success" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name),exibirPagar()">Adicionar ao Carrinho</a>
													<?php } else { ?>
														<a href="produtos.php" class="btn btn-danger" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Indisponível</a>
													<?php } ?>	
												<?php } else { ?>
													<a href="meu_carrinho.php?carrinho=produto&id=<?php echo $read_produto_view['idTab_Valor'];?>" class="btn btn-success" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name),exibirPagar()">Adicionar ao Carrinho</a>
												<?php } ?>
										<?php } ?>
									</div>
								<?php } else { ?>
									<button class="btn btn-warning "  >Loja Fechada</button>
								<?php } ?>
							</div>	
						</div>
					</div>		
				</div>
			
		</div>		
	</div>
</section>

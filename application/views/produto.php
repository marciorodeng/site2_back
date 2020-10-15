<?php 
	if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['id_Cliente'.$idSis_Empresa];
	}else{
		unset(	$_SESSION['id_Cliente'.$idSis_Empresa],
				$_SESSION['Nome_Cliente'.$idSis_Empresa]
				);	
	}	
	$id_valor = addslashes($_GET['id']);
	$read_produto = mysqli_query($conn, "
	SELECT 
		TPS.idTab_Produtos,
		TPS.Nome_Prod,
		TPS.idSis_Empresa,
		TPS.Arquivo,
		TPS.VendaSite,
		TPS.produto_breve_descricao,
		TPS.ValorProdutoSite,
		TPS.Comprimento,
		TV.idTab_Valor,
		TV.Desconto AS id_Desconto,
		TV.QtdProdutoDesconto,
		TV.QtdProdutoIncremento,
		TV.Convdesc,		
		TV.ValorProduto,
		TPR.Promocao,
		TPR.Descricao,
		TPR.Ativo,
		TPR.VendaSite,
		TOP2.Opcao AS Opcao2,
		TOP1.Opcao AS Opcao1,
		(TV.ValorProduto) AS SubTotal2
	FROM 
		Tab_Produtos AS TPS
			LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produtos = TPS.idTab_Produtos
			LEFT JOIN Tab_Promocao AS TPR ON TPR.idTab_Promocao = TV.idTab_Promocao
			LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TPS.idTab_Produto
			LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
			LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2
	WHERE 
		TV.idTab_Valor = '".$id_valor."' 
	ORDER BY 
		TV.idTab_Valor ASC	
	");
	$valortotal2 = '0';
	if(mysqli_num_rows($read_produto) > '0'){
		foreach($read_produto as $read_produto_view){
			$subtotal2 		= $read_produto_view['SubTotal2'];
			$valortotal2 	= $subtotal2;
			$id_valor_produto = $read_produto_view['idTab_Valor'];
			$id_produto = $read_produto_view['idTab_Produtos'];
			$desc_produto = $read_produto_view['id_Desconto'];
			$qtd_produto = $read_produto_view['QtdProdutoDesconto'];
			
			$valor_produto = $read_produto_view['ValorProduto'];
		}
	}else{
		header("Location: index.php");
	}
	$qtdestoque = $qtdcompra = $qtdvenda = 0;
	$compra = mysqli_query($conn, "
			SELECT
			SUM(APV.QtdProduto * APV.QtdIncrementoProduto) AS QtdCompra,
				TPS.idTab_Produtos
			FROM
				App_Produto AS APV
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TVV.idTab_Produtos					
			WHERE
				OT.AprovadoOrca ='S' AND
				APV.idTab_Produtos_Produto = '".$id_produto."' AND
				APV.idSis_Empresa = '".$idSis_Empresa."' AND
				APV.idTab_TipoRD = '1'
	");
	
	if(mysqli_num_rows($compra) > '0'){
		foreach($compra as $compra_view){
			$qtdcompra = $compra_view['QtdCompra'];
		}
	}
	
	$venda = mysqli_query($conn, "
			SELECT
				SUM(APV.QtdProduto * APV.QtdIncrementoProduto) AS QtdVenda,
				TPS.idTab_Produtos
			FROM
				App_Produto AS APV
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TVV.idTab_Produtos					
			WHERE
				OT.AprovadoOrca ='S' AND
				APV.idTab_Produtos_Produto = '".$id_produto."' AND
				APV.idSis_Empresa = '".$idSis_Empresa."' AND
				APV.idTab_TipoRD = '2'
				

	");
	if(mysqli_num_rows($venda) > '0'){
		foreach($venda as $venda_view){
			$qtdvenda = $venda_view['QtdVenda'];
		}
	}
	$qtdestoque = $qtdcompra - $qtdvenda;
	/*
	echo "<pre>";
	echo $qtdcompra;
	echo "<br>";
	echo $qtdvenda;
	echo "<br>";
	echo $qtdestoque;
	echo "</pre>";
	exit();
	*/
?>

<section id="service" class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<?php
				$result_categoria = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' AND TipoCatprod = 'P'  ORDER BY Catprod ASC ";
				$read_categoria = mysqli_query($conn, $result_categoria);
				if(mysqli_num_rows($read_categoria) > '0'){?>
					<div class="row">	
						<div class="col-lg-12">
							<h2 class="ser-title ">Produtos</h2>
							<hr class="botm-line">
							<div class="list-group">
								<?php
								foreach($read_categoria as $read_categoria_view){
									echo '<a href="produtos.php?cat='.$read_categoria_view['idTab_Catprod'].'" class="list-group-item">'.$read_categoria_view['Catprod'].'</a>';
								}?>
								
							</div>
						</div>
					</div>
				<?php	
				}
				?>
				<?php
				$result_categoria = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' AND TipoCatprod = 'S'  ORDER BY Catprod ASC ";
				$read_categoria = mysqli_query($conn, $result_categoria);
				if(mysqli_num_rows($read_categoria) > '0'){?>
					<div class="row">	
						<div class="col-lg-12">
							<h2 class="ser-title ">Serviços</h2>
							<hr class="botm-line">
							<div class="list-group">
								<?php
								foreach($read_categoria as $read_categoria_view){
									echo '<a href="produtos.php?cat='.$read_categoria_view['idTab_Catprod'].'" class="list-group-item">'.$read_categoria_view['Catprod'].'</a>';
								}
								?>
								
							</div>
						</div>
					</div>
				<?php	
				}
				?>				
				<!--
				<div class="row">	
					<div class="col-lg-12">
						<h2 class="ser-title ">Categorias</h2>
						<hr class="botm-line">
						<div class="list-group">
							<?php
								$result_categoria = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' ORDER BY Catprod ASC ";
								$read_categoria = mysqli_query($conn, $result_categoria);
								if(mysqli_num_rows($read_categoria) > '0'){
									foreach($read_categoria as $read_categoria_view){
										echo '<a href="produtos.php?cat='.$read_categoria_view['idTab_Catprod'].'" class="list-group-item">'.$read_categoria_view['Catprod'].'</a>';
									}
								}
							?>
						</div>
					</div>
				</div>
				-->
				<div class="row">	
					<div class="col-lg-12">
						<h2 class="ser-title "><a href="promocao.php">Promoções</a></h2>
						<hr class="botm-line">
					</div>
				</div>	
			</div>
			<div class="col-md-9">
				<!--
				<h2 class="ser-title">Produto</h2>
				<hr class="botm-line">
				-->
				<div class="row img-prod ">
					<div class="row">		
						<div class="col-md-12">	
							<div class="row">	
								<div class="col-md-4 ">
									<img class="img-fluid" width='250' src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produto_view['Arquivo']; ?>" alt="" >
								</div>
								<div class="col-md-7 fundo-entrega-carrinho">
									<div class="col-md-12 text-center">
										<form action="meu_carrinho.php?id_Session=<?php echo $id_valor_produto;?>" method="post">	
											<div class="row">
												<!--
												<h3 class="card-title">Quant do Combo <input type="text" name="qtdcombo" id="qtdcombo" value="10"></h3>
												<h3 class="card-title">id-valor-prod: <?php echo $id_valor_produto;?><input type="hidden" name="id_valor_produto" id="id_valor_produto" value="<?php echo $id_valor_produto;?>"></h3>
												<h3 class="card-title">id-prod: <?php echo $id_produto;?><input type="hidden" name="id_produto" id="id_produto" value="<?php echo $id_produto;?>"></h3>
												<h3 class="card-title">desc-prod: <?php echo $desc_produto;?><input type="hidden" name="desc" id="desc" value="<?php echo $desc_produto;?>"></h3>
												<h3 class="card-title">qtd-prod: <?php echo $qtd_produto;?><input type="hidden" name="qtd" id="qtd" value="<?php echo $qtd_produto;?>"></h3>
												<h3 class="card-title">valor-prod: <?php echo $valor_produto;?><input type="hidden" name="valor" id="valor" value="<?php echo $valor_produto;?>"></h3>
												-->
												<!--<h3 class="card-title">Qtd Compra: <?php echo $qtdcompra;?></h3>
												<h3 class="card-title">Qtd Venda: <?php echo $qtdvenda;?></h3>-->
												<?php if($qtdestoque > 0){ ?>
													<h5 class="card-title">Qtd Estoque: <?php echo $qtdestoque;?></h5>
												<?php } ?>
												<h3 class="card-title"><?php echo utf8_encode($read_produto_view['Nome_Prod']);?>  
																		<?php echo utf8_encode ($read_produto_view['Opcao2']);?> 
																		<?php echo utf8_encode ($read_produto_view['Opcao1']);?> -
																		<?php echo utf8_encode ($read_produto_view['Convdesc']);?> -
																		<?php echo utf8_encode ($read_produto_view['QtdProdutoIncremento']);?> Unid.
												</h3>
																		
												<!--<h4 class="card-title"><?php echo utf8_encode($read_produto_view['Promocao']);?><br>  
																		<?php echo utf8_encode ($read_produto_view['Descricao']);?></h4>-->

												<!--<h4>R$ <?php #echo number_format($read_produto_view['ValorProduto'],2,",",".");?> (cada)</h4>-->
												<h4>R$ <?php echo number_format($valortotal2,2,",",".");?></h4>
												<p class="card-text"><?php echo utf8_encode ($read_produto_view['produto_breve_descricao']);?></p>

											</div>
											<!--<input type="submit" value="Submit">-->	
										</form>
										<div class="row">
											<div class="col-lg-12">							
												<div class="card card-outline-secondary my-4">
													<div class="card-body">
														<br>
														<?php if($row_empresa['EComerce'] == 'S'){ ?>
															<?php if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ ?>
																<?php 	if($qtdestoque > '0'){ ?>
																	<a href="meu_carrinho.php?carrinho=produto&id=<?php echo $id_valor;?>" class="btn btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name),exibirPagar()">Adicionar ao Carrinho</a>
																	<!--<a href="meu_carrinho.php?id=<?php echo $id_valor;?>" class="btn btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Adicionar ao Carrinho</a>-->								
																<?php } else { ?>
																	<a href="produtos.php" class="btn btn-danger btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Produto Indisponível no estoque</a>
																<?php } ?>
																	<!--<a href="meu_carrinho.php?carrinho=produto&id=<?php echo $id_valor;?>" class="btn btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Adicionar ao Carrinho</a>-->
																<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
																  Aguarde um instante! Estamos processando sua solicitação!
																</div>
															<?php } else { ?>
																<a href="login_cliente.php" class="btn btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Logar P/ Adicionar ao Carrinho</a>
																<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
																  Aguarde um instante! Estamos processando sua solicitação!
																</div>
															<?php } ?>	
														<?php } ?>
													</div>
												</div>
											</div>
										</div>								
									</div>
								</div>
							</div>
						</div>
						<!--
						<div class="col-lg-6">
							<div class="col-lg-12 fundo-entrega-carrinho">
								<h3 class="mb-3">Confira as Opções de Entrega</h3>
								<div class="row">
									<div class="col-lg-12">	
										<div class="col-md-4 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="tipofrete" class="custom-control-input"  id="Retirada" value="1" onclick="tipoFrete('1')" checked>
												<label class="custom-control-label" for="Retirada">Retirada</label>
											</div>
										</div>									
										<div class="col-md-4 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="tipofrete" class="custom-control-input" id="Combinar" value="2" onclick="tipoFrete('2')">
												<label class="custom-control-label" for="Combinar">A Combinar</label>
											</div>
										</div>									
										<div class="col-md-4 mb-3 ">
											<div class="custom-control custom-radio">
												<input type="radio" name="tipofrete" class="custom-control-input" id="Correios" value="3" onclick="tipoFrete('3')">
												<label class="custom-control-label" for="Correios">Correios</label>
											</div>
										</div>
									</div>
								</div>
								<h3 class="mb-3 Correios">Calcular Preço e Prazo de Entrega</h3>

								<h3 class="mb-3 Combinar">Cobinar a Entrega com o Vendedor</h3>
								
								<h3 class="mb-3 Retirada">Retirar o produto na Loja</h3>							

								<form class="mb-3 Correios" name="Form2" id="Form2">
									
									<input type="text" name="CepDestino" id="CepDestino" placeholder="Cep" maxlength="8" class="text-muted"><br>								
									
									<input type="hidden" name="CepOrigem" id="CepOrigem" placeholder="CepOrigem" value="24445360">
									<input type="hidden" name="Peso" id="Peso" placeholder="Peso" value="5.50">
									<input type="hidden" name="Formato" id="Formato" placeholder="Formato" value="1">
									<input type="hidden" name="Comprimento" id="Comprimento" placeholder="Comprimento" value="<?php echo $read_produto_view['Comprimento'];?>">
									<input type="hidden" name="Altura" id="Altura" placeholder="Altura" value="30">
									<input type="hidden" name="Largura" id="Largura" placeholder="Largura" value="30">
									<input type="hidden" name="Diametro" id="Diametro" placeholder="Diametro" value="0">		
									<input type="hidden" name="MaoPropria" id="MaoPropria" placeholder="MaoPropria" value="N">
									<input type="hidden" name="ValorDeclarado" id="ValorDeclarado" placeholder="ValorDeclarado" value="0">
									<input type="hidden" name="AvisoRecebimento" id="AvisoRecebimento" placeholder="AvisoRecebimento" value="N"><br>
									<select name="Codigo" id="Codigo" class="text-muted">
										
										<option class="text-muted" value="40010"> SEDEX </option>
										<option class="text-muted" value="41106"> PAC </option>
									</select>

									<input type="submit" class="text-muted" value="Pesquisar"><br>

									<div class="ResultadoCep"></div><br>							
									<div class="ResultadoPrecoPrazo"></div><br>

									<a href="http://www.buscacep.correios.com.br/sistemas/buscacep/default.cfm" target="_blank">Não sei meu CEP!!</a>							
								
								</form>
								
								<div class="row">
									<div class="col-lg-12">							
										<div class="card card-outline-secondary my-4">
											<div class="card-body">
												<br>
												<?php 	if($qtdestoque > '0'){ ?>
												<a href="meu_carrinho.php?id=<?php echo $id_valor;?>" class="btn btn-success btn-block">Adicionar ao Carrinho</a>								
												<?php } else { ?>
												<a href="produtos.php" class="btn btn-danger btn-block">Produto Indisponível no estoque</a>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
								<br>
							</div>
						</div>
						-->
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

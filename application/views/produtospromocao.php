<?php
	if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['id_Cliente'.$idSis_Empresa];
	}else{
		unset(	$_SESSION['id_Cliente'.$idSis_Empresa],
				$_SESSION['Nome_Cliente'.$idSis_Empresa]
				);	
	}	
	if(isset($_GET['promocao'])){	
		$id_promocao = addslashes($_GET['promocao']);
	}						
	/*
	echo '<br>';
	echo "<pre>";
	print_r($promocao);
	echo "</pre>";
	exit ();
	*/
?>
<section id="service" class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<?php
				$result_categoria = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprod = 'S' AND TipoCatprod = 'P'  ORDER BY Catprod ASC ";
				$read_categoria = mysqli_query($conn, $result_categoria);
				if(mysqli_num_rows($read_categoria) > '0'){?>
					<div class="row">	
						<div class="col-lg-12">
							<hr class="botm-line">
							<h2 class="ser-title ">
								<a href="produtos.php?">
									Produtos
								</a>
							</h2>
							<br>
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
				$result_categoria = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprod = 'S' AND TipoCatprod = 'S'  ORDER BY Catprod ASC ";
				$read_categoria = mysqli_query($conn, $result_categoria);
				if(mysqli_num_rows($read_categoria) > '0'){?>
					<div class="row">	
						<div class="col-lg-12">
							<hr class="botm-line">
							<h2 class="ser-title ">
								<a href="produtos.php?">
									Serviços
								</a>
							</h2>
							<br>
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
				<?php
				$result_categoria = "SELECT * FROM Tab_Catprom WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprom = 'S' ORDER BY Catprom ASC ";
				$read_categoria = mysqli_query($conn, $result_categoria);
				if(mysqli_num_rows($read_categoria) > '0'){?>
					<div class="row">	
						<div class="col-lg-12">
							<hr class="botm-line">
							<h2 class="ser-title ">
								<a href="promocao.php?">
									Promoções
								</a>
							</h2>
							<br>
							<div class="list-group">
								<?php
								foreach($read_categoria as $read_categoria_view){
									echo '<a href="promocao.php?cat='.$read_categoria_view['idTab_Catprom'].'" class="list-group-item">'.$read_categoria_view['Catprom'].'</a>';
								}
								?>
								
							</div>
						</div>
					</div>
				<?php	
				}
				?>	
			</div>
			<div class="col-md-9">
				<?php if($row_empresa['EComerce'] == 'S' && isset($_SESSION['id_Cliente'.$idSis_Empresa]) && isset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) && count($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) > '0'){ ?>
					<div class="row">	
						<div class="col-md-12">	
							<?php if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ ?>
								<div class="row">	
									<!--
									<div class="col-md-6">
										<label></label><br>
										<a href="entrega.php" class="btn btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Finalizar Pedido!</a>
									</div>
									-->
									<div class="col-md-12">
										<label></label><br>
										<a href="entrega.php" class="btn btn-primary btn-block" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)">Carrinho com: <?php echo $_SESSION['item_carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]];?> Unid.  <br>Se desejar Finalizar a compra,<br>click aqui.</a>
									</div>
									
								</div>
								<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
									Aguarde um instante! Estamos processando sua solicitação!
								</div>							
							<?php } else { ?>
								<div class="col-md-6">
									<a href="login_cliente.php" class="btn btn-danger btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Logar / Finalizar Pedido</a>
									<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
									  Aguarde um instante! Estamos processando sua solicitação!
									</div>							
								</div>
							<?php } ?>
						</div>
					</div>
					<br>
				<?php } ?>	
				<?php
					$read_promocao = mysqli_query($conn, "
						SELECT 
							TPR.*,
							SUM(TV.QtdProdutoDesconto * TV.ValorProduto) AS Total
						FROM 
							Tab_Promocao AS TPR
								LEFT JOIN Tab_Valor AS TV ON TV.idTab_Promocao = TPR.idTab_Promocao
						WHERE 
							TPR.idTab_Promocao = '".$id_promocao."' AND
							TPR.VendaSite = 'S'
					");
					$read_produtos_derivados = mysqli_query($conn, "
						SELECT 
							TV.idTab_Valor,
							TV.idTab_Modelo,
							TV.ValorProduto,
							TV.QtdProdutoDesconto,
							TV.QtdProdutoIncremento,
							TV.Convdesc,
							TV.idTab_Promocao,
							TV.Desconto,
							TPS.idTab_Produtos,
							TPS.idTab_Produto,
							TPS.idSis_Empresa,
							TPS.Nome_Prod,
							TPS.Arquivo,
							TPS.Valor_Produto,
							TPS.Estoque,
							(TV.QtdProdutoDesconto * TV.ValorProduto) AS SubTotal,
							(TV.ValorProduto) AS SubTotal2
						FROM 
							Tab_Valor AS TV
								LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TV.idTab_Produtos
						WHERE 
							TV.idTab_Promocao = '".$id_promocao."' AND
							TV.VendaSitePreco = 'S'
						ORDER BY 
							TV.idTab_Valor ASC
					");

				?>
				<?php 
					$cont_promocao = mysqli_num_rows($read_promocao);
					if($cont_promocao > '0'){
						$total = 0;
						foreach($read_promocao as $read_promocao_view){
							$total 		= $read_promocao_view['Total'];
							?>
							<div class="row">
								<hr class="botm-line">
								<div class="col-md-12 fundo-entrega-carrinho">
									<div class="col-md-12 text-center">	
										<div class="row">
											<h3 class="card-title"><?php echo utf8_encode($read_promocao_view['Promocao']);?> R$ <?php echo number_format($total,2,",",".");?></h3>
											<h4 class="card-title"><?php echo utf8_encode ($read_promocao_view['Descricao']);?></h4>
										</div>							
									</div>
									<div class="row">
										<div class="col-md-12">
										
										<?php
											$cont_produtos = mysqli_num_rows($read_produtos_derivados);
												/*
												echo "<pre>";
												print_r($cont_produtos);
												echo '<br>';
												echo "</pre>";
												*/
											if($cont_produtos > '0'){
												$valortotal2 = '0';
												foreach($read_produtos_derivados as $read_produtos_derivados_view){
													$subtotal2 		= $read_produtos_derivados_view['SubTotal2'];
													$valortotal2 	= $subtotal2;
													$qtd_incremento = $read_produtos_derivados_view['QtdProdutoIncremento'];
													$qtd_estoque = $read_produtos_derivados_view['Estoque'];
													$id_produto = $read_produtos_derivados_view['idTab_Produtos'];
													$total_estoque = $qtd_estoque - $qtd_incremento;
													?>		
														<div class="col-lg-3 col-md-3 col-sm-6 mb-3">
															<div class="img-produtos ">
																<img class="team-img " src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produtos_derivados_view['Arquivo']; ?>" alt="" class="img-circle img-responsive" width='120'>
																<div class="card-body">
																	<h5 class="card-title">
																		<?php echo utf8_encode ($read_produtos_derivados_view['Nome_Prod']);?><br> 
																		<?php echo utf8_encode ($read_produtos_derivados_view['Convdesc']);?>
																	</h5>
																	<h5><?php echo utf8_encode ($read_produtos_derivados_view['QtdProdutoIncremento']);?> Unid.
																		<br>R$ <?php echo number_format($read_produtos_derivados_view['ValorProduto'],2,",",".");?>
																	</h5>
																	<!--<h4>R$ <?php echo number_format($valortotal2,2,",",".");?></h4>-->
																</div>
																<div class="card-body">
																	<?php 	if($total_estoque < 0){ ?>
																		<p style="color: #FF0000">Indisponível no Estoque</p>							
																	<?php } ?>
																</div>	
															</div>
														</div>
													<?php
													
												}
											}
										?>
										</div>	
									</div>
									<?php if($loja_aberta){ ?>
										<div class="row">		
											<div class="col-md-12">
												<div class="col-md-12 text-center">
													<div class="row">
														<div class="col-lg-12">							
															<div class="card card-outline-secondary my-4">
																<div class="card-body">
																	<br>
																	<?php if($row_empresa['EComerce'] == 'S'){ ?>
																		<?php if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ ?>
																			<?php 
																			for($i = 1; $i<=$cont_produtos; $i++){
																					
																			}
																			?>
																			
																			
																				<a href="meu_carrinho.php?carrinho=promocao&id=<?php echo $id_promocao;?>" class="btn btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name),exibirPagar()">Adicionar Promoção ao Carrinho</a>
																				
																				
																				<!--<a href="meu_carrinho.php?carrinho=produto&id=<?php echo $id_valor;?>" class="btn btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Adicionar ao Carrinho</a>-->
																			<!--<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
																			  Aguarde um instante! Estamos processando sua solicitação!
																			</div>-->
																		<?php } else { ?>
																			<a href="login_cliente.php" class="btn btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Logar P/ Adicionar ao Carrinho</a>
																			<!--<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
																			  Aguarde um instante! Estamos processando sua solicitação!
																			</div>-->
																		<?php } ?>	
																	<?php } ?>
																</div>
															</div>
														</div>
													</div>								
												</div>
											</div>
										</div>
									<?php } else { ?>
										<button class="btn btn-warning btn-block "  >Loja Fechada</button>
									<?php } ?>
								</div>
							</div>
							<?php
						}
					}
				?>
			</div>		
		</div>
	</div>
</section>

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
?>
<section id="service" class="section-padding">
	<div class="container-1">
		<div class="row">
			<div class="col-lg-12">
				<?php if($row_empresa['EComerce'] == 'S' && isset($_SESSION['id_Cliente'.$idSis_Empresa]) && isset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) && count($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) > '0'){ ?>
					<div class="row">	
						<div class="col-md-12">	
							<?php if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ ?>
								<div class="row">
									<div class="col-md-12">
										<a href="entrega.php" class="btn btn-primary btn-block" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)">Se desejar Finalizar a compra, Click Aqui!!</a>
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
				<?php } ?>
			</div>
			<div class="col-md-12">	
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
							TPS.idTab_Produtos,
							TPS.idTab_Produto,
							TPS.idSis_Empresa,
							TPS.Nome_Prod,
							TPS.Arquivo,
							TPS.Valor_Produto,
							TPS.ContarEstoque,
							TPS.Estoque,
							TPS.Produtos_Descricao,
							(TV.QtdProdutoDesconto * TV.ValorProduto) AS SubTotal,
							(TV.ComissaoCashBack * TV.ValorProduto /100) AS CashBack,
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
							<div class="col-md-12 fundo-entrega-carrinho">
								<div class="container-4">	
									<div class="row">
								
										<br>
										<h2 class="ser-title"><?php echo utf8_encode($read_promocao_view['Promocao']);?></h2>
										<hr class="botm-line">
									
									
									
										<div class="col-md-12 text-center">
											<div class="row">
												<h4 class="card-title">
													<?php echo utf8_encode ($read_promocao_view['Descricao']);?>
												</h4>
												<?php if($row_empresa['EComerce'] == 'S'){ ?>
													<h4 class="card-title">
														R$ <?php echo number_format($total,2,",",".");?>
													</h4>
												<?php } ?>	
											</div>							
										</div>
										<div class="row">
											<?php
												$cont_produtos = mysqli_num_rows($read_produtos_derivados);
												if($cont_produtos > '0'){
													$valortotal2 = '0';
													$qtd_estoque_prom = '1';
													$prazo_prom = '0';
													foreach($read_produtos_derivados as $read_produtos_derivados_view){
														$subtotal2 		= $read_produtos_derivados_view['SubTotal2'];
														$cashback 		= $read_produtos_derivados_view['CashBack'];
														$valortotal2 	= $subtotal2;
														$qtd_incremento = $read_produtos_derivados_view['QtdProdutoIncremento'];
														$contar_estoque = $read_produtos_derivados_view['ContarEstoque'];
														$qtd_estoque = $read_produtos_derivados_view['Estoque'];
														$prazo_prod = $read_produtos_derivados_view['TempoDeEntrega'];
														$id_produto = $read_produtos_derivados_view['idTab_Produtos'];
														$total_estoque = $qtd_estoque - $qtd_incremento;
														
														if($contar_estoque == "S"){
															if($qtd_estoque < $qtd_estoque_prom){
																$qtd_estoque_prom = $qtd_estoque;
															}else{
																$qtd_estoque_prom = $qtd_estoque_prom;
															}
														}else{
															$qtd_estoque_prom = $qtd_estoque_prom;
														}
														
														if($prazo_prod >= $prazo_prom){
															$prazo_prom = $prazo_prod;
														}else{
															$prazo_prom = $prazo_prom;
														}
														
														?>		
															<div class="col-lg-3 col-md-6 col-sm-6 mb-3 text-center">
																
																<div class="card-body">
																	<img class="team-img img-responsive" src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produtos_derivados_view['Arquivo']; ?>" alt="" width='300'>
																</div>
																<div class="card-body">
																	<h5 class="card-title">
																		<?php echo utf8_encode ($read_produtos_derivados_view['Nome_Prod']);?>
																	</h5>
																</div>
																<div class="card-body">
																	<h5 class="card-title">
																		<?php echo utf8_encode ($read_produtos_derivados_view['Produtos_Descricao']);?>
																	</h5>
																	<?php if($row_empresa['EComerce'] == 'S'){ ?>
																		<h5 class="card-title">
																			<?php echo utf8_encode ($read_produtos_derivados_view['Convdesc']);?>
																		</h5>
																		<h5><?php echo utf8_encode ($read_produtos_derivados_view['QtdProdutoIncremento']);?> Unid./
																			 R$ <?php echo number_format($read_produtos_derivados_view['ValorProduto'],2,",",".");?>
																		</h5>
																		<?php if($row_empresa['CashBackAtivo'] == 'S'){ ?>
																			<h6>
																				 CashBack: R$ <?php echo number_format($read_produtos_derivados_view['CashBack'],2,",",".");?>
																			</h6>
																		<?php } ?>
																	<?php } ?>
																</div>
																<div class="card-body">
																	<?php 	if($contar_estoque == "S"){ ?>
																		<?php 	if($total_estoque < 0){ ?>
																			<p style="color: #FF0000">Indisponível no Estoque</p>							
																		<?php } ?>
																	<?php } ?>	
																</div>	
																
															</div>
														<?php
														
													}
												}
											?>
												
										</div>
										<?php if($row_empresa['EComerce'] == 'S'){ ?>
											<div class="col-md-12 text-center">	
												<div class="row">
													<h3 class="card-title">
														<?php 
															if($prazo_prom == 0){
																echo 'Pronta Entrega';
															}else{
																echo 'Prazo de Entrega ' . $prazo_prom . ' Dia(s)';
															}	
														?>
													</h3>
												</div>							
											</div>
										<?php } ?>	
										<?php if($loja_aberta){ ?>
											<div class="row">	
												<div class="col-lg-12">	
													<?php if($row_empresa['EComerce'] == 'S'){ ?>
														<?php if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ ?>
																<?php if($qtd_estoque_prom == 1){ ?>
																	<a href="meu_carrinho.php?carrinho=promocao&id=<?php echo $id_promocao;?>" class="btn btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name),exibirPagar()">Adicionar Promoção ao Carrinho</a>
																<?php }else{ ?>	
																	<a href="promocao.php" class="btn btn-warning btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Algums produtos, desta promoção, estão Indisponíveis! Selecione outra promoção</a>
																	<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
																		Aguarde um instante! Estamos processando sua solicitação!
																	</div>
																<?php } ?>
														<?php } else { ?>
															<a href="login_cliente.php" class="btn btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Logar P/ Adicionar ao Carrinho</a>
														<?php } ?>	
													<?php } ?>
												</div>
											</div>
										<?php } else { ?>
											<button class="btn btn-warning btn-block "  >Loja Fechada</button>
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
	</div>
</section>

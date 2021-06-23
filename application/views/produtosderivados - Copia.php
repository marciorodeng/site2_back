<?php
	if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['id_Cliente'.$idSis_Empresa];
	}else{
		unset(	$_SESSION['id_Cliente'.$idSis_Empresa],
				$_SESSION['Nome_Cliente'.$idSis_Empresa]
				);	
	}	
	if(isset($_GET['id_modelo'])){	
		$id_modelo = addslashes($_GET['id_modelo']);
		$result_categoria = "SELECT 
							TP.*,
							TCP.Catprod,
							TCP.TipoCatprod
						FROM 
							Tab_Produto AS TP
								LEFT JOIN Tab_Catprod AS TCP ON TCP.idTab_Catprod = TP.idTab_Catprod
						WHERE 
							TP.idTab_Produto = '".$id_modelo."'";
		$resultado_categoria = mysqli_query($conn, $result_categoria);
		$row_categoria = mysqli_fetch_assoc($resultado_categoria);
	
	
		if($row_categoria['TipoCatprod'] == "P"){
			$tipocategoria = 'Produtos';
		}elseif($row_categoria['TipoCatprod'] == "S"){
			$tipocategoria = 'Serviços';
		}elseif($row_categoria['TipoCatprod'] == "A"){
			$tipocategoria = 'Aluguel';
		}
	
	}
	/*
	echo '<br>';
	echo "<pre>";
	print_r($id_modelo);
	echo '<br>';
	print_r($row_categoria['Catprod']);
	echo "</pre>";
	exit ();
	*/	
?>
<section id="service" class="section-padding">
	<div class="container-1">
		<div class="row">
			<div class="col-md-12">
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
				<nav class="navbar navbar-inverse navbar-fixed header-menu">
					<div class="">
						<div class="navbar-header">
							<!--
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar3" aria-expanded="false" aria-controls="navbar3">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							-->
							<div class="col-lg-12">
								<button type="button" class=" navbar-brand navbar-toggle collapsed btn-block" data-toggle="collapse" data-target="#navbar3" aria-expanded="false" aria-controls="navbar3">
									Categorias <span class="caret"></span>
								</button>
							</div>	
								<!--
							<span class=" navbar-brand navbar-toggle" > 
								Categorias
							</span>
							
							<span  class="navbar-toggle " > 
								 Categorias
							</span>
							-->
						</div>
						<div id="navbar3" class="navbar-collapse collapse">
							<ul class="nav navbar-nav navbar-left">
								<?php
									$result_categoria_produtos = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprod = 'S' AND TipoCatprod = 'P'  ORDER BY Catprod ASC ";
									$read_categoria_produtos = mysqli_query($conn, $result_categoria_produtos);
									if(mysqli_num_rows($read_categoria_produtos) > '0'){?>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<h2 style="color:#FFFFFF">Produtos <span class="caret"></span></h2>
											</a>
											<ul class="dropdown-menu" aria-labelledby="dropdown03">
												<?php
													foreach($read_categoria_produtos as $read_categoria_produtos_view){
														echo '	<li>
																	<a class="dropdown-item" href="produtos.php?cat='.$read_categoria_produtos_view['idTab_Catprod'].'" >
																		'.$read_categoria_produtos_view['Catprod'].'
																	</a>
																</li>
																<li role="separator" class="divider"></li>';
													}
												?>
											</ul>							
										</li>
										<?php 
									} 
								?>								
								<?php
									$result_categoria_servicos = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprod = 'S' AND TipoCatprod = 'S'  ORDER BY Catprod ASC ";
									$read_categoria_servicos = mysqli_query($conn, $result_categoria_servicos);
									if(mysqli_num_rows($read_categoria_servicos) > '0'){?>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<h2 style="color:#FFFFFF">Serviços <span class="caret"></span></h2>
											</a>
											<ul class="dropdown-menu" aria-labelledby="dropdown03">
												<?php
													foreach($read_categoria_servicos as $read_categoria_servicos_view){
														echo '	<li>
																	<a class="dropdown-item" href="produtos.php?cat='.$read_categoria_servicos_view['idTab_Catprod'].'" >
																		'.$read_categoria_servicos_view['Catprod'].'
																	</a>
																</li>
																<li role="separator" class="divider"></li>';
													}
												?>
											</ul>						
										</li>
										<?php 
									} 
								?>
								<?php
									$result_categoria_promocao = "SELECT * FROM Tab_Catprom WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprom = 'S' ORDER BY Catprom ASC ";
									$read_categoria_promocao = mysqli_query($conn, $result_categoria_promocao);
									if(mysqli_num_rows($read_categoria_promocao) > '0'){?>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<h2 style="color:#FFFFFF">Promoções <span class="caret"></span></h2>
											</a>
											<ul class="dropdown-menu" aria-labelledby="dropdown03">
												<?php
													foreach($read_categoria_promocao as $read_categoria_promocao_view){
														echo '	<li>
																	<a class="dropdown-item" href="promocao.php?cat='.$read_categoria_promocao_view['idTab_Catprom'].'" >
																		'.$read_categoria_promocao_view['Catprom'].'
																	</a>
																</li>
																<li role="separator" class="divider"></li>';
													}
												?>
											</ul>									
										</li>
										<?php 
									} 
								?>
							</ul>
						</div>		
					</div>
				</nav>
			</div>
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<div class="container-3">
							<hr class="botm-line">
							<h2 class="ser-title"><?php echo $row_categoria['Catprod'];?></h2>
						</div>	
						<?php
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
								TPS.Produtos_Descricao,
								TOP2.Opcao AS Opcao2,
								TOP1.Opcao AS Opcao1,
								TP.idTab_Catprod,
								(TV.ValorProduto) AS SubTotal2
							FROM 
								Tab_Valor AS TV
									LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TV.idTab_Produtos
									LEFT JOIN Tab_Promocao AS TPR ON TPR.idTab_Promocao = TV.idTab_Promocao
									LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TPS.idTab_Produto
									LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_2
									LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_1

							WHERE 
								TV.idTab_Produto = '".$id_modelo."' AND
								TV.Desconto = '1' AND
								TP.Ativo = 'S' AND
								TP.VendaSite = 'S' AND
								TV.AtivoPreco = 'S' AND
								TV.VendaSitePreco = 'S'
							ORDER BY 
								TPS.Nome_Prod ASC
							");
							$valortotal2 = '0';

							if(mysqli_num_rows($read_produtos_derivados) > '0'){
								
								foreach($read_produtos_derivados as $read_produtos_derivados_view){
									$comissao 		= $read_produtos_derivados_view['SubTotal2'] * $read_produtos_derivados_view['ComissaoVenda']/100;
									$cashback 		= $read_produtos_derivados_view['SubTotal2'] * $read_produtos_derivados_view['ComissaoCashBack']/100;
									$qtd_incremento = $read_produtos_derivados_view['QtdProdutoIncremento'];
									$id_produto 	= $read_produtos_derivados_view['idTab_Produtos'];
									$subtotal2 		= $read_produtos_derivados_view['SubTotal2'];
									$valortotal2 	= $subtotal2;
									$contar_estoque	= $read_produtos_derivados_view['ContarEstoque'];
									$qtd_estoque 	= $read_produtos_derivados_view['Estoque'];
									?>
									
									<div class="col-lg-3 col-md-4 col-sm-4 mb-4 text-center">
										<br>
											<div class="card-body">
												<img class="team-img img-responsive" src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produtos_derivados_view['Arquivo']; ?>" alt="" width='500'>					 
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
													<h5> 
														<?php echo utf8_encode ($read_produtos_derivados_view['Convdesc']);?>
													</h5>
													<h5> 
														<?php echo utf8_encode ($read_produtos_derivados_view['QtdProdutoIncremento']);?> Unid. 
														R$ <?php echo number_format($valortotal2,2,",",".");?>
													</h5>
													<?php if($row_empresa['CashBackAtivo'] == 'S'){ ?>
														<h6> 
															CashBack R$ <?php echo number_format($cashback,2,",",".");?>
														</h6>
													<?php } ?>
													<h5 class="card-title">
														<?php 
															if($read_produtos_derivados_view['TempoDeEntrega'] <= 0){
																echo 'Pronta Entrega!';
															}else{
																echo 'Prazo de Entrega: ' . $read_produtos_derivados_view['TempoDeEntrega'] . ' Dia(s)';
															} 
														?>
													</h5>
												<?php } ?>
											</div>
											<?php if($loja_aberta){ ?>
												<div class="card-body">
													<?php if($row_empresa['EComerce'] == 'S'){ ?>
														<?php if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ ?>
															<?php if($contar_estoque == "S"){ ?>
																<?php if($qtd_estoque >= $qtd_incremento){ ?>
																	<a href="meu_carrinho.php?carrinho=produto&id=<?php echo $read_produtos_derivados_view['idTab_Valor'];?>" class="btn btn-success" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name),exibirPagar()">Adicionar ao Carrinho</a>
																<?php } else { ?>
																	<a href="produtos.php" class="btn btn-danger" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Indisponível no estoque</a>
																<?php } ?>	
															<?php } else { ?>
																<a href="meu_carrinho.php?carrinho=produto&id=<?php echo $read_produtos_derivados_view['idTab_Valor'];?>" class="btn btn-success" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name),exibirPagar()">Adicionar ao Carrinho</a>
															<?php } ?>	
																
																<!--<a href="meu_carrinho.php?carrinho=produto&id=<?php echo $read_produtos_derivados_view['idTab_Valor'];?>" class="btn btn-success k" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name),exibirPagar()">Adicionar ao Carrinho</a>
																
																<a href="meu_carrinho.php?carrinho=produto&id=<?php echo $read_produtos_derivados_view['idTab_Valor'];?>" class="btn btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Adicionar ao Carrinho</a>-->
															<!--
															<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
															  Aguarde um instante! Estamos processando sua solicitação!
															</div>
															-->
														<?php } else { ?>
															<a href="login_cliente.php" class="btn btn-success " name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Logar P/ Adic. ao Carrinho</a>
															<!--
															<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
															  Aguarde um instante! Estamos processando sua solicitação!
															</div>
															-->
														<?php } ?>	
													<?php } ?>
												</div>
											<?php } else { ?>
												<button class="btn btn-warning "  >Loja Fechada</button>
											<?php } ?>
										
									</div>

									<?php 
								}
							}
						?>
					</div>	
				</div>	
			</div>		
		</div>
	</div>
</section>

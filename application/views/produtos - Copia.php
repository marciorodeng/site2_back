<?php
	if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['id_Cliente'.$idSis_Empresa];
		}else{
		unset(	$_SESSION['id_Cliente'.$idSis_Empresa],
		$_SESSION['Nome_Cliente'.$idSis_Empresa]
		);	
	}	
?>
<section id="service" class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
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
					<div class="container">
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
			
			<!--
			<div class="col-lg-3">
				<?php
					/*
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
					*/
				?>
				<?php
					/*
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
					*/
				?>
				<?php
					/*
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
					*/
				?>
			</div>
			-->
			<div class="col-lg-12">

				
				<div class="row">
					<?php
						if(isset($_GET['cat']) && $_GET['cat'] != ''){
							$id_cat = addslashes($_GET['cat']);
							$sql_categoria = "AND TP.idTab_Catprod = '".$id_cat."'";
							$sql_categoria_id = "AND idTab_Catprod = '".$id_cat."'";
							}else{
							$sql_categoria = '';
							$sql_categoria_id = '';
						}
						
						$result_categoria_id = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprod = 'S' {$sql_categoria_id} ORDER BY TipoCatprod ASC, Catprod ASC  ";
						$read_categoria_id = mysqli_query($conn, $result_categoria_id);
						
						if(mysqli_num_rows($read_categoria_id) > '0'){
							foreach($read_categoria_id as $read_categoria_view_id){
								$id_catprod = $read_categoria_view_id['idTab_Catprod'];
								$tipo_catprod = $read_categoria_view_id['TipoCatprod'];
								$result_produto_id = "SELECT * 
														FROM 
															Tab_Produto as TP
																LEFT JOIN Tab_Catprod AS TCP ON TCP.idTab_Catprod = TP.idTab_Catprod
														WHERE 
															TP.idTab_Produto != '' AND
															TP.Ativo = 'S' AND
															TP.VendaSite = 'S' AND
															TP.idSis_Empresa = '".$idSis_Empresa."' AND
															TP.idTab_Catprod = '".$id_catprod."' 
														ORDER BY
															TP.Produtos ASC ";
								
								if($tipo_catprod == "P"){
									$tipocategoria = 'Produtos';
								}elseif($tipo_catprod == "S"){
									$tipocategoria = 'Serviços';
								}elseif($tipo_catprod == "A"){
									$tipocategoria = 'Aluguel';
								}
								
								echo'
								<div class="col-md-12">
								<hr class="botm-line">
								<h2 class="ser-title">'.$read_categoria_view_id['Catprod'].'</h2>
								</div>';
								
								$read_produto_id = mysqli_query($conn, $result_produto_id);
								if(mysqli_num_rows($read_produto_id) > '0'){
									
									foreach($read_produto_id as $read_produto_view_id){
										$produtobase_id = $read_produto_view_id['idTab_Produto'];
										$result_produtos_id = "SELECT 
																		TPS.idTab_Produtos,
																		TPS.idTab_Produto,
																		TV.VendaSitePreco
																	FROM 
																		Tab_Produtos as TPS
																			LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TPS.idTab_Produto
																			RIGHT JOIN Tab_Valor AS TV ON TV.idTab_Produtos = TPS.idTab_Produtos
																	WHERE
																		TPS.idSis_Empresa = '".$idSis_Empresa."' AND
																		TPS.idTab_Produto = '".$produtobase_id."' AND
																		TV.VendaSitePreco = 'S'
																	";
										$read_produtos_id = mysqli_query($conn, $result_produtos_id);
										if(mysqli_num_rows($read_produtos_id) > '0'){
											$existemprodutos = 1;
										}else{
											$existemprodutos = 0;
										}
										/*
										echo '<br>';
										echo "<pre>";
										print_r($produtobase_id);
										echo '<br>';
										print_r($existemprodutos);
										echo "</pre>";
										*/
										?>
										
											<div class="col-lg-3 col-md-6 col-sm-6 mb-4">
												<br>
													<?php if($existemprodutos == 1) { ?>
														<div class="card-body">
															<a href="produtosderivados.php?id_modelo=<?php echo $read_produto_view_id['idTab_Produto'];?>"><img class="team-img  img-responsive" src="<?php echo $idSis_Empresa;?>/produtos/miniatura/<?php echo $read_produto_view_id['Arquivo'];?>" alt="" width='500'></a>					 
														</div>
														<div class="card-body">
															<h5 class="card-title text-center">
																<a href="produtosderivados.php?id_modelo=<?php echo $read_produto_view_id['idTab_Produto'];?>"><?php echo utf8_encode($read_produto_view_id['Produtos']);?></a>
															</h5>
														</div>
													<?php }elseif($existemprodutos == 0) { ?>
														<div class="card-body">
															<img class="team-img  img-responsive" src="<?php echo $idSis_Empresa;?>/produtos/miniatura/<?php echo $read_produto_view_id['Arquivo'];?>" alt="" width='500'>					 
														</div>	
														<div class="card-body">
															<h5 class="card-title text-center">
																<?php echo utf8_encode($read_produto_view_id['Produtos']);?>
															</h5>
														</div>
													<?php } ?>
												
											</div>
										
										<?php
									}
								}
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
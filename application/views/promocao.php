<?php
	if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['id_Cliente'.$idSis_Empresa];
	}else{
		unset(	$_SESSION['id_Cliente'.$idSis_Empresa],
				$_SESSION['Nome_Cliente'.$idSis_Empresa]
				);	
	}
	$dataatual = date('Y-m-d', time());
	$dia_da_semana = date('N');
?>
<section id="service" class="section-padding">
	<div class="container">
		<div class="row">
		
			<div class="col-lg-12">
				<nav class="navbar navbar-inverse navbar-fixed" role="banner">
					<div class="container-fluid">
						<div class="navbar-header">
							<div class="col-lg-12">
								<button type="button" class="navbar-toggle navbar-brand btn-block" data-toggle="collapse" data-target="#myNavbar">
									<span class="">Categorias</span> <span class="caret"></span>
									<!--
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									-->	
								</button>
							</div>	
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<ul class="nav navbar-nav navbar">
								<?php
									$result_categoria_produtos = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprod = 'S' AND TipoCatprod = 'P'  ORDER BY Catprod ASC ";
									$read_categoria_produtos = mysqli_query($conn, $result_categoria_produtos);
									if(mysqli_num_rows($read_categoria_produtos) > '0'){?>
										<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
											<div class="btn-group">
												<a  class="dropdown-toggle" data-toggle="dropdown">
													<h2>Produtos <span class="caret"></span></h2>
												</a>
												<ul class="dropdown-menu" role="menu">
													<?php
														foreach($read_categoria_produtos as $read_categoria_produtos_view){
															echo '	<li>
																		<a href="produtos.php?cat='.$read_categoria_produtos_view['idTab_Catprod'].'" >
																			'.$read_categoria_produtos_view['Catprod'].'
																		</a>
																	</li>
																	<li role="separator" class="divider"></li>';
														}
													?>
												</ul>
											</div>									
										</li>
										<?php 
									} 
								?>
								<?php
									$result_categoria_servicos = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprod = 'S' AND TipoCatprod = 'S'  ORDER BY Catprod ASC ";
									$read_categoria_servicos = mysqli_query($conn, $result_categoria_servicos);
									
									if(mysqli_num_rows($read_categoria_servicos) > '0'){?>
										<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
											<div class="btn-group">
												<a  class="dropdown-toggle" data-toggle="dropdown">
													<h2>Serviços <span class="caret"></span></h2>
												</a>
												<ul class="dropdown-menu" role="menu">
													<?php
														foreach($read_categoria_servicos as $read_categoria_servicos_view){
															echo '	<li>
																		<a href="produtos.php?cat='.$read_categoria_servicos_view['idTab_Catprod'].'" >
																			'.$read_categoria_servicos_view['Catprod'].'
																		</a>
																	</li>
																	<li role="separator" class="divider"></li>';
														}
													?>
												</ul>
											</div>									
										</li>
										<?php 
									} 
								?>
								<?php
									$result_categoria_promocao = "SELECT * FROM Tab_Catprom WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprom = 'S' ORDER BY Catprom ASC ";
									$read_categoria_promocao = mysqli_query($conn, $result_categoria_promocao);
									if(mysqli_num_rows($read_categoria_promocao) > '0'){?>
										<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
											<div class="btn-group">
												<a  class="dropdown-toggle" data-toggle="dropdown">
													<h2>Promoções <span class="caret"></span></h2>
												</a>
												<ul class="dropdown-menu" role="menu">
													<?php
														foreach($read_categoria_promocao as $read_categoria_promocao_view){
															echo '	<li>
																		<a href="promocao.php?cat='.$read_categoria_promocao_view['idTab_Catprom'].'" >
																			'.$read_categoria_promocao_view['Catprom'].'
																		</a>
																	</li>
																	<li role="separator" class="divider"></li>';
														}
													?>
												</ul>
											</div>									
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
				$result_categoria = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."'AND Site_Catprod = 'S' AND TipoCatprod = 'P'  ORDER BY Catprod ASC ";
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
			<div class="col-md-12">
				<?php if($row_empresa['EComerce'] == 'S' && isset($_SESSION['id_Cliente'.$idSis_Empresa]) && isset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) && count($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) > '0'){ ?>
					<div class="row">	
						<div class="col-md-12">	
							<?php if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ ?>
								<div class="row">	
									<!--<div class="col-md-6">
										<label></label><br>
										<a href="entrega.php" class="btn btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Finalizar Pedido!</a>
									</div>-->
									<div class="col-md-12">
										<label></label><br>
										<a href="entrega.php" class="btn btn-primary btn-block" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)">Carrinho com: <?php echo $_SESSION['total_produtos'.$_SESSION['id_Cliente'.$idSis_Empresa]];?> Unid. <br>Se desejar Finalizar a compra,<br>click aqui.</a>
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
				
				<div class="row">
					<?php
						if(isset($_GET['cat']) && $_GET['cat'] != ''){
							$id_cat = addslashes($_GET['cat']);
							$sql_categoria = "AND TPM.idTab_Catprom = '".$id_cat."'";
							$sql_categoria_id = "AND idTab_Catprom = '".$id_cat."'";
						}else{
							$sql_categoria = '';
							$sql_categoria_id = '';
						}
						
						$result_categoria_id = "
												SELECT * 
												FROM 
													Tab_Catprom 
												WHERE 
													idSis_Empresa = '".$idSis_Empresa."' AND
													Site_Catprom = 'S'
													{$sql_categoria_id} 
												ORDER BY 
													Catprom ASC ";
						$read_categoria_id = mysqli_query($conn, $result_categoria_id);
								
						if(mysqli_num_rows($read_categoria_id) > '0'){
							foreach($read_categoria_id as $read_categoria_view_id){
								$id_catprom = $read_categoria_view_id['idTab_Catprom'];
								$result_produto_id = "
										SELECT 
											TPM.*,
											TCT.*,
											TD.*
										FROM 
											Tab_Promocao as TPM
												LEFT JOIN Tab_Catprom AS TCT ON TCT.idTab_Catprom = TPM.idTab_Catprom
												LEFT JOIN Tab_Dia_Prom AS TD ON TD.idTab_Promocao = TPM.idTab_Promocao
										WHERE 
											TPM.DataInicioProm <= '".$dataatual."' AND 
											TPM.DataFimProm >= '".$dataatual."' AND 
											TD.id_Dia_Prom = '".$dia_da_semana."' AND
											TD.Aberto_Prom = 'S' AND
											TPM.VendaSite = 'S' AND
											TPM.idSis_Empresa = '".$idSis_Empresa."' AND
											TPM.idTab_Catprom = '".$id_catprom."' 
										ORDER BY 
											TPM.Promocao ASC ";
								
								echo'
								<div class="col-md-12">
									<hr class="botm-line">
									<h2 class="ser-title">Promoções - '.$read_categoria_view_id['Catprom'].'</h2>
								</div>';
								
								$read_produto_id = mysqli_query($conn, $result_produto_id);
								if(mysqli_num_rows($read_produto_id) > '0'){
									
									foreach($read_produto_id as $read_produto_view_id){
										
										$idTab_Promocao = $read_produto_view_id['idTab_Promocao'];
										$select_produtos = "SELECT 
																SUM(TV.QtdProdutoDesconto * TV.ValorProduto) AS SubTotal,
																TV.idTab_Promocao
															FROM
																Tab_Valor AS TV
																	LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = TV.idTab_Promocao				
															WHERE
																TV.idTab_Promocao = '".$idTab_Promocao."'
																";
										$subtotal 		= mysqli_query($conn, $select_produtos);
										if(mysqli_num_rows($subtotal) > '0'){
											$valortotal = '0';
											foreach($subtotal as $subtotal_view){
												$valortotal += $subtotal_view['SubTotal'];
											}
										}
									
										echo'
										<div class="col-lg-4 col-md-6 col-sm-6 mb-4">
											<div class="img-produtos ">
												<a href="produtospromocao.php?promocao='.$read_produto_view_id['idTab_Promocao'].'>"><img class="team-img " src="'.$idSis_Empresa.'/promocao/miniatura/'.$read_produto_view_id['Arquivo'].'" alt="" ></a>					 
												<div class="card-body">
													<h5 class="card-title">
														<a href="produtospromocao.php?promocao='.$read_produto_view_id['idTab_Promocao'].'">'.utf8_encode($read_produto_view_id['Promocao']).'</a>
													</h5>
													<h5 class="card-title">
														'.utf8_encode($read_produto_view_id['Descricao']).'
													</h5>
													<h5 class="card-title">
														R$ '.number_format($valortotal,2,",",".").'
													</h5>
												</div>
											</div>
										</div>
										';
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

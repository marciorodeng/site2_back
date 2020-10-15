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
	}						
	/*
	echo '<br>';
	echo "<pre>";
	print_r($id_modelo);
	echo "</pre>";
	exit ();
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
				<div class="col-md-4">
					<h2 class="ser-title">Produtos</h2>
					<hr class="botm-line">
				</div>
				-->
				<?php if($row_empresa['EComerce'] == 'S' && isset($_SESSION['id_Cliente'.$idSis_Empresa]) && isset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) && count($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) > '0'){ ?>
					<div class="row">	
						<div class="col-md-12">	
							<?php if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ ?>
								<div class="row">	
									<div class="col-md-6">
										<label></label><br>
										<a href="entrega.php" class="btn btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Finalizar Pedido!</a>
									</div>
									<div class="col-md-6">
										<label></label><br>
										<a href="meu_carrinho.php" class="btn btn-primary btn-block" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)">Voltar ao Carrinho!</a>
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
					<div class="col-md-12">
						<?php
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
								TOP2.Opcao AS Opcao2,
								TOP1.Opcao AS Opcao1,
								(TV.ValorProduto) AS SubTotal2
							FROM 
								Tab_Valor AS TV
									LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TV.idTab_Produtos
									LEFT JOIN Tab_Promocao AS TPR ON TPR.idTab_Promocao = TV.idTab_Promocao
									LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TPS.idTab_Produto
									LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
									LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2

							WHERE 
								TV.idTab_Modelo = '".$id_modelo."' AND
								TV.Desconto = '1' AND
								TPR.Ativo = 'S' AND
								TPR.VendaSite = 'S' AND
								TV.AtivoPreco = 'S' AND
								TV.VendaSitePreco = 'S'
							ORDER BY 
								TPS.idTab_Produtos ASC
							");
							$valortotal2 = '0';
							if(mysqli_num_rows($read_produtos_derivados) > '0'){
								foreach($read_produtos_derivados as $read_produtos_derivados_view){
									$subtotal2 		= $read_produtos_derivados_view['SubTotal2'];
									$valortotal2 	= $subtotal2;
									?>		
									<div class="col-lg-4 col-md-4 col-sm-6 mb-4">
										<div class="img-produtos ">
											<a href="produto.php?id=<?php echo $read_produtos_derivados_view['idTab_Valor'];?>"><img class="team-img " src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produtos_derivados_view['Arquivo']; ?>" alt="" ></a>					 
											<div class="card-body">
												<h5 class="card-title">
													<a href="produto.php?id=<?php echo $read_produtos_derivados_view['idTab_Valor'];?>">
																			<?php echo utf8_encode ($read_produtos_derivados_view['Nome_Prod']);?><br> 
																			<?php echo utf8_encode ($read_produtos_derivados_view['Opcao2']);?><br>
																			<?php echo utf8_encode ($read_produtos_derivados_view['Opcao1']);?> - 
																			<?php echo utf8_encode ($read_produtos_derivados_view['Convdesc']);?> 
																			<?php echo utf8_encode ($read_produtos_derivados_view['QtdProdutoIncremento']);?> Unid.
													</a>
												</h5>
												<!--<h5><?php echo utf8_encode ($read_produtos_derivados_view['Promocao']);?></h5>-->
												<h4>R$ <?php echo number_format($valortotal2,2,",",".");?></h4>
												<!--<h4>R$ <?php echo number_format($read_produtos_derivados_view['ValorProduto'],2,",",".");?></h4>-->
											</div>
											<div class="row">
												<div class="col-lg-12">							
													<div class="card card-outline-secondary my-4">
														<div class="card-body">
															<br>
															<?php if($row_empresa['EComerce'] == 'S'){ ?>
																<?php if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ ?>
																		<a href="meu_carrinho.php?carrinho=produto&id=<?php echo $read_produtos_derivados_view['idTab_Valor'];?>" class="btn btn-success k" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name),exibirPagar()">Adicionar ao Carrinho</a>
																		
																		<!--<a href="meu_carrinho.php?carrinho=produto&id=<?php echo $read_produtos_derivados_view['idTab_Valor'];?>" class="btn btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Adicionar ao Carrinho</a>-->
																	<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
																	  Aguarde um instante! Estamos processando sua solicitação!
																	</div>
																<?php } else { ?>
																	<a href="login_cliente.php" class="btn btn-success " name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Logar P/ Adicionar ao Carrinho</a>
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

<?php
	if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['id_Cliente'.$idSis_Empresa];
	}else{
		unset(	$_SESSION['id_Cliente'.$idSis_Empresa],
				$_SESSION['Nome_Cliente'.$idSis_Empresa]
				);	
	}
	$dataatual = date('Y-m-d', time());
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
						<h2 class="ser-title">Promoções</h2>
						<hr class="botm-line">
					</div>
					<div class="col-md-12">
						<?php

							$read_promocao = mysqli_query($conn, "
							SELECT 
								TPM.idTab_Promocao,
								TPM.Promocao,
								TPM.Descricao,
								TPM.Arquivo,
								TPM.Desconto,
								TPM.ValorPromocao,
								TPM.DataInicioProm,
								TPM.DataFimProm,
								SUM(TV.ValorProduto) AS SubTotal2
							FROM 
								Tab_Promocao AS TPM
									LEFT JOIN Tab_Valor AS TV ON TV.idTab_Promocao = TPM.idTab_Promocao
							WHERE 
								TPM.idSis_Empresa = '".$idSis_Empresa."' AND 
								TPM.DataInicioProm <= '".$dataatual."' AND 
								TPM.DataFimProm >= '".$dataatual."' AND
								TPM.Ativo = 'S' AND
								TPM.VendaSite = 'S' AND
								TV.AtivoPreco = 'S' AND
								TV.VendaSitePreco = 'S' AND
								TPM.Desconto != '1'
							GROUP BY
								TPM.idTab_Promocao	
							ORDER BY 
							TPM.Desconto ASC
							");
							$valortotal = $valortotal2 = '0';
							if(mysqli_num_rows($read_promocao) > '0'){
								foreach($read_promocao as $read_promocao_view){
									$subtotal2 		= $read_promocao_view['SubTotal2'];
									$valortotal2 	= $subtotal2;
									
									$idTab_Promocao = $read_promocao_view['idTab_Promocao'];
									$select_produtos = "SELECT 
															SUM(TV.QtdProdutoIncremento * TV.ValorProduto) AS SubTotal,
															TV.idTab_Promocao
														FROM
															Tab_Valor AS TV
																LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = TV.idTab_Promocao				
														WHERE
															TV.idTab_Promocao = '".$idTab_Promocao."' AND
															TV.idSis_Empresa = '".$idSis_Empresa."' AND
															TV.AtivoPreco = 'S' AND
															TV.VendaSitePreco = 'S' 
															";
									$subtotal 		= mysqli_query($conn, $select_produtos);
									if(mysqli_num_rows($subtotal) > '0'){
										foreach($subtotal as $subtotal_view){
											$valortotal = $subtotal_view['SubTotal'];
										}
									}
									
									?>		
									<div class="col-lg-4 col-md-4 col-sm-6 mb-4">
										<div class="img-produtos ">
											<?php if($row_empresa['EComerce'] == 'S'){ ?>
												<?php if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ ?>
													<a href="meu_carrinho.php?carrinho=promocao&id=<?php echo $read_promocao_view['idTab_Promocao'];?>"> <img class="team-img " src="<?php echo $idSis_Empresa ?>/promocao/miniatura/<?php echo $read_promocao_view['Arquivo']; ?>" alt="" ></a>					 
												<?php } else { ?>
													<a href="login_cliente.php"  name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)"> <img class="team-img " src="<?php echo $idSis_Empresa ?>/promocao/miniatura/<?php echo $read_promocao_view['Arquivo']; ?>" alt="" ></a>
												<?php } ?>
											<?php } else { ?>
												<img class="team-img " src="<?php echo $idSis_Empresa ?>/promocao/miniatura/<?php echo $read_promocao_view['Arquivo']; ?>" alt="" >
											<?php } ?>
											<div class="card-body">
												<h4 class="card-title">
													<?php if($row_empresa['EComerce'] == 'S'){ ?>
														<?php if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ ?>
															<a href="meu_carrinho.php?carrinho=promocao&id=<?php echo $read_promocao_view['idTab_Promocao'];?>"> <?php echo utf8_encode ($read_promocao_view['Promocao']);?></a>
														<?php } else { ?>
															<a href="login_cliente.php"  name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)"> <?php echo utf8_encode ($read_promocao_view['Promocao']);?><br>Logar P/ Adicionar ao Carrinho</a>
														<?php } ?>
													<?php } else { ?>
														<?php echo utf8_encode ($read_promocao_view['Promocao']);?>
													<?php } ?>
												</h4>
												<h5><?php echo utf8_encode ($read_promocao_view['Descricao']);?></h5>
												<!--<h4>R$ <?php echo number_format($read_promocao_view['ValorPromocao'],2,",",".");?></h4>-->
												<h4>R$ <?php echo number_format($valortotal2,2,",",".");?></h4>
												<!--<p><?php echo utf8_encode ($read_promocao_view['produto_breve_descricao']);?></p>-->
											</div>
											<!--
											<div class="card-body">
												<a href="meu_carrinho.php?id=<?php echo $read_promocao_view['idTab_Valor'];?>" class="btn btn-success">Adicionar ao Carrinho</a>
											</div>										
											-->	
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

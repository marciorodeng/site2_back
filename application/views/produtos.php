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
			<div class="col-lg-9">
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
									<a href="entrega.php" class="btn btn-primary btn-block" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)">Carrinho com: <?php echo $_SESSION['total_produtos'.$_SESSION['id_Cliente'.$idSis_Empresa]];?> Unid.<br> Se desejar Finalizar a compra,<br> click aqui.</a>
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
							$sql_categoria = "AND TP.idTab_Catprod = '".$id_cat."'";
							$sql_categoria_id = "AND idTab_Catprod = '".$id_cat."'";
						}else{
							$sql_categoria = '';
							$sql_categoria_id = '';
						}
						
						$result_categoria_id = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprod = 'S' {$sql_categoria_id} ORDER BY Catprod ASC ";
						$read_categoria_id = mysqli_query($conn, $result_categoria_id);
								
						if(mysqli_num_rows($read_categoria_id) > '0'){
							foreach($read_categoria_id as $read_categoria_view_id){
								$id_catprod = $read_categoria_view_id['idTab_Catprod'];
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
								
								echo'
								<div class="col-md-12">
									<hr class="botm-line">
									<h2 class="ser-title">'.$read_categoria_view_id['Catprod'].'</h2>
								</div>';
								
								$read_produto_id = mysqli_query($conn, $result_produto_id);
								if(mysqli_num_rows($read_produto_id) > '0'){
									
									foreach($read_produto_id as $read_produto_view_id){
										echo'
										<div class="col-lg-4 col-md-6 col-sm-6 mb-4">
											<div class="img-produtos ">
												<a href="produtosderivados.php?id_modelo='.$read_produto_view_id['idTab_Produto'].'>"><img class="team-img " src="'.$idSis_Empresa.'/produtos/miniatura/'.$read_produto_view_id['Arquivo'].'" alt="" ></a>					 
												<div class="card-body">
													<h5 class="card-title">
														<a href="produtosderivados.php?id_modelo='.$read_produto_view_id['idTab_Produto'].'">'.utf8_encode($read_produto_view_id['Produtos']).'</a>
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

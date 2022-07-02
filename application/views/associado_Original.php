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
			<div class="col-md-12">
				<h2 class="ser-title">Nossos Produtos!</h2>
				<hr class="botm-line">
			</div>				
			<div class="col-lg-12">
				<div class="col-lg-12">
					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<!--
							<ol class="carousel-indicators">
							<?php
								$controle_ativo = 2;		
								$controle_num_slide = 1;
								$result_carousel = "SELECT 
								TP.idTab_Produto,
								TP.Produtos,
								TP.idSis_Empresa,
								TP.Arquivo,
								TP.VendaSite,
								TP.ValorProdutoSite,
								TV.ValorProduto
								FROM 
								Tab_Produto AS TP
								LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produto = TP.idTab_Produto
								WHERE 
								TP.idSis_Empresa = '".$idSis_Empresa."' AND 
								TP.Ativo = 'S' AND
								TP.VendaSite = 'S' 
								ORDER BY 
								TP.idTab_Produto ASC";
								$resultado_carousel = mysqli_query($conn, $result_carousel);
								while($row_carousel = mysqli_fetch_assoc($resultado_carousel)){ 
									if($controle_ativo == 2){ ?>
									<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li><?php
										$controle_ativo = 1;
									}else{ ?>
									<li data-target="#carousel-example-generic" data-slide-to="<?php echo $controle_num_slide; ?>"></li><?php
										$controle_num_slide++;
									}
								}
							?>						
							</ol>
						-->
						<!-- Wrapper for slides -->
						<div class="carousel-inner" role="listbox">
							<?php
								$controle_ativo = 2;						
								$result_carousel = "SELECT 
								TP.idTab_Produto,
								TP.Produtos,
								TP.idSis_Empresa,
								TP.Arquivo,
								TP.VendaSite,
								TP.ValorProdutoSite,
								TV.ValorProduto
								FROM 
								Tab_Produto AS TP
								LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produto = TP.idTab_Produto
								WHERE 
								TP.idSis_Empresa = '".$idSis_Empresa."' AND 
								TP.Ativo = 'S' AND
								TP.VendaSite = 'S' 
								ORDER BY 
								TP.idTab_Produto ASC";
								$resultado_carousel = mysqli_query($conn, $result_carousel);
								while($row_carousel = mysqli_fetch_assoc($resultado_carousel)){ 
									if($controle_ativo == 2){ ?>
										<div class="item active">
											<img src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $row_carousel['Arquivo']; ?>" alt="<?php echo $row_carousel['Produtos']; ?>">
											<div class="carousel-caption d-none d-md-block">
												<a href="produtos.php"><h3>Clique Aqui!</h3><p class="paragrafo">Conheça todos os produtos!</p></a>
											</div>												
										</div> <?php
										$controle_ativo = 1;
									}else{ ?>
										<div class="item">
											<img src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $row_carousel['Arquivo']; ?>" alt="<?php echo $row_carousel['Produtos']; ?>">
											<div class="carousel-caption d-none d-md-block">
												<a href="produtos.php"><h3>Clique Aqui!</h3><p class="paragrafo">Conheça todos os produtos!</p></a>
											</div>												
										</div> <?php
									}
								}
							?>					
						</div>
						
						<!-- Controls -->
						<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
				</div>
			</div>				
		</div>
	</div>
</section>		

						
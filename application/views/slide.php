<section id="slide" class="section-padding1">
	<div class="container">
		<div class="row">
			<div class="col-md-12">	
				<div class="espaco-topo">
					<div id="carousel-example-generic2" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						
							<ol class="carousel-indicators">
							<?php
								$controle_ativo1 = 2;		
								$controle_num_slide1 = 1;
								$result_carousel1 = "SELECT * FROM App_Slides WHERE idSis_Empresa = '".$idSis_Empresa."' AND Ativo = 'S' ORDER BY idApp_Slides ASC";
								$resultado_carousel1 = mysqli_query($conn, $result_carousel1);								
								while($row_carousel1 = mysqli_fetch_assoc($resultado_carousel1)){
									if($controle_ativo1 == 2){ ?>
									<li data-target="#carousel-example-generic2" data-slide-to="0" class="active"></li><?php
										$controle_ativo1 = 1;
									}else{ ?>
									<li data-target="#carousel-example-generic2" data-slide-to="<?php echo $controle_num_slide1; ?>"></li><?php
										$controle_num_slide1++;
									}
								}
							?>					
							</ol>
						
						<!-- Wrapper for slides -->
						<div class="carousel-inner" role="listbox">
							<?php
								$controle_ativo1 = 2;						
								$result_carousel1 = "SELECT * FROM App_Slides WHERE idSis_Empresa = '".$idSis_Empresa."' AND Ativo = 'S' ORDER BY idApp_Slides ASC";
								$resultado_carousel1 = mysqli_query($conn, $result_carousel1);
								while($row_carousel1 = mysqli_fetch_assoc($resultado_carousel1)){
									if($controle_ativo1 == 2){ ?>
										<div class="item active">
											<!--<img src="<?php echo $idSis_Empresa ?>/documentos/miniatura/<?php echo $row_carousel1['Slide1']; ?>" alt="">-->
											<img src="<?php echo $idSis_Empresa ?>/documentos/miniatura/<?php echo $row_carousel1['Slide1']; ?>" alt="">
											<div class="carousel-caption d-none d-md-block">
												<h1><?php echo utf8_encode($row_carousel1['Texto_Slide1']); ?></h1>
											</div>												
										</div> <?php
										$controle_ativo1 = 1;
									}else{ ?>
										<div class="item">
											<!--<img src="<?php echo $idSis_Empresa ?>/documentos/miniatura/<?php echo $row_carousel1['Slide1']; ?>" alt="">-->
											<img src="<?php echo $idSis_Empresa ?>/documentos/miniatura/<?php echo $row_carousel1['Slide1']; ?>" alt="">
											<div class="carousel-caption d-none d-md-block">
												<h1><?php echo utf8_encode($row_carousel1['Texto_Slide1']); ?></h1>
											</div>												
										</div> <?php
									}
								}
							?>					
						</div>
						
						<!-- Controls -->
						<a class="left carousel-control" href="#carousel-example-generic2" role="button" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="right carousel-control" href="#carousel-example-generic2" role="button" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>		

						
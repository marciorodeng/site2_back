<?php
	if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];
	}else{
		unset(	$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa],
				$_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa]
				);	
	}
	$result_atuacao = "
						SELECT 
							idApp_Atuacao,
							Nome_Atuacao,
							Texto_Atuacao,
							Arquivo_Atuacao,
							Ativo_Atuacao
						FROM 
							App_Atuacao
						WHERE 
							idSis_Empresa = '".$idSis_Empresa."' AND
							Ativo_Atuacao = 'S'
						ORDER BY 
							idApp_Atuacao ASC
					";
	$resultado_atuacao = mysqli_query($conn, $result_atuacao);
	$cont_atuacao = mysqli_num_rows($resultado_atuacao);
	
	$result_colaborador = "
							SELECT 
								idApp_Colaborador,
								Nome_Colaborador,
								Texto_Colaborador,
								Arquivo_Colaborador,
								Ativo_Colaborador
							FROM 
								App_Colaborador
							WHERE 
								idSis_Empresa = '".$idSis_Empresa."' AND
								Ativo_Colaborador = 'S'
							ORDER BY 
								idApp_Colaborador ASC
						";
	$resultado_colaborador = mysqli_query($conn, $result_colaborador);
	$cont_colaborador = mysqli_num_rows($resultado_colaborador);
				
	$result_depoimento = "
							SELECT 
								idApp_Depoimento,
								Nome_Depoimento,
								Texto_Depoimento,
								Arquivo_Depoimento,
								Ativo_Depoimento
							FROM 
								App_Depoimento
							WHERE 
								idSis_Empresa = '".$idSis_Empresa."' AND
								Ativo_Depoimento = 'S'
							ORDER BY 
								idApp_Depoimento ASC
						";
	$resultado_depoimento = mysqli_query($conn, $result_depoimento);
	$cont_depoimento = mysqli_num_rows($resultado_depoimento);
?>
<section id="about" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h1 class="title-h1"><?php echo $row_empresa['NomeEmpresa'];?></h1>
				<hr class="traco-h1">
			</div>
			<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<div class="section-title">
					<br>
					<p style="text-align: justify; text-indent: 30px;" class="sec-para"><?php echo $row_empresa['AEmpresa'];?></p>
					<!--<a href="" style="color: #0cb8b6; padding-top:10px;">Saiba Mais..</a>-->
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<div style="visibility: visible;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 more-features-box">
					<?php if(isset($row_empresa['Top1']) && $row_empresa['Top1'] != "") { ?>
						<div class="more-features-box-text">
							<div class="more-features-box-text-icon"> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
							<div class="more-features-box-text-description">
								<h4><?php echo $row_empresa['Top1'];?></h4>
								<p><?php echo $row_empresa['Texto_Top1'];?></p>
							</div>
						</div>
					<?php } ?>
					<?php if(isset($row_empresa['Top2']) && $row_empresa['Top2'] != "") { ?>	
						<div class="more-features-box-text">
							<div class="more-features-box-text-icon"> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
							<div class="more-features-box-text-description">
								<h4><?php echo $row_empresa['Top2'];?></h4>
								<p><?php echo $row_empresa['Texto_Top2'];?></p>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<?php if(isset($row_empresa['Video_Empresa']) && $row_empresa['Video_Empresa'] != "") { ?>
					<figure >
						<div class="boxVideo">
							<iframe  class="img-responsive thumbnail" src="https://www.youtube.com/embed/<?php echo $row_empresa['Video_Empresa'];?>" title="Video sobre a empresa <?php echo $row_empresa['NomeEmpresa'];?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					</figure>
				<?php } ?>
			</div>
		</div>
	</div>
</section>
<?php if(isset($cont_atuacao) && $cont_atuacao >= 1) { ?>
	<section id="service" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<h2 class="ser-title">O que fazemos</h2>
					<hr class="botm-line">
				</div>
				<?php while($row_resultado_atuacao = mysqli_fetch_assoc($resultado_atuacao)) { ?>	
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="thumbnail thumbnail2"> 
							<h4 style="text-align: center;"><?php echo $row_resultado_atuacao['Nome_Atuacao']; ?></h4>
							<?php if($row_empresa['EComerce'] == 'S'){ ?>	
								<a href="catalogo.php">
									<img src="<?php echo $idSis_Empresa ?>/documentos/miniatura/<?php echo $row_resultado_atuacao['Arquivo_Atuacao']; ?>" alt="<?php echo $row_resultado_atuacao['Texto_Atuacao']; ?>" class="team-img">
								</a>
							<?php }else{ ?>
								<img src="<?php echo $idSis_Empresa ?>/documentos/miniatura/<?php echo $row_resultado_atuacao['Arquivo_Atuacao']; ?>" alt="<?php echo $row_resultado_atuacao['Texto_Atuacao']; ?>" class="team-img">
							<?php } ?>
							<div class="caption">
								<p style="text-align: justify; text-indent: 30px;"><?php echo $row_resultado_atuacao['Texto_Atuacao']; ?></p>
								<?php if($row_empresa['EComerce'] == 'S'){ ?>
									<p><a class="btn btn-info btn-block" href="catalogo.php" style="color: #ffffff; padding-top:10px;">Conheça nossa loja</a></p>
								<?php }else{ ?>
									<a href="https://api.whatsapp.com/send?phone=55<?php echo $row_empresa['Telefone'];?>&text=" target="_blank" class="btn btn-block btn-success text-center" style="color:#fff; margin-bottom:5px; margin-top: 5px">
										<div class="container-2 text-center">
											<span style="color:#FFFFFF; font-size: 20px;">Fale conosco </span>
											<svg enable-background="new 0 0 512 512" width="30" height="30" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104  l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z" fill="#4CAF50"/><path d="m405.02 361.5c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.62-127.46-112.58-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016 0.16 8.576 0.288 7.52 0.32 11.296 0.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744s-7.36 7.68-11.136 12.352c-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z" fill="#FAFAFA"/></svg>
										</div>
									</a>	
								<?php } ?>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
<?php } ?>
<?php if(isset($cont_depoimento) && $cont_depoimento >= 1) { ?>
	<section id="testimonial" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<br>
					<h2 class="ser-title">Depoimentos</h2>
					<hr class="botm-line">
				</div>
				<?php while($row_resultado_depoimento = mysqli_fetch_assoc($resultado_depoimento)){ ?>	
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="testi-details">
							<!-- Paragraph -->
							<p><?php echo $row_resultado_depoimento['Texto_Depoimento']; ?>.</p>
						</div>
						<div class="testi-info">
							<!-- User Image -->
							<a href="#">
								<!--<img src="img/thumb.png" alt="" class="img-responsive">-->
								<img src="<?php echo $idSis_Empresa ?>/documentos/miniatura/<?php echo $row_resultado_depoimento['Arquivo_Depoimento']; ?>" alt="<?php echo $row_resultado_depoimento['Texto_Depoimento']; ?>" class="img-responsive">
							</a>
							<!-- User Name -->
							<h3><span><?php echo $row_resultado_depoimento['Nome_Depoimento']; ?></span></h3>
						</div>
					</div>					
				<?php } ?>
			</div>
		</div>
		<br><br>
	</section>
<?php } ?>
<?php if(isset($cont_colaborador) && $cont_colaborador >= 1) { ?>
	<section id="doctor-team" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<br>
					<h2 class="ser-title">Nossa Equipe</h2>
					<hr class="botm-line">
				</div>
				<?php while($row_resultado_colaborador = mysqli_fetch_assoc($resultado_colaborador)){ ?>	
					<div class="col-lg-2 col-md-3 col-sm-3 col-xs-6">
						<div class="thumbnail thumbnail3"> 
							<img src="<?php echo $idSis_Empresa ?>/documentos/miniatura/<?php echo $row_resultado_colaborador['Arquivo_Colaborador']; ?>" alt="<?php echo $row_resultado_colaborador['Texto_Colaborador']; ?>" class="team-img">
							<div class="caption">
								<h4><?php echo $row_resultado_colaborador['Nome_Colaborador']; ?></h4>
								<p><?php echo $row_resultado_colaborador['Texto_Colaborador']; ?></p>
								<ul class="list-inline">
									<li><a href="#"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#"><i class="fa fa-twitter"></i></a></li>
									<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
<?php } ?>
<section id="contact" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="container">	
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<br>
				<h2 class="ser-title">Fale Conosco</h2>
				<hr class="botm-line">
				<!--
				<a id="mibew-agent-button" href="/mibew/chat?locale=en" target="_blank" onclick="Mibew.Objects.ChatPopups['5e73e3aadb299d07'].open();return false;">
					<img src="/mibew/b?i=mibew&amp;lang=en" class="img-responsive" border="0" alt="" width="500"/>
				</a>
				<br>
				-->
			</div>	
			<!--
			<div class="col-md-12">
				<h2 class="ser-title">Envie um e-mail</h2>
				<hr class="botm-line">
			</div>
			-->
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3>Informações e contato</h3>
				<div class="space"></div>
				<h4><?php echo $row_empresa['EnderecoEmpresa'];?>, <?php echo $row_empresa['NumeroEmpresa'];?> - <?php echo $row_empresa['ComplementoEmpresa'];?><br>
				<?php echo $row_empresa['BairroEmpresa'];?> - <?php echo $row_empresa['MunicipioEmpresa'];?> - <?php echo $row_empresa['EstadoEmpresa'];?><br>
				Cep: <?php echo $row_empresa['CepEmpresa'];?>.</h4>
				<div class="space"></div>
				<p><i class="fa fa-envelope-o fa-fw pull-left fa-2x"></i><?php echo $row_empresa['Email'];?></p>
				<div class="space"></div>
				<p><i class="fa fa-phone fa-fw pull-left fa-2x"></i><h4>TEL:  <?php echo $row_empresa['Telefone'];?></h4></p>
			</div>
			<!--
			<div class="col-md-8 col-sm-8 marb20">
				<div class="contact-info">	
					
					<p id="resultado"></p>
					<form id="cadastrarUsuario" action=""  method="POST">
						
						<div class="form-group">
						<input type="Nome" name="Nome" class="form-control br-radius-zero" placeholder="Seu nome" data-rule="minlen:4" data-msg="Por favor, no mínimo 4 digitos" />
							<div class="validation"></div>
						</div>
						<div class="form-group">
							<input type="email" class="form-control br-radius-zero" name="email" placeholder="Seu E-mail" data-rule="email" data-msg="Por favor, use um e-mail válido" />
							<div class="validation"></div>
						</div>
						<div class="form-group">
							<textarea type="message" class="form-control br-radius-zero" name="message" rows="5" placeholder="Mensagem" data-rule="minlen:10" data-msg="Por favor, escreva algo para nós."></textarea>
							<div class="validation"></div>
						</div>
						<button type="submit" class="btn btn-primary pull-right">Enviar</button>
					</form>
				</div>
			</div>
			-->
		</div>
	</div>
</section>
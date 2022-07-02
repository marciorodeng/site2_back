<?php
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
					<p style="text-align: justify;  text-indent: 30px;" class="sec-para"><?php echo $row_empresa['AEmpresa'];?></p>
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
							<img src="<?php echo $idSis_Empresa ?>/documentos/miniatura/<?php echo $row_resultado_atuacao['Arquivo_Atuacao']; ?>" alt="<?php echo $row_resultado_atuacao['Texto_Atuacao']; ?>" class="team-img">
							<div class="caption">
								<p style="text-align: justify; text-indent: 30px;"><?php echo $row_resultado_atuacao['Texto_Atuacao']; ?></p>
								<?php if($row_empresa['EComerce'] == 'S'){ ?>
									<p><a class="btn btn-info btn-block" href="index.php" style="color: #ffffff; padding-top:10px;">Conheça nossa loja</a></p>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
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
							<p><?php echo $row_resultado_depoimento['Texto_Depoimento']; ?>.</p>
						</div>
						<div class="testi-info">
							<a href="#">
								<img src="<?php echo $idSis_Empresa ?>/documentos/miniatura/<?php echo $row_resultado_depoimento['Arquivo_Depoimento']; ?>" alt="<?php echo $row_resultado_depoimento['Texto_Depoimento']; ?>" class="img-responsive">
							</a>
							<h3><span><?php echo $row_resultado_depoimento['Nome_Depoimento']; ?></span></h3>
						</div>
					</div>					
				<?php } ?>
			</div>
		</div>
		<br><br>
	</section>
<?php } ?>
<section id="contact" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="container">	
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<br>
				<h2 class="ser-title">Fale Conosco</h2>
				<hr class="botm-line">
			</div>
			<!--
			<a id="mibew-agent-button" href="/mibew/chat?locale=en" target="_blank" onclick="Mibew.Objects.ChatPopups['5e73e3aadb299d07'].open();return false;">
				<img src="/mibew/b?i=mibew&amp;lang=en" class="img-responsive" border="0" alt="" width="500"/>
			</a>
			<br>
			-->	
			<!--
			<div class="col-md-12">
				<h2 class="ser-title">Envie um e-mail</h2>
				<hr class="botm-line">
			</div>
			-->
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3>Informações e contato</h3>
				<div class="space"></div>
				<h4><?php echo utf8_encode($row_empresa['EnderecoEmpresa']);?>, <?php echo utf8_encode($row_empresa['NumeroEmpresa']);?> - <?php echo utf8_encode($row_empresa['ComplementoEmpresa']);?><br>
				<?php echo utf8_encode($row_empresa['BairroEmpresa']);?> - <?php echo utf8_encode($row_empresa['MunicipioEmpresa']);?> - <?php echo utf8_encode($row_empresa['EstadoEmpresa']);?><br>
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
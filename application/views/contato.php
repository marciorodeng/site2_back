<section id="contato" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h1 class="title-h1">Fale Conosco</h1>
				<hr class="traco-h1">
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

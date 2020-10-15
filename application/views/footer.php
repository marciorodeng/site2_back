<footer id="footer">
	<div class="top-footer">
		<div class="container">
			<div class="row">
				
				<div class="col-md-4 col-sm-4 marb20">
					<div class="ftr-tle">
						<h4 class="white no-padding">Sobre Nós</h4>
					</div>
					<div class="info-sec">
						<p><?php echo utf8_encode($row_empresa['SobreNos']);?></p>
					</div>
					<?php if(isset($_SESSION['Nome_Usuario'.$idSis_Empresa])){ ?>
						<div class="col-md-12">	
							<?php if(isset($_SESSION['Nome_Usuario'.$idSis_Empresa])){ ?>
								<div class="col-md-3">
									<img class="img-circle " width='80' src="../contapessoal/5/usuarios/miniatura/<?php echo $_SESSION['Arquivo_Usuario'.$idSis_Empresa]; ?>" alt="">					
								</div>
								<div class="col-md-9 ">
									<a class="white no-padding" ><?php echo $_SESSION['Nome_Usuario'.$idSis_Empresa]; ?></a>
									<p class="white no-padding">Indica a Nossa Empresa!</p>
								</div>
							<?php } ?>
						</div>	
					<?php } ?>
				</div>
				
				<div class="col-md-4 col-sm-4 marb20">
					<div class="ftr-tle">
						<h4 class="white no-padding">Atalhos</h4>
					</div>
					<div class="info-sec">
						<ul class="quick-info">
							<li><a href="#slide"><i></i>Slides</a></li>
							<li><a href="produtos.php"><i></i>Produtos</a></li>
							<li><a href="contato.php"><i></i>Fale Conosco</a></li>
						</ul>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 marb20">
					<div class="ftr-tle">
						<h4 class="white no-padding">Atendimento</h4>
					</div>
					<div class="info-sec">
						<p><?php echo utf8_encode($row_empresa['Atendimento']);?></p>
					</div>
				</div>
				<!--
				<div class="col-md-4 col-sm-4 marb20">
					<div class="ftr-tle">
						<h4 class="white no-padding">Siga-nos nas redes sociais</h4>
					</div>
					<div class="info-sec">
						<ul class="social-icon">
							<li class="bglight-blue"><i class="fa fa-facebook"></i></li>
							<li class="bgred"><i class="fa fa-google-plus"></i></li>
							<li class="bgdark-blue"><i class="fa fa-linkedin"></i></li>
							<li class="bglight-blue"><i class="fa fa-twitter"></i></li>
						</ul>
					</div>
				</div>
				-->
			</div>
		</div>
	</div>
	<div class="footer-line">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="credits">
						<h6>Feito Por <a href="https://www.enkontraki.com.br/<?php echo $sistema ?>" target="_blank">enkontraki.com.br</a> .TODOS OS DIREITOS RESERVADOS.<br>
						Todo o conteúdo do site, todas as fotos, imagens, aqui veiculados, são de propriedade e responsabilidade exclusiva da <?php echo utf8_encode($row_empresa['NomeEmpresa']);?>. É vedada qualquer reprodução, total ou parcial, de qualquer elemento de identidade, sem expressa autorização. A violação de qualquer direito mencionado implicará na responsabilização cível e criminal nos termos da Lei.<br>
						<?php echo utf8_encode($row_empresa['NomeEmpresa']);?> - CNPJ: <?php echo utf8_encode($row_empresa['Cnpj']);?> - <?php echo utf8_encode($row_empresa['EnderecoEmpresa']);?>, <?php echo utf8_encode($row_empresa['NumeroEmpresa']);?> - <?php echo utf8_encode($row_empresa['ComplementoEmpresa']);?>
						<?php echo utf8_encode($row_empresa['BairroEmpresa']);?> - <?php echo utf8_encode($row_empresa['MunicipioEmpresa']);?> - <?php echo utf8_encode($row_empresa['EstadoEmpresa']);?> - Cep: <?php echo $row_empresa['CepEmpresa'];?>. <br>
						A inclusão no carrinho não garante o preço e/ou a disponibilidade do produto. Caso os produtos apresentem divergências de valores, o preço válido é o exibido na tela de pagamento. Vendas sujeitas a análise e disponibilidade de estoque.</h6>

					</div>
				</div>
			</div>
		</div>
	</div>
</footer>


		<footer id="footer" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="top-footer">
				<div class="container">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12 marb20">
							<div class="ftr-tle">
								<h4 class="white no-padding">Sobre Nós</h4>
							</div>
							<div class="info-sec">
								<p><?php echo utf8_encode($row_empresa['SobreNos']);?></p>
							</div>
							<?php if(isset($_SESSION['Site_Back']['Nome_Usuario'.$idSis_Empresa])){ ?>
								<div class="col-md-12">	
									<?php if(isset($_SESSION['Site_Back']['Nome_Usuario'.$idSis_Empresa])){ ?>
										<div class="col-md-3">
											<img class="img-circle " width='80' src="../associados/5/usuarios/miniatura/<?php echo $_SESSION['Site_Back']['Arquivo_Usuario'.$idSis_Empresa]; ?>" alt="">					
										</div>
										<div class="col-md-9 ">
											<a class="white no-padding" ><?php echo $_SESSION['Site_Back']['Nome_Usuario'.$idSis_Empresa]; ?></a>
											<p class="white no-padding">Indica a Nossa Empresa!</p>
										</div>
									<?php } ?>
								</div>	
							<?php } ?>
						</div>
						<!--
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
						-->
						<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12 marb20">
							<div class="ftr-tle">
								<h4 class="white no-padding">Atendimento</h4>
							</div>
							<div class="info-sec">
								<p><?php echo utf8_encode($row_empresa['Atendimento']);?></p>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 marb20">
							<div class="ftr-tle">
								<h4 class="white no-padding">Siga-nos nas redes sociais</h4>
							</div>
							<div class="info-sec">
								<ul class="social-icon">
									<?php if($row_empresa['Facebook']) { ?>
										<a href="https://www.facebook.com/<?php echo $row_empresa['Facebook'];?>" target="_blank">
											<li class="bglight-blue">
												<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16" style="margin-top:10px">
												  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
												</svg>
											</li>
										</a>
									<?php } ?>
									<?php if($row_empresa['Instagram']) { ?>	
										<a href="https://www.instagram.com/<?php echo $row_empresa['Instagram'];?>" target="_blank">
											<li class="bgred">
												<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16" style="margin-top:10px">
												  <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
												</svg>
											</li>
										</a>
									<?php } ?>
									<?php if($row_empresa['Youtube']) { ?>
										<a href="https://www.youtube.com/watch?v=<?php echo $row_empresa['Youtube'];?>" target="_blank">
											<li class="bgdark-blue">
												<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16" style="margin-top:10px">
												  <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"/>
												</svg>
											</li>
										</a>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="footer-line">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
							<div class="credits">
								<h6>Feito Por <a href="https://www.enkontraki.com.br" target="_blank"> enkontraki.com.br </a>. TODOS OS DIREITOS RESERVADOS.<br>
								Todo o conteúdo do site, todas as fotos, imagens, aqui veiculados, são de propriedade e responsabilidade exclusiva da <?php echo utf8_encode($row_empresa['NomeEmpresa']);?>. É vedada qualquer reprodução, total ou parcial, de qualquer elemento de identidade, sem expressa autorização. A violação de qualquer direito mencionado implicará na responsabilização cível e criminal nos termos da Lei.<br>
								<?php echo utf8_encode($row_empresa['NomeEmpresa']);?> - CNPJ: <?php echo utf8_encode($row_empresa['Cnpj']);?> - <?php echo utf8_encode($row_empresa['EnderecoEmpresa']);?>, <?php echo utf8_encode($row_empresa['NumeroEmpresa']);?> - <?php echo utf8_encode($row_empresa['ComplementoEmpresa']);?>
								<?php echo utf8_encode($row_empresa['BairroEmpresa']);?> - <?php echo utf8_encode($row_empresa['MunicipioEmpresa']);?> - <?php echo utf8_encode($row_empresa['EstadoEmpresa']);?> - Cep: <?php echo $row_empresa['CepEmpresa'];?>. <br>
								A inclusão no carrinho não garante o preço e/ou a disponibilidade do produto. Caso os produtos apresentem divergências de valores, o preço válido é o exibido na tela de pagamento. Vendas sujeitas a análise e disponibilidade de estoque.</h6>

							</div>
						</div>
					</div>
				</div>
			</div>
			<a href="https://api.whatsapp.com/send?phone=55<?php echo $row_empresa['Telefone'];?>&text=" target="_blank" style="position:fixed;bottom:20px;right:30px;">
				<svg enable-background="new 0 0 512 512" width="50" height="50" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104  l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z" fill="#4CAF50"/><path d="m405.02 361.5c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.62-127.46-112.58-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016 0.16 8.576 0.288 7.52 0.32 11.296 0.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744s-7.36 7.68-11.136 12.352c-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z" fill="#FAFAFA"/></svg>
			</a>
		</footer>
		
		<script src="../site2_back/js/jquery.min.js"></script> 	
		<script src="../site2_back/js/jquery-ui.js"></script>
		<script src="../site2_back/js/pesquisar.js" language="JavaScript"></script>	
		<script src="../site2_back/js/jquery.mask.min.js"></script>
		<script src="../site2_back/js/bootstrap.min.js"></script> 	
		<script src="../site2_back/js/carregador.js" language="JavaScript"></script>
		<!--<script src="../site2_back/js/personalizado.js" language="JavaScript"></script>-->
   
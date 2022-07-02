<?php
	if($idSis_Empresa){
		$_SESSION['Site_Back']['Acesso']['idSis_Empresa'] = $idSis_Empresa;
	}
?>
<section id="navegador" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	
	<input type="hidden" id="id_empresa" value="<?php echo $idSis_Empresa;?>">
	<input type="hidden" id="sistema" value="<?php echo $sistema;?>">
	
	<nav class="navbar navbar-inverse navbar-fixed-top navbar-menu">
		<div class="row">	
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-4 navbar-header">
				<a class="navbar-brand navbar-logo" href="inicial.php">
					<img src="<?php echo $idSis_Empresa ?>/documentos/miniatura/<?php echo $row_documento['Logo_Nav']; ?>">
				</a>
				<!--<span class="navbar-brand" style="color: #FFFFFF" ><?php #echo utf8_encode($row_empresa['NomeEmpresa']);?></span>-->
			</div>
			<!--
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-4">			
				<?php if(isset($_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa])){ ?>
					<a class="navbar-foto" href="">
						<img class=" img-circle "  width='40' src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/clientes/miniatura/<?php echo $_SESSION['Site_Back']['Arquivo_Cliente'.$idSis_Empresa]; ?>" alt="">
					</a>							
				<?php } else { ?>
					<a class="navbar-foto" href="">
						<img class=" img-circle "  width='40' src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/clientes/miniatura/Foto.jpg" alt="">
					</a>
				<?php } ?>
			</div>
			-->	
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
				<?php if($row_empresa['EComerce'] == 'S'){ ?>
					<a class="navbar-logo navbar-lupa" href="meu_carrinho.php">
						<div class="container-2">
							<img class="" type="button"  width='30' height="30" src="../<?php echo $sistema ?>/arquivos/imagens/carrinho.png">
							<span class="" style="color: #000000">
								<?php 
									if(isset($_SESSION['Site_Back']['carrinho'.$idSis_Empresa])){
										echo count($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]);
									}else{
										echo '0';
									}
								?>
							</span>
						</div>	
					</a>
				<?php } ?>			
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-2">
				<a class="navbar-lupa" href="" data-toggle="modal" data-target="#buscaModal">
					<img class="" type="button"  width='30'  src="../<?php echo $sistema ?>/arquivos/imagens/lupa.png">
				</a>
			</div>
			<div class="col-xs-2 navbar-header">	
				<button type="button" class="navbar-toggle " data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			
		</div>
		<div class="row">
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right navbar-fonte">
					<li class="" >
						<a class="nav-link" style="color: #8a8a8a" href="contato.php">Fale Conosco</a>
					</li>
					<?php
						$result_categoria_produtos = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprod = 'S' AND TipoCatprod = 'P'  ORDER BY Catprod ASC ";
						$read_categoria_produtos = mysqli_query($conn, $result_categoria_produtos);
						if(mysqli_num_rows($read_categoria_produtos) > '0'){?>
							<li class="dropdown">
								<a class="nav-link dropdown-toggle" style="color: #8a8a8a" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Produtos <span class="caret"></span>
								</a>
								<ul class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdown03">
									<?php
										foreach($read_categoria_produtos as $read_categoria_produtos_view){
											echo '	<li>
														<a class="dropdown-item" href="produtos.php?cat='.$read_categoria_produtos_view['idTab_Catprod'].'" >
															'.$read_categoria_produtos_view['Catprod'].'
														</a>
														</li>
													<li role="separator" class="divider"></li>';
										}
									?>
								</ul>							
							</li>
							<?php 
						} 
					?>								
					<?php
						$result_categoria_servicos = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprod = 'S' AND TipoCatprod = 'S'  ORDER BY Catprod ASC ";
						$read_categoria_servicos = mysqli_query($conn, $result_categoria_servicos);
						if(mysqli_num_rows($read_categoria_servicos) > '0'){?>
							<li class="dropdown">
								<a class="nav-link dropdown-toggle" style="color: #8a8a8a" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Serviços <span class="caret"></span>
								</a>
								<ul class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdown03">
									<?php
										foreach($read_categoria_servicos as $read_categoria_servicos_view){
											echo '	<li>
														<a class="dropdown-item" href="produtos.php?cat='.$read_categoria_servicos_view['idTab_Catprod'].'" >
															'.$read_categoria_servicos_view['Catprod'].'
														</a>
													</li>
													<li role="separator" class="divider"></li>';
										}
									?>
								</ul>						
							</li>
							<?php 
						} 
					?>
					<?php
						$result_categoria_promocao = "SELECT * FROM Tab_Catprom WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprom = 'S' ORDER BY Catprom ASC ";
						$read_categoria_promocao = mysqli_query($conn, $result_categoria_promocao);
						if(mysqli_num_rows($read_categoria_promocao) > '0'){?>
							<li class="dropdown">
								<a class="nav-link dropdown-toggle" style="color: #8a8a8a" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Promoções <span class="caret"></span>
								</a>
								<ul class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdown03">
									<?php
										foreach($read_categoria_promocao as $read_categoria_promocao_view){
											echo '	<li>
														<a class="dropdown-item" href="promocao.php?cat='.$read_categoria_promocao_view['idTab_Catprom'].'" >
															'.$read_categoria_promocao_view['Catprom'].'
														</a>
													</li>
													<li role="separator" class="divider"></li>';
										}
									?>
								</ul>									
							</li>
							<?php 
						
						} 
					?>			
					<?php if($row_empresa['EComerce'] == 'S'){ ?>
						<li class="">
							<a class="nav-link" style="color: #8a8a8a" href="meu_carrinho.php">Meu Carrinho</a>
						</li>
					<?php } ?>
					<?php if(isset($_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa])){ ?>	
						<li class="">
							<a class="nav-link" style="color: #8a8a8a" href="meus_pedidos.php">Meus Pedidos</a>
						</li>
					<?php } ?>	
					<li class="dropdown">
						<a class="nav-link dropdown-toggle" style="color: #8a8a8a" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Login <span class="caret"></span>
						</a>
						<ul class="dropdown-menu" aria-labelledby="dropdown01">
							<li>
								<?php if(isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa])){ ?>
									<?php if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){ ?>
										<a class="dropdown-item" href="pesquisar_cliente.php">
											<img class="img-circle " width='40' src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/clientes/miniatura/<?php echo $_SESSION['Site_Back']['Arquivo_Cliente'.$idSis_Empresa]; ?>" alt=""> 
											<?php echo $_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa];?>
										</a>
										<input type="hidden" id="id_Associado" value= "<?php echo $_SESSION['Site_Back']['id_Associado'.$idSis_Empresa]; ?>">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<textarea type="text" class="form-control Copiado_Associado" id="texto_associado" value= "" readonly="" rows="1"></textarea>
											<button type="button" class="btn btn-sm btn-primary Copiar_Associado" onclick="url_Associado()">
												<span class="Copiar_Associado">Gerar e Copiar Link do Associado <?php echo $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];?></span>
											</button>
											<button type="button" class="btn btn-sm btn-success Copiado_Associado" id="botao">
												<span class="Copiado_Associado">Link Gerado e Copiado do Associado <?php echo $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];?></span>
											</button>
										</div>							
									<?php } else { ?>	
										<a class="dropdown-item" href="pesquisar_cliente.php">
											Pesquisar Cliente
										</a>
									<?php } ?>	
								<?php } else { ?>
									<?php if(isset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa])){ ?>
										<?php if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){ ?>
											<a class="dropdown-item" href="login_cliente.php">
												<img class="img-circle " width='40' src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/clientes/miniatura/<?php echo $_SESSION['Site_Back']['Arquivo_Cliente'.$idSis_Empresa]; ?>" alt=""> 
												<?php echo $_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa];?> 
											</a>
											<input type="hidden" id="id_Associado" value= "<?php echo $_SESSION['Site_Back']['id_Associado'.$idSis_Empresa]; ?>">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<textarea type="text" class="form-control Copiado_Associado" id="texto_associado" value= "" readonly="" rows="1"></textarea>
												<button type="button" class="btn btn-sm btn-primary Copiar_Associado" onclick="url_Associado()">
													<span class="Copiar_Associado">Gerar e Copiar Link do Associado <?php echo $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];?></span>
												</button>
												<button type="button" class="btn btn-sm btn-success Copiado_Associado" id="botao">
													<span class="Copiado_Associado">Link Gerado e Copiado do Associado <?php echo $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];?></span>
												</button>
											</div>							
										<?php } else { ?>	
											<a class="dropdown-item" href="login_cliente.php">
												Login do Cliente
											</a>
										<?php } ?>							
									<?php } else { ?>	
										<?php if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){ ?>
											<a class="dropdown-item" href="login_cliente.php">
												<img class="img-circle " width='40' src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/clientes/miniatura/<?php echo $_SESSION['Site_Back']['Arquivo_Cliente'.$idSis_Empresa]; ?>" alt=""> 
												<?php echo $_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa];?>
											</a>
											<input type="hidden" id="id_Associado" value= "<?php echo $_SESSION['Site_Back']['id_Associado'.$idSis_Empresa]; ?>">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<textarea type="text" class="form-control Copiado_Associado" id="texto_associado" value= "" readonly="" rows="1"></textarea>
												<button type="button" class="btn btn-sm btn-primary Copiar_Associado" onclick="url_Associado()">
													<span class="Copiar_Associado">Gerar e Copiar Link do Associado <?php echo $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];?></span>
												</button>
												<button type="button" class="btn btn-sm btn-success Copiado_Associado" id="botao">
													<span class="Copiado_Associado">Link Gerado e Copiado do Associado <?php echo $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];?></span>
												</button>
											</div>							
										<?php } else { ?>	
											<a class="dropdown-item" href="login_cliente.php">
												Login do Cliente
											</a>
										<?php } ?>
									<?php } ?>
								<?php } ?>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<?php if(isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa])){ ?>
									<a class="dropdown-item" href="login_usuario.php">
										<img class="img-circle " width='40' src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/usuarios/miniatura/<?php echo $_SESSION['Site_Back']['Arquivo_Usuario_vend'.$idSis_Empresa]; ?>" alt=""> 
										<?php echo $_SESSION['Site_Back']['Nome_Usuario_vend'.$idSis_Empresa];?><br>
									</a>
									<input type="hidden" id="id_Vendedor" value= "<?php echo $_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa]; ?>">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<textarea type="text" class="form-control Copiado_Vendedor" id="texto_vendedor" value= "" readonly="" rows="1"></textarea>
										<button type="button" class="btn btn-sm btn-primary Copiar_Vendedor" onclick="url_Vendedor()">
											<span class="Copiar_Vendedor">Gerar e Copiar Link do Vendedor <?php echo $_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa];?></span>
										</button>
										<button type="button" class="btn btn-sm btn-success Copiado_Vendedor" id="botao">
											<span class="Copiado_Vendedor">Link Gerado e Copiado do Vendedor <?php echo $_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa];?></span>
										</button>
									</div>
								<?php } else { ?>
									<?php if(isset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa])){ ?>
										<a class="dropdown-item" href="login_usuario.php">
											<img class="img-circle " width='40' src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/usuarios/miniatura/<?php echo $_SESSION['Site_Back']['Arquivo_Vendedor'.$idSis_Empresa]; ?>" alt=""> 
											<?php echo $_SESSION['Site_Back']['Nome_Vendedor'.$idSis_Empresa];?><br> 
											Vendedor <?php echo $_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa];?>
										</a>							
									<?php } else { ?>								
										<a class="dropdown-item" href="login_usuario.php">
											Login do Vendedor
										</a>
									<?php } ?>	
								<?php } ?>
							</li>	
							<li role="separator" class="divider"></li>
							<li>
								<a class="dropdown-item" target="_blank" href="../<?php echo $sistema;?>/login/index5">
									Administracao
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div id="buscaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header bg-warning">
					<div class="row">
						<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
							<h3 class="modal-title" id="buscaModalLabel"><?php echo $row_empresa['NomeEmpresa']; ?></h3>
							<div class="row">
								<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 mb-3 ">	
									<div class="custom-control custom-radio">
										<input type="radio" name="SetBusca" class="custom-control-input "  id="SetProduto" value="PD" checked >
										<label class="custom-control-label" for="Produto">Produtos</label>
									</div>
								</div>
								<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 mb-3 ">	
									<div class="custom-control custom-radio">
										<input type="radio" name="SetBusca" class="custom-control-input " id="SetPromocao" value="PM">
										<label class="custom-control-label" for="Promocao">Promoções</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpaBuscaProduto(), limpaBuscaPromocao()">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<input class="form-control input-produto" type="text" name="Produto" id="Produto" maxlength="255" placeholder="Busca Produto">
							<input class="form-control input-promocao" type="text" name="Promocao" id="Promocao" maxlength="255" placeholder="Busca Promoção">
						</div>
					</div>	
				</div>
				<div class="modal-body">
					<div class="input_fields_produtos"></div>
					<div class="input_fields_promocao"></div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
							<button type="button" class="btn btn-primary" data-dismiss="modal" name="botaoFecharBusca" id="botaoFecharBusca" onclick="limpaBuscaProduto(), limpaBuscaPromocao()">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>	
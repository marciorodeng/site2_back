<?php
	if($idSis_Empresa){
		$_SESSION['Site_Back']['Acesso']['idSis_Empresa'] = $idSis_Empresa;
	}
	
	if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){ 
		$result = 'SELECT 
					CashBackCliente,
					ValidadeCashBack
				FROM
					App_Cliente
				WHERE
					idSis_Empresa = ' . $idSis_Empresa . ' AND
					idApp_Cliente = "' . $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa] . '"
				LIMIT 1	
			';

		$resultado = mysqli_query($conn, $result);
		foreach($resultado as $resultado_view){
			$cashtotal 	= 	$resultado_view['CashBackCliente'];
			$validade 	=	$resultado_view['ValidadeCashBack'];
		}

		$validade_explode = explode('-', $validade);
		$validade_dia = $validade_explode[2];
		$validade_mes = $validade_explode[1];
		$validade_ano = $validade_explode[0];
		
		$validade_visao 	= $validade_dia . '/' . $validade_mes . '/' . $validade_ano;
		
		$data_hoje = date('Y-m-d', time());

		if(strtotime($validade) >= strtotime($data_hoje)){
			$cashtotal_visao 	= number_format($cashtotal,2,",",".");
		}else{
			$cashtotal_visao 	= '0,00';
		}
		$cashtotal_conta 	= str_replace(',', '.', str_replace('.', '', $cashtotal_visao));
		
	}

?>
<section id="navegador" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	
	<input type="hidden" id="id_empresa" value="<?php echo $idSis_Empresa;?>">
	<input type="hidden" id="sistema" value="<?php echo $sistema;?>">
	
	<nav class="navbar navbar-inverse navbar-fixed-top navbar-menu">
		<div class="row">	
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-4 navbar-header">
				<a class="navbar-brand navbar-logo" href="inicial.php">
					<img src="<?php echo $idSis_Empresa ?>/documentos/miniatura/<?php echo $row_documento['Logo_Nav']; ?>" alt="">
				</a>
			</div>
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
				<?php if($row_empresa['EComerce'] == 'S'){ ?>	
					<a class="navbar-lupa" href="" data-toggle="modal" data-target="#buscaModal">
						<img class="" type="button"  width='30'  src="../<?php echo $sistema ?>/arquivos/imagens/lupa.png">
					</a>
				<?php } ?>
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
						<a class="nav-link" style="color: #8a8a8a" href="index.php">Home</a>
					</li>
					<?php if($row_empresa['EComerce'] == 'S'){ ?>
						<li class="dropdown">
							<a class="nav-link dropdown-toggle" style="color: #8a8a8a" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Catálogo <span class="caret"></span>
							</a>
							<ul class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdown01">
								<li>
									<a class="dropdown-item" href="catalogo.php" >
										Catálogo Completo
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<?php
								$result_categoria_produtos = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprod = 'S' AND TipoCatprod = 'P'  ORDER BY Catprod ASC ";
								$read_categoria_produtos = mysqli_query($conn, $result_categoria_produtos);
								if(mysqli_num_rows($read_categoria_produtos) > '0'){?>							
									<li>
										<a class="dropdown-item" href="catalogo.php?cat=prd" >
											Catálogo de Produtos
										</a>
									</li>
									<li role="separator" class="divider"></li>
								<?php 
								} 
								?>
								<?php
								$result_categoria_servicos = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprod = 'S' AND TipoCatprod = 'S'  ORDER BY Catprod ASC ";
								$read_categoria_servicos = mysqli_query($conn, $result_categoria_servicos);
								if(mysqli_num_rows($read_categoria_servicos) > '0'){?>
									<li>
										<a class="dropdown-item" href="catalogo.php?cat=srv" >
											Catálogo de Serviços
										</a>
									</li>
									<li role="separator" class="divider"></li>
								<?php 
								} 
								?>
								<?php
								$result_categoria_promocao = "SELECT * FROM Tab_Catprom WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprom = 'S' ORDER BY Catprom ASC ";
								$read_categoria_promocao = mysqli_query($conn, $result_categoria_promocao);
								if(mysqli_num_rows($read_categoria_promocao) > '0'){?>	
									<li>
										<a class="dropdown-item" href="catalogo.php?cat=prm" >
											Catálogo de Promoções
										</a>
									</li>
									<li role="separator" class="divider"></li>
								<?php 
								} 
								?>
							</ul>									
						</li>
					<?php } ?>
					<li class="" >
						<a class="nav-link" style="color: #8a8a8a" href="contato.php">Fale Conosco</a>
					</li>
					<?php if((!isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa]) && !isset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa])) || !isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){ ?>
						<li class="dropdown">
							<a class="nav-link dropdown-toggle" style="color: #8a8a8a" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Login <span class="caret"></span>
							</a>
							<ul class="dropdown-menu" aria-labelledby="dropdown01">
								<?php if(!isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){ ?>	
									<li>
										<?php if(isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa])){ ?>
											<?php if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){ ?>
												<a class="dropdown-item" href="pesquisar_cliente.php">
													Cliente / <?php echo $_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa];?> / Deslogar
												</a>							
											<?php } else { ?>	
												<a class="dropdown-item" href="pesquisar_cliente.php">
													Pesquisar Cliente
												</a>
											<?php } ?>	
										<?php } else { ?>
											<?php if(isset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa])){ ?>
												<?php if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){ ?>
													<a class="dropdown-item" href="login_cliente.php"> 
														Cliente / <?php echo $_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa];?> / Deslogar
													</a>							
												<?php } else { ?>	
													<a class="dropdown-item" href="login_cliente.php">
														Login do Cliente
													</a>
												<?php } ?>							
											<?php } else { ?>	
												<?php if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){ ?>
													<a class="dropdown-item" href="login_cliente.php"> 
														Cliente / <?php echo $_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa];?> / Deslogar
													</a>							
												<?php } else { ?>	
													<a class="dropdown-item" href="login_cliente.php">
														Login do Cliente
													</a>
												<?php } ?>
											<?php } ?>
										<?php } ?>
									</li>
									<li role="separator" class="divider"></li>
								<?php } ?>
								<?php if(!isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa]) && !isset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa])){ ?>
									<li>
										<?php if(isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa])){ ?>
											<a class="dropdown-item" href="login_usuario.php"> 
												Vendedor / <?php echo $_SESSION['Site_Back']['Nome_Usuario_vend'.$idSis_Empresa];?> / Deslogar
											</a>
										<?php } else { ?>
											<?php if(isset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa])){ ?>
												<a class="dropdown-item" href="login_usuario.php">
													Vendedor / <?php echo $_SESSION['Site_Back']['Nome_Vendedor'.$idSis_Empresa];?> / Deslogar
												</a>							
											<?php } else { ?>								
												<a class="dropdown-item" href="login_usuario.php">
													Login do Vendedor
												</a>
											<?php } ?>	
										<?php } ?>
									</li>
									<li role="separator" class="divider"></li>
								<?php } ?>
								<li>
									<a class="dropdown-item" target="_blank" href="../<?php echo $sistema;?>/login/index5">
										Painel de Controle
									</a>
								</li>
								<li role="separator" class="divider"></li>
							</ul>
						</li>
					<?php } ?>
					<?php if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){ ?>
						<li class="dropdown">
							<a class="nav-link dropdown-toggle" style="color: #8a8a8a" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<div class="container-2">
									<img class="img-circle img-responsive" style="width:40px; height:40px; margin-top:-10px; margin-bottom:-3px" src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/clientes/miniatura/<?php echo $_SESSION['Site_Back']['Arquivo_Cliente'.$idSis_Empresa]; ?>" alt=""> 
									<span class="caret" style="margin-top:5px; margin-left:10px"></span>
								</div>
							</a>
							<ul class="dropdown-menu" aria-labelledby="dropdown01">
								<li>
									<a class="dropdown-item" href="login_cliente.php">
										<img class="img-circle " width='40' src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/clientes/miniatura/<?php echo $_SESSION['Site_Back']['Arquivo_Cliente'.$idSis_Empresa]; ?>" alt=""> 
										Cliente / <?php echo $_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa];?> / Deslogar
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a class="dropdown-item" href="meus_pedidos.php">
										Meus Pedidos
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a class="dropdown-item" href="meus_agendamentos.php">
										Meus Agendamentos
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a class="dropdown-item" target="_blank" href="../<?php echo $sistema;?>/login/index5">
										Painel de Controle
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<?php 
									if((isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa]) 
										&& isset($_SESSION['Site_Back']['Nivel_Usuario_vend'.$idSis_Empresa])
										&& $_SESSION['Site_Back']['Nivel_Usuario_vend'.$idSis_Empresa] == 2)
										OR (isset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa]) 
										&& isset($_SESSION['Site_Back']['Nivel_Vendedor'.$idSis_Empresa])
										&& $_SESSION['Site_Back']['Nivel_Vendedor'.$idSis_Empresa] == 2)){ 
								?>
								<?php }else{ ?>
									<li>
										<a class="dropdown-item" href="">
											CashBack <span style="color: #D9210B">R$ <?php echo $cashtotal_visao;?></span> / Validade <span style="color: #D9210B"><?php echo $validade_visao;?></span>
										</a>
									</li>
									<li role="separator" class="divider"></li>
								<?php } ?>
								<li>
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
								</li>
							</ul>
						</li>
					<?php } ?>
					<?php if(isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa])){ ?>
						<li class="dropdown">
							<a class="nav-link dropdown-toggle" style="color: #8a8a8a" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<div class="container-2">
									<img class="img-circle img-responsive" style="width:40px; height:40px; margin-top:-10px; margin-bottom:-3px" src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/usuarios/miniatura/<?php echo $_SESSION['Site_Back']['Arquivo_Usuario_vend'.$idSis_Empresa]; ?>" alt=""> 
									<span class="caret" style="margin-top:5px; margin-left:10px"></span>
								</div>
							</a>
							<ul class="dropdown-menu" aria-labelledby="dropdown01">
								<li>
									<a class="dropdown-item" href="login_usuario.php">
										<img class="img-circle " width='40' src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/usuarios/miniatura/<?php echo $_SESSION['Site_Back']['Arquivo_Usuario_vend'.$idSis_Empresa]; ?>" alt=""> 
										 Vendedor / <?php echo $_SESSION['Site_Back']['Nome_Usuario_vend'.$idSis_Empresa];?> /Deslogar
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a class="dropdown-item" target="_blank" href="../<?php echo $sistema;?>/login/index5">
										Painel de Controle
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
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
								</li>
							</ul>
						</li>
					<?php }elseif(isset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa])){ ?>
						<li class="dropdown">
							<a class="nav-link dropdown-toggle" style="color: #8a8a8a" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<div class="container-2">
									<img class="img-circle img-responsive" style="width:40px; height:40px; margin-top:-10px; margin-bottom:-3px" src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/usuarios/miniatura/<?php echo $_SESSION['Site_Back']['Arquivo_Vendedor'.$idSis_Empresa]; ?>" alt=""> 
									<span class="caret" style="margin-top:5px; margin-left:10px"></span>
								</div>
							</a>
							<ul class="dropdown-menu" aria-labelledby="dropdown01">
								<li>
									<a class="dropdown-item" href="login_usuario.php">
										<img class="img-circle " width='40' src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/usuarios/miniatura/<?php echo $_SESSION['Site_Back']['Arquivo_Vendedor'.$idSis_Empresa]; ?>" alt=""> 
										Vendedor / <?php echo $_SESSION['Site_Back']['Nome_Vendedor'.$idSis_Empresa];?> / Deslogar
									</a>
								</li>
							</ul>
						</li>
					<?php } ?>
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
							<input class="form-control input-produto" type="text" autofocus name="Produto" id="Produto" maxlength="255" placeholder="Busca Produto">
							<input class="form-control input-promocao" type="text" autofocus name="Promocao" id="Promocao" maxlength="255" placeholder="Busca Promoção">
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
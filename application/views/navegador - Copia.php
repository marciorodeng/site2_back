<?php
	if($idSis_Empresa){
		$_SESSION['Acesso']['idSis_Empresa'] = $idSis_Empresa;
	}
?>
<nav class="navbar navbar-inverse navbar-fixed-top header-menu">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>					
			<a class="navbar-brand" href="inicial.php"><img src="<?php echo $idSis_Empresa ?>/documentos/miniatura/<?php echo $row_documento['Logo_Nav']; ?>"></a>
			<span class="navbar-brand-nome "style="color: #FFFFFF" ><?php echo utf8_encode($row_empresa['NomeEmpresa']);?></span>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li class="nav-item">
					<a class="nav-link" href="contato.php">Fale Conosco</a>
				</li>
				<?php
					$result_categoria_produtos = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' AND Site_Catprod = 'S' AND TipoCatprod = 'P'  ORDER BY Catprod ASC ";
					$read_categoria_produtos = mysqli_query($conn, $result_categoria_produtos);
					if(mysqli_num_rows($read_categoria_produtos) > '0'){?>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Produtos <span class="caret"></span>
							</a>
							<ul class="dropdown-menu" aria-labelledby="dropdown03">
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
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Serviços <span class="caret"></span>
							</a>
							<ul class="dropdown-menu" aria-labelledby="dropdown03">
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
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Promoções <span class="caret"></span>
							</a>
							<ul class="dropdown-menu" aria-labelledby="dropdown03">
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
				<?php if(isset($_SESSION['Nome_Cliente'.$idSis_Empresa])){ ?>	
					<?php if($row_empresa['EComerce'] == 'S'){ ?>
						<li class="nav-item">
							<a class="nav-link" href="meu_carrinho.php">Meu Carrinho</a>
						</li>
					<?php } ?>
					<li class="nav-item">
						<a class="nav-link" href="meus_pedidos.php">Meus Pedidos</a>
					</li>
				<?php } ?>	
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Login <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" aria-labelledby="dropdown01">
						<li>
							<?php if(isset($_SESSION['Nome_Cliente'.$idSis_Empresa])){ ?>
								<a class="dropdown-item" href="sair.php">
									<img class="img-circle " width='40' src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/clientes/miniatura/<?php echo $_SESSION['Arquivo_Cliente'.$idSis_Empresa]; ?>" alt=""> 
									<?php echo utf8_encode($_SESSION['Nome_Cliente'.$idSis_Empresa]);?> 
									/ Deslogar
								</a>							
							<?php } else { ?>	
								<a class="dropdown-item" href="login_cliente.php">
									Login do Cliente:
								</a>
							<?php } ?>
						</li>
						<li role="separator" class="divider"></li>
						<li>
							<?php if(isset($_SESSION['Nome_Usuario'.$idSis_Empresa])){ ?>
								<a class="dropdown-item" href="login_associado.php"><img class="img-circle " width='40' src="../associados/5/usuarios/miniatura/<?php echo $_SESSION['Arquivo_Usuario'.$idSis_Empresa]; ?>" alt="">	<?php echo utf8_encode($_SESSION['Nome_Usuario'.$idSis_Empresa]); ?>/Desl.Assoc.</a>
							<?php } else { ?>							
								<a class="dropdown-item" href="login_associado.php">Link de Associado:</a>
							<?php } ?>	
						</li>
						<li role="separator" class="divider"></li>
						<li>
							<a class="dropdown-item" target="_blank" href="../<?php echo $sistema;?>/login/index5">Administracao:</a>
						</li>
					</ul>
				</li>
			</ul>
			
			
			<!--
			<ul class="nav navbar-nav navbar-right">
				<li class="nav-item">
					<a class="nav-link" href="contato.php">Fale Conosco</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="produtos.php">Produtos</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="produtos.php">Servicos</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="promocao.php">Promoções</a>
				</li>				
				<?php if(isset($_SESSION['Nome_Cliente'.$idSis_Empresa])){ ?>	
					<?php if($row_empresa['EComerce'] == 'S'){ ?>
						<li class="nav-item">
							<a class="nav-link" href="meu_carrinho.php">Meu Carrinho</a>
						</li>
					<?php } ?>
					<li class="nav-item">
						<a class="nav-link" href="meus_pedidos.php">Meus Pedidos</a>
					</li>
				<?php } ?>	
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Login <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" aria-labelledby="dropdown01">
						<li>
							<?php if(isset($_SESSION['Nome_Cliente'.$idSis_Empresa])){ ?>
								<a class="dropdown-item" href="sair.php">
									<img class="img-circle " width='40' src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/clientes/miniatura/<?php echo $_SESSION['Arquivo_Cliente'.$idSis_Empresa]; ?>" alt=""> 
									<?php echo utf8_encode($_SESSION['Nome_Cliente'.$idSis_Empresa]);?> 
									/ Deslogar
								</a>							
							<?php } else { ?>	
								<a class="dropdown-item" href="login_cliente.php">
									Login do Cliente:
								</a>
							<?php } ?>
						</li>
						<li role="separator" class="divider"></li>
						<li>
							<?php if(isset($_SESSION['Nome_Usuario'.$idSis_Empresa])){ ?>
								<a class="dropdown-item" href="login_associado.php"><img class="img-circle " width='40' src="../associados/5/usuarios/miniatura/<?php echo $_SESSION['Arquivo_Usuario'.$idSis_Empresa]; ?>" alt="">	<?php echo utf8_encode($_SESSION['Nome_Usuario'.$idSis_Empresa]); ?>/Desl.Assoc.</a>
							<?php } else { ?>							
								<a class="dropdown-item" href="login_associado.php">Link de Associado:</a>
							<?php } ?>	
						</li>
						<li role="separator" class="divider"></li>
						<li>
							<a class="dropdown-item" target="_blank" href="../<?php echo $sistema;?>/login/index5">Administracao:</a>
						</li>
					</ul>
				</li>
				<li><a href="login_cliente.php">Login</a></li>
			</ul>
			-->
		</div>		
	</div>
</nav>
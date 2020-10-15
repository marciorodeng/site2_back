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
			
			<?php if(isset($_SESSION['Nome_Cliente'.$idSis_Empresa])){ ?>
				<a class="navbar-brand-nome"style="color: #FFFFFF" href=""><?php echo utf8_encode($_SESSION['Nome_Cliente'.$idSis_Empresa]);?></a>
			<?php }else{ ?>
				<a class="navbar-brand-nome "style="color: #FFFFFF" href="login_cliente.php">!! Login do Cliente !!</a>
			<?php } ?>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li class="nav-item">
					<a class="nav-link" href="contato.php">Fale Conosco</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="produtos.php">Produtos</a>
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
						<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</a>
						<div class="dropdown-menu" aria-labelledby="dropdown01">
						
						<?php if(isset($_SESSION['Nome_Cliente'.$idSis_Empresa])){ ?>	
							<a class="dropdown-item" href="sair.php"> Cliente-Deslogar</a><br><br>							
						<?php } else { ?>	
							<a class="dropdown-item" href="login_cliente.php">Cliente</a><br><br>
						<?php } ?>
						
							<!--<a class="dropdown-item" href="login_cliente.php">Cliente</a><br><br>-->
							<!--
							<a class="dropdown-item" href="login_associado.php">Associado</a><br><br>
							-->
							<a class="dropdown-item" target="_blank" href="../<?php echo $sistema;?>/login/index5">Funcionários</a><br>
							
						</div>
					</li>
					<!--<li><a href="login_cliente.php">Login</a></li>-->					

			</ul>
		</div>		
	</div>
</nav>
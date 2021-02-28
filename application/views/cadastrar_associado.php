<section id="service" class="section-padding3">
	<div class="container">
		<div class="row">					
			<div class="col-md-12">
				<h2 class="ser-title">Cadastrar Associado</h2>
				<hr class="botm-line">
			</div>		
		</div>
	</div>
</section>
<?php if(isset($_SESSION['id_Associado'])){ ?>	
	<section id="contact" class="section-padding3">		
		<div class="container">
			<div class="form-signin" style="background: #aeb1ef;">
				<?php if(isset($_SESSION['Nome_Associado'])){ ?>
					Eu, <a class="navbar-brand-nome" href=""><?php echo utf8_encode($_SESSION['Nome_Associado']);?></a>
				<?php } ?>			
				<h3>Solicito o meu Link de Associado a Empresa:<br> " <?php echo utf8_encode($row_empresa['NomeEmpresa']); ?> ",<br> para ser um(a) divulgador(a) dos seus Produtos e/ou Serviços</h3>
				<?php
					if(isset($_SESSION['msg'])){
						echo $_SESSION['msg'];
						unset($_SESSION['msg']);
					}
				?>
				<form method="POST" action="">
					<input type="hidden" name="idSis_Empresa" value="<?php echo $idSis_Empresa; ?>" >
					<input type="hidden" name="idSis_Usuario" value="<?php echo $_SESSION['id_Associado']; ?>">
					<input type="submit" name="btnCadUsuario" class="btn btn-success" value="Solicitar Link de Divulgação"><br>
				</form>
			</div>
		</div>
	</section>	
<?php } ?>
				
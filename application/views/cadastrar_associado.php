<section id="cadastrar" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<br>
		<h2 class="ser-title">Cadastrar Associado</h2>
		<hr class="botm-line">
	</div>
	<?php if(isset($_SESSION['Site_Back']['id_Associado'])){ ?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-signin" style="background: #aeb1ef;">
				<?php if(isset($_SESSION['Site_Back']['Nome_Associado'])){ ?>
					Eu, <a class="navbar-brand-nome" href=""><?php echo $_SESSION['Site_Back']['Nome_Associado'];?></a>
				<?php } ?>			
				<h3>Solicito o meu Link de Associado à Empresa <br> "<span style="color: #000080"><?php echo $row_empresa['NomeEmpresa']; ?></span>",<br> para ser um(a) divulgador(a) dos seus Produtos e/ou Serviços</h3>
				<?php
					if(isset($_SESSION['Site_Back']['msg'])){
						echo $_SESSION['Site_Back']['msg'];
						unset($_SESSION['Site_Back']['msg']);
					}
				?>
				<form method="POST" action="">
					<input type="hidden" name="idSis_Empresa" value="<?php echo $idSis_Empresa; ?>" >
					<input type="hidden" name="idSis_Associado" value="<?php echo $_SESSION['Site_Back']['id_Associado']; ?>">
					<input type="submit" name="btnCadAssociado" class="btn btn-success" value="Solicitar Link de Divulgação"><br>
				</form>
			</div>
		</div>
	<?php } ?>
</section>	
				
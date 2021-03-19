<section id="contact" class="section-padding2">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="ser-title">Depósito / Transferência</h2>
				<hr class="botm-line">
			</div>
			<div class="col-md-4 col-sm-4">
				<h3>Informações da Conta</h3>
				<h4>
					<b>Banco : </b>  <?php echo utf8_encode($row_empresa['BancoEmpresa']);?><br>
					<b>Agência : </b><?php echo utf8_encode($row_empresa['AgenciaEmpresa']);?><br>
					<b>Conta : </b>  <?php echo utf8_encode($row_empresa['ContaEmpresa']);?>
				</h4>
				<h3>Informações da Chave</h3>
				<h4>
					<b>Pix : </b><?php echo utf8_encode($row_empresa['PixEmpresa']);?>
				</h4>
			</div>
		</div>
	</div>
</section>

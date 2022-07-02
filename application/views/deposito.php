<section id="contato" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<br>
				<h2 class="ser-title">Depósito/ Transf/ Pix</h2>
				<hr class="botm-line">
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
</section>

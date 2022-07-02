<section id="compra" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<br>
		<h2 class="ser-title">Pedido: <a href="pedido.php?id=<?php echo $row_link['idApp_OrcaTrata'];?>"><?php echo $row_link['idApp_OrcaTrata']; ?></a></h2>
		<hr class="botm-line">
	</div>	
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" align="center">
		<span><img src="https://www.enkontraki.com.br/<?php echo $sistema ?>/arquivos/imagens/sucesso.png" class="img-responsive" width='250'></span>					
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<?php if($type_pedido == 2){?>						
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">
					<label>Imprima o seu Boleto</label><br>
					<a href="<?php echo $row_link['link_boleto']; ?>" target="_blank"><img src="https://www.enkontraki.com.br/<?php echo $sistema ?>/arquivos/imagens/boleto.jpg" class="img-responsive img-link" width='250'></a>							
				</div>
			</div>
		<?php } ?>
		<?php if($type_pedido == 3){?>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">
					<label>Acesse sua Conta</label><br>
					<a href="<?php echo $row_link['link_db_online']; ?>" target="_blank"><img src="https://www.enkontraki.com.br/<?php echo $sistema ?>/arquivos/imagens/debitoonline.jpg" class="img-responsive img-link" width='250'></a>							
				</div>
			</div>							
		<?php } ?>
	</div>	
</section>		

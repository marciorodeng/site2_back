<section id="service" class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-md-12" >
				<h2 class="ser-title">
					Compra Realizada!
				</h2>
				<hr class="botm-line">
				<h2 class="ser-title">
					Pedido: <a href="pedido.php?id=<?php echo $row_link['idApp_OrcaTrata'];?>"><?php echo $row_link['idApp_OrcaTrata']; ?></a>
				</h2>
			</div>					
			<div class="col-md-2" >
				
			</div>	
			<div class="col-md-4" align="center">
				<span><img src="https://www.enkontraki.com.br/<?php echo $sistema ?>/arquivos/imagens/sucesso.png" class="img-responsive" width='250'></span>					
			</div>
			<div class="col-lg-6">
				<?php if($type_pedido == 2){?>						
					<div class="col-lg-6">	
						<div class="col-lg-12" align="center">
							<h4>Imprima o seu Boleto</h4>
						</div>
						<div class="col-md-12 " align="center">
							<a href="<?php echo $row_link['link_boleto']; ?>" target="_blank"><img src="https://www.enkontraki.com.br/<?php echo $sistema ?>/arquivos/imagens/boleto.jpg" class="img-responsive img-link" width='250'></a>							
						</div>
					</div>
				<?php } ?>
				<?php if($type_pedido == 3){?>
					<div class="col-lg-6">	
						<div class="col-lg-12" align="center">
							<h4>Acesse sua Conta</h4>
						</div>
						<div class="col-md-12 " align="center">
							<a href="<?php echo $row_link['link_db_online']; ?>" target="_blank"><img src="https://www.enkontraki.com.br/<?php echo $sistema ?>/arquivos/imagens/debitoonline.jpg" class="img-responsive img-link" width='250'></a>							
						</div>
					</div>							
				<?php } ?>
			</div>				
		</div>
	</div>
</section>		

<?php
	if(isset($_GET['emp']) && isset($_GET['usuario']) && $_GET['emp'] != 0 && $_GET['usuario'] != 0){
		$erro = false;
		$emp = addslashes($_GET['emp']);
		$usuario = addslashes($_GET['usuario']);
		$link = 'https://www.enkontraki.com.br/' . $row_empresa['Site'] . '/vendedor.php/?emp=' . $emp . '&usuario=' . $usuario;		
	}else{
		$erro = true;
		$link = 'Nenhum link gerado';
	}

?>
<section id="cadastro" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
	<?php if(!$erro) { ?>	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<br>
			<h2 class="ser-title">
				Link Gerado!
			</h2>
			<hr class="botm-line">
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">
			<h3>Envie o link para seus amigos e receba comissão das compras que eles fizerem através da sua indicação!</h3>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
				<textarea type="text" class="form-control" id="texto" value= "" readonly=""><?php echo $link; ?></textarea>
			</div>
			<button type="button" class="btn btn-sm btn-primary" id="botao">
				<span class="Copiar">Copiar Link</span>
				<span class="Copiado">Link Copiado</span>
			</button>
		</div>
	<?php }else{ ?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<br>
			<h2 class="ser-title">
				Nenhum Link Gerado!
			</h2>
			<hr class="botm-line">
		</div>
	<?php } ?>	
</section>
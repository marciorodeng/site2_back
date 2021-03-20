<?php
	$link = 'https://www.enkontraki.com.br/' . $row_empresa['Site'] . '/associado.php/?emp=' . $row_link['idSis_Empresa'] . '&usuario=' . $row_link['idSis_Usuario_5'];
?>
<section id="service" class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-md-12" >
				<h2 class="ser-title">
					Cadastro Realizado!
				</h2>
				<hr class="botm-line">
			</div>
			<!--
			<div class="col-md-2" ></div>	
			<div class="col-md-4" align="center">
				<span><img src="../<?php echo $sistema ?>/arquivos/imagens/sucesso4.png" class="img-responsive" width='250'></span>
			</div>
			-->
		</div>
		<div class="row">
			<div class="col-lg-12" align="center">
				<h3>Acesse o site da <span style="color: #000080"><?php echo utf8_encode($row_empresa['NomeEmpresa']);?></span>, com o seu link de Associado, para receber o CashBack das suas compras!</h3>
			</div>
			<div class="col-md-12" align="center">
				<div style="overflow: auto; height: auto; ">
					<a href="../<?php echo $row_empresa['Site'] ?>/associado.php/?emp=<?php echo $row_link['idSis_Empresa'] ?>&usuario=<?php echo $row_link['idSis_Usuario_5'] ?>">
						https://www.enkontraki.com.br/<?php echo $row_empresa['Site'];?>/associado.php/?emp=<?php echo $row_link['idSis_Empresa'];?>&usuario=<?php echo $row_link['idSis_Usuario_5'];?>
					</a>
				</div>
			</div>
			<div class="col-lg-12" align="center">
				<h3>Divulgue seu link de Associado para seus amigos e acumule CashBack das compras que eles fizerem através da sua indicação!</h3>
			</div>
			<div class="col-lg-12" align="center">
				
					<div class="col-md-12 text-center">
						<textarea type="text" class="form-control" id="texto" value= "" readonly=""><?php echo $link; ?></textarea>
					</div>
					<button type="button" class="btn btn-sm btn-primary" id="botao">Copiar Link</button>
				
			</div>
			<div class="col-lg-12" align="center">
				<h3>Após acumular R$ 20,00 de saldo em CashBack, na <span style="color: #000080"><?php echo utf8_encode($row_empresa['NomeEmpresa']);?></span>, você pode solicitar o resgate do valor para sua conta!</h3>
			</div>
		</div>
	</div>
</section>		
<script>
	document.getElementById("botao").addEventListener("click", function(){
		//alert('Copiando');
		document.getElementById("texto").select();
		document.execCommand('copy');
	});	
</script>
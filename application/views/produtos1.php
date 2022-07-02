<section id="service" class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="ser-title">Nossos Produtos!</h2>
				<hr class="botm-line">
			</div>				
			
			<div class="col-md-12">
				<?php

					$read_produto = mysqli_query($conn, "
					SELECT 
						TP.idTab_Produto,
						TP.Produtos,
						TP.idSis_Empresa,
						TP.Arquivo,
						TP.VendaSite,
						TP.ValorProdutoSite,
						TV.idTab_Valor,
						TV.ValorProduto
					FROM 
						Tab_Produto AS TP
							LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produto = TP.idTab_Produto
					WHERE 
						TP.idSis_Empresa = '".$idSis_Empresa."' AND 
						TP.Ativo = 'S' AND
						TP.VendaSite = 'S' 
					ORDER BY 
						TV.idTab_Valor ASC
					");
					if(mysqli_num_rows($read_produto) > '0'){
						foreach($read_produto as $read_produto_view){
						?>		
						<div class="col-lg-3 col-md-3 col-sm-6 mb-4">
							<div class="img-produtos ">
								<a href="produto.php?id=<?php echo $read_produto_view['idTab_Valor'];?>"><img class="team-img " src="https://www.enkontraki.com.br/<?php echo $sistema ?>/arquivos/imagens/empresas/<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produto_view['Arquivo']; ?>" alt="" ></a>					 
								<div class="card-body">
									<h4 class="card-title">
										<a href="produto.php?id=<?php echo $read_produto_view['idTab_Valor'];?>"><?php echo utf8_encode ($read_produto_view['Produtos']);?></a>
									</h4>
									<h5>R$ <?php echo number_format($read_produto_view['ValorProduto'],2,",",".");?></h5>
									<!--<p><?php echo utf8_encode ($read_produto_view['produto_breve_descricao']);?></p>-->
								</div>
								<!--
								<div class="card-body">
									<a href="meu_carrinho.php?id=<?php echo $read_produto_view['idTab_Valor'];?>" class="btn btn-success">Adicionar ao Carrinho</a>
								</div>										
								-->	
							</div>
						</div>
						<?php 
						}
					}
				?>
			</div>								
		</div>
	</div>
</section>

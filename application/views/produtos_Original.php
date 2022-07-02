<section id="service" class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="row">	
					<div class="col-md-4">
						<h2 class="ser-title">Nossos Produtos!</h2>
					</div>	
					<?php if($row_empresa['EComerce'] == 'S' && isset($_SESSION['id_Cliente'.$idSis_Empresa]) && isset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) && count($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) > '0'){ ?>
						<div class="col-md-8">	
							<?php if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ ?>
								<div class="row">	
									<div class="col-md-6">
										<label></label><br>
										<a href="entrega.php" class="btn btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Finalizar Pedido!</a>
									</div>
									<div class="col-md-6">
										<label></label><br>
										<a href="meu_carrinho.php" class="btn btn-primary btn-block" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)">Voltar ao Carrinho!</a>
									</div>
								</div>
								<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
									Aguarde um instante! Estamos processando sua solicitação!
								</div>							
							<?php } else { ?>
								<div class="col-md-6">
									<a href="login_cliente.php" class="btn btn-danger btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Logar / Finalizar Pedido</a>
									<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
									  Aguarde um instante! Estamos processando sua solicitação!
									</div>							
								</div>
							<?php } ?>
						</div>	
					<?php } ?>
				</div>
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
						TP.Ativo,
						TP.VendaSite,
						TP.ValorProdutoSite
					FROM 
						Tab_Produto AS TP
					WHERE 
						TP.idSis_Empresa = '".$idSis_Empresa."' AND
						TP.Ativo = 'S' AND
						TP.VendaSite = 'S'
					ORDER BY 
						TP.idTab_Produto ASC
					");
					if(mysqli_num_rows($read_produto) > '0'){
						foreach($read_produto as $read_produto_view){
						?>		
						<div class="col-lg-3 col-md-3 col-sm-6 mb-4">
							<div class="img-produtos ">
								<a href="produtosderivados.php?id_modelo=<?php echo $read_produto_view['idTab_Produto'];?>"><img class="team-img " src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produto_view['Arquivo']; ?>" alt="" ></a>					 
								<div class="card-body">
									<h5 class="card-title">
										<a href="produtosderivados.php?id_modelo=<?php echo $read_produto_view['idTab_Produto'];?>"><?php echo utf8_encode ($read_produto_view['Produtos']);?></a>
									</h5>
								</div>
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

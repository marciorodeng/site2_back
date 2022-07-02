<?php
	if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['id_Cliente'.$idSis_Empresa];
	}else{
		unset(	$_SESSION['id_Cliente'.$idSis_Empresa],
				$_SESSION['Nome_Cliente'.$idSis_Empresa]
				);	
	}	
?>
<section id="service" class="section-padding">
	<div class="container">
		<div class="row">	
			<div class="col-lg-3">
				<div class="row">	
					<div class="col-lg-12">
						<h2 class="ser-title ">Categorias</h2>
						<hr class="botm-line">
						<div class="list-group">
							<?php
								$result_categoria = "SELECT * FROM Tab_Catprod WHERE idSis_Empresa = '".$idSis_Empresa."' ORDER BY Catprod ASC ";
								$read_categoria = mysqli_query($conn, $result_categoria);
								if(mysqli_num_rows($read_categoria) > '0'){
									foreach($read_categoria as $read_categoria_view){
										echo '<a href="produtos.php?cat='.$read_categoria_view['idTab_Catprod'].'" class="list-group-item">'.$read_categoria_view['Catprod'].'</a>';
									}
								}
							?>
						</div>
					</div>
				</div>
				<div class="row">	
					<div class="col-lg-12">
						<h2 class="ser-title "><a href="promocao.php">Promoções</a></h2>
						<hr class="botm-line">
					</div>
				</div>	
			</div>
			<div class="col-lg-9">
				<div class="row">	
					<div class="col-md-4">
						<h2 class="ser-title">Produtos</h2>
						<hr class="botm-line">
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
				<div class="row">
					<?php
						if(isset($_GET['cat']) && $_GET['cat'] != ''){
							$id_cat = addslashes($_GET['cat']);
							$sql_categoria = "AND Prodaux3 = '".$id_cat."'";
						}else{
							$sql_categoria = '';
						}
						$result_produto = "SELECT * FROM Tab_Produto WHERE idTab_Produto != '' AND idSis_Empresa = '".$idSis_Empresa."' {$sql_categoria} ORDER BY Produtos ASC ";
						$read_produto = mysqli_query($conn, $result_produto);
						if(mysqli_num_rows($read_produto) > '0'){
							foreach($read_produto as $read_produto_view){
					?>
								<div class="col-lg-4 col-md-6 col-sm-6 mb-4">
									<div class="img-produtos ">
										<a href="produtosderivados.php?id_modelo=<?php echo $read_produto_view['idTab_Produto'];?>"><img class="team-img " src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produto_view['Arquivo']; ?>" alt="" ></a>					 
										<div class="card-body">
											<h5 class="card-title">
												<a href="produtosderivados.php?id_modelo=<?php echo $read_produto_view['idTab_Produto'];?>"><?php echo utf8_encode ($read_produto_view['Produtos']);?></a>
											</h5>
										</div>
									</div>
								</div>
								
								<!--
								<div class="col-lg-4 col-md-6 mb-4">
									<div class="card h-100">
										<a href="#"><img class="card-img-top" src="<?php echo $idSis_Empresa; ?>/produtos/miniatura/<?php echo $read_produto_view['Arquivo']; ?>" alt="" ></a>
										<div class="card-body">
											<h4 class="card-title">
												<a href="#"><?php echo $read_produto_view['Produtos'] ;?></a>
											</h4>
											<h5>$24.99</h5>
											<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
										</div>
										<div class="card-footer">
											<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
										</div>
									</div>
								</div>
								-->
					<?php
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
</section>

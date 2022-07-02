<?php 

	if(!isset($_SESSION['carrinho'])){
		$_SESSION['carrinho'] = array();
	}
	
	if(isset($_SESSION['id_Cliente'])){
		$cliente = $_SESSION['id_Cliente'];
	}

?>

<section id="service" class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="ser-title">Meus Pedidos!</h2>
				<hr class="botm-line">
			</div>
			<div class="col-lg-1"></div>
				<div class="col-lg-10">
				<div class="col-md-12 order-md-2 mb-4">

					<ul class="list-group mb-3 ">										
						<?php
							$read_pedido = mysqli_query($conn, "SELECT *
																	
																FROM 
																	App_OrcaTrata
																WHERE 
																	idSis_Empresa = '".$idSis_Empresa."' AND
																	idApp_Cliente = '".$cliente."'
																ORDER BY 
																	idApp_OrcaTrata DESC");
							if(mysqli_num_rows($read_pedido) > '0'){
								foreach($read_pedido as $read_pedido_view){
									
									$total = $read_pedido_view['ValorRestanteOrca'] + $read_pedido_view['ValorFrete'];
								
								
									if($read_pedido_view['status'] == '0'){
										if($read_pedido_view['CombinadoFrete'] == 'N'){
											$status_pedido = 'Combinando Entrega';
										}else{
											$status_pedido = 'Aguardando Pagamento';
										}
									}
									if ($read_pedido_view['status'] == '1' || $read_pedido_view['status'] == '2'){
										$status_pedido = 'Aguardando Confirmação do Pagamento';
									}
									if ($read_pedido_view['status'] == '3' || $read_pedido_view['status'] == '4'){
										$status_pedido = 'Aprovado';
									}
									if ($read_pedido_view['status'] == '7'){
										$status_pedido = 'Cancelado';
									}
									if ($read_pedido_view['status'] == '6' || $read_pedido_view['status'] == '8'){
										$status_pedido = 'Devolvido';
									}
									if ($read_pedido_view['status'] == '9'){
										$status_pedido = 'Retido';
									}

									?>		
									<li class="list-group-item d-flex justify-content-between lh-condensed fundo">
										
										<div class="row img-prod-pag">	
											<div class="row">	
												<div class="col-md-3 ">
													<h4 class="my-0"> <span class="text-muted">Pedido: </span><?php echo $read_pedido_view['idApp_OrcaTrata'];?></h4>
													<!--<span class="text-muted">Pedido <?php echo $read_pedido_view['idApp_OrcaTrata'];?> </span>--> 
												</div>
												<div class="col-md-3 ">
													<h4 class="my-0"><span class="text-muted">Produtos: </span> R$ <?php echo number_format($read_pedido_view['ValorRestanteOrca'], 2, ",", ".");?> </h4>
												</div>
												<div class="col-md-3 ">
													<h4 class="my-0"><span class="text-muted">Frete: </span> R$ <?php echo number_format($read_pedido_view['ValorFrete'], 2, ",", ".");?> </h4>
												</div>
												<div class="col-md-3 ">
													<h4 class="my-0"><span class="text-muted">Total: </span> R$ <?php echo number_format($total, 2, ",", ".");?> </h4>
												</div>
											</div>	
											<div class="row">	
												<div class="col-md-3 "></div>
												<div class="col-md-3 ">
													<h4 class="my-0"><span class="text-muted">Data: </span><?php echo date_format(new DateTime($read_pedido_view['pedido_data_hora']),'d/m/Y');?></h4>  
												</div>											
												<div class="col-md-3 ">
													<h4 class="my-0"><span class="text-muted">Status: </span><?php echo $status_pedido;?></h4>  
												</div>
												<div class="col-md-3 ">
													<h4 class="my-0">
													<?php if($read_pedido_view['status'] == '0'){ ?>
														
														<?php if($read_pedido_view['CombinadoFrete'] == 'N'){ ?>
															<a href="pedido.php?id=<?php echo $read_pedido_view['idApp_OrcaTrata'];?>">Ver</a>
														<?php } else {?>
															<a href="pagar.php?id=<?php echo $read_pedido_view['idApp_OrcaTrata'];?>">Ver & Pagar</a>
														<?php } ?>													

													<?php } else if($read_pedido_view['status'] == '1'){?>
														
														<?php if($read_pedido_view['FormaPagamento'] == '1'){ ?>
															<a href="pedido.php?id=<?php echo $read_pedido_view['idApp_OrcaTrata'];?>">Ver</a>
														<?php } else if($read_pedido_view['FormaPagamento'] == '2'){?>
															<a href="compra_realizada.php?code=<?php echo $read_pedido_view['cod_trans'];?>&type=<?php echo $read_pedido_view['FormaPagamento'];?>">Ver & Imprimir Boleto</a>
														<?php } else if($read_pedido_view['FormaPagamento'] == '3'){?>
															<a href="compra_realizada.php?code=<?php echo $read_pedido_view['cod_trans'];?>&type=<?php echo $read_pedido_view['FormaPagamento'];?>">Ver & Acessar Conta</a>
														<?php } ?>
													
													<?php } else {?>
														<a href="pedido.php?id=<?php echo $read_pedido_view['idApp_OrcaTrata'];?>">Ver</a>	
													<?php } ?>													
													</h4>
												</div>
											</div>
										</div>
											
									</li>
								<?php
								}
							}
						?>
		
					</ul>
					<div class="card-body text-right">
						<a href="produtos.php" class="btn btn-success">Novo Pedido</a>
					</div>						
				</div>
			</div>
		</div>
	</div>
	
</section>

						
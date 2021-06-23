<?php
	if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['id_Cliente'.$idSis_Empresa];
	}else{
		unset(	$_SESSION['id_Cliente'.$idSis_Empresa],
				$_SESSION['Nome_Cliente'.$idSis_Empresa]
				);	
	}
	$dataatual = date('Y-m-d', time());
	$dia_da_semana = date('N');
?>
<section id="service" class="section-padding">
	<div class="container-1">
		<div class="row">
			<div class="col-lg-12">
				<?php if($row_empresa['EComerce'] == 'S' && isset($_SESSION['id_Cliente'.$idSis_Empresa]) && isset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) && count($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) > '0'){ ?>
					<div class="row">	
						<div class="col-md-12">	
							<?php if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ ?>
								<div class="row">	
									<!--
										<div class="col-md-6">
										<label></label><br>
										<a href="entrega.php" class="btn btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Finalizar Pedido!</a>
										</div>
									-->
									<div class="col-md-12">
										<a href="entrega.php" class="btn btn-primary btn-block" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)">Se desejar Finalizar a compra, Click Aqui!!</a>
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
					</div>
				<?php } ?>
			</div>
			<div class="col-md-12">
				<div class="row">
					<div class="container-4">
						<?php
							if(isset($_GET['cat']) && $_GET['cat'] != ''){
								$id_cat = addslashes($_GET['cat']);
								$sql_categoria = "AND TPM.idTab_Catprom = '".$id_cat."'";
								$sql_categoria_id = "AND idTab_Catprom = '".$id_cat."'";
							}else{
								$sql_categoria = '';
								$sql_categoria_id = '';
							}
							
							$result_categoria_id = "
													SELECT * 
													FROM 
														Tab_Catprom 
													WHERE 
														idSis_Empresa = '".$idSis_Empresa."' AND
														Site_Catprom = 'S'
														{$sql_categoria_id} 
													ORDER BY 
														Catprom ASC ";
							$read_categoria_id = mysqli_query($conn, $result_categoria_id);
									
							if(mysqli_num_rows($read_categoria_id) > '0'){
								foreach($read_categoria_id as $read_categoria_view_id){
									$id_catprom = $read_categoria_view_id['idTab_Catprom'];
									$result_produto_id = "
											SELECT 
												TPM.*,
												TCT.*,
												TD.*
											FROM 
												Tab_Promocao as TPM
													LEFT JOIN Tab_Catprom AS TCT ON TCT.idTab_Catprom = TPM.idTab_Catprom
													LEFT JOIN Tab_Dia_Prom AS TD ON TD.idTab_Promocao = TPM.idTab_Promocao
											WHERE 
												TPM.DataInicioProm <= '".$dataatual."' AND 
												TPM.DataFimProm >= '".$dataatual."' AND 
												TD.id_Dia_Prom = '".$dia_da_semana."' AND
												TD.Aberto_Prom = 'S' AND
												TPM.VendaSite = 'S' AND
												TPM.idSis_Empresa = '".$idSis_Empresa."' AND
												TPM.idTab_Catprom = '".$id_catprom."' 
											ORDER BY 
												TPM.Promocao ASC ";
									
									echo'
									<div class="col-md-12">
										
											<br>
											<h2 class="ser-title">'.$read_categoria_view_id['Catprom'].'</h2>
											<hr class="botm-line">
										
									</div>';
									
									$read_produto_id = mysqli_query($conn, $result_produto_id);
									if(mysqli_num_rows($read_produto_id) > '0'){
										
										foreach($read_produto_id as $read_produto_view_id){
											
											$idTab_Promocao = $read_produto_view_id['idTab_Promocao'];
											$select_produtos = "SELECT 
																	SUM(TV.ComissaoCashBack * TV.ValorProduto /100) AS CashBack,
																	SUM(TV.QtdProdutoDesconto * TV.ValorProduto) AS SubTotal,
																	TV.idTab_Promocao
																FROM
																	Tab_Valor AS TV
																		LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = TV.idTab_Promocao				
																WHERE
																	TV.idTab_Promocao = '".$idTab_Promocao."'
																	";
											$subtotal 		= mysqli_query($conn, $select_produtos);
											if(mysqli_num_rows($subtotal) > '0'){
												$cashback = '0';
												$valortotal = '0';
												foreach($subtotal as $subtotal_view){
													$cashback += $subtotal_view['CashBack'];
													$valortotal += $subtotal_view['SubTotal'];
												}
											}
											?>
											
											<div class="col-lg-3 col-md-6 col-sm-6 mb-4 text-center">
												
													<div class="card-body">
														<a href="produtospromocao.php?promocao=<?php echo $read_produto_view_id['idTab_Promocao'];?>"><img class="team-img img-responsive" src="<?php echo $idSis_Empresa;?>/promocao/miniatura/<?php echo $read_produto_view_id['Arquivo'];?>" alt="" width='500' ></a>					 
													</div>
													<div class="card-body">
														<h5 class="card-title">
															<a href="produtospromocao.php?promocao=<?php echo $read_produto_view_id['idTab_Promocao'];?>"><?php echo utf8_encode($read_produto_view_id['Promocao']);?></a>
														</h5>
													</div>
													<div class="card-body">
														<h5 class="card-title">
															<?php echo utf8_encode($read_produto_view_id['Descricao']);?>
														</h5>
														<?php if($row_empresa['EComerce'] == 'S'){ ?>	
															<h5 class="card-title">
																R$ <?php echo number_format($valortotal,2,",",".");?>
															</h5>
															<?php if($row_empresa['CashBackAtivo'] == 'S'){ ?>
																<h6 class="card-title">
																	CashBack: R$ <?php echo number_format($cashback,2,",",".");?>
																</h6>
															<?php } ?>
														<?php } ?>	
													</div>
												
											</div>
											
											<?php
										}
									}
								}
							}		
						?>
					</div>	
				</div>
			</div>
		</div>
	</div>
</section>

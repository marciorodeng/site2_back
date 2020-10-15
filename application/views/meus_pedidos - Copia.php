<?php if(isset($_SESSION['Nome_Cliente'.$idSis_Empresa])){ ?>
	<?php 

		if(!isset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]])){
			$_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]] = array();
		}
		
		if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){
			$cliente = $_SESSION['id_Cliente'.$idSis_Empresa];
		}

	?>

	<section id="service" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="row">	
					<div class="col-md-12">	
						<div class="col-md-8">
							<h2 class="ser-title">Meus Pedidos!</h2>
							<hr class="botm-line">
						</div>
						<div class="col-md-4 card-body text-right">
							<a href="meus_pedidos.php" class="btn btn-warning">Atualizar Status dos Pedidos</a>
						</div>
					</div>	
				</div>	
				<div class="col-lg-1"></div>
					<div class="col-lg-10">
					<div class="col-md-12 order-md-2 mb-4">

						<ul class="list-group mb-3 ">										
							<?php
								//Receber o numero da pagina
								$pagina_atual = filter_input(INPUT_GET,'pagina',FILTER_SANITIZE_NUMBER_INT);
								$pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
								//Setar a quantidade de itens
								$qnt_result_pg = 3;
								//Calcular o início da visualização
								$inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;
								$read_pedido = mysqli_query($conn, "SELECT 
																		OT.idApp_OrcaTrata,
																		OT.AprovadoOrca,
																		OT.CanceladoOrca,
																		OT.FinalizadoOrca,
																		OT.ConcluidoOrca,
																		OT.QuitadoOrca,
																		OT.ProntoOrca,
																		OT.EnviadoOrca,
																		OT.ObsOrca,
																		OT.AVAP,
																		OT.Tipo_Orca,
																		OT.status,
																		OT.idSis_Empresa,
																		OT.idApp_Cliente,
																		OT.ValorRestanteOrca,
																		OT.ValorFrete,
																		OT.ValorBoleto,
																		OT.CombinadoFrete,
																		OT.FormaPagamento,
																		OT.pedido_data_hora,
																		OT.DataOrca,
																		OT.DataEntregaOrca,
																		OT.cod_trans,
																		OT.TipoFrete,
																		FP.FormaPag,
																		TF.TipoFrete AS Entrega
																	FROM 
																		App_OrcaTrata AS OT
																			LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = OT.FormaPagamento
																			LEFT JOIN Tab_TipoFrete AS TF ON TF.idTab_TipoFrete = OT.TipoFrete
																	WHERE 
																		OT.idSis_Empresa = '".$idSis_Empresa."' AND
																		OT.idApp_Cliente = '".$cliente."'
																	ORDER BY 
																		OT.idApp_OrcaTrata DESC
																	LIMIT $inicio, $qnt_result_pg
																	");
								//somar a quantidade de usuarios
								$result_pg = "SELECT COUNT(idApp_OrcaTrata) AS num_result FROM App_OrcaTrata WHERE idSis_Empresa = '".$idSis_Empresa."' AND idApp_Cliente = '".$cliente."'";
								$resultado_pg = mysqli_query($conn, $result_pg);
								$row_pg = mysqli_fetch_assoc($resultado_pg);
								//echo $row_pg['num_result'];
								$quantidade_pg = ceil($row_pg['num_result']/$qnt_result_pg);
								//Limitar os links antes e depois
								$max_links = 2;
								if($pagina > 1){
									echo "<a href='meus_pedidos.php?pagina=1'>Primeira</a> &nbsp;";
								}
								for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
									if($pag_ant >= 1){
										echo "<a href='meus_pedidos.php?pagina=$pag_ant'>$pag_ant</a> &nbsp;";
									}	
								}
								
								if($qnt_result_pg < $row_pg['num_result']){
									echo "$pagina &nbsp;"; 
								}
								for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
									if($pag_dep <= $quantidade_pg){
										echo "<a href='meus_pedidos.php?pagina=$pag_dep'>$pag_dep</a> &nbsp;";
									}	
								}
								if($pagina < $quantidade_pg){
									echo "<a href='meus_pedidos.php?pagina=$quantidade_pg'>Ultima</a> &nbsp;";
								}																
								if(mysqli_num_rows($read_pedido) > '0'){
									foreach($read_pedido as $read_pedido_view){
										
										$total = $read_pedido_view['ValorRestanteOrca'] + $read_pedido_view['ValorFrete'] + $read_pedido_view['ValorBoleto'] ;
										
										if($read_pedido_view['AVAP'] == 'V'){
											$pagar = 'Na Loja';
										}elseif($read_pedido_view['AVAP'] == 'P'){
											$pagar = 'Na Entrega';
										}elseif($read_pedido_view['AVAP'] == 'O'){
											$pagar = 'On Line';
										}
										if($read_pedido_view['CanceladoOrca'] == 'N'){
											if($read_pedido_view['AprovadoOrca'] == 'N'){
												if($read_pedido_view['AVAP'] == 'O'){
													$pedido = 'Aguardando Pagamento OnLine';
												}else{
													$pedido = 'Em Análise';
												}
											}else{
												if($read_pedido_view['QuitadoOrca'] == 'S'){
													$pedido = 'Aprovado';
													$status_pagamento = 'Pago';
												}else{
													$status_pagamento = 'Aguardando';
													
													if($read_pedido_view['AVAP'] == 'O'){
														if($read_pedido_view['status'] == '0'){
															$pedido = 'Aguardando Pagamento OnLine';
														}else{
															$pedido = 'Em Análise';
														}
													}else{
														$pedido = 'Aprovado';
													}
													
													if($read_pedido_view['AVAP'] == 'O'){
														if($read_pedido_view['status'] == '0'){
															if($read_pedido_view['CombinadoFrete'] == 'N'){
																$status_pedido = 'Combinando Entrega';
															}else{
																$status_pedido = 'Aguardando Pagamento';
															}
														}
														if ($read_pedido_view['status'] == '1' || $read_pedido_view['status'] == '2'){
															$status_pedido = 'Aprovado & Aguardando Confirmação do Pagamento';
														}
														if ($read_pedido_view['status'] == '3' || $read_pedido_view['status'] == '4'){
															$status_pedido = 'Aprovado & Pago';
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
													}elseif($read_pedido_view['AVAP'] == 'P'){
														$status_pedido = 'Aguardando';
														$status_pagamento = 'Aguardando';
													}
												}
											}	
										}else{
											$pedido = 'Cancelado';
										}
										
										if($read_pedido_view['TipoFrete'] == '1'){
											$entrega = 'Retirar';
											if($read_pedido_view['ProntoOrca'] == 'S'){
												$status_envio = 'Aguardando Retirada';
											}else{
												$status_envio = 'Aguardando Pagamento';
											}
										}elseif($read_pedido_view['TipoFrete'] == '2'){
											$entrega = 'MotoBoy';
										}elseif($read_pedido_view['TipoFrete'] == '3'){
											$entrega = 'Correios';
										}
										
										if($read_pedido_view['CanceladoOrca'] == 'N'){
											if($read_pedido_view['AprovadoOrca'] == 'S'){
												if($read_pedido_view['ProntoOrca'] == 'N' && $read_pedido_view['EnviadoOrca'] == 'N' && $read_pedido_view['ConcluidoOrca'] == 'N' ){
													$cor = 'fundoVermelho';
												}elseif($read_pedido_view['ProntoOrca'] == 'S' && $read_pedido_view['EnviadoOrca'] == 'N' && $read_pedido_view['ConcluidoOrca'] == 'N'){
													$cor = 'fundoVerde';
												}elseif($read_pedido_view['AVAP'] != 'O' && $read_pedido_view['QuitadoOrca'] != 'N'){
													$cor = 'fundoAmarelo';
												}elseif($read_pedido_view['ProntoOrca'] == 'S' && $read_pedido_view['EnviadoOrca'] == 'S' && $read_pedido_view['ConcluidoOrca'] == 'N'){
													$cor = 'fundoAmarelo';
												}elseif($read_pedido_view['ProntoOrca'] == 'S' && $read_pedido_view['EnviadoOrca'] == 'S' && $read_pedido_view['ConcluidoOrca'] == 'S' && $read_pedido_view['QuitadoOrca'] == 'N'){
													$cor = 'fundoAmarelo';
												}elseif($read_pedido_view['ProntoOrca'] == 'S' && $read_pedido_view['EnviadoOrca'] == 'S' && $read_pedido_view['ConcluidoOrca'] == 'N' && $read_pedido_view['QuitadoOrca'] == 'S'){
													$cor = 'fundoAmarelo';
												}
											} else {
												$cor = 'fundoAzulEscuro';
											}
											if($read_pedido_view['CombinadoFrete'] == 'N' && $read_pedido_view['Tipo_Orca'] == 'O' && $read_pedido_view['TipoFrete'] == '2'){
												$cor = 'fundoAzulEscuro';
											}
											if($read_pedido_view['CombinadoFrete'] == 'S' && $read_pedido_view['AVAP'] == 'O' && $read_pedido_view['QuitadoOrca'] == 'N'){
												$cor = 'fundoCinza';
											}
											if($read_pedido_view['ProntoOrca'] == 'S' && $read_pedido_view['EnviadoOrca'] == 'S' && $read_pedido_view['ConcluidoOrca'] == 'S' && $read_pedido_view['QuitadoOrca'] == 'S'){
												$cor = 'fundoAzulClaro';
											}
										} else {
											$cor = '';
										}

										?>		
										<li class="list-group-item d-flex justify-content-between lh-condensed <?php echo $cor;?>">
											
											<div class="row img-prod-pag">
												
													<div class="row">
														<div class="col-md-3 ">
															<h5 class="my-0"><span class="text-muted" style="color: #000000">Pedido:</span>
																<a style="color: #000000" href="pedido.php?id=<?php echo $read_pedido_view['idApp_OrcaTrata'];?>"><?php echo $read_pedido_view['idApp_OrcaTrata'];?></a>
															</h5>
														</div>	
														<div class="col-md-3 ">
															<h5 class="my-0"><span class="text-muted" style="color: #000000">Dt.Pdd: </span><?php echo date_format(new DateTime($read_pedido_view['DataOrca']),'d/m/Y');?></h5>  
														</div>
														<div class="col-md-3 ">
															<h5 class="my-0"><span class="text-muted" style="color: #000000">Dt.Ent: </span><?php echo date_format(new DateTime($read_pedido_view['DataEntregaOrca']),'d/m/Y');?></h5>  
														</div>
														<div class="col-md-3 ">
															<h5 class="my-0"><span class="text-muted" style="color: #000000">Pedido: </span><?php echo $pedido;?></h5>  
														</div>
													</div>
													<div class="row">
														<div class="col-md-3 ">
															<h5 class="my-0"><span class="text-muted" style="color: #000000">Total: </span> R$ <?php echo number_format($total, 2, ",", ".");?> </h5>
														</div>
														<div class="col-md-3 ">
															<h5 class="my-0"><span class="text-muted" style="color: #000000">Pagar: </span><?php echo $pagar;?></h5>  
														</div>
														<div class="col-md-3 ">
															<h5 class="my-0"> <span class="text-muted" style="color: #000000">Forma: </span><?php echo utf8_encode($read_pedido_view['FormaPag']);?></h5>
														</div>
														<div class="col-md-3 ">
															<h5 class="my-0"><span class="text-muted" style="color: #000000">Pagamento: </span>
																<?php if($read_pedido_view['CanceladoOrca'] == 'N'){ ?>	
																	<?php if($read_pedido_view['QuitadoOrca'] == 'S'){ ?>
																		<span>Pago</span>
																	<?php } else{?>	
																		<?php if($read_pedido_view['AVAP'] == 'O'){ ?>
																			<?php if($read_pedido_view['status'] == '0'){ ?>
																				<?php if($read_pedido_view['CombinadoFrete'] == 'S'){ ?>
																					<a href="pagar.php?id=<?php echo $read_pedido_view['idApp_OrcaTrata'];?>">Pagar OnLine</a>
																					<?php } else{ ?>
																					<span>Aguardando</span>
																				<?php } ?>
																			<?php } else if($read_pedido_view['status'] == '1'){?>
																				<?php if($read_pedido_view['FormaPagamento'] == '1'){ ?>
																					<span>Aguardando</span>
																				<?php } else if($read_pedido_view['FormaPagamento'] == '2'){?>
																					<a href="compra_realizada.php?code=<?php echo $read_pedido_view['cod_trans'];?>&type=<?php echo $read_pedido_view['FormaPagamento'];?>">Imprimir Boleto</a>
																				<?php } else if($read_pedido_view['FormaPagamento'] == '3'){?>
																					<a href="compra_realizada.php?code=<?php echo $read_pedido_view['cod_trans'];?>&type=<?php echo $read_pedido_view['FormaPagamento'];?>">Acessar Conta OnLine</a>
																				<?php } ?>
																			<?php } else {?>
																				<span>Aguardando</span>	
																			<?php } ?>
																		<?php } else {?>
																			<span>Aguardando</span>	
																		<?php } ?>
																	<?php } ?>
																<?php } else {?>
																	<span>Cancelado</span>	
																<?php } ?>	
															</h5>
														</div>
													</div>
													<div class="row">	
														<div class="col-md-3 ">
															<h5 class="my-0"><span class="text-muted" style="color: #000000">Entrega:</span>
																<?php if($read_pedido_view['TipoFrete'] == '1'){ ?>
																	<span>Retirar na Loja</span>
																<?php } elseif($read_pedido_view['TipoFrete'] == '2') {?>
																	<span>MotoBoy</span>
																<?php } else {?>
																	<span>Correios</span>
																<?php } ?>
															</h5>
														</div>
														<?php if($read_pedido_view['CanceladoOrca'] == 'N'){ ?>
															<div class="col-md-3 ">
																<h5 class="my-0"><span class="text-muted" style="color: #000000">Produtos:</span>
																	<?php if($read_pedido_view['AprovadoOrca'] == 'S'){ ?>	
																		<?php if($read_pedido_view['ProntoOrca'] == 'S'){ ?>
																			<span>Prontos para Entrega</span>
																		<?php } else {?>
																			<span>Sendo Separados</span>
																		<?php } ?>
																	<?php } else {?>
																		<span>Aguardando</span>
																	<?php } ?>	
																</h5>
															</div>
															<div class="col-md-3 ">
																<h5 class="my-0"><span class="text-muted" style="color: #000000">Expedição:</span>
																	<?php if($read_pedido_view['TipoFrete'] == '1'){ ?>
																		<?php if($read_pedido_view['ConcluidoOrca'] == 'N'){ ?>
																			<span>Aguardando Retirada</span>
																		<?php } else {?>
																			<span>Entregue</span>
																		<?php } ?>
																	<?php } else {?>
																		<?php if($read_pedido_view['EnviadoOrca'] == 'S'){ ?>
																			<span>Enviado</span>
																		<?php } else {?>
																			<span>Aguardando</span>
																		<?php } ?>
																	<?php } ?>
																</h5>
															</div>
															<div class="col-md-3 ">
																<h5 class="my-0"><span class="text-muted" style="color: #000000">Entrega:</span>
																	<?php if($read_pedido_view['CanceladoOrca'] == 'N'){ ?>	
																		<?php if($read_pedido_view['ConcluidoOrca'] == 'S'){ ?>
																			<span>Entregue</span>
																		<?php } else {?>
																			<span>Aguardando</span>
																		<?php } ?>
																	<?php } else {?>
																		<span>Cancelado</span>
																	<?php } ?>	
																</h5>
															</div>
														<?php } else {?>
															
															<div class="col-md-9 ">
																<h5 class="my-0"><span class="text-muted" style="color: #000000">Motivo:</span>
																	<span><?php echo utf8_encode($read_pedido_view['ObsOrca']);?></span>
																</h5>
															</div>
														<?php } ?>
													</div>
												
											</div>
										</li>
										<?php
									}
								}
								//somar a quantidade de usuarios
								$result_pg = "SELECT COUNT(idApp_OrcaTrata) AS num_result FROM App_OrcaTrata WHERE idSis_Empresa = '".$idSis_Empresa."' AND idApp_Cliente = '".$cliente."'";
								$resultado_pg = mysqli_query($conn, $result_pg);
								$row_pg = mysqli_fetch_assoc($resultado_pg);
								//echo $row_pg['num_result'];
								$quantidade_pg = ceil($row_pg['num_result']/$qnt_result_pg);
								//Limitar os links antes e depois
								$max_links = 2;
								if($pagina > 1){
									echo "<a href='meus_pedidos.php?pagina=1'>Primeira</a> &nbsp;";
								}
								for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
									if($pag_ant >= 1){
										echo "<a href='meus_pedidos.php?pagina=$pag_ant'>$pag_ant</a> &nbsp;";
									}	
								}
								if($qnt_result_pg < $row_pg['num_result']){
									echo "$pagina &nbsp;"; 
								}	
								for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
									if($pag_dep <= $quantidade_pg){
										echo "<a href='meus_pedidos.php?pagina=$pag_dep'>$pag_dep</a> &nbsp;";
									}	
								}
								if($pagina < $quantidade_pg){
									echo "<a href='meus_pedidos.php?pagina=$quantidade_pg'>Ultima</a> &nbsp;";
								}
							?>
			
						</ul>
						<?php if($loja_aberta){ ?>	
							<?php if($row_empresa['EComerce'] == 'S'){ ?>
								<div class="card-body text-right">
									<a href="produtos.php" class="btn btn-success">Novo Pedido</a>
								</div>
							<?php } ?>
						<?php } else { ?>
							<button class="btn btn-warning btn-block "  >Loja Fechada</button>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		
	</section>

<?php } ?>
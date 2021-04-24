<?php if(isset($_SESSION['Nome_Cliente'.$idSis_Empresa])){ ?>	
	<?php 
		if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ 
			$result = 'SELECT 
						PD.idApp_Produto,
						PD.idSis_Empresa,
						PD.idApp_Cliente,
						PD.ValorComissaoCashBack,
						PD.StatusComissaoCashBack,
						PD.DataPagoCashBack,
						PD.id_Orca_CashBack
					FROM
						App_Produto AS PD
							LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PD.idApp_OrcaTrata
					WHERE
						PD.idSis_Empresa = ' . $idSis_Empresa . ' AND
						PD.StatusComissaoCashBack = "N" AND
						PD.id_Orca_CashBack = 0 AND
						PD.ValorComissaoCashBack > 0.00 AND
						OT.QuitadoOrca = "S" AND
						OT.CanceladoOrca = "N" AND
						PD.idApp_Cliente = "' . $_SESSION['id_Cliente'.$idSis_Empresa] . '" 
				';

			$resultado = mysqli_query($conn, $result);
			$cashtotal = 0;
			while ($row = mysqli_fetch_assoc($resultado) ) {
				$cashtotal += $row['ValorComissaoCashBack'];
			}
			$cashtotal_visao = number_format($cashtotal,2,",",".");
			$cashtotal_conta = str_replace(',', '.', str_replace('.', '', $cashtotal_visao));
			
			/*
			echo "<br>";
			echo "<pre>";
			echo $idSis_Empresa;
			echo "<br>";
			echo $_SESSION['id_Cliente'.$idSis_Empresa];
			echo "<br>";
			echo $cashtotal;
			echo "<br>";
			echo $cashtotal_visao;
			echo "<br>";
			echo $cashtotal_conta;
			echo "</pre>";
			*/			
		} 
	?>
	<section id="service" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2 class="ser-title">Meu Carrinho!</h2>
					<hr class="botm-line">
				</div>
				
				<?php 
				#print_r($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]);
				if(isset($id_Session) && isset($_SESSION['cart'][$id_Session])){	
					foreach ($_SESSION['cart'][$id_Session] as $value) :
					  // echo "INSERT INTO teste (nome, dinheiro) VALUES (" . $value["name"] . ", " . $value["money"] . ")";
						
						$qtd_produto 	= $value['qtd']; // Passo a quantidade que vem junto com o produto
						/*
						echo "<pre>";
							echo $qtd_produto;
							echo "<br>";
							echo $value['valor'];
						echo "</pre>";
						*/
					endforeach;
					/*
					echo "<pre>";
						print_r($_SESSION['cart']);
					echo "</pre>";
					*/
				}
				?>
				
				<div class="col-lg-12">
					<div class="col-md-12 order-md-2 mb-4 img-prod-pag fundo-carrinho">
						<form name="Form" id="Form" action="?acao=up-produtos" method="post">
							<ul class="list-group mb-3 ">										
								<?php
									$total_venda = '0';
									$total_peso = '0';
									$item_carrinho = '0';
									$total_produtos = '0';
									$prazo_carrinho = '0';
									if(isset($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) && count($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) > '0'){
										foreach($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]] as $id_produto_carrinho => $quantidade_produto_carrinho){
											$item_carrinho++;
											$read_produto_carrinho = mysqli_query($conn, "
											SELECT 
												TPS.idTab_Produtos,
												TPS.Nome_Prod,
												TPS.Arquivo,
												TPS.ValorProdutoSite,
												TPS.PesoProduto,
												TPS.ObsProduto,
												TPS.Estoque,
												TPS.Produtos_Descricao,
												TV.idTab_Promocao,
												TV.idTab_Valor,
												TV.Desconto AS idTipo,
												TV.QtdProdutoDesconto,
												TV.QtdProdutoIncremento,
												TV.ValorProduto,
												TV.Convdesc,
												TV.TempoDeEntrega,
												TPR.Promocao,
												TPR.Descricao,
												TDSC.Desconto,
												TOP2.Opcao AS Opcao2,
												TOP1.Opcao AS Opcao1
											FROM 
												Tab_Produtos AS TPS
													LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produtos = TPS.idTab_Produtos
													LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TPS.idTab_Produto
													LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
													LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2
													LEFT JOIN Tab_Desconto AS TDSC ON TDSC.idTab_Desconto = TV.Desconto
													LEFT JOIN Tab_Promocao AS TPR ON TPR.idTab_Promocao = TV.idTab_Promocao
											WHERE 
												TV.idTab_Valor = '".$id_produto_carrinho."' 
											ORDER BY 
												TV.idTab_Valor ASC						
											");
											
											if(mysqli_num_rows($read_produto_carrinho) > '0'){
												
												foreach($read_produto_carrinho as $read_produto_carrinho_view){
													$quantidade_produto_desconto = $read_produto_carrinho_view['QtdProdutoDesconto'];
													$quantidade_produto_embalagem = $read_produto_carrinho_view['QtdProdutoIncremento'];
													$quantidade_estoque = $read_produto_carrinho_view['Estoque'];
													$prazo_prod = $read_produto_carrinho_view['TempoDeEntrega'];
													$sub_total_produtos = $quantidade_produto_carrinho * $quantidade_produto_embalagem;
													$total_produtos += $sub_total_produtos;
													$idTipo = $read_produto_carrinho_view['idTipo'];
													$idTab_Produto = $read_produto_carrinho_view['idTab_Produtos'];
													$sub_total_peso = $quantidade_produto_carrinho * $read_produto_carrinho_view['PesoProduto'];
													$total_peso += $sub_total_peso;
													$sub_total_produto_carrinho = $quantidade_produto_carrinho * $read_produto_carrinho_view['ValorProduto'];
													$total_venda += $sub_total_produto_carrinho;
													$total = number_format($total_venda, 2, ",", ".");
												
													if($prazo_prod >= $prazo_carrinho){
														$prazo_carrinho = $prazo_prod;
													}else{
														$prazo_carrinho = $prazo_carrinho;
													}
													
												}
												
											} 
											
											?>		
											<li class="list-group-item d-flex justify-content-between lh-condensed fundo">

												<div class="row img-prod-pag">	
													<div class="col-md-12">	
														<div class="col-md-2">		
															<div class="row ">	
																<div class="col-md-12">
																	<h4 class="my-0"><span class="text-muted">Item: </span><?php echo $item_carrinho;?> </h4> 
																</div>															
															</div>
															<div class="row ">	
																<div class="col-md-12 ">
																	<h4 class="my-0">Tipo <?php echo utf8_encode ($read_produto_carrinho_view['Desconto']);?></h4>
																	<!--<h4 class="my-0"><?php echo utf8_encode ($read_produto_carrinho_view['Convdesc']);?></h4>-->
																	<h5 class="my-0"><?php echo utf8_encode ($read_produto_carrinho_view['Promocao']);?></h5>
																	<!--<h5 class="my-0"><?php echo utf8_encode ($read_produto_carrinho_view['Descricao']);?></h5>-->
																</div>
															</div>	
															<div class="row ">	
																<div class="col-md-12">
																	<?php if($idTipo == '1'){?>
																		<h5 class="my-0"><a href="deletar_produto_carrinho.php?tipo=<?php echo $read_produto_carrinho_view['idTipo']; ?>&promocao=<?php echo $read_produto_carrinho_view['idTab_Promocao']; ?>&id=<?php echo $id_produto_carrinho; ?>&somar=0">Excluir Produto</a></h5>
																	<?php }else if($idTipo > '1'){?>
																		<h5 class="my-0"><a href="deletar_produto_carrinho.php?tipo=<?php echo $read_produto_carrinho_view['idTipo']; ?>&promocao=<?php echo $read_produto_carrinho_view['idTab_Promocao']; ?>&id=<?php echo $id_produto_carrinho; ?>&somar=0">Excluir Promoção</a></h5>
																	<?php } ?>
																</div>
															</div>
														</div>
														
														<div class="col-md-2">
															<div class="row ">	
																<div class="col-md-12 ">
																	<h5 class="card-title">
																		<?php echo utf8_encode ($read_produto_carrinho_view['Nome_Prod']);?><br>
																		<?php echo utf8_encode ($read_produto_carrinho_view['Convdesc']);?>
																	</h5>
																	<h5 class="card-title">
																		<?php echo utf8_encode ($read_produto_carrinho_view['Produtos_Descricao']);?>
																	</h5>
																	<h5 class="card-title">
																		<?php 
																			if($read_produto_carrinho_view['TempoDeEntrega'] <= 0){
																				echo 'Pronta Entrega!';
																			}else{
																				echo 'Pazo de Entrega: ' . $read_produto_carrinho_view['TempoDeEntrega'] . ' Dias';
																			} 
																		?>
																	</h5>
																	<!--<h5 class="my-0"><?php echo utf8_encode ($read_produto_carrinho_view['Nome_Prod']);?></h5><br>
																		<h6 class="my-0"><?php echo utf8_encode ($read_produto_carrinho_view['Convdesc']);?></h6><br>
																		<h6 class="my-0"><?php echo utf8_encode ($read_produto_carrinho_view['Produtos_Descricao']);?></h6>
																		<h5 class="my-0"><?php echo $read_produto_carrinho_view['QtdProdutoIncremento'];?> Unid.</h5>-->
																</div>
															</div>															
														</div>
														
														<div class="col-md-2">	
															<div class="row ">	
																<div class="col-md-12">
																	<img class="team-img img-circle img-responsive" src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produto_carrinho_view['Arquivo']; ?>" alt="" width='150' >
																</div>
															</div>															
														</div>	
														<!--
														<div class="col-md-2">
															<div class="row ">	
																<div class="col-md-12 ">
																	<h5 class="card-title">
																		<?php echo utf8_encode ($read_produto_carrinho_view['Produtos_Descricao']);?>
																	</h5>
																	<h5 class="card-title">
																		<?php 
																			if($read_produto_carrinho_view['TempoDeEntrega'] <= 0){
																				echo 'Pronta Entrega!';
																			}else{
																				echo 'Pazo de Entrega: ' . $read_produto_carrinho_view['TempoDeEntrega'] . ' Dias';
																			} 
																		?>
																	</h5>
																	<h5 class="my-0"><?php echo utf8_encode ($read_produto_carrinho_view['Nome_Prod']);?></h5><br>
																		<h6 class="my-0"><?php echo utf8_encode ($read_produto_carrinho_view['Convdesc']);?></h6><br>
																		<h6 class="my-0"><?php echo utf8_encode ($read_produto_carrinho_view['Produtos_Descricao']);?></h6>
																		<h5 class="my-0"><?php echo $read_produto_carrinho_view['QtdProdutoIncremento'];?> Unid.</h5>
																</div>
															</div>															
														</div>
														-->
														<div class="col-md-2">		
															<div class="row ">
																<div class="col-md-6 text-left">
																	<h4 class="my-0"><span class="text-muted">QtdPrd</span><br><span id="QtdPrd<?php echo $item_carrinho;?>" value=""><?php echo $read_produto_carrinho_view['QtdProdutoIncremento'];?> Un.</span><span class="text-muted"></span></h4> 
																</div>
																<div class="col-md-6 text-left">
																	<h4 class="my-0"><span class="text-muted">Valor </span><br>R$<span id="Valor<?php echo $item_carrinho;?>" value=""><?php echo number_format($read_produto_carrinho_view['ValorProduto'],2,",",".");?></span><span class="text-muted"></span></h4> 
																</div>														
															</div>
														</div>
														<div class="col-md-2">		
															<div class="row ">
																<div class="col-md-2 text-center">	
																	<?php if($idTipo == '1'){?>
																		<h4 class="my-0"><a href="deletar_produto_carrinho.php?tipo=<?php echo $read_produto_carrinho_view['idTipo']; ?>&promocao=<?php echo $read_produto_carrinho_view['idTab_Promocao']; ?>&id=<?php echo $id_produto_carrinho; ?>&somar=1&qtd=<?php echo $quantidade_produto_carrinho; ?>"><h2>-</h2></a></h4>
																	<?php }else if($idTipo > '1'){?>
																		<h4 class="my-0"><a href="deletar_produto_carrinho.php?tipo=<?php echo $read_produto_carrinho_view['idTipo']; ?>&promocao=<?php echo $read_produto_carrinho_view['idTab_Promocao']; ?>&id=<?php echo $id_produto_carrinho; ?>&somar=1&qtd=<?php echo $quantidade_produto_carrinho; ?>"><h2>-</h2></a></h4>
																	<?php } ?>
																</div>	
																<div class="col-md-6 text-center">
																	<h4 class="my-0"><span class="text-muted"></span><input class="text-muted" type="hidden" onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $item_carrinho ?>','<?php echo $id_produto_carrinho ?>')" id="Qtd<?php echo $item_carrinho;?>" size="5" name="prod[<?php echo $id_produto_carrinho ?>]" value="<?php echo $quantidade_produto_carrinho ?>"/><span class="text-muted"><?php echo $quantidade_produto_carrinho ?> x</span></h4>
																</div>
																<div class="col-md-2 text-center">	
																	<?php if($idTipo == '1'){?>
																		<h4 class="my-0"><a href="deletar_produto_carrinho.php?tipo=<?php echo $read_produto_carrinho_view['idTipo']; ?>&promocao=<?php echo $read_produto_carrinho_view['idTab_Promocao']; ?>&id=<?php echo $id_produto_carrinho; ?>&somar=2&qtd=<?php echo $quantidade_produto_carrinho; ?>"><h2>+</h2></a></h4>
																	<?php }else if($idTipo > '1'){?>
																		<h4 class="my-0"><a href="deletar_produto_carrinho.php?tipo=<?php echo $read_produto_carrinho_view['idTipo']; ?>&promocao=<?php echo $read_produto_carrinho_view['idTab_Promocao']; ?>&id=<?php echo $id_produto_carrinho; ?>&somar=2&qtd=<?php echo $quantidade_produto_carrinho; ?>"><h2>+</h2></a></h4>
																	<?php } ?>
																</div>
															</div>
														</div>
														<div class="col-md-2">		
															<div class="row ">
																<!--
																<div class="col-md-3 ">
																	<h5 class="my-0">Estoque<br><span id="Estoque<?php echo $item_carrinho;?>" value=""><?php echo $quantidade_estoque;?></span></h5> 
																</div>
																-->
																<!--
																<div class="col-md-3 ">
																	<?php if($idTipo == '1'){?>
																		<h4 class="my-0"><span class="text-muted">Qtd<br> </span><input class="text-muted" type="text" onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $item_carrinho ?>','<?php echo $id_produto_carrinho ?>')" id="Qtd<?php echo $item_carrinho;?>" size="5" name="prod[<?php echo $id_produto_carrinho ?>]" value="<?php echo $quantidade_produto_carrinho ?>"/><span class="text-muted"> X </span></h4> 
																	<?php }else if($idTipo == '2'){?>
																		<h4 class="my-0"><span class="text-muted">Qtd<br> </span><input class="text-muted" type="hidden" onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $item_carrinho ?>','<?php echo $id_produto_carrinho ?>')" id="Qtd<?php echo $item_carrinho;?>" size="5" name="prod[<?php echo $id_produto_carrinho ?>]" value="<?php echo $quantidade_produto_carrinho ?>"/><span class="text-muted"><?php echo $quantidade_produto_carrinho ?> X </span></h4>
																	<?php } ?>
																</div>
																-->
																<div class="col-md-6 ">
																	<h4 class="my-0"><span class="text-muted">SubQtd </span><br><span id="SubQtd<?php echo $item_carrinho;?>" ><?php echo $sub_total_produtos;?> Un.</span></h4> 
																</div>
																<div class="col-md-6 ">
																	<h4 class="my-0"><span class="text-muted">SubTotal </span><br>R$<span id="Subtotal<?php echo $item_carrinho;?>" ><?php echo number_format($sub_total_produto_carrinho,2,",",".");?></span></h4> 
																</div>
																
															</div>	
															<div class="row ">
																<h5 class="my-0"><span id="msg<?php echo $item_carrinho;?>" value=""></span></h5>
																<?php if($quantidade_produto_carrinho > $quantidade_estoque){?>
																	<div class="col-md-12 ">
																		<h4 class="my-0" style="color: #FF0000"><span class="text-muted" style="color: #FF0000"> Atenção!!</span> Quantidade maior que o Estoque!!!!</h4>
																	</div>
																<?php } ?>
															</div>
														</div>
													</div>	
												</div>
											</li>
											<?php
										}
									}
									
									$_SESSION['item_carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]] = $item_carrinho;
									$_SESSION['total_produtos'.$_SESSION['id_Cliente'.$idSis_Empresa]] = $total_produtos;
									/*
									echo "<pre>";
									echo $item_carrinho;
									echo "<br>";
									echo $_SESSION['item_carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]];
									echo "</pre>";
									
									
									echo '<br>';
									echo "<pre>";
									print_r('Prazo do Carrinho: ' . $prazo_carrinho . ' Dia(s)');
									echo "</pre>";
									
									exit ();
									*/
								?>
								
								<li class="list-group-item d-flex justify-content-between fundo">
									<span>Total de Itens </span>
									<strong>: <span  name="PCount" id="PCount" value="<?php echo $item_carrinho; ?>"><?php echo $item_carrinho; ?></span></strong>
								</li>
								<?php if($item_carrinho > 0) { ?>
									<li class="list-group-item d-flex justify-content-between fundo">
										<span>Total de Produtos </span>
										<strong>: <span  name="PRCount" id="PRCount" value="<?php echo $total_produtos; ?>"><?php echo $total_produtos; ?> Unid.</span></strong>
									</li>
									<li class="list-group-item d-flex justify-content-between fundo">
										<span>Valor do Pedido </span>
										<strong>: R$ <span  name="ValorTotal" id="ValorTotal"><?php echo $total;?></span></strong>
									</li>
									<li class="list-group-item d-flex justify-content-between fundo">
										<span>Valor em CashBack </span>
										<strong>: R$ <span  name="ValorCashBack" id="ValorCashBack"><?php echo $cashtotal_visao;?></span></strong>
									</li>
									<li class="list-group-item d-flex justify-content-between fundo">
										<span>Prazo de Entrega na Loja </span>
										<strong>: 
											<span  name="PrazoPrdServ" id="PrazoPrdServ">
												<?php 
													if($prazo_carrinho == 0){
														echo 'Pronta Entrega!';
													}else{
														echo $prazo_carrinho . '  Dia(s)';
													}
												?>
											</span>
										</strong>
									</li>
								<?php } ?>
							</ul>
							<?php if($loja_aberta){ ?>	
								<div class="row">	
									<div class="col-md-6 card-body text-left">
										<?php if($row_empresa['EComerce'] == 'S'){ ?>
											<?php if(count($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) > '0'){ ?>

												<!--<input class="btn btn-md btn-success" type="submit" value="Escolher Produto/ Finalizar Pedido"/>-->
												<div class="row">
													<div class="col-md-6">
														<br>
														<input type="submit" class="btn btn-md btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" value="Adicionar Produto!"/>
													</div>
													<?php if($total_venda >= $row_empresa['ValorMinimo']){ ?>
														<div class="col-md-6">
															<br>
															<a href="entrega.php" class="btn btn-warning btn-block" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)">Finalizar Pedido / Observações!</a>
														</div>
													<?php }else{ ?>
														<div class="alert alert-warning aguardar" role="alert">
															Atenção! O Valor Mínimo do pedido deve ser de R$ <?php echo number_format($row_empresa['ValorMinimo'], 2, ",", ".");?>
														</div>
													<?php } ?>
												</div>	
												<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
												  Aguarde um instante! Estamos processando sua solicitação!
												</div>
												<!--<input type="submit" class="azul" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" value="Cadastrar"/>-->
											
											<?php } else { ?>	
										
												<a href="produtos.php" class="btn btn-success" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Adicionar Produto</a>
												<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
												  Aguarde um instante! Estamos processando sua solicitação!
												</div>									
												<!--<input type="submit" class="btn btn-md btn-success" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" value="Escolher Produto/ Finalizar Pedido""/>-->
											
											<?php } ?>
										<?php } ?>
									</div>
									<!--
									<div class="col-md-4 card-body text-center">
										<input class="btn btn-md btn-primary" type="submit" value="Atualizar Quantidade"/>
									</div>
									-->
								</div>
							<?php } else { ?>
								<a href="meu_carrinho.php" class="btn btn-warning btn-block">Loja Fechada</a>
								<!--<button class="btn btn-warning btn-block "  >Loja Fechada</button>-->
							<?php } ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php } ?>							
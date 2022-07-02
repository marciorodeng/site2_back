<?php

	if(isset($row_empresa['EComerce']) && $row_empresa['EComerce'] == "N"){
		echo "<script>window.location = 'index.php'</script>";
		exit();
	}

	if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){ 
		$result = 'SELECT 
					CashBackCliente,
					ValidadeCashBack
				FROM
					App_Cliente
				WHERE
					idSis_Empresa = ' . $idSis_Empresa . ' AND
					idApp_Cliente = "' . $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa] . '"
				LIMIT 1	
			';

		$resultado = mysqli_query($conn, $result);
		foreach($resultado as $resultado_view){
			$cashtotal 	= 	$resultado_view['CashBackCliente'];
			$validade 	=	$resultado_view['ValidadeCashBack'];
		}

		$validade_explode = explode('-', $validade);
		$validade_dia = $validade_explode[2];
		$validade_mes = $validade_explode[1];
		$validade_ano = $validade_explode[0];
		
		$validade_visao 	= $validade_dia . '/' . $validade_mes . '/' . $validade_ano;
		
		$data_hoje = date('Y-m-d', time());

		if(strtotime($validade) >= strtotime($data_hoje)){
			$cashtotal_visao 	= number_format($cashtotal,2,",",".");
		}else{
			$cashtotal_visao 	= '0,00';
		}
		$cashtotal_conta 	= str_replace(',', '.', str_replace('.', '', $cashtotal_visao));

	} 
?>
	
<section id="carrinho" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		
		<?php 
		if(isset($id_Session) && isset($_SESSION['Site_Back']['cart'][$id_Session])){	
			foreach ($_SESSION['Site_Back']['cart'][$id_Session] as $value) :
				$qtd_produto 	= $value['qtd']; // Passo a quantidade que vem junto com o produto
			endforeach;
		}
		?>
		<div class="container">
			<div class="row">	
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<h1 class="title-h1">Carrinho!</h1>
					<hr class="traco-h1">
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fundo-carrinho ">	
				<form name="Form" id="Form" action="?acao=up-produtos" method="post">
					<ul class="list-group mb-3 ">										
						<?php
							$total_venda = '0';
							$total_peso = '0';
							$item_carrinho = '0';
							$total_produtos = '0';
							$prazo_carrinho = '0';
							if(isset($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]) && count($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]) > '0'){
								foreach($_SESSION['Site_Back']['carrinho'.$idSis_Empresa] as $id_produto_carrinho => $quantidade_produto_carrinho){
									$item_carrinho++;
									$read_produto_carrinho = mysqli_query($conn, "
									SELECT 
										TPS.idTab_Produtos,
										TPS.Nome_Prod,
										TPS.Arquivo,
										TPS.ValorProdutoSite,
										TPS.PesoProduto,
										TPS.ObsProduto,
										TPS.ContarEstoque,
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
											$contar_estoque = $read_produto_carrinho_view['ContarEstoque'];
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
										<div class="row ">
											<div class="col-md-4">
												<div class="row ">	
													<div class="container-2">	
														<div class="col-xs-4 col-md-4">		
															<div class="row ">
																
																	<!--
																	<div class="col-md-4">
																		<h4 class="my-0"><span class="text-muted">Item: </span><?php echo $item_carrinho;?> </h4> 
																	</div>
																	-->
																	<div class="col-md-12">
																		<img class="team-img img-responsive" src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produto_carrinho_view['Arquivo']; ?>" alt="" width='100' >
																	</div>
																
															</div>
														</div>	
														<div class="col-xs-8 col-md-8">	
															<div class="row ">	
																<div class="col-md-12 ">
																	<span class="" style="color: #000000"><?php echo utf8_encode ($read_produto_carrinho_view['Promocao']);?></span>
																	<span class="" style="color: #000000"><?php echo utf8_encode ($read_produto_carrinho_view['Descricao']);?></span>
																</div>
															</div>
															<div class="row ">	
																<div class="col-md-12 ">
																	<span class="card-title" style="color: #000000">
																		<?php echo utf8_encode ($read_produto_carrinho_view['Nome_Prod']);?><br>
																		<?php echo utf8_encode ($read_produto_carrinho_view['Convdesc']);?>
																	</span>
																	<span class="card-title"style="color: #000000">
																		<?php echo utf8_encode ($read_produto_carrinho_view['Produtos_Descricao']);?>
																	</span>
																</div>
																
															</div>		
															<div class="row text-center">
																<h5 class="container-2 text-center">
																	<div class="col-md-2">
																		<span class="my-0"><a href="deletar_produto_carrinho.php?tipo=<?php echo $read_produto_carrinho_view['idTipo']; ?>&promocao=<?php echo $read_produto_carrinho_view['idTab_Promocao']; ?>&id=<?php echo $id_produto_carrinho; ?>&somar=1&qtd=<?php echo $quantidade_produto_carrinho; ?>"><h2>-</h2></a></span>
																	</div>	
																	<div class="col-md-3 ">
																		<span class="my-0"><span class="text-muted"></span><input class="text-muted" type="hidden" onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $item_carrinho ?>','<?php echo $id_produto_carrinho ?>')" id="Qtd<?php echo $item_carrinho;?>" size="5" name="prod[<?php echo $id_produto_carrinho ?>]" value="<?php echo $quantidade_produto_carrinho ?>"/><span class="text-muted"><?php echo $quantidade_produto_carrinho ?></span></span>
																	</div>
																	<div class="col-md-2 ">
																		<span class="my-0"><a href="deletar_produto_carrinho.php?tipo=<?php echo $read_produto_carrinho_view['idTipo']; ?>&promocao=<?php echo $read_produto_carrinho_view['idTab_Promocao']; ?>&id=<?php echo $id_produto_carrinho; ?>&somar=2&qtd=<?php echo $quantidade_produto_carrinho; ?>"><h2>+</h2></a></span>
																	</div>
																	<div class="col-md-5 ">
																		<span class="my-0 text-right">
																			<a href="deletar_produto_carrinho.php?tipo=<?php echo $read_produto_carrinho_view['idTipo']; ?>&promocao=<?php echo $read_produto_carrinho_view['idTab_Promocao']; ?>&id=<?php echo $id_produto_carrinho; ?>&somar=0">
																				<span class="glyphicon glyphicon-trash"></span>
																			</a>
																		</span>
																	</div>
																</h5>
															</div>
														</div>
													</div>	
												</div>
											</div>	
											<div class="col-md-6">		
												<div class="row ">
													<div class="container-2">
														<div class="col-xs-4 col-md-4">
															<div class="row ">
																<div class="col-md-6">
																	<span class="card-title" style="color: #000000">
																		<?php 
																			if($read_produto_carrinho_view['TempoDeEntrega'] <= 0){
																				echo 'Pronta Entrega!';
																			}else{
																				echo '' . $read_produto_carrinho_view['TempoDeEntrega'] . ' Dias!';
																			} 
																		?>
																	</span>
																</div>
															</div>
														</div>
														<div class="col-xs-4 col-md-4">
															<span class="my-0"style="color: #000000"><span id="SubQtd<?php echo $item_carrinho;?>" ><?php echo $sub_total_produtos;?> un.</span></span> 
														</div>
														<div class="col-xs-4 col-md-4">
															<span class="my-0"style="color: #000000">R$<span id="Subtotal<?php echo $item_carrinho;?>" ><?php echo number_format($sub_total_produto_carrinho,2,",",".");?></span></span> 
														</div>
													</div>
												</div>	
												<div class="row ">
													<h5 class="my-0"><span id="msg<?php echo $item_carrinho;?>" value=""></span></h5>
													<?php if($contar_estoque == "S"){?>
														<?php if($quantidade_produto_carrinho > $quantidade_estoque){?>
															<div class="col-md-12 ">
																<span class="my-0" style="color: #FF0000"><span class="text-muted" style="color: #FF0000"> Atenção!!</span> Quantidade maior que o Estoque!!!!</span>
															</div>
														<?php } ?>
													<?php } ?>	
												</div>
											</div>
										</div>
									</li>
									<?php
								}
							}
							
							$_SESSION['Site_Back']['item_carrinho'.$idSis_Empresa] = $item_carrinho;
							$_SESSION['Site_Back']['total_produtos'.$idSis_Empresa] = $total_produtos;
							/*
							echo "<pre>";
							echo $item_carrinho;
							echo "<br>";
							echo $_SESSION['Site_Back']['item_carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]];
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
							<?php if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])) { ?>
								<?php 
									if((isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa]) 
										&& isset($_SESSION['Site_Back']['Nivel_Usuario_vend'.$idSis_Empresa])
										&& $_SESSION['Site_Back']['Nivel_Usuario_vend'.$idSis_Empresa] == 2)
										OR (isset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa]) 
										&& isset($_SESSION['Site_Back']['Nivel_Vendedor'.$idSis_Empresa])
										&& $_SESSION['Site_Back']['Nivel_Vendedor'.$idSis_Empresa] == 2)){ 
								?>
								<?php }else{ ?>
									<li class="list-group-item d-flex justify-content-between fundo">
										<span>Valor em CashBack </span>
										<strong>: R$ <span  name="ValorCashBack" id="ValorCashBack"><?php echo $cashtotal_visao;?></span></strong>
									</li>
									<li class="list-group-item d-flex justify-content-between fundo">
										<span>Validade do CashBack </span>
										<strong>: <span><?php echo $validade_visao;?></span></strong>
									</li>
								<?php } ?>	
							<?php } ?>
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
							<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 ">
								<?php if($row_empresa['EComerce'] == 'S'){ ?>
									<?php if(isset($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]) && count($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]) > '0'){ ?>

										<!--<input class="btn btn-md btn-success" type="submit" value="Escolher Produto/ Finalizar Pedido"/>-->
										<div class="row">
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 card-body text-left">
												<br>
												<input type="submit" class="btn btn-md btn-success btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" value="Escolher Produto"/>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 card-body text-left">
												<br>
												<?php if($total_venda >= $row_empresa['ValorMinimo']){ ?>
													<?php if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])) { ?>
														<a href="entrega.php" class="btn btn-warning btn-block" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)">Concluir Pedido</a>
													<?php }else{ ?>
														<?php if(isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa])) { ?>
															<a href="pesquisar_cliente.php" class="btn btn-warning btn-block" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)">Concluir Pedido</a>
														<?php }else{ ?>
															<a href="login_cliente.php" class="btn btn-warning btn-block" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)">Concluir Pedido</a>
														<?php } ?>
													<?php } ?>
													
												<?php }else{ ?>
													<div class="alert alert-warning aguardar" role="alert">
														Atenção! O Valor Mínimo do pedido deve ser de R$ <?php echo number_format($row_empresa['ValorMinimo'], 2, ",", ".");?>
													</div>
												<?php } ?>
											</div>
										</div>	
										<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
										  Aguarde um instante! Estamos processando sua solicitação!
										</div>
										<!--<input type="submit" class="azul" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" value="Cadastrar"/>-->
									
									<?php } else { ?>	
								
										<a href="catalogo.php" class="btn btn-success" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Escolher Produto</a>
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
				<br>
			</div>
		</div>
			
</section>
					
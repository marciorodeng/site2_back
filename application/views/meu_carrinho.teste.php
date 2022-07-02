<section id="service" class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="ser-title">Meu Carrinho!</h2>
				<hr class="botm-line">
			</div>				
						
			<div class="col-lg-12">
				<div class="col-md-12 order-md-2 mb-4 img-prod-pag fundo-carrinho">
					<form name="Form" id="Form" action="?acao=up" method="post">
						<ul class="list-group mb-3 ">										
							<?php

								$item_carrinho = '0';
								if(count($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) > '0'){
									foreach($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]] as $id_produto_carrinho => $quantidade_produto_carrinho){
										$item_carrinho++;
										$read_produto_carrinho = mysqli_query($conn, "
										SELECT 
											TP.idTab_Produto,
											TP.Produtos,
											TP.Arquivo,
											TP.ValorProdutoSite,
											TP.PesoProduto,
											TP.ObsProduto,
											TV.idTab_Valor,
											TV.ValorProduto
										FROM 
											Tab_Produto AS TP
												LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produto = TP.idTab_Produto
												WHERE 
											TV.idTab_Valor = '".$id_produto_carrinho."'
										ORDER BY 
											TV.idTab_Valor ASC						
										");
										if(mysqli_num_rows($read_produto_carrinho) > '0'){
											
											foreach($read_produto_carrinho as $read_produto_carrinho_view){
											
												$idTab_Produto = $read_produto_carrinho_view['idTab_Produto'];
												
												$sub_total_peso = $quantidade_produto_carrinho * $read_produto_carrinho_view['PesoProduto'];
												$total_peso += $sub_total_peso;
												$sub_total_produto_carrinho = $quantidade_produto_carrinho * $read_produto_carrinho_view['ValorProduto'];
												$total_venda += $sub_total_produto_carrinho;
												$total = number_format($total_venda, 2, ",", ".");

												$compra = mysqli_query($conn, "
														SELECT
															SUM(APV.QtdProduto) AS QtdCompra,
															TP.idTab_Produto
														FROM
															App_Produto AS APV
																LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
																LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
																LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto					
														WHERE
															OT.AprovadoOrca ='S' AND
															TP.idTab_Produto = '".$idTab_Produto."' AND
															APV.idSis_Empresa = '".$idSis_Empresa."' AND
															APV.idTab_TipoRD = '1'
															

												");
												if(mysqli_num_rows($compra) > '0'){
													foreach($compra as $compra_view){
														$qtdcompra = $compra_view['QtdCompra'];
													}
													}
												
												$venda = mysqli_query($conn, "
														SELECT
															SUM(APV.QtdProduto) AS QtdVenda,
															TP.idTab_Produto
														FROM
															App_Produto AS APV
																LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
																LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
																LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto					
														WHERE
															OT.AprovadoOrca ='S' AND
															TP.idTab_Produto = '".$idTab_Produto."' AND
															APV.idSis_Empresa = '".$idSis_Empresa."' AND
															APV.idTab_TipoRD = '2'


												");
												if(mysqli_num_rows($venda) > '0'){
													foreach($venda as $venda_view){
														$qtdvenda = $venda_view['QtdVenda'];
													}
												}
												
												$qtdestoque = $qtdcompra - $qtdvenda;												
												
											}
												
											
										} 
									?>		
										

																
										<li class="list-group-item d-flex justify-content-between lh-condensed fundo">
											<div class="row img-prod-pag">	
												<div class="col-md-12">	
													<div class="col-md-2">		
														<div class="row ">	
															<div class="col-md-12">
																<h4 class="my-0"><span class="text-muted">Item:</span><?php echo $item_carrinho;?> </h4> 
															</div>															
														</div>
													</div>
													<div class="col-md-2">
														<div class="row ">	
															<div class="col-md-12 ">
																<h4 class="my-0"><?php echo utf8_encode ($read_produto_carrinho_view['Produtos']);?></h4> 
															</div>
														</div>	
														<div class="row ">	
															<div class="col-md-12">
																<img class="team-img img-circle img-responsive" src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produto_carrinho_view['Arquivo']; ?>" alt="" width='100' >
															</div>
														</div>															
													</div>	
													<div class="col-md-8">		
														<div class="row ">
															<div class="col-md-4 ">
																<h4 class="my-0">Estoque: <?php echo $qtdestoque;?></h4> 
															</div>
															<div class="col-md-4 ">
																<h4 class="my-0"><span class="text-muted"><?php echo $item_carrinho;?>- Qtd:</span><input class="text-muted" onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $item_carrinho ?>')" id="Qtd<?php echo $item_carrinho;?>" type="text" size="5" name="Qtd<?php echo $item_carrinho;?>" value="<?php echo $quantidade_produto_carrinho ?>"/><span class="text-muted"> X </span></h4> 
															</div>
															<?php if($quantidade_produto_carrinho > $qtdestoque){?>
																<div class="col-md-4 ">
																	<h4 class="my-0" style="color: #FF0000"><span class="text-muted" style="color: #FF0000"> Atenção!!</span> Quantidade maior que o Estoque!!!!</h4>
																</div>
															<?php } ?>														
														</div>	
														<div class="row ">
															<div class="col-md-4 ">
																<h4 class="my-0"><span class="text-muted"><?php echo $item_carrinho;?>- Valor: </span> R$<span id="Valor<?php echo $item_carrinho;?>"><?php echo $read_produto_carrinho_view['ValorProduto'];?></span><span class="text-muted"> =</span></h4> 
															</div>
															<div class="col-md-4 ">
																<h4 class="my-0"><span class="text-muted"><?php echo $item_carrinho;?>- SubTotal: </span>R$<span id="Subtotal<?php echo $item_carrinho;?>">0,00</span></h4> 
															</div>
															<div class="col-md-4 ">
																<h4 class="my-0"><a href="deletar_produto_carrinho.php?id=<?php echo $id_produto_carrinho ?>">Excluir</a></h4> 
															</div>
														</div>
													</div>
												</div>	
											</div>
										</li>

									<?php
									}
								}
							?>
							
							<li class="list-group-item d-flex justify-content-between fundo">
								<span>Total de Itens </span>
								<strong>: <?php echo $item_carrinho; ?></strong>
							</li>
							<?php if($item_carrinho > 0) { ?>
								<li class="list-group-item d-flex justify-content-between fundo">
									<span>Valor Total </span>
									<strong>R$ <?php echo $total;?></strong>
								</li>
							<?php } ?>
						</ul>
						<div class="row">	
							<div class="col-md-4 card-body text-left">
								<a href="produtos.php" class="btn btn-success">Escolher Produto</a>
							</div>
							<div class="col-md-4 card-body text-center">
								<input class="btn btn-md btn-primary" type="submit" value="Atualizar Quantidade"/>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-12 fundo-entrega-carrinho">
					<div class="col-lg-12 ">
						<form name="FormularioEntrega" id="FormularioEntrega" method="post" action="finalizar_pedido.php" >
							<div class="row">
								<div class="col-lg-12 ">	
									<h3 class="mb-3">Escolha sua opção de Entrega</h3>
										
									<div class="row ">
										<div class="col-lg-12">	
											<div class="col-md-3 mb-3 ">	
												<div class="custom-control custom-radio">
													<input type="radio" name="tipofrete" class="custom-control-input"  id="Retirada" value="1" onclick="tipoFrete('1')" checked>
													<label class="custom-control-label" for="Retirada">Retirada</label>
													<img src="https://www.enkontraki.com.br/<?php echo $sistema ?>/arquivos/imagens/loja.png" class="img-responsive img-link Retirada" width='150'>
												</div>
											</div>
											<div class="col-md-3 mb-3 ">	
												<div class="custom-control custom-radio">
													<input type="radio" name="tipofrete" class="custom-control-input" id="Combinar" value="2" onclick="tipoFrete('2')">
													<label class="custom-control-label" for="Combinar">A Combinar</label>
													<img src="https://www.enkontraki.com.br/<?php echo $sistema ?>/arquivos/imagens/combinar.png" class="img-responsive img-link Combinar" width='150'>
												</div>
											</div>								
											<div class="col-md-3 mb-3 ">
												<div class="custom-control custom-radio">
													<input type="radio" name="tipofrete" class="custom-control-input" id="Correios" value="3" onclick="tipoFrete('3')">
													<label class="custom-control-label" for="Correios">Correios</label>
													<img src="https://www.enkontraki.com.br/<?php echo $sistema ?>/arquivos/imagens/correios.png" class="img-responsive img-link Correios" width='150'>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<h3 class="mb-3 Correios">Calcular Valor do Frete e Prazo de Entrega</h3>

							<h3 class="mb-3 Combinar">Cobinar a Entrega com o Vendedor</h3>
							
							<h3 class="mb-3 Retirada">Retirar o produto na Loja</h3>							
	
							<input type="hidden" name="RecarregaCepDestino" id="RecarregaCepDestino" value="<?php echo $row_empresa['Cep'];?>">
							<input type="hidden" name="RecarregaLogradouro" id="RecarregaLogradouro" value="<?php echo $row_empresa['Endereco'];?>">
							<input type="hidden" name="RecarregaNumero" id="RecarregaNumero" value="<?php echo $row_empresa['Numero'];?>">
							<input type="hidden" name="RecarregaComplemento" id="RecarregaComplemento" value="<?php echo $row_empresa['Complemento'];?>">
							<input type="hidden" name="RecarregaBairro" id="RecarregaBairro" value="<?php echo $row_empresa['Bairro'];?>">
							<input type="hidden" name="RecarregaCidade" id="RecarregaCidade" value="<?php echo $row_empresa['Municipio'];?>">
							<input type="hidden" name="RecarregaEstado" id="RecarregaEstado" value="<?php echo $row_empresa['Estado'];?>">
					
							<input type="hidden" name="CepOrigem" id="CepOrigem" placeholder="CepOrigem" value="<?php echo $row_empresa['Cep'];?>">
							<input type="hidden" name="Peso" id="Peso" placeholder="Peso" value="<?php echo $total_peso; ?>">
							<input type="hidden" name="Formato" id="Formato" placeholder="Formato" value="1">
							<input type="hidden" name="Comprimento" id="Comprimento" placeholder="Comprimento" value="30">
							<input type="hidden" name="Largura" id="Largura" placeholder="Largura" value="15">									
							<input type="hidden" name="Altura" id="Altura" placeholder="Altura" value="5">
							<input type="hidden" name="Diametro" id="Diametro" placeholder="Diametro" value="0">		
							<input type="hidden" name="MaoPropria" id="MaoPropria" placeholder="MaoPropria" value="N">
							<input type="hidden" name="ValorDeclarado" id="ValorDeclarado" placeholder="ValorDeclarado" value="0">
							<input type="hidden" name="AvisoRecebimento" id="AvisoRecebimento" placeholder="AvisoRecebimento" value="N">
								
							<div class="row Liga">
								<div class="col-md-9 mb-3 Retirada">
									<h5><?php echo $row_empresa['Endereco'];?>, <?php echo $row_empresa['Numero'];?> - <?php echo $row_empresa['Complemento'];?><br>
										<?php echo $row_empresa['Bairro'];?> - <?php echo $row_empresa['Municipio'];?> - <?php echo $row_empresa['Estado'];?><br>
										Cep: <?php echo $row_empresa['Cep'];?>.
									</h5>
								</div>
							</div>
																	
							<div class="row Desliga">
								<div class="col-md-3 mb-3 Desliga">
									<label class="Desliga">Cep</label>
									<input type="text" name="CepDestino" class="form-control Desliga Calcular" id="CepDestino" placeholder="CEP sem traço" maxlength="8" value="<?php echo $row_empresa['Cep'];?>" required>
									<input type="text" name="Cep" class="form-control Correios Desliga Recalcular" id="Cep" readonly="" value="" required>
								</div>
								<div class="col-md-2 mb-3 Combinar">	
									<label class=" Combinar">Buscar End.</label>
									<button class=" form-control Combinar" type="button" onclick="LoadFrete(); Procuraendereco()"  >Buscar</button>
								</div>
									<div class="col-md-2 mb-3 Correios">	
										<label class=" Correios Calcular">Calcula Frete.</label>
										<label class=" Correios Recalcular">Recalcular Frete.</label>
										<?php if(count($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) > '0'){ ?>	
											<button class=" form-control Correios Calcular" type="button" onclick="LoadFrete(); Procuraendereco(); Calcular()"  >Calcular</button>	
											<button class=" form-control Correios Recalcular" type="button" onclick="Recalcular()"  >Recalcular</button>
										<?php } ?>
									</div>
								<div class="col-md-2 mb-3 Combinar">	
									<label class=" Combinar"></label><br>
									<a href="http://www.buscacep.correios.com.br/sistemas/buscacep/default.cfm" target="_blank">Não sei meu CEP!!</a>
								</div>
								<div class="col-md-2 mb-3 Correios">	
									<label class=" Correios">Tipo de Envio</label>
									<?php if(count($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) > '0'){ ?>
										<select class="form-control Correios" name="Codigo" id="Codigo" readonly="" onchange="Limpar(); LoadFrete(); Procuraendereco()">
											<option class="text-muted" value="41106">1 - PAC </option>										
											<option class="text-muted" value="40010">2 - SEDEX </option>
										</select>
									<?php } ?>	
								</div>
								<div class="col-md-2 mb-3 Correios">	
									<label class=" Correios"></label><br>
									<a href="http://www.buscacep.correios.com.br/sistemas/buscacep/default.cfm" target="_blank">Não sei meu CEP!!</a>
								</div>
								<div class="col-md-3 mb-3 Correios">	
									<label class=" Correios"></label><br>
									<span id="msg"></span>
								</div>								
							</div>
							<div class="row Desliga">
								<div class="col-md-3 mb-3 Correios">
									<label class=" Correios">Produtos</label>
									<input type="text" class="form-control Desliga" id="valor_prod" placeholder="Valor da Compra" readonly="" value="<?php echo $total;?>"/>								
								</div>
								<div class="col-md-2 mb-3 Correios">
									<label class=" Correios">Frete</label>
									<input type="text" class="Correios form-control"  name="valorfrete" id="valorfrete" placeholder="Valor do Frete" value="" readonly="" required>	
								</div>
								<div class="col-md-2 mb-3 Correios">
									<label class=" Correios">Total</label>
									<input type="text" class="form-control Desliga" id="valor_total" placeholder="Total" value="" readonly=""/>
								</div>
								<div class="col-md-2 mb-3 Correios">	
									<label class=" Correios">Prazo(dias)</label>
									<span class="ResultadoPrecoPrazo Correios Desliga"></span>
									<input type="text" class="Correios form-control"  name="prazoentrega" id="prazoentrega" placeholder="Prazo" value="" readonly="" required>
								</div>								
							</div>
							<div class="row Desliga">
								<div class="col-md-5 mb-3 Desliga">
									<label class="Desliga">Endereço</label>
									<input type="text" name="Logradouro" class="form-control Desliga" id="Logradouro" placeholder="Av. Rua" value="<?php echo $row_empresa['Endereco'];?>" required>
								</div>
								<div class="col-md-2 mb-3 Desliga">
									<label class="Desliga">Número</label>
									<input type="text" name="Numero" class="form-control Desliga" id="Numero" placeholder="Número" value="<?php echo $row_empresa['Numero'];?>" required>
								</div>
								<div class="col-md-5 mb-3 Desliga">
									<label class="Desliga">Complemento</label>
									<input type="text" name="Complemento" class="form-control Desliga" id="Complemento" placeholder="Complemento" value="<?php echo $row_empresa['Complemento'];?>">
								</div>							
							</div>
							<div class="row Desliga">
								<div class="col-md-5 mb-3 Desliga">
									<label class="Desliga">Bairro</label>
									<input type="text" name="Bairro" class="form-control Desliga" id="Bairro" placeholder="Bairro" value="<?php echo $row_empresa['Bairro'];?>" required>
								</div>
								<div class="col-md-5 mb-3 Desliga">
									<label class="Desliga">Cidade</label>
									<input type="text" name="Cidade" class="form-control Desliga" id="Cidade" placeholder="Cidade" value="<?php echo $row_empresa['Municipio'];?>" required>
								</div>
								<div class="col-md-2 mb-3 Desliga">
									<label class="Desliga">Estado</label>
									<select name="Estado" class="form-control Desliga" id="Estado" required>
										<option value="<?php echo $row_empresa['Estado'];?>"><?php echo $row_empresa['Estado'];?></option>
										<option value="AC">AC</option>
										<option value="AL">AL</option>
										<option value="AP">AP</option>
										<option value="AM">AM</option>
										<option value="BA">BA</option>
										<option value="CE">CE</option>
										<option value="DF">DF</option>
										<option value="ES">ES</option>
										<option value="GO">GO</option>
										<option value="MA">MA</option>
										<option value="MT">MT</option>
										<option value="MS">MS</option>
										<option value="MG">MG</option>
										<option value="PA">PA</option>
										<option value="PB">PB</option>
										<option value="PR">PR</option>
										<option value="PE">PE</option>
										<option value="PI">PI</option>
										<option value="RJ">RJ</option>
										<option value="RN">RN</option>
										<option value="RS">RS</option>
										<option value="RO">RO</option>
										<option value="RR">RR</option>
										<option value="SC">SC</option>
										<option value="SP">SP</option>
										<option value="SE">SE</option>
										<option value="TO">TO</option>
										<!--<option value="SP" selected>SP</option>-->
									</select>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-lg-12">							
									<div class="card card-outline-secondary my-4">								
										<div class="card-body">										
											<?php if(count($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) > '0'){ ?>
												<?php if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ ?>
													<input type="submit" id="botao" name="botao" class="btn btn-danger btn-block finalizar" value="Finalizar Pedido">
											
												<?php } else { ?>	
													
													<a href="login_cliente.php" class="btn btn-danger btn-block">Logar / Finalizar Pedido</a>
												
												<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>							
						</form>	
					</div>
				</div>				
			</div>
		</div>
	</div>
</section>

						
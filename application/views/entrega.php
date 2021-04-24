<?php if(isset($_SESSION['Nome_Cliente'.$idSis_Empresa])){ ?>	
	<section id="service" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2 class="ser-title">Entrega & Pagamento!</h2>
					<hr class="botm-line">
				</div>
				<div class="col-lg-12">
					<form name="FormularioEntrega" id="FormularioEntrega" method="post" action="finalizar_pedido.php" >
						<div class="col-md-12 order-md-2 mb-4 img-prod-pag fundo-carrinho">
						
							<ul class="list-group mb-3 ">										
								<?php
									$total_venda = '0';
									$total_peso = '0';
									$total_produtos = '0';
									$item_carrinho = '0';
									$prazo_carrinho = '0';
									if(count($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) > '0'){
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
												TOP2.Opcao AS Opcao2,
												TOP1.Opcao AS Opcao1,
												CONCAT(TPS.Nome_Prod, ' ' ,TOP2.Opcao, ' ' ,TOP1.Opcao) AS Produtos,
												TV.idTab_Valor,
												TV.Desconto,
												TV.QtdProdutoDesconto,
												TV.QtdProdutoIncremento,
												TV.ValorProduto,
												TV.Convdesc,
												TV.TempoDeEntrega,
												TPR.Promocao,
												TPR.Descricao,
												TDSC.Desconto
											FROM 
												Tab_Produtos AS TPS
													LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produtos = TPS.idTab_Produtos
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
												
													$idTab_Produto = $read_produto_carrinho_view['idTab_Produtos'];
													$quantidade_produto_incremento = $read_produto_carrinho_view['QtdProdutoIncremento'];
													$quantidade_estoque = $read_produto_carrinho_view['Estoque'];
													$prazo_prod = $read_produto_carrinho_view['TempoDeEntrega'];
													$sub_total_qtd_produto = $quantidade_produto_carrinho * $quantidade_produto_incremento;
													$total_produtos += $sub_total_qtd_produto;
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
																	<h5 class="card-title"><?php echo utf8_encode ($read_produto_carrinho_view['Desconto']);?><br> 
																							<?php echo utf8_encode ($read_produto_carrinho_view['Promocao']);?>
																	</h5>
																	<!--<h5 class="my-0"><?php echo utf8_encode ($read_produto_carrinho_view['Desconto']);?></h5>
																	<h5 class="my-0"><?php echo utf8_encode ($read_produto_carrinho_view['Promocao']);?></h5>
																	<h5 class="my-0"><?php echo utf8_encode ($read_produto_carrinho_view['Descricao']);?></h5>-->
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="row ">	
																<div class="col-md-12">
																	<img class="team-img img-circle img-responsive" src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produto_carrinho_view['Arquivo']; ?>" alt="" width='100' >
																</div>
															</div>															
														</div>
														<div class="col-md-3">
															<div class="row ">	
																<div class="col-md-12 ">
																	<h5 class="card-title"><?php echo utf8_encode ($read_produto_carrinho_view['Nome_Prod']);?><br> 
																							<?php echo utf8_encode ($read_produto_carrinho_view['Convdesc']);?><br>
																							<?php echo utf8_encode ($read_produto_carrinho_view['Produtos_Descricao']);?>
																	</h5>
																	<!--<h5 class="my-0"><?php echo utf8_encode ($read_produto_carrinho_view['Nome_Prod']);?></h5><br>
																	<h5 class="my-0"><?php echo utf8_encode ($read_produto_carrinho_view['Convdesc']);?></h5>
																	<h5 class="my-0"><?php echo $read_produto_carrinho_view['QtdProdutoIncremento'];?> Unid.</h5>-->
																</div>
															</div>															
														</div>	
														<div class="col-md-2">		
															<div class="row ">
																<div class="col-md-12 ">
																	<h4 class="my-0"><span class="text-muted">SubQtd: </span> <span id="Qtd<?php echo $item_carrinho;?>"  name="prod[<?php echo $id_produto_carrinho ?>]" value="" ><?php echo $sub_total_qtd_produto ?> Un.</span><span class="text-muted"></span></h4> 
																</div>														
															</div>
														</div>	
														<div class="col-md-3">		
															<div class="row ">
																<!--
																<div class="col-md-3 ">
																	<h4 class="my-0">Estoque:<br> <?php echo $quantidade_estoque;?></h4> 
																</div>
																														
																<div class="col-md-6 ">
																	<h4 class="my-0"><span class="text-muted">Valor</span><br>R$<span id="Valor<?php echo $item_carrinho;?>" value=""><?php echo number_format($read_produto_carrinho_view['ValorProduto'],2,",",".");?></span><span class="text-muted"> =</span></h4> 
																</div>
																-->	
																<div class="col-md-12 ">
																	<h4 class="my-0"><span class="text-muted">SubTotal: </span> R$<span id="Subtotal<?php echo $item_carrinho;?>" ><?php echo number_format($sub_total_produto_carrinho,2,",",".");?></span></h4> 
																</div>														
															</div>	
															<!--
															<div class="row ">
																<div class="col-md-4 ">
																	<h4 class="my-0"><a href="deletar_produto_carrinho.php?id=<?php echo $id_produto_carrinho ?>">Excluir</a></h4> 
																</div>															
																<?php if($quantidade_produto_carrinho > $quantidade_estoque){?>
																	<div class="col-md-4 ">
																		<h4 class="my-0" style="color: #FF0000"><span class="text-muted" style="color: #FF0000"> Atenção!!</span> Quantidade maior que o Estoque!!!!</h4>
																	</div>
																<?php } ?>
															</div>
															-->
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
									<strong>: <span  name="PCount" id="PCount" value="<?php echo $item_carrinho; ?>"><?php echo $item_carrinho; ?></span></strong>
								</li>
								<?php if($item_carrinho > 0) { ?>
									<li class="list-group-item d-flex justify-content-between fundo">
										<span>Total Produtos </span>
										<strong>: <span  name="TotalProd" id="TotalProd"><?php echo $total_produtos;?> Unid.</span></strong>
									</li>
									<li class="list-group-item d-flex justify-content-between fundo">
										<span>Valor Total </span>
										<strong>: R$ <span  name="ValorTotal" id="ValorTotal"><?php echo $total;?></span></strong>
									</li>
									<li class="list-group-item d-flex justify-content-between fundo">
										<span>Prazo de Entrega na Loja </span>
										<strong>: 
											<span>
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
							
							<div class="row">
								<div class="col-md-6 mb-3 ">
									<label>Observações:</label>
									<textarea type="text" name="Descricao" class="form-control " id="Descricao" placeholder="Observações do Pedido:" value=""></textarea>
								</div>
								<div class="col-md-6">	
									<div class="row">
										<div class="col-md-6 card-body text-left">
											<br>
											<a href="produtos.php" class="btn btn-block btn-success">Adicionar Produto</a>
										</div>
										<div class="col-md-6 card-body text-left">
											<br>
											<a href="meu_carrinho.php" class="btn btn-block btn-warning">Voltar ao Carrinho</a>
											<!--<a href="produtos.php" class="btn btn-success">Escolher Produto</a>
											<input class="btn btn-md btn-success" type="submit" value="Escolher Produto/ Fechar o Carrinho"/>-->
										</div>
										<?php if($total_venda < $row_empresa['ValorMinimo']){ ?>
											<div class="alert alert-warning aguardar" role="alert">
												Atenção! O Valor Mínimo do pedido deve ser de R$ <?php echo number_format($row_empresa['ValorMinimo'], 2, ",", ".");?>
											</div>
										<?php } ?>
										<!--
										<div class="col-md-4 card-body text-center">
											<input class="btn btn-md btn-primary" type="submit" value="Atualizar Quantidade"/>
										</div>
										-->
									</div>	
								</div>	
							</div>
						
						</div>
						<?php if($total_venda >= $row_empresa['ValorMinimo']){ ?>
							<?php if ($row_empresa['RetirarLoja'] == 'S' || $row_empresa['MotoBoy'] == 'S' || $row_empresa['Correios'] == 'S') { ?>
								
									<div class="col-md-12 fundo-entrega-carrinho">
										<div class="col-lg-12 ">
											<div class="row">
												<div class="col-lg-12 ">	
													<h3 class="mb-3">Local e Forma da Entrega</h3>
													<?php if ($row_empresa['RetirarLoja'] == 'S') { ?>
													<div class="col-md-3 mb-3 ">	
														<div class="custom-control custom-radio">
															<input type="radio" name="tipofrete" class="custom-control-input "  id="Retirada" value="1" onclick="tipoFrete('1'), calculaDataEntrega()" >
															<label class="custom-control-label" for="Retirada">Retirar na Loja</label>
															<img src="../<?php echo $sistema ?>/arquivos/imagens/loja.png" class="img-responsive img-link Retirada" width='150'>
														</div>
													</div>
													<?php } ?>
													<?php if ($row_empresa['MotoBoy'] == 'S') { ?>
													<div class="col-md-3 mb-3 ">	
														<div class="custom-control custom-radio">
															<input type="radio" name="tipofrete" class="custom-control-input " id="Combinar" value="2" onclick="tipoFrete('2'), calculaDataEntrega()" >
															<label class="custom-control-label" for="Combinar">Casa/Pela Loja </label>
															<img src="../<?php echo $sistema ?>/arquivos/imagens/combinar.png" class="img-responsive img-link Combinar" width='150'>
														</div>
													</div>
													<?php } ?>
													<?php if ($row_empresa['Correios'] == 'S') { ?>
														<div class="col-md-3 mb-3 ">
														<div class="custom-control custom-radio">
															<input type="radio" name="tipofrete" class="custom-control-input " id="Correios" value="3" onclick="tipoFrete('3')">
															<label class="custom-control-label" for="Correios">Casa/Correios</label>
															<img src="../<?php echo $sistema ?>/arquivos/imagens/correios.png" class="img-responsive img-link Correios" width='150'>
														</div>
													</div>
													<?php } ?>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-12">		
													<h3 class="mb-3 Correios">Calcular Valor e Prazo de Entrega</h3>

													<h3 class="mb-3 Combinar">Cobinar a Entrega com o Vendedor</h3>
													
													<h3 class="mb-3 Retirada">Retirar o produto na Loja</h3>							
							
													<input type="hidden" name="RecarregaCepDestino" id="RecarregaCepDestino" value="<?php echo $row_empresa['CepEmpresa'];?>">
													<input type="hidden" name="RecarregaLogradouro" id="RecarregaLogradouro" value="<?php echo $row_empresa['EnderecoEmpresa'];?>">
													<input type="hidden" name="RecarregaNumero" id="RecarregaNumero" value="<?php echo $row_empresa['NumeroEmpresa'];?>">
													<input type="hidden" name="RecarregaComplemento" id="RecarregaComplemento" value="<?php echo $row_empresa['ComplementoEmpresa'];?>">
													<input type="hidden" name="RecarregaBairro" id="RecarregaBairro" value="<?php echo $row_empresa['BairroEmpresa'];?>">
													<input type="hidden" name="RecarregaCidade" id="RecarregaCidade" value="<?php echo $row_empresa['MunicipioEmpresa'];?>">
													<input type="hidden" name="RecarregaEstado" id="RecarregaEstado" value="<?php echo $row_empresa['EstadoEmpresa'];?>">
													<input type="hidden" name="RecarregaReferencia" id="RecarregaReferencia" value="<?php echo $row_empresa['ReferenciaEmpresa'];?>">
											
													<input type="hidden" name="CepOrigem" id="CepOrigem" placeholder="CepOrigem" value="<?php echo $row_empresa['CepEmpresa'];?>">
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
															<h5><?php echo utf8_encode($row_empresa['EnderecoEmpresa']);?>, <?php echo utf8_encode($row_empresa['NumeroEmpresa']);?> - <?php echo utf8_encode($row_empresa['ComplementoEmpresa']);?><br>
																<?php echo utf8_encode($row_empresa['BairroEmpresa']);?> - <?php echo utf8_encode($row_empresa['MunicipioEmpresa']);?> - <?php echo utf8_encode($row_empresa['EstadoEmpresa']);?><br>
																Cep: <?php echo $row_empresa['CepEmpresa'];?><br>.
																<?php echo utf8_encode($row_empresa['ReferenciaEmpresa']);?>
															</h5>
														</div>
													</div>
													
													<input type="hidden" name="PrazoPrdServ" id="PrazoPrdServ" value="<?php echo $prazo_carrinho;?>">
													<input type="hidden" name="PrazoCorreios" id="PrazoCorreios" value="">
													<input type="hidden" name="DataEntrega1" id="DataEntrega1" value="">
													
													<div class="row Desliga">
														<div class="col-md-3 mb-3 Desliga">
															<label class="Desliga">Cep</label>
															<input type="text" name="CepDestino" class="form-control Desliga Calcular" id="CepDestino" placeholder="CEP sem traço" maxlength="8" value="<?php echo $row_empresa['CepEmpresa'];?>" required>
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
																<button class=" form-control Correios Calcular btn btn-md btn-success" type="button" onclick="LoadFrete(); Procuraendereco(); Calcular()"  >Calcular</button>	
																<button class=" form-control Correios Recalcular btn btn-md btn-warning" type="button" onclick="Recalcular()"  >Recalcular</button>
															<?php } ?>
														</div>
														<div class="col-md-2 mb-3 Combinar">	
															<label class=" Combinar"></label><br>
															<a href="http://www.buscacep.correios.com.br/sistemas/buscacep/default.cfm" target="_blank">Não sei meu CEP!!</a>
														</div>
														<div class="col-md-5 mb-3 Combinar">	
															<label class=" Combinar"></label>
															<p class=" Combinar" style="color: blue">"A Forma, o Tempo e o Valor da Taxa de Entrega, serão informados no status do pedido, após a análise do endereço fornecido!"</p>
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
															<input type="text" class="Correios form-control"  name="valorfreteaparente" id="valorfreteaparente" placeholder="Valor do Frete" value="" readonly="">
															<input type="hidden" class="Correios form-control"  name="valorfrete" id="valorfrete" required>	
														</div>
														<div class="col-md-2 mb-3 Correios">
															<label class=" Correios">Total</label>
															<input type="text" class="form-control Desliga" id="valor_total_aparente" placeholder="Total" value="" readonly=""/>
															<input type="hidden" class="form-control Desliga" id="valor_total"/>
														</div>
														<div class="col-md-2 mb-3 Correios">	
															<label class=" Correios">Prazo(dias)</label>
															<span class="ResultadoPrecoPrazo Correios Desliga"></span>
															<input type="text" class="Correios form-control"  name="prazoentrega" id="prazoentrega" placeholder="Prazo" value="" readonly="" required>
														</div>
														<div class="col-md-2 mb-3 Correios">	
															<label class=" Correios">Data da Entrega</label>
															<input type="text" class="form-control Desliga"  name="dataaparente" id="dataaparente" placeholder="Data da entrega" value="" readonly="">
															<input type="hidden" class="form-control Desliga"  name="dataentrega" id="dataentrega">
														</div>
													</div>
													<div class="row Desliga">
														<div class="col-md-5 mb-3 Desliga">
															<label class="Desliga">Endereço</label>
															<input type="text" name="Logradouro" class="form-control Desliga" id="Logradouro" placeholder="Av. Rua" value="<?php echo $row_empresa['EnderecoEmpresa'];?>" required>
														</div>
														<div class="col-md-2 mb-3 Desliga">
															<label class="Desliga">Número</label>
															<input type="text" name="Numero" class="form-control Desliga" id="Numero" placeholder="Número" value="<?php echo $row_empresa['NumeroEmpresa'];?>" required>
														</div>
														<div class="col-md-5 mb-3 Desliga">
															<label class="Desliga">Complemento</label>
															<input type="text" name="Complemento" class="form-control Desliga" id="Complemento" placeholder="Complemento" value="<?php echo $row_empresa['ComplementoEmpresa'];?>">
														</div>							
													</div>
													<div class="row Desliga">
														<div class="col-md-5 mb-3 Desliga">
															<label class="Desliga">Bairro</label>
															<input type="text" name="Bairro" class="form-control Desliga" id="Bairro" placeholder="Bairro" value="<?php echo $row_empresa['BairroEmpresa'];?>" required>
														</div>
														<div class="col-md-5 mb-3 Desliga">
															<label class="Desliga">Cidade</label>
															<input type="text" name="Cidade" class="form-control Desliga" id="Cidade" placeholder="Cidade" value="<?php echo $row_empresa['MunicipioEmpresa'];?>" required>
														</div>
														<div class="col-md-2 mb-3 Desliga">
															<label class="Desliga">Estado</label>
															<select name="Estado" class="form-control Desliga" id="Estado" required>
																<option value="<?php echo $row_empresa['EstadoEmpresa'];?>"><?php echo $row_empresa['EstadoEmpresa'];?></option>
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
													<div class="row Desliga">
														<div class="col-md-12 mb-3 Desliga">
															<label class="Desliga">Referencia</label>
															<input type="text" name="Referencia" class="form-control Desliga" id="Referencia" placeholder="Ex. Ao lado da ...." value="<?php echo $row_empresa['ReferenciaEmpresa'];?>">
														</div>							
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-12 fundo-entrega-carrinho LocalFormaPag">
										<div class="col-lg-12 ">
											<div class="row">
												<div class="col-lg-12 ">	
													<h3 class="mb-3">Local e Forma do Pagamento</h3>
													<?php if ($row_empresa['NaLoja'] == 'S') { ?>
													<div class="col-md-3 mb-3 ">	
														<div class="custom-control custom-radio locpagloja">
															<input type="radio" name="localpagamento" class="custom-control-input "  id="NaLoja" value="V" onclick="localPagamento('V')"  >
															<label class="custom-control-label" for="NaLoja">Na Loja</label>
															<img src="../<?php echo $sistema ?>/arquivos/imagens/NaLoja.png" class="img-responsive img-link NaLoja" width='150'>
														</div>
													</div>
													<?php } ?>
													<?php if ($row_empresa['NaEntrega'] == 'S') { ?>
													<div class="col-md-3 mb-3 ">	
														<div class="custom-control custom-radio locpagcasa">
															<input type="radio" name="localpagamento" class="custom-control-input " id="NaEntrega" value="P" onclick="localPagamento('P')" >
															<label class="custom-control-label" for="NaEntrega">Na Casa </label>
															<img src="../<?php echo $sistema ?>/arquivos/imagens/NaEntrega.png" class="img-responsive img-link NaEntrega" width='150'>
														</div>
													</div>
													<?php } ?>
													<?php if ($row_empresa['OnLine'] == 'S') { ?>
														<div class="col-md-3 mb-3 ">
														<div class="custom-control custom-radio locpagonline">
															<input type="radio" name="localpagamento" class="custom-control-input " id="OnLine" value="O" onclick="localPagamento('O')">
															<label class="custom-control-label" for="OnLine">On Line</label>
															<img src="../<?php echo $sistema ?>/arquivos/imagens/OnLine.png" class="img-responsive img-link OnLine" width='150'>
														</div>
													</div>
													<?php } ?>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-12 ">
													<div class="col-md-6 mb-3 FormaPag">
														<label class="Desliga1">Forma de Pagamento</label>
														<select name="formapagamento" class="form-control Desliga1" id="FormaPagamento" required>
															<option class="CARTAO" value="1" >CARTAO</option>
															<option class="DEBITO" value="3">DEBITO</option>
															<option class="DINHEIRO" value="7">DINHEIRO</option>
															<option class="DEPOSITO" value="9">DEPOSITO/TRANSF.</option>
															<?php if ($row_empresa['TipoBoleto'] == 'L') { ?>
																<option class="BOLETODALOJA" value="11">BOLETO DA LOJA</option>
															<?php } elseif ($row_empresa['TipoBoleto'] == 'P') { ?>	
																<option class="BOLETOPAGSEGURO" value="2">BOLETO PAG SEGURO</option>
															<?php } ?>
															<option class="CHEQUE" value="8">CHEQUE</option>
															<option class="OUTROS" value="10">OUTROS</option>
															<!--<option value="SP" selected>SP</option>-->
														</select>
													</div>
													<div class="col-md-2 mb-3 FormaPag">
														<label class="Desliga1">Troco para:</label>
														<input type="text" name="ValorDinheiro" class="form-control Desliga1" id="ValorDinheiro" placeholder="Ex: 100" value="">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-12 fundo-entrega-carrinho finalizar2">
										<div class="col-lg-12 ">
											<div class="row">
												<div class="col-lg-12">							
													<div class="card card-outline-secondary my-4">								
														<div class="card-body">										
															<?php if(count($_SESSION['carrinho'.$_SESSION['id_Cliente'.$idSis_Empresa]]) > '0'){ ?>
																<?php if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ ?>
																	
																	<!--<input type="submit" id="botao" name="botao" class="btn btn-danger btn-block finalizar" value="Finalizar Pedido">-->
																	
																	<!--<input type="submit" class="btn btn-md btn-danger btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" value="Finalizar Pedido"/>-->
																	<button type="submit" class="btn btn-primary btn-lg btn-block finalizar"  name="btnComprar" id="btnComprar"> Finalizar Pedido </button>
																	<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
																		Aguarde um instante! Estamos processando sua solicitação!
																	</div>												
																
																<?php } else { ?>	
																	
																	<a href="login_cliente.php" class="btn btn-danger btn-block">Logar / Finalizar Pedido</a>
																
																<?php } ?>
															<?php } ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								
							<?php } ?>
						<?php } ?>
					</form>	
				</div>
			</div>
		</div>
	</section>

<?php } ?>						
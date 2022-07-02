<section id="service" class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="ser-title">Finalizar a Compra!</h2>
				<hr class="botm-line">
			</div>
			<div class="col-lg-12">
				
				<div class="row">
					
					<div class="col-md-5 order-md-2 mb-4">

						<ul class="list-group mb-3 ">										
							<li class="list-group-item d-flex justify-content-between fundo">
								<span>Pedido: </span>
								<strong>: <?php echo $id_pedido; ?></strong>
							</li>							
							
							<?php
								$read_produto = mysqli_query($conn, "
																	SELECT 
																		OT.idApp_OrcaTrata,
																		OT.ValorFrete,
																		OT.ValorOrca,
																		OT.ValorRestanteOrca,
																		OT.TipoFrete,
																		OT.TipoFretePagSeguro,
																		OT.Cep,
																		OT.Logradouro,
																		OT.Numero,
																		OT.Complemento,
																		OT.Bairro,
																		OT.Cidade,
																		OT.Estado,
																		AP.idApp_Produto,
																		AP.QtdProduto,
																		AP.ValorProduto,
																		AP.idApp_OrcaTrata,
																		AP.idTab_Produto,
																		TP.Produtos,
																		TP.idSis_Empresa,
																		TP.Arquivo,
																		TP.VendaSite,
																		TP.ValorProdutoSite
																	FROM 
																		App_OrcaTrata AS OT
																			LEFT JOIN App_Produto AS AP ON AP.idApp_OrcaTrata = OT.idApp_OrcaTrata
																			
																			LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = AP.idTab_Produto
																	WHERE 
																		OT.idApp_OrcaTrata = '".$id_pedido."'
																	ORDER BY 
																		AP.idApp_Produto ASC
																	");
								$total = '0';									
								if(mysqli_num_rows($read_produto) > '0'){
									foreach($read_produto as $read_produto_orca){
									$tipofrete = $read_produto_orca['TipoFrete'];
									$tipofretepagseguro = $read_produto_orca['TipoFretePagSeguro'];
									$frete = $read_produto_orca['ValorFrete']; 
									$valorfrete = number_format($frete, 2, '.', '');
									$valorestanterorca = $read_produto_orca['ValorRestanteOrca'];
									$valorprodutos = number_format($valorestanterorca, 2, '.', '');
									$total1 = $valorprodutos + $valorfrete;
									}
									$cont_item = 0;
									foreach($read_produto as $read_produto_view){
									$sub_total = $read_produto_view['ValorProduto'] * $read_produto_view['QtdProduto'];
									$total += $sub_total;
									$cont_item++;
									?>		
										<li class="list-group-item d-flex justify-content-between lh-condensed fundo">
											
												<div class="row img-prod-pag">	
													<div class="col-md-3 ">
														<img class="team-img img-circle img-responsive" src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produto_view['Arquivo']; ?>" alt="" width='50' >
													</div>														
													<div class="col-md-8 ">
														<div class="row">
															<h4 class="my-0"><?php echo utf8_encode ($read_produto_view['Produtos']);?></h4>
															<!--<small class="text-muted">Brief description</small>-->
														</div>
														<div class="row">	
															<span class="text-muted">Qtd. <?php echo $read_produto_view['QtdProduto'];?> x</span> 
															<span class="text-muted">R$ <?php echo number_format($read_produto_view['ValorProduto'],2,",",".");?> =</span> 
															<span class="text-muted">R$ <?php echo number_format($sub_total,2,",",".");?></span>																
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
								<strong>: <?php echo $cont_item; ?></strong>
							</li>
							
							<li class="list-group-item d-flex justify-content-between fundo">
								<span>Valor dos Produtos </span>
								<strong>R$ <?php echo number_format($valorestanterorca,2,",",".");?></strong>
							</li>
							<li class="list-group-item d-flex justify-content-between fundo">
								<span>Valor do Frete </span>
								<strong>R$ <?php echo number_format($read_produto_orca['ValorFrete'],2,",",".");?></strong>
							</li>
							<li class="list-group-item d-flex justify-content-between fundo">
								<span>Total </span>
								<strong>R$ <?php echo number_format($total1,2,",",".");?></strong>
							</li>
							<li class="list-group-item d-flex justify-content-between fundo">
								<span>Pagamento com Boleto, acréscimo de R$1,00 </span>
							</li>							
						</ul>
					</div>
					
					<div class="col-md-7 order-md-1 fundo">
						<span class="endereco" data-endereco="<?php echo URL; ?>"></span>
						
						<!-- colocar mensagem de alerta
						<div class="alert alert-warning" role="alert">
							<span id="msg"></span>
						</div>
						-->
						<span id="msg"></span>

						<form name="formPagamento" action="" id="formPagamento">
							
							<span id="msg"></span>
							
							<h3 class="mb-3">Escolha forma de pagamento</h3>
							
							<div class="row">
								<div class="col-md-4 mb-3 ">
									<div class="custom-control custom-radio">
										<input type="radio" name="paymentMethod" class="custom-control-input" id="boleto" value="boleto"  onclick="tipoPagamento('boleto')" checked>
										<label class="custom-control-label" for="boleto">Boleto</label>
										<img src="https://www.enkontraki.com.br/<?php echo $sistema ?>/arquivos/imagens/Boleto.png" class="img-responsive img-link boleto" width='150'>
									</div>
								</div>	
								<div class="col-md-4 mb-3 ">	
									<div class="custom-control custom-radio">
										<input type="radio" name="paymentMethod" class="custom-control-input" id="eft" value="eft" onclick="tipoPagamento('eft')">
										<label class="custom-control-label" for="eft">Débito Online</label>
										<img src="https://www.enkontraki.com.br/<?php echo $sistema ?>/arquivos/imagens/debitoonline.png" class="img-responsive img-link bankName" width='150'>
									</div>
								</div>	
								<div class="col-md-4 mb-3 ">	
									<div class="custom-control custom-radio">
										<input type="radio" name="paymentMethod" class="custom-control-input" id="creditCard" value="creditCard" onclick="tipoPagamento('creditCard')" >
										<label class="custom-control-label" for="creditCard">Cartão de Crédito</label>
										<img src="https://www.enkontraki.com.br/<?php echo $sistema ?>/arquivos/imagens/Cartao.png" class="img-responsive img-link creditCard" width='150'>
									</div>
								</div>	
							</div>
							<!-- Pagamento com débito online -->

							<h3 class="mb-3 bankName">Escolha o Banco</h3>
							
							<div class="mb-3 bankName">
								<label class="bankName">Banco</label>
								<select name="bankName" id="bankName" class="form-control select-bank-name bankName">
									
								</select>
							</div>
							
							<!-- Pagamento com cartão de crédito -->
							<h3 class="mb-3 creditCard">Dados do Cartão</h3>
							
							<input type="hidden" name="bandeiraCartao" id="bandeiraCartao" required>
							<input type="hidden" name="valorParcelas" id="valorParcelas">
							<input type="hidden" name="tokenCartao" id="tokenCartao">
							<input type="hidden" name="hashCartao" id="hashCartao">
							
							<div class="row creditCard">
								<div class="col-md-5 mb-3 creditCard">
									<label class="creditCard">Cartão *</label>
									<div class="input-group">
										<input type="text"  name="numCartao" id="numCartao" class="form-control" value="" required>
										<small class="form-text text-muted">
											Preencha para ver o parcelamento
										</small>											
									</div>
								</div>	
								<div class="col-md-2 mb-3 creditCard">	
									<label class="creditCard">Bandeira</label>
									<div class="input-group-prepend">
										<span class="input-group-text bandeira-cartao creditCard">   </span>
									</div>
								</div>
								<div class="col-md-5 mb-3 creditCard">
									<label class="creditCard">Quantidades de Parcelas</label>
									<select name="qntParcelas" id="qntParcelas" class="form-control select-qnt-parcelas creditCard" >
										
									</select>
								</div>
							</div>
							<div class="mb-3 creditCard">
								<label class="creditCard">Nome do titular</label>
								<input type="text" name="creditCardHolderName" class="form-control" id="creditCardHolderName" placeholder="Nome igual ao escrito no cartão" value="Jose Comprador" >
								<small id="creditCardHolderName" class="form-text text-muted">
									Como está gravado no cartão
								</small>
							</div>
							
							<div class="row creditCard">
								<div class="col-md-4 mb-3 creditCard">
									<label class="creditCard">Mês de Validade</label>
									<input type="text" name="mesValidade" id="mesValidade" maxlength="2" value=""  class="form-control creditCard" required>
								</div>
								<div class="col-md-4 mb-3 creditCard">
									<label class="creditCard">Ano de Validade</label>
									<input type="text" name="anoValidade" id="anoValidade" maxlength="4" value="" class="form-control creditCard" required>
								</div>
								<div class="col-md-4 mb-3 creditCard">                            
									<label class="creditCard">CVV do cartão</label>
									<input type="text" name="cvvCartao" id="cvvCartao" class="form-control creditCard"  maxlength="3" value="" required>
									<small id="cvvCartao" class="form-text text-muted creditCard">
										Código de 3 digitos 
									</small>
								</div>									
							</div>

							<div class="row creditCard">
								<div class="col-md-6 mb-3 creditCard">
									<label class="creditCard">CPF do dono do Cartão</label>
									<input type="text" name="creditCardHolderCPF" id="creditCardHolderCPF" placeholder="CPF sem traço" value="" class="form-control creditCard" required>
								</div>
								<div class="col-md-6 mb-3 creditCard">
									<label class="creditCard">Data de Nascimento</label>
									<input type="text" name="creditCardHolderBirthDate" id="creditCardHolderBirthDate" placeholder="Data de Nascimento. Ex: 12/12/1912" value="" class="form-control creditCard" required>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="row">
									<h3 class="mb-3">Dados do Comprador</h3>
									<div class="row">
										<div class="col-md-9 mb-3">
											<label>Nome</label>                            
											<input type="text" name="senderName" id="senderName" placeholder="Nome completo" value="<?php echo $row_cliente['NomeCliente']; ?>" class="form-control" required>
										</div>	
										<div class="col-md-3 mb-3">	
											<label>CPF</label>                            
											<input type="text" name="senderCPF" id="senderCPF" placeholder="CPF sem traço" value="<?php echo $row_cliente['CpfCliente']; ?>" class="form-control" required>
										</div>
									</div>
									<div class="mb-3">
										<label>E-mail</label>  
										<input type="email" name="senderEmail" id="senderEmail" placeholder="E-mail do comprador" value="c53501031513143960391@sandbox.pagseguro.com.br" class="form-control" required>                                                
									</div>
									<div class="row">
										<div class="col-md-3 mb-3">
											<label>DDD</label>
											<input type="text" name="senderAreaCode" id="senderAreaCode" placeholder="DDD" value="11" class="form-control" required>
										</div>
										<div class="col-md-9 mb-3">
											<label>Telefone</label>
											<input type="text" name="senderPhone" id="senderPhone" placeholder="Somente número" value="56273440" class="form-control" required>
										</div>
									</div>
								</div>
								<br>
							</div>

							<div class="col-lg-12 creditCard">
								<div class="row">
									<h3 class="mb-3">Endereço de Cobrança</h3>
									<div class="row ">
										<div class="col-lg-12">	
											<div class="col-md-6 mb-3 ">	
												<div class="custom-control custom-radio">
													<input type="radio" name="tipoendereco" class="custom-control-input"  id="EnderecoCadastrado" value="1" onclick="tipoEndereco('1')" checked>
													<label class="custom-control-label" for="EnderecoCadastrado">Endereço Cadastrado</label>
												</div>
											</div>											
											<div class="col-md-6 mb-3 ">	
												<div class="custom-control custom-radio">
													<input type="radio" name="tipoendereco" class="custom-control-input" id="OutroEndereco" value="2" onclick="tipoEndereco('2')" >
													<label class="custom-control-label" for="OutroEndereco">Outro Endereço</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<input type="hidden" name="RecarregaCepDestino" id="RecarregaCepDestino" value="<?php echo $_SESSION['Cep_Cliente'.$idSis_Empresa];?>">
								<input type="hidden" name="RecarregaLogradouro" id="RecarregaLogradouro" value="<?php echo $_SESSION['Endereco_Cliente'.$idSis_Empresa];?>">
								<input type="hidden" name="RecarregaNumero" id="RecarregaNumero" value="<?php echo $_SESSION['Numero_Cliente'.$idSis_Empresa];?>">
								<input type="hidden" name="RecarregaComplemento" id="RecarregaComplemento" value="<?php echo $_SESSION['Complemento_Cliente'.$idSis_Empresa];?>">
								<input type="hidden" name="RecarregaBairro" id="RecarregaBairro" value="<?php echo $_SESSION['Bairro_Cliente'.$idSis_Empresa];?>">
								<input type="hidden" name="RecarregaCidade" id="RecarregaCidade" value="<?php echo $_SESSION['Cidade_Cliente'.$idSis_Empresa];?>">
								<input type="hidden" name="RecarregaEstado" id="RecarregaEstado" value="<?php echo $_SESSION['Estado_Cliente'.$idSis_Empresa];?>">

								<div class="row">
									<!--<h3 class="mb-3 creditCard">Endereço do titular do cartão</h3>-->
									<div class="row creditCard">
										<div class="col-md-3 mb-3 creditCard">
											<label class="creditCard">CEP</label>
											<input type="text" name="billingAddressPostalCode" class="form-control creditCard" id="billingAddressPostalCode" placeholder="CEP sem traço"  maxlength="8" value="00000000" required>
										</div>
										<div class="col-md-3 mb-3 creditCard">	
											<label class=" creditCard">Buscar Endereço</label>
											<button class=" form-control creditCard" type="button" onclick="Procuraendereco();"  >Buscar Endereço</button>
										</div>
										
										<div class="col-md-3 mb-3 creditCard">	
											<label class=" creditCard"></label><br>
											<a href="http://www.buscacep.correios.com.br/sistemas/buscacep/default.cfm" target="_blank">Não sei meu CEP!!</a>
											<!--<div class="ResultCep"></div>-->
										</div>
									</div>
									<div class="row creditCard">
										<div class="col-md-9 mb-3 creditCard">
											<label class="creditCard">Endereço</label>
											<input type="text" name="billingAddressStreet" id="billingAddressStreet" placeholder="Av. Rua" value="nao informado" class="creditCard form-control" required>
										</div>                            
										<div class="col-md-3 mb-3 creditCard">
											<label class="creditCard">Número</label>
											<input type="text" name="billingAddressNumber" id="billingAddressNumber" placeholder="Número" value="nao informado" class="creditCard form-control" required>
										</div>
									</div>
									
									<div class="mb-3 creditCard">
										<label class="creditCard">Complemento</label>
										<input type="text" name="billingAddressComplement" id="billingAddressComplement" placeholder="Complemento" value="nao informado" class="creditCard form-control">
									</div>

									<div class="row creditCard">
										<div class="col-md-5 mb-3 creditCard">
											<label class="creditCard">Bairro</label>
											<input type="text" name="billingAddressDistrict" id="billingAddressDistrict" placeholder="Bairro" value="nao informado" class="creditCard form-control" required>
										</div>
										<div class="col-md-5 mb-3 creditCard">
											<label class="creditCard">Cidade</label>
											<input type="text" name="billingAddressCity" id="billingAddressCity" placeholder="Cidade" value="nao informado" class="creditCard form-control" required>
										</div>
										<div class="col-md-2 mb-3 creditCard">
											<label class="creditCard">Estado</label>
											<select name="billingAddressState" class="form-control creditCard" id="billingAddressState" required>
												<option value="">Selecione</option>
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
												<option value="RJ" selected>RJ</option>
												<option value="RN">RN</option>
												<option value="RS">RS</option>
												<option value="RO">RO</option>
												<option value="RR">RR</option>
												<option value="SC">SC</option>
												<option value="SP">SP</option>
												<option value="SE">SE</option>
												<option value="TO">TO</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<input type="hidden" name="billingAddressCountry" id="billingAddressCountry" value="BRL">
							
							<div class="col-lg-12 creditCard">
								<div class="row">
									<h5 class="mb-3">Deseja salvar, este endereço, no seu cadastro, para facilitar suas próximas compras?</h5>
									<div class="row ">
										<div class="col-lg-12">	
											<div class="col-md-2 mb-3 ">	
												<div class="custom-control custom-radio">
													<input type="radio" name="salvarinformacao" class="custom-control-input" value="2" checked>
													<label class="custom-control-label" for="Nao">Não</label>
												</div>
											</div>											
											<div class="col-md-2 mb-3 ">	
												<div class="custom-control custom-radio">
													<input type="radio" name="salvarinformacao" class="custom-control-input"  value="1">
													<label class="custom-control-label" for="Sim">Sim</label>
												</div>
											</div>
											<input type="hidden" name="idCliente" id="idCliente" value="<?php echo $_SESSION['id_Cliente'.$idSis_Empresa];?>">
										</div>
									</div>
								</div>							
							<br>
							</div>
							
							
							<h3 class="mb-3">Endereço de Entrega</h3>
							
							<input type="hidden" name="shippingAddressRequired" id="shippingAddressRequired" value="true">

							<input type="hidden" name="shippingAddressStreet" class="form-control" id="shippingAddressStreet" value="<?php echo $read_produto_orca['Logradouro'];?>" required>
							
							<input type="hidden" name="shippingAddressNumber" class="form-control" id="shippingAddressNumber" value="<?php echo $read_produto_orca['Numero'];?>"  required>

							<input type="hidden" name="shippingAddressComplement" class="form-control" id="shippingAddressComplement" value="<?php echo $read_produto_orca['Complemento'];?>">

							<input type="hidden" name="shippingAddressDistrict" class="form-control" id="shippingAddressDistrict" value="<?php echo $read_produto_orca['Bairro'];?>" required>

							<input type="hidden" name="shippingAddressCity" class="form-control" id="shippingAddressCity" value="<?php echo $read_produto_orca['Cidade'];?>" required>

							<input type="hidden" name="shippingAddressState" class="form-control" id="shippingAddressState" value="<?php echo $read_produto_orca['Estado'];?>" required>

							<input type="hidden" name="shippingAddressPostalCode" class="form-control" id="shippingAddressPostalCode" value="<?php echo $read_produto_orca['Cep'];?>" required>
							
							<div class="row">
								<div class="col-md-9 mb-3">
									<h5><?php echo $read_produto_orca['Logradouro'];?>, <?php echo $read_produto_orca['Numero'];?> - <?php echo $read_produto_orca['Complemento'];?><br>
										<?php echo $read_produto_orca['Bairro'];?> - <?php echo $read_produto_orca['Cidade'];?> - <?php echo $read_produto_orca['Estado'];?><br>
										Cep: <?php echo $read_produto_orca['Cep'];?>.
									</h5>
								</div>
							</div>							
							
							<!-- Moeda utilizada para pagamento -->
							<input type="hidden" name="shippingAddressCountry" id="shippingAddressCountry" value="BRL">
							
							<!-- 1 - PAC / 2 - SEDEX / 3 - Sem frete 
							<input type="hidden" name="shippingType" value="3">-->

							<input type="hidden" name="shippingCost" value="<?php echo $valorfrete; ?>">
							
							<input type="hidden" name="shippingType" value="<?php echo $tipofretepagseguro; ?>">

							<input type="hidden" name="receiverEmail" id="receiverEmail" value="<?php echo EMAIL_LOJA; ?>">
							
							<input type="hidden" name="currency" id="currency" value="<?php echo MOEDA_PAGAMENTO; ?>">
							
							<input type="hidden" name="notificationURL" id="notificationURL" value="<?php echo URL_NOTIFICACAO; ?>">

							<input type="hidden" name="reference" id="reference" value="<?php echo $id_pedido; ?>">
							
							<input type="hidden" name="amount" id="amount" value="<?php echo $total1; ?>">
							
							<!--<input type="hidden" name="hashCartao" id="hashCartao">-->
							
							<!--<input type="submit" name="btnComprar" id="btnComprar" value="Comprar">-->

							<hr class="mb-4">
							<button class="btn btn-primary btn-lg btn-block" type="submit" name="btnComprar" id="btnComprar"> Comprar </button>
							<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
								Aguarde um instante! Estamos processando sua solicitação!
							</div>							
							<br>
						</form>
					</div>
				</div>
			</div>				
		</div>
	</div>	
</section>

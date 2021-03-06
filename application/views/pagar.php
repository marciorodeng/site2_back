<section id="pagar" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h1 class="title-h1">Pagar Compra!</h1>
				<hr class="traco-h1">	
			</div>
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 order-lg-2 order-md-2 order-sm-2 mb-4 ">
				<ul class="list-group mb-3 ">
					<li class="list-group-item d-flex justify-content-between fundo">
						<span>Pedido: </span>
						<strong><?php echo $id_pedido; ?></strong>
					</li>							
					
					<?php
						$read_produto = mysqli_query($conn, "
															SELECT 
																OT.idApp_OrcaTrata,
																OT.ValorFrete,
																OT.CashBackOrca,
																OT.UsarCashBack,
																OT.ValorOrca,
																OT.ValorRestanteOrca,
																OT.TipoFrete,
																OT.FormaPagamento,
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
																AP.idTab_Produtos_Produto,
																AP.NomeProduto,
																TPS.Nome_Prod,
																TOP2.Opcao,
																TOP1.Opcao,
																CONCAT(TPS.Nome_Prod, ' - ' ,TOP2.Opcao, ' - ' ,TOP1.Opcao) AS Produtos,
																TPS.idSis_Empresa,
																TPS.Arquivo,
																TPS.VendaSite
															FROM 
																App_OrcaTrata AS OT
																	LEFT JOIN App_Produto AS AP ON AP.idApp_OrcaTrata = OT.idApp_OrcaTrata
																	LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = AP.idTab_Produtos_Produto
																	LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
																	LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2
															WHERE 
																OT.QuitadoOrca = 'N' AND
																OT.idApp_OrcaTrata = '".$id_pedido."' AND
																OT.idSis_Empresa = '".$idSis_Empresa."' AND
																OT.idApp_Cliente = '".$cliente."' 
															ORDER BY 
																AP.idApp_Produto ASC
															");
						$total = '0';
					
						$cont_orca = mysqli_num_rows($read_produto);

						if(isset($cont_orca) && $cont_orca > 0){
							
							foreach($read_produto as $read_produto_orca){
								$tipofrete = $read_produto_orca['TipoFrete'];
								$formapagamento = $read_produto_orca['FormaPagamento'];
								$tipofretepagseguro = $read_produto_orca['TipoFretePagSeguro'];
								
								$valorestanterorca = $read_produto_orca['ValorRestanteOrca'];
								$cashback = $read_produto_orca['CashBackOrca']; 
								$frete = $read_produto_orca['ValorFrete']; 

								$valorfrete = number_format($frete, 2, '.', '');
								$valorprodutos = number_format($valorestanterorca, 2, '.', '');
								$valorcashback = number_format($cashback, 2, '.', '');
								$total1 = $valorprodutos + $valorfrete - $valorcashback;

							}
							$cont_item = 0;
							foreach($read_produto as $read_produto_view){
								$sub_total = $read_produto_view['ValorProduto'] * $read_produto_view['QtdProduto'];
								$total += $sub_total;
								$cont_item++;
							?>		
								<li class="list-group-item d-flex justify-content-between lh-condensed fundo">
									
										
											<div class="container-2">
												<div class="col-xs-4  col-md-2 ">	
													<img class="team-img img-responsive" src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produto_view['Arquivo']; ?>" alt="" width='100' >
												</div>														
												<div class="col-xs-8 col-md-8 ">	
													<div class="row">
														<h5 class="my-0"><?php echo utf8_encode ($read_produto_view['NomeProduto']);?></h5>
														<!--<small class="text-muted">Brief description</small>-->
													</div>
													<div class="row">	
														<!--<span class="text-muted">R$ <?php #echo number_format($read_produto_view['ValorProduto'],2,",",".");?> x </span>--> 
														<span class="text-muted"><?php echo $read_produto_view['QtdProduto'];?> Un. </span>
														<span class="text-muted">R$<?php echo number_format($sub_total,2,",",".");?></span>																
													</div>
												</div>
											</div>	
										
										
								</li>
							<?php
							}
						}else{
							echo "<script>window.location = 'index.php'</script>";
							exit();
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
						<span>CashBack </span>
						<strong>R$ <?php echo number_format($read_produto_orca['CashBackOrca'],2,",",".");?></strong>
					</li>
					<li class="list-group-item d-flex justify-content-between fundo">
						<span>Total </span>
						<strong>R$ <?php echo number_format($total1,2,",",".");?></strong>
					</li>
					<li class="list-group-item d-flex justify-content-between fundo">
						<span>Pagamento com Boleto, acr??scimo de R$1,00 </span>
					</li>							
				</ul>
			</div>
			<?php if ($row_empresa['Boleto'] == 'S' || $row_empresa['Debito'] == 'S' || $row_empresa['Cartao'] == 'S') { ?>
				<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 order-lg-1 order-md-1 order-sm-1 mb-4 fundo">
					<div class="list-group mb-3">
						
						<span class="endereco" data-endereco="<?php echo URL; ?>"></span>
						
						<!-- colocar mensagem de alerta
						<div class="alert alert-warning" role="alert">
							<span id="msg"></span>
						</div>
						
						<span id="msg"></span>
						-->
						<form name="formPagamento" action="" id="formPagamento">
							
							<h3 class="mb-3">Dados do Comprador</h3>
							<div class="row">
								<div class="col-md-9 mb-3">
									<label>Nome</label>                            
									<input type="text" name="senderName" id="senderName" placeholder="Nome completo" value="<?php echo $row_cliente['NomeCliente']; ?>" class="form-control" required>
								</div>	
								<div class="col-md-3 mb-3">	
									<label>CPF</label>                            
									<input type="text" name="senderCPF" id="senderCPF" placeholder="Ex: 99999999999" maxlength="11" value="<?php echo $row_cliente['CpfCliente']; ?>" class="form-control CPF" required>
								</div>
							</div>
							<div class="mb-3">
								<label>E-mail</label>  
								<input type="email" name="senderEmail" id="senderEmail" placeholder="E-mail do comprador" value="<?php echo $row_cliente['Email']; ?>" class="form-control" required>                                                
							</div>
							<div class="row">
								<div class="col-md-3 mb-3">
									<label>DDD</label>
									<input type="text" name="senderAreaCode" id="senderAreaCode" placeholder="Ex: 99" maxlength="2" value="" class="form-control DDD" required>
								</div>
								<div class="col-md-9 mb-3">
									<label>Celular</label>
									<input type="text" name="senderPhone" id="senderPhone" placeholder="Ex: 999999999" maxlength="9" value="" class="form-control senderCelular" required>
								</div>
							</div>
								
							
							<h3 class="mb-3">Endere??o de Entrega</h3>
							
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
									<h5><?php echo utf8_encode($read_produto_orca['Logradouro']);?>, <?php echo utf8_encode($read_produto_orca['Numero']);?> - <?php echo utf8_encode($read_produto_orca['Complemento']);?><br>
										<?php echo utf8_encode($read_produto_orca['Bairro']);?> - <?php echo utf8_encode($read_produto_orca['Cidade']);?> - <?php echo utf8_encode($read_produto_orca['Estado']);?><br>
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
							<?php if ($row_documento['Ativo_Pagseguro'] == 'S') { ?>
								
								<h3 class="mb-3">Confirme a forma de pagamento</h3>
								
								<div class="row">
									<?php if ($row_empresa['Boleto'] == 'S' && $formapagamento == '2') { ?>
										<div class="col-md-4 mb-3 ">
											<div class="custom-control custom-radio">
												<input type="radio" name="paymentMethod" class="custom-control-input" id="boleto" value="boleto"  onclick="tipoPagamento('boleto')">
												<label class="custom-control-label" for="boleto">Boleto</label>
												<img src="../<?php echo $sistema ?>/arquivos/imagens/Boleto.png" class="img-responsive img-link boleto" width='150'>
											</div>
										</div>
									
									<?php }elseif ($row_empresa['Debito'] == 'S' && $formapagamento == '3') { ?>
										<div class="col-md-4 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="paymentMethod" class="custom-control-input" id="eft" value="eft" onclick="tipoPagamento('eft')">
												<label class="custom-control-label" for="eft">D??bito Online</label>
												<img src="../<?php echo $sistema ?>/arquivos/imagens/debitoonline.png" class="img-responsive img-link bankName" width='150'>
											</div>
										</div>
									
									<?php }elseif ($row_empresa['Cartao'] == 'S' && $formapagamento == '1') { ?>
										<div class="col-md-4 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="paymentMethod" class="custom-control-input" id="creditCard" value="creditCard" onclick="tipoPagamento('creditCard')" >
												<label class="custom-control-label" for="creditCard">Cart??o de Cr??dito</label>
												<img src="../<?php echo $sistema ?>/arquivos/imagens/Cartao.png" class="img-responsive img-link creditCard" width='150'>
											</div>
										</div>
									<?php } ?>
								</div>
								<!-- Pagamento com d??bito online -->

								<h3 class="mb-3 bankName">Escolha o Banco</h3>
								
								<div class="mb-3 bankName">
									<label class="bankName">Banco</label>
									<select name="bankName" id="bankName" class="form-control select-bank-name bankName">
										
									</select>
								</div>
								
								<!-- Pagamento com cart??o de cr??dito -->
								<h3 class="mb-3 creditCard">Dados do Cart??o</h3>
								
								<input type="hidden" name="bandeiraCartao" id="bandeiraCartao" required>
								<input type="hidden" name="valorParcelas" id="valorParcelas">
								<input type="hidden" name="tokenCartao" id="tokenCartao">
								<input type="hidden" name="hashCartao" id="hashCartao">
								
								<div class="row creditCard">
									<div class="col-md-5 mb-3 creditCard">
										<label class="creditCard">Cart??o *</label>
										<div class="input-group">
											<input type="text"  name="numCartao" id="numCartao" class="form-control" maxlength="16" value="" required>
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
									<input type="text" name="creditCardHolderName" class="form-control" id="creditCardHolderName" placeholder="Nome igual ao escrito no cart??o" value="Jose Comprador" >
									<small class="form-text text-muted">
										Como est?? gravado no cart??o
									</small>
								</div>
								
								<div class="row creditCard">
									<div class="col-md-4 mb-3 creditCard">
										<label class="creditCard">M??s de Validade</label>
										<input type="text" name="mesValidade" id="mesValidade" placeholder="Ex: 99" maxlength="2" value=""  class="form-control creditCard" required>
									</div>
									<div class="col-md-4 mb-3 creditCard">
										<label class="creditCard">Ano de Validade</label>
										<input type="text" name="anoValidade" id="anoValidade" placeholder="Ex: 9999" maxlength="4" value="" class="form-control creditCard" required>
									</div>
									<div class="col-md-4 mb-3 creditCard">                            
										<label class="creditCard">CVV do cart??o</label>
										<input type="text" name="cvvCartao" id="cvvCartao" placeholder="Ex: 999" maxlength="3" value="" class="form-control creditCard" required>
										<small class="form-text text-muted creditCard">
											C??digo de 3 digitos 
										</small>
									</div>									
								</div>

								<div class="row creditCard">
									<div class="col-md-6 mb-3 creditCard">
										<label class="creditCard">CPF do dono do Cart??o</label>
										<input type="text" name="creditCardHolderCPF" id="creditCardHolderCPF" placeholder="Ex: 99999999999" maxlength="11" value="" class="form-control creditCard" required>
									</div>
									<div class="col-md-6 mb-3 creditCard">
										<label class="creditCard">Data de Nascimento</label>
										<input type="text" name="creditCardHolderBirthDate" id="creditCardHolderBirthDate" placeholder="Ex: 12/12/1912" value="" class="form-control Date creditCard" required>
									</div>
								</div>

								<div class="col-lg-12 creditCard">
									<div class="row">
										<h3 class="mb-3">Endere??o de Cobran??a</h3>
										<div class="row ">
											<div class="col-lg-12">	
												<div class="col-md-6 mb-3 ">	
													<div class="custom-control custom-radio">
														<input type="radio" name="tipoendereco" class="custom-control-input"  id="EnderecoCadastrado" value="1" onclick="tipoEndereco('1')" checked>
														<label class="custom-control-label" for="EnderecoCadastrado">Endere??o Cadastrado</label>
													</div>
												</div>											
												<div class="col-md-6 mb-3 ">	
													<div class="custom-control custom-radio">
														<input type="radio" name="tipoendereco" class="custom-control-input" id="OutroEndereco" value="2" onclick="tipoEndereco('2')" >
														<label class="custom-control-label" for="OutroEndereco">Outro Endere??o</label>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<input type="hidden" name="RecarregaCepDestino" id="RecarregaCepDestino" value="<?php echo $_SESSION['Site_Back']['Cep_Cliente'.$idSis_Empresa];?>">
									<input type="hidden" name="RecarregaLogradouro" id="RecarregaLogradouro" value="<?php echo $_SESSION['Site_Back']['Endereco_Cliente'.$idSis_Empresa];?>">
									<input type="hidden" name="RecarregaNumero" id="RecarregaNumero" value="<?php echo $_SESSION['Site_Back']['Numero_Cliente'.$idSis_Empresa];?>">
									<input type="hidden" name="RecarregaComplemento" id="RecarregaComplemento" value="<?php echo $_SESSION['Site_Back']['Complemento_Cliente'.$idSis_Empresa];?>">
									<input type="hidden" name="RecarregaBairro" id="RecarregaBairro" value="<?php echo $_SESSION['Site_Back']['Bairro_Cliente'.$idSis_Empresa];?>">
									<input type="hidden" name="RecarregaCidade" id="RecarregaCidade" value="<?php echo $_SESSION['Site_Back']['Cidade_Cliente'.$idSis_Empresa];?>">
									<input type="hidden" name="RecarregaEstado" id="RecarregaEstado" value="<?php echo $_SESSION['Site_Back']['Estado_Cliente'.$idSis_Empresa];?>">

									<div class="row">
										<!--<h3 class="mb-3 creditCard">Endere??o do titular do cart??o</h3>-->
										<div class="row creditCard">
											<div class="col-md-3 mb-3 creditCard">
												<label class="creditCard">CEP</label>
												<input type="text" name="billingAddressPostalCode" class="form-control creditCard" id="billingAddressPostalCode" placeholder="CEP sem tra??o"  maxlength="8" value="00000000" required>
											</div>
											<div class="col-md-3 mb-3 creditCard">	
												<label class=" creditCard">Buscar Endere??o</label>
												<button class=" form-control creditCard" type="button" onclick="Procuraendereco();"  >Buscar Endere??o</button>
											</div>
											
											<div class="col-md-3 mb-3 creditCard">	
												<label class=" creditCard"></label><br>
												<a href="http://www.buscacep.correios.com.br/sistemas/buscacep/default.cfm" target="_blank">N??o sei meu CEP!!</a>
												<!--<div class="ResultCep"></div>-->
											</div>
										</div>
										<div class="row creditCard">
											<div class="col-md-9 mb-3 creditCard">
												<label class="creditCard">Endere??o</label>
												<input type="text" name="billingAddressStreet" id="billingAddressStreet" placeholder="Av. Rua" value="nao informado" class="creditCard form-control" required>
											</div>                            
											<div class="col-md-3 mb-3 creditCard">
												<label class="creditCard">N??mero</label>
												<input type="text" name="billingAddressNumber" id="billingAddressNumber" placeholder="N??mero" value="nao informado" class="creditCard form-control" required>
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
										<h5 class="mb-3">Deseja salvar, este endere??o, no seu cadastro, para facilitar suas pr??ximas compras?</h5>
										<div class="row ">
											<div class="col-lg-12">	
												<div class="col-md-2 mb-3 ">	
													<div class="custom-control custom-radio">
														<input type="radio" name="salvarinformacao" class="custom-control-input" value="2" checked>
														<label class="custom-control-label" for="Nao">N??o</label>
													</div>
												</div>											
												<div class="col-md-2 mb-3 ">	
													<div class="custom-control custom-radio">
														<input type="radio" name="salvarinformacao" class="custom-control-input"  value="1">
														<label class="custom-control-label" for="Sim">Sim</label>
													</div>
												</div>
												<input type="hidden" name="idCliente" id="idCliente" value="<?php echo $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];?>">
											</div>
										</div>
									</div>							
									<br>
								</div>
								
								<!--<input type="submit" name="btnComprar" id="btnComprar" value="Comprar">-->
								<hr class="mb-4">
									
								<span id="msg"></span>
								<button class="btn btn-primary btn-lg btn-block comprar" type="submit" name="btnComprar" id="btnComprar"> Pagar </button>
								
								<div class="col-lg-12 alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
									Aguarde um instante! Estamos processando sua solicita????o!
								</div>
							<?php }else{ ?>	
								<h3 class="mb-3">O pagamento pelo PagSeguro n??o est?? ativo nesta empresa!</h3>
							<?php } ?>
							<br>
						</form>
					</div>	
				</div>
			<?php } ?>
		</div>
	</div>
</section>

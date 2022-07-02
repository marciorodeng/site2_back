
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

		}else{
			echo "<script>window.location = 'index.php'</script>";
			exit();
		} 
	?>
	<input type="hidden" id="id_empresa" value="<?php echo $idSis_Empresa;?>">
	<section id="entrega" class="col-md-12 col-sm-12 col-xs-12">
		<div class="container">	
			<div class="row">		
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<h1 class="title-h1">Entrega & Pagamento!</h1>
					<hr class="traco-h1">
				</div>
			</div>	
			<form name="FormularioEntrega" id="FormularioEntrega" method="post" action="finalizar_pedido.php" >
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  fundo-carrinho">	
					<ul class="list-group mb-3 ">										
						<?php
							$total_venda = '0';
							$total_peso = '0';
							$total_produtos = '0';
							$item_carrinho = '0';
							$prazo_carrinho = '0';
							if(count($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]) > '0'){
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
										<div class="row ">
											<div class="col-md-4">
												<div class="row ">
													<div class="container-2">
														<div class="col-xs-4 col-md-4">
															<div class="row ">	
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
																	<span class="card-title" style="color: #000000"><?php echo utf8_encode ($read_produto_carrinho_view['Nome_Prod']);?><br> 
																							<?php echo utf8_encode ($read_produto_carrinho_view['Convdesc']);?><br>
																							<?php echo utf8_encode ($read_produto_carrinho_view['Produtos_Descricao']);?>
																	</span>
																</div>
															</div>															
														</div>
													</div>
												</div>	
											</div>	
											<div class="col-md-6">
												<div class="row ">
													<div class="container-2">
														<div class="col-xs-4 col-md-1"></div>
														<div class="col-xs-4 col-md-5 ">		
															<div class="row ">
																<div class="col-md-12 ">
																	<span class="card-title" style="color: #000000"><span id="Qtd<?php echo $item_carrinho;?>"  name="prod[<?php echo $id_produto_carrinho ?>]" value="" ><?php echo $sub_total_qtd_produto ?> un.</span><span class="text-muted"></span></span> 
																</div>														
															</div>
														</div>	
														<div class="col-xs-4 col-md-6 ">		
															<div class="row ">	
																<div class="col-md-12 ">
																	<span class="card-title" style="color: #000000">R$<span id="Subtotal<?php echo $item_carrinho;?>" ><?php echo number_format($sub_total_produto_carrinho,2,",",".");?></span></span> 
																</div>														
															</div>
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
							<strong>: <span  name="PCount" id="PCount" value="<?php echo $item_carrinho; ?>"><?php echo $item_carrinho; ?></span></strong>
						</li>
						<?php if($item_carrinho > 0) { ?>
							<li class="list-group-item d-flex justify-content-between fundo">
								<span>Total Produtos </span>
								<strong>: <span  name="TotalProd" id="TotalProd"><?php echo $total_produtos;?> Unid.</span></strong>
							</li>
							<li class="list-group-item d-flex justify-content-between fundo">
								<span>Valor do Pedido </span>
								<strong>: R$ <span><?php echo $total;?></span></strong>
							</li>
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
									<strong>: R$ <span><?php echo $cashtotal_visao;?></span></strong>
								</li>
								<li class="list-group-item d-flex justify-content-between fundo">
									<span>Validade do CashBack </span>
									<strong>: <span><?php echo $validade_visao;?></span></strong>
								</li>
							<?php } ?>	
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
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 ">
							
							<textarea type="text" name="Descricao" class="form-control " id="Descricao" placeholder="Observações do Pedido:" value=""></textarea>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-8 col-lg-8 ">	
							<div class="row">
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 card-body text-left">
									<br>
									<a href="produtos.php" class="btn btn-block btn-success">Adicionar Produto</a>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 card-body text-left">
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
					<br>
				</div>
				<?php if($total_venda >= $row_empresa['ValorMinimo']){ ?>
					<?php if ($row_empresa['RetirarLoja'] == 'S' || $row_empresa['MotoBoy'] == 'S' || $row_empresa['Correios'] == 'S') { ?>
						
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fundo-entrega-carrinho">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
									<div class="row">
										<h3 class="mb-3">Forma de Entrega & Local</h3>
										<div class="row">
											<?php if ($row_empresa['RetirarLoja'] == 'S') { ?>
											<div class="col-xs-4  col-sm-3  col-md-3 col-lg-3">	
												<div class="custom-control custom-radio">
													<input type="radio" name="tipofrete" class="custom-control-input "  id="Retirada" value="1" onclick="tipoFrete('1')" >
													<label class="custom-control-label" for="Retirada">Retirar na Loja</label>
													<img src="../<?php echo $sistema ?>/arquivos/imagens/loja.png" class="img-responsive img-link Retirada" width='150'>
												</div>
											</div>
											<?php } ?>
											<?php if ($row_empresa['MotoBoy'] == 'S') { ?>
											<div class="col-xs-4  col-sm-3  col-md-3 col-lg-3">	
												<div class="custom-control custom-radio">
													<input type="radio" name="tipofrete" class="custom-control-input " id="Combinar" value="2" onclick="tipoFrete('2')" >
													<label class="custom-control-label" for="Combinar">Casa/ Loja </label>
													<img src="../<?php echo $sistema ?>/arquivos/imagens/combinar.png" class="img-responsive img-link Combinar" width='150'>
												</div>
											</div>
											<?php } ?>
											<?php if ($row_empresa['Correios'] == 'S') { ?>
											<div class="col-xs-4  col-sm-3  col-md-3 col-lg-3">
												<div class="custom-control custom-radio">
													<input type="radio" name="tipofrete" class="custom-control-input " id="Correios" value="3" onclick="tipoFrete('3')">
													<label class="custom-control-label" for="Correios">Casa/ Correios</label>
													<img src="../<?php echo $sistema ?>/arquivos/imagens/correios.png" class="img-responsive img-link Correios" width='150'>
												</div>
											</div>
											<?php } ?>
										</div>	
										<input type="hidden" id="Hidden_tipofrete">
									</div>
									<div class="row">
										<div class="row">	
											<div class="col-lg-12">		
												<h3 class="mb-3 Correios">Calcular Valor e Prazo de Entrega</h3>

												<h3 class="mb-3 Combinar">Cobinar Entrega com o Vendedor</h3>
												
												<h3 class="mb-3 Retirada">Retirar na Loja</h3>							
						
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
												<div class="row Desliga">
													<div class="col-md-3 mb-3 Desliga">
														<label class="Desliga">Cep</label>
														<input type="text" name="CepDestino" class="form-control Desliga Calcular Cep" id="CepDestino" placeholder="CEP sem traço" maxlength="8" value="<?php echo $row_empresa['CepEmpresa'];?>" required>
														<input type="text" name="Cep" class="form-control Correios Desliga Recalcular Cep" id="Cep" readonly="" value="" required>
													</div>
													<div class="col-md-2 mb-3 Combinar">	
														<label class=" Combinar">Buscar End.</label>
														<button class=" form-control Combinar" type="button" onclick="Procuraendereco()"  >Buscar</button>
													</div>
													<div class="col-md-2 mb-3 Correios">	
														<label class=" Correios Calcular">Calcula Frete.</label>
														<label class=" Correios Recalcular">Recalcular Frete.</label>
														<?php if(count($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]) > '0'){ ?>	
															<button class=" form-control Correios Calcular btn btn-md btn-success" type="button" onclick="Procuraendereco(); Calcular()"  >Calcular</button>	
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
														<?php if(count($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]) > '0'){ ?>
															<select class="form-control Correios" name="Codigo" id="Codigo" readonly="" onchange="Limpar(); Procuraendereco()">
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
														<label class=" Correios">Valor Total</label>
														<input type="text" class="form-control Desliga" id="valor_total_aparente" placeholder="Total" value="" readonly=""/>
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
										
									<div class="col-lg-12 ExibirCashBack ">
										<div class="row ">	
											<div class="row ">
												<?php 
													if((isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa]) 
														&& isset($_SESSION['Site_Back']['Nivel_Usuario_vend'.$idSis_Empresa])
														&& $_SESSION['Site_Back']['Nivel_Usuario_vend'.$idSis_Empresa] == 2)
														OR (isset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa]) 
														&& isset($_SESSION['Site_Back']['Nivel_Vendedor'.$idSis_Empresa])
														&& $_SESSION['Site_Back']['Nivel_Vendedor'.$idSis_Empresa] == 2)){ 
												?>
													<input type="hidden" name="UsarCupom"  value="N" >
												<?php } else { ?>
													<div class="row ">
														<div class="col-xs-12  col-sm-4  col-md-3 col-lg-3">	
															<h4 class="">Usar Cupom?</h4>
															<div class="row ">	
																<div class="col-xs-6  col-sm-6  col-md-6 col-lg-6">
																	<input type="radio" name="UsarCupom" class="custom-control-input"  value="N" onclick="usarcupom(this.value)" checked>
																	<label class="custom-control-label" for="Nao">Não</label>
																</div>											
																<div class="col-xs-6  col-sm-6  col-md-6 col-lg-6">		
																	<input type="radio" name="UsarCupom" class="custom-control-input"  value="S" onclick="usarcupom(this.value)">
																	<label class="custom-control-label" for="Sim">Sim</label>
																</div>
															</div>
														</div>
													</div>
												<?php } ?>
												<div class="row UsarCupom">	
													<div class="col-xs-12  col-sm-4  col-md-3 col-lg-3">
														<label for="Cupom" style="color: #000000">Cupom <span id="CodigoCupom"></span> </label><br>
														<div class="input-group">
															<span class="input-group-addon">Nº</span>
															<input type="text" class="form-control" onkeyup="cupom(this.value)" name="Cupom" id="Cupom" style="color: #000000" value="">
														</div>
													</div>
													<div class="col-xs-12  col-sm-4  col-md-3 col-lg-3">
														<label for="Hidden_ValorCupom" style="color: #000000">Valor Cupom</label><br>
														<div class="input-group">
															<span class="input-group-addon"><span id="Hidden_TipoDescOrca" style="color: #000000"></span></span>
															<input type="text" class="form-control" name="Hidden_ValorCupom" id="Hidden_ValorCupom" style="color: #000000" value="" readonly="">
														</div>
													</div>
												</div>
												<h3 class="UsarCupom" id="Hidden_MensagemCupom" ></h3>
											</div>
											<div class="row ">
												<?php 
													if((isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa]) 
														&& isset($_SESSION['Site_Back']['Nivel_Usuario_vend'.$idSis_Empresa])
														&& $_SESSION['Site_Back']['Nivel_Usuario_vend'.$idSis_Empresa] == 2)
														OR (isset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa]) 
														&& isset($_SESSION['Site_Back']['Nivel_Vendedor'.$idSis_Empresa])
														&& $_SESSION['Site_Back']['Nivel_Vendedor'.$idSis_Empresa] == 2)){ 
												?>
													<input type="hidden" name="UsarCashBack"  value="N" >
												<?php } else { ?>
													<div class="row ">
														<div class="col-xs-12  col-sm-4  col-md-3 col-lg-3">	
															<h4 class="">Usar CashBack?</h4>
															<div class="row ">	
																<div class="col-xs-6  col-sm-6  col-md-6 col-lg-6">	
																	<input type="radio" name="UsarCashBack" class="custom-control-input"  value="N" onclick="usarcashback(this.value)" checked>
																	<label class="custom-control-label" for="Nao">Não</label>
																</div>											
																<div class="col-xs-6  col-sm-6  col-md-6 col-lg-6">		
																	<input type="radio" name="UsarCashBack" class="custom-control-input"  value="S" onclick="usarcashback(this.value)">
																	<label class="custom-control-label" for="Sim">Sim</label>
																</div>
															</div>
														</div>
													</div>
												<?php } ?>
												<div class="row ">
													<div class="col-xs-12  col-sm-4  col-md-3 col-lg-3 UsarCashBack">
														<label style="color: #000000">Valor CashBack</label><br>
														<div class="input-group">
															<span class="input-group-addon"style="color: #000000">R$</span>
															<input type="text" class="form-control" style="color: #000000" value="<?php echo $cashtotal_visao;?>" readonly="">
														</div>
													</div>
													<div class="col-xs-12  col-sm-4  col-md-3 col-lg-3">
														<label style="color: #000000">Valor Final</label><br>
														<div class="input-group">
															<span class="input-group-addon"style="color: #000000">R$</span>
															<input type="text" class="form-control" name="ValorFinalOrca" id="ValorFinalOrca" style="color: #000000" value="<?php echo $total;?>" readonly="">
														</div>
													</div>
												</div>
											</div>
										</div>	
									</div>
									<input type="hidden" name="Hidden_TipoFrete" id="Hidden_TipoFrete" value="1">	
									<input type="hidden" name="Hidden_UsarCupom" id="Hidden_UsarCupom" value="N">
									<input type="hidden" name="Hidden_UsarCashBack" id="Hidden_UsarCashBack" value="N">	
									<input type="hidden" name="idCliente" id="idCliente" value="<?php echo $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];?>">
									<input type="hidden" name="ValorTotal" id="ValorTotal" value="<?php echo $total;?>">
									<input type="hidden" name="ValorCashBack" id="ValorCashBack" value="<?php echo $cashtotal_visao;?>">
									<input type="hidden" name="PrazoPrdServ" id="PrazoPrdServ" value="<?php echo $prazo_carrinho;?>">
									<input type="hidden" name="PrazoCorreios" id="PrazoCorreios" value="0">
									<input type="hidden" name="DataEntrega1" id="DataEntrega1" value="">
									<input type="hidden" name="DataEntrega2" id="DataEntrega2" value="">
									<input type="hidden" name="valor_total" id="valor_total" value="0">
									<input type="hidden" name="TipoDescOrca" id="TipoDescOrca" value="V">
									<input type="hidden" name="ValorCupom" id="ValorCupom" value="0">
									<input type="hidden" name="ValidaCupom" id="ValidaCupom" value="0">
									<input type="hidden" name="SubValorFinal" id="SubValorFinal" value="0">
									<input type="hidden" name="DescPercOrca" id="DescPercOrca" value="0" style="color: #000000">
									<input type="hidden" name="DescValorOrca" id="DescValorOrca" value="0" style="color: #000000">
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fundo-entrega-carrinho LocalFormaPag">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
									<div class="row">
										<h3 class="mb-3">Forma de Pagamento & Local</h3>
										<div class="row">
											<?php if ($row_empresa['NaLoja'] == 'S') { ?>
											<div class="col-xs-4  col-sm-3  col-md-3 col-lg-3">	
												<div class="custom-control custom-radio locpagloja">
													<input type="radio" name="localpagamento" class="custom-control-input "  id="NaLoja" value="V" onclick="localPagamento('V')"  >
													<label class="custom-control-label" for="NaLoja">Na Loja</label>
													<img src="../<?php echo $sistema ?>/arquivos/imagens/NaLoja.png" class="img-responsive img-link NaLoja" width='150'>
												</div>
											</div>
											<?php } ?>
											<?php if ($row_empresa['NaEntrega'] == 'S') { ?>
											<div class="col-xs-4  col-sm-3  col-md-3 col-lg-3">	
												<div class="custom-control custom-radio locpagcasa">
													<input type="radio" name="localpagamento" class="custom-control-input " id="NaEntrega" value="P" onclick="localPagamento('P')" >
													<label class="custom-control-label" for="NaEntrega">Na Casa </label>
													<img src="../<?php echo $sistema ?>/arquivos/imagens/NaEntrega.png" class="img-responsive img-link NaEntrega" width='150'>
												</div>
											</div>
											<?php } ?>
											<?php if ($row_empresa['OnLine'] == 'S') { ?>
											<div class="col-xs-4  col-sm-3  col-md-3 col-lg-3">
												<div class="custom-control custom-radio locpagonline">
													<input type="radio" name="localpagamento" class="custom-control-input " id="OnLine" value="O" onclick="localPagamento('O')">
													<label class="custom-control-label" for="OnLine">On Line</label>
													<img src="../<?php echo $sistema ?>/arquivos/imagens/OnLine.png" class="img-responsive img-link OnLine" width='150'>
												</div>
											</div>
											<?php } ?>
										</div>
									</div>
									<input type="hidden" id="Hidden_localpagamento">
									<input type="hidden" id="Hidden_Ativo_Pagseguro" value="<?php echo $row_documento['Ativo_Pagseguro'];?>">
									<br>
									<div class="row">
										<div class="row">	
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 FormaPag">
												<label class="Desliga1">Pagamento</label>
												<select name="formapagamento" class="form-control Desliga1" id="FormaPagamento" required>
													<option class="CARTAO" value="1" >CARTAO</option>
													<option class="DEBITO" value="3">DEBITO</option>
													<option class="DINHEIRO" value="7">DINHEIRO</option>
													<option class="DEPOSITO" value="9">DEPOSITO/TRANSF/PIX</option>
													<?php if ($row_empresa['Boleto'] == 'S') { ?>
														<?php if ($row_empresa['TipoBoleto'] == 'L') { ?>
															<option class="BOLETODALOJA" value="11">BOLETO DA LOJA</option>
														<?php } elseif ($row_empresa['TipoBoleto'] == 'P') { ?>	
															<option class="BOLETOPAGSEGURO" value="2">BOLETO PAG SEGURO</option>
														<?php } ?>
													<?php } ?>	
													<option class="CHEQUE" value="8">CHEQUE</option>
													<option class="OUTROS" value="10">OUTROS</option>
													<!--<option value="SP" selected>SP</option>-->
												</select>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 FormaPag">
												<label class="Desliga1">Troco para:</label>
												<input type="text" class="form-control Numero2 Desliga1" name="ValorDinheiro" id="ValorDinheiro" placeholder="Ex: 100" value="">
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fundo-entrega-carrinho finalizar2">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
									<br>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">							
											<div class="card card-outline-secondary my-4">								
												<div class="card-body">										
													<?php if(count($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]) > '0'){ ?>
														<?php if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){ ?>
															
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
									<br>
								</div>
							</div>
						
					<?php } ?>
				<?php } ?>
			</form>	
		</div>
	</section>					
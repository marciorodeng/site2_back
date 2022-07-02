<?php 

	$id_pedido = addslashes($_GET['id']);	
	
	if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];
	}
	
	$result_cliente = "SELECT * FROM App_Cliente WHERE idApp_Cliente = '".$cliente."'";
	$resultado_cliente = mysqli_query($conn, $result_cliente);
	$row_cliente = mysqli_fetch_assoc($resultado_cliente);
		

	
	if(!isset($_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]])){
		$_SESSION['Site_Back']['carrinho'.$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]] = array();
	}

?>
<section id="pedido" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<br>
		<h2 class="ser-title">Pedido: <?php echo $id_pedido; ?></h2>
		<hr class="botm-line">
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fundo-carrinho">
		<ul class="list-group mb-3 ">										
			<?php
				$read_orcatrata = mysqli_query($conn, "
													SELECT 
														OT.ValorTotalOrca,
														OT.ValorFinalOrca,
														OT.CashBackOrca,
														OT.ValorFrete,
														OT.ValorBoleto,
														OT.ValorRestanteOrca,
														OT.ValorExtraOrca,
														OT.DescValorOrca,
														OT.ValorSomaOrca,
														OT.FormaPagamento,
														OT.Descricao
													FROM 
														App_OrcaTrata AS OT
													WHERE 
														OT.idApp_OrcaTrata = '".$id_pedido."'  
													ORDER BY 
														OT.idApp_OrcaTrata ASC
													");
				
				$read_produto = mysqli_query($conn, "
													SELECT 
														AP.idApp_Produto,
														AP.ValorProduto, 
														AP.QtdProduto,
														AP.QtdIncrementoProduto,
														AP.idTab_Produto,
														AP.idTab_Produtos_Produto,
														AP.idApp_OrcaTrata,
														AP.NomeProduto,
														TPS.Nome_Prod,
														TPS.Arquivo,
														TOP2.Opcao,
														TOP1.Opcao,
														CONCAT(TPS.Nome_Prod, ' ' ,TOP2.Opcao, ' ' ,TOP1.Opcao) AS Produtos
													FROM 
														App_Produto  AS AP 
															LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = AP.idTab_Produtos_Produto
															LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
															LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2
													WHERE 
														AP.idApp_OrcaTrata = '".$id_pedido."'  
													ORDER BY 
														AP.idApp_Produto ASC
													");
				if(mysqli_num_rows($read_orcatrata) > '0'){
					foreach($read_orcatrata as $read_orcatrata_view){
						$descricao = $read_orcatrata_view['Descricao'];
						$valortotalorca = $read_orcatrata_view['ValorTotalOrca'];
						$valorfinalorca = $read_orcatrata_view['ValorFinalOrca'];
						$cashback_orca = $read_orcatrata_view['CashBackOrca'];
						$extra_orca = $read_orcatrata_view['ValorExtraOrca'];
						$desc_orca = $read_orcatrata_view['DescValorOrca'];
						$total_orca = $read_orcatrata_view['ValorRestanteOrca'];
						$valor_frete = $read_orcatrata_view['ValorFrete'];
						$valor_boleto = $read_orcatrata_view['ValorBoleto'];
						$total_valor = 0;
						$total_produtos = 0;
						$cont_item = 0;
						if(mysqli_num_rows($read_produto) > '0'){
							foreach($read_produto as $read_produto_view){
								$sub_total = $read_produto_view['ValorProduto'] * $read_produto_view['QtdProduto'];
								$total_valor += $sub_total;
								$sub_total_produtos = $read_produto_view['QtdIncrementoProduto'] * $read_produto_view['QtdProduto'];
								$total_produtos += $sub_total_produtos;
								$cont_item++;
								?>		
								<li class="list-group-item d-flex justify-content-between lh-condensed fundo">
									<div class="row">
										<div class="container-2">
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">	
												<img class="team-img img-responsive" src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produto_view['Arquivo']; ?>" alt="" width='100' >
											</div>
											<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
												<div class="row">
													<span class="my-0" style="color: #000000"><?php echo utf8_encode ($read_produto_view['NomeProduto']);?></span>
													<!--<small class="text-muted">Brief description</small>-->
												</div>
												<div class="row">	
													<!--<span class="text-muted">Valor = R$ <?php echo number_format($read_produto_view['ValorProduto'],2,",",".");?> / </span>--> 
													<span class="text-muted"><?php echo $sub_total_produtos;?> Un. </span>
													<span class="text-muted">R$<?php echo number_format($sub_total,2,",",".");?></span>																
												</div>
											</div>
										</div>
									</div>
								</li>
								<?php
							}
						}
					}	
				}	
			?>
			<li class="list-group-item d-flex justify-content-between fundo">
				<span>Observações </span>
				<strong>: <?php echo utf8_encode($descricao); ?></strong>
			</li>
			<li class="list-group-item d-flex justify-content-between fundo">
				<span>Total de Itens </span>
				<strong>: <?php echo $cont_item; ?></strong>
			</li>
			<li class="list-group-item d-flex justify-content-between fundo">
				<span>Produtos: </span>
				<strong><?php echo $total_produtos;?> Unid.</strong>
			</li>
			<li class="list-group-item d-flex justify-content-between fundo">
				<span>Produtos & Serviços: </span>
				<strong>R$ <?php echo number_format($total_valor,2,",",".");?></strong>
			</li>
			<li class="list-group-item d-flex justify-content-between fundo">
				<span>Valor do Frete: </span>
				<strong>R$ <?php echo number_format($valor_frete,2,",",".");?></strong>
			</li>
			<li class="list-group-item d-flex justify-content-between fundo">
				<span>Extra: </span>
				<strong>R$ <?php echo number_format($extra_orca,2,",",".");?></strong>
			</li>
			<li class="list-group-item d-flex justify-content-between fundo">
				<span>Desconto: </span>
				<strong>R$ <?php echo number_format($desc_orca,2,",",".");?></strong>
			</li>
			<li class="list-group-item d-flex justify-content-between fundo">
				<span>CashBack: </span>
				<strong>R$ <?php echo number_format($cashback_orca,2,",",".");?></strong>
			</li>
			<?php if($read_orcatrata_view['FormaPagamento'] == 2) { ?>	
				<li class="list-group-item d-flex justify-content-between fundo">
					<span>Valor do Boleto: </span>
					<strong>R$ <?php echo number_format($valor_boleto,2,",",".");?></strong>
				</li>
			<?php } ?>	
			<li class="list-group-item d-flex justify-content-between fundo">
				<span>Total: </span>
				<strong>R$ <?php echo number_format($valorfinalorca,2,",",".");?></strong>
			</li>
			<?php								
				$read_parcelas = mysqli_query($conn, "
													SELECT 
														*
													FROM 
														App_Parcelas  AS PRC 
													WHERE 
														PRC.idApp_OrcaTrata = '".$id_pedido."'  
													ORDER BY 
														PRC.idApp_Parcelas ASC
													");
						
				$total_parcelas = 0;
				$cont_parcelas = 0;
				if(mysqli_num_rows($read_parcelas) > '0'){
					foreach($read_parcelas as $read_parcelas_view){
						if($read_parcelas_view['Quitado'] == "S"){
							$quitado = "Pago";
						}elseif($read_parcelas_view['Quitado'] == "N"){
							$quitado = "Aguardando";
						}else{
							$quitado = "Outros";
						}
						$cont_parcelas++;
						?>		
						<li class="list-group-item d-flex justify-content-between lh-condensed fundo">
							<div class="row">	
								<div class="col-md-3 ">	
									<h4 class="my-0">Parcela <?php echo utf8_encode ($read_parcelas_view['Parcela']);?> </h4>													
								</div>
								<div class="col-md-6 ">	
									<span class="my-0">R$ <?php echo number_format($read_parcelas_view['ValorParcela'],2,",",".");?></span> |
									<span class="my-0">Vnc.  <?php echo date_format(new DateTime($read_parcelas_view['DataVencimento']),'d/m/Y');?></span> |
									<span class="my-0"> <?php echo $quitado;?> </span>
								</div>
							</div>
						</li>
						<?php
					}
				}	
			?>
		</ul>
	</div>
</section>

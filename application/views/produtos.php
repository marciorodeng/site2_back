<?php
	
	if(isset($row_empresa['EComerce']) && $row_empresa['EComerce'] == "N"){
		echo "<script>window.location = 'index.php'</script>";
		exit();
	}

	if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){
		$cliente = $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];
	}else{
		unset(	$_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa],
				$_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa]
		);	
	}	
?>
<section id="produtos" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<?php if($row_empresa['EComerce'] == 'S' && isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]) && isset($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]) && count($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]) > '0'){ ?>
			
			<div class="col-md-12">	
				<?php if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){ ?>
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
						<?php if(isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa])){ ?>
							<a href="pesquisar_cliente.php" class="btn btn-danger btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Logar / Finalizar Pedido</a>
						<?php } else { ?>
							<a href="login_cliente.php" class="btn btn-danger btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)">Logar / Finalizar Pedido</a>
						<?php } ?>
						<div class="alert alert-warning aguardar" role="alert" name="aguardar" id="aguardar">
							Aguarde um instante! Estamos processando sua solicitação!
						</div>							
					</div>
				<?php } ?>
			</div>
		
	<?php } ?>

	<div class="container">
		<div class="row">	
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h1 class="title-h1">Produtos & Serviços</h1>
				<hr class="traco-h1">
			</div>
		</div>
	</div>
		
	<?php
		if(isset($_GET['cat']) && $_GET['cat'] != ''){
			$id_cat = addslashes($_GET['cat']);
			$sql_categoria = "AND TP.idTab_Catprod = '".$id_cat."'";
			$sql_categoria_id = "AND idTab_Catprod = '".$id_cat."'";
			}else{
			$sql_categoria = '';
			$sql_categoria_id = '';
		}
		
		$result_categoria_id = "
								SELECT * 
								FROM 
									Tab_Catprod 
								WHERE 
									idSis_Empresa = '".$idSis_Empresa."' AND 
									Site_Catprod = 'S' {$sql_categoria_id} 
								ORDER BY 
									TipoCatprod ASC, 
									Catprod ASC  
								";
								
		$read_categoria_id = mysqli_query($conn, $result_categoria_id);
		
		$contagem = mysqli_num_rows($read_categoria_id);

		if(isset($contagem) && $contagem > 0){
			foreach($read_categoria_id as $read_categoria_view_id){
				$id_catprod = $read_categoria_view_id['idTab_Catprod'];
				$tipo_catprod = $read_categoria_view_id['TipoCatprod'];
				$result_produto_id = "
										SELECT * 
										FROM 
											Tab_Produto as TP
												LEFT JOIN Tab_Catprod AS TCP ON TCP.idTab_Catprod = TP.idTab_Catprod
										WHERE 
											TP.idTab_Produto != '' AND
											TP.Ativo = 'S' AND
											TP.VendaSite = 'S' AND
											TP.idSis_Empresa = '".$idSis_Empresa."' AND
											TP.idTab_Catprod = '".$id_catprod."' 
										ORDER BY
											TP.Produtos ASC ";
				
				if($tipo_catprod == "P"){
					$tipocategoria = 'Produtos';
				}elseif($tipo_catprod == "S"){
					$tipocategoria = 'Serviços';
				}elseif($tipo_catprod == "A"){
					$tipocategoria = 'Aluguel';
				}
				
				echo'
				<br>
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h2 class="ser-title">'.$read_categoria_view_id['Catprod'].'</h2>
							<hr class="botm-line">
						</div>
				';
				
				$read_produto_id = mysqli_query($conn, $result_produto_id);
				if(mysqli_num_rows($read_produto_id) > '0'){
					
					foreach($read_produto_id as $read_produto_view_id){ ?>
						<!--
						<div class="container">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<h4 class="ser-title"><?php #echo utf8_encode($read_produto_view_id['Produtos']);?></h4>
									<hr class="botm-line">
								</div>
							</div>	
						</div>
						-->
						<?php
						$produtobase_id = $read_produto_view_id['idTab_Produto'];
						$result_produtos_id = "
												SELECT 
													TV.idTab_Valor,
													TV.idTab_Produto,
													TV.ValorProduto,
													TV.QtdProdutoDesconto,
													TV.QtdProdutoIncremento,
													TV.Convdesc,
													TV.idTab_Promocao,
													TV.Desconto,
													TV.ComissaoVenda,
													TV.ComissaoCashBack,
													TV.TempoDeEntrega,
													TPR.Promocao,
													TPR.Descricao,
													TPR.Ativo,
													TPR.VendaSite,
													TPS.idTab_Produtos,
													TPS.idTab_Produto,
													TPS.idSis_Empresa,
													TPS.Nome_Prod,
													TPS.Arquivo AS ArquivoDerivados,
													TPS.Valor_Produto,
													TPS.ContarEstoque,
													TPS.Estoque,
													TPS.Produtos_Descricao,
													TOP2.Opcao AS Opcao2,
													TOP1.Opcao AS Opcao1,
													TP.idTab_Catprod,
													TP.Produtos,
													(TV.ValorProduto) AS SubTotal2
												FROM 
													Tab_Valor AS TV
														LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TV.idTab_Produtos
														LEFT JOIN Tab_Promocao AS TPR ON TPR.idTab_Promocao = TV.idTab_Promocao
														LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TPS.idTab_Produto
														LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_2
														LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_1

												WHERE 
													TV.idTab_Produto = '".$produtobase_id."' AND
													TV.Desconto = '1' AND
													TP.Ativo = 'S' AND
													TP.VendaSite = 'S' AND
													TV.AtivoPreco = 'S' AND
													TV.VendaSitePreco = 'S'
												ORDER BY 
													TPS.Nome_Prod ASC
												";
						$read_produtos_id = mysqli_query($conn, $result_produtos_id);
						if(mysqli_num_rows($read_produtos_id) > '0'){
							
							$existemprodutos = 1;
							
							foreach($read_produtos_id as $read_produtos_derivados_view){ 
								
								$comissao 		= $read_produtos_derivados_view['SubTotal2'] * $read_produtos_derivados_view['ComissaoVenda']/100;
								$cashback 		= $read_produtos_derivados_view['SubTotal2'] * $read_produtos_derivados_view['ComissaoCashBack']/100;
								$qtd_incremento = $read_produtos_derivados_view['QtdProdutoIncremento'];
								$id_produto 	= $read_produtos_derivados_view['idTab_Produtos'];
								$subtotal2 		= $read_produtos_derivados_view['SubTotal2'];
								$valortotal2 	= $subtotal2;
								$contar_estoque	= $read_produtos_derivados_view['ContarEstoque'];
								$qtd_estoque 	= $read_produtos_derivados_view['Estoque'];
								?>
							
								
								<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 text-center">
									<div class="card-body">
										<a href="produto.php?id=<?php echo $read_produtos_derivados_view['idTab_Valor'];?>">
											<img class="team-img img-responsive" src="<?php echo $idSis_Empresa ?>/produtos/miniatura/<?php echo $read_produtos_derivados_view['ArquivoDerivados']; ?>" alt="" width='500'>					 
										</a>
									</div>
									<div class="card-body">
										<h5 class="card-title">
											<?php echo utf8_encode ($read_produtos_derivados_view['Nome_Prod']);?>
										</h5>
									</div>
									<div class="card-body">
										<h5 class="card-title">
											<?php echo utf8_encode ($read_produtos_derivados_view['Produtos_Descricao']);?>
										</h5>
										<?php if($row_empresa['EComerce'] == 'S'){ ?>
											<h5> 
												<?php echo utf8_encode ($read_produtos_derivados_view['Convdesc']);?>
											</h5>
											<h5> 
												<?php echo utf8_encode ($read_produtos_derivados_view['QtdProdutoIncremento']);?> Unid. 
												R$ <?php echo number_format($valortotal2,2,",",".");?>
											</h5>
											<?php if($row_empresa['CashBackAtivo'] == 'S'){ ?>
												<h6> 
													CashBack R$ <?php echo number_format($cashback,2,",",".");?>
												</h6>
											<?php } ?>
											<h5 class="card-title">
												<?php 
													if($read_produtos_derivados_view['TempoDeEntrega'] <= 0){
														echo 'Pronta Entrega!';
													}else{
														echo 'Prazo de Entrega: ' . $read_produtos_derivados_view['TempoDeEntrega'] . ' Dia(s)';
													} 
												?>
											</h5>
										<?php } ?>
									</div>
								</div>
							
								<?php
							}
						
						
						}else{
							$existemprodutos = 0;
						
						}
						/*
						echo '<br>';
						echo "<pre>";
						print_r($produtobase_id);
						echo '<br>';
						print_r($existemprodutos);
						echo "</pre>";
						*/
						?>
							<!--
							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
								<?php if($existemprodutos == 1) { ?>
									<div class="">
										<a href="produtosderivados.php?id_modelo=<?php echo $read_produto_view_id['idTab_Produto'];?>">
											<img class="team-img  img-responsive" src="<?php echo $idSis_Empresa;?>/produtos/miniatura/<?php echo $read_produto_view_id['Arquivo'];?>" alt="" width='500'>
										</a>					 
									</div>
									<div class="">
										<h4 class="card-title text-center">
											<a href="produtosderivados.php?id_modelo=<?php echo $read_produto_view_id['idTab_Produto'];?>">
												<?php echo utf8_encode($read_produto_view_id['Produtos']);?>
											</a>
										</h4>
									</div>
								<?php }elseif($existemprodutos == 0) { ?>	
									<div class="card-body">
										<h4 class="card-title text-center">
											<?php echo utf8_encode($read_produto_view_id['Produtos']);?>
										</h4>
									</div>
									<div class="card-body">
										<img class="team-img  img-responsive" src="<?php echo $idSis_Empresa;?>/produtos/miniatura/<?php echo $read_produto_view_id['Arquivo'];?>" alt="" width='500'>					 
									</div>
								<?php } ?>
								
							</div>
							-->
						<?php
					}
				}
				echo'
					</div>
				</div>
				';
			}
		}else{
			echo "<script>window.location = 'index.php'</script>";
			exit();
		}
	?>
</section>

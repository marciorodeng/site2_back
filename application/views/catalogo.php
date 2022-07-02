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
<section id="catalogo" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<?php if($row_empresa['EComerce'] == 'S' && isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa]) && isset($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]) && count($_SESSION['Site_Back']['carrinho'.$idSis_Empresa]) > '0'){ ?>
			
		<div class="col-md-12">	
			<?php if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){ ?>
				<div class="row">
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
				<h1 class="title-h1">Catálogo</h1>
				<hr class="traco-h1">
			</div>				
			<?php
				if(isset($_GET['cat']) && $_GET['cat'] != ''){
					$cat = $_GET['cat'];
					if($cat == "prd"){
						$tipocategoria = 'Produtos';
					}elseif($cat == "srv"){
						$tipocategoria = 'Serviços';
					}elseif($cat == "prm"){
						$tipocategoria = 'Promoções';
					}else{
						$tipocategoria = 'Catálogo';
					}
				}else{
					$cat = '';
					$tipocategoria = 'Catálogo';
				}
				if(!$cat || $cat == '' || (isset($cat) && $cat == 'prd')){
					$result_categoria_prd = "
											SELECT * 
											FROM 
												Tab_Catprod 
											WHERE 
												idSis_Empresa = '".$idSis_Empresa."' AND 
												TipoCatprod = 'P' AND
												Site_Catprod = 'S'  
											ORDER BY  
												Catprod ASC 
											";
					$read_categoria_prd = mysqli_query($conn, $result_categoria_prd);						
					if(mysqli_num_rows($read_categoria_prd) > '0'){
						echo'
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<h1 class="title-h2">Produtos</h2>
								<hr class="botm-line">
							</div>
						';
						foreach($read_categoria_prd as $read_categoria_view_prd){
							$id_catprod = $read_categoria_view_prd['idTab_Catprod'];
							$arquivo_catprod = $read_categoria_view_prd['Arquivo'];

							echo'									
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
									<h3 class="ser-title">'.$read_categoria_view_prd['Catprod'].'</h3>
									<hr class="botm-line">
									<div class="card-body">
										<a href="produtos.php?cat='.$read_categoria_view_prd['idTab_Catprod'].'">
											<img class="team-img img-responsive " src="'.$idSis_Empresa.'/produtos/miniatura/'.$read_categoria_view_prd['Arquivo'].'" alt="" width="500">
										</a>
									</div>
								</div>
							';
						}
					}
				}
				if(!$cat || $cat == '' || (isset($cat) && $cat == 'srv')){
					$result_categoria_srv = "
											SELECT * 
											FROM 
												Tab_Catprod 
											WHERE 
												idSis_Empresa = '".$idSis_Empresa."' AND 
												TipoCatprod = 'S' AND
												Site_Catprod = 'S'  
											ORDER BY  
												Catprod ASC 
											";
					$read_categoria_srv = mysqli_query($conn, $result_categoria_srv);						
					if(mysqli_num_rows($read_categoria_srv) > '0'){
						echo'
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<h1 class="title-h2">Serviços</h2>
								<hr class="botm-line">
							</div>
						';
						foreach($read_categoria_srv as $read_categoria_view_srv){
							$id_catprod = $read_categoria_view_srv['idTab_Catprod'];
							$arquivo_catprod = $read_categoria_view_srv['Arquivo'];

							echo'									
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
									<h3 class="ser-title">'.$read_categoria_view_srv['Catprod'].'</h3>
									<hr class="botm-line">
									<div class="card-body">
										<a href="produtos.php?cat='.$read_categoria_view_srv['idTab_Catprod'].'">
											<img class="team-img img-responsive " src="'.$idSis_Empresa.'/produtos/miniatura/'.$read_categoria_view_srv['Arquivo'].'" alt="" width="500">
										</a>
									</div>
								</div>
							';
						}
					}
				}
				if(!$cat || $cat == '' || (isset($cat) && $cat == 'prm')){
					$result_categoria_prm = "
											SELECT * 
											FROM 
												Tab_Catprom 
											WHERE 
												idSis_Empresa = '".$idSis_Empresa."' AND 
												Site_Catprom = 'S'  
											ORDER BY  
												Catprom ASC 
											";
					$read_categoria_prm = mysqli_query($conn, $result_categoria_prm);
						
					if(mysqli_num_rows($read_categoria_prm) > '0'){
						echo'
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<h1 class="title-h2">Promoções</h2>
								<hr class="botm-line">
							</div>
						';						
						foreach($read_categoria_prm as $read_categoria_view_prm){
							$id_catprom = $read_categoria_view_prm['idTab_Catprom'];
							$arquivo_catprom = $read_categoria_view_prm['Arquivo'];

							echo'										
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
									<h3 class="ser-title">'.$read_categoria_view_prm['Catprom'].'</h3>
									<hr class="botm-line">
									<div class="card-body">
										<a href="promocao.php?cat='.$read_categoria_view_prm['idTab_Catprom'].'">
											<img class="team-img img-responsive " src="'.$idSis_Empresa.'/promocao/miniatura/'.$read_categoria_view_prm['Arquivo'].'" alt="" width="500">
										</a>
									</div>
								</div>
							';
						}
					}
				}
			?>
		</div>	
	</div>		
</section>

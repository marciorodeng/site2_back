<?php if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){ ?>
	<?php 

		if(!isset($_SESSION['Site_Back']['carrinho'.$idSis_Empresa])){
			$_SESSION['Site_Back']['carrinho'.$idSis_Empresa] = array();
		}
		
		if(isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){
			$cliente = $_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa];
			$nomecliente = $_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa];
		}
	
		$date_agora = date('Y-m-d H:i:s', time());
		/*
		echo '<pre>';
		echo '<br>';
		print_r($date_agora);
		echo '</pre>';
		*/
	?>
	<section id="pedidos" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<h1 class="title-h1">Meus Agendamentos!</h1>
					<hr class="traco-h1">
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="input-group">
						<span class="input-group-btn">
							<a href="meus_agendamentos.php" class="btn btn-warning btn-block">
								<span class="glyphicon glyphicon-search"></span> Atualizar
							</a>
						</span>
					</div>
				</div>
				<br>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<ul class="list-group mb-3 ">										
						<?php
							//Receber o numero da pagina
							$pagina_atual = filter_input(INPUT_GET,'pagina',FILTER_SANITIZE_NUMBER_INT);
							$pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
							//Setar a quantidade de itens
							$qnt_result_pg = 3;
							//Calcular o início da visualização
							$inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;
							$read_pedido = mysqli_query($conn, "SELECT 
																	*
																FROM 
																	App_Consulta
																WHERE 
																	idSis_Empresa = '".$idSis_Empresa."' AND
																	idApp_Cliente = '".$cliente."' AND
																	DataInicio >= '".$date_agora."'
																ORDER BY 
																	DataInicio ASC
																LIMIT $inicio, $qnt_result_pg
																");
							//somar a quantidade de usuarios
							$result_pg = "SELECT 
											COUNT(idApp_Consulta) AS num_result 
										FROM 
											App_Consulta 
										WHERE 
											idSis_Empresa = '".$idSis_Empresa."' AND 
											idApp_Cliente = '".$cliente."' AND 
											DataInicio >= '".$date_agora."' 
										ORDER BY 
											DataInicio ASC";
							
							$resultado_pg = mysqli_query($conn, $result_pg);
							$row_pg = mysqli_fetch_assoc($resultado_pg);
							//echo $row_pg['num_result'];
							$quantidade_pg = ceil($row_pg['num_result']/$qnt_result_pg);
							//Limitar os links antes e depois
							$max_links = 2;
							if($pagina > 1){
								echo "<a href='meus_agendamentos.php?pagina=1'>Primeira</a> &nbsp;";
							}
							for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
								if($pag_ant >= 1){
									echo "<a href='meus_agendamentos.php?pagina=$pag_ant'>$pag_ant</a> &nbsp;";
								}	
							}
							
							if($qnt_result_pg < $row_pg['num_result']){
								echo "$pagina &nbsp;"; 
							}
							for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
								if($pag_dep <= $quantidade_pg){
									echo "<a href='meus_agendamentos.php?pagina=$pag_dep'>$pag_dep</a> &nbsp;";
								}	
							}
							if($pagina < $quantidade_pg){
								echo "<a href='meus_agendamentos.php?pagina=$quantidade_pg'>Ultima</a> &nbsp;";
							}																
							if(mysqli_num_rows($read_pedido) > '0'){
								
								foreach($read_pedido as $read_pedido_view){ 
									
									if($read_pedido_view['DataInicio'] >= $date_agora){
										$cor = 'fundoAzulEscuro';
										//$cor = 'fundoVermelho';
										//$cor = 'fundoAzulEscuro';
										//$cor = 'fundoAmarelo';
										//$cor = 'fundoAzulClaro';
									}else{
										$cor = '';
									}
									
									$dataini = explode(' ', $read_pedido_view['DataInicio']);
									$date = new DateTime($dataini[0]);
									$hour = new DateTime($dataini[1]);
									
									?>
									<li class="list-group-item d-flex justify-content-between lh-condensed <?php echo $cor;?>">
										<div class="row ">
											<div class="container-3">
												<div class="row">
													<div class="col-lg-3 col-md-3 col-sm-3  col-xs-6">
														<h5 class="my-0"><span class="text-muted" style="color: #000000">Repetição:</span>
															<?php echo $read_pedido_view['Repeticao'];?>
														</h5>
													</div>
													<div class="col-lg-3 col-md-3 col-sm-3  col-xs-6">
														<h5 class="my-0"><span class="text-muted" style="color: #000000">Recorrência:</span>
															<?php echo $read_pedido_view['Recorrencia'];?>
														</h5>
													</div>
													<div class="col-lg-3 col-md-3 col-sm-3  col-xs-6">
														<h5 class="my-0"><span class="text-muted" style="color: #000000">Data: </span><?php echo $date->format('d/m/Y');?></h5>  
													</div>
													<div class="col-lg-3 col-md-3 col-sm-3  col-xs-6">
														<h5 class="my-0"><span class="text-muted" style="color: #000000">Hora: </span><?php echo $hour->format('H:i');?></h5>  
													</div>
												</div>	
											</div>
										</div>
									</li>
									<?php
								}
								//somar a quantidade de usuarios
								$result_pg = "SELECT 
											COUNT(idApp_Consulta) AS num_result 
										FROM 
											App_Consulta 
										WHERE 
											idSis_Empresa = '".$idSis_Empresa."' AND 
											idApp_Cliente = '".$cliente."' AND 
											DataInicio >= '".$date_agora."' 
										ORDER BY 
											DataInicio ASC";
								$resultado_pg = mysqli_query($conn, $result_pg);
								$row_pg = mysqli_fetch_assoc($resultado_pg);
								//echo $row_pg['num_result'];
								$quantidade_pg = ceil($row_pg['num_result']/$qnt_result_pg);
								//Limitar os links antes e depois
								$max_links = 2;
								if($pagina > 1){
									echo "<a href='meus_agendamentos.php?pagina=1'>Primeira</a> &nbsp;";
								}
								for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
									if($pag_ant >= 1){
										echo "<a href='meus_agendamentos.php?pagina=$pag_ant'>$pag_ant</a> &nbsp;";
									}	
								}
								if($qnt_result_pg < $row_pg['num_result']){
									echo "$pagina &nbsp;"; 
								}	
								for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
									if($pag_dep <= $quantidade_pg){
										echo "<a href='meus_agendamentos.php?pagina=$pag_dep'>$pag_dep</a> &nbsp;";
									}	
								}
								if($pagina < $quantidade_pg){
									echo "<a href='meus_agendamentos.php?pagina=$quantidade_pg'>Ultima</a> &nbsp;";
								}
							}	
						?>
					</ul>
				</div>
			</div>
		</div>	
	</section>

<?php } else { echo "<script>window.location = 'login_cliente.php'</script>"; } ?>
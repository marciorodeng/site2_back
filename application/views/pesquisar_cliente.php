		
	<section id="pesquisarcliente" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">					
		<div class="row">
			<div class=" col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3  col-lg-6 ">
				<br>
				<h2 class="ser-title">Pesquisar Cliente</h2>
				<hr class="botm-line">
			</div>
			<div class=" col-xs-12 col-sm-offset-1 col-sm-10  col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6 ">
				<div class="form-signin-pesquisar text-left" style="background: #00FF00;">				
					<h3>Pesquisar Cliente da <?php echo $row_empresa['NomeEmpresa']; ?></h3>
					<?php
						if(isset($_SESSION['Site_Back']['msg'])){ ?>
							<h3 style="color: #FF0000"> <?php echo $_SESSION['Site_Back']['msg'];?>!!</h3>
							<?php unset($_SESSION['Site_Back']['msg']);?>
					<?php } ?>
					<?php	
						if(isset($_SESSION['Site_Back']['msgcad'])){ ?>
							<h3 style="color: green"> <?php echo $_SESSION['Site_Back']['msgcad'];?>!!</h3>
							<?php unset($_SESSION['Site_Back']['msgcad']);?>
					<?php } ?>
					<br>
					<?php if(!isset($_SESSION['Site_Back']['id_Cliente'.$idSis_Empresa])){ ?>	
						<form method="POST" action="valida_pesquisar_cliente.php">
							<input type="hidden" id="id_empresa" value="<?php echo $idSis_Empresa;?>">
							<?php 
								if(isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa])){
									$usuario_vend = $_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa];
									$nivel_vend = $_SESSION['Site_Back']['Nivel_Usuario_vend'.$idSis_Empresa];
								}elseif(isset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa])){
									$usuario_vend = $_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa];
									$nivel_vend = $_SESSION['Site_Back']['Nivel_Vendedor'.$idSis_Empresa];
								}else{
									$usuario_vend = FALSE;
									$nivel_vend = 1;
								}
							?>
							<?php if($usuario_vend){ ?>
								<input type="hidden" id="usuario_vend" value="<?php echo $usuario_vend;?>">
								<input type="hidden" id="nivel_vend" value="<?php echo $nivel_vend;?>">
							<?php }else{ ?>
								<input type="hidden" id="usuario_vend" value="<?php echo $usuario_vend;?>">
								<input type="hidden" id="nivel_vend" value="1">
							<?php } ?>
							<div class="row ">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
									<label>Nome ou Telefone do Cliente</label>
									<input class="form-control" type="text" name="id_Cliente_Auto"  id="id_Cliente_Auto" placeholder="Ex: 21987654321" maxlength="100" >
									<span class="modal-title" id="NomeClienteAuto1"></span>
								</div>
								<input type="hidden" id="NomeClienteAuto" name="NomeClienteAuto" value="" />
								<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="">
								<input type="hidden" id="Hidden_id_Cliente_Auto" name="Hidden_id_Cliente_Auto" value="" />
								<input type="hidden" id="Hidden_idApp_Cliente" name="Hidden_idApp_Cliente" value="" />						
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left" style="margin-top: 10px;">
									<label>Cliente Encontrado?</label>
									<div class="row ">
										<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left CliSim">
											<input type="submit" name="btnLogin" value="Sim" class="btn btn-success btn-block text-center " style="margin-top: 10px;">
										</div>
										<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left CliNao">
											<a type="button" class="btn btn-danger btn-block text-center" href="cadastrar_cliente3.php" style="margin-top: 10px;">Não</a>
										</div>
									</div>
								</div>
							</div>
						</form>
					<?php }else{ ?>
						<img class="img-circle " width='40' src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/clientes/miniatura/<?php echo $_SESSION['Site_Back']['Arquivo_Cliente'.$idSis_Empresa]; ?>" alt=""> 
						<?php echo $_SESSION['Site_Back']['Nome_Cliente'.$idSis_Empresa];?>
						<div class="row text-center">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top: 10px;">
								<a type="button" class="btn btn-danger btn-block" href="sair.php"> Deslogar da Empresa</a>
							</div>
						</div>
					<?php } ?>
				</div>	
			</div>
		</div>	
	</section>
			

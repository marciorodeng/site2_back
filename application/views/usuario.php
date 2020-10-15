<?php if((isset($_SESSION['Nome_Usuario'.$idSis_Empresa])) || (isset($_SESSION['Nome_Cliente'.$idSis_Empresa]))){ ?>		
	<section class="usuario">		
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12">	
						<?php if(isset($_SESSION['Nome_Usuario'.$idSis_Empresa])){ ?>
							<div class="col-md-1">
								<img class="img-circle img-responsive" width='50' src="../contapessoal/5/usuarios/miniatura/<?php echo $_SESSION['Arquivo_Usuario'.$idSis_Empresa]; ?>" alt="">					
							</div>
							<div class="col-md-5">
								<a ><?php echo $_SESSION['Nome_Usuario'.$idSis_Empresa]; ?></a>
							</div>
						<?php } ?>
						<?php if(isset($_SESSION['id_Cliente'.$idSis_Empresa])){ ?>
						<div class="col-md-5">	
							<a  href=""><?php echo $_SESSION['Nome_Cliente'.$idSis_Empresa];?></a>
						</div>
						<?php } ?>
						
					</div>	
					<hr class="botm-line">
				</div>
			</div>
		</div>
	</section>
<?php } ?>
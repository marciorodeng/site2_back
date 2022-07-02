
	<section id="loginusuario" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">					
		<div class="row">
			<div class=" col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3  col-lg-6 ">
				<br>
				<h2 class="ser-title">Login do Vendedor</h2>
				<hr class="botm-line">
			</div>
			<div class=" col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3  col-lg-6 ">
				<div class="form-signin text-left" style="background: #6A5ACD;">				
					<h3>Acesso do Vendedor da <?php echo $row_empresa['NomeEmpresa']; ?></h3>
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
					<?php if(isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa])){?>
						<img class="img-circle " width='40' src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/usuarios/miniatura/<?php echo $_SESSION['Site_Back']['Arquivo_Usuario_vend'.$idSis_Empresa]; ?>" alt=""> 
						<?php echo $_SESSION['Site_Back']['Nome_Usuario_vend'.$idSis_Empresa];?>
						<div class="row text-center">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top: 10px;">
								<a type="button" class="btn btn-danger btn-block" href="sair_vend.php"> Deslogar da Empresa</a>
							</div>
							<!--
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top: 10px;">
								<a type="button" class="btn btn-info btn-block" href="login_vendedor.php"> Link de Vendedor</a>
							</div>
							-->
						</div>
					<?php }else{ ?>	
						<?php if(isset($_SESSION['Site_Back']['id_Vendedor'.$idSis_Empresa])){?>
							<img class="img-circle " width='40' src="../<?php echo $row_empresa['Site']; ?>/<?php echo $row_empresa['idSis_Empresa']; ?>/usuarios/miniatura/<?php echo $_SESSION['Site_Back']['Arquivo_Vendedor'.$idSis_Empresa]; ?>" alt=""> 
							<?php echo $_SESSION['Site_Back']['Nome_Vendedor'.$idSis_Empresa];?>
							<div class="row text-center">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top: 10px;">
									<a type="button" class="btn btn-danger btn-block" href="sair_vend.php"> Deslogar da Empresa</a>
								</div>
								<!--
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top: 10px;">
									<a type="button" class="btn btn-info btn-block" href="login_vendedor.php"> Link de Vendedor</a>
								</div>
								-->
							</div>						
						<?php }else{ ?>	
							<form method="POST" action="valida_usuario.php">
								<label>Digite o Celular cadastrado, com DDD.</label>
								<input type="text" name="celular"  id="celular" placeholder="Ex: 21987654321" maxlength="11" class="form-control"><br>
								<label>Digite a Senha cadastrada.</label>
								<div class="input-group">
									<input type="password" name="senha" id="senha" placeholder="Digite a sua senha" class="form-control btn-sm ">
									<span class="input-group-btn">
										<button class="btn btn-info btn-md " type="button" onclick="mostrarSenha()">
											
											<span class="Mostrar glyphicon glyphicon-eye-open"></span>
											
											<span class="NMostrar glyphicon glyphicon-eye-close"></span>
											
										</button>
									</span>
								</div>
								<div class="row text-center">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top: 10px;">
										<input type="submit" name="btnLogin" value="Logar na Empresa" class="btn btn-success btn-block">
									</div>
									<!--
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top: 10px;">
										<a type="button" class="btn btn-info btn-block" href="login_vendedor.php"> Link de Vendedor</a>
									</div>
									-->
								</div>
							</form>
						<?php } ?>
					<?php } ?>
				</div>	
			</div>
		</div>	
	</section>
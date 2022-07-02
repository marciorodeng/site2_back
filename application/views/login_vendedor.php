	
	<section id="loginassociado" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="row">					
			<div class=" col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3  col-lg-6 ">
				<br>
				<h2 class="ser-title">Link do Vendedor</h2>
				<hr class="botm-line">
			</div>		
			<div class=" col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3  col-lg-6 ">
				<div class="form-signin text-left" style="background: #900095;">				
					<h3>Acessar Link de Vendedor da <?php echo $row_empresa['NomeEmpresa']; ?></h3>
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
					<form method="POST" action="valida_vendedor.php">
						<label>Digite o Celular(Login), com DDD</label>
						<input type="text" name="CelularUsuario" placeholder="Ex: 21987654321" maxlength="11" class="form-control"><br>
						
						<label>Digite a Senha</label>
						<input type="password" name="Senha" placeholder="Digite a sua senha" class="form-control"><br>
						
						<input type="submit" name="btnLogin" class="btn btn-success" value="Acessar Link">
						<!--
						<div class="row text-center" style="margin-top: 20px;"> 
							Você ainda não possui uma conta pessoal de associado? Então<a href="../<?php echo $sistema;?>/login/registrar"> Clique aqui </a> e cadastre!
						</div>
						-->
					</form>
				</div>	
			</div>
		</div>
	</section>
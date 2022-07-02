<?php if(isset($_SESSION['Site_Back']['id_Usuario_vend'.$idSis_Empresa])){ ?>	
	<section id="cadastrarcliente" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
		<div class="row">	
			<div class=" col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3  col-lg-6 ">
				<br>
				<h2 class="ser-title">Cadastrar Cliente</h2>
				<hr class="botm-line">
			</div>
			<div class=" col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3  col-lg-6 ">			
				<div class="form-signin" style="background: #aeb1ef;">
					<h3>Cadastrar Cliente</h3>
					<?php if(isset($_SESSION['Site_Back']['msg'])){ ?>
							<h3 style="color: #FF0000"> <?php echo $_SESSION['Site_Back']['msg'];?>!!</h3>
							<?php unset($_SESSION['Site_Back']['msg']);?>
					<?php } ?>
					<form method="POST" action="">
						<label>Digite Nome e Sobrenome</label>
						<input type="text" name="NomeCliente" placeholder="Digite o nome e o sobrenome" class="form-control"><br>
						
						<label>Digite um Celular, com DDD</label>
						<input type="text" name="CelularCliente" placeholder="Ex: 21987654321" maxlength="11" class="form-control Celular"><br>
						
						<!--<label>E-mail</label>
						<input type="text" name="Email" placeholder="Digite o seu e-mail" class="form-control"><br>
						
						<label>Usuário/Login</label>
						<input type="text" name="usuario" placeholder="Digite o usuário" class="form-control"><br>//o usuario é o próprio celular cadastrado-->

						<input type="submit" name="btnCadUsuario" value="Cadastrar" class="btn btn-success"><br>
						<!--
						<div class="row text-center" style="margin-top: 20px;"> 
							Lembrou da sua senha? Então <a href="login_cliente.php">Clique aqui</a> para logar!
						</div>

						<div class="row text-center" style="margin-top: 20px;"> 
							Não quer se cadastrar agora? Então <a href="index.php">Clique aqui</a> para entrar sem logar!
						</div>
						-->
					</form>
				</div>
			</div>
		</div>
	</section>
<?php } ?>		

				
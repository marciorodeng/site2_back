<section id="service" class="section-padding3">
	<div class="container">
		<div class="row">					
			<div class="col-md-12">
				<h2 class="ser-title">Cadastrar Cliente</h2>
				<hr class="botm-line">
			</div>		
		</div>
	</div>
</section>
<section id="contact" class="section-padding3">		
	<div class="container">
		<div class="form-signin" style="background: #aeb1ef;">
			<h3>Cadastrar Cliente</h3>
			<?php
				if(isset($_SESSION['msg'])){ ?>
					<h3 style="color: #FF0000"> <?php echo $_SESSION['msg'];?> !!</h3>
					<?php unset($_SESSION['msg']);?>
			<?php } ?>
			
			<form method="POST" action="">
				<label>Digite seu Nome</label>
				<input type="text" name="NomeCliente" placeholder="Digite o nome e o sobrenome" class="form-control"><br>
				
				<label>Digite um Celular, com DDD</label>
				<input type="text" name="CelularCliente" placeholder="Ex: 21987654321" maxlength="11" class="form-control"><br>
				
				<!--<label>E-mail</label>
				<input type="text" name="Email" placeholder="Digite o seu e-mail" class="form-control"><br>
				
				<label>Usuário/Login</label>
				<input type="text" name="usuario" placeholder="Digite o usuário" class="form-control"><br>-->
				
				<label>Digite uma Senha</label>
				<!--<input type="password" name="senha" placeholder="Digite a senha" class="form-control"><br>-->
				<div class="input-group">
					<input type="password" name="senha" id="senha" placeholder="Digite uma senha" class="form-control btn-sm "><br>
					<span class="input-group-btn">
						<button class="btn btn-info btn-md " type="button" onclick="mostrarSenha()">
							
							<span class="Mostrar glyphicon glyphicon-eye-open"></span>
							
							<span class="NMostrar glyphicon glyphicon-eye-close"></span>
							
						</button>
					</span>
				</div>
				<label>Digite a mesma Senha novamente</label>
				<!--<input type="password" name="confirmar" placeholder="Digite a senha novamente" class="form-control"><br>-->
				<div class="input-group">
					<input type="password" name="confirmar" id="confirmar" placeholder="Digite a senha novamente" class="form-control btn-sm "><br>
					<span class="input-group-btn">
						<button class="btn btn-info btn-md " type="button" onclick="confirmarSenha()">
							
							<span class="Open glyphicon glyphicon-eye-open"></span>
							
							<span class="Close glyphicon glyphicon-eye-close"></span>
							
						</button>
					</span>
				</div>
				<input type="submit" name="btnCadUsuario" value="Cadastrar" class="btn btn-success"><br>
				
				<div class="row text-center" style="margin-top: 20px;"> 
					Lembrou da sua senha? Então <a href="login_cliente.php">Clique aqui</a> para logar!
				</div>

				<div class="row text-center" style="margin-top: 20px;"> 
					Não quer se cadastrar agora? Então <a href="index.php">Clique aqui</a> para entrar sem logar!
				</div>					
			</form>
			<script>
				exibir();
				exibir_confirmar();
				function exibir(){
					$('.Mostrar').show();
					$('.NMostrar').hide();
				}
				function exibir_confirmar(){
					$('.Open').show();
					$('.Close').hide();
				}
				function mostrarSenha(){
					var tipo = document.getElementById("senha");
					if(tipo.type == "password"){
						tipo.type = "text";
						$('.Mostrar').hide();
						$('.NMostrar').show();
					}else{
						tipo.type = "password";
						$('.Mostrar').show();
						$('.NMostrar').hide();
					}
				}
				function confirmarSenha(){
					var tipo = document.getElementById("confirmar");
					if(tipo.type == "password"){
						tipo.type = "text";
						$('.Open').hide();
						$('.Close').show();
					}else{
						tipo.type = "password";
						$('.Open').show();
						$('.Close').hide();
					}
				}
			</script>
		</div>
	</div>
</section>	

				
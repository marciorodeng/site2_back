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
			
				<input type="hidden" name="idSis_Usuario_5" value="<?php echo $_SESSION['Usuario_5'.$idSis_Empresa]['idSis_Usuario_5'];?>">
				<input type="hidden" name="NomeCliente" value="<?php echo $_SESSION['Usuario_5'.$idSis_Empresa]['Nome'];?>">
				<input type="hidden" name="CelularCliente" value="<?php echo $_SESSION['Usuario_5'.$idSis_Empresa]['Celular'];?>">
				<input type="hidden" name="senha" value="<?php echo $_SESSION['Usuario_5'.$idSis_Empresa]['Senha'];?>">
				<input type="hidden" name="confirmar" value="<?php echo $_SESSION['Usuario_5'.$idSis_Empresa]['Senha'];?>">
				<input type="hidden" name="Codigo" value="<?php echo $_SESSION['Usuario_5'.$idSis_Empresa]['Codigo'];?>">
				<input type="submit" name="btnCadUsuario" value="Sim" class="btn btn-success">
					<a href="login_cliente.php">
						<button class="btn btn-danger btn-md " type="button" > Não </button>
					</a>
				<br>
				
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

				
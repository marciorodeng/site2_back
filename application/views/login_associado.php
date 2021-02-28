<section id="service" class="section-padding3">
	<div class="container">
		<div class="row">					
			<div class="col-md-12">
				<h2 class="ser-title">Link do Associado</h2>
				<hr class="botm-line">
			</div>		
		</div>
	</div>
</section>
<section id="contact" class="section-padding3">		
	<div class="container">
		<div class="form-signin text-left" style="background: #900095;">				
			<h3>Acessar Link do Associado da <?php echo utf8_encode($row_empresa['NomeEmpresa']); ?></h3>
			<?php
				if(isset($_SESSION['msg'])){
					echo $_SESSION['msg'];
					unset($_SESSION['msg']);
				}
				if(isset($_SESSION['msgcad'])){
					echo $_SESSION['msgcad'];
					unset($_SESSION['msgcad']);
				}
				
			?>
			<br>
			<form method="POST" action="valida_associado.php">
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
</section>			

<section id="service" class="section-padding3">
	<div class="container">
		<div class="row">					
			<div class="col-md-12">
				<h2 class="ser-title">Login do Cliente</h2>
				<hr class="botm-line">
			</div>		
		</div>
	</div>
</section>
<section id="contact" class="section-padding3">		
	<div class="container">
		<div class="form-signin text-left" style="background: #42dea4;">				
			<h3>Acesso do Cliente da <?php echo utf8_encode($row_empresa['NomeEmpresa']); ?></h3>
			<?php
				if(isset($_SESSION['msg'])){ ?>
					<h3 style="color: #FF0000"> <?php echo $_SESSION['msg'];?>!!</h3>
					<?php unset($_SESSION['msg']);?>
			<?php } ?>
			<?php	
				if(isset($_SESSION['msgcad'])){ ?>
					<h3 style="color: green"> <?php echo $_SESSION['msgcad'];?>!!</h3>
					<?php unset($_SESSION['msgcad']);?>
			<?php } ?>
			<br>
			<form method="POST" action="valida_cliente.php">
				<!--<label>Digite o seu Login</label>
				<input type="text" name="usuario" placeholder="Digite o seu usuário" class="form-control"><br>-->
				
				<label>Digite o Celular, com DDD, cadastrado</label>
				<input type="text" name="celular" placeholder="Ex: 21987654321" maxlength="11" class="form-control"><br>
				
				<label>Digite a Senha cadastrada</label>
				<input type="password" name="senha" placeholder="Digite a sua senha" class="form-control"><br>
				
				<input type="submit" name="btnLogin" value="Acessar" class="btn btn-success">

				<div class="row text-center" style="margin-top: 20px;"> 
					Você ainda não está cadastrado? Então<a href="cadastrar_cliente.php"> Clique aqui </a> e cadastre-se!
				</div>					
			</form>
		</div>	
	</div>
</section>			

<section id="logincliente" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">					
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<br>
			<h2 class="ser-title">Login do Cliente</h2>
			<hr class="botm-line">
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
					
					<label>Digite o Celular cadastrado, com DDD.</label>
					<input type="text" name="celular"  id="celular" placeholder="Ex: 21987654321" maxlength="11" class="form-control"><br>
					<!--
					<label>Digite a Senha cadastrada</label>
					<input type="password" name="senha" id="senha" placeholder="Digite a sua senha" class="form-control"><br>
					<button type="button" onclick="mostrarSenha()">Apresentar senha</button>
					-->
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
					<input type="submit" name="btnLogin" value="Acessar" class="btn btn-success btn-block" style="margin-top: 10px;">

					<div class="row text-center" style="margin-top: 20px;">
						<div class="col-md-12" >
							<a type="button" class="btn btn-warning btn-block" href="cadastrar_cliente.php"> Não sou Cadastrado</a>
						</div>
					</div>
				</form>
				<script>
					exibir();
					function exibir(){
						$('.Mostrar').show();
						$('.NMostrar').hide();
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
				</script>
			</div>	
		</div>
	</div>	
</section>			

<?php
	if(isset($_GET['cel_cliente'])){	
		$cel_cliente = addslashes($_GET['cel_cliente']);
	}else{
		$cel_cliente = '';
	}
?>		
	<section id="logincliente" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">					
		<div class="row">
			<div class=" col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3  col-lg-6 ">
				<br>
				<h2 class="ser-title">Login do Cliente</h2>
				<hr class="botm-line">
			</div>
			<div class=" col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3  col-lg-6 ">
				<div class="form-signin text-left" style="background: #42dea4;">				
					<h3>Acesso do Cliente da <?php echo $row_empresa['NomeEmpresa']; ?></h3>
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
						<form method="POST" action="valida_cliente.php">
							<!--<label>Digite o seu Login</label>
							<input type="text" name="usuario" placeholder="Digite o seu usuário" class="form-control"><br>-->
							
							<label>Digite o Celular cadastrado, com DDD.</label>
							<input type="text" name="celular"  id="celular" placeholder="Ex: 21987654321" maxlength="11" class="form-control Celular" value="<?php echo $cel_cliente;?>"><br>
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
							<div class="row text-center">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top: 10px;">
									<input type="submit" name="btnLogin" value="Logar na Empresa" class="btn btn-success btn-block">
								</div>
								<?php if(isset($row_empresa['AssociadoAtivo']) && $row_empresa['AssociadoAtivo'] == "S"){ ?>
									<!--
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top: 10px;">
										<a type="button" class="btn btn-info btn-block" href="login_associado.php"> Link de Associado</a>
									</div>
									-->
								<?php } ?>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top: 10px;">
									<a type="button" class="btn btn-warning btn-block" href="cadastrar_cliente.php"> Não sou Cadastrado</a>
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
						<?php if(isset($row_empresa['AssociadoAtivo']) && $row_empresa['AssociadoAtivo'] == "S"){ ?>
							<!--
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top: 10px;">
								<a type="button" class="btn btn-info btn-block" href="login_associado.php"> Link de Associado</a>
							</div>
							-->
						<?php } ?>
					</div>
					<?php } ?>
					<!--
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
					-->
				</div>	
			</div>
		</div>	
	</section>			

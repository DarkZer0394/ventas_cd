<div class="contenido">
	<form name="entrar" method="POST"
		enctype="multipart/form-data" action="">
		<p id="titulo_de_pagina">Iniciar</p>
		<input required type="email" name="correo_electronico"
			placeholder="por@ejemplo.com" />
		<input required type="password" name="contraseña"
			placeholder="contraseña"/>
		<div class="contenedorIcon">
			<input type="submit" class="icon" id="enviar"
			name="enviar" value="&rarr;"/>
		</div>
		<a href="registrar.php">Regístrate</a><br>
		<a href="solicitar_contraseña.php">Olvide mi contraseña</a>
	</form>
</div>
<?php
	if(isset($_POST["enviar"])){
		$aviso="";
		$correoElectronico=htmlspecialchars($_POST["correo_electronico"]);
		$contraseña=htmlspecialchars($_POST["contraseña"]);
		try{
			$sql="SELECT * FROM cliente WHERE correo_electronico =?";
			$stmt= $conexion->prepare($sql);
			$stmt->execute(array($correoElectronico));
			$resultado= $stmt->fetch(PDO::FETCH_ASSOC);
			if($resultado){
				$contraseñaEnBaseDeDatos= $resultado["contraseña"];
				$rol= $resultado["rol"];
				if(password_verify($contraseña,$contraseñaEnBaseDeDatos)){
					$_SESSION["ID"]=session_id();
					$_SESSION["NUMERO_DE_CLIENTE"]=$resultado["numero_cliente"];
					$_SESSION["USUARIO"]= $resultado["nombre"];
					$_SESSION["CORREO"]= $resultado["correo_electronico"];
					$_SESSION["STATUS"]= "ACTIVA";
					$_SESSION["ROL"]= $rol;
					if($rol==0){
						echo"<script>
								location.href= 'index.php?pagina=tienda';
							 </script>";
					}elseif($rol==1){
						echo"<script>
								location.href= 'index.php?pagina=mostrar_albumes';
							 </script>";
					}
					
				} else{
					$aviso .="Autenticacion incorrecta1<br>";
					echo "<pre style='background:#fff;color:#000;padding:10px;'>";
					echo "Correo buscado: " . htmlspecialchars($correoElectronico) . "<br>";
					echo "Resultado de fetch:<br>";
					print_r($resultado);   
					echo "</pre>";
					echo "contra:" .htmlspecialchars($contraseña) . "<br>";
				}
			} else{
				$aviso .="Autenticacion incorrecta2<br>";
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		echo "<div id='aviso'>".$aviso."</div>";
	}
?>
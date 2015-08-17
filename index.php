<?php session_start();?>
<?php 
if(isset($_SESSION['login'])){
	switch ($_SESSION['rol']) {
	case 1:
		header("Location: view/admin.php");
		break;
	case 2:
		header("Location: view/gerente.php");
		break;
	case 3:
		header("Location: view/tecnico.php");
		break;
	case 4:
		header("Location: view/ike.php");
		break;
	case 5:
		header("Location: view/foraneo.php");
		break;			
	}	
}

?>
<?php include "view/header.log" ?>


<script type="text/javascript">
function showModalContrasena()
{
	$("#modal-cambio-contrasena").modal();
}
function solicitarContrasena()
{
	$("#modal-cambio-contrasena").modal("hide");
	var email=document.getElementById("txt_email_contrasena").value;
	if(email.length<=0)
	{
		alert("El campo no debe estar vacio");
	}
	else
	{
		$.post("control/psw.php",{email:email},function(data){
			if(data=="true")
			{
				
				alert("Por favor revisa tu bandeja de entrada y sigue las instrucciones");
			}else{
				alert(data);
				//alert("Datos incorrectos por favor verificalos");
			}
		});
	}
}
</script>


<img src="img/logo.png" id="logo">
<h4><label>Inicio de Sesión</label></h4>
<p class="bg-success">Favor de otorgar los permisos necesarios para detectar la ubicación</p>
<div id="login">
	<div class="form-horizontal" id="form-login">
		<label>Usuario</label>
		<input type="text" class="form-control" id="usuario">
		<label>Contraseña</label>
		<input type="password" class="form-control" id="contrasena">
		<a onclick="showModalContrasena();">Solicitar cambio de usuario y contraseña</a>
		<br>
		<button class="btn btn-primary" onclick="validar();"> Iniciar sesión</button>
		<?php if(isset($_GET['ok'])){
			echo "<p class='bg-success'>Los datos han sido cambiados</p>";
		} ?>
	</div>
</div>

<?php include "view/modal_cambio_contrasena.php" ?>
<?php include "view/footer.log" ?>
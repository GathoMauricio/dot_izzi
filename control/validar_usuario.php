<?php include "conexion.php" ?>
<?php

$usuario = md5($_POST['usuario']);
$contrasena = md5($_POST['contrasena']); 

 
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="SELECT * FROM empleado LEFT JOIN usuario ON empleado.id_usuario=usuario.id_usuario WHERE usuario='".$usuario."' AND contrasena='".$contrasena."'";
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
	session_start();
	$_SESSION['login'] = $fila['nombre']." ".$fila['apaterno']." ".$fila['amaterno'];
	$_SESSION['id_empleado']=$fila['id_empleado'];
	$_SESSION['foto']=$fila['foto'];
	$_SESSION['rol'] = $fila['id_rol'];
	echo "true";
}
else{

	echo "false";
}
mysqli_close($conexion);
setcookie('PHPSESSID', $_COOKIE['PHPSESSID'],1000); 
 ?>

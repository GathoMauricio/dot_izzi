<?php header('Access-Control-Allow-Origin: *'); ?>	
<?php include "conexion.php" ?>
<?php 
$usuario = md5($_POST['usuario']);
$contrasena = md5($_POST['contrasena']); 

$consulta="SELECT * FROM empleado LEFT JOIN usuario ON empleado.id_usuario=usuario.id_usuario WHERE usuario='".$usuario."' AND contrasena='".$contrasena."'";
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
	echo $fila['id_empleado'];	
}
else{

	echo "0";
}
mysqli_close($conexion);
 ?>
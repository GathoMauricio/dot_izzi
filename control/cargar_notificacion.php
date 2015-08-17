
<?php 
header("X-XSS-Protection: 0");
include "../control/conexion.php";
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="SELECT * FROM notificacion";
$datos=mysqli_query($conexion,$consulta);
while($fila=mysqli_fetch_array($datos))
{
	echo "<p class='bg-success'><button class='btn btn-success' id='".$fila['id_notificacion']."' onclick='eliminarNotificacion(this.id);'><span class='glyphicon glyphicon-remove' ></span></button> ".$fila['notificacion']."</p>";
}
mysqli_close($conexion);
 ?>
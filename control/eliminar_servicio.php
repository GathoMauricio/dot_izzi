<?php 
include "../control/conexion.php";
$expediente=$_POST['expediente'];
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);

$consulta="DELETE FROM imagen WHERE id_expediente=".$expediente;
mysqli_query($conexion,$consulta);
$consulta="DELETE FROM comentarios WHERE id_publicacion=".$expediente;
mysqli_query($conexion,$consulta);
$consulta="DELETE FROM respuesta WHERE id_expediente=".$expediente;
mysqli_query($conexion,$consulta);
$consulta="DELETE FROM expediente WHERE id_expediente=".$expediente;
mysqli_query($conexion,$consulta);

mysqli_close($conexion);


echo "EL SERVICIO HA SIDO ELIMINADO";
 ?>
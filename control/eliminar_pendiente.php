<?php 
include "conexion.php";
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="DELETE FROM pendiente WHERE id_pendiente=".$_POST['id'];
mysqli_query($conexion,$consulta);
$consulta="DELETE FROM comentario_pendiente WHERE id_pendiente=".$_POST['id'];
mysqli_query($conexion,$consulta);

echo "Pendiente eliminado";
 ?>
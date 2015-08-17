<?php 
$host_bd="localhost";
$usuario_bd="root";
$contrasena_bd="";
$base_datos="dot";

$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
 ?>
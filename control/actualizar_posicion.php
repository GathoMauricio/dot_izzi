<?php 
header("X-XSS-Protection: 0");
session_start();
include "../control/conexion.php";
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
date_default_timezone_set("Mexico/General");
$fecha=date('Y-m-d');
$hora=date('H:i:s');

$consulta="UPDATE empleado SET 
lat='".$_POST['lat']."',
lon='".$_POST['lon']."',
aprox='".$_POST['aprox']."',
fecha_conexion='".$fecha."',
hora_conexion='".$hora."'  
WHERE id_empleado=".$_SESSION['id_empleado'];
try {
mysqli_query($conexion,$consulta);	
} catch (Exception $e) {
	
}

 ?>
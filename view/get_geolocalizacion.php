<?php 
include "../control/conexion.php";
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta = "SELECT * FROM empleado WHERE id_empleado=".$_POST['id'];
$datos=mysqli_query($conexion,$consulta);
$lat="";
$lon="";
$aprox="";
if($fila=mysqli_fetch_array($datos))
{
	$lat=$fila['lat'];
	$lon=$fila['lon'];
	$aprox=$fila['aprox'];
}
echo "?lat=".$lat."&lon=".$lon."&aprox=".$aprox;
 ?>

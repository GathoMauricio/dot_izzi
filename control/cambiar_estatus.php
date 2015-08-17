<?php 
include "conexion.php" ;
$expediente=$_POST['expediente'];
$estatus=$_POST['estatus'];
$solucion=$_POST['solucion'];

$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
date_default_timezone_set("Mexico/General");
$hora = date("H:i");
$consulta="";
switch ($estatus) {
	case 1:
		$consulta="UPDATE expediente SET id_estatus=".$estatus." WHERE id_expediente = ".$expediente;
		break;
	case 2:
		$consulta="UPDATE expediente SET id_estatus=".$estatus.",h_inicio='".$hora."' WHERE id_expediente = ".$expediente;
		break;
	case 3:
		$consulta="UPDATE expediente SET id_estatus=".$estatus.",h_final='".$hora."',d_solucion='".$solucion."' WHERE id_expediente = ".$expediente;
		break;
	case 4:
		$consulta="UPDATE expediente SET id_estatus=2 WHERE id_expediente = ".$expediente;
		break;	
}
mysqli_query($conexion,$consulta);
mysqli_close($conexion);
 ?>
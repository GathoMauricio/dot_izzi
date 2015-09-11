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
$consulta="SELECT * FROM expediente ex LEFT JOIN empleado e 
ON ex.id_tecnico=e.id_empleado WHERE ex.id_expediente=".$expediente;
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
	switch ($fila['id_estatus']) {
		case 1:
			$mensaje="MOVIL: \n".$fila['nombre']." ".$fila['apaterno']." Ha puesto el estatus del expediente ".$fila['id_expediente']." en Pendiente";
			break;
		case 2:
			$mensaje="MOVIL:\n".$fila['nombre']." ".$fila['apaterno']." Ha puesto el estatus del expediente ".$fila['id_expediente']." en Proceso";
			break;
		case 3:
			$mensaje="MOVIL: \n".$fila['nombre']." ".$fila['apaterno']." Ha puesto el estatus del expediente ".$fila['id_expediente']." en Finalizado";
			break;
		
	}
}

require 'Pusher.php';

$pusher=PusherInstance::get_pusher();

$pusher->trigger(
'canal_notificacion',
'nueva_notificacion',
array('mensaje' => $mensaje)
);
mysqli_close($conexion);
 ?>
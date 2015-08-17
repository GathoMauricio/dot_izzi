<?php session_start() ?>
<?php include "../control/conexion.php" ?>
<?php 
$id=$_POST['id'];
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");

$consulta="SELECT * FROM expediente_ike WHERE id_expediente=".$id;
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
$expediente=$fila['id_expediente'];
$tecnico=$fila['id_tecnico'];
$estatus=$fila['id_estatus'];
$mapa=$fila['mapa'];
$fecha=$fila['fecha'];
$solicitud=$fila['solicitud'];
$usuario=$fila['usuario'];
$direccion=$fila['direccion_u'];
$telefono=$fila['telefono_u'];
$horario1=$fila['horario1'];
$horario2=$fila['horario2'];
$inicio=$fila['h_inicio'];
$final=$fila['h_final'];
$problema=$fila['d_problema'];
$solucion=$fila['d_solucion'];
$locacion=$fila['locacion'];
$costo=$fila['costo'];
$capturista=$fila['capturista'];
$tipo=$fila['tipo'];
}

$consulta="INSERT INTO expediente
(
	id_expediente,
	id_tecnico,
	id_estatus,
	mapa,
	fecha,
	solicitud,
	usuario,
	direccion_u,
	telefono_u,
	horario1,
	horario2,
	h_inicio,
	h_final,
	d_problema,
	d_solucion,
	locacion,
	costo,
	capturista,
	id_estatus_ike,
	tipo
) 
VALUES 
(
	".$expediente.",
	".$tecnico.",
	".$estatus.",
	'".$mapa."',
	'".$fecha."',
	'".$solicitud."',
	'".$usuario."',
	'".$direccion."',
	'".$telefono."',
	'".$horario1."',
	'".$horario2."',
	'".$inicio."',
	'".$final."',
	'".$problema."',
	'".$solucion."',
	'".$locacion."',
	'".$costo."',
	'Iké: ".$capturista."',
	1,
	'".$tipo."')";
mysqli_query($conexion,$consulta);


$consulta="DELETE FROM expediente_ike WHERE id_expediente=".$id;
mysqli_query($conexion,$consulta);
mysqli_close($conexion);


 ?>
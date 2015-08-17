<?php 
header("X-XSS-Protection: 0");
include "../control/conexion.php";
$expediente=$_POST['expediente'];
$estatus=1;
$mapa=$_POST['mapa'];
$fecha=$_POST['fecha'];
$solicitud=$_POST['solicitud'];
$usuario=$_POST['usuario'];
$direccion=$_POST['direccion'];
$telefono="";
$horario1=$_POST['horario1'];
$horario2=$_POST['horario2'];
$inicio="";
$final="";
$problema=$_POST['problema'];
$solucion="";
$capturista=$_POST['capturista'];
$locacion=$_POST['locacion'];
$costo=$_POST['costo'];
$tipo=$_POST['tipo'];
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="INSERT INTO expediente_ike 
(
	id_expediente,
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
	'".$capturista."',
	1,
	'".$tipo."')";
mysqli_query($conexion,$consulta);



mysqli_close($conexion);
header("Location: ../view/nuevo_servicio_ike.php?r=Servicio guardado sujeto a validación");
 ?>
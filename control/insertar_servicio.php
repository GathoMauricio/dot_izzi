<?php 
header("X-XSS-Protection: 0");
include "../control/conexion.php";
$expediente=$_POST['expediente'];
$tecnico=$_POST['tecnico'];
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
	'".$capturista."',
	1,
	'".$tipo."')";
mysqli_query($conexion,$consulta);

$consulta='SELECT * FROM empleado WHERE id_empleado='.$tecnico." AND localidad != 'DF'";
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
	require_once 'mail/lib/swift_required.php';

	$mensaje="Nuevo servicio expediente:".$expediente." Fecha: ".$fecha;

    $transport = Swift_SmtpTransport::newInstance('mail.dotredes.com', 587)
      ->setUsername('asistencia@dotredes.com')
      ->setPassword('asistencia2769')
    ;
    
    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance("Nuevo Servicio")
      ->setFrom(array('asistencia@dotredes.com' => 'DOT REDES'))
      ->setTo(array($fila['email'] => 'CONTACTO'))
      ->setBody($mensaje)
    ;
   $mailer->send($message);
}

mysqli_close($conexion);
header("Location: ../view/nuevo_servicio.php");
 ?>


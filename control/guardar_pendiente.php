<?php 
header("X-XSS-Protection: 0");
include "conexion.php";
session_start();

$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");

$consulta="INSERT INTO pendiente
(
	id_empleado,titulo,descripcion,fecha,hora
)
VALUES
(
	".$_POST['empleado'].",
	'".$_POST['titulo']."',
	'".$_POST['descripcion']."',
	'".$_POST['fecha']."',
  '".$_POST['hora']."'
)";
mysqli_query($conexion,$consulta);
$id=mysqli_insert_id($conexion);

$consulta="SELECT * FROM pendiente p LEFT JOIN empleado e on p.id_empleado=e.id_empleado WHERE p.id_pendiente=".$id;
$datos=mysqli_query($conexion,$consulta);
$nombre="";
$email="";
if($fila=mysqli_fetch_array($datos))
{
$nombre=$fila['nombre']." ".$fila['apaterno']." ".$fila['amaterno'];
$email=$fila['email'];
}


$mensaje=$_SESSION['login']." te ha asignado la  actividad  ".$_POST['titulo'];

require_once 'mail/lib/swift_required.php';
    $transport = Swift_SmtpTransport::newInstance('mail.dotredes.com', 587)
      ->setUsername('asistencia@dotredes.com')
      ->setPassword('asistencia2769')
    ;
    
    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance("Reasignación de actividad")
      ->setFrom(array('asistencia@dotredes.com' => 'DOT REDES'))
      ->setTo(array( $email => 'CONTACTO'))
      ->setBody($mensaje)
    ;
   $mailer->send($message);


echo "Pendiente almacenado con éxito";
mysqli_close($conexion);
 ?>
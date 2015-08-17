<?php 
header("X-XSS-Protection: 0");
include "conexion.php";
session_start();

$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");


$consulta="UPDATE pendiente SET 
id_empleado=".$_POST['empleado'].",
titulo='".$_POST['titulo']."',
descripcion='".$_POST['descripcion']."',
fecha='".$_POST['fecha']."',
hora='".$_POST['hora']."'  
WHERE id_pendiente=".$_POST['id'];
mysqli_query($conexion,$consulta);
$consulta="SELECT * FROM pendiente p LEFT JOIN empleado e on p.id_empleado=e.id_empleado WHERE p.id_pendiente=".$_POST['id'];
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
      ->setUsername('contacto@dotredes.com')
      ->setPassword('contacto')
    ;
    
    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance("Reasignación de actividad")
      ->setFrom(array('contacto@dotredes.com' => 'DOT REDES'))
      ->setTo(array( $email => 'CONTACTO'))
      ->setBody($mensaje)
    ;
   $mailer->send($message);


echo "Pendiente actualizado con éxito";
mysqli_close($conexion);
 ?>
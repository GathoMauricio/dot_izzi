<?php 
include "conexion.php";
session_start();
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="UPDATE pendiente SET id_empleado=".$_POST['empleado']." WHERE id_pendiente=".$_POST['id'];
mysqli_query($conexion,$consulta);


$consulta="SELECT * FROM pendiente p LEFT JOIN empleado e on p.id_empleado=e.id_empleado WHERE id_pendiente=".$_POST['id'];
$datos=mysqli_query($conexion,$consulta);
$nombre="";
$email="";
$titulo="";
if($fila=mysqli_fetch_array($datos))
{
$nombre=$fila['nombre']." ".$fila['apaterno']." ".$fila['amaterno'];
$email=$fila['email'];
$titulo=$fila['titulo'];
}

//Enviando EMAIL al ADMIN
$mensaje=$_SESSION['login']." ha reasignado la actividad ".$_POST['id']." a ".$nombre."\n".$titulo;

require_once 'mail/lib/swift_required.php';
    $transport = Swift_SmtpTransport::newInstance('mail.dotredes.com', 587)
      ->setUsername('contacto@dotredes.com')
      ->setPassword('contacto')
    ;
    
    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance("Reasignación de actividad")
      ->setFrom(array('contacto@dotredes.com' => 'DOT REDES'))
      ->setTo(array('rortuno@dotredes.com'=> 'CONTACTO'))
      ->setBody($mensaje)
    ;
   $mailer->send($message);

   //Enviando EMAIL al correo prueba

    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance("Reasignación de actividad")
      ->setFrom(array('contacto@dotredes.com' => 'DOT REDES'))
      ->setTo(array( "systems@dotredes.com" => 'CONTACTO'))
      ->setBody($mensaje)
    ;
   $mailer->send($message);

   //Enviando EMAIL al empleado asignado

    $mensaje=$_SESSION['login']." te ha asignado la actividad ".$_POST['id']."\n".$titulo;

    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance("Reasignación de actividad")
      ->setFrom(array('contacto@dotredes.com' => 'DOT REDES'))
      ->setTo(array( $email => 'CONTACTO'))
      ->setBody($mensaje)
    ;
   $mailer->send($message);

echo "Pendiente ".$_POST['id']." Reasignación completa";
 ?>
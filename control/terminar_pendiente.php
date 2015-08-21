<?php include "../control/conexion.php" ?>
<?php 
session_start();
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");

$comentario="Terminado por ".$_SESSION['login'].": ".$_POST['comentario'];

$consulta="UPDATE pendiente SET id_estatus=3 , comentario='".$comentario."' WHERE id_pendiente=".$_POST['id'];

mysqli_query($conexion,$consulta);


require_once 'mail/lib/swift_required.php';
    $transport = Swift_SmtpTransport::newInstance('mail.dotredes.com', 587)
      ->setUsername('asistencia@dotredes.com')
      ->setPassword('asistencia2769')
    ;
    
    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance("Termino de pendiente ".$_POST['id'])
      ->setFrom(array('asistencia@dotredes.com' => 'DOT REDES'))
      ->setTo(array('rortuno@dotredes.com'=> 'CONTACTO'))
      ->setBody($comentario)
    ;
   $mailer->send($message);
   
   /*$mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance("Termino de pendiente ".$_POST['id'])
      ->setFrom(array('asistencia@dotredes.com' => 'DOT REDES'))
      ->setTo(array('desarrollo@dotredes.com'=> 'CONTACTO'))
      ->setBody($comentario)
    ;
   $mailer->send($message);*/
?>
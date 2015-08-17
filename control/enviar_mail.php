<?php 
session_start();
$mensaje="";
if(isset($_POST['solucion']))
{
$mensaje = $_SESSION['login']." ha ".$_POST['tipo']." con el Expediente ".$_POST['expediente'] ."\nDiagnóstico: ".$_POST['solucion'];
$mensaje = wordwrap($mensaje, 70, "\r\n");
}else
{
	if(isset($_POST['comentario']))
	{
		$mensaje = $_SESSION['login']." ha ".$_POST['tipo']." con el Expediente ".$_POST['expediente'] ."\nComentario: ".$_POST['comentario'];
	}else{
			$mensaje = $_SESSION['login']." ha ".$_POST['tipo']." con el Expediente ".$_POST['expediente'] ;	
		 }
}
require_once 'mail/lib/swift_required.php';
    $transport = Swift_SmtpTransport::newInstance('mail.dotredes.com', 587)
      ->setUsername('contacto@dotredes.com')
      ->setPassword('contacto')
    ;
    
    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance($_POST['tipo'])
      ->setFrom(array('contacto@dotredes.com' => 'DOT REDES'))
      ->setTo(array('comercial@dotredes.com'=> 'CONTACTO'))
      ->setBody($mensaje)
    ;
   $mailer->send($message);

   $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance($_POST['tipo'])
      ->setFrom(array('contacto@dotredes.com' => 'DOT REDES'))
      ->setTo(array('ventas@dotredes.com'=> 'CONTACTO'))
      ->setBody($mensaje)
    ;
   $mailer->send($message);

   $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance($_POST['tipo'])
      ->setFrom(array('contacto@dotredes.com' => 'DOT REDES'))
      ->setTo(array('rortuno@dotredes.com'=> 'CONTACTO'))
      ->setBody($mensaje)
    ;
   $mailer->send($message);

   $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance($_SESSION['login']." ha ".$_POST['tipo'])
      ->setFrom(array('contacto@dotredes.com' => 'DOT REDES'))
      ->setTo(array('katze.systems@gmail.com'=> 'CONTACTO'))
      ->setBody($mensaje)
    ;
   $mailer->send($message);

   if($_POST['tipo']=="Agregado un comentario")
   {
      include "conexion.php";
      $consulta="SELECT * 
      FROM  empleado 
      LEFT JOIN expediente ON empleado.id_empleado = expediente.id_tecnico
      LEFT JOIN usuario ON usuario.id_usuario = empleado.id_usuario
      WHERE expediente.id_expediente =".$_POST['expediente'];
      
      $conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
      mysqli_set_charset($conexion, "utf8");
      $datos=mysqli_query($conexion,$consulta);
      if($fila=mysqli_fetch_array($datos))
      {
        $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance($_SESSION['login']." ha ".$_POST['tipo'])
       ->setFrom(array('contacto@dotredes.com' => 'DOT REDES'))
       ->setTo(array($fila['email'] => 'CONTACTO'))
       ->setBody($mensaje)
      ;
        $mailer->send($message);
      }
   }

?>
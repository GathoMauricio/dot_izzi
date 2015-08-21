<?php 
include 'conexion.php';
require_once 'mail/lib/swift_required.php';
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");

$fecha = date('Y-m-d');
$tiempo=getdate();
$hora = $tiempo['hours'].":".$tiempo['minutes'].":00";

$transport = Swift_SmtpTransport::newInstance('mail.dotredes.com', 587)
      ->setUsername('asistencia@dotredes.com')
      ->setPassword('asistencia2769')
    ;


echo "<h2>Pendientes caducados hoy</h2>";
$consulta="SELECT * FROM pendiente p LEFT JOIN empleado e ON 
p.id_empleado=e.id_empleado WHERE fecha='".$fecha."' AND hora <= '".$hora."' AND id_estatus=1";


$datos=mysqli_query($conexion,$consulta);

$contador=0;
echo "<table border 1>";
echo "<tr><td>TITULO</td><td>EMPLEADO</td><td>FECHA</td><td>HORA</td></tr>";
while($fila=mysqli_fetch_array($datos))
{
	$contador++;
echo "<tr><td>".$fila['titulo']."</td><td>".$fila['nombre']." ".$fila['apaterno']."</td><td>".$fila['fecha']."</td><td>".$fila['hora']." Hrs</td></tr>";

$mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance("Tienes un pendiente caducado")
      ->setFrom(array('asistencia@dotredes.com' => 'DOT REDES'))
      ->setTo(array($fila['email'] => 'CONTACTO'))
      ->setBody("Pendiente caducado: ".$fila['titulo']." Favor de checarlo o editar la Fecha/Hora")
    ;
   $mailer->send($message);

/*$mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance("Pendiente caducado")
      ->setFrom(array('contacto@dotredes.com' => 'DOT REDES'))
      ->setTo(array('systems@dotredes.com'=> 'CONTACTO'))
      ->setBody("El pendiente ".$fila['titulo']." ha caducado \n Responsable: ".$fila['nombre']." ".$fila['apaterno'])
    ;
   $mailer->send($message);*/

   $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance("Pendiente caducado")
      ->setFrom(array('asistencia@dotredes.com' => 'DOT REDES'))
      ->setTo(array('rortuno@dotredes.com'=> 'CONTACTO'))
      ->setBody("El pendiente ".$fila['titulo']." ha caducado \n Responsable: ".$fila['nombre']." ".$fila['apaterno'])
    ;
   $mailer->send($message);

}
echo "</table>";
if($contador<=0)
{
	echo '<h4>No hay pendientes caducados</h4>';
}
echo "<h2>Pendientes pasados</h2>";

$consulta = "SELECT * FROM pendiente p LEFT JOIN empleado e ON 
p.id_empleado=e.id_empleado WHERE fecha < '".$fecha."' AND id_estatus=1";
$datos=mysqli_query($conexion,$consulta);

$contador=0;
echo "<table border 1>";
echo "<tr><td>TITULO</td><td>EMPLEADO</td><td>FECHA</td><td>HORA</td></tr>";
while($fila=mysqli_fetch_array($datos))
{
	$contador++;

echo "<tr><td>".$fila['titulo']."</td><td>".$fila['nombre']." ".$fila['apaterno']."</td><td>".$fila['fecha']."</td><td>".$fila['hora']." Hrs</td></tr>";

$mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance("Tienes un pendiente caducado")
      ->setFrom(array('asistencia@dotredes.com' => 'DOT REDES'))
      ->setTo(array($fila['email'] => 'CONTACTO'))
      ->setBody("Pendiente caducado: ".$fila['titulo']." Favor de checarlo o editar la Fecha/Hora")
    ;
   $mailer->send($message);

/*$mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance("Pendiente caducado")
      ->setFrom(array('contacto@dotredes.com' => 'DOT REDES'))
      ->setTo(array('systems@dotredes.com'=> 'CONTACTO'))
      ->setBody("El pendiente ".$fila['titulo']." ha caducado \n Responsable: ".$fila['nombre']." ".$fila['apaterno'])
    ;
   $mailer->send($message);*/

   $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance("Pendiente caducado")
      ->setFrom(array('asistencia@dotredes.com' => 'DOT REDES'))
      ->setTo(array('rortuno@dotredes.com'=> 'CONTACTO'))
      ->setBody("El pendiente ".$fila['titulo']." ha caducado \n Responsable: ".$fila['nombre']." ".$fila['apaterno'])
    ;
   $mailer->send($message);

}
echo "</table>";
if($contador<=0)
{
	echo '<h4>No hay pendientes caducados</h4>';
}
 ?>
<?php include "../control/conexion.php" ?>
<?php 
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="SELECT * FROM empleado WHERE email='".$_POST['email']."'";
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
	$key=md5(microtime());
	$mensaje="Para continuar sigue la siguiente liga  http://dotredes.dyndns.biz:18888/dot_izzi/control/psw_auth.php?auth=".$key;

	require_once 'mail/lib/swift_required.php';
    $transport = Swift_SmtpTransport::newInstance('mail.dotredes.com', 587)
      ->setUsername('asistencia@dotredes.com')
      ->setPassword('asistencia2769')
    ;
    
    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance("Restaurar Datos de Acceso")
      ->setFrom(array('asistencia@dotredes.com' => 'DOT REDES'))
      ->setTo(array($fila['email']=> 'CONTACTO'))
      ->setBody($mensaje)
    ;
   $mailer->send($message);

$consulta="UPDATE `usuario` SET `key`= '".$key."' WHERE `id_usuario` = ".$fila['id_usuario'];
mysqli_query($conexion,$consulta);
echo "true";
}else
{
echo "false";
}
?>
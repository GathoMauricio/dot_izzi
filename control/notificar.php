<?php 
require 'Pusher.php';

$pusher=PusherInstance::get_pusher();

$pusher->trigger(
'canal_notificacion',
'nueva_notificacion',
array('mensaje' => $mensaje)
);

session_start();
$mensaje="";
if(isset($_POST['solucion']))
{
$mensaje = "WEB: ".$_SESSION['login']." ha ".$_POST['tipo']." con el Expediente ".$_POST['expediente'] ."\nDiagnóstico: ".$_POST['solucion'];
$mensaje = wordwrap($mensaje, 70, "\r\n");
}else
{
	if(isset($_POST['comentario']))
	{
		$mensaje = "WEB: ".$_SESSION['login']." ha ".$_POST['tipo']." con el Expediente ".$_POST['expediente'] ."\nComentario: ".$_POST['comentario'];
	}else{
			$mensaje = "WEB: ".$_SESSION['login']." ha ".$_POST['tipo']." con el Expediente ".$_POST['expediente'] ;	
		 }
}

$pusher->trigger(
'canal_notificacion',
'nueva_notificacion',
array('mensaje' => $mensaje)
);
 ?>
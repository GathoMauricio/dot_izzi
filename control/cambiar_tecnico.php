<?php 
include 'conexion.php';
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$id_tecnico=$_POST['id_tecnico'];
$id_expediente=$_POST['id_expediente'];
$consulta="UPDATE expediente SET id_tecnico=".$id_tecnico." WHERE id_expediente=".$id_expediente;
mysqli_query($conexion,$consulta);
require 'Pusher.php';

$pusher=PusherInstance::get_pusher();

$pusher->trigger(
'dot_mensaje',
'mensaje'.$id_tecnico,
array('mensaje' => "Se te ha asignado el expediente ".$id_expediente,
	 'expediente'=>$id_expediente)
);
echo"Expediente actualizado";
 ?>
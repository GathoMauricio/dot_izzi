<?php session_start() ?>
<?php include "../control/conexion.php" ?>
<?php 
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");

$id_pendiente=$_POST['id_pendiente'];
$comentario=$_POST['comentario'];
$fecha=date('Y-m-d');
$hora=date('H:i:s');

$consulta="INSERT INTO comentario_pendiente 
(id_pendiente,comentador,comentario,fecha,hora,foto_perfil) 
VALUES (".$id_pendiente.",'".$_SESSION['login']."','".$comentario."','".$fecha."','".$hora."','".$_SESSION['foto']."')";

if(isset($_POST['empleado']))
{
	$consultaEmpleado="SELECT * FROM empleado WHERE id_empleado=".$_POST['empleado'];
	$datos=mysqli_query($conexion,$consultaEmpleado);
	if($fila=mysqli_fetch_array($datos))
	{
		$consulta="INSERT INTO comentario_pendiente 
(id_pendiente,comentador,comentario,fecha,hora,foto_perfil) 
VALUES (".$id_pendiente.",'".$fila['nombre']." ".$fila['apaterno']."','".$comentario."','".$fecha."','".$hora."','".$fila['foto']."')";
	}
}
mysqli_query($conexion,$consulta);

header('Access-Control-Allow-Origin: *');


$consulta="SELECT * FROM pendiente WHERE id_pendiente=".$id_pendiente;
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
	$canal=$fila['id_empleado'];
}
require "Pusher.php";
$pusher2 = PusherInstance::get_pusher();
$pusher2->trigger(
'dot_mensaje',
'mensaje'.$canal,
array('mensaje' => "Se ha agregado un nuevo comentario en el pendiente ".$id_pendiente,
	 'expediente'=>$id_pendiente)
);

$pusher2 = PusherInstance::get_pusher();
$pusher2->trigger(
'canal_notificacion',
'nueva_notificacion',
array('mensaje' => "Se ha agregado un nuevo comentario en el pendiente ".$id_pendiente,
	 'expediente'=>$id_pendiente)
);
 ?>
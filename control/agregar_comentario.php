<?php session_start() ?>
<?php include "../control/conexion.php" ?>
<?php 
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");

$id_expediente=$_POST['id_expediente'];
$comentario=$_POST['comentario'];
$fecha=date('Y-m-d');
$hora=date('H:i:s');

$consulta="INSERT INTO comentarios 
(id_publicacion,comentador,comentario,fecha,hora,foto_perfil) 
VALUES (".$id_expediente.",'".$_SESSION['login']."','".$comentario."','".$fecha."','".$hora."','".$_SESSION['foto']."')";

if(isset($_POST['id_empleado']))
{
$consultaEmpleado="SELECT * FROM empleado WHERE id_empleado=".$_POST['id_empleado'];
$datos=mysqli_query($conexion,$consultaEmpleado);
if($fila=mysqli_fetch_array($datos))
{
	$empleado=$fila['nombre'].' '.$fila['apaterno'].' '.$fila['amaterno'];
	$foto=$fila['foto'];
}	
	$consulta="INSERT INTO comentarios 
(id_publicacion,comentador,comentario,fecha,hora,foto_perfil) 
VALUES (".$id_expediente.",'".$empleado."','".$comentario."','".$fecha."','".$hora."','".$foto."')";
}
mysqli_query($conexion,$consulta);



header('Access-Control-Allow-Origin: *');


$consulta="SELECT * FROM expediente WHERE id_expediente=".$id_expediente;
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
	$canal=$fila['id_tecnico'];
}
require "Pusher.php";
$pusher2 = PusherInstance::get_pusher();
$pusher2->trigger(
'dot_mensaje',
'mensaje'.$canal,
array('mensaje' => "Se ha agregado un nuevo comentario en el expediente ".$id_expediente,
	 'expediente'=>$id_expediente)
);

$pusher2 = PusherInstance::get_pusher();
$pusher2->trigger(
'canal_notificacion',
'nueva_notificacion',
array('mensaje' => "Se ha agregado un nuevo comentario en el expediente ".$id_expediente,
	 'expediente'=>$id_expediente)
);


echo "Alerta enviada!!!";

 ?>
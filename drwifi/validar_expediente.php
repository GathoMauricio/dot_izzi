<?php
header('Access-Control-Allow-Origin: *');
include "../mobile/conexion.php";
$consulta="SELECT * FROM expediente WHERE id_expediente=".$_POST['expediente']. AND id_estatus=1;
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
	$json=array(
		"expediente"=>$fila['id_expediente'],
		"usuario"=>$fila['usuario']
		);
}else
{
	echo false;
}
 ?>
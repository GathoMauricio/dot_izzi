<?php
header('Access-Control-Allow-Origin: *');
include "../mobile/conexion.php";
$consulta="SELECT * FROM expediente 
WHERE id_expediente=".$_POST['expediente']." 
AND fecha='".$_POST['fecha']."' 
AND id_estatus=1";
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
	echo $fila['id_expediente'];
}else
{
	echo false;
}
 ?>
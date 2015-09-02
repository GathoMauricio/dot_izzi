<?php 
include "conexion.php";
$consulta="SELECT * FROM expediente WHERE id_expediente=".$_POST['expediente'];
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
	if($fila['id_estatus_encuesta'] > 1)
	{
		echo '2';//Si la encuesta es 2 ya se realizo
	}else
	{
		echo '1';//si la encuesta es 1 no se ha realizado
	}
}
 ?>
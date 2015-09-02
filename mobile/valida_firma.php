<?php 
include "conexion.php";
$consulta="SELECT * FROM expediente WHERE id_expediente=".$_POST['expediente'];
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
	echo $fila['firma']; //si viene vacia aún no firma el usuario, si trae algo es la ruta de la imagen
}
 ?>
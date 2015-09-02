<?php 
include "conexion.php";
$consulta="SELECT count(id_imagen) as contador FROM imagen WHERE id_expediente=".$_POST['expediente'];
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
	echo $fila['contador']; //si vhay por lo menos una imagen regresa un numer mayor q 0
}else{
	echo '0';
}
 ?>
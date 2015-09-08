<?php header('Access-Control-Allow-Origin: *'); ?>
<?php include "conexion.php" ?>
<?php 
date_default_timezone_set("Mexico/General");
$aprox="";
if(isset($_POST['aprox']))
{
	$aprox=$_POST['aprox'];
}

$consulta="UPDATE empleado SET 
lat='".$_POST['lat']."',
lon='".$_POST['lon']."',
aprox='".$aprox."',
fecha_conexion='".date('Y-m-d')."',
hora_conexion='".date('h:i:s')."' 
WHERE id_empleado=".$_POST['id_empleado'];
mysqli_query($conexion,$consulta);
echo "Lat ".$_POST['lat']."  /  lon".$_POST['lon']."/Aprox:".$aprox;
 ?>
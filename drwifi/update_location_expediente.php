<?php 

header('Access-Control-Allow-Origin: *');
include "../mobile/conexion.php";
$consulta="UPDATE expediente SET 
lat_expediente='".$_POST['lat']."',
lon_expediente='".$_POST['lon']."' 
WHERE id_expediente=".$_POST['expediente'];
mysqli_query($conexion,$consulta);
 ?>
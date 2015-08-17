<?php header('Access-Control-Allow-Origin: *'); ?>	
<?php include "conexion.php" ?>
<?php 
$consulta="UPDATE empleado SET 
lat='".$_POST['lat']."',
lon='".$_POST['lon']."'
WHERE id_empleado=".$_POST['id_empleado'];
mysqli_query($conexion,$consulta);
echo "Lat ".$_POST['lat']."  /  lon".$_POST['lon'];
 ?>
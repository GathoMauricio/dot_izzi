<?php include "../control/conexion.php" ?>
<?php 
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="SELECT i.ruta  FROM imagen i LEFT JOIN expediente e ON i.id_expediente=e.id_expediente  WHERE e.id_expediente=".$_POST['expediente'];
$datos=mysqli_query($conexion,$consulta);
while($fila=mysqli_fetch_array($datos))
{
	echo '<img id="img_servicio" src="../images/'.$fila['ruta'].'">';
}
mysqli_close($conexion);
 ?>
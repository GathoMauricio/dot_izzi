<?php include "../control/conexion.php" ?>
<?php 
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="SELECT firma FROM expediente WHERE id_expediente=".$_POST['expediente'];
$datos=mysqli_query($conexion,$consulta);
while($fila=mysqli_fetch_array($datos))
{
	if(strlen($fila['firma']) > 0)
	echo '<img id="img_servicio" src="http://dotredes.dyndns.biz:18888/dot_izzi/mobile/firma/img_firmas/'.$fila['firma'].'">';
	else echo '<label>Este expediente aún no tiene firma!!!</label>';
}
mysqli_close($conexion);
 ?>
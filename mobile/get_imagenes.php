<?php include "conexion.php" ?>
<?php 
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="SELECT *  FROM imagen i LEFT JOIN expediente e ON i.id_expediente=e.id_expediente  WHERE e.id_expediente=".$_POST['expediente'];
$datos=mysqli_query($conexion,$consulta);
echo '<div style="height:300px;overflow:scroll;">';
while($fila=mysqli_fetch_array($datos))
{
	echo '<img id="'.$fila['id_imagen'].'" onclick="eliminarFoto(this.id,'.$_POST['expediente'].');" src="http://dotredes.dyndns.biz:18888/dot_izzi/images/'.$fila['ruta'].'" width="100" height="100" style="padding:2px;">';
}
echo '</div>';
mysqli_close($conexion);
 ?>
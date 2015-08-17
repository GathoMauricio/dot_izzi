
<?php 
header("X-XSS-Protection: 0");
include "../control/conexion.php";
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="DELETE FROM notificacion WHERE id_notificacion=".$_POST['id_notificacion'];
mysqli_query($conexion,$consulta);
mysqli_close($conexion);
 ?>
<?php include "../control/conexion.php" ?>
<?php 
session_start();
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="SELECT * from expediente WHERE id_tecnico=".$_SESSION['id_empleado']." AND id_estatus=1";

$datos=mysqli_query($conexion,$consulta);

while ($fila=mysqli_fetch_array($datos)) {
	echo "<p class='bg-info'><i>Pendiente:</i> Fecha: ".$fila['fecha']." / Expediente: ".$fila['id_expediente']."</p>";
}
 ?>
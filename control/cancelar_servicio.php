<?php 
header("X-XSS-Protection: 0");
include "../control/conexion.php";

$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");

$expediente=$_POST['expediente'];
$estatus=$_POST['estatus'];

$consulta="UPDATE expediente SET estatus_cancelacion=".$_POST['tipo']." ,id_estatus=3,
causa_cancelacion='".$_POST['causa']."' WHERE id_expediente=".$expediente;

mysqli_query($conexion,$consulta);

mysqli_close($conexion);

 ?>
<?php session_start() ?>
<?php include "../control/conexion.php" ?>
<?php 
$id=$_POST['id'];
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");

$consulta="DELETE FROM expediente_ike WHERE id_expediente=".$id;
mysqli_query($conexion,$consulta);
mysqli_close($conexion);


 ?>
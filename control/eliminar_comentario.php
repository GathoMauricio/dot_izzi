<?php 
include "../control/conexion.php";
$comentario=$_POST['comentario'];
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
$consulta="DELETE FROM comentarios WHERE id_comentario=".$comentario;
mysqli_query($conexion,$consulta);
mysqli_close($conexion);

 ?>
<?php 
include "conexion.php";
$consulta="DELETE FROM imagen WHERE id_imagen=".$_POST['id'];
mysqli_query($conexion,$consulta);
 ?>
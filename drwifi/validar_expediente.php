<?php
header('Access-Control-Allow-Origin: *');
include "../mobile/conexion.php";
$consulta="SELECT * FROM expediente WHERE id_expediente=".$_POST['expediente']. AND id_estatus=1;
 ?>
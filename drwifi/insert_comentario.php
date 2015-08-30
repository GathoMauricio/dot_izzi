<?php 
header('Access-Control-Allow-Origin: *');
include "../mobile/conexion.php";
$id_expediente=$_POST['id_expediente'];
$comentario=$_POST['comentario'];
$fecha=date('Y-m-d');
$hora=date('H:i:s');

$consulta="INSERT INTO comentarios 
(id_publicacion,comentador,comentario,fecha,hora,foto_perfil) 
VALUES (
	".$id_expediente.",
	'Usuario',
	'".$comentario."',
	'".$fecha."',
	'".$hora."',
	'drwifi.png'
	)";
mysqli_query($conexion,$consulta);
 ?>
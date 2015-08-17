<?php 
header("X-XSS-Protection: 0");
include "../control/conexion.php";
$expediente=$_POST['expediente'];
$capturista=$_POST['capturista'];
$mapa=$_POST['mapa'];
$fecha=$_POST['fecha'];
$solicitud=$_POST['solicitud'];
$usuario=$_POST['usuario'];
$direccion=$_POST['direccion'];
$horario1=$_POST['horario1'];
$horario2=$_POST['horario2'];
$problema=$_POST['problema'];
$locacion=$_POST['locacion'];
$costo=$_POST['costo'];
$tipo=$_POST['tipo'];
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");

$consulta="UPDATE expediente_ike SET 
mapa='".$mapa."',
fecha='".$fecha."',
solicitud='".$solicitud."',
usuario='".$usuario."',
direccion_u='".$direccion."',
horario1='".$horario1."',
horario2='".$horario2."',
d_problema='".$problema."',
locacion='".$locacion."',
costo='".$costo."',
capturista='".$capturista."',
tipo='".$tipo."' 
WHERE id_expediente=".$expediente;

mysqli_query($conexion,$consulta);
mysqli_close($conexion);
header("Location: ../view/editar_agendado.php?expediente=".$expediente."&act=true");
 ?>


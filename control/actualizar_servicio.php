<?php 
header("X-XSS-Protection: 0");
session_start();
include "../control/conexion.php";
$expediente=$_POST['expediente'];
$tecnico=$_POST['tecnico'];
$mapa=$_POST['mapa'];
$fecha=$_POST['fecha'];
$solicitud=$_POST['solicitud'];
$usuario=$_POST['usuario'];
$direccion=$_POST['direccion'];
$horario1=$_POST['horario1'];
$horario2=$_POST['horario2'];
$problema=$_POST['problema'];
//$capturista=$_POST['capturista'];
$locacion=$_POST['locacion'];
$costo=$_POST['costo'];
$tipo=$_POST['tipo'];
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");

$consulta="UPDATE expediente SET 
id_tecnico=".$tecnico.",
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

tipo='".$tipo."' 
WHERE id_expediente=".$expediente;

mysqli_query($conexion,$consulta);

//PROCEDURE
date_default_timezone_set("Mexico/General");
function getIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
       
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
   
    return $_SERVER['REMOTE_ADDR'];
}
$procedure="CALL bitacora('".date('Y-m-d')."','".date('H:i:s')."','".$_SESSION['login']."','Actualizo expediente ".$expediente."','".getIP()."');";
mysqli_query($conexion,$procedure);
//END PROCEDURE

mysqli_close($conexion);
header("Location: ../view/editar_servicio.php?expediente=".$expediente."&act=true");
 ?>


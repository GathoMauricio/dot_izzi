<?php 
session_start();
include "../control/conexion.php";
$expediente=$_POST['expediente'];
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);

$consulta="DELETE FROM imagen WHERE id_expediente=".$expediente;
mysqli_query($conexion,$consulta);
$consulta="DELETE FROM comentarios WHERE id_publicacion=".$expediente;
mysqli_query($conexion,$consulta);
$consulta="DELETE FROM respuesta WHERE id_expediente=".$expediente;
mysqli_query($conexion,$consulta);
$consulta="DELETE FROM expediente WHERE id_expediente=".$expediente;
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
$procedure="CALL bitacora('".date('Y-m-d')."','".date('H:i:s')."','".$_SESSION['login']."','Elimino expediente ".$expediente."','".getIP()."');";
mysqli_query($conexion,$procedure);
//END PROCEDURE
mysqli_close($conexion);


echo "EL SERVICIO HA SIDO ELIMINADO";
 ?>
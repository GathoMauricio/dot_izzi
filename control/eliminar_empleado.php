<?php 
include "../control/conexion.php";
$empleado=$_POST['empleado'];
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
$consulta="SELECT * FROM empleado WHERE id_empleado=".$empleado;
$datos=mysqli_query($conexion,$consulta);
$id_usuario=0;
if($fila=mysqli_fetch_array($datos))
{
$id_usuario=$fila['id_usuario'];
}
$consulta="DELETE FROM empleado WHERE id_empleado=".$empleado;
mysqli_query($conexion,$consulta);

$consulta="DELETE FROM usuario WHERE id_usuario=".$id_usuario;
mysqli_query($conexion,$consulta);





mysqli_close($conexion);


echo "EL EMPLEADO HA SIDO ELIMINADO";
 ?>
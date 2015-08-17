<?php 
header("X-XSS-Protection: 0");
include "../control/conexion.php";

$empleado=$_POST['empleado'];
$nombre=$_POST['nombre'];
$apaterno=$_POST['apaterno'];
$amaterno=$_POST['amaterno'];
$telefono=$_POST['telefono'];
$direccion=$_POST['direccion'];
$email=$_POST['email'];
$locacion=$_POST['locacion'];
$disponibilidad=$_POST['disponibilidad'];
$rol=$_POST['rol'];

$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");

$consulta="UPDATE empleado SET 
nombre='".$nombre."',
apaterno='".$apaterno."',
amaterno='".$amaterno."',
telefono='".$telefono."',
direccion='".$direccion."',
email='".$email."',
localidad='".$locacion."',
disponibilidad=".$disponibilidad." 
WHERE id_empleado=".$empleado;

mysqli_query($conexion,$consulta);

$consulta="UPDATE usuario set id_rol=".$rol." WHERE id_usuario=(SELECT id_usuario FROM empleado WHERE id_empleado=".$empleado.")";
mysqli_query($conexion,$consulta);

mysqli_close($conexion);
header("Location: ../view/empleados.php");
 ?>


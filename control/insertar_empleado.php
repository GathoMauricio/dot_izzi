<?php 
header("X-XSS-Protection: 0");
include "conexion.php";


$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="INSERT INTO usuario 
(
id_rol,
usuario,
contrasena
) 
VALUES 
(
".$_POST['rol'].",
'".md5($_POST['usuario'])."',
'".md5($_POST['contrasena'])."'
);";
mysqli_query($conexion,$consulta);

$id_usuario=mysqli_insert_id($conexion);


$consulta2="INSERT INTO empleado 
(
id_usuario,
nombre,
apaterno,
amaterno,
telefono,
direccion,
email,
foto,
localidad,
disponibilidad
)
VALUES
(
".$id_usuario.",
'".$_POST['nombre']."',
'".$_POST['apaterno']."',
'".$_POST['amaterno']."',
'".$_POST['telefono']."',
'".$_POST['direccion']."',
'".$_POST['email']."',
'perfil.jpg',
'".$_POST['locacion']."',
".$_POST['disponibilidad']."
)";
mysqli_query($conexion,$consulta2);

mysqli_close($conexion);
header("Location: ../view/empleados.php");
 ?>


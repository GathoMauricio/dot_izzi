<?php include "../control/conexion.php" ?>
<?php 
$expediente=$_POST['expediente'];
$r1=$_POST['r1'];
$r2=$_POST['r2'];
$r3=$_POST['r3'];
$r4=$_POST['r4'];
$r5=$_POST['r5'];
$r6=$_POST['r6'];
$r7=$_POST['r7'];
$r8=$_POST['r8'];
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
$consulta="DELETE FROM respuesta WHERE id_expediente=".$expediente;
mysqli_query($conexion,$consulta);
$consulta="INSERT INTO respuesta (id_expediente,r1,r2,r3,r4,r5,r6,r7,r8) VALUES 
('".$expediente."',
'".$r1."',
'".$r2."',
'".$r3."',
'".$r4."',
'".$r5."',
'".$r6."',
'".$r7."',
'".$r8."')";
mysqli_query($conexion,$consulta);

$consulta="UPDATE expediente SET id_estatus_encuesta=2 WHERE id_expediente=".$expediente;
mysqli_query($conexion,$consulta);
 ?>
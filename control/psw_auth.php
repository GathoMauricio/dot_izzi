<?php include "../control/conexion.php" ?>

<?php 
if(isset($_POST['id_usuario']))
{
	date_default_timezone_set("Mexico/General");
	$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
	mysqli_set_charset($conexion, "utf8");
	$consulta="UPDATE `usuario` SET `usuario`='".md5($_POST['usuario'])."',`contrasena`='".md5($_POST['contrasena'])."',`key`='' WHERE id_usuario=".$_POST['id_usuario'];

	mysqli_query($conexion,$consulta);
	header ("Location: http://dotredes.dyndns.biz:18888/dot_izzi/index.php?ok");
}

 ?>

<?php 
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="SELECT * FROM `usuario` WHERE `key` = '".$_GET['auth']."'";
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
	echo '
	<form action="psw_auth.php" method="POST">
	<input type="text" value="'.$fila['id_usuario'].'" name="id_usuario" hidden>
	<input type="text" name="usuario" placeholder="Ingresa tu nuevo usuario" required>
	<input type="text" name="contrasena" placeholder="Ingresa tu nueva contrasena" required>
	<input type="submit">
	</form>';
}else
{
	echo "<H1>Usted no tiene acceso a esta zona</H1>";
	header ("Location: http://dotredes.dyndns.biz:18888/dot_izzi/index.php");
}
?>
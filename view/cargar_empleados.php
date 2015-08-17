<?php session_start() ?>
<?php include "../control/conexion.php" ?>
<?php 
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="SELECT * FROM empleado 
LEFT JOIN usuario ON empleado.id_usuario=usuario.id_usuario 
LEFT JOIN rol ON usuario.id_rol=rol.id_rol";
if(isset($_POST['nombre']))
{
	$consulta="SELECT * FROM empleado 
	LEFT JOIN usuario ON empleado.id_usuario=usuario.id_usuario 
	LEFT JOIN rol ON usuario.id_rol=rol.id_rol 
	WHERE nombre LIKE '%".$_POST['nombre']."%' OR apaterno LIKE '%".$_POST['nombre']."%' OR amaterno LIKE '%".$_POST['nombre']."%'";
}
$datos=mysqli_query($conexion,$consulta);
$contador=0;
while($fila=mysqli_fetch_array($datos))
{
	$contador++;
	echo '<p><div class="comentario"><div style="float:right">
	<button class="btn btn-default" onclick="editarEmpleado(this.id);" id="'.$fila['id_empleado'].'"><span class="glyphicon glyphicon-pencil"  ></span></button>
	<button class="btn btn-info" onclick="editarImagen(this.id);" id="'.$fila['id_empleado'].'"><span class="glyphicon glyphicon-picture"  ></span></button>
	<button class="btn btn-danger" onclick="eliminarEmpleado(this.id);" id="'.$fila['id_empleado'].'"><span class="glyphicon glyphicon-trash"  ></span></button>
	</div>
     	<img src="../img/'.$fila['foto'].'" width="70">
     	<label style="color:#3b5998;font-size:18px;">  
     	'.$fila['nombre'].' '.$fila['apaterno'].' '.$fila['amaterno'].'
     	</label>
     	<br>
     	<div id="lbl_datos" style="padding-left:80px;"><i>'.$fila['tipo'].' - '.$fila['localidad'].'</i>
     	</div>
     	<br>
     	<p style="font-size:15px;padding-left:50px;"><label>Teléfono: </label> '.$fila['telefono'].'</p>
     	<p style="font-size:15px;padding-left:50px;"><label>E-mail: </label> '.$fila['email'].'</p>
     	<p style="font-size:15px;padding-left:50px;"><label>Dirección: </label> '.$fila['direccion'].'</p>';
    echo '
     	</div></p>';
}
if($contador<=0)
{
	echo "<center><h3>No se encontró el empleado solicitado</h3></center>";
}

mysqli_close($conexion);
 ?>
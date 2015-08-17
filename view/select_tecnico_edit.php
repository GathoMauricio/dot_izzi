<select name='tecnico' class='form-control' required>
<?php 
include "../control/conexion.php";
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="SELECT * FROM empleado LEFT JOIN usuario ON empleado.id_usuario=usuario.id_usuario Where usuario.id_rol=3 AND localidad='DF'";
if(isset($_POST['locacion']))
{
$fecha_e=$_POST['fecha'];
$horario_e=$_POST['horario'];
$clausula="";

$consulta_e="SELECT * FROM expediente WHERE fecha='".$fecha_e."' AND horario1 LIKE '%".$horario_e[0].$horario_e[1]."%'";
$datos_e=mysqli_query($conexion,$consulta_e);
while ($fila_e=mysqli_fetch_array($datos_e)) {
	//$clausula=$clausula." AND id_empleado != ".$fila_e['id_tecnico']." ";
}

$consulta="SELECT * FROM empleado LEFT JOIN usuario ON empleado.id_usuario=usuario.id_usuario Where usuario.id_rol=3 AND localidad='".$_POST['locacion']."' AND disponibilidad != 2 ".$clausula;
$fecha=date('w',strtotime($_POST['fecha']));
if($fecha==6)
{
    $consulta="SELECT * FROM empleado LEFT JOIN usuario ON empleado.id_usuario=usuario.id_usuario Where usuario.id_rol=3 AND localidad='".$_POST['locacion']."' ".$clausula;
}

if($fecha==0)
{
    $consulta="SELECT * FROM empleado LEFT JOIN usuario ON empleado.id_usuario=usuario.id_usuario Where usuario.id_rol=3 AND localidad='".$_POST['locacion']."' AND disponibilidad == -1";
}


$datos=mysqli_query($conexion,$consulta);
                
while($fila=mysqli_fetch_array($datos))
{
    echo "<option  value='".$fila['id_empleado']."'>".$fila['nombre']." ".$fila['apaterno']." ".$fila['amaterno']."</option>";
    //echo $consulta_e."  ".$consulta;
}
}


mysqli_close($conexion);
?>
</select>
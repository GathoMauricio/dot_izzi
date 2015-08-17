<?php include "../control/conexion.php" ?>
<?php 
session_start();
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");

$consulta_empleado="SELECT * FROM empleado ORDER BY nombre";
$datos_empleado=mysqli_query($conexion,$consulta_empleado);
while($fila_empleado=mysqli_fetch_array($datos_empleado))
{

echo "<label id='lbl_".$fila_empleado['nombre']." ".$fila_empleado['apaterno']." ".$fila_empleado['amaterno']."'>".$fila_empleado['nombre']." ".$fila_empleado['apaterno']." ".$fila_empleado['amaterno']."</label><br><a href='#inicio'>Ir a inicio</a>";


$consulta="SELECT * from pendiente p 
LEFT JOIN empleado e 
ON p.id_empleado=e.id_empleado 
LEFT JOIN estatus s
ON p.id_estatus=s.id_estatus 
WHERE p.id_estatus = 3  AND e.id_empleado=".$fila_empleado['id_empleado']." 
ORDER BY fecha";
//WHERE fecha='".date('Y-m-d')."'";
$contador=0;
$datos=mysqli_query($conexion,$consulta);
echo '<table class="table">';
echo '<tr class="info"><td>ID</td><td>TITULO</td><td>FECHA</td><td>COMENTARIOS</td></tr>';
while ($fila=mysqli_fetch_array($datos)) {
$contador++;
echo '<tr>
<td>'.$fila['id_pendiente'].'</td>
<td>'.$fila['titulo'].'</td>
<td>'.$fila['fecha'].'</td>
<td>'.$fila['comentario'].'</td>

</tr>';
}
if($contador<=0)
{
	echo "<br><label>No hay datos que mostrar para ".$fila_empleado['nombre']." ".$fila_empleado['apaterno']." ".$fila_empleado['amaterno']."</label>";
}
echo'</table>';
}
 ?>
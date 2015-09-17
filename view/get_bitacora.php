
<div style="width:100%;height:600px;overflow:scroll;">
<table class="table">
<tr>
<td>
	<center>Fecha 
		<input type="date" class="form-control" style="width:200px;background:transparent;" onchange="fechaBitacora(this.value);">
	</center>
</td>
<td>Hora</td>
<td>Usuario</td>
<td>Movimiento</td>
<td>Host</td>
</tr>
<?php 
include "../mobile/conexion.php";
$consulta="SELECT * FROM bitacora WHERE fecha = '".date('Y-m-d')."' ORDER BY id_bitacora DESC";
if(isset($_POST['fecha']))
{
$consulta="SELECT * FROM bitacora WHERE fecha = '".$_POST['fecha']."' ORDER BY id_bitacora DESC";
}
$datos=mysqli_query($conexion,$consulta);
while($fila=mysqli_fetch_array($datos))
{
echo'
<tr>
<td><center>'.$fila['fecha'].'</center></td>
<td>'.$fila['hora'].' Hrs.</td>
<td>'.$fila['usuario'].'</td>
<td>'.$fila['movimiento'].'</td>
<td>'.$fila['host'].'</td>
</tr>
';
}
 ?>
 </table>
 </div>
<?php include "conexion.php" ?>
<?php 
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
$consulta="SELECT * FROM respuesta WHERE id_expediente=".$_POST['expediente'];
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
	echo '<center>
	<label>El Tiempo de Respuesta a su solicitud fue (horario de llegada):</label><br>
	<label style="color:gray">'.$fila['r1'].'</label><br>
	<label>¿Nuestro Representante de Soporte Técnico Fue Cordial y Paciente?</label><br>
	<label style="color:gray">'.$fila['r2'].'</label><br>
	<label>¿Nuestro Representante de Soporte Técnico Estaba Informado y Escuchó con atencion su problema?</label><br>
	<label style="color:gray">'.$fila['r3'].'</label><br>
	<label>¿Le explicaron cual era el problema de su equipo y la solución?</label><br>
	<label style="color:gray">'.$fila['r4'].'</label><br>
	<label>En General ¿Como Calificaria el proceso para que le resuelvan su problema?</label><br>
	<label style="color:gray">'.$fila['r5'].'</label><br>
	<label>¿Considera que nuestros ingenieros han entendido perfectamente su problema? </label><br>
	<label style="color:gray">'.$fila['r6'].'</label><br>
	<label>¿recomendaria nuestros servicios?</label><br>
	<label style="color:gray">'.$fila['r7'].'</label><br>
	<label>Comentarios:</label><br>
	<label style="color:gray">'.$fila['r8'].'</label><br>
	</center>';
}else
{
	echo '<center><label style="color:green">NO SE HA REALIZADO UNA ENCUESTA PARA ESTE EXPEDIENTE</label></center>';
}
 ?>
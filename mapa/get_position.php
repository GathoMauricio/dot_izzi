<?php 

date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect("localhost","root","","dot");
mysqli_set_charset($conexion, "utf8");
$consulta = "SELECT * FROM empleado e LEFT JOIN usuario u ON e.id_usuario=u.id_usuario WHERE u.id_rol=3 ORDER BY e.id_empleado";
$datos=mysqli_query($conexion,$consulta);
while($fila=mysqli_fetch_array($datos)){
 $empleados[]=array(
 	"lat"=>$fila['lat'],
 	"lon"=>$fila['lon']
 	);
}
echo json_encode($empleados);
 ?>
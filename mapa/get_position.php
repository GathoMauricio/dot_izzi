<?php include "../mobile/conexion.php" ?>
<?php 

date_default_timezone_set("Mexico/General");


$consulta = "SELECT * FROM empleado e LEFT JOIN usuario u ON e.id_usuario=u.id_usuario WHERE u.id_rol=2 OR u.id_rol=3 ORDER BY e.id_empleado";
$datos=mysqli_query($conexion,$consulta);
while($fila=mysqli_fetch_array($datos)){
 $empleados[]=array(
 	"nombre"=>$fila['nombre'],
 	"fecha"=>$fila['fecha_conexion'],
 	"hora"=>$fila['hora_conexion'],
 	"lat"=>$fila['lat'],
 	"lon"=>$fila['lon'],
 	"aprox"=>$fila['aprox'],
 	"foto"=>$fila['foto']
 	);
}
echo json_encode($empleados);
 ?>
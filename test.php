<?php 
include "mobile/conexion.php";
$tecnico="83";
$exp="2760";
$contador=0;
$consulta="SELECT * FROM `expediente` WHERE `id_tecnico`=".$tecnico."  ORDER BY `fecha`,`horario1` ASC";
$datos=mysqli_query($conexion,$consulta);
//Lista todos los expedientes del técnico
while($fila=mysqli_fetch_array($datos))
{
	//echo $fila['id_expediente']." ".$fila['horario1']." ".$fila['fecha']." ".$fila['id_estatus']."<br>";
	$array[]=$fila['id_expediente'];
	$contador++;
	if($fila['id_expediente']==$exp) break; //si el expediente obtenido es encontrado deja de listar
}
//echo count($array)."<br>";
//Se obtiene el penultimo registro (uno antes al q se intenta hacer contacto)
for ($i=0; $i < count($array)-1; $i++) { 
	$expedienteAnterior = $array[$i];
}
//busca el estatus del expediente anterior
$consulta="SELECT id_estatus FROM expediente WHERE id_expediente=".$expedienteAnterior;
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
	switch($fila['id_estatus'])
	{
		case 1:
				echo 0;//si el estatus es uno (Pendiente) regresa 0
			break;
		case 2:
				echo 0;//si el estatus es dos (En proceso) regresa 0
			break;
		case 3:
				echo 1;//sii el estatus es tres (Finalizado) regresa 1
			break;
	}
}
 ?>
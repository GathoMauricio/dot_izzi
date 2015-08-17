<?php session_start() ?>
<?php include "../control/conexion.php" ?>
<?php 
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");

$consulta_locacion="SELECT * FROM locacion";
$datos_locacion=mysqli_query($conexion,$consulta_locacion);

while($fila_locacion=mysqli_fetch_array($datos_locacion))
{

$consulta="SELECT * FROM expediente 
LEFT JOIN empleado ON expediente.id_tecnico=empleado.id_empleado 
LEFT JOIN estatus ON expediente.id_estatus=estatus.id_estatus 
WHERE fecha='".date('Y-m-d')."' AND locacion='".$fila_locacion['locacion']."'  ORDER BY horario1 ASC";
if(isset($_POST['criterio']))
{
	$consulta="SELECT * FROM expediente 
	LEFT JOIN empleado ON expediente.id_tecnico=empleado.id_empleado 
	LEFT JOIN estatus ON expediente.id_estatus=estatus.id_estatus 
	WHERE id_expediente=".$_POST['criterio']." AND locacion='".$fila_locacion['locacion']."'";
}
if(isset($_POST['fecha']))
{
	$consulta="SELECT * FROM expediente 
	LEFT JOIN empleado ON expediente.id_tecnico=empleado.id_empleado 
	LEFT JOIN estatus ON expediente.id_estatus=estatus.id_estatus 
	WHERE fecha='".$_POST['fecha']."' AND locacion='".$fila_locacion['locacion']."'";
}

/*
$consulta="SELECT * FROM expediente 
LEFT JOIN empleado ON expediente.id_tecnico=empleado.id_empleado 
LEFT JOIN estatus ON expediente.id_estatus=estatus.id_estatus 
WHERE fecha='".date('Y-m-d')."' AND locacion= 'DF' ORDER BY horario1 ASC";
if(isset($_POST['criterio']))
{
	$consulta="SELECT * FROM expediente 
	LEFT JOIN empleado ON expediente.id_tecnico=empleado.id_empleado 
	LEFT JOIN estatus ON expediente.id_estatus=estatus.id_estatus 
	WHERE id_expediente=".$_POST['criterio']."AND locacion= 'DF'";
}
if(isset($_POST['fecha']))
{
	$consulta="SELECT * FROM expediente 
	LEFT JOIN empleado ON expediente.id_tecnico=empleado.id_empleado 
	LEFT JOIN estatus ON expediente.id_estatus=estatus.id_estatus 
	WHERE fecha='".$_POST['fecha']."' AND locacion= 'DF'";
}*/


$datos=mysqli_query($conexion,$consulta);

$contador=0;




echo "<label id='lbl_".$fila_locacion['locacion']."'>".$fila_locacion['locacion']."</label><br><a href='#inicio'>Ir a inicio</a>";

echo ' 
<table class="table">
<tr class="info">
<th>Expediente</th>
<td>Fecha</td>
<td>Técnico</td>

<td>Horario</td>
<td>Estatus Iké</td>
<td>Estatus técnico</td>

<td>Tipo de servicio</td>
<td></td>
</tr>
 ';


$estatus_ike='';
$estatus_tec="";
$estatus_pago="";
$color_estatus_ike="";

while($fila=mysqli_fetch_array($datos)){
	$contador++;
	
	switch ($fila['id_estatus']) {
		case 1 :
			$estatus_tec='<img src="../img/load_face.gif"> PENDIENTE';
		break;
		case 2 :
			$estatus_tec='<img src="../img/load_face.gif"> EN PROCESO';
		break;
		case 3:
			$estatus_tec='<span class="glyphicon glyphicon-ok"><span> FINALIZADO';
		break;
	}

	
	$color_estatus_ike="";
	switch ($fila['id_estatus_ike']) {
		case 1:
			$estatus_ike='<img src="../img/load_face.gif">';
			$color_estatus_ike="warning";

			break;
		case 2:
			$estatus_ike='<span class="glyphicon glyphicon-ok"><span>';
			$color_estatus_ike="success";
			break;
		case 3:
			$estatus_ike='<span class="glyphicon glyphicon-question-sign"><span>';
			$color_estatus_ike="info";
			break;
		default:
			$estatus_ike='<span class="glyphicon glyphicon-remove"><span>';
			$color_estatus_ike="danger";
			break;
	}
	switch ($fila['pagado']) {
		case 'SI' :
			$estatus_pago='<span class="glyphicon glyphicon-ok"><span>';
		break;
		case 'NO' :
			$estatus_pago='<img src="../img/load_face.gif">';
		break;
		
	}

			

	echo ' 
		<tr class="'.$color_estatus_ike.'">
		<th>'.$fila['id_expediente'].'</th>
		<td>'.$fila['fecha'].'</td>
		<td>'.$fila['nombre'].' '.$fila['apaterno'].' '.$fila['amaterno'].'</td>
		
		<td>'.$fila['horario1'].' / '.$fila['horario2'].'</td>
		<td><center>'.$estatus_ike.'</center></td>
		<td><center>'.$estatus_tec.'</center></td>
		
		<td>'.$fila['tipo'].'</td>
		<td>
		<button class="btn btn-default" id="'.$fila['id_expediente'].'" onclick="detalleIke(this.id);" title="Ver detalles"><span class="glyphicon glyphicon-list"></span></button>
		<button class="btn btn-default" onclick="estatus_ike(this.id,1);" id="'.$fila['id_expediente'].'" title="Servicio pendiente"><span class="glyphicon glyphicon-asterisk"  ></span></button>
		<button class="btn btn-success" onclick="estatus_ike(this.id,2);" id="'.$fila['id_expediente'].'" title="Servicio cerrado"><span class="glyphicon glyphicon-ok"  ></span></button>
		<button class="btn btn-info" onclick="estatus_ike(this.id,3);" id="'.$fila['id_expediente'].'" title="Servicio con dudas"><span class="glyphicon glyphicon-question-sign"  ></span></button>
		<button class="btn btn-danger" onclick="estatus_ike(this.id,4);" id="'.$fila['id_expediente'].'" title="Servicio cancelado"><span class="glyphicon glyphicon-remove"  ></span></button>

		</td>
		</tr>
		';


     }


echo '</table>';



if($contador<=0)
{
	echo "<center><h3>No se encontró el expediente solicitado</h3></center>";
}
}
mysqli_close($conexion);
 ?>







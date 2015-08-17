<?php session_start() ?>
<?php include "../control/conexion.php" ?>
<?php 
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="SELECT * FROM expediente_ike 
LEFT JOIN empleado ON expediente.id_tecnico=empleado.id_empleado 
LEFT JOIN estatus ON expediente.id_estatus=estatus.id_estatus
WHERE fecha='".date('Y-m-d')."' ORDER BY horario1 ASC";
if(isset($_POST['criterio']))
{
	$consulta="SELECT * FROM expediente_ike
	LEFT JOIN empleado ON expediente_ike.id_tecnico=empleado.id_empleado 
	LEFT JOIN estatus ON expediente_ike.id_estatus=estatus.id_estatus 
	WHERE id_expediente=".$_POST['criterio'];
}
if(isset($_POST['fecha']))
{
	$consulta="SELECT * FROM expediente_ike 
	LEFT JOIN empleado ON expediente.id_tecnico=empleado.id_empleado 
	LEFT JOIN estatus ON expediente.id_estatus=estatus.id_estatus 
	WHERE fecha='".$_POST['fecha']."' ORDER BY horario1 DESC";
}
$datos=mysqli_query($conexion,$consulta);
$btn_estatus="";
$lbl_estatus="";
$aux="";
$h_inicio="";
$h_final="";
$contador=0;
while($fila=mysqli_fetch_array($datos)){
	$contador++;
	$h_inicio=$fila['h_inicio'];
	$h_final=$fila['h_final'];
	switch ($fila['id_estatus']) {
		case 1 :
			$btn_estatus='<button id="'.$fila['id_expediente'].'" class="btn btn-success" style="width:90%" onclick="cambiar_estatus(this.id,2);">Confirmar contacto</button>';
			$lbl_estatus='<p class="bg-danger" style="text-align:center">EL ESTATUS PARA ESTE SERVICIO ES: PENDIENTE</p>';
			$aux='';
		break;
		case 2 :
			$btn_estatus='<label>Diagnóstico y/o solución:</label><br><textarea id="txtsolucion_'.$fila['id_expediente'].'" class="form-control"></textarea><br><button id="'.$fila['id_expediente'].'" class="btn btn-warning" style="width:90%" onclick="cambiar_estatus(this.id,3);">Confirmar retirada</button>
			<br><button id="'.$fila['id_expediente'].'" class="btn btn-default" style="width:90%" onclick="cambiar_estatus(this.id,1);">Cancelar</button>
			';
			$lbl_estatus='<p class="bg-warning" style="text-align:center">EL ESTATUS PARA ESTE SERVICIO ES: EN PROCESO</p>
			<p id="lbl_datos"><strong>Hora de contacto: </strong>'.$fila['h_inicio'].' Hrs.</p>';
			$aux="";
		break;
		default:
			$btn_estatus='<button id="'.$fila['id_expediente'].'" class="btn btn-default" style="width:90%" onclick="cambiar_estatus(this.id,4);">Cancelar</button>';
			$lbl_estatus='<p class="bg-success" style="text-align:center">EL ESTATUS PARA ESTE SERVICIO ES: FINALIZADO</p><p id="lbl_datos"><strong>Hora de contacto: </strong>'.$fila['h_inicio'].' Hrs.</p><p id="lbl_datos"><strong>Hora de retirada: </strong>'.$fila['h_final'].' Hrs.</p>';
			$aux='<p id="d_solucion"><strong>Diagnóstico y/o solución</strong>: '.$fila['d_solucion'].'</p>';
			break;
	}
	$estatus_ike='';
	$color_estatus_ike="";
	switch ($fila['id_estatus_ike']) {
		case 1:
			$estatus_ike='';
			break;
		case 2:
			$estatus_ike='glyphicon glyphicon-ok';
			$color_estatus_ike="green";
			break;
		case 3:
			$estatus_ike='glyphicon glyphicon-question-sign';
			$color_estatus_ike="blue";
			break;
		default:
			$estatus_ike='glyphicon glyphicon-remove';
			$color_estatus_ike="red";
			break;
	}

	$boton_pago="";
	switch ($fila['pagado']) {
		case "NO":
				$boton_pago='<button class="btn btn-success" id="'.$fila['id_expediente'].'" onclick="estatusPago(this.id,2);" title="Cambiar estatus a pagado"><span class="glyphicon glyphicon-usd"></span></button>';
			break;
		case "SI":
				$boton_pago='<button class="btn btn-warning" id="'.$fila['id_expediente'].'" onclick="estatusPago(this.id,1);" title="Cambiar estatus a NO pagado"><span class="glyphicon glyphicon-usd"></span></button>';
			break;
	}
	$botonCancelar='<button onclick="cancelarServicio('.$fila['id_expediente'].',2);" class="btn btn-danger" title="Cancelar servicio"><span class="glyphicon glyphicon-remove"></span></button>';
	$causaCancelacion="";
	if($fila['estatus_cancelacion']>1)
	{
		$botonCancelar="<label style='color:red' onclick='cancelarServicio(".$fila['id_expediente'].",1)' title='Click para deshacer los cambios'>Servicio cancelado</label>";
		$causaCancelacion="<br>".$fila['causa_cancelacion']."";
	}
	echo '<div class="publicacion" id="pub_'.$fila['id_expediente'].'">
	<button class="btn btn-success" id="'.$fila['id_expediente'].'" onclick="validarServicio(this.id);" title="Validar servicio"><span class="glyphicon glyphicon-ok"></span></button>
		<button class="btn btn-danger" id="'.$fila['id_expediente'].'" onclick="noValidarServicio(this.id);" title="No Validar servicio"><span class="glyphicon glyphicon-remove"></span></button>
	<p id="lbl_expediente"><strong>Expediente: </strong>'.$fila['id_expediente'].'</p>
		<p style="background-color:#3b5998;color:white;text-align:center;">'.$fila['tipo'].'</p>
		
		<p id="lbl_datos"><strong>Fecha:</strong>  '.$fila['fecha'].'  / <strong>Horario:</strong>  '.$fila['horario1'].' - '.$fila['horario2'].' Hrs. / <strong>Solicitud: </strong>  '.$fila['solicitud'].'  / <strong>Locación: </strong>'.$fila['locacion'].'</p>
        <p id="lbl_datos"><strong>Técnico asignado:</strong> '.$fila['nombre'].' '.$fila['apaterno'].' '.$fila['amaterno'].'<p>
        <p id="lbl_datos"><strong>Capturó:</strong> '.$fila['capturista'].'</p>
        <p id="lbl_datos"><strong>Costo:</strong> $'.$fila['costo'].'</p>
        <p id="lbl_nombre"><strong>Usuario:</strong> '.$fila['usuario'].' </p>
        <p><strong>Direccion:</strong> '.$fila['direccion_u'].'  </p>
        </p>
        <p><strong>Problema:</strong> '.$fila['d_problema'].' </p>
        <p>'.$aux.'</p>
        
     </div>';
     
     
     
     echo '<br><hr><br><br>';
}

if($contador<=0)
{
	echo "<center><h3>No se encontró el expediente solicitado</h3></center>";
}
mysqli_close($conexion);
 ?>
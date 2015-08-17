<?php session_start() ?>
<?php include "../control/conexion.php" ?>
<?php 
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="SELECT * FROM expediente 
LEFT JOIN empleado ON expediente.id_tecnico=empleado.id_empleado 
LEFT JOIN estatus ON expediente.id_estatus=estatus.id_estatus 
WHERE id_tecnico=".$_SESSION['id_empleado']." AND fecha='".date('Y-m-d')."'";
if(isset($_POST['criterio']))
{
	$consulta="SELECT * FROM expediente 
	LEFT JOIN empleado ON expediente.id_tecnico=empleado.id_empleado 
	LEFT JOIN estatus ON expediente.id_estatus=estatus.id_estatus 
	WHERE id_expediente=".$_POST['criterio']." AND id_tecnico=".$_SESSION['id_empleado'];
}
if(isset($_POST['fecha']))
{
	$consulta="SELECT * FROM expediente 
	LEFT JOIN empleado ON expediente.id_tecnico=empleado.id_empleado 
	LEFT JOIN estatus ON expediente.id_estatus=estatus.id_estatus 
	WHERE fecha='".$_POST['fecha']."' AND id_tecnico=".$_SESSION['id_empleado'];
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
			$aux='<p id="mapa"><center> '.$fila['mapa'].' </center></p>';
		break;
		case 2 :
			$btn_estatus='<label>Diagnóstico y/o solución:</label><br><textarea id="txtsolucion_'.$fila['id_expediente'].'" class="form-control"></textarea><br><button id="'.$fila['id_expediente'].'" class="btn btn-warning" style="width:90%" onclick="abrirEncuesta(this.id);">Realizar encuesta</button>
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
	$botonCancelar="";
	$causaCancelacion="";
	if($fila['estatus_cancelacion']>1)
	{
		$botonCancelar="<label style='color:red'>Servicio cancelado</label>";
		$causaCancelacion="<p>".$fila['causa_cancelacion']."</p>";
	}
	echo '<div class="publicacion" id="pub_'.$fila['id_expediente'].'">
	'.$botonCancelar.'
	'.$causaCancelacion.'
	<button class="btn btn-info" title="Ver imagen" onclick="verImagen('.$fila['id_expediente'].');"><span class="glyphicon glyphicon-picture"></span></button>
	<button class="btn btn-default" title="Agregar imagen" onclick="subirImagen('.$fila['id_expediente'].');"><span class="glyphicon glyphicon-upload"></span></button>
	<button class="btn btn-success" title="Crear PDF" onclick="crearPDF('.$fila['id_expediente'].');"><span class="glyphicon glyphicon-print"></span></button>
	<div id="estatus_ike" style="color:'.$color_estatus_ike.'"> <img src="../img/ike.jpg" id="ike_img"> <span class="'.$estatus_ike.'"></span></div><br><br>
	<p id="lbl_expediente"><strong>Expediente: </strong>'.$fila['id_expediente'].'</p>
		<p style="background-color:#3b5998;color:white;text-align:center;">'.$fila['tipo'].'</p>
		'.$lbl_estatus.'
		<p id="lbl_datos"><strong>Fecha:</strong>  '.$fila['fecha'].'  / <strong>Horario:</strong>  '.$fila['horario1'].' - '.$fila['horario2'].' Hrs. / <strong>Solicitud: </strong>  '.$fila['solicitud'].'  / <strong>Locación: </strong>'.$fila['locacion'].'</p>
        <p id="lbl_datos"><strong>Técnico asignado:</strong> '.$fila['nombre'].' '.$fila['apaterno'].' '.$fila['amaterno'].'<p>
        <p id="lbl_datos"><strong>Capturó:</strong> '.$fila['capturista'].'</p>
        <p id="lbl_datos"><strong>Costo:</strong> $'.$fila['costo'].'</p>
        <p id="lbl_nombre"><strong>Usuario:</strong> '.$fila['usuario'].' </p>
        <p><strong>Direccion:</strong> '.$fila['direccion_u'].'  </p>
        </p>
        <p><strong>Problema:</strong> '.$fila['d_problema'].' </p>
        '.$aux.'
        <center>
        '.$btn_estatus.'
        </center>
     </div>';
     $consulta_comentarios="SELECT * FROM comentarios WHERE id_publicacion=".$fila['id_expediente'];
     $datos_comentarios=mysqli_query($conexion,$consulta_comentarios);
     while($fila_comentario=mysqli_fetch_array($datos_comentarios))
     {
     	echo '<p><div class="comentario">
     	<div style="float="right"><button onclick="eliminarComentario('.$fila_comentario['id_comentario'].','.$fila['id_expediente'].');" class="close" title="Eliminar comentario"><span aria-hidden="true">&times;</span></button></div>
     	<img src="../img/'.$fila_comentario['foto_perfil'].'" width="50">
     	<label style="color:#3b5998;font-size:18px;">'.$fila_comentario['comentador'].'</label>
     	<br>
     	<div id="lbl_datos" style="padding-left:50px;">Fecha: '.$fila_comentario['fecha'].' / Hora: '.$fila_comentario['hora'].'Hrs</div><br><p style="font-size:15px;padding-left:50px;">'.$fila_comentario['comentario'].'</p>';
     	echo '
     		  </div></p>';
     }
     	echo '<p>
     	
     	<div class="comentario">
     	<center>
     	<input type="text" id="comentario_'.$fila['id_expediente'].'" placeholder="Escribe un comentario..." class="form-control">
     	<br>
     	<button class="btn btn-default" id="'.$fila['id_expediente'].'" onclick="agregarComentario(this.id);"><span class="glyphicon glyphicon-comment" ></span> Añadir comentario</button>
		</center>
     	</div>
     	
     	</p>';
     echo '<br><hr><br><br>';
}
if($contador<=0)
{
	echo "<center><h3>No se encontró el expediente solicitado</h3></center>";
}
mysqli_close($conexion);
 ?>
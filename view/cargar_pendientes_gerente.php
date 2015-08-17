<?php include "../control/conexion.php" ?>
<?php 
session_start();
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");

$consulta="SELECT * from pendiente p 
LEFT JOIN empleado e 
ON p.id_empleado=e.id_empleado 
LEFT JOIN estatus s
ON p.id_estatus=s.id_estatus 
WHERE p.id_estatus=1"; 
//WHERE p.id_empleado=".$_SESSION['id_empleado'];
//fecha='".date('Y-m-d')."'";

$datos=mysqli_query($conexion,$consulta);

while ($fila=mysqli_fetch_array($datos)) {
	$estatus="";
	switch ($fila['id_estatus']) {
		case 1:
			$estatus="bg-danger";
			break;
		case 2:
			$estatus="bg-info";
			break;
		case 3:
			$estatus="bg-success";
			break;		

	}
	//<p class="'.$estatus.'" style="text-align:center">EL ESTATUS PARA ESTE REGISTRO ES: '.$fila['estatus'].'</p>
	echo '
		<div class="publicacion">
            
            <button class="btn btn-info" id="'.$fila['id_pendiente'].'" title="Reasignar" onclick="showReasignarGerente(this.id)"><span class="glyphicon glyphicon-user"></span></button>
            <button class="btn btn-warning" id="'.$fila['id_pendiente'].'" title="Editar" onclick="showEditarPendiente(this.id)"><span class="glyphicon glyphicon-pencil"></span></button>
            <button class="btn btn-success" id="'.$fila['id_pendiente'].'" title="Terminar" onclick="terminarPendiente(this.id)"><span class="glyphicon glyphicon-log-out"></span></button>
            <p id="lbl_nombre"><strong>ID:</strong>'.$fila['id_pendiente'].'</p>
            <p id="lbl_nombre"><strong>Pendiente:</strong>'.$fila['titulo'].'</p>
            <p id="lbl_datos"><strong>Empleado asignado:</strong> '.$fila['nombre'].' '.$fila['apaterno'].' '.$fila['amaterno'].' 
            / <strong>Fecha:</strong>'.$fila['fecha'].' / <strong>Hora:</strong>'.$fila['hora'].' Hrs<p>
            <p ><strong>Descripción:</strong> '.$fila['descripcion'].' </p>
        </div>
	';

	 $consulta_comentarios="SELECT * FROM comentario_pendiente WHERE id_pendiente=".$fila['id_pendiente'];
     $datos_comentarios=mysqli_query($conexion,$consulta_comentarios);
     while($fila_comentario=mysqli_fetch_array($datos_comentarios))
     {
     	echo '<p><div class="comentario">
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
     	<input type="text" id="comentario_pendiente_'.$fila['id_pendiente'].'" placeholder="Escribe un comentario..." class="form-control">
     	<br>
     	<button class="btn btn-default" id="'.$fila['id_pendiente'].'" onclick="agregarComentarioPendiente(this.id);"><span class="glyphicon glyphicon-comment" ></span> Añadir comentario</button>
		</center>
     	</div>
     	
     	</p>';
     echo '<br><hr><br><br>';
}
 ?>
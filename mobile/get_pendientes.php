<?php 
include 'conexion.php';
$consulta ="SELECT * FROM pendiente WHERE id_empleado = ".$_POST['id_empleado']." AND id_estatus=1";
$datos = mysqli_query($conexion,$consulta);
while($fila=mysqli_fetch_array($datos))
{
	echo'<div class="contenido_inicio">
		<center>
            <p style="color:blue">Pendiente: '.$fila['id_pendiente'].'</p>
            <label class="lbl_nombre" >'.$fila['titulo'].'.</label>
        </center>

        <label class="lbl_datos" ><b>fecha:</b> '.$fila['fecha'].'.</label>
            <label  class="lbl_datos"><b>Horario:</b> De  '.$fila['hora'].' Hrs.
        <p class="contenido_servicio">
                <b>Descripción: </b>'.$fila['descripcion'].'
        </p>
        <div class="contenido_inicio">
            <center>
                <table>
                    <tr>
                        <td onclick="terminarPendiente('.$fila['id_pendiente'].')" style="width:25%;border:solid 1px gray;">
                        <span class="icon-redo2"></span>
                        Terminar
                        </td>
                        <td onclick="comentarPendiente('.$fila['id_pendiente'].')" style="width:25%;border:solid 1px gray;">
                        <span class="icon-bubble2"></span>
                        Comentar
                        </td>
                    </tr>
                 </table>
            </center>
        </div>';
        $consultaComentario="SELECT * FROM comentario_pendiente WHERE id_pendiente=".$fila['id_pendiente'];
$datosComentario=mysqli_query($conexion,$consultaComentario);
while($filaComentario=mysqli_fetch_array($datosComentario))
{
echo'
<div class="contenido_inicio">
<br/>
<a><img onclick="" src="http://dotredes.dyndns.biz:18888/dot_izzi/img/'.$filaComentario['foto_perfil'].'" alt="FOTO PERFIL" width="60"  style="float:left"/></a>
<label class="lbl_nombre" ><a class="lbl_nombre" onclick="">'.$filaComentario['comentador'].'</a></label>
<label  class="lbl_datos">'.$filaComentario['fecha'].' A las  '.$filaComentario['hora'].' Hrs.</label>
<p>'.$filaComentario['comentario'].'</p>
</div>
';
}
echo'</div>';
echo'<br><br>';
	
}
 ?>
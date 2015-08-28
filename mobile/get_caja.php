<?php 
include "conexion.php";
$consulta="SELECT * FROM expediente e LEFT JOIN empleado em ON 
e.id_tecnico=em.id_empleado
 WHERE e.id_expediente=".$_POST['id_expediente'];
$datos=mysqli_query($conexion,$consulta);
$estatus="";
$h_inicio="";
$h_final="";
$d_solucion="";
$botonEstatus="";
$diagnostico="";
while($fila=mysqli_fetch_array($datos))
{
	switch ($fila['id_estatus'])
	{
		case 1:
            $estatus='<p style="color:#F78181">Estatus: Pendiente</p>';
			$h_inicio="";
			$h_final="";
			$d_solucion="";
            $botonEstatus='<td onclick="cambiarEstatus('.$fila['id_expediente'].',2);" style="width:25%;border:solid 1px gray;"><span class="icon-checkmark2"></span><br/>Contacto</td>';
			$diagnostico='';
            break;
		case 2:
            $estatus='<p style="color:#F4FA58">Estatus: En proceso</p>';
			$h_inicio='<br><b>Contacto: </b> '.$fila['h_inicio'].' Hrs.';
			$h_final="";
			$d_solucion="";
            $botonEstatus='<td onclick="cambiarEstatus('.$fila['id_expediente'].',3);" style="width:25%;border:solid 1px gray;"><span class="icon-checkmark2"></span><br/>Finalizar</td>';
			$diagnostico='<label><b>Diagnóstico:</b></label><textarea style="width:100%" placeholder="Ingresar diagnóstico" id="txt_diagnostico_'.$fila['id_expediente'].'">'.$fila['d_solucion'].'</textarea>';
            break;
		case 3:
            $estatus='<p style="color:#2EFE64">Estatus: Finalizado</p>';
			$h_inicio='<br><b>Contacto: </b> '.$fila['h_inicio'].' Hrs.';
			$h_final='<br><b>Finalizado: </b> '.$fila['h_final'].'. Hrs';
			$d_solucion='<br><br><b>Diagnóstico: </b></b>'.$fila['d_solucion'].'';
            $botonEstatus='<td onclick="cambiarEstatus('.$fila['id_expediente'].',2);" style="width:25%;border:solid 1px gray;"><span class="icon-checkmark2"></span><br/>Deshacer</td>';
			$diagnostico="";
            break;
		
	}
echo'

<center>
<div class="contenido_inicio">
            <center>
                <p style="color:blue">Expediente: '.$fila['id_expediente'].'</p>
                '.$estatus.'
            </center>

            <img src="img/ike.jpg" alt="IKE LOGO" width="100" height="120" style="float:left"/>
            <label class="lbl_nombre" >'.$fila['usuario'].'.</label>
            <label class="lbl_datos" ><b>fecha:</b> '.$fila['fecha'].'.</label>
            <label  class="lbl_datos"><b>Horario:</b> De  '.$fila['horario1'].' Hrs. A '.$fila['horario2'].' Hrs.
                '.$h_inicio.'
                '.$h_final.'
                <br/><b> En:</b> '.$fila['locacion'].'.
                <br/><b>Costo:</b> $'.$fila['costo'].'.
                <br/><b>Solicitado por:</b> '.$fila['solicitud'].'.
                <br/><b>Capturado por:</b> '.$fila['capturista'].'.

            </label>
            <p class="contenido_servicio">
                <b>Dirección: </b>'.$fila['direccion_u'].'
                <br/><br/>
                <b>Problemática: </b>'.$fila['d_problema'].'
                '.$diagnostico.'
                '.$d_solucion.'
            </p>
        </div>
        <div class="contenido_inicio">
            <center>
                <table>
                    <tr>
                        <td onclick="" style="width:25%;border:solid 1px gray;"><span class="icon-map2"></span><br/>Mapa</td>
                        '.$botonEstatus.'
                        <td onclick="" style="width:25%;border:solid 1px gray;"><span class="icon-bubble2"></span><br/>Comentar</td>
                        <td onclick="" style="width:25%;border:solid 1px gray;"><span class="icon-attachment"></span><br/>Adjunto</td>
                    </tr>
                </table>
            </center>
        </div>
';	
$consultaComentario="SELECT * FROM comentarios WHERE id_publicacion=".$fila['id_expediente'];
$datosComentario=mysqli_query($conexion,$consultaComentario);
while($filaComentario=mysqli_fetch_array($datosComentario))
{
echo'
<div class="contenido_inicio">
<div style ="float:right;padding:5px;"><a style="color:gray;" onclick=""><span class="icon-cross"></span></a></div>
<br/>
<a><img onclick="" src="img/logo.png" alt="DOT LOGO" width="60"  style="float:left"/></a>
<label class="lbl_nombre" ><a class="lbl_nombre" onclick="">'.$filaComentario['comentador'].'</a></label>
<label  class="lbl_datos">'.$filaComentario['fecha'].' A las  '.$filaComentario['hora'].' Hrs.</label>
<p>'.$filaComentario['comentario'].'</p>
</div>
';
}
echo'<br><br>';
}
echo '</center>';

 ?>
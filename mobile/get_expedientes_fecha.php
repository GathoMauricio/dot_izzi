<?php 
include "conexion.php";
 /*$consulta="SELECT * FROM expediente e LEFT JOIN empleado em ON 
e.id_tecnico=em.id_empleado
 WHERE e.id_tecnico=".$_POST['id_empleado']." AND e.fecha='".$_POST['fecha']."'";*/

$consulta="SELECT * FROM empleado e LEFT JOIN usuario u 
ON e.id_usuario=u.id_usuario WHERE e.id_empleado=".$_POST['id_empleado'];
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
    $rol=$fila['id_rol'];
}

if($rol<3)
{
$consulta="SELECT * FROM expediente e LEFT JOIN empleado em 
ON e.id_tecnico=em.id_empleado 
WHERE e.fecha='".$_POST['fecha']."' ORDER BY e.horario1";
}else{
$consulta="SELECT * FROM expediente e LEFT JOIN empleado em 
ON e.id_tecnico=em.id_empleado 
WHERE e.id_tecnico=".$_POST['id_empleado']." AND e.fecha='".$_POST['fecha']."' ORDER BY e.horario1";
}

$datos=mysqli_query($conexion,$consulta);
$estatus="";
$h_inicio="";
$h_final="";
$d_solucion="";
$botonEstatus="";
$diagnostico="";
$btnMenu1="";
$btnMenu2="";
$btnMenu3="";
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
            $btnMenu1='<td onclick="abrirMapa('.$fila['lat_expediente'].','.$fila['lon_expediente'].');" style="width:25%;border:solid 1px gray;"><span class="icon-map2"></span><br/>Mapa</td>';
            $btnMenu2='<td onclick="comentar('.$fila['id_expediente'].');" style="width:25%;border:solid 1px gray;"><span class="icon-bubble2"></span><br/>Comentar</td>';
            $btnMenu3='';
            $btnMenu4='';
            $btnMenu5='';
            $btnMenu6='';
            $btnMenu7='';
            break;
        case 2:
            $estatus='<p style="color:#F4FA58">Estatus: En proceso</p>';
            $h_inicio='<br><b>Contacto: </b> '.$fila['h_inicio'].' Hrs.';
            $h_final="";
            $d_solucion="";
            $botonEstatus='<td onclick="cambiarEstatus('.$fila['id_expediente'].',3);" style="width:25%;border:solid 1px gray;"><span class="icon-checkmark2"></span><br/>Finalizar</td>';
            $diagnostico='<label><b>Diagnóstico:</b></label><textarea style="width:100%" placeholder="Ingresar diagnóstico" id="txt_diagnostico_'.$fila['id_expediente'].'">'.$fila['d_solucion'].'</textarea>';
            $btnMenu1='<td onclick="cambiarEstatus('.$fila['id_expediente'].',1);" style="width:25%;border:solid 1px gray;"><span class="icon-undo"></span><br/>Deshacer</td>';
            $btnMenu2='<td onclick="comentar('.$fila['id_expediente'].');" style="width:25%;border:solid 1px gray;"><span class="icon-bubble2"></span><br/>Comentar</td>';
            $btnMenu3='<td onclick="adjuntar('.$fila['id_expediente'].');" style="width:25%;border:solid 1px gray;"><span class="icon-camera"></span><br/>Adjuntar</td>';
            $btnMenu4='<td onclick="encuesta('.$fila['id_expediente'].');" style="width:25%;border:solid 1px gray;"><span class="icon-star-half"></span><br/>Encuesta</td>';
            $btnMenu5='<td onclick="firma('.$fila['id_expediente'].');" style="width:25%;border:solid 1px gray;"><span class="icon-pen"></span><br/>Firma</td>';
            $btnMenu6='<td onclick="documentacion();" style="width:25%;border:solid 1px gray;"><span class="icon-folder-open"></span><br/>Archivos</td>';
            $btnMenu7='<td onclick="verAdjuntos('.$fila['id_expediente'].');" style="width:25%;border:solid 1px gray;"><span class="icon-images"></span><br/>Ver</td>';
            break;
        case 3:
            $estatus='<p style="color:#2EFE64">Estatus: Finalizado</p>';
            $h_inicio='<br><b>Contacto: </b> '.$fila['h_inicio'].' Hrs.';
            $h_final='<br><b>Finalizado: </b> '.$fila['h_final'].'. Hrs';
            $d_solucion='<br><br><b>Diagnóstico: </b></b>'.$fila['d_solucion'].'';
            $botonEstatus='<td onclick="cambiarEstatus('.$fila['id_expediente'].',2);" style="width:25%;border:solid 1px gray;"><span class="icon-undo"></span><br/>Deshacer</td>';
            $diagnostico="";
            $btnMenu1='<td onclick="comentar('.$fila['id_expediente'].');" style="width:25%;border:solid 1px gray;"><span class="icon-bubble2"></span><br/>Comentar</td>';
            $btnMenu2='<td onclick="verAdjuntos('.$fila['id_expediente'].');" style="width:25%;border:solid 1px gray;"><span class="icon-camera"></span><br/>Ver adjuntos</td>';
            $btnMenu3='<td onclick="verFirma('.$fila['id_expediente'].');" style="width:25%;border:solid 1px gray;"><span class="icon-pen"></span><br/>Ver firma</td>';
            $btnMenu4='';
            $btnMenu5='';
            $btnMenu6='';
            $btnMenu7='';
            break;
        
    }
echo'
<div id="caja_'.$fila['id_expediente'].'">
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
                        '.$botonEstatus.'
                        '.$btnMenu1.'
                        '.$btnMenu2.'
                        '.$btnMenu3.'
                    </tr>
                    <tr>
                        '.$btnMenu4.'
                        '.$btnMenu5.'
                        '.$btnMenu6.'
                        '.$btnMenu7.'
                    </tr>
                </table>
            </center>
        </div>
';  
$consultaComentario="SELECT * FROM comentarios WHERE id_publicacion=".$fila['id_expediente'];
$datosComentario=mysqli_query($conexion,$consultaComentario);
//Pendiente eliminar comentarios
//<div style ="float:right;padding:5px;"><a style="color:gray;" onclick="eliminarComentario('.$filaComentario['id_comentario'].')"><span class="icon-cross"></span></a></div>

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
echo'<br><br>';
echo '</center>';
echo '</div>';
}

 ?>
<?php 
include "conexion.php";
$consulta="SELECT * FROM expediente e LEFT JOIN empleado em ON 
e.id_tecnico=em.id_empleado
 WHERE e.id_tecnico=".$_POST['id_empleado'];
$datos=mysqli_query($conexion,$consulta);
$h_inicio="";
$h_final="";
$d_solucion="";

while($fila=mysqli_fetch_array($datos))
{
	switch ($fila['id_estatus']) {
		case 1:
			$h_inicio="";
			$h_final="";
			$d_solucion="";
			break;
		case 2:
			$h_inicio="";
			$h_final="";
			$d_solucion="";
			break;
		case 3:
			$h_inicio="";
			$h_final="";
			$d_solucion="";
			break;
		
	}
echo'
<center>
<p style="color:blue">Expediente: '.$fila['id_expediente'].'</p>
                <p style="color:red">Status: Pendiente</p>
            </center>

            <img src="img/ike.jpg" alt="IKE LOGO" width="100" height="120" style="float:left"/>
            <label class="lbl_nombre" >Nombre Del Cliente en Cuestión.</label>
            <label  class="lbl_datos"><b>Horario:</b> 000-00-00 A las  00:00 Hrs.
                <br/><b> En:</b> Locación.
                <br/><b>Costo:</b> $000.
                <br/><b>Solicitado por:</b> Solicitante de Servicio.
                <br/><b>Capturado por:</b> Gerente que Capturó.

            </label>
            <p class="contenido_servicio">
                <b>Dirección: </b>CP 53660 NAUCALPAN COL. SAN RAFAEL CHAMAPA CALLE CALZADA DE GUADALUPE NO. 17 ENTRE CALLE FELIPE ANGELES Y FRANCISCO VILLA REFERENCIA VISUAL ENFRENTE DEL DOM. TALLER DE TRANSMISIONES AUTOMÁTICAS, EN EL DOMICILIO HAY UN EXPENDIO DE CERVECERÍA A MEDIA CUADRA DE UNA TIENDA NETO
                <br/><br/>
                <b>Problemática: </b>CONFIGURACIÓN DE TP -LINK WA 730RE NO DIFUNDE LA RED DEL 2DO. PISO (CHECAR QUE LLEGUE SEÑAL A UNA SMART TV
            </p>
        </div>
        <div class="contenido_inicio">
            <center>
                <table>
                    <tr>
                        <td onclick="" style="width:25%;border:solid 1px gray;"><span class="icon-map2"></span><br/>Mapa</td>
                        <td onclick="" style="width:25%;border:solid 1px gray;"><span class="icon-checkmark2"></span><br/>Estatus</td>
                        <td onclick="" style="width:25%;border:solid 1px gray;"><span class="icon-bubble2"></span><br/>Comentar</td>
                        <td onclick="" style="width:25%;border:solid 1px gray;"><span class="icon-attachment"></span><br/>Adjunto</td>
                    </tr>
                </table>
            </center>
        </div>
';	
$consultaComentario="SELECT * FROM comentarios WHERE id_expediente=".$fila['id_publicacion'];
$datosComentario=mysqli_query($conexion,$consultaComentario);
while($filaComentario=mysqli_fetch_array($datosComentario))
{
echo'
<div class="contenido_inicio">
            <div style ="float:right;padding:5px;"><a style="color:gray;" onclick=""><span class="icon-cross"></span></a></div>
            <br/>
            <a><img onclick="" src="img/logo.png" alt="DOT LOGO" width="60"  style="float:left"/></a>
            <label class="lbl_nombre" ><a class="lbl_nombre" onclick="">Empleado que ha comentado.</a></label>
            <label  class="lbl_datos">000-00-00 A las  00:00 Hrs.</label>
            <p>Este ya es el comentario del empleado en cuestión</p>
        </div>
';
}
}
echo '</center>';
 ?>
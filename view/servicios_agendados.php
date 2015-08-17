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



$consulta="SELECT * FROM expediente_ike 
LEFT JOIN empleado ON expediente_ike.id_tecnico=empleado.id_empleado 
LEFT JOIN estatus ON expediente_ike.id_estatus=estatus.id_estatus 
WHERE  locacion='".$fila_locacion['locacion']."' ORDER BY fecha,horario1 ASC";

if(isset($_POST['criterio']))
{
    $consulta="SELECT * FROM expediente_ike 
    LEFT JOIN empleado ON expediente_ike.id_tecnico=empleado.id_empleado 
    LEFT JOIN estatus ON expediente_ike.id_estatus=estatus.id_estatus 
    WHERE id_expediente=".$_POST['criterio']." AND locacion='".$fila_locacion['locacion']."' ORDER BY horario1 ASC";
}
if(isset($_POST['fecha']))
{
    $consulta="SELECT * FROM expediente_ike 
    LEFT JOIN empleado ON expediente_ike.id_tecnico=empleado.id_empleado 
    LEFT JOIN estatus ON expediente_ike.id_estatus=estatus.id_estatus 
    WHERE fecha='".$_POST['fecha']."' AND locacion='".$fila_locacion['locacion']."' ORDER BY horario1 ASC";
}
$datos=mysqli_query($conexion,$consulta);

$contador=0;




echo "<label id='lbl_".$fila_locacion['locacion']."'>".$fila_locacion['locacion']."</label><br><a href='#inicio'>Ir a inicio</a>";

echo ' 
<table class="table">
<tr class="info">
<th>Expediente</th>
<td>Fecha</td>

<td>Capturó</td>
<td>Horario</td>
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
    $botonPago="";
    switch ($fila['pagado']) {
        case 'SI' :
            $estatus_pago='<span class="glyphicon glyphicon-ok"><span>';
            $botonPago='<button class="btn btn-warning" id="'.$fila['id_expediente'].'" onclick="estatusPago(this.id,1);" title="Cambiar estatus a NO pagado"><span class="glyphicon glyphicon-usd"></span></button>';
        break;
        case 'NO' :
            $estatus_pago='<img src="../img/load_face.gif">';
            $botonPago='<button class="btn btn-success" id="'.$fila['id_expediente'].'" onclick="estatusPago(this.id,2);" title="Cambiar estatus a pagado"><span class="glyphicon glyphicon-usd"></span></button>';
        break;
        
    }

    echo ' 
        <tr class="'.$color_estatus_ike.'">
        <th>'.$fila['id_expediente'].'</th>
        <td>'.$fila['fecha'].'</td>
        
        <td>'.$fila['capturista'].'</td>
        <td>'.$fila['horario1'].' / '.$fila['horario2'].'</td>
        
        <td>'.$fila['tipo'].'</td>
        <td>
        <button class="btn btn-default" id="'.$fila['id_expediente'].'" onclick="editarAgendado(this.id);" title="Editar"><span class="glyphicon glyphicon-pencil"></span></button>
        <button class="btn btn-danger" id="'.$fila['id_expediente'].'" onclick="noValidarServicio(this.id);" title="Eliminar"><span class="glyphicon glyphicon-remove"></span></button>
        </td>
        </tr>
        ';


     }


    echo '</table>';



    if($contador<=0)
    {
        echo "<center><h5>No se encontró expedientes para ".$fila_locacion['locacion']."</h5></center>";
    }
}
mysqli_close($conexion);
 ?>

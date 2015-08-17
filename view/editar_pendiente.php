<?php include "../control/conexion.php" ?>
<?php 
session_start();
date_default_timezone_set("Mexico/General");
$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$titulo="";
$fecha="";
$empleado=0;
$descripcion="";

$consulta="SELECT * from pendiente p 
LEFT JOIN empleado e 
ON p.id_empleado=e.id_empleado 
LEFT JOIN estatus s
ON p.id_estatus=s.id_estatus 
WHERE id_pendiente=".$_POST['id'];
$datos=mysqli_query($conexion,$consulta);
while ($fila=mysqli_fetch_array($datos)) {
$titulo=$fila['titulo'];
$fecha=$fila['fecha'];
$hora=$fila['hora'];
$empleado=$fila['id_empleado'];
$descripcion=$fila['descripcion'];
}
?>

<div class="form">
          <label>Título</label>
          <input type="text" id="txt_titulo_pendiente_edit" placeholder="Título..." class="form-control" value="<?php echo $titulo ?>"><br>
          <label>Fecha</label>
          <input type="date" id="txt_fecha_pendiente_edit" class="form-control" value="<?php echo $fecha ?>"><br>
          <label>Hora</label>
          <input type="time" id="txt_hora_pendiente_edit" class="form-control" value="<?php echo $hora ?>"><br>
          <label>Empleado</label>
          <select id="txt_empleado_pendiente_edit" class="form-control">
            <?php 
            $consulta="SELECT * FROM empleado e 
            LEFT JOIN usuario u ON e.id_usuario=u.id_usuario 
            LEFT JOIN rol r ON u.id_rol=r.id_rol 
              ORDER BY tipo,nombre";
            $datos=mysqli_query($conexion,$consulta);
            while($fila=mysqli_fetch_array($datos))
            {
              if($empleado==$fila['id_empleado'])
              {
                echo '<option value="'.$fila['id_empleado'].'" selected>'.$fila['nombre'].' '.$fila['apaterno'].' '.$fila['amaterno'].' - '.$fila['tipo'].'</option>';
              }else{
                echo '<option value="'.$fila['id_empleado'].'">'.$fila['nombre'].' '.$fila['apaterno'].' '.$fila['amaterno'].' - '.$fila['tipo'].'</option>';
              }
              
            }
             ?>
          </select><br>
          <label>Descripción</label>
          <textarea id="txt_descripcion_pendiente_edit" class="form-control" placeholder="Descripción..."><?php echo $titulo ?></textarea>
</div>


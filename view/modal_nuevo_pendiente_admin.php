<!-- Modal -->
<div class="modal fade" id="modal-nuevo-pendiente-admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Nuevo Pendiente</h4>
      </div>
      <div class="modal-body">
        <div class="form">
          <label>Título</label>
          <input type="text" id="txt_titulo_pendiente" placeholder="Título..." class="form-control"><br>
          <label>Fecha</label>
          <input type="date" id="txt_fecha_pendiente" class="form-control"><br>
          <label>Hora</label>
          <input type="time" id="txt_hora_pendiente" class="form-control"><br>
          <label>Empleado</label>
          <select id="txt_empleado_pendiente" class="form-control">
            <?php 
            include "../control/conexion.php";
            $conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
            mysqli_set_charset($conexion, "utf8");
            $consulta="SELECT * FROM empleado e 
            LEFT JOIN usuario u ON e.id_usuario=u.id_usuario 
            LEFT JOIN rol r ON u.id_rol=r.id_rol 
              ORDER BY tipo,nombre";
            $datos=mysqli_query($conexion,$consulta);
            while($fila=mysqli_fetch_array($datos))
            {
              echo '<option value="'.$fila['id_empleado'].'">'.$fila['nombre'].' '.$fila['apaterno'].' '.$fila['amaterno'].' - '.$fila['tipo'].'</option>';
            }
             ?>
          </select><br>
          <label>Descripción</label>
          <textarea id="txt_descripcion_pendiente" class="form-control" placeholder="Descripción..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <div id="load_pendiente"></div>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="guardarNuevoPendienteAdmin();">Guardar</button>
      </div>
    </div>
  </div>
</div>
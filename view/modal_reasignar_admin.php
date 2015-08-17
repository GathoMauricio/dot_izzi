<!-- Modal -->
<div class="modal fade" id="modal-reasignar-admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Reasignar Pendiente</h4>
      </div>
      <div class="modal-body">
        <div class="form">
          <input type="text" id="txt_reasignar_admin" hidden>
          <label>Empleado</label>
          <select id="txt_reasignar_empleado_pendiente" class="form-control">
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
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="reasignarPendienteAdmin();">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal-editar-pendiente-admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Pendiente <input id="txt_editar_id" readonly></h4>
      </div>
      <div class="modal-body" id="body_editar_pendiente">
        
      </div>
      <div class="modal-footer">
        <div id="load_pendiente"></div>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="editarPendiente();">Actualizar</button>
        
      </div>
    </div>
  </div>
</div>
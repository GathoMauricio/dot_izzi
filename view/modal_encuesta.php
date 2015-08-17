<!-- Modal -->
<div class="modal fade" id="modal-encuesta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ENCUESTA</h4>
      </div>
      <div class="modal-body">

        <input type="text" id="encuesta_expediente" readonly>

        <label id="p1">1.-El Tiempo de Respuesta a su solicitud fue (horario de llegada):</label>
        <select id="r1" class="form-control"><option value="Excelente">Excelete</option><option value="Bueno">Bueno</option><option value="Regular">Regular</option><option value="Malo">Malo</option></select>
        
        <label id="p2">2.-Nuestro Representante de Soporte Técnico Fue Cordial y Paciente?</label>
        <select id="r2" class="form-control"><option value="Excelente">Excelete</option><option value="Bueno">Bueno</option><option value="Regular">Regular</option><option value="Malo">Malo</option></select>
        
        <label id="p3">3.-Nuestro Representante de Soporte Tecnico Estaba Informado y Escucho con atencion su problema?</label>
        <select id="r3" class="form-control"><option value="Excelente">Excelete</option><option value="Bueno">Bueno</option><option value="Regular">Regular</option><option value="Malo">Malo</option></select>
        
        <label id="p4">4.-Le explicaron cual era el problema de su equipo y la solucion?</label>
        <select id="r4" class="form-control"><option value="Excelente">Excelete</option><option value="Bueno">Bueno</option><option value="Regular">Regular</option><option value="Malo">Malo</option></select>
        
        <label id="p5">5.-¿Como Calificaria el proceso para que le resuelvan su problema?</label>
        <select id="r5" class="form-control"><option value="Excelente">Excelete</option><option value="Bueno">Bueno</option><option value="Regular">Regular</option><option value="Malo">Malo</option></select>
        
        <label id="p6">6.-Considera que nuestros ingenieros han entendido perfectamente su problema?</label>
        <select id="r6" class="form-control"><option value="Excelente">Excelete</option><option value="Bueno">Bueno</option><option value="Regular">Regular</option><option value="Malo">Malo</option></select>
        
        <label id="p7">7.-recomendaria nuestros servicios?</label>
        <select id="r7" class="form-control"><option value="SI">SI</option><option value="NO">NO</option><option value="TAL VEZ">TAL VEZ</option>></select>
        
        <label id="p8">Comentarios</label>
        <textarea id="r8" placeholder="Puede agregar comentarios extras...." class="form-control"></textarea>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="guardarEncuesta();">Guardar y Cerrar</button>
      </div>
    </div>
  </div>
</div>
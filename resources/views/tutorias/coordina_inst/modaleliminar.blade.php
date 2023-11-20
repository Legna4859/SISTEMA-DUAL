<div class="modal" tabindex="-1" role="dialog" id="modaleliminar">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h2>¿Deseas eliminar la actividad?</h2>
        <input type="text" id="id_plan_actividad" name="id_plan_actividad" v-model="elimina.ac.id_plan_actividad" hidden="true">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" @click="eliminactividad()">Aceptar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
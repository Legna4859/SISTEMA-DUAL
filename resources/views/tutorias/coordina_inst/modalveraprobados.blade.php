<div class="modal fade" id="modalveraprobados" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Actividades Aprobadas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
         <form id="pl">
            <div class="modal-body">
                <div class="row">
                  <div class="col">
                    <label>Fecha de Inicio</label>
                    <input type="text" class="form-control" v-model="act.va.fi_actividad" disabled="true">
                  </div>
                  <div class="col">
                    <label>Fecha Final</label>
                    <input type="text" class="form-control" v-model="act.va.ff_actividad" disabled="true">
                  </div>
                  <div class="col-12">
                    <label>Descripción</label>
                    <textarea type="text" class="form-control" v-model="act.va.desc_actividad" disabled="true"></textarea> 
                  </div>
                  <div class="col-12">
                    <label>Objetivo</label>
                    <textarea type="text" class="form-control" v-model="act.va.objetivo_actividad" disabled="true"></textarea> 
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
         </form>
    </div>
  </div>
</div>
<div class="modal fade" id="modalveractividades" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Actividad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
         <form id="pl">
            <div class="modal-body">
                <input type="text" name="id_plan_actividad" id="id_plan_actividad" v-model="actividad.des.id_plan_actividad" 
                        hidden="true">
                <div class="row">
                  <div class="col">
                    <label>Fecha de Inicio</label>
                    <input type="text" class="form-control" v-model="actividad.des.fi_actividad" disabled="true">
                  </div>
                  <div class="col">
                    <label>Fecha Final</label>
                    <input type="text" class="form-control" v-model="actividad.des.ff_actividad" disabled="true">
                  </div>
                  <div class="col-12">
                    <label>Descripción</label>
                    <textarea type="text" class="form-control" v-model="actividad.des.desc_actividad" disabled="true"></textarea> 
                  </div>
                  <div class="col-12">
                    <label>Objetivo</label>
                    <textarea type="text" class="form-control" v-model="actividad.des.objetivo_actividad" disabled="true"></textarea> 
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" @click="aprobaract()">Aprobar</button>
              <button type="button" class="btn btn-primary" @click="sugdes()">Sugerencia</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
         </form>
    </div>
  </div>
</div>
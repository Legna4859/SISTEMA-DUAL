<div class="modal fade" id="modalvercorrecion" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Correción</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
         <form id="pl">
            <div class="modal-body">
                <input type="text" name="id_plan_actividad" id="id_plan_actividad" v-model="act.coor_c.id_plan_actividad" 
                        hidden="true">      
                <div class="row">
                  <div class="col-12">
                    <label>Sugerencia anterior</label>
                    <input type="text" class="form-control" v-model="act.coor_c.comentario" disabled="true"> 
                    <br> 
                  </div>  
                  <div class="col">
                    <label>Fecha de Inicio</label>
                    <input type="text" class="form-control" v-model="act.coor_c.fi_actividad" disabled="true">
                  </div>
                  <div class="col">
                    <label>Fecha Final</label>
                    <input type="text" class="form-control" v-model="act.coor_c.ff_actividad" disabled="true">
                  </div>
                  <div class="col-12">
                    <label>Descripción</label>
                    <textarea type="text" class="form-control" v-model="act.coor_c.desc_actividad" disabled="true"></textarea> 
                  </div>
                  <div class="col-12">
                    <label>Objetivo</label>
                    <textarea type="text" class="form-control" v-model="act.coor_c.objetivo_actividad" disabled="true"></textarea> 
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" @click="apruebac()">Aprobar</button>
              <button type="button" class="btn btn-primary" @click="sugdes2()">Sugerencia</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
         </form>
    </div>
  </div>
</div>
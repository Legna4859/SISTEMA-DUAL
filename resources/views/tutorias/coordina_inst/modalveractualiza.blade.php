<div class="modal fade" id="modalveractualiza" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Actualizar Actividad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
         <form id="pl">
            <div class="modal-body">
            	<input type="text" name="id_plan_actividad" id="id_plan_actividad" v-model="actplan.p.id_plan_actividad" hidden="true">
                <div class="row">
                  <div class="col">
                    <label>Fecha de Inicio</label>
                    <input type="date" class="form-control" id="fi_actividad" name="fi_actividad" v-model="actplan.p.fi_actividad"
                            required="true">
                  </div>
                  <div class="col">
                    <label>Fecha Final</label>
                    <input type="date" class="form-control" id="ff_actividad" name="ff_actividad" v-model="actplan.p.ff_actividad"
                            required="true">
                  </div>
                  <div class="col-12">
                    <label>Descripción</label>
                    <textarea type="text" class="form-control" id="desc_actividad" name="desc_actividad" 
                    			v-model="actplan.p.desc_actividad" required="true">
                    </textarea> 
                  </div>
                  <div class="col-12">
                    <label>Objetivo</label>
                    <textarea type="text" class="form-control" id="objetivo_actividad" name="objetivo_actividad" 
                    			v-model="actplan.p.objetivo_actividad" required="true">				
                    </textarea> 
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" @click="actualizarplan()">Actualizar</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
         </form>
    </div>
  </div>
</div>
<div class="modal fade" id="modalsugerencia2" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sugerencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
         <form id="pl">
            <div class="modal-body">
                <div class="row">
                  <div class="col-12">
                    <input type="text" name="id_plan_actividad" id="id_plan_actividad" 
                           v-model="act.coor_c.id_plan_actividad" hidden="true">
                    <textarea type="text" class="form-control" id="comentario" name="comentario" v-model="comentario"
                              required="true"></textarea> 
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" @click="envsuge2()">Enviar</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
         </form>
    </div>
  </div>
</div>
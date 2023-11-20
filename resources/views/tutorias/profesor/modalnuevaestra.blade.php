<div class="modal fade" id="modalnuevaestra" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Actualizar Estrategia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
         <form id="s">
            <div class="modal-body">   
                <div class="col-md-12">
                    <input type="text" id="id_asigna_planeacion_tutor" name="id_asigna_planeacion_tutor"
                           v-model="ingresado.env.id_asigna_planeacion_tutor" hidden="true">
                    <input type="text" id="id_asigna_generacion" name="id_asigna_generacion" 
                           v-model="ingresado.env.id_asigna_generacion" hidden="true">
                    <textarea class="form-control" rows="8" id="estrategia" name="estrategia" v-model="ingresado.env.estrategia" 
                              required="true"> 
                    </textarea>    
                    <label>Requiere subir evidencia</label>
                    <div>
                        <input type="checkbox" class="" id="requiere_evidencia" name="requiere_evidencia" 
                            v-model="ingresado.env.requiere_evidencia">
                    </div>   
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" @click="nueva()">Actualizar</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
         </form>
    </div>
  </div>
</div>
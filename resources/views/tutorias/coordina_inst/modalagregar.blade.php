<div class="modal fade" id="modalagregar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Agregar Actividad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
         <form id="pl">
            <div class="modal-body">
                <div class="row">
                  <div class="col">
                    <input type="text" id="id_generacion" name="id_generacion" v-model="id_generacion" hidden="true">
                    <label>Fecha de Inicio</label>
                    <input type="date" id="fi_actividad" name="fi_actividad" v-model="fi_actividad" class="form-control" 
                     min="<?php echo date("Y-m-d"); ?>" required="true">
                  </div>
                  <div class="col">
                    <label>Fecha Final</label>
                    <input type="date" id="ff_actividad" name="ff_actividad" v-model="ff_actividad" class="form-control" 
                     min="<?php echo date("Y-m-d"); ?>" required="true">
                  </div>
                  <div class="col-12">
                    <label>Descripción</label>
                    <textarea type="text" class="form-control" id="desc_actividad" name="desc_actividad" 
                    v-model="desc_actividad" required="true"></textarea> 
                  </div>
                  <div class="col-12">
                    <label>Objetivo</label>
                    <textarea type="text" class="form-control" id="objetivo_actividad" name="objetivo_actividad" 
                    v-model="objetivo_actividad" required="true"></textarea> 
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" @click="enviar()">Enviar</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
         </form>
    </div>
  </div>
</div>
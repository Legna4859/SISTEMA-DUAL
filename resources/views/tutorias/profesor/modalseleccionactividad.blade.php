<div id="modalseleccionactividad" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">  
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group col-md-12">
                        <h5>¿Desea agregar esta actividad a su planeación?</h5>
                        <input type="text" id="id_plan_actividad" name="id_plan_actividad"
                               v-model="estra.planeacion.id_plan_actividad" hidden="true">
                        <input type="text" id="id_asigna_generacion" name="id_asigna_generacion" 
                               v-model="estra.planeacion.id_asigna_generacion" hidden="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" @click="enviaseleccionado()" class="btn btn-primary">Aceptar</button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
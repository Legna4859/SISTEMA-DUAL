<!-- Modal -->
<div class="modal fade" id="modalcorrecion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div v-if="correct.va.comentario!=null">
                    <h5 class="modal-title">Actualizar Correción</h5>
                </div>
                <div v-else>
                    <h5 class="modal-title">Correción</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <input type="text" name="id_asigna_planeacion_actividad" id="id_asigna_planeacion_actividad" v-model="act.va.id_asigna_planeacion_actividad" hidden="true" >
                    <input type="text" name="id_asigna_generacion" id="id_asigna_generacion" v-model="act.va.id_asigna_generacion" hidden="true">
                    <input type="text" name="id_generacion" id="id_generacion" v-model="act.va.id_generacion" hidden="true">
                    <input type="text" name="generacion" id="generacion" v-model="act.va.generacion" hidden="true">
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            <textarea required class="form-control" rows="8" name="comentario" id="comentario" v-model="correct.va.comentario"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click='submitCorreccion()'>Aceptar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

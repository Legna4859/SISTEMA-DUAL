<div id="modalestrategia" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estrategia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group col-md-12">
                        <input type="text" id="id_asigna_planeacion_tutor" name="id_asigna_planeacion_tutor"
                               v-model="estra.planeacion.id_asigna_planeacion_tutor" hidden="true">
                        <input type="text" id="id_asigna_generacion" name="id_asigna_generacion"
                               v-model="estra.planeacion.id_asigna_generacion" hidden="true">
                        <textarea required class="form-control" rows="8" id="estrategia" name="estrategia"
                                  v-model="estrategia" required="true"></textarea>
                        <label>Requiere subir evidencia</label>
                        <div>
                            <input type="checkbox" class="" id="requiere_evidencia" name="requiere_evidencia"
                                   v-model="requiere_evidencia">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" @click="actualizaestra()" class="btn btn-primary">Guardar</button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


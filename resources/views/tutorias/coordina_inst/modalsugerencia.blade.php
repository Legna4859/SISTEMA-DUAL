<div id="modalsugerencia" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div v-if="suge.sugerencia.id_sugerencia!=null">
                    <h5 class="modal-title">Actualizar Sugerencia</h5>
                </div>
                <div v-else>
                    <h5 class="modal-title">Sugerencia</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group col-md-12">
                        <!--<pre>@{{ suge }}</pre>-->
                            <div class="form-group col-md-12">
                                <label>Decripción Actividad</label>
                                <textarea class="form-control" rows="4" disabled v-model="suge.actividad.desc_actividad"></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Sugerencia de Cambio de Decripción Actividad</label>
                                <textarea class="form-control" rows="4" name="desc_actividad_cambio" disabled v-model="suge.sugerencia.desc_actividad_cambio"></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Objetivo</label>
                                <textarea class="form-control" rows="4" disabled v-model="suge.actividad.objetivo_actividad"></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Sugerencia de Cambio de Objetivo</label>
                                <textarea class="form-control" rows="4" name="objetivo_actividad_cambio" disabled v-model="suge.sugerencia.objetivo_actividad_cambio"></textarea>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" @click="actualizasuge(1)" class="btn btn-outline-success">Aprobar</button>
                    </div>
                    <div>
                        <button type="button" @click="actualizasuge(3)" class="btn btn-outline-danger">Rechazar</button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
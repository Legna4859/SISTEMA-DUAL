<!-- Modal -->
<div class="modal fade" id="modaleditar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Actualizar Información</h5>
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
                    <input type="text" id="id_estado" name="id_estado" hidden="true">
                    <div class="form-row" v-if="act.va.comentario!=null">
                        <div class="form-group col-md-12">
                            <label>Correciones anteriores</label>
                            <textarea class="form-control" rows="3" v-model="act.va.comentario" disabled></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label >Fecha Inicio</label>
                                <input type="text" class="form-control" id="fi_actividad" name="fi_actividad" min="<?php echo date("Y-m-d"); ?>" v-model="act.va.fi_acti" disabled>
                            </div>
                            <div class="col">
                                <label >Fecha Límite</label>
                                <input type="text" class="form-control"  id="ff_actividad" name="ff_actividad" min="<?php echo date("Y-m-d"); ?>" max="" v-model="act.va.ff_acti" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nombre de Actividad</label>
                        <textarea class="form-control" rows="3" id="desc_actividad" name="desc_actividad" v-model="act.va.desc_actividad" disabled></textarea>
                    </div>
                    <div class="form-group">
                        <label>Objetivo</label>
                        <textarea class="form-control" rows="3" id="objetivo_actividad" name="objetivo_actividad" v-model="act.va.objetivo_actividad" disabled></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click='submitAprobar()'>Aprobar</button>
                    <button type="button" class="btn btn-secondary" @click='correccion(act.va)'>Sugerencia</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

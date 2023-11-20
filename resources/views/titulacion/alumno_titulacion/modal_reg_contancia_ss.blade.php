<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_constancia_ss_reg}" >
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_constancia_ss();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">@{{ titulo_constancia_ss }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h3  style="text-align: justify">Constancia de liberación del Servicio Social.</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label>Selecciona el documento</label>

                            <input type="file" id="file"  class="form-control" accept="application/pdf"  v-on:change="variable_doc_5($event)"/>


                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_constancia_ss();">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="guardar_doc_constancia_ss();" :disabled="estado_guardar_constancia_ss">Guardar</button>
                </div>
            </div>
        </div>

    </div>
</div>
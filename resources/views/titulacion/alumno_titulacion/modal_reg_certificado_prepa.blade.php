<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_certificado_prepa_reg}" >
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_certificado_prepa();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">@{{ titulo_certificado_prepa }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h3  style="text-align: justify">Certificado de preparatoria legalizado <b style="color: red;">(Documento legalizado y escaneado por los dos lados)</b></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label>Selecciona el documento</label>

                            <input type="file" id="file"  class="form-control" accept="application/pdf"  v-on:change="variable_doc_3($event)"/>


                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_certificado_prepa();">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="guardar_doc_certificado_prepa();" :disabled="estado_guardar_certificado_prepa">Guardar</button>
                </div>
            </div>
        </div>

    </div>
</div>
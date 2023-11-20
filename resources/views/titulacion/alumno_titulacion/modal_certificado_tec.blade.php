<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_certificado_tesvb_reg}" >
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_certificado_tec();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">@{{ titulo_certificado_tesvb }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h3  style="text-align: justify">Certificado del TESVB <b style="color: red;">(Documento escaneado por los dos lados)</b></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label>Selecciona el documento</label>

                            <input type="file" id="file"  class="form-control" accept="application/pdf"  v-on:change="variable_doc_4($event)"/>


                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_certificado_tec();">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="guardar_doc_certificado_tec();" :disabled="estado_guardar_certificado_tesvb">Guardar</button>
                </div>
            </div>
        </div>

    </div>
</div>
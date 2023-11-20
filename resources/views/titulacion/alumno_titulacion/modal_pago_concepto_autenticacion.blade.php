<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_pago_concepto_autenticacion}" >
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_pago_concepto_autenticacion();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">@{{ titulo_pago_concepto_autenticacion }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h3  style="text-align: justify">Pago por concepto de autenticación de títulos profesionales diplomas o grados académicos electrónicos, para escuelas estatales oficiales o particulares incorporadas de: licenciatura o posgrado, por cada uno.</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label>Selecciona el documento</label>

                            <input type="file" id="file"  class="form-control" accept="application/pdf"  v-on:change="variable_doc_14($event)"/>


                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_pago_concepto_autenticacion();">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="guardar_doc_pago_concepto_autenticacion();" :disabled="estado_guardar_pago_concepto_autenticacion">Guardar</button>
                </div>
            </div>
        </div>

    </div>
</div>
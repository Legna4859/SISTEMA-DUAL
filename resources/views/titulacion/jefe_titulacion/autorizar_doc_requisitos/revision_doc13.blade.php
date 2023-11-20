<div  class="modal" :class="{mostrar:modal_validar_13}" >
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_validar_13();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">Notificación</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h5  style="text-align: justify">Guardar revisión del documento de la acta de residencia profesional</h5>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_validar_13();">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="guardar_validar_13();" :disabled="estadoguardar">Aceptar</button>
                </div>
            </div>
        </div>

    </div>
</div>
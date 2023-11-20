<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_enviar_aceptacion}" >
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModalenviar_autorizacion();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">Notificación de Autorización de Documentación</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h5  style="text-align: justify">¿ Seguro que quieres  Autorizar la documentación?</h5>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModalenviar_autorizacion();">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="Enviar_aceptacion();" :disabled="guarda_envio_correccion">Enviar</button>
                </div>
            </div>
        </div>

    </div>
</div>
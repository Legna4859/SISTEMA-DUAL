<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_enviar_correcciones}" >
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_enviar_correcciones();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">Enviar correcciones de la documentación de  requisitos de titulación</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h5  style="text-align: justify">¿ Seguro que quieres enviar tu documentación con las correcciones?</h5>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_enviar_correcciones();">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="guardar_enviar_correcciones();" :disabled="estado_enviar_correcciones">Enviar</button>
                </div>
            </div>
        </div>

    </div>
</div>
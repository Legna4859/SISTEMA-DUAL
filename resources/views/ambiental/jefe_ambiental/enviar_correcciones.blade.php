<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_env_correcciones}" >
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModalenviar_correcciones();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">@{{  tituloModal}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h5  style="text-align: justify">¿ Seguro que quieres enviar las correcciones de la documentación?</h5>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModalenviar_correcciones(encargados);">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="estadoguardar=true, Enviar_correcciones(encargados);" :disabled="estadoguardar">Enviar</button>
                </div>
            </div>
        </div>

    </div>
</div>
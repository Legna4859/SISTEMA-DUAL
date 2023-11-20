<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_enviar_aurizacion}" >
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_autorizar();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">Autorización</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h4>¿ Seguro que quieres autorizar los datos personales de titulación del estudiante ?</h4>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_autorizar();">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="enviar_autorizacion();" :disabled="estado_guardar_autorizar">Aceptar</button>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_enviar_datos_mod}" >
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_enviar_datos_mod();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">Enviar correciones</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h4>¿ Seguro que quieres enviar las correciones de tu  registro de datos personales al Departamento de Titulación para su revisión y autorización ?</h4>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_enviar_datos_mod();">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="enviar_registro_datos_mod();" :disabled="estado_guardar_envio_mod">Aceptar</button>
                </div>
            </div>
        </div>

    </div>
</div>
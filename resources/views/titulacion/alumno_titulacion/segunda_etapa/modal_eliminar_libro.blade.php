<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_eliminar_libro}" >
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_eliminar_libro();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">Eliminar libro</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                       <h4>¿ Seguro que quieres eliminar el libro ?</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p><b>Titulo del libro: </b> @{{ lib.titulo }}</p>
                        <p><b>Autor del libro: </b> @{{ lib.autor }}</p>
                        <p><b>Editorial del libro: </b> @{{ lib.editorial }}</p>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_eliminar_libro();">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="eliminacion_libro();" :disabled="estado_eliminar_libro">Aceptar</button>
                </div>
            </div>
        </div>

    </div>
</div>
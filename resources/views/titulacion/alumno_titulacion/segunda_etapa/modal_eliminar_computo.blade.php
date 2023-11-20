<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_eliminar_computo}" >
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_eliminar_computo();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">Eliminar equipo y/o material didáctico</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h4>¿ Seguro que quieres eliminar el equipo y/o material didáctico ?</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p><b>Nombre del equipo o material didáctico: </b> @{{ comp.nombre_equipo }}</p>
                        <p><b>Descripción del equipo o material didáctico: </b> @{{ comp.descripcion }}</p>
                        <p><b>Folio fiscal del equipo o material didáctico: </b> @{{ comp.folio_fiscal }}</p>
                        <p><b>Nombre de la tienda del equipo o material didáctico: </b> @{{ comp.nombre_tienda }}</p>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_eliminar_computo();">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="eliminacion_computo();" >Aceptar</button>
                </div>
            </div>
        </div>

    </div>
</div>
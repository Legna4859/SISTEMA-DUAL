<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_per_desact}" >
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_desactivar();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">@{{  tituloModal_periodo}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h5  style="text-align: justify"><b>NOMBRE DEL PERIODO:</b> @{{ periodo.nombre_periodo_amb }}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">¿Seguro que quieres desactivar el periodo?</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_desactivar();">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="guardar_periodo_desactivo();" :disabled="estadoguardar">Aceptar</button>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_encar}" >
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">@{{  tituloModal_encar}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h5  style="text-align: justify"><b>NOMBRE DEL PROCEDIMIENTO:</b> @{{ encargado.nom_procedimiento }}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="personal">SELECCIONAR PERSONAL</label>
                            <select class="form-control"  v-validate="'required'" v-model="encargado.id_personal">
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="personal in personales" :value="personal.id_personal">@{{personal.nombre}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal();">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="guardar_encargado();" :disabled="estadoguardar">Guardar</button>
                </div>
        </div>
        </div>

    </div>
</div>
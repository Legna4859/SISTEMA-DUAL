<!-- Modal -->
<div  class="modal" :class="{mostrar:modal}" >
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">@{{  tituloModal}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="form-group">
                        <label for="nom_procedimiento">Nombre del Procedimiento</label>
                          <textarea v-model="procedimiento.nom_procedimiento" class="form-control" id="nom_procedimiento" name="nom_procedimiento" rows="2"  ></textarea>
                    </div>
                </div>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" @click="cerrarModal();">Cerrar</button>
                <button type="button" class="btn btn-success" @click="guardar_proc();" :disabled="estadoguardar">Guardar</button>
            </div>
        </div>

    </div>
</div>
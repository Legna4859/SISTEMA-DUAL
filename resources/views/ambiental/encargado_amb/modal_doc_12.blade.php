<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_doceavo}" >
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_doceavo();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">@{{  tituloModal }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h5  style="text-align: justify">e) Adecuación de los recursos.</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="personal"> ¿Requiere adecuación de recursos?</label>
                            <select class="form-control"  v-validate="'required'" v-model="doc.evi_adecuacion_recurso_m5"  v-on:change="estado_doc_12($event)">
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="respuesta in respuestas" :value="respuesta.id_respuesta">@{{respuesta.descripcion}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <template v-if="estado_doc == true ">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <label>¿ Si requiere adecuación de recursos, selecciona documento ?</label>

                                <input type="file" id="file"  class="form-control" accept="application/pdf"  v-on:change="variable_doc_12($event)"/>


                            </div>
                        </div>
                    </div>
                </template>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_doceavo();">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="guardar_doc_12();" :disabled="estadoguardar">Guardar</button>
                </div>
            </div>
        </div>

    </div>
</div>
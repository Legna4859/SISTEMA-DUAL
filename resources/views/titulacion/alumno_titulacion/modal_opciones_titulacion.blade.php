<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_opcion_titulacion_reg}" >
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_opciones_titulacion();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">@{{ titulo_opcion_titulacion }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h3  style="text-align: justify">Opciones de Titulación</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="personal">¿ Elige una opción de titulación ?</label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.id_opcion_titulacion">
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="respuesta in opciones_titulacion" :value="respuesta.id_opcion_titulacion">@{{respuesta.opcion_titulacion }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <template v-if="docu.id_opcion_titulacion   == 1">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label>Selecciona Caratula final de residencia</label>

                            <input type="file" id="file"  class="form-control" accept="application/pdf"  v-on:change="variable_doc_7($event)"/>


                        </div>
                    </div>
                </div>
                </template>
                <template v-if="docu.id_opcion_titulacion   == 2 ||
                 docu.id_opcion_titulacion   == 3 || docu.id_opcion_titulacion   == 4 ||
                 docu.id_opcion_titulacion   == 5 || docu.id_opcion_titulacion   == 6 ||
                 docu.id_opcion_titulacion   == 9 || docu.id_opcion_titulacion   == 10">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <label>Selecciona Constancia de Viabilidad</label>

                                <input type="file" id="file"  class="form-control" accept="application/pdf"  v-on:change="variable_doc_7($event)"/>


                            </div>
                        </div>
                    </div>
                </template>
                <template v-if="docu.id_opcion_titulacion   == 7">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <label>Selecciona Testimonio del examen EGEL</label>

                                <input type="file" id="file"  class="form-control" accept="application/pdf"  v-on:change="variable_doc_7($event)"/>


                            </div>
                        </div>
                    </div>
                </template>
                <template v-if="docu.id_opcion_titulacion   == 11">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <label>Selecciona constancia de estudios en el programa dual</label>

                                <input type="file" id="file"  class="form-control" accept="application/pdf"  v-on:change="variable_doc_7($event)"/>


                            </div>
                        </div>
                    </div>
                </template>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_opciones_titulacion();">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="guardar_doc_opcion_titulacion();" :disabled="estado_guardar_opcion_titulacion">Guardar</button>
                </div>
            </div>
        </div>

    </div>
</div>
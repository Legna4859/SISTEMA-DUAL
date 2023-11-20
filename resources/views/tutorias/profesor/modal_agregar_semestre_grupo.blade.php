<div id="modal_agregar_semestre_grupo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar semestre al grupo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 ">
                            <h5 style="text-align: center">Carrera:@{{ datos_generacion.carrera }} <br>
                            Generación:@{{ datos_generacion.generacion }}<br>
                                Grupo:@{{ datos_generacion.grupo }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 ">

                                <label for="personal">Selecciona el semestre del grupo</label>
                            <select class="custom-select custom-select-md"  v-validate="'required'" v-model="datos_generacion.id_grupo_tutoria">
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="respuesta in catalogo_semestres" v-bind:value="respuesta.id_grupo_tutorias" >@{{respuesta.descripcion }}</option>
                            </select>


                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <input type="text" id="id_asigna_tutor" name="id_asigna_tutor"
                               v-model="datos_generacion.id_asigna_tutor"  hidden>

                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" @click="guardar_semestre_grupo()" class="btn btn-primary">Guardar</button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
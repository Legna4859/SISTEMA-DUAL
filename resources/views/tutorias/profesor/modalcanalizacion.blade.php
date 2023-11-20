<div class="modal fade" id="modalcanalizacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Canalizar Alumnos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <input type="text" name="id_alumno" v-model="canaliza.valores.id_alumno" id="id_alumno" hidden="true">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" colspan="4" class="text-center">DATOS DEL ESTUDIANTE</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td scope="col" colspan="3">CARRERA: @{{canaliza.valores.carrera}}</td>
                                    <td scope="col">SEMESTRE: @{{canaliza.valores.descripcion}}</td>
                                    <td scope="col" >FECHA CITA:
                                        <input type="date" class="form-control" id="fecha_canalizacion" name="fecha_canalizacion"
                                               min="<?php echo date("Y-m-d"); ?>" v-model="fecha_canalizacion" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" colspan="3">NOMBRE DEL ESTUDIANTE: @{{canaliza.valores.apaterno}} @{{canaliza.valores.amaterno}} @{{canaliza.valores.nombre}}</td>
                                    <td>GRUPO: @{{canaliza.valores.grupo}}</td>
                                </tr>
                                <tr>
                                    <td scope="row" colspan="3">NOMBRE DEL TUTOR: @{{canaliza.valores.nombre_tut}}</td>
                                    <td>HORA: <input type="time" name="hora" id="hora" v-model="hora" required></td>
                                </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" colspan="4" class="text-center">OBSERVACIONES</th>
                                    <th scope="col" class="text-center">OBSERVACIONES GENERALES</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row" colspan="3" >Aspectos sociológicos</th>
                                    <th scope="row" colspan="6" rowspan="9" >
                                <textarea type="text" id="observaciones" name="observaciones" v-model="observaciones"
                                          class="form-control"></textarea>
                                    </th>
                                </tr>
                                <tr>
                                    <td>Indisciplina:</td>
                                    <td style="width: 8%">
                                        <select id="aspectos_sociologicos1" name="aspectos_sociologicos1" v-model="aspectos_sociologicos1"
                                                class="custom-select" required>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Problemas de integración:</td>
                                    <td style="width: 8%">
                                        <select id="aspectos_sociologicos2" name="aspectos_sociologicos2" v-model="aspectos_sociologicos2"
                                                class="custom-select" required>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Problemas familiares:</td>
                                    <td style="width: 8%">
                                        <select id="aspectos_sociologicos3" name="aspectos_sociologicos3" v-model="aspectos_sociologicos3"
                                                class="custom-select" required>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="3" >Aspectos académicos</th>
                                </tr>
                                <tr>
                                    <td>Dificultades de concentración:</td>
                                    <td style="width: 8%">
                                        <select id="aspectos_academicos1" name="aspectos_academicos1" v-model="aspectos_academicos1"
                                                class="custom-select" required>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Falta de motivación académica:</td>
                                    <td style="width: 8%">
                                        <select id="aspectos_academicos2" name="aspectos_academicos2" v-model="aspectos_academicos2"
                                                class="custom-select" required>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bajo rendimiento académico:</td>
                                    <td style="width: 8%">
                                        <select id="aspectos_academicos3" name="aspectos_academicos3" v-model="aspectos_academicos3"
                                                class="custom-select" required>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="3">OTROS (especifique):
                                        <br>
                                        <textarea type="text" id="otros" name="otros" v-model="otros"class="form-control"></textarea>
                                    </th>
                                </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label ><b>Estatus: </b></label>
                                                <select name="status" id="status" v-model="status" class="custom-select" required>
                                                    <option disabled="true" selected>--Seleccione una opción--</option>
                                                    <option value="En Proceso">En Proceso</option>
                                                    <option value="Terminado">Terminado</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label ><b>Área a Canalizar: </b></label>
                                                <select name="desc_area" id="desc_area" v-model="desc_area" class="custom-select" required>
                                                    <option disabled="true" selected>--Seleccione una opción--</option>
                                                    <option value="Área Psicológica">Área Psicológica</option>
                                                    <option value="Área Académica">Área Académica</option>
                                                    <option value="Área de Salud">Área de Salud</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label ><b>Subárea a Canalizar: </b></label>
                                                <select name="desc_subarea" id="desc_subarea" v-model="desc_subarea" class="custom-select">
                                                    <option disabled="true" selected>--Seleccione una opción--</option>
                                                    <option value="Asesoría Académica">Asesoría Académica</option>
                                                    <option value="Departamento de Residencia">Departamento de Residencia</option>
                                                    <option value="Departamento de Servicio Social">Departamento de Servicio Social</option>
                                                    <option value="Subdirección de Servicios Escolares">Subdirección de Servicios Escolares
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click='submitForm()'>Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
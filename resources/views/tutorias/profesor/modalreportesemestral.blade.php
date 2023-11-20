<div class="modal fade" id="modalreportesemestral" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Agregar Datos</h5>
            </div>
            <div class="modal-body">
                <input type="text" id="id_asigna_generacion" name="id_asigna_generacion" v-model="report.ver.id_asigna_generacion" 
                        hidden="true">
                <input type="text" id="nombre" name="nombre" v-model="report.ver.nombre" hidden="true">
                <input type="text" id="apaterno" name="apaterno" v-model="report.ver.apaterno" hidden="true">
                <input type="text" id="amaterno" name="amaterno" v-model="report.ver.amaterno" hidden="true">
                <input type="text" id="cuenta" name="cuenta" v-model="report.ver.cuenta" hidden="true">
                <input type="text" id="beca" name="beca" v-model="report.ver.beca" hidden="true"> 
                <input type="text" id="materias_repeticion" name="materias_repeticion" v-model="report.ver.materias_repeticion" 
                hidden="true">
                <input type="text" id="materias_especial" name="materias_especial" v-model="report.ver.materias_especial" hidden="true">
                <input type="text" id="estado" name="estado" v-model="report.ver.estado" hidden="true">
                  <form>      
                      <div align="center">
                        <h5>Tutorias</h5>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label>Grupal</label>
                            <select class="custom-select" id="tutoria_grupal" name="tutoria_grupal" v-model="tutoria_grupal" 
                                    required="true">
                                <option>Si</option>
                                <option>No</option>
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Individual</label>
                            <select class="custom-select" id="tutoria_individual" name="tutoria_individual" v-model="tutoria_individual"
                                    required="true">
                                <option>Si</option>
                                <option>No</option>
                           </select>
                        </div>
                      </div>
                      <br>
                      <div align="center">
                        <h5>Apoyo</h5>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label>Académico</label>
                             <select class="custom-select" id="academico" name="academico"  v-model="academico"required="true">
                                <option>Si</option>
                                <option>No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Médico</label>
                            <select class="custom-select" id="medico" name="medico" v-model="medico" required="true">
                                <option>Si</option>
                                <option>No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Psicológico</label>
                            <select class="custom-select" id="psicologico" name="psicologico" v-model="psicologico" required="true">
                                <option>Si</option>
                                <option>No</option>
                            </select>
                        </div>
                      </div>
                      <div class="form-group col-md-12">
                          <label>Observaciones</label>
                          <textarea type="text" id="observaciones" name="observaciones" v-model="observaciones" 
                            class="form-control" maxlength="38"></textarea>
                          <small>Las observaciones deben contener un máximo de 38 caracteres.</small>
                      </div>
                  </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" @click="enviadatos()">Aceptar</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
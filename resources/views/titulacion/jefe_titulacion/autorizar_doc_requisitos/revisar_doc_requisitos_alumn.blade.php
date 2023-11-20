@extends('layouts.app')
@section('title', 'Titulación')
@section('content')

    <main class="col-md-12">

        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <p>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                    <a href="{{url("/titulacion/autorizar_alumnos_doc_requisitos/".$alumno->id_carrera)}}">Autorizar Documentación de requisitos de titulación </a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span>Revisión de Documentación de Requisitos de Titulación</span>
                </p>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Revisión de Documentación de Requisitos de Titulación <br>
                            No. Cuenta: {{ $alumno->cuenta }} <br>
                            Nombre del estudiante: {{ $alumno->nombre }}  {{ $alumno->apaterno }}  {{ $alumno->amaterno }}<br>
                            Carrera: {{ $alumno->carrera }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    {{--
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  --}}
  <div id="envio_doc">

      <template v-if="fecha_activa == 0 ">

          <div class="row">
              <div  class="col-md-10 col-lg-offset-1">
                  <div class="panel panel-danger">
                      <div class="panel-heading">
                          <h3 class="panel-title text-center"> La fecha límite de registro de tu documentación expiro, verifica con el departamento de titulación.</h3>
                      </div>
                  </div>
              </div>
          </div>
      </template>
      <template v-if="fecha_activa == 1 ">

          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="panel panel-success">
                      <div class="panel-body">
                          <div class="col-md-4 ">
                              <h3>Acta de nacimiento</h3><br>
                                  <br/>

                          </div>
                          <div class="col-md-3 ">
                              <label>
                                  <a  target="_blank" href="/titulacion/@{{docu.pdf_acta_nac   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                              </label>
                          </div>
                          <div class="col-md-3" style="text-align: left">
                              <template v-if="docu.cal_acta_nac == 1">
                                    <template v-if="docu.estado_acta_nac == 1">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25" >  SI</h4>

                                    </template>
                                   <template v-if="docu.estado_acta_nac == 2">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25">   NO</h4>
                                   </template>
                              </template>
                              <template v-if="docu.cal_acta_nac == 0">
                                  <div class="form-group">
                                      <label for="personal">Autorizar</label>
                                      <select class="form-control"  v-validate="'required'" v-model="docu.estado_acta_nac" >
                                          <option disabled selected hidden :value="0">Selecciona</option>
                                          <option v-for="respuesta in respuestas" :value="respuesta.id_respuesta">@{{respuesta.descripcion}}</option>
                                      </select>
                                  </div>
                              </template>
                          </div>
                          <template v-if="docu.estado_acta_nac == 1">
                          <template v-if="docu.cal_acta_nac == 0">
                              <div class="col-md-2">
                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_acta();" >Guardar</button>
                              </div>
                          </template>
                          <template v-if="docu.cal_acta_nac == 1">
                              <div class="col-md-2">
                                     <p style="color: red">Revisado</p>
                               </div>
                          </template>
                          </template>

                      </div>


                      <template v-if="docu.estado_acta_nac == 2">
                          <template v-if="docu.cal_acta_nac == 0">
                          <div class="row">
                              <div class="col-md-10 col-md-offset-1">
                                  <div class="form-group">
                                      <label for="domicilio3">Comentario para la modificación </label>
                                      <textarea class="form-control" id="comentario_doc1" v-model="docu.comentario_acta_nac" name="comentario_doc1" rows="1"   required>@{{ $encargados[0]->comentario_estado_acc_m1 }}</textarea>
                                  </div>
                              </div>
                          </div>
                          </template>
                          <template v-if="docu.cal_acta_nac == 1">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación: </label>
                                          <h4 style="color: red">@{{ docu.comentario_acta_nac  }}</h4>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <div class="row">

                              <div class="col-md-2 col-md-offset-5">
                                  <template v-if="docu.cal_acta_nac == 0">

                                          <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_acta();" >Guardar</button>
                                  </template>
                                  <template v-if="docu.cal_acta_nac == 1">
                                          <p style="color: red">Revisado</p>
                                  </template>
                              </div>

                          </div>
                      </template>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="panel panel-success">
                      <div class="panel-body">
                          <div class="col-md-4 ">
                              <h3>Curp<br>
                                  <br/>
                              </h3>
                          </div>
                          <div class="col-md-3 ">
                              <label>
                                  <a  target="_blank" href="/titulacion/@{{docu.pdf_curp   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                              </label>
                          </div>
                          <div class="col-md-3" style="text-align: left">
                              <template v-if="docu.cal_curp == 1">
                                  <template v-if="docu.estado_curp == 1">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25" >  SI</h4>

                                  </template>
                                  <template v-if="docu.estado_curp == 2">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25">   NO</h4>
                                  </template>
                              </template>
                              <template v-if="docu.cal_curp == 0">
                                  <div class="form-group">
                                      <label for="personal">Autorizar</label>
                                      <select class="form-control"  v-validate="'required'" v-model="docu.estado_curp" >
                                          <option disabled selected hidden :value="0">Selecciona</option>
                                          <option v-for="respuesta in respuestas" :value="respuesta.id_respuesta">@{{respuesta.descripcion}}</option>
                                      </select>
                                  </div>
                              </template>
                          </div>
                          <template v-if="docu.estado_curp == 1">
                              <template v-if="docu.cal_curp == 0">
                                  <div class="col-md-2">
                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_curp();" >Guardar</button>
                                  </div>
                              </template>
                              <template v-if="docu.cal_curp == 1">
                                  <div class="col-md-2">
                                      <p style="color: red">Revisado</p>
                                  </div>
                              </template>
                          </template>

                      </div>


                      <template v-if="docu.estado_curp == 2">
                          <template v-if="docu.cal_curp == 0">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación </label>
                                          <textarea class="form-control" id="comentario_doc2" v-model="docu.comentario_curp" name="comentario_doc2" rows="1"   required>@{{ docu.comentario_curp }}</textarea>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <template v-if="docu.cal_curp == 1">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación: </label>
                                          <h4 style="color: red">@{{ docu.comentario_curp  }}</h4>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <div class="row">

                              <div class="col-md-2 col-md-offset-5">
                                  <template v-if="docu.cal_curp == 0">

                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_curp();" >Guardar</button>
                                  </template>
                                  <template v-if="docu.cal_curp == 1">
                                      <p style="color: red">Revisado</p>
                                  </template>
                              </div>

                          </div>
                      </template>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="panel panel-success">
                      <div class="panel-body">
                          <div class="col-md-4 ">
                              <h3>Certificado de preparatoria <b style="color: red;">(Documento legalizado y escaneado por los dos lados)</b> <br>
                                  <br/>
                              </h3>
                          </div>
                          <div class="col-md-3 ">
                              <label>
                                  <a  target="_blank" href="/titulacion/@{{docu.pdf_certificado_prep   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                              </label>
                          </div>
                          <div class="col-md-3" style="text-align: left">
                              <template v-if="docu.cal_certificado_prep == 1">
                                  <template v-if="docu.estado_certificado_prep == 1">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25" >  SI</h4>

                                  </template>
                                  <template v-if="docu.estado_certificado_prep == 2">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25">   NO</h4>
                                  </template>
                              </template>
                              <template v-if="docu.cal_certificado_prep == 0">
                                  <div class="form-group">
                                      <label for="personal">Autorizar</label>
                                      <select class="form-control"  v-validate="'required'" v-model="docu.estado_certificado_prep" >
                                          <option disabled selected hidden :value="0">Selecciona</option>
                                          <option v-for="respuesta in respuestas" :value="respuesta.id_respuesta">@{{respuesta.descripcion}}</option>
                                      </select>
                                  </div>
                              </template>
                          </div>
                          <template v-if="docu.estado_certificado_prep == 1">
                              <template v-if="docu.cal_certificado_prep == 0">
                                  <div class="col-md-2">
                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_certificado_prepa();" >Guardar</button>
                                  </div>
                              </template>
                              <template v-if="docu.cal_certificado_prep == 1">
                                  <div class="col-md-2">
                                      <p style="color: red">Revisado</p>
                                  </div>
                              </template>
                          </template>

                      </div>


                      <template v-if="docu.estado_certificado_prep == 2">
                          <template v-if="docu.cal_certificado_prep == 0">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación </label>
                                          <textarea class="form-control" id="comentario_doc2" v-model="docu.comentario_certificado_prep" name="comentario_doc3" rows="1"   required>@{{ docu.comentario_certificado_prep }}</textarea>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <template v-if="docu.cal_certificado_prep == 1">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación: </label>
                                          <h4 style="color: red">@{{ docu.comentario_certificado_prep  }}</h4>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <div class="row">

                              <div class="col-md-2 col-md-offset-5">
                                  <template v-if="docu.cal_certificado_prep == 0">

                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_certificado_prepa();" >Guardar</button>
                                  </template>
                                  <template v-if="docu.cal_certificado_prep == 1">
                                      <p style="color: red">Revisado</p>
                                  </template>
                              </div>

                          </div>
                      </template>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="panel panel-success">
                      <div class="panel-body">
                          <div class="col-md-4 ">
                              <h3>Certificado del TESVB <b style="color: red;">(Documento escaneado por los dos lados)</b><br>
                                  <br/>
                              </h3>
                          </div>
                          <div class="col-md-3 ">
                              <label>
                                  <a  target="_blank" href="/titulacion/@{{docu.pdf_certificado_tesvb   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                              </label>
                          </div>
                          <div class="col-md-3" style="text-align: left">
                              <template v-if="docu.cal_certificado_tesvb == 1">
                                  <template v-if="docu.estado_certificado_tesvb == 1">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25" >  SI</h4>

                                  </template>
                                  <template v-if="docu.estado_certificado_tesvb == 2">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25">   NO</h4>
                                  </template>
                              </template>
                              <template v-if="docu.cal_certificado_tesvb == 0">
                                  <div class="form-group">
                                      <label for="personal">Autorizar</label>
                                      <select class="form-control"  v-validate="'required'" v-model="docu.estado_certificado_tesvb" >
                                          <option disabled selected hidden :value="0">Selecciona</option>
                                          <option v-for="respuesta in respuestas" :value="respuesta.id_respuesta">@{{respuesta.descripcion}}</option>
                                      </select>
                                  </div>
                              </template>
                          </div>
                          <template v-if="docu.estado_certificado_tesvb == 1">
                              <template v-if="docu.cal_certificado_tesvb == 0">
                                  <div class="col-md-2">
                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_certificado_tesvb();" >Guardar</button>
                                  </div>
                              </template>
                              <template v-if="docu.cal_certificado_tesvb == 1">
                                  <div class="col-md-2">
                                      <p style="color: red">Revisado</p>
                                  </div>
                              </template>
                          </template>

                      </div>


                      <template v-if="docu.estado_certificado_tesvb == 2">
                          <template v-if="docu.cal_certificado_tesvb == 0">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación </label>
                                          <textarea class="form-control" id="comentario_doc4" v-model="docu.comentario_certificado_tesvb" name="comentario_doc4" rows="1"   required>@{{ docu.comentario_certificado_tesvb }}</textarea>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <template v-if="docu.cal_certificado_tesvb == 1">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación: </label>
                                          <h4 style="color: red">@{{ docu.comentario_certificado_tesvb  }}</h4>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <div class="row">

                              <div class="col-md-2 col-md-offset-5">
                                  <template v-if="docu.cal_certificado_tesvb == 0">

                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_certificado_tesvb();" >Guardar</button>
                                  </template>
                                  <template v-if="docu.cal_certificado_tesvb == 1">
                                      <p style="color: red">Revisado</p>
                                  </template>
                              </div>

                          </div>
                      </template>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="panel panel-success">
                      <div class="panel-body">
                          <div class="col-md-4 ">
                              <h3>Constancia de liberación del Servicio Social<br>
                                  <br/>
                              </h3>
                          </div>
                          <div class="col-md-3 ">
                              <label>
                                  <a  target="_blank" href="/titulacion/@{{docu.pdf_constancia_ss    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                              </label>
                          </div>
                          <div class="col-md-3" style="text-align: left">
                              <template v-if="docu.cal_constancia_ss == 1">
                                  <template v-if="docu.estado_constancia_ss == 1">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25" >  SI</h4>

                                  </template>
                                  <template v-if="docu.estado_constancia_ss == 2">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25">   NO</h4>
                                  </template>
                              </template>
                              <template v-if="docu.cal_constancia_ss == 0">
                                  <div class="form-group">
                                      <label for="personal">Autorizar</label>
                                      <select class="form-control"  v-validate="'required'" v-model="docu.estado_constancia_ss" >
                                          <option disabled selected hidden :value="0">Selecciona</option>
                                          <option v-for="respuesta in respuestas" :value="respuesta.id_respuesta">@{{respuesta.descripcion}}</option>
                                      </select>
                                  </div>
                              </template>
                          </div>
                          <template v-if="docu.estado_constancia_ss == 1">
                              <template v-if="docu.cal_constancia_ss == 0">
                                  <div class="col-md-2">
                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_constancia_ss();" >Guardar</button>
                                  </div>
                              </template>
                              <template v-if="docu.cal_constancia_ss == 1">
                                  <div class="col-md-2">
                                      <p style="color: red">Revisado</p>
                                  </div>
                              </template>
                          </template>

                      </div>


                      <template v-if="docu.estado_constancia_ss == 2">
                          <template v-if="docu.cal_constancia_ss == 0">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación </label>
                                          <textarea class="form-control" id="comentario_doc5" v-model="docu.comentario_constancia_ss" name="comentario_doc5" rows="1"   required>@{{ docu.comentario_constancia_ss }}</textarea>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <template v-if="docu.cal_constancia_ss == 1">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación: </label>
                                          <h4 style="color: red">@{{ docu.comentario_constancia_ss  }}</h4>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <div class="row">

                              <div class="col-md-2 col-md-offset-5">
                                  <template v-if="docu.cal_constancia_ss == 0">

                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_constancia_ss();" >Guardar</button>
                                  </template>
                                  <template v-if="docu.cal_constancia_ss == 1">
                                      <p style="color: red">Revisado</p>
                                  </template>
                              </div>

                          </div>
                      </template>
                  </div>
              </div>
          </div>

          <template v-if="veri_constancia_ingles == 2">
          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="panel panel-success">
                      <div class="panel-body">
                          <div class="col-md-4 ">
                              <h3>Constancia de Acreditación del Idioma Ingles<br>
                                  <br/>
                              </h3>
                          </div>
                          <div class="col-md-3 ">
                              <label>
                                  <a  target="_blank" href="/certificado_ingles/@{{ingles.pdf_certificado   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                              </label>
                          </div>
                          <div class="col-md-3" style="text-align: left">
                              <label>El departamento de Actividades Culturales y Deportivas subió al sistema la constancia de acreditación del idioma ingles.</label>
                          </div>

                      </div>



                  </div>
              </div>
          </div>
          </template>
          <template v-if="veri_constancia_ingles == 1">
              <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                      <div class="panel panel-success">
                          <div class="panel-body">
                              <div class="col-md-4 ">
                                  <h3>Constancia de acreditación del idioma ingles<br>
                                      <br/>
                                  </h3>
                              </div>
                              <div class="col-md-3 ">
                                  <label>
                                      <a  target="_blank" href="/titulacion/@{{docu.pdf_certificado_acred_ingles    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                                  </label>
                              </div>
                              <div class="col-md-3" style="text-align: left">
                                  <template v-if="docu.cal_certificado_acred_ingles == 1">
                                      <template v-if="docu.estado_certificado_acred_ingles == 1">
                                          <label for="personal">Autorizado</label>
                                          <h4 style="color: #942a25" >  SI</h4>

                                      </template>
                                      <template v-if="docu.estado_certificado_acred_ingles == 2">
                                          <label for="personal">Autorizado</label>
                                          <h4 style="color: #942a25">   NO</h4>
                                      </template>
                                  </template>
                                  <template v-if="docu.cal_certificado_acred_ingles == 0">
                                      <div class="form-group">
                                          <label for="personal">Autorizar</label>
                                          <select class="form-control"  v-validate="'required'" v-model="docu.estado_certificado_acred_ingles" >
                                              <option disabled selected hidden :value="0">Selecciona</option>
                                              <option v-for="respuesta in respuestas" :value="respuesta.id_respuesta">@{{respuesta.descripcion}}</option>
                                          </select>
                                      </div>
                                  </template>
                              </div>
                              <template v-if="docu.estado_certificado_acred_ingles == 1">
                                  <template v-if="docu.cal_certificado_acred_ingles == 0">
                                      <div class="col-md-2">
                                          <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_certificado_acred_ingles();" >Guardar</button>
                                      </div>
                                  </template>
                                  <template v-if="docu.cal_certificado_acred_ingles == 1">
                                      <div class="col-md-2">
                                          <p style="color: red">Revisado</p>
                                      </div>
                                  </template>
                              </template>

                          </div>


                          <template v-if="docu.estado_certificado_acred_ingles == 2">
                              <template v-if="docu.cal_certificado_acred_ingles == 0">
                                  <div class="row">
                                      <div class="col-md-10 col-md-offset-1">
                                          <div class="form-group">
                                              <label for="domicilio3">Comentario para la modificación </label>
                                              <textarea class="form-control" id="comentario_doc6" v-model="docu.comentario_certificado_acred_ingles" name="comentario_doc6" rows="1"   required>@{{ docu.comentario_certificado_acred_ingles }}</textarea>
                                          </div>
                                      </div>
                                  </div>
                              </template>
                              <template v-if="docu.cal_certificado_acred_ingles == 1">
                                  <div class="row">
                                      <div class="col-md-10 col-md-offset-1">
                                          <div class="form-group">
                                              <label for="domicilio3">Comentario para la modificación: </label>
                                              <h4 style="color: red">@{{ docu.comentario_certificado_acred_ingles  }}</h4>
                                          </div>
                                      </div>
                                  </div>
                              </template>
                              <div class="row">

                                  <div class="col-md-2 col-md-offset-5">
                                      <template v-if="docu.cal_certificado_acred_ingles == 0">

                                          <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_certificado_acred_ingles();" >Guardar</button>
                                      </template>
                                      <template v-if="docu.cal_certificado_acred_ingles == 1">
                                          <p style="color: red">Revisado</p>
                                      </template>
                                  </div>

                              </div>
                          </template>
                      </div>
                  </div>
              </div>
          </template>
          <template v-if="veri_egel == 1">
              <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                      <div class="panel panel-success">
                          <div class="panel-body">
                              <div class="col-md-4 ">
                                  <h3>Reporte individual de resultados del EGEL (ceneval) <br>
                                      <br/>
                                  </h3>
                              </div>
                              <div class="col-md-3 ">
                                  <label>
                                      <a  target="_blank" href="/titulacion/@{{docu.pdf_reporte_result_egel    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                                  </label>
                              </div>
                              <div class="col-md-3" style="text-align: left">
                                  <template v-if="docu.cal_reporte_result_egel == 1">
                                      <template v-if="docu.estado_reporte_result_egel == 1">
                                          <label for="personal">Autorizado</label>
                                          <h4 style="color: #942a25" >  SI</h4>

                                      </template>
                                      <template v-if="docu.estado_reporte_result_egel == 2">
                                          <label for="personal">Autorizado</label>
                                          <h4 style="color: #942a25">   NO</h4>
                                      </template>
                                  </template>
                                  <template v-if="docu.cal_reporte_result_egel == 0">
                                      <div class="form-group">
                                          <label for="personal">Autorizar</label>
                                          <select class="form-control"  v-validate="'required'" v-model="docu.estado_reporte_result_egel" >
                                              <option disabled selected hidden :value="0">Selecciona</option>
                                              <option v-for="respuesta in respuestas" :value="respuesta.id_respuesta">@{{respuesta.descripcion}}</option>
                                          </select>
                                      </div>
                                  </template>
                              </div>
                              <template v-if="docu.estado_reporte_result_egel == 1">
                                  <template v-if="docu.cal_reporte_result_egel == 0">
                                      <div class="col-md-2">
                                          <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_reporte_result_egel();" >Guardar</button>
                                      </div>
                                  </template>
                                  <template v-if="docu.cal_reporte_result_egel == 1">
                                      <div class="col-md-2">
                                          <p style="color: red">Revisado</p>
                                      </div>
                                  </template>
                              </template>

                          </div>


                          <template v-if="docu.estado_reporte_result_egel == 2">
                              <template v-if="docu.cal_reporte_result_egel == 0">
                                  <div class="row">
                                      <div class="col-md-10 col-md-offset-1">
                                          <div class="form-group">
                                              <label for="domicilio3">Comentario para la modificación </label>
                                              <textarea class="form-control" id="comentario_doc5" v-model="docu.comentario_reporte_result_egel" name="comentario_doc5" rows="1"   required>@{{ docu.comentario_reporte_result_egel }}</textarea>
                                          </div>
                                      </div>
                                  </div>
                              </template>
                              <template v-if="docu.cal_reporte_result_egel == 1">
                                  <div class="row">
                                      <div class="col-md-10 col-md-offset-1">
                                          <div class="form-group">
                                              <label for="domicilio3">Comentario para la modificación: </label>
                                              <h4 style="color: red">@{{ docu.comentario_reporte_result_egel  }}</h4>
                                          </div>
                                      </div>
                                  </div>
                              </template>
                              <div class="row">

                                  <div class="col-md-2 col-md-offset-5">
                                      <template v-if="docu.cal_reporte_result_egel == 0">

                                          <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_reporte_result_egel();" >Guardar</button>
                                      </template>
                                      <template v-if="docu.cal_reporte_result_egel == 1">
                                          <p style="color: red">Revisado</p>
                                      </template>
                                  </div>

                              </div>
                          </template>
                      </div>
                  </div>
              </div>
          </template>
          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="panel panel-success">
                      <div class="panel-body">
                          <div class="col-md-4 ">
                              <h4>Opcion de titulación:<br>
                                  <br/>

                                      <template v-if="docu.id_opcion_titulacion   == 1">

                                              <b>I. Informe de residencia</b> <br>
                                              Caratula final de residencia <br>
                                      </template>
                                      <template v-if="docu.id_opcion_titulacion   == 2">

                                              <b>II. Proyecto de Innovación</b> <br>
                                              Constancia de Viabilidad <br>

                                      </template>
                                      <template v-if="docu.id_opcion_titulacion   == 3">

                                              <b>III. Proyecto de investigación</b> <br>
                                              Constancia de Viabilidad <br>


                                      </template>
                                      <template v-if="docu.id_opcion_titulacion   == 4">
                                              <b>IV. Informe de Estancia</b> <br>
                                              Constancia de Viabilidad <br>

                                      </template>
                                      <template v-if="docu.id_opcion_titulacion   == 5">

                                              <b>V. Tesis</b> <br>
                                              Constancia de Viabilidad <br>

                                      </template>
                                      <template v-if="docu.id_opcion_titulacion   == 6">

                                              <b>VI. Tesina</b> <br>
                                              Constancia de Viabilidad <br>

                                      </template>
                                  <template v-if="docu.id_opcion_titulacion   == 7">
                                          <b>VII. Otros : Ceneval</b> <br>
                                          Testimonio del examen EGEL<br>

                                  </template>
                                  <template v-if="docu.id_opcion_titulacion   == 8">

                                          <b>VII. Otros : Examen por área del conocimiento</b> <br>
                                          No se necesita documento <br>

                                  </template>
                                      <template v-if="docu.id_opcion_titulacion   == 9">
                                              <b>VII. Otros : Experiencia Profesional</b> <br>
                                              Constancia de Viabilidad <br>

                                      </template>
                                      <template v-if="docu.id_opcion_titulacion   == 10">

                                              <b>VII. Otros : Incubación de negocio</b> <br>
                                              Constancia de Viabilidad <br>


                                      </template>
                                  <template v-if="docu.id_opcion_titulacion   == 11">

                                      <b>VII. Otros : Modalidad dual</b> <br>
                                      Constancia de estudios en el programa dual <br>


                                  </template>

                              </h4>
                          </div>
                          <div class="col-md-3 ">
                              <template v-if="docu.id_opcion_titulacion   != 8 ">
                              <label>
                                  <a  target="_blank" href="/titulacion/@{{docu.pdf_opcion_titulacion    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                              </label>
                              </template>
                          </div>
                          <div class="col-md-3" style="text-align: left">
                              <template v-if="docu.cal_opcion_titulacion == 1">
                                  <template v-if="docu.estado_opcion_titulacion == 1">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25" >  SI</h4>

                                  </template>
                                  <template v-if="docu.estado_opcion_titulacion == 2">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25">   NO</h4>
                                  </template>
                              </template>
                              <template v-if="docu.cal_opcion_titulacion == 0">
                                  <div class="form-group">
                                      <label for="personal">Autorizar</label>
                                      <select class="form-control"  v-validate="'required'" v-model="docu.estado_opcion_titulacion" >
                                          <option disabled selected hidden :value="0">Selecciona</option>
                                          <option v-for="respuesta in respuestas" :value="respuesta.id_respuesta">@{{respuesta.descripcion}}</option>
                                      </select>
                                  </div>
                              </template>
                          </div>
                          <template v-if="docu.estado_opcion_titulacion == 1">
                              <template v-if="docu.cal_opcion_titulacion == 0">
                                  <div class="col-md-2">
                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_opcion_titulacion();" >Guardar</button>
                                  </div>
                              </template>
                              <template v-if="docu.cal_opcion_titulacion == 1">
                                  <div class="col-md-2">
                                      <p style="color: red">Revisado</p>
                                  </div>
                              </template>
                          </template>

                      </div>


                      <template v-if="docu.estado_opcion_titulacion == 2">
                          <template v-if="docu.cal_opcion_titulacion == 0">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación </label>
                                          <textarea class="form-control" id="comentario_doc6" v-model="docu.comentario_opcion_titulacion" name="comentario_doc6" rows="1"   required>@{{ docu.comentario_opcion_titulacion }}</textarea>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <template v-if="docu.cal_opcion_titulacion == 1">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación: </label>
                                          <h4 style="color: red">@{{ docu.comentario_opcion_titulacion  }}</h4>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <div class="row">

                              <div class="col-md-2 col-md-offset-5">
                                  <template v-if="docu.cal_opcion_titulacion == 0">

                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_opcion_titulacion();" >Guardar</button>
                                  </template>
                                  <template v-if="docu.cal_opcion_titulacion == 1">
                                      <p style="color: red">Revisado</p>
                                  </template>

                              </div>

                          </div>
                      </template>
                  </div>
              </div>
          </div>
          <template v-if="veri_anterior_10 == 0">
              <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                      <div class="panel panel-success">
                          <div class="panel-body">
                              <div class="col-md-4 ">
                                  <h3>Acta de residencia profesional<br>
                                      <br/>
                                  </h3>
                              </div>
                              <div class="col-md-3 ">
                                  <label>
                                      <a  target="_blank" href="/titulacion/@{{docu.pdf_acta_residencia    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                                  </label>
                              </div>
                              <div class="col-md-3" style="text-align: left">
                                  <template v-if="docu.cal_acta_residencia == 1">
                                      <template v-if="docu.estado_acta_residencia == 1">
                                          <label for="personal">Autorizado</label>
                                          <h4 style="color: #942a25" >  SI</h4>

                                      </template>
                                      <template v-if="docu.estado_acta_residencia == 2">
                                          <label for="personal">Autorizado</label>
                                          <h4 style="color: #942a25">   NO</h4>
                                      </template>
                                  </template>
                                  <template v-if="docu.cal_acta_residencia == 0">
                                      <div class="form-group">
                                          <label for="personal">Autorizar</label>
                                          <select class="form-control"  v-validate="'required'" v-model="docu.estado_acta_residencia" >
                                              <option disabled selected hidden :value="0">Selecciona</option>
                                              <option v-for="respuesta in respuestas" :value="respuesta.id_respuesta">@{{respuesta.descripcion}}</option>
                                          </select>
                                      </div>
                                  </template>
                              </div>
                              <template v-if="docu.estado_acta_residencia == 1">
                                  <template v-if="docu.cal_acta_residencia == 0">
                                      <div class="col-md-2">
                                          <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_acta_residencia();" >Guardar</button>
                                      </div>
                                  </template>
                                  <template v-if="docu.cal_acta_residencia == 1">
                                      <div class="col-md-2">
                                          <p style="color: red">Revisado</p>
                                      </div>
                                  </template>
                              </template>

                          </div>


                          <template v-if="docu.estado_acta_residencia == 2">
                              <template v-if="docu.cal_acta_residencia == 0">
                                  <div class="row">
                                      <div class="col-md-10 col-md-offset-1">
                                          <div class="form-group">
                                              <label for="domicilio3">Comentario para la modificación </label>
                                              <textarea class="form-control" id="comentario_doc5" v-model="docu.comentario_acta_residencia" name="comentario_doc5" rows="1"   required>@{{ docu.comentario_acta_residencia }}</textarea>
                                          </div>
                                      </div>
                                  </div>
                              </template>
                              <template v-if="docu.cal_acta_residencia == 1">
                                  <div class="row">
                                      <div class="col-md-10 col-md-offset-1">
                                          <div class="form-group">
                                              <label for="domicilio3">Comentario para la modificación: </label>
                                              <h4 style="color: red">@{{ docu.comentario_acta_residencia  }}</h4>
                                          </div>
                                      </div>
                                  </div>
                              </template>
                              <div class="row">

                                  <div class="col-md-2 col-md-offset-5">
                                      <template v-if="docu.cal_acta_residencia == 0">

                                          <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_acta_residencia();" >Guardar</button>
                                      </template>
                                      <template v-if="docu.cal_acta_residencia == 1">
                                          <p style="color: red">Revisado</p>
                                      </template>
                                  </div>

                              </div>
                          </template>
                      </div>
                  </div>
              </div>
          </template>
          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="panel panel-success">
                      <div class="panel-body">
                          <div class="col-md-4 ">
                              <h3>Pago de registro de título profesional de licenciatura con timbre holograma<br>
                                  <br/>
                              </h3>
                          </div>
                          <div class="col-md-3 ">
                              <label>
                                  <a  target="_blank" href="/titulacion/@{{docu.pdf_pago_titulo    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                              </label>
                          </div>
                          <div class="col-md-3" style="text-align: left">
                              <template v-if="docu.cal_pago_titulo == 1">
                                  <template v-if="docu.estado_pago_titulo == 1">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25" >  SI</h4>

                                  </template>
                                  <template v-if="docu.estado_pago_titulo == 2">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25">   NO</h4>
                                  </template>
                              </template>
                              <template v-if="docu.cal_pago_titulo == 0">
                                  <div class="form-group">
                                      <label for="personal">Autorizar</label>
                                      <select class="form-control"  v-validate="'required'" v-model="docu.estado_pago_titulo" >
                                          <option disabled selected hidden :value="0">Selecciona</option>
                                          <option v-for="respuesta in respuestas" :value="respuesta.id_respuesta">@{{respuesta.descripcion}}</option>
                                      </select>
                                  </div>
                              </template>
                          </div>
                          <template v-if="docu.estado_pago_titulo == 1">
                              <template v-if="docu.cal_pago_titulo == 0">
                                  <div class="col-md-2">
                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_pago_titulo();" >Guardar</button>
                                  </div>
                              </template>
                              <template v-if="docu.cal_pago_titulo == 1">
                                  <div class="col-md-2">
                                      <p style="color: red">Revisado</p>
                                  </div>
                              </template>
                          </template>

                      </div>


                      <template v-if="docu.estado_pago_titulo == 2">
                          <template v-if="docu.cal_pago_titulo == 0">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación </label>
                                          <textarea class="form-control" id="comentario_doc5" v-model="docu.comentario_pago_titulo" name="comentario_doc5" rows="1"   required>@{{ docu.comentario_pago_titulo }}</textarea>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <template v-if="docu.cal_pago_titulo == 1">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación: </label>
                                          <h4 style="color: red">@{{ docu.comentario_pago_titulo  }}</h4>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <div class="row">

                              <div class="col-md-2 col-md-offset-5">
                                  <template v-if="docu.cal_pago_titulo == 0">

                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_pago_titulo();" >Guardar</button>
                                  </template>
                                  <template v-if="docu.cal_pago_titulo == 1">
                                      <p style="color: red">Revisado</p>
                                  </template>
                              </div>

                          </div>
                      </template>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="panel panel-success">
                      <div class="panel-body">
                          <div class="col-md-4 ">
                              <h3>Pago de constancia de no adeudo<br>
                                  <br/>
                              </h3>
                          </div>
                          <div class="col-md-3 ">
                              <label>
                                  <a  target="_blank" href="/titulacion/@{{docu.pdf_pago_contancia    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                              </label>
                          </div>
                          <div class="col-md-3" style="text-align: left">
                              <template v-if="docu.cal_pago_contancia == 1">
                                  <template v-if="docu.estado_pago_contancia == 1">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25" >  SI</h4>

                                  </template>
                                  <template v-if="docu.estado_pago_contancia == 2">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25">   NO</h4>
                                  </template>
                              </template>
                              <template v-if="docu.cal_pago_contancia == 0">
                                  <div class="form-group">
                                      <label for="personal">Autorizar</label>
                                      <select class="form-control"  v-validate="'required'" v-model="docu.estado_pago_contancia" >
                                          <option disabled selected hidden :value="0">Selecciona</option>
                                          <option v-for="respuesta in respuestas" :value="respuesta.id_respuesta">@{{respuesta.descripcion}}</option>
                                      </select>
                                  </div>
                              </template>
                          </div>
                          <template v-if="docu.estado_pago_contancia == 1">
                              <template v-if="docu.cal_pago_contancia == 0">
                                  <div class="col-md-2">
                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_pago_contancia();" >Guardar</button>
                                  </div>
                              </template>
                              <template v-if="docu.cal_pago_contancia == 1">
                                  <div class="col-md-2">
                                      <p style="color: red">Revisado</p>
                                  </div>
                              </template>
                          </template>

                      </div>


                      <template v-if="docu.estado_pago_contancia == 2">
                          <template v-if="docu.cal_pago_contancia == 0">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación </label>
                                          <textarea class="form-control" id="comentario_doc5" v-model="docu.comentario_pago_contancia" name="comentario_doc5" rows="1"   required>@{{ docu.comentario_pago_contancia }}</textarea>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <template v-if="docu.cal_pago_contancia == 1">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación: </label>
                                          <h4 style="color: red">@{{ docu.comentario_pago_contancia  }}</h4>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <div class="row">

                              <div class="col-md-2 col-md-offset-5">
                                  <template v-if="docu.cal_pago_contancia == 0">

                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_pago_contancia();" >Guardar</button>
                                  </template>
                                  <template v-if="docu.cal_pago_contancia == 1">
                                      <p style="color: red">Revisado</p>
                                  </template>
                              </div>

                          </div>
                      </template>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="panel panel-success">
                      <div class="panel-body">
                          <div class="col-md-4 ">
                              <h3>Pago de derecho de titulación<br>
                                  <br/>
                              </h3>
                          </div>
                          <div class="col-md-3 ">
                              <label>
                                  <a  target="_blank" href="/titulacion/@{{docu.pdf_pago_derecho_ti    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                              </label>
                          </div>
                          <div class="col-md-3" style="text-align: left">
                              <template v-if="docu.cal_pago_derecho_ti == 1">
                                  <template v-if="docu.estado_pago_derecho_ti == 1">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25" >  SI</h4>

                                  </template>
                                  <template v-if="docu.estado_pago_derecho_ti == 2">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25">   NO</h4>
                                  </template>
                              </template>
                              <template v-if="docu.cal_pago_derecho_ti == 0">
                                  <div class="form-group">
                                      <label for="personal">Autorizar</label>
                                      <select class="form-control"  v-validate="'required'" v-model="docu.estado_pago_derecho_ti" >
                                          <option disabled selected hidden :value="0">Selecciona</option>
                                          <option v-for="respuesta in respuestas" :value="respuesta.id_respuesta">@{{respuesta.descripcion}}</option>
                                      </select>
                                  </div>
                              </template>
                          </div>
                          <template v-if="docu.estado_pago_derecho_ti == 1">
                              <template v-if="docu.cal_pago_derecho_ti == 0">
                                  <div class="col-md-2">
                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_pago_derecho_ti();" >Guardar</button>
                                  </div>
                              </template>
                              <template v-if="docu.cal_pago_derecho_ti == 1">
                                  <div class="col-md-2">
                                      <p style="color: red">Revisado</p>
                                  </div>
                              </template>
                          </template>

                      </div>


                      <template v-if="docu.estado_pago_derecho_ti == 2">
                          <template v-if="docu.cal_pago_derecho_ti == 0">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación </label>
                                          <textarea class="form-control" id="comentario_doc5" v-model="docu.comentario_pago_derecho_ti" name="comentario_doc5" rows="1"   required>@{{ docu.comentario_pago_derecho_ti }}</textarea>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <template v-if="docu.cal_pago_derecho_ti == 1">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación: </label>
                                          <h4 style="color: red">@{{ docu.comentario_pago_derecho_ti  }}</h4>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <div class="row">

                              <div class="col-md-2 col-md-offset-5">
                                  <template v-if="docu.cal_pago_derecho_ti == 0">

                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_pago_derecho_ti();" >Guardar</button>
                                  </template>
                                  <template v-if="docu.cal_pago_derecho_ti == 1">
                                      <p style="color: red">Revisado</p>
                                  </template>
                              </div>

                          </div>
                      </template>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="panel panel-success">
                      <div class="panel-body">
                          <div class="col-md-4 ">
                              <h3>Pago de integrantes a jurado<br>
                                  <br/>
                              </h3>
                          </div>
                          <div class="col-md-3 ">
                              <label>
                                  <a  target="_blank" href="/titulacion/@{{docu.pdf_pago_integrante_jurado    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                              </label>
                          </div>
                          <div class="col-md-3" style="text-align: left">
                              <template v-if="docu.cal_pago_integrante_jurado == 1">
                                  <template v-if="docu.estado_pago_integrante_jurado == 1">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25" >  SI</h4>

                                  </template>
                                  <template v-if="docu.estado_pago_integrante_jurado == 2">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25">   NO</h4>
                                  </template>
                              </template>
                              <template v-if="docu.cal_pago_integrante_jurado == 0">
                                  <div class="form-group">
                                      <label for="personal">Autorizar</label>
                                      <select class="form-control"  v-validate="'required'" v-model="docu.estado_pago_integrante_jurado" >
                                          <option disabled selected hidden :value="0">Selecciona</option>
                                          <option v-for="respuesta in respuestas" :value="respuesta.id_respuesta">@{{respuesta.descripcion}}</option>
                                      </select>
                                  </div>
                              </template>
                          </div>
                          <template v-if="docu.estado_pago_integrante_jurado == 1">
                              <template v-if="docu.cal_pago_integrante_jurado == 0">
                                  <div class="col-md-2">
                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_integrante_jurado();" >Guardar</button>
                                  </div>
                              </template>
                              <template v-if="docu.cal_pago_integrante_jurado == 1">
                                  <div class="col-md-2">
                                      <p style="color: red">Revisado</p>
                                  </div>
                              </template>
                          </template>

                      </div>


                      <template v-if="docu.estado_pago_integrante_jurado == 2">
                          <template v-if="docu.cal_pago_integrante_jurado == 0">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación </label>
                                          <textarea class="form-control" id="comentario_doc5" v-model="docu.comentario_pago_integrante_jurado" name="comentario_doc5" rows="1"   required>@{{ docu.comentario_pago_integrante_jurado }}</textarea>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <template v-if="docu.cal_pago_integrante_jurado == 1">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación: </label>
                                          <h4 style="color: red">@{{ docu.comentario_pago_integrante_jurado  }}</h4>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <div class="row">

                              <div class="col-md-2 col-md-offset-5">
                                  <template v-if="docu.cal_pago_integrante_jurado == 0">

                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_resp_integrante_jurado();" >Guardar</button>
                                  </template>
                                  <template v-if="docu.cal_pago_integrante_jurado == 1">
                                      <p style="color: red">Revisado</p>
                                  </template>
                              </div>

                          </div>
                      </template>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="panel panel-success">
                      <div class="panel-body">
                          <div class="col-md-4 ">
                              <h3>Pago por concepto de autenticación de títulos profesionales diplomas o grados académicos electrónicos, para escuelas estatales oficiales o particulares incorporadas de: licenciatura o posgrado, por cada uno.<br>
                                  <br/>
                              </h3>
                          </div>
                          <div class="col-md-3 ">
                              <label>
                                  <a  target="_blank" href="/titulacion/@{{docu.pdf_pago_concepto_autenticacion    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                              </label>
                          </div>
                          <div class="col-md-3" style="text-align: left">
                              <template v-if="docu.cal_pago_concepto_autenticacion == 1">
                                  <template v-if="docu.estado_pago_concepto_autenticacion == 1">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25" >  SI</h4>

                                  </template>
                                  <template v-if="docu.estado_pago_concepto_autenticacion == 2">
                                      <label for="personal">Autorizado</label>
                                      <h4 style="color: #942a25">   NO</h4>
                                  </template>
                              </template>
                              <template v-if="docu.cal_pago_concepto_autenticacion == 0">
                                  <div class="form-group">
                                      <label for="personal">Autorizar</label>
                                      <select class="form-control"  v-validate="'required'" v-model="docu.estado_pago_concepto_autenticacion" >
                                          <option disabled selected hidden :value="0">Selecciona</option>
                                          <option v-for="respuesta in respuestas" :value="respuesta.id_respuesta">@{{respuesta.descripcion}}</option>
                                      </select>
                                  </div>
                              </template>
                          </div>
                          <template v-if="docu.estado_pago_concepto_autenticacion == 1">
                              <template v-if="docu.cal_pago_concepto_autenticacion == 0">
                                  <div class="col-md-2">
                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_pago_concepto_autenticacion();" >Guardar</button>
                                  </div>
                              </template>
                              <template v-if="docu.cal_pago_concepto_autenticacion == 1">
                                  <div class="col-md-2">
                                      <p style="color: red">Revisado</p>
                                  </div>
                              </template>
                          </template>

                      </div>


                      <template v-if="docu.estado_pago_concepto_autenticacion == 2">
                          <template v-if="docu.cal_pago_concepto_autenticacion == 0">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación </label>
                                          <textarea class="form-control" id="comentario_doc5" v-model="docu.comentario_pago_concepto_autenticacion" name="comentario_doc5" rows="1"   required>@{{ docu.comentario_pago_concepto_autenticacion }}</textarea>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <template v-if="docu.cal_pago_concepto_autenticacion == 1">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <div class="form-group">
                                          <label for="domicilio3">Comentario para la modificación: </label>
                                          <h4 style="color: red">@{{ docu.comentario_pago_concepto_autenticacion  }}</h4>
                                      </div>
                                  </div>
                              </div>
                          </template>
                          <div class="row">

                              <div class="col-md-2 col-md-offset-5">
                                  <template v-if="docu.cal_pago_concepto_autenticacion == 0">

                                      <button style="margin: 30px"  class="btn btn-primary btn-sm" v-on:click="guardar_pago_concepto_autenticacion();" >Guardar</button>
                                  </template>
                                  <template v-if="docu.cal_pago_concepto_autenticacion == 1">
                                      <p style="color: red">Revisado</p>
                                  </template>
                              </div>

                          </div>
                      </template>
                  </div>
              </div>
          </div>
          <div class="row">
              <div  class="col-md-10 col-lg-offset-1">
                  <table id="tabla_envio" class="table table-bordered table-resposive">

                      <thead>
                      <tr>

                          <th>Requisito</th>
                          <th>Ver Documento</th>
                          <th>Acción</th>

                      </tr>
                      </thead>

                      <tbody>
                      <tr>
                          <td>Constancia de No Adeudo</td>
                          <template v-if="docu.evi_constancia_adeudo  == 0">
                              <th></th>
                              <td><button  class="btn btn-primary btn-sm" v-on:click="modificar_constancia_adeudo=false, abrirModal_constancia_adeudo();" >Agregar</button></td>
                          </template>
                          <template v-if="docu.evi_constancia_adeudo  == 1">
                              <th><a  target="_blank" href="/titulacion/@{{docu.pdf_constancia_adeudo   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></th>
                              <td><button  class="btn btn-warning btn-sm" v-on:click="modificar_constancia_adeudo=true, abrirModal_constancia_adeudo();" >Modificar</button></td>
                          </template>
                      </tr>
                      </tbody>
                  </table>
              </div>
          </div>

          @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.enviar_revision_doc')
      </template>


      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.revision_doc1')
      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.revision_doc2')
      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.revision_doc3')
      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.revision_doc4')
      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.revision_doc5')
      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.revision_doc6')
      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.revision_doc7')
      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.revision_doc8')
      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.revision_doc9')
      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.revision_doc10')
      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.revision_doc11')
      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.revision_doc12')
      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.revision_doc13')
      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.revision_doc14')
      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.modal_reg_constancia_adeudo')
      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.modal_enviar_correccion')
      @include('titulacion.jefe_titulacion.autorizar_doc_requisitos.aceptar_documentacion')


  </div>

</main>

<script>
  new Vue({
      el:"#envio_doc",

      data(){
          return {

              //lo inicialisamos el array
              documentacion:[],
              fecha_activa:[],
              veri_egel:[],
              veri_anterior_10:[],
              est_actual_doc_al:[],
              veri_constancia_ingles:[],
              estado_certi_in:[],
              opciones_titulacion:[],
              respuestas:[],

              estado_guardar_correo:false,
              estado_guardar_acta:false,
              estado_guardar_curp:false,
              estado_guardar_certificado_prepa:false,
              estado_guardar_certificado_tesvb:false,
              estado_guardar_constancia_ss:false,
              estado_guardar_certificado_ingles:false,
              estado_guardar_opcion_titulacion:false,
              estado_enviar:false,



              correo_electronico:"",
              estadoguardar:false,

              docu:{
                  id_requisitos:0,
                  id_alumno :0,

                  evi_acta_nac:0,
                  comentario_acta_nac:"",
                  pdf_acta_nac:"",
                  estado_acta_nac :0,
                  cal_acta_nac :0,

                  evi_curp:0,
                  comentario_curp:"",
                  pdf_curp:"",
                  estado_curp :0,
                  cal_curp :0,

                  evi_certificado_prep:0,
                  comentario_certificado_prep:"",
                  pdf_certificado_prep:"",
                  estado_certificado_prep :0,
                  cal_certificado_prep :0,

                  evi_certificado_tesvb:0,
                  comentario_certificado_tesvb:"",
                  pdf_certificado_tesvb:"",
                  estado_certificado_tesvb :0,
                  cal_certificado_tesvb :0,

                  evi_constancia_ss:0,
                  comentario_constancia_ss:"",
                  pdf_constancia_ss:"",
                  estado_constancia_ss :0,
                  cal_constancia_ss:0,

                  evi_certificado_acred_ingles:0,
                  comentario_certificado_acred_ingles:"",
                  pdf_certificado_acred_ingles:"",
                  estado_certificado_acred_ingles :0,
                  cal_certificado_acred_ingles:0,

                  evi_reporte_result_egel:0,
                  comentario_reporte_result_egel:"",
                  pdf_reporte_result_egel:"",
                  estado_reporte_result_egel:0,
                  cal_reporte_result_egel:0,

                  id_opcion_titulacion:0,


                  evi_opcion_titulacion:0,
                  comentario_opcion_titulacion:"",
                  pdf_opcion_titulacion:"",
                  estado_opcion_titulacion :0,
                  cal_opcion_titulacion:0,

                  evi_constancia_adeudo:0,
                  comentario_constancia_adeudo:"",
                  pdf_constancia_adeudo:"",
                  estado_constancia_adeudo :0,

                  evi_pago_titulo:0,
                  comentario_pago_titulo:"",
                  pdf_pago_titulo:"",
                  estado_pago_titulo:0,
                  cal_pago_titulo:0,

                  evi_pago_contancia:0,
                  comentario_pago_contancia:"",
                  pdf_pago_contancia:"",
                  estado_pago_contancia:0,
                  cal_pago_contancia:0,

                  evi_pago_derecho_ti:0,
                  comentario_pago_derecho_ti:"",
                  pdf_pago_derecho_ti:"",
                  estado_pago_derecho_ti:0,
                  cal_pago_derecho_ti:0,

                  evi_pago_integrante_jurado:0,
                  comentario_pago_integrante_jurado:"",
                  pdf_pago_integrante_jurado:"",
                  estado_pago_integrante_jurado:0,
                  cal_pago_integrante_jurado:0,

                  evi_acta_residencia:0,
                  comentario_acta_residencia:"",
                  pdf_acta_residencia:"",
                  estado_acta_residencia:0,
                  cal_acta_residencia:0,

                  evi_pago_concepto_autenticacion:0,
                  comentario_pago_concepto_autenticacion:"",
                  pdf_pago_concepto_autenticacion:"",
                  estado_pago_concepto_autenticacion:0,
                  cal_pago_concepto_autenticacion:0,

                  correo_electronico:"",
                  id_estado_enviado:0,


              },
              ingles:{
                  id_certificado_acreditacion:0,
                  pdf_certificado:"",
                  id_alumno:0,
                  estado_cert:0,
              },

              modal_validar_1:0,
              modal_validar_2:0,
              modal_validar_3:0,
              modal_validar_4:0,
              modal_validar_5:0,
              modal_validar_6:0,
              modal_validar_7:0,
              modal_validar_8:0,
              modal_validar_9:0,
              modal_validar_10:0,
              modal_validar_11:0,
              modal_validar_12:0,
              modal_validar_13:0,
              modal_validar_14:0,


              titulo_cons_adeudo:"",
              estado_guardar_cons_adeudo:false,
              modificar_constancia_adeudo:false,
              modal_cons_adeudo:0,
              modal_enviar_correcciones:0,
              guarda_envio_correccion:false,
              modal_enviar_aceptacion:0,

              file:'',





          }
      },
      methods: {
          //meetodo para mostrar tabla
          async Documentacion() {
              swal({
                  title:"",
                  text:"Cargando...",
                  buttons: false,
                  closeOnClickOutside: false,
                  timer: 5000,
                  //icon: "success"
              });
              //llamar datos al controlador
              const contar = await axios.get('/titulacion/estado_actual_fecha/{{$id_alumno}}');
              this.fecha_activa = contar.data;
              const respuestas = await axios.get('/ambiental/respuestas/');
              this.respuestas = respuestas.data;
              const verificacion_reg_doc = await axios.get('/titulacion/est_actual_doc_al/{{$id_alumno}}');
              this.est_actual_doc_al = verificacion_reg_doc.data;
              const verificacion_const_ing = await axios.get('/titulacion/veri_constancia_ingles/{{$id_alumno}}');
              this.veri_constancia_ingles = verificacion_const_ing.data;
              const veri_egel_al= await axios.get('/titulacion/veri_egel_al/{{$id_alumno}}');
              this.veri_egel = veri_egel_al.data;
              const veri_ante_2010= await axios.get('/titulacion/veri_ante_2010/{{$id_alumno}}');
              this.veri_anterior_10 = veri_ante_2010.data;



              if(this.veri_constancia_ingles == 2){
                  const certificado_ingles = await axios.get('/titulacion/status_certi_ingles/{{$id_alumno}}');
                  this.estado_certi_in = certificado_ingles.data;
                  this.ingles.id_certificado_acreditacion=this.estado_certi_in[0].id_certificado_acreditacion;
                  this.ingles.pdf_certificado=this.estado_certi_in[0].pdf_certificado;
                  this.ingles.id_alumno=this.estado_certi_in[0].id_alumno;
                  this.ingles.estado_cert=this.estado_certi_in[0].estado_cert;
              }
              if(this.est_actual_doc_al > 0){
                  const doc = await axios.get('/titulacion/documentacion_alumno/{{$id_alumno}}');
                  this.documentacion = doc.data;

                  this.docu.id_requisitos =this.documentacion[0].id_requisitos;
                  this.docu.id_alumno =this.documentacion[0].id_alumno;

                  this.docu.evi_acta_nac =this.documentacion[0].evi_acta_nac;
                  this.docu.comentario_acta_nac =this.documentacion[0].comentario_acta_nac;
                  this.docu.pdf_acta_nac =this.documentacion[0].pdf_acta_nac;
                  this.docu.estado_acta_nac =this.documentacion[0].estado_acta_nac;
                  this.docu.cal_acta_nac =this.documentacion[0].cal_acta_nac;

                  this.docu.evi_curp =this.documentacion[0].evi_curp;
                  this.docu.comentario_curp =this.documentacion[0].comentario_curp;
                  this.docu.pdf_curp =this.documentacion[0].pdf_curp;
                  this.docu.estado_curp =this.documentacion[0].estado_curp;
                  this.docu.cal_curp =this.documentacion[0].cal_curp;

                  this.docu.evi_certificado_prep =this.documentacion[0].evi_certificado_prep;
                  this.docu.comentario_certificado_prep =this.documentacion[0].comentario_certificado_prep;
                  this.docu.pdf_certificado_prep =this.documentacion[0].pdf_certificado_prep;
                  this.docu.estado_certificado_prep =this.documentacion[0].estado_certificado_prep;
                  this.docu.cal_certificado_prep =this.documentacion[0].cal_certificado_prep;

                  this.docu.evi_certificado_tesvb =this.documentacion[0].evi_certificado_tesvb;
                  this.docu.comentario_certificado_tesvb =this.documentacion[0].comentario_certificado_tesvb;
                  this.docu.pdf_certificado_tesvb =this.documentacion[0].pdf_certificado_tesvb;
                  this.docu.estado_certificado_tesvb =this.documentacion[0].estado_certificado_tesvb;
                  this.docu.cal_certificado_tesvb =this.documentacion[0].cal_certificado_tesvb;

                  this.docu.evi_constancia_ss =this.documentacion[0].evi_constancia_ss;
                  this.docu.comentario_constancia_ss =this.documentacion[0].comentario_constancia_ss ;
                  this.docu.pdf_constancia_ss =this.documentacion[0].pdf_constancia_ss;
                  this.docu.estado_constancia_ss =this.documentacion[0].estado_constancia_ss;
                  this.docu.cal_constancia_ss =this.documentacion[0].cal_constancia_ss;

                  this.docu.evi_certificado_acred_ingles =this.documentacion[0].evi_certificado_acred_ingles;
                  this.docu.comentario_certificado_acred_ingles =this.documentacion[0].comentario_certificado_acred_ingles ;
                  this.docu.pdf_certificado_acred_ingles =this.documentacion[0].pdf_certificado_acred_ingles;
                  this.docu.estado_certificado_acred_ingles =this.documentacion[0].estado_certificado_acred_ingles;
                  this.docu.cal_certificado_acred_ingles =this.documentacion[0].cal_certificado_acred_ingles;

                  this.docu.evi_reporte_result_egel =this.documentacion[0].evi_reporte_result_egel;
                  this.docu.comentario_reporte_result_egel =this.documentacion[0].comentario_reporte_result_egel ;
                  this.docu.pdf_reporte_result_egel =this.documentacion[0].pdf_reporte_result_egel;
                  this.docu.estado_reporte_result_egel =this.documentacion[0].estado_reporte_result_egel;
                  this.docu.cal_reporte_result_egel =this.documentacion[0].cal_reporte_result_egel;

                  this.docu.id_opcion_titulacion =this.documentacion[0].id_opcion_titulacion;

                  this.docu.evi_opcion_titulacion =this.documentacion[0].evi_opcion_titulacion;
                  this.docu.comentario_opcion_titulacion =this.documentacion[0].comentario_opcion_titulacion ;
                  this.docu.pdf_opcion_titulacion =this.documentacion[0].pdf_opcion_titulacion;
                  this.docu.estado_opcion_titulacion =this.documentacion[0].estado_opcion_titulacion;
                  this.docu.cal_opcion_titulacion =this.documentacion[0].cal_opcion_titulacion;

                  this.docu.evi_constancia_adeudo =this.documentacion[0].evi_constancia_adeudo;
                  this.docu.comentario_constancia_adeudo =this.documentacion[0].comentario_constancia_adeudo ;
                  this.docu.pdf_constancia_adeudo =this.documentacion[0].pdf_constancia_adeudo;
                  this.docu.estado_constancia_adeudo =this.documentacion[0].estado_constancia_adeudo;

                  this.docu.evi_pago_titulo =this.documentacion[0].evi_pago_titulo;
                  this.docu.comentario_pago_titulo =this.documentacion[0].comentario_pago_titulo ;
                  this.docu.pdf_pago_titulo =this.documentacion[0].pdf_pago_titulo;
                  this.docu.estado_pago_titulo =this.documentacion[0].estado_pago_titulo;
                  this.docu.cal_pago_titulo =this.documentacion[0].cal_pago_titulo;

                  this.docu.evi_pago_contancia =this.documentacion[0].evi_pago_contancia;
                  this.docu.comentario_pago_contancia =this.documentacion[0].comentario_pago_contancia ;
                  this.docu.pdf_pago_contancia =this.documentacion[0].pdf_pago_contancia;
                  this.docu.estado_pago_contancia =this.documentacion[0].estado_pago_contancia;
                  this.docu.cal_pago_contancia =this.documentacion[0].cal_pago_contancia;

                  this.docu.evi_pago_derecho_ti =this.documentacion[0].evi_pago_derecho_ti;
                  this.docu.comentario_pago_derecho_ti =this.documentacion[0].comentario_pago_derecho_ti ;
                  this.docu.pdf_pago_derecho_ti =this.documentacion[0].pdf_pago_derecho_ti;
                  this.docu.estado_pago_derecho_ti =this.documentacion[0].estado_pago_derecho_ti;
                  this.docu.cal_pago_derecho_ti =this.documentacion[0].cal_pago_derecho_ti;

                  this.docu.evi_pago_integrante_jurado =this.documentacion[0].evi_pago_integrante_jurado;
                  this.docu.comentario_pago_integrante_jurado =this.documentacion[0].comentario_pago_integrante_jurado ;
                  this.docu.pdf_pago_integrante_jurado =this.documentacion[0].pdf_pago_integrante_jurado;
                  this.docu.estado_pago_integrante_jurado =this.documentacion[0].estado_pago_integrante_jurado;
                  this.docu.cal_pago_integrante_jurado =this.documentacion[0].cal_pago_integrante_jurado;

                  this.docu.evi_acta_residencia =this.documentacion[0].evi_acta_residencia;
                  this.docu.comentario_acta_residencia =this.documentacion[0].comentario_acta_residencia ;
                  this.docu.pdf_acta_residencia =this.documentacion[0].pdf_acta_residencia;
                  this.docu.estado_acta_residencia =this.documentacion[0].estado_acta_residencia;
                  this.docu.cal_acta_residencia =this.documentacion[0].cal_acta_residencia;

                  this.docu.evi_pago_concepto_autenticacion =this.documentacion[0].evi_pago_concepto_autenticacion;
                  this.docu.comentario_pago_concepto_autenticacion =this.documentacion[0].comentario_pago_concepto_autenticacion ;
                  this.docu.pdf_pago_concepto_autenticacion =this.documentacion[0].pdf_pago_concepto_autenticacion;
                  this.docu.estado_pago_concepto_autenticacion =this.documentacion[0].estado_pago_concepto_autenticacion;
                  this.docu.cal_pago_concepto_autenticacion =this.documentacion[0].cal_pago_concepto_autenticacion;



                  this.docu.correo_electronico =this.documentacion[0].correo_electronico;
                  this.docu.id_estado_enviado =this.documentacion[0].id_estado_enviado;



              }
              const opciones_titulacion = await axios.get('/titulacion/opciones_titulacion/{{ $id_alumno }}/');
              this.opciones_titulacion = opciones_titulacion.data;
          },
          async abrirModal_constancia_adeudo(){
              this.estado_guardar_cons_adeudo=false;
              this.modal_cons_adeudo=1;
              if(this.modificar_constancia_adeudo == true){
                  this.titulo_cons_adeudo="Modificar Documentación";
              }else{
                  this.titulo_cons_adeudo="Registrar Documentación"
              }
          },
          async cerrarModal_cons_adeudo(){
              this.modal_cons_adeudo=0;
          },
          variable_doc_1(event){
              this.file = event.target.files[0];
          },
          async guardar_doc_cons_adeudo(){
              let data = new FormData();


              let file=this.file;
              if( file == ''){
                  swal({
                      position: "top",
                      type: "warning",
                      title: "El campo se encuentra  vacío.",
                      showConfirmButton: false,
                      timer: 3500
                  });
              }else {

                  this.estado_guardar_cons_adeudo = true;
                  data.append('name', 'my-file')
                  data.append('file', file)

                  let config = {
                      header: {
                          'Content-Type': 'multipart/form-data'
                      }
                  }
                  const resultado= await axios.post('/titulacion/registrar_constancia_adeudo/'+this.docu.id_requisitos, data, config);

                  this.cerrarModal_cons_adeudo();
                  this.Documentacion();
                  swal({
                      position: "top",
                      type: "success",
                      title: "Registro exitoso",
                      showConfirmButton: false,
                      timer: 3500
                  });

              }
          },

          async guardar_resp_acta(){
            if(this.docu.estado_acta_nac == 1)
            {
                  this.modal_validar_1=1;
            }
              if(this.docu.estado_acta_nac == 2)
              {
                  if(this.docu.comentario_acta_nac == ""){
                      swal({
                          position: "top",
                          type: "warning",
                          title: "El campo del comentario se encuentra  vacío.",
                          showConfirmButton: false,
                          timer: 3500});
                  }else{
                      this.modal_validar_1=1;
                  }
              }
          },
          async guardar_resp_curp(){
              if(this.docu.estado_curp == 1)
              {
                  this.modal_validar_2=1;
              }
              if(this.docu.estado_curp == 2)
              {
                  if(this.docu.comentario_curp == ""){
                      swal({
                          position: "top",
                          type: "warning",
                          title: "El campo del comentario se encuentra  vacío.",
                          showConfirmButton: false,
                          timer: 3500});
                  }else{
                      this.modal_validar_2=1;
                  }
              }
          },
          async guardar_resp_certificado_prepa(){
              if(this.docu.estado_certificado_prep == 1)
              {
                  this.modal_validar_3=1;
              }
              if(this.docu.estado_certificado_prep == 2)
              {
                  if(this.docu.comentario_certificado_prep == ""){
                      swal({
                          position: "top",
                          type: "warning",
                          title: "El campo del comentario se encuentra  vacío.",
                          showConfirmButton: false,
                          timer: 3500});
                  }else{
                      this.modal_validar_3=1;
                  }
              }

          },
          async guardar_resp_certificado_tesvb(){
              if(this.docu.estado_certificado_tesvb == 1)
              {
                  this.modal_validar_4=1;
              }
              if(this.docu.estado_certificado_tesvb == 2)
              {
                  if(this.docu.comentario_certificado_tesvb == ""){
                      swal({
                          position: "top",
                          type: "warning",
                          title: "El campo del comentario se encuentra  vacío.",
                          showConfirmButton: false,
                          timer: 3500});
                  }else{
                      this.modal_validar_4=1;
                  }
              }
          },
          async guardar_resp_constancia_ss(){
              if(this.docu.estado_constancia_ss == 1)
              {
                  this.modal_validar_5=1;
              }
              if(this.docu.estado_constancia_ss == 2)
              {
                  if(this.docu.comentario_constancia_ss == ""){
                      swal({
                          position: "top",
                          type: "warning",
                          title: "El campo del comentario se encuentra  vacío.",
                          showConfirmButton: false,
                          timer: 3500});
                  }else{
                      this.modal_validar_5=1;
                  }
              }
          },
          async guardar_resp_certificado_acred_ingles(){
              if(this.docu.estado_certificado_acred_ingles == 1)
              {
                  this.modal_validar_6=1;
              }
              if(this.docu.estado_certificado_acred_ingles == 2)
              {
                  if(this.docu.comentario_certificado_acred_ingles == ""){
                      swal({
                          position: "top",
                          type: "warning",
                          title: "El campo del comentario se encuentra  vacío.",
                          showConfirmButton: false,
                          timer: 3500});
                  }else{
                      this.modal_validar_6=1;
                  }
              }
          },
          async guardar_resp_reporte_result_egel(){
              if(this.docu.estado_reporte_result_egel == 1)
              {
                  this.modal_validar_8=1;
              }
              if(this.docu.estado_reporte_result_egel == 2)
              {
                  if(this.docu.comentario_reporte_result_egel == ""){
                      swal({
                          position: "top",
                          type: "warning",
                          title: "El campo del comentario se encuentra  vacío.",
                          showConfirmButton: false,
                          timer: 3500});
                  }else{
                      this.modal_validar_8=1;
                  }
              }
          },
          async guardar_resp_opcion_titulacion(){
              if(this.docu.estado_opcion_titulacion == 1)
              {
                  this.modal_validar_7=1;
              }
              if(this.docu.estado_opcion_titulacion == 2)
              {
                  if(this.docu.comentario_opcion_titulacion == ""){
                      swal({
                          position: "top",
                          type: "warning",
                          title: "El campo del comentario se encuentra  vacío.",
                          showConfirmButton: false,
                          timer: 3500});
                  }else{
                      this.modal_validar_7=1;
                  }
              }
          },
          async guardar_resp_pago_titulo(){
              if(this.docu.estado_pago_titulo == 1)
              {
                  this.modal_validar_9=1;
              }
              if(this.docu.estado_pago_titulo == 2)
              {
                  if(this.docu.comentario_pago_titulo == ""){
                      swal({
                          position: "top",
                          type: "warning",
                          title: "El campo del comentario se encuentra  vacío.",
                          showConfirmButton: false,
                          timer: 3500});
                  }else{
                      this.modal_validar_9=1;
                  }
              }
          },
          async guardar_resp_pago_contancia(){
              if(this.docu.estado_pago_contancia == 1)
              {
                  this.modal_validar_10=1;
              }
              if(this.docu.estado_pago_contancia == 2)
              {
                  if(this.docu.comentario_pago_contancia == ""){
                      swal({
                          position: "top",
                          type: "warning",
                          title: "El campo del comentario se encuentra  vacío.",
                          showConfirmButton: false,
                          timer: 3500});
                  }else{
                      this.modal_validar_10=1;
                  }
              }
          },
          async guardar_resp_pago_derecho_ti(){
              if(this.docu.estado_pago_derecho_ti == 1)
              {
                  this.modal_validar_11=1;
              }
              if(this.docu.estado_pago_derecho_ti == 2)
              {
                  if(this.docu.comentario_pago_derecho_ti == ""){
                      swal({
                          position: "top",
                          type: "warning",
                          title: "El campo del comentario se encuentra  vacío.",
                          showConfirmButton: false,
                          timer: 3500});
                  }else{
                      this.modal_validar_11=1;
                  }
              }
          },
          async guardar_resp_integrante_jurado(){
              if(this.docu.estado_pago_integrante_jurado == 1)
              {
                  this.modal_validar_12=1;
              }
              if(this.docu.estado_pago_integrante_jurado == 2)
              {
                  if(this.docu.comentario_pago_integrante_jurado == ""){
                      swal({
                          position: "top",
                          type: "warning",
                          title: "El campo del comentario se encuentra  vacío.",
                          showConfirmButton: false,
                          timer: 3500});
                  }else{
                      this.modal_validar_12=1;
                  }
              }
          },
          async guardar_resp_acta_residencia(){
              if(this.docu.estado_acta_residencia == 1)
              {
                  this.modal_validar_13=1;
              }
              if(this.docu.estado_acta_residencia == 2)
              {
                  if(this.docu.comentario_acta_residencia == ""){
                      swal({
                          position: "top",
                          type: "warning",
                          title: "El campo del comentario se encuentra  vacío.",
                          showConfirmButton: false,
                          timer: 3500});
                  }else{
                      this.modal_validar_13=1;
                  }
              }
          },
          async guardar_pago_concepto_autenticacion(){
              if(this.docu.estado_pago_concepto_autenticacion == 1)
              {
                  this.modal_validar_14=1;
              }
              if(this.docu.estado_pago_concepto_autenticacion == 2)
              {
                  if(this.docu.comentario_pago_concepto_autenticacion == ""){
                      swal({
                          position: "top",
                          type: "warning",
                          title: "El campo del comentario se encuentra  vacío.",
                          showConfirmButton: false,
                          timer: 3500});
                  }else{
                      this.modal_validar_14=1;
                  }
              }
          },

          async cerrarModal_validar_1()
          {
              this.modal_validar_1=0;
          },
          async cerrarModal_validar_2()
          {
              this.modal_validar_2=0;
          },
          async cerrarModal_validar_3()
          {
              this.modal_validar_3=0;
          },
          async cerrarModal_validar_4()
          {
              this.modal_validar_4=0;
          },
          async cerrarModal_validar_5()
          {
              this.modal_validar_5=0;
          },
          async cerrarModal_validar_6()
          {
              this.modal_validar_6=0;
          },
          async cerrarModal_validar_7()
          {
              this.modal_validar_7=0;
          },
          async cerrarModal_validar_8()
          {
              this.modal_validar_8=0;
          },
          async cerrarModal_validar_9()
          {
              this.modal_validar_9=0;
          },
          async cerrarModal_validar_10()
          {
              this.modal_validar_10=0;
          },
          async cerrarModal_validar_11()
          {
              this.modal_validar_11=0;
          },
          async cerrarModal_validar_12()
          {
              this.modal_validar_12=0;
          },
          async cerrarModal_validar_13()
          {
              this.modal_validar_13=0;
          },
          async cerrarModal_validar_14()
          {
              this.modal_validar_14=0;
          },
          async guardar_validar_1(){
              const resultado=await axios.post('/titulacion/guardar_validar_1/'+this.docu.id_requisitos,this.docu);
              this.Documentacion();
              this.cerrarModal_validar_1();
              swal({
                  position: "top",
                  type: "success",
                  title: "Registro exitoso",
                  showConfirmButton: false,
                  timer: 3500
              });
          },
          async guardar_validar_2(){
              const resultado=await axios.post('/titulacion/guardar_validar_2/'+this.docu.id_requisitos,this.docu);
              this.Documentacion();
              this.cerrarModal_validar_2();
              swal({
                  position: "top",
                  type: "success",
                  title: "Registro exitoso",
                  showConfirmButton: false,
                  timer: 3500
              });
          },
          async guardar_validar_3(){
              const resultado=await axios.post('/titulacion/guardar_validar_3/'+this.docu.id_requisitos,this.docu);
              this.Documentacion();
              this.cerrarModal_validar_3();
              swal({
                  position: "top",
                  type: "success",
                  title: "Registro exitoso",
                  showConfirmButton: false,
                  timer: 3500
              });
          },
          async guardar_validar_4(){
              const resultado=await axios.post('/titulacion/guardar_validar_4/'+this.docu.id_requisitos,this.docu);
              this.Documentacion();
              this.cerrarModal_validar_4();
              swal({
                  position: "top",
                  type: "success",
                  title: "Registro exitoso",
                  showConfirmButton: false,
                  timer: 3500
              });
          },
          async guardar_validar_5(){
              const resultado=await axios.post('/titulacion/guardar_validar_5/'+this.docu.id_requisitos,this.docu);
              this.Documentacion();
              this.cerrarModal_validar_5();
              swal({
                  position: "top",
                  type: "success",
                  title: "Registro exitoso",
                  showConfirmButton: false,
                  timer: 3500
              });
          },
          async guardar_validar_6(){
              const resultado=await axios.post('/titulacion/guardar_validar_6/'+this.docu.id_requisitos,this.docu);
              this.Documentacion();
              this.cerrarModal_validar_6();
              swal({
                  position: "top",
                  type: "success",
                  title: "Registro exitoso",
                  showConfirmButton: false,
                  timer: 3500
              });
          },
          async guardar_validar_7(){
              const resultado=await axios.post('/titulacion/guardar_validar_7/'+this.docu.id_requisitos,this.docu);
              this.Documentacion();
              this.cerrarModal_validar_7();
              swal({
                  position: "top",
                  type: "success",
                  title: "Registro exitoso",
                  showConfirmButton: false,
                  timer: 3500
              });
          },
          async guardar_validar_8(){
              const resultado=await axios.post('/titulacion/guardar_validar_8/'+this.docu.id_requisitos,this.docu);
              this.Documentacion();
              this.cerrarModal_validar_8();
              swal({
                  position: "top",
                  type: "success",
                  title: "Registro exitoso",
                  showConfirmButton: false,
                  timer: 3500
              });
          },
          async guardar_validar_9(){
              const resultado=await axios.post('/titulacion/guardar_validar_9/'+this.docu.id_requisitos,this.docu);
              this.Documentacion();
              this.cerrarModal_validar_9();
              swal({
                  position: "top",
                  type: "success",
                  title: "Registro exitoso",
                  showConfirmButton: false,
                  timer: 3500
              });
          },
          async guardar_validar_10(){
              const resultado=await axios.post('/titulacion/guardar_validar_10/'+this.docu.id_requisitos,this.docu);
              this.Documentacion();
              this.cerrarModal_validar_10();
              swal({
                  position: "top",
                  type: "success",
                  title: "Registro exitoso",
                  showConfirmButton: false,
                  timer: 3500
              });
          },
          async guardar_validar_11(){
              const resultado=await axios.post('/titulacion/guardar_validar_11/'+this.docu.id_requisitos,this.docu);
              this.Documentacion();
              this.cerrarModal_validar_11();
              swal({
                  position: "top",
                  type: "success",
                  title: "Registro exitoso",
                  showConfirmButton: false,
                  timer: 3500
              });
          },
          async guardar_validar_12(){
              const resultado=await axios.post('/titulacion/guardar_validar_12/'+this.docu.id_requisitos,this.docu);
              this.Documentacion();
              this.cerrarModal_validar_12();
              swal({
                  position: "top",
                  type: "success",
                  title: "Registro exitoso",
                  showConfirmButton: false,
                  timer: 3500
              });
          },
          async guardar_validar_13(){
              const resultado=await axios.post('/titulacion/guardar_validar_13/'+this.docu.id_requisitos,this.docu);
              this.Documentacion();
              this.cerrarModal_validar_13();
              swal({
                  position: "top",
                  type: "success",
                  title: "Registro exitoso",
                  showConfirmButton: false,
                  timer: 3500
              });
          },
          async guardar_validar_14(){
              const resultado=await axios.post('/titulacion/guardar_validar_14/'+this.docu.id_requisitos,this.docu);
              this.Documentacion();
              this.cerrarModal_validar_14();
              swal({
                  position: "top",
                  type: "success",
                  title: "Registro exitoso",
                  showConfirmButton: false,
                  timer: 3500
              });
          },
          async abrirModalenviar_modificaciones(){
              this.modal_enviar_correcciones=1;
              this.guarda_envio_correccion=false;
          },
          async cerrarModalenviar_correcciones(){
              this.modal_enviar_correcciones=0;
          },
          async Enviar_correcciones(){
              this.guarda_envio_correccion=true;
                  window.location.href = '/requisitos/enviar_correcciones_alumno/'+this.docu.id_requisitos;
                  swal({
                      position: "top",
                      type: "success",
                      title: "Envio exitoso",
                      showConfirmButton: false,
                      timer: 3500
                  });

          },
          async abrirModalautorizar_Doc(){
              this.modal_enviar_aceptacion=1;
              this.guarda_envio_correccion=false;

          },
          async cerrarModalenviar_autorizacion(){
              this.modal_enviar_aceptacion=0;
          },
          async Enviar_aceptacion(){
              this.cerrarModalenviar_autorizacion();
              this.guarda_envio_correccion=true;
              window.location.href = '/requisitos/enviar_autorizacion_documentacion/'+this.docu.id_requisitos;
              swal({
                  position: "top",
                  type: "success",
                  title: "Autorización exitosa",
                  showConfirmButton: false,
                  timer: 3500
              });
          }



      },
      //funciones para cuando se cargue la vista
      async created(){
          //disparar la funcion
          this.Documentacion();

      },

  })
</script>
<style>
  .mostrar{
      display: list-item;
      opacity: 1;
      background: rgba(44,38,75,0.849);
  }
</style>

@endsection
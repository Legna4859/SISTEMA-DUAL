@extends('layouts.app')
@section('title', 'Ambiental')
@section('content')

    <main class="col-md-12">


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Enviar documentación del procedimiento del Periodo: {{ $periodo[0]->nombre_periodo_amb }} <br>
                        {{ $procedimiento[0]->nom_procedimiento }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <div id="envio_doc">
            <div class="row">
                <div class="col-md-10 col-xs-10 col-md-offset-1">
                    <p>
                        <span class="glyphicon glyphicon-arrow-right"></span>
                        <a href="{{url("/ambiental/enviar_documentacion")}}">Procedimientos</a>
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span>Documentación del procedimiento </span>

                    </p>
                    <br>
                </div>
            </div>
            <template v-if="activo == 0 ">

                <div class="row">
                    <div  class="col-md-10 col-lg-offset-1">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">No se te ha registrado que documentación entregaras a la subdirección de Vinculación.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-if="activo == 1 ">
                <template v-if="status_documentacion == 2 ">
                <div class="row">
                    <div  class="col-md-10 col-lg-offset-1">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">No se te solicito documentación.</h3>
                            </div>
                        </div>
                    </div>
                </div>
                </template>

                <div class="row">
                    <div  class="col-md-10 col-lg-offset-1">
                        <table id="tabla_envio" class="table table-bordered table-resposive">
                            <template v-if="status_documentacion != 2 ">
                            <thead>
                            <tr>

                                <th>Módulo</th>
                                <th>Requerimiento</th>
                                <th>Requiere evidencia</th>
                                <th>Acción</th>
                                <th>Mostrar evidencia</th>
                            </tr>
                            </thead>
                            </template>
                            <tbody>
                            <template v-if="documentacion[0].solic_estado_acc_m1  == 2">
                            <tr>
                            <td>Modulo 1</td>
                            <td>a) El estado de las acciones de las revisiones por la dirección previas.</td>
                                <td>SI </td>
                                <td v-if="documentacion[0].evi_estado_acc_m1  == 0"> <button  class="btn btn-primary btn-sm" v-on:click="modificarse_pri=true , abrirModal_pri();" >Agregar</button></td>
                                <td v-if="documentacion[0].evi_estado_acc_m1 == 0"></td>

                                <td v-if="documentacion[0].evi_estado_acc_m1 == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_pri=true , abrirModal_pri();" >Modificar</button></td>
                                  <td v-if="documentacion[0].evi_estado_acc_m1 == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_estado_acc_m1  }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                            </tr>
                            </template>
                            <template v-if="documentacion[0].solic_cuestion_ambas_per_m2 == 2 ||
                             documentacion[0].solic_necesidades_espectativas_m2 == 2 ||
                             documentacion[0].solic_aspecto_ambiental_m2 == 2 ||
                             documentacion[0].solic_riesgo_oportu_m2 == 2">
                            <tr>

                                <td>Modulo 2</td>
                                <td colspan="4">b)Los cambios en </td>
                            </tr>
                            </template>
                            <template v-if="documentacion[0].solic_cuestion_ambas_per_m2  == 2">
                            <tr>

                                <td></td>
                                <td>1) Las cuestiones externas e internas que sean pertinentes al sistema  de gestión ambiental.</td>
                                <td v-if="documentacion[0].evi_cuestion_ambas_per_m2  == 0">SI  O NO</td>
                                <td v-if="documentacion[0].evi_cuestion_ambas_per_m2  == 1">SI</td>
                                <td v-if="documentacion[0].evi_cuestion_ambas_per_m2  == 2">NO</td>
                                <td v-if="documentacion[0].evi_cuestion_ambas_per_m2  == 0"> <button  class="btn btn-primary btn-sm" v-on:click="modificarse_segundo=false , abrirModal_cuestion_ambas_per_m2(documentacion);" >Agregar</button></td>
                                <td v-if="documentacion[0].evi_cuestion_ambas_per_m2  == 0"></td>
                                  <td v-if="documentacion[0].evi_cuestion_ambas_per_m2  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_segundo=true , abrirModal_cuestion_ambas_per_m2(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_cuestion_ambas_per_m2  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_cuestion_ambas_per_m2   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                                <td v-if="documentacion[0].evi_cuestion_ambas_per_m2  == 2"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_segundo=true , abrirModal_cuestion_ambas_per_m2(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_cuestion_ambas_per_m2  == 2"></td>
                            </tr>
                            </template>
                            <template v-if="documentacion[0].solic_necesidades_espectativas_m2  == 2">
                            <tr>

                                <td></td>
                                <td>2) Las necesidades y expectativas de las partes interesadas incluido los requisitos legales y otros requisitos.</td>
                                <td v-if="documentacion[0].evi_necesidades_espectativas_m2  == 0">SI  O NO</td>
                                <td v-if="documentacion[0].evi_necesidades_espectativas_m2  == 1">SI</td>
                                <td v-if="documentacion[0].evi_necesidades_espectativas_m2  == 2">NO</td>
                                <td v-if="documentacion[0].evi_necesidades_espectativas_m2  == 0"> <button  class="btn btn-primary btn-sm" v-on:click="modificarse_tercero=false , abrirModal_necesidades_espectativas_m2(documentacion);" >Agregar</button></td>
                                <td v-if="documentacion[0].evi_necesidades_espectativas_m2  == 0"></td>
                                <td v-if="documentacion[0].evi_necesidades_espectativas_m2  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_tercero=true , abrirModal_necesidades_espectativas_m2(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_necesidades_espectativas_m2  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_necesidades_espectativas_m2   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                                <td v-if="documentacion[0].evi_necesidades_espectativas_m2  == 2"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_tercero=true , abrirModal_necesidades_espectativas_m2(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_necesidades_espectativas_m2  == 2"></td>
                            </tr>
                            </template>
                            <template v-if="documentacion[0].solic_aspecto_ambiental_m2  == 2">

                            <tr>

                                <td></td>
                                <td>3) Sus  aspectos ambientales significativos.</td>
                                <td v-if="documentacion[0].evi_aspecto_ambiental_m2  == 0">SI</td>
                                <td v-if="documentacion[0].evi_aspecto_ambiental_m2  == 1">SI</td>
                                <td v-if="documentacion[0].evi_aspecto_ambiental_m2  == 0"> <button  class="btn btn-primary btn-sm" v-on:click="modificarse_cuarto=false , abrirModal_aspecto_ambiental_m2(documentacion);" >Agregar</button></td>
                                <td v-if="documentacion[0].evi_aspecto_ambiental_m2  == 0"></td>
                                <td v-if="documentacion[0].evi_aspecto_ambiental_m2  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_cuarto=true , abrirModal_aspecto_ambiental_m2(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_aspecto_ambiental_m2  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_aspecto_ambiental_m2   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                            </tr>
                            </template>
                            <template v-if="documentacion[0].solic_riesgo_oportu_m2  == 2">

                            <tr>

                                <td></td>
                                <td>4) Los riesgos y oportunidades.</td>
                                <td v-if="documentacion[0].evi_riesgo_oportu_m2  == 0">SI</td>
                                <td v-if="documentacion[0].evi_riesgo_oportu_m2  == 1">SI</td>
                                <td v-if="documentacion[0].evi_riesgo_oportu_m2  == 0"> <button  class="btn btn-primary btn-sm" v-on:click="modificarse_quinto=false , abrirModal_riesgo_oportu_m2(documentacion);" >Agregar</button></td>
                                <td v-if="documentacion[0].evi_riesgo_oportu_m2  == 0"></td>
                                <td v-if="documentacion[0].evi_riesgo_oportu_m2  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_quinto=true , abrirModal_riesgo_oportu_m2(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_riesgo_oportu_m2  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_riesgo_oportu_m2   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                            </tr>
                            </template>
                            <template v-if="documentacion[0].solic_grado_objetivo_m3  == 2 ||
                            documentacion[0].solic_programa_gestion_m3 == 2
                            ">
                            <tr>

                                <td>Modulo 3</td>
                                <td colspan="4">c) El grado en el que se han logrado los objetivos ambientales.</td>
                            </tr>
                            </template>
                            <template v-if="documentacion[0].solic_grado_objetivo_m3  == 2">
                            <tr>

                                <td></td>
                                <td>1.- Objetivos Ambientales del S. G. A.</td>
                                <td v-if="documentacion[0].evi_grado_objetivo_m3  == 0">SI</td>
                                <td v-if="documentacion[0].evi_grado_objetivo_m3  == 1">SI</td>
                                <td v-if="documentacion[0].evi_grado_objetivo_m3  == 0"> <button  class="btn btn-primary btn-sm" v-on:click="modificarse_sexto=false , abrirModal_grado_objetivo_m3(documentacion);" >Agregar</button></td>
                                <td v-if="documentacion[0].evi_grado_objetivo_m3  == 0"></td>
                                <td v-if="documentacion[0].evi_grado_objetivo_m3  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_sexto=true , abrirModal_grado_objetivo_m3(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_grado_objetivo_m3  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_grado_objetivo_m3    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                            </tr>
                            </template>
                            <template v-if="documentacion[0].solic_programa_gestion_m3  == 2">
                            <tr>

                                <td></td>
                                <td>2.-Programa de Gestión Ambiental.</td>
                                <td v-if="documentacion[0].evi_programa_gestion_m3  == 0">SI</td>
                                <td v-if="documentacion[0].evi_programa_gestion_m3  == 1">SI</td>
                                <td v-if="documentacion[0].evi_programa_gestion_m3  == 0"> <button  class="btn btn-primary btn-sm" v-on:click="modificarse_septimo=false , abrirModal_programa_gestion_m3(documentacion);" >Agregar</button></td>
                                <td v-if="documentacion[0].evi_programa_gestion_m3  == 0"></td>
                                <td v-if="documentacion[0].evi_programa_gestion_m3  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_septimo=true , abrirModal_programa_gestion_m3(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_programa_gestion_m3  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_programa_gestion_m3    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                            </tr>
                            </template>
                            <template v-if="documentacion[0].solic_noconformid_correctivas_m4  == 2 ||
                            documentacion[0].solic_resu_seg_med_m4  == 2 ||
                             documentacion[0].solic_cumplimiento_req_m4  == 2 ||
                              documentacion[0].solic_resultado_audi_m4  == 2
                             ">
                            <tr>

                                <td>Modulo 4</td>
                                <td colspan="4">d) La información sobre el desempeño ambiental de la organización , incluidas las tendencias relativas a:</td>
                            </tr>
                            </template>
                            <template v-if="documentacion[0].solic_noconformid_correctivas_m4  == 2 ">
                            <tr>

                                <td></td>
                                <td>1) No conformidades y acciones correctivas.</td>
                                <td v-if="documentacion[0].evi_noconformid_correctivas_m4  == 0">SI</td>
                                <td v-if="documentacion[0].evi_noconformid_correctivas_m4  == 1">SI</td>
                                <td v-if="documentacion[0].evi_noconformid_correctivas_m4  == 0"> <button  class="btn btn-primary btn-sm" v-on:click="modificarse_octavo=false , abrirModal_noconformid_correctivas_m4(documentacion);" >Agregar</button></td>
                                <td v-if="documentacion[0].evi_noconformid_correctivas_m4  == 0"></td>
                                <td v-if="documentacion[0].evi_noconformid_correctivas_m4  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_octavo=true , abrirModal_noconformid_correctivas_m4(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_noconformid_correctivas_m4  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_noconformid_correctivas_m4    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                            </tr>
                            </template>
                            <template v-if="documentacion[0].solic_resu_seg_med_m4  == 2 ">
                            <tr>

                                <td></td>
                                <td>2) Resultados de seguimiento y medición.</td>
                                <td v-if="documentacion[0].evi_resu_seg_med_m4   == 0">SI</td>
                                <td v-if="documentacion[0].evi_resu_seg_med_m4   == 1">SI</td>
                                <td v-if="documentacion[0].evi_resu_seg_med_m4   == 0"> <button  class="btn btn-primary btn-sm" v-on:click="modificarse_noveno=false , abrirModal_resu_seg_med_m4(documentacion);" >Agregar</button></td>
                                <td v-if="documentacion[0].evi_resu_seg_med_m4   == 0"></td>
                                <td v-if="documentacion[0].evi_resu_seg_med_m4   == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_noveno=true , abrirModal_resu_seg_med_m4(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_resu_seg_med_m4   == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_resu_seg_med_m4    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                            </tr>
                            </template>
                            <template v-if="documentacion[0].solic_cumplimiento_req_m4  == 2 ">
                            <tr>

                                <td></td>
                                <td>3) Cumplimiento de los requisitos legales y otros requisitos.</td>
                                <td v-if="documentacion[0].evi_cumplimiento_req_m4   == 0">SI</td>
                                <td v-if="documentacion[0].evi_cumplimiento_req_m4   == 1">SI</td>
                                <td v-if="documentacion[0].evi_cumplimiento_req_m4   == 0"> <button  class="btn btn-primary btn-sm" v-on:click="modificarse_decimo=false , abrirModal_cumplimiento_req_m4(documentacion);" >Agregar</button></td>
                                <td v-if="documentacion[0].evi_cumplimiento_req_m4   == 0"></td>
                                <td v-if="documentacion[0].evi_cumplimiento_req_m4   == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_decimo=true , abrirModal_cumplimiento_req_m4(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_cumplimiento_req_m4   == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_cumplimiento_req_m4    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                            </tr>
                            </template>
                            <template v-if="documentacion[0].solic_resultado_audi_m4  == 2">
                            <tr>

                                <td></td>
                                <td>4) Resultado de las auditorias.</td>
                                <td v-if="documentacion[0].evi_resultado_audi_m4   == 0">SI</td>
                                <td v-if="documentacion[0].evi_resultado_audi_m4   == 1">SI</td>
                                <td v-if="documentacion[0].evi_resultado_audi_m4   == 0"> <button  class="btn btn-primary btn-sm" v-on:click="modificarse_onceavo=false , abrirModal_resultado_audi_m4(documentacion);" >Agregar</button></td>
                                <td v-if="documentacion[0].evi_resultado_audi_m4   == 0"></td>
                                <td v-if="documentacion[0].evi_resultado_audi_m4   == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_onceavo=true , abrirModal_resultado_audi_m4(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_resultado_audi_m4   == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_resultado_audi_m4    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                            </tr>
                            </template>
                            <template v-if="documentacion[0].solic_adecuacion_recurso_m5  == 2">
                            <tr>

                                <td>Modulo 5</td>
                                <td>e) Adecuación de los recursos.</td>

                                <td v-if="documentacion[0].evi_adecuacion_recurso_m5  == 0">SI  O NO</td>
                                <td v-if="documentacion[0].evi_adecuacion_recurso_m5  == 1">SI</td>
                                <td v-if="documentacion[0].evi_adecuacion_recurso_m5  == 2">NO</td>
                                <td v-if="documentacion[0].evi_adecuacion_recurso_m5  == 0"> <button  class="btn btn-primary btn-sm" v-on:click="modificarse_doceavo=false , abrirModal_adecuacion_recurso_m5(documentacion);" >Agregar</button></td>
                                <td v-if="documentacion[0].evi_adecuacion_recurso_m5  == 0"></td>
                                <td v-if="documentacion[0].evi_adecuacion_recurso_m5  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_doceavo=true , abrirModal_adecuacion_recurso_m5(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_adecuacion_recurso_m5  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_adecuacion_recurso_m5   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                                <td v-if="documentacion[0].evi_adecuacion_recurso_m5  == 2"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_doceavo=true , abrirModal_adecuacion_recurso_m5(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_adecuacion_recurso_m5  == 2"></td>
                            </tr>
                            </template>
                            <template v-if="documentacion[0].solic_comunicacion_pertinente_m6  == 2">
                            <tr>

                                <td>Modulo 6</td>
                                <td>f) Las comunciaciones pertinentes de las partes interesadas, incluidas las quejas.</td>
                                <td v-if="documentacion[0].evi_comunicacion_pertinente_m6   == 0">SI</td>
                                <td v-if="documentacion[0].evi_comunicacion_pertinente_m6   == 1">SI</td>
                                <td v-if="documentacion[0].evi_comunicacion_pertinente_m6   == 0"> <button  class="btn btn-primary btn-sm" v-on:click="modificarse_terceavo=false , abrirModal_comunicacion_pertinente_m6(documentacion);" >Agregar</button></td>
                                <td v-if="documentacion[0].evi_comunicacion_pertinente_m6   == 0"></td>
                                <td v-if="documentacion[0].evi_comunicacion_pertinente_m6   == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_terceavo=true , abrirModal_comunicacion_pertinente_m6(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_comunicacion_pertinente_m6   == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_comunicacion_pertinente_m6    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                            </tr>
                            </template>
                            <template v-if="documentacion[0].solic_oportunidades_mejora_m7  == 2">
                            <tr>

                                <td>Modulo 7</td>
                                <td>g) Las oportunidades de mejora continua.</td>

                                <td v-if="documentacion[0].evi_oportunidades_mejora_m7  == 0">SI  O NO</td>
                                <td v-if="documentacion[0].evi_oportunidades_mejora_m7  == 1">SI</td>
                                <td v-if="documentacion[0].evi_oportunidades_mejora_m7  == 2">NO</td>
                                <td v-if="documentacion[0].evi_oportunidades_mejora_m7  == 0"> <button  class="btn btn-primary btn-sm" v-on:click="modificarse_cuartoceavo=false , abrirModal_oportunidades_mejora_m7(documentacion);" >Agregar</button></td>
                                <td v-if="documentacion[0].evi_oportunidades_mejora_m7  == 0"></td>
                                <td v-if="documentacion[0].evi_oportunidades_mejora_m7  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_cuartoceavo=true , abrirModal_oportunidades_mejora_m7(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_oportunidades_mejora_m7  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_oportunidades_mejora_m7   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                                <td v-if="documentacion[0].evi_oportunidades_mejora_m7  == 2"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_cuartoceavo=true , abrirModal_oportunidades_mejora_m7(documentacion);" >Modificar</button></td>
                                <td v-if="documentacion[0].evi_oportunidades_mejora_m7  == 2"></td>
                            </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                @include('ambiental.encargado_amb.condicionante_envio')
            </template>
            <template v-if="activo == 2">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Se envio correctamente tu documentación a la SUBDIRECCIÓN DE VINCULACIÓN Y EXTENSIÓN para su revisión</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-if="activo == 3">
                @include('ambiental.encargado_amb.correcciones_procedimiento_doc')
                @include('ambiental.encargado_amb.modal_enviar_modificacion_doc')
            </template>
            <template v-if="activo == 4">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Tu documentación fue autorizada por la SUBDIRECCIÓN DE VINCULACIÓN Y EXTENSIÓN</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            @include('ambiental.encargado_amb.modal_doc_1')
            @include('ambiental.encargado_amb.modal_doc_2')
            @include('ambiental.encargado_amb.modal_doc_3')
            @include('ambiental.encargado_amb.modal_doc_4')
            @include('ambiental.encargado_amb.modal_doc_5')
            @include('ambiental.encargado_amb.modal_doc_6')
            @include('ambiental.encargado_amb.modal_doc_7')
            @include('ambiental.encargado_amb.modal_doc_8')
            @include('ambiental.encargado_amb.modal_doc_9')
            @include('ambiental.encargado_amb.modal_doc_10')
            @include('ambiental.encargado_amb.modal_doc_11')
            @include('ambiental.encargado_amb.modal_doc_12')
            @include('ambiental.encargado_amb.modal_doc_13')
            @include('ambiental.encargado_amb.modal_doc_14')
            @include('ambiental.encargado_amb.modal_enviar_documentacion')

        </div>
    </main>
    <script>
        new Vue({
            el:"#envio_doc",

            data(){
                return {

                    //lo inicialisamos el array
                    documentacion:[],
                    activaciones:[],
                    respuestas:[],
                    activo:0,
                    estado_guardar_pri:false,
                    estado_guardar:false,
                    modal_pri:0,
                    modal_segundo:0,
                    modal_tercero:0,
                    modal_cuarto:0,
                    modal_quinto:0,
                    modal_sexto:0,
                    modal_septimo:0,
                    modal_octavo:0,
                    modal_noveno:0,
                    modal_decimo:0,
                    modal_onceavo:0,
                    modal_doceavo:0,
                    modal_terceavo:0,
                    modal_cuartoceavo:0,
                    modificarse_pri:false,
                    modificarse_segundo:false,
                    modificarse_tercero:false,
                    modificarse_cuarto:false,
                    modificarse_quinto:false,
                    modificarse_sexto:false,
                    modificarse_septimo:false,
                    modificarse_octavo:false,
                    modificarse_noveno:false,
                    modificarse_decimo:false,
                    modificarse_onceavo:false,
                    modificarse_doceavo:false,
                    modificarse_terceavo:false,
                    modificarse_cuartoceavo:false,
                    tituloModal:"",
                    doc_1:{},
                    file:'',
                    file2:'',
                    file3:'',
                    file4:'',
                    file5:'',
                    file6:'',
                    file7:'',
                    file8:'',
                    file9:'',
                    file10:'',
                    file11:'',
                    file12:'',
                    file13:'',
                    file14:'',
                    files:'',
                    doc:{
                        id_encargado:0,
                        id_periodo_amb:0,
                        evi_estado_acc_m1:0,
                        estado_estado_acc_m1:0,
                        pdf_estado_acc_m1:"",
                        comentario_estado_acc_m1:"",
                        evi_cuestion_ambas_per_m2:0,
                        estado_cuestion_ambas_per_m2:0,
                        pdf_cuestion_ambas_per_m2:"",
                        comentario_cuestion_ambas_per_m2:"",
                        evi_necesidades_espectativas_m2:0,
                        estado_necesidades_espectativas_m2:0,
                        pdf_necesidades_espectativas_m2:"",
                        comentario_necesidades_espectativas_m2:"",
                        evi_aspecto_ambiental_m2:0,
                        estado_aspecto_ambiental_m2:0,
                        pdf_aspecto_ambiental_m2:"",
                        comentario_aspecto_ambiental_m2:"",
                        evi_riesgo_oportu_m2:0,
                        estado_riesgo_oportu_m2:0,
                        pdf_riesgo_oportu_m2:"",
                        comentario_riesgo_oportu_m2:"",
                        evi_grado_objetivo_m3:0,
                        estado_grado_objetivo_m3:0,
                        pdf_grado_objetivo_m3:"",
                        comentario_grado_objetivo_m3:"",
                        evi_programa_gestion_m3:0,
                        estado_programa_gestion_m3:0,
                        pdf_programa_gestion_m3:"",
                        comentario_programa_gestion_m3:"",
                        evi_noconformid_correctivas_m4:0,
                        estado_noconformid_correctivas_m4:0,
                        pdf_noconformid_correctivas_m4:"",
                        comentario_noconformid_correctivas_m4:"",
                        evi_resu_seg_med_m4:0,
                        estado_resu_seg_med_m4:0,
                        pdf_resu_seg_med_m4:"",
                        comentario_resu_seg_med_m4:"",
                        evi_cumplimiento_req_m4:0,
                        estado_cumplimiento_req_m4:0,
                        pdf_cumplimiento_req_m4:"",
                        comentario_cumplimiento_req_m4:"",
                        evi_resultado_audi_m4:0,
                        estado_resultado_audi_m4:0,
                        pdf_resultado_audi_m4:"",
                        comentario_resultado_audi_m4:"",
                        evi_adecuacion_recurso_m5:0,
                        estado_adecuacion_recurso_m5:0,
                        pdf_adecuacion_recurso_m5:"",
                        comentario_adecuacion_recurso_m5:"",
                        evi_comunicacion_pertinente_m6:0,
                        estado_comunicacion_pertinente_m6:0,
                        pdf_comunicacion_pertinente_m6:"",
                        comentario_comunicacion_pertinente_m6:"",
                        evi_oportunidades_mejora_m7:0,
                        estado_oportunidades_mejora_m7:0,
                        pdf_oportunidades_mejora_m7:"",
                        comentario_oportunidades_mejora_m7:""
                    },
                    id_documentacion_encar:0,
                    estado_doc:false,
                    modal_enviar:0,
                    modal_enviar_modificacion:0,
                    status_documentacion:[],
                    modal_enviar_mod:0,


                }
            },
            methods: {
                //meetodo para mostrar tabla
                async Documentacion() {
                    //llamar datos al controlador
                    const contar = await axios.get('/ambiental/estado_documentacion/{{$id_encargado}}');
                    this.activaciones = contar.data;
                    this.activo = this.activaciones;
                        const documentacion = await axios.get('/ambiental/ver_documentacion_encargado/{{$id_encargado}}');
                        this.documentacion = documentacion.data;

                    const respuestas = await axios.get('/ambiental/respuestas/');
                    this.respuestas = respuestas.data;

                    const estado_doc = await axios.get('/ambiental/estado_documentacion_encargado/{{$id_encargado}}');
                    this.status_documentacion = estado_doc.data;

                },
                async  abrirModal_pri(){
                    this.estado_guardar_pri=false;
                    this.modal_pri=1;
                    if(this.modificarse_pri){
                        this.tituloModal="Agregar Documento";
                    }else{

                        this.tituloModal="Agregar Nuevo Documento";

                    }
                },
                async abrirModal_cuestion_ambas_per_m2(data={}){
                    this.modal_segundo=1;

                    if(this.modificarse_segundo){

                        this.tituloModal="Modificar Documento";
                        this.doc.evi_cuestion_ambas_per_m2=data[0].evi_cuestion_ambas_per_m2;
                        if( this.doc.evi_cuestion_ambas_per_m2 == 1) {
                            this.estado_doc = true;
                        }else{
                            this.estado_doc = false;
                        }
                        this.doc.pdf_cuestion_ambas_per_m2=data[0].pdf_cuestion_ambas_per_m2;
                        this.id_documentacion_encar=data[0].id_documentacion_encar;
                        this.file2="";
                    }else{
                        this.estado_doc = false;
                        this.tituloModal="Agregar Nuevo Documento";
                        this.doc.evi_cuestion_ambas_per_m2=data[0].evi_cuestion_ambas_per_m2;
                        this.doc.pdf_cuestion_ambas_per_m2=data[0].pdf_cuestion_ambas_per_m2;
                        this.id_documentacion_encar=data[0].id_documentacion_encar;

                    }

                },
                async abrirModal_necesidades_espectativas_m2(data={}){
                    this.modal_tercero=1;

                    if(this.modificarse_tercero){
                            this.file3="";
                        this.tituloModal="Modificar Documento";
                        this.doc.evi_necesidades_espectativas_m2=data[0].evi_necesidades_espectativas_m2;
                        if( this.doc.evi_necesidades_espectativas_m2 == 1) {
                            this.estado_doc = true;
                        }
                        else{
                            this.estado_doc = false;
                        }
                        this.doc.pdf_necesidades_espectativas_m2=data[0].pdf_necesidades_espectativas_m2;
                        this.id_documentacion_encar=data[0].id_documentacion_encar;
                    }else{
                        this.estado_doc = false;
                        this.tituloModal="Agregar Nuevo Documento";
                        this.doc.evi_necesidades_espectativas_m2=data[0].evi_necesidades_espectativas_m2;
                        this.doc.pdf_necesidades_espectativas_m2=data[0].pdf_necesidades_espectativas_m2;
                        this.id_documentacion_encar=data[0].id_documentacion_encar;

                    }

                },
                async  abrirModal_aspecto_ambiental_m2(){
                    this.estado_guardar=false;
                    this.modal_cuarto=1;
                    if(this.modificarse_cuarto){
                        this.tituloModal="Modificar Documento";
                        this.file4="";
                    }else{

                        this.tituloModal="Agregar Nuevo Documento";

                    }
                },
                async abrirModal_riesgo_oportu_m2(){
                    this.estado_guardar=false;
                    this.modal_quinto=1;
                    if(this.modificarse_quinto){
                        this.file5="";
                        this.tituloModal="Modificar Documento";
                    }else{

                        this.tituloModal="Agregar Nuevo Documento";

                    }
                },
                async abrirModal_grado_objetivo_m3(){
                    this.estado_guardar=false;
                    this.modal_sexto=1;
                    if(this.modificarse_sexto){
                        this.file6="";
                        this.tituloModal="Modificar Documento";
                    }else{

                        this.tituloModal="Agregar Nuevo Documento";

                    }
                },
                async abrirModal_programa_gestion_m3(){
                    this.estado_guardar=false;
                    this.modal_septimo=1;
                    if(this.modificarse_septimo){
                        this.file7="";
                        this.tituloModal="Modificar Documento";
                    }else{

                        this.tituloModal="Agregar Nuevo Documento";

                    }
                },
                async abrirModal_noconformid_correctivas_m4(){
                    this.estado_guardar=false;
                    this.modal_octavo=1;
                    if(this.modificarse_octavo){
                        this.file8="";
                        this.tituloModal="Modificar Documento";
                    }else{

                        this.tituloModal="Agregar Nuevo Documento";

                    }
                },
                async abrirModal_resu_seg_med_m4(){
                    this.estado_guardar=false;
                    this.modal_noveno=1;
                    if(this.modificarse_noveno){
                        this.file9="";
                        this.tituloModal="Modificar Documento";
                    }else{

                        this.tituloModal="Agregar Nuevo Documento";

                    }
                },
                async abrirModal_cumplimiento_req_m4()
                {
                    this.estado_guardar=false;
                    this.modal_decimo=1;
                    if(this.modificarse_decimo){
                        this.file10="";
                        this.tituloModal="Modificar Documento";
                    }else{

                        this.tituloModal="Agregar Nuevo Documento";

                    }
                },
                async abrirModal_resultado_audi_m4()
                {
                    this.estado_guardar=false;
                    this.modal_onceavo=1;
                    if(this.modificarse_onceavo){
                        this.file11="";
                        this.tituloModal="Modificar Documento";
                    }else{

                        this.tituloModal="Agregar Nuevo Documento";

                    }
                },
                async abrirModal_adecuacion_recurso_m5(data={})
                {
                    this.modal_doceavo=1;

                    if(this.modificarse_doceavo){
                        this.file12="";
                        this.tituloModal="Modificar Documento";
                        this.doc.evi_adecuacion_recurso_m5=data[0].evi_adecuacion_recurso_m5;
                        if( this.doc.evi_adecuacion_recurso_m5 == 1) {
                            this.estado_doc = true;
                        }
                        else{
                            this.estado_doc = false;
                        }
                        this.doc.pdf_adecuacion_recurso_m5=data[0].pdf_adecuacion_recurso_m5;
                        this.id_documentacion_encar=data[0].id_documentacion_encar;
                    }else{
                        this.estado_doc = false;
                        this.tituloModal="Agregar Nuevo Documento";
                        this.doc.evi_adecuacion_recurso_m5=data[0].evi_adecuacion_recurso_m5;
                        this.doc.pdf_adecuacion_recurso_m5=data[0].pdf_adecuacion_recurso_m5;
                        this.id_documentacion_encar=data[0].id_documentacion_encar;

                    }
                },
                async abrirModal_comunicacion_pertinente_m6(){
                    this.estado_guardar=false;
                    this.modal_terceavo=1;
                    if(this.modificarse_terceavo){
                        this.file13="";
                        this.tituloModal="Modificar Documento";
                    }else{

                        this.tituloModal="Agregar Nuevo Documento";

                    }
                },
                async abrirModal_oportunidades_mejora_m7(data={})
                {
                    this.modal_cuartoceavo=1;

                    if(this.modificarse_cuartoceavo){
                        this.file14="";
                        this.tituloModal="Modificar Documento";
                        this.doc.evi_oportunidades_mejora_m7 =data[0].evi_oportunidades_mejora_m7 ;
                        if( this.doc.evi_oportunidades_mejora_m7  == 1) {
                            this.estado_doc = true;
                        }
                        else{
                            this.estado_doc = false;
                        }
                        this.doc.pdf_oportunidades_mejora_m7=data[0].pdf_oportunidades_mejora_m7;
                        this.id_documentacion_encar=data[0].id_documentacion_encar;
                    }else{
                        this.estado_doc = false;
                        this.tituloModal="Agregar Nuevo Documento";
                        this.doc.evi_oportunidades_mejora_m7 =data[0].evi_oportunidades_mejora_m7 ;
                        this.doc.pdf_oportunidades_mejora_m7=data[0].pdf_oportunidades_mejora_m7;
                        this.id_documentacion_encar=data[0].id_documentacion_encar;

                    }
                },

                async abrirModalenviar(data={}){

                    this.modal_enviar=1;
                    this.id_documentacion_encar=data[0].id_documentacion_encar;
                },
                async abrirModalenviar_modficiacion(data={}){

                    this.modal_enviar_modificacion=1;
                    this.id_documentacion_encar=data[0].id_documentacion_encar;
                },
                async cerrarModal_enviar_mod(){
                    this.modal_enviar_modificacion=0;

                },
                async cerrarModal_enviar(){
                    this.modal_enviar=0;

                },
                async cerrarModal_pri(){
                    this.modal_pri=0;

                },
                async  cerrarModal_seg(){
                    this.modal_segundo=0;

                },
                async cerrarModal_tercero(){
                    this.modal_tercero=0;

                },
                async cerrarModal_cuarto(){
                    this.modal_cuarto=0;

                },
                async  cerrarModal_quinto(){
                    this.modal_quinto=0;

                },
                async  cerrarModal_sexto(){
                    this.modal_sexto=0;

                },
                async  cerrarModal_septimo(){
                    this.modal_septimo=0;

                },
                async  cerrarModal_octavo(){
                    this.modal_octavo=0;

                },
                async  cerrarModal_noveno(){
                    this.modal_noveno=0;

                },
                async  cerrarModal_decimo(){
                    this.modal_decimo=0;

                },
                async  cerrarModal_onceavo(){
                    this.modal_onceavo=0;

                },
                async  cerrarModal_doceavo(){
                    this.modal_doceavo=0;

                },
                async  cerrarModal_terceavo(){
                    this.modal_terceavo=0;

                },
                async  cerrarModal_cuartoceavo(){
                    this.modal_cuartoceavo=0;

                },

                async guardar_doc_1(){
                    /*
                            Initialize the form data
                        */
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

                        this.estado_guardar_pri=true;
                        data.append('name', 'my-file')
                        data.append('file', file)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        if(this.modificarse_pri) {
                            const resultado= await axios.post('/ambiental/modificar_doc_1/{{$id_encargado}}', data, config);
                        }else{
                            const resultado= await axios.post('/ambiental/registrar_doc_1/{{$id_encargado}}', data, config);
                        }
                        this.cerrarModal_pri();
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
                async guardar_doc_2(){
                    /*
                            Initialize the form data
                        */
                    if(this.doc.evi_cuestion_ambas_per_m2 == '') {
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Elige una opcion.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {
                         if(this.doc.evi_cuestion_ambas_per_m2 == 1) {


                             let data = new FormData();


                             let file2 = this.file2;

                             if (file2 == '') {
                                 swal({
                                     position: "top",
                                     type: "warning",
                                     title: "El campo se encuentra  vacío.",
                                     showConfirmButton: false,
                                     timer: 3500
                                 });
                             } else {

                                 this.estadoguardar = true;
                                 data.append('name', 'my-file')
                                 data.append('file', file2)

                                 let config = {
                                     header: {
                                         'Content-Type': 'multipart/form-data'
                                     }
                                 }

                                 const resultado=await axios.post('/ambiental/modificar_doc_2_condoc/{{$id_encargado}}', data, config);

                                 this.cerrarModal_seg();
                                 this.Documentacion();

                                 swal({
                                     position: "top",
                                     type: "success",
                                     title: "Registro exitoso",
                                     showConfirmButton: false,
                                     timer: 3500
                                 });

                             }
                         }else{
                             this.estadoguardar=true;
                             const resultado= await axios.post('/ambiental/modificar_doc_2_sindoc/{{$id_encargado}}');
                             this.cerrarModal_seg();
                             this.Documentacion();
                             swal({
                                 position: "top",
                                 type: "success",
                                 title: "Registro exitoso",
                                 showConfirmButton: false,
                                 timer: 3500
                             });

                         }
                    }
                },
                async guardar_doc_3(){
                    /*
                            Initialize the form data
                        */
                    if(this.doc.evi_necesidades_espectativas_m2 == '') {
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Elige una opcion.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {
                        if(this.doc.evi_necesidades_espectativas_m2 == 1) {


                            let data = new FormData();


                            let file3 = this.file3;
                            if (file3 == '') {
                                swal({
                                    position: "top",
                                    type: "warning",
                                    title: "El campo se encuentra  vacío.",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            } else {

                                this.estadoguardar = true;
                                data.append('name', 'my-file')
                                data.append('file', file3)

                                let config = {
                                    header: {
                                        'Content-Type': 'multipart/form-data'
                                    }
                                }
                                const resultado=await axios.post('/ambiental/modificar_doc_3_condoc/{{$id_encargado}}', data, config);

                                this.cerrarModal_tercero();
                                this.Documentacion();

                                this.file = '';
                                swal({
                                    position: "top",
                                    type: "success",
                                    title: "Registro exitoso",
                                    showConfirmButton: false,
                                    timer: 3500
                                });

                            }
                        }else{
                            this.estadoguardar=true;
                            const resultado= await axios.post('/ambiental/modificar_doc_3_sindoc/{{$id_encargado}}');
                            this.cerrarModal_tercero();
                            this.Documentacion();
                            swal({
                                position: "top",
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });

                        }
                    }
                },
                async guardar_doc_4(){
                    /*
                            Initialize the form data
                        */
                    let data = new FormData();


                    let file4=this.file4;
                    if( file4 == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estadoguardar=true;
                        data.append('name', 'my-file')
                        data.append('file', file4)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/ambiental/modificar_doc_4/{{$id_encargado}}', data, config);
                        this.cerrarModal_cuarto();
                        this.Documentacion();
                        this.file ='';
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });

                    }
                },
                async guardar_doc_5(){
                    /*
                            Initialize the form data
                        */
                    let data = new FormData();


                    let file5=this.file5;
                    if( file5 == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estadoguardar=true;
                        data.append('name', 'my-file')
                        data.append('file', file5)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/ambiental/modificar_doc_5/{{$id_encargado}}', data, config);
                        this.cerrarModal_quinto();
                        this.Documentacion()
                        this.file ='';
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                        ;
                    }
                },
                async guardar_doc_6(){
                    /*
                            Initialize the form data
                        */
                    let data = new FormData();


                    let file6=this.file6;
                    if( file6 == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estadoguardar=true;
                        data.append('name', 'my-file')
                        data.append('file', file6)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/ambiental/modificar_doc_6/{{$id_encargado}}', data, config);
                        this.cerrarModal_sexto();
                        this.Documentacion()
                        this.file ='';
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                        ;
                    }
                },
                async guardar_doc_7(){
                    /*
                            Initialize the form data
                        */
                    let data = new FormData();


                    let file7=this.file7;
                    if( file7 == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estadoguardar=true;
                        data.append('name', 'my-file')
                        data.append('file', file7)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/ambiental/modificar_doc_7/{{$id_encargado}}', data, config);
                        this.cerrarModal_septimo();
                        this.Documentacion()
                        this.file ='';
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                        ;
                    }
                },
                async guardar_doc_8(){
                    /*
                            Initialize the form data
                        */
                    let data = new FormData();


                    let file8=this.file8;
                    if( file8 == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estadoguardar=true;
                        data.append('name', 'my-file')
                        data.append('file', file8)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/ambiental/modificar_doc_8/{{$id_encargado}}', data, config);
                        this.cerrarModal_octavo();
                        this.Documentacion()
                        this.file ='';
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                        ;
                    }
                },
                async guardar_doc_9(){
                    /*
                            Initialize the form data
                        */
                    let data = new FormData();


                    let file9=this.file9;
                    if( file9 == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estadoguardar=true;
                        data.append('name', 'my-file')
                        data.append('file', file9)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/ambiental/modificar_doc_9/{{$id_encargado}}', data, config);
                        this.cerrarModal_noveno();
                        this.Documentacion()
                        this.file ='';
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                        ;
                    }
                },
                async guardar_doc_10(){
                    /*
                            Initialize the form data
                        */
                    let data = new FormData();


                    let file10=this.file10;
                    if( file10 == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estadoguardar=true;
                        data.append('name', 'my-file')
                        data.append('file', file10)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/ambiental/modificar_doc_10/{{$id_encargado}}', data, config);
                        this.cerrarModal_decimo();
                        this.Documentacion();
                        this.file ='';
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                        ;
                    }
                },
                async guardar_doc_11(){
                    /*
                            Initialize the form data
                        */
                    let data = new FormData();


                    let file11=this.file11;
                    if( file11 == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estadoguardar=true;
                        data.append('name', 'my-file')
                        data.append('file', file11)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/ambiental/modificar_doc_11/{{$id_encargado}}', data, config);
                        this.cerrarModal_onceavo();
                        this.Documentacion()
                        this.file ='';
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                        ;
                    }
                },
                async guardar_doc_12(){
                    /*
                            Initialize the form data
                        */
                    if(this.doc.evi_adecuacion_recurso_m5 == '') {
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Elige una opcion.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {
                        if(this.doc.evi_adecuacion_recurso_m5 == 1) {


                            let data = new FormData();


                            let file12 = this.file12;
                            if (file12 == '') {
                                swal({
                                    position: "top",
                                    type: "warning",
                                    title: "El campo se encuentra  vacío.",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            } else {

                                this.estadoguardar = true;
                                data.append('name', 'my-file')
                                data.append('file', file12)

                                let config = {
                                    header: {
                                        'Content-Type': 'multipart/form-data'
                                    }
                                }
                                const resultado=await axios.post('/ambiental/modificar_doc_12_condoc/{{$id_encargado}}', data, config);

                                this.cerrarModal_doceavo();
                                this.Documentacion();

                                this.file = '';
                                swal({
                                    position: "top",
                                    type: "success",
                                    title: "Registro exitoso",
                                    showConfirmButton: false,
                                    timer: 3500
                                });

                            }
                        }else{
                            this.estadoguardar=true;
                            const resultado= await axios.post('/ambiental/modificar_doc_12_sindoc/{{$id_encargado}}');
                            this.cerrarModal_doceavo();
                            this.Documentacion();
                            swal({
                                position: "top",
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });

                        }
                    }
                },
                async guardar_doc_13(){
                    /*
                            Initialize the form data
                        */
                    let data = new FormData();


                    let file13=this.file13;
                    if( file13 == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estadoguardar=true;
                        data.append('name', 'my-file')
                        data.append('file', file13)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/ambiental/modificar_doc_13/{{$id_encargado}}', data, config);
                        this.cerrarModal_terceavo();
                        this.Documentacion()
                        this.file ='';
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                        ;
                    }
                },
                async guardar_doc_14(){
                    /*
                            Initialize the form data
                        */
                    if(this.doc.evi_oportunidades_mejora_m7 == '') {
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Elige una opcion.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {
                        if(this.doc.evi_oportunidades_mejora_m7 == 1) {


                            let data = new FormData();


                            let file14 = this.file14;
                            if (file14 == '') {
                                swal({
                                    position: "top",
                                    type: "warning",
                                    title: "El campo se encuentra  vacío.",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            } else {

                                this.estadoguardar = true;
                                data.append('name', 'my-file')
                                data.append('file', file14)

                                let config = {
                                    header: {
                                        'Content-Type': 'multipart/form-data'
                                    }
                                }
                                const resultado=await axios.post('/ambiental/modificar_doc_14_condoc/{{$id_encargado}}', data, config);

                                this.cerrarModal_cuartoceavo();
                                this.Documentacion();

                                this.file = '';
                                swal({
                                    position: "top",
                                    type: "success",
                                    title: "Registro exitoso",
                                    showConfirmButton: false,
                                    timer: 3500
                                });

                            }
                        }else{
                            this.estadoguardar=true;
                            const resultado= await axios.post('/ambiental/modificar_doc_14_sindoc/{{$id_encargado}}');
                            this.cerrarModal_cuartoceavo();
                            this.Documentacion();
                            swal({
                                position: "top",
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });

                        }
                    }
                },
                async guardar_enviar(){
                    this.estado_guardar=true;

                    const resultado= await axios.post('/ambiental/enviar_documentacion/'+this.id_documentacion_encar);
                    this.cerrarModal_enviar();
                    this.Documentacion();
                    swal({
                        position: "top",
                        type: "success",
                        title: "Se envio correctamente",
                        showConfirmButton: false,
                        timer: 3500
                    });
                },
                async guardar_enviar_mod(){
                    this.estado_guardar=true;

                    const resultado= await axios.post('/ambiental/enviar_documentacion_mod/'+this.id_documentacion_encar);
                    this.cerrarModal_enviar_mod();
                    this.Documentacion();
                    swal({
                        position: "top",
                        type: "success",
                        title: "Se envio correctamente",
                        showConfirmButton: false,
                        timer: 3500
                    });
                },
                variable_doc_1(event){
                    this.file = event.target.files[0];
                },
                variable_doc_2(event){
                    this.file2 = event.target.files[0];
                },
                variable_doc_3(event){
                    this.file3 = event.target.files[0];
                },
                variable_doc_4(event){

                    this.file4 = event.target.files[0];
                },
                variable_doc_5(event){

                    this.file5 = event.target.files[0];
                },
                variable_doc_6(event){

                    this.file6 = event.target.files[0];
                },
                variable_doc_7(event){

                    this.file7 = event.target.files[0];
                },
                variable_doc_8(event){

                    this.file8 = event.target.files[0];
                },
                variable_doc_9(event){

                    this.file9 = event.target.files[0];
                },
                variable_doc_10(event){

                    this.file10 = event.target.files[0];
                },
                variable_doc_11(event){

                    this.file11 = event.target.files[0];
                },
                variable_doc_12(event){

                    this.file12 = event.target.files[0];
                },
                variable_doc_13(event){

                    this.file13 = event.target.files[0];
                },
                variable_doc_14(event){

                    this.file14 = event.target.files[0];
                },
                estado_doc_2(event){
                    var eventos= event.target.value;
                    if(eventos == 1){
                        this.estado_doc=true;
                    }else{
                        this.estado_doc=false;
                    }
                },
                estado_doc_3(event){
                    var eventos= event.target.value;
                    if(eventos == 1){
                        this.estado_doc=true;
                    }else{
                        this.estado_doc=false;
                    }
                },
                estado_doc_12(event){
                    var eventos= event.target.value;
                    if(eventos == 1){
                        this.estado_doc=true;
                    }else{
                        this.estado_doc=false;
                    }
                },
                estado_doc_14(event){
                    var eventos= event.target.value;
                    if(eventos == 1){
                        this.estado_doc=true;
                    }else{
                        this.estado_doc=false;
                    }
                },


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

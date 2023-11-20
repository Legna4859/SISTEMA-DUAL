
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-danger">
            <div class="panel-heading">Hacer las modificaciones que se te muestra en los comentarios de cada documento.</div>

        </div>
    </div>
</div>
    <div class="row">
        <div  class="col-md-10 col-lg-offset-1">
            <table id="tabla_envio" class="table table-bordered table-resposive">
                <thead>
                <tr>

                    <th>Módulo</th>
                    <th>Requerimiento</th>
                    <th>Requiere evidencia</th>
                    <th>Acción</th>
                    <th>Mostrar evidencia</th>
                    <th>Comentario de modificación</th>
                </tr>
                </thead>
                <tbody>
                <template v-if="documentacion[0].solic_estado_acc_m1  == 2">
                <tr>

                    <td>Modulo 1</td>
                    <td>a) El estado de las acciones de las revisiones por la dirección previas.</td>
                    <td>SI </td>
                    <template v-if="documentacion[0].estado_estado_acc_m1 == 1">
                        <td style="color: red; ">Autorizado</td>
                        <td style="color: red">Autorizado</td>
{{--
                        <td><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_estado_acc_m1  }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                        --}}
                        <td style="color: red;  ">Autorizado</td>
                    </template>
                    <template v-if="documentacion[0].estado_estado_acc_m1 == 2">
                    <td ><button v-if="documentacion[0].pdf_estado_acc_m1 != ''" class="btn btn-warning btn-sm" v-on:click="modificarse_pri=true , abrirModal_pri();" >Modificar</button></td>

                        <td><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_estado_acc_m1  }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                        <td style="color: #0e90d2">@{{ documentacion[0].comentario_estado_acc_m1 }}</td>
                    </template>
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
                    <td v-if="documentacion[0].evi_cuestion_ambas_per_m2  == 1">SI</td>
                    <td v-if="documentacion[0].evi_cuestion_ambas_per_m2  == 2">NO</td>
                  <template v-if="documentacion[0].estado_cuestion_ambas_per_m2 == 1">
                      <td style="color: red; ">Autorizado</td>
                      <td style="color: red">Autorizado</td>
                      <td style="color: red; ">Autorizado</td>

                  </template>
                    <template v-if="documentacion[0].estado_cuestion_ambas_per_m2 ==2">

                    <td v-if="documentacion[0].evi_cuestion_ambas_per_m2  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_segundo=true , abrirModal_cuestion_ambas_per_m2(documentacion);" >Modificar</button></td>

                        <td v-if="documentacion[0].evi_cuestion_ambas_per_m2  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_cuestion_ambas_per_m2   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                    <td v-if="documentacion[0].evi_cuestion_ambas_per_m2  == 2"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_segundo=true , abrirModal_cuestion_ambas_per_m2(documentacion);" >Modificar</button></td>
                    <td v-if="documentacion[0].evi_cuestion_ambas_per_m2  == 2"></td>
                        <td style="color: #0e90d2">@{{ documentacion[0].comentario_cuestion_ambas_per_m2 }}</td>
                    </template>
                </tr>
                </template>
                <template v-if="documentacion[0].solic_necesidades_espectativas_m2  == 2">
                <tr>

                    <td></td>
                    <td>2) Las necesidades y expectativas de las partes interesadas incluido los requisitos legales y otros requisitos.</td>
                    <td v-if="documentacion[0].evi_necesidades_espectativas_m2  == 1">SI</td>
                    <td v-if="documentacion[0].evi_necesidades_espectativas_m2  == 2">NO</td>
                    <template v-if="documentacion[0].estado_necesidades_espectativas_m2 ==1">
                        <td style="color: red; ">Autorizado</td>
                        <td style="color: red">Autorizado</td>
                        <td style="color: red; ">Autorizado</td>

                    </template>
                    <template v-if="documentacion[0].estado_necesidades_espectativas_m2 ==2">
                    <td v-if="documentacion[0].evi_necesidades_espectativas_m2  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_tercero=true , abrirModal_necesidades_espectativas_m2(documentacion);" >Modificar</button></td>
                    <td v-if="documentacion[0].evi_necesidades_espectativas_m2  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_necesidades_espectativas_m2   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                    <td v-if="documentacion[0].evi_necesidades_espectativas_m2  == 2"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_tercero=true , abrirModal_necesidades_espectativas_m2(documentacion);" >Modificar</button></td>
                    <td v-if="documentacion[0].evi_necesidades_espectativas_m2  == 2"></td>
                        <td style="color: #0e90d2">@{{ documentacion[0].comentario_necesidades_espectativas_m2 }}</td>
                    </template>
                </tr>
                </template>
                <template v-if="documentacion[0].solic_aspecto_ambiental_m2  == 2">
                <tr>

                    <td></td>
                    <td>3) Sus  aspectos ambientales significativos.</td>
                    <td v-if="documentacion[0].evi_aspecto_ambiental_m2  == 1">SI</td>
                    <template v-if="documentacion[0].estado_aspecto_ambiental_m2 ==1">
                        <td style="color: red; ">Autorizado</td>
                        <td style="color: red">Autorizado</td>
                        <td style="color: red; ">Autorizado</td>

                    </template>
                    <template v-if="documentacion[0].estado_aspecto_ambiental_m2 ==2">
                    <td v-if="documentacion[0].evi_aspecto_ambiental_m2  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_cuarto=true , abrirModal_aspecto_ambiental_m2(documentacion);" >Modificar</button></td>
                    <td v-if="documentacion[0].evi_aspecto_ambiental_m2  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_aspecto_ambiental_m2   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                        <td style="color: #0e90d2">@{{ documentacion[0].comentario_aspecto_ambiental_m2 }}</td>
                    </template>
                </tr>
                </template>
                <template v-if="documentacion[0].solic_riesgo_oportu_m2  == 2">
                <tr>

                    <td></td>
                    <td>4) Los riesgos y oportunidades.</td>

                    <td v-if="documentacion[0].evi_riesgo_oportu_m2  == 1">SI</td>
                    <template v-if="documentacion[0].estado_riesgo_oportu_m2 ==1">
                        <td style="color: red; ">Autorizado</td>
                        <td style="color: red">Autorizado</td>
                        <td style="color: red; ">Autorizado</td>

                    </template>
                    <template v-if="documentacion[0].estado_riesgo_oportu_m2 ==2">
                       <td v-if="documentacion[0].evi_riesgo_oportu_m2  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_quinto=true , abrirModal_riesgo_oportu_m2(documentacion);" >Modificar</button></td>
                    <td v-if="documentacion[0].evi_riesgo_oportu_m2  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_riesgo_oportu_m2   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                        <td style="color: #0e90d2">@{{ documentacion[0].comentario_riesgo_oportu_m2 }}</td>
                    </template>
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
                    <td v-if="documentacion[0].evi_grado_objetivo_m3  == 1">SI</td>
                    <template v-if="documentacion[0].estado_grado_objetivo_m3 ==1">
                        <td style="color: red; ">Autorizado</td>
                        <td style="color: red">Autorizado</td>
                        <td style="color: red; ">Autorizado</td>

                    </template>
                    <template v-if="documentacion[0].estado_grado_objetivo_m3 ==2">
                    <td v-if="documentacion[0].evi_grado_objetivo_m3  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_sexto=true , abrirModal_grado_objetivo_m3(documentacion);" >Modificar</button></td>
                    <td v-if="documentacion[0].evi_grado_objetivo_m3  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_grado_objetivo_m3    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                        <td style="color: #0e90d2">@{{ documentacion[0].comentario_grado_objetivo_m3 }}</td>
                    </template>
                </tr>
                </template>
                <template v-if="documentacion[0].solic_programa_gestion_m3  == 2">
                <tr>

                    <td></td>
                    <td>2.-Programa de Gestión Ambiental.</td>

                    <td v-if="documentacion[0].evi_programa_gestion_m3  == 1">SI</td>
                    <template v-if="documentacion[0].estado_programa_gestion_m3 ==1">
                        <td style="color: red; ">Autorizado</td>
                        <td style="color: red">Autorizado</td>
                        <td style="color: red; ">Autorizado</td>

                    </template>
                    <template v-if="documentacion[0].estado_programa_gestion_m3 ==2">
                    <td v-if="documentacion[0].evi_programa_gestion_m3  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_septimo=true , abrirModal_programa_gestion_m3(documentacion);" >Modificar</button></td>
                    <td v-if="documentacion[0].evi_programa_gestion_m3  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_programa_gestion_m3    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                        <td style="color: #0e90d2">@{{ documentacion[0].comentario_programa_gestion_m3 }}</td>
                    </template>
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
                    <td v-if="documentacion[0].evi_noconformid_correctivas_m4  == 1">SI</td>
                    <template v-if="documentacion[0].estado_noconformid_correctivas_m4 ==1">
                        <td style="color: red; ">Autorizado</td>
                        <td style="color: red">Autorizado</td>
                        <td style="color: red; ">Autorizado</td>

                    </template>
                    <template v-if="documentacion[0].estado_noconformid_correctivas_m4 ==2">
                    <td v-if="documentacion[0].evi_noconformid_correctivas_m4  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_octavo=true , abrirModal_noconformid_correctivas_m4(documentacion);" >Modificar</button></td>
                    <td v-if="documentacion[0].evi_noconformid_correctivas_m4  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_noconformid_correctivas_m4    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                        <td style="color: #0e90d2">@{{ documentacion[0].comentario_noconformid_correctivas_m4 }}</td>
                    </template>
                </tr>
                </template>
                <template v-if="documentacion[0].solic_resu_seg_med_m4  == 2 ">
                <tr>

                    <td></td>
                    <td>2) Resultados de seguimiento y medición.</td>
                    <td v-if="documentacion[0].evi_resu_seg_med_m4   == 1">SI</td>
                    <template v-if="documentacion[0].estado_resu_seg_med_m4 ==1">
                        <td style="color: red; ">Autorizado</td>
                        <td style="color: red">Autorizado</td>
                        <td style="color: red; ">Autorizado</td>
                    </template>
                    <template v-if="documentacion[0].estado_resu_seg_med_m4 ==2">
                    <td v-if="documentacion[0].evi_resu_seg_med_m4   == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_noveno=true , abrirModal_resu_seg_med_m4(documentacion);" >Modificar</button></td>
                    <td v-if="documentacion[0].evi_resu_seg_med_m4   == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_resu_seg_med_m4    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                        <td style="color: #0e90d2">@{{ documentacion[0].comentario_resu_seg_med_m4 }}</td>
                    </template>
                </tr>
                </template>
                <template v-if="documentacion[0].solic_cumplimiento_req_m4  == 2 ">
                <tr>

                    <td></td>
                    <td>3) Cumplimiento de los requisitos legales y otros requisitos.</td>

                    <td v-if="documentacion[0].evi_cumplimiento_req_m4   == 1">SI</td>
                    <template v-if="documentacion[0].estado_cumplimiento_req_m4 ==1">
                        <td style="color: red; ">Autorizado</td>
                        <td style="color: red">Autorizado</td>
                        <td style="color: red; ">Autorizado</td>
                    </template>
                    <template v-if="documentacion[0].estado_cumplimiento_req_m4 ==2">
                    <td v-if="documentacion[0].evi_cumplimiento_req_m4   == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_decimo=true , abrirModal_cumplimiento_req_m4(documentacion);" >Modificar</button></td>
                    <td v-if="documentacion[0].evi_cumplimiento_req_m4   == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_cumplimiento_req_m4    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                        <td style="color: #0e90d2">@{{ documentacion[0].comentario_cumplimiento_req_m4 }}</td>
                    </template>
                </tr>
                </template>
                <template v-if="documentacion[0].solic_resultado_audi_m4  == 2">
                <tr>

                    <td></td>
                    <td>4) Resultado de las auditorias.</td>
                    <td v-if="documentacion[0].evi_resultado_audi_m4   == 1">SI</td>
                    <template v-if="documentacion[0].estado_resultado_audi_m4 ==1">
                        <td style="color: red; ">Autorizado</td>
                        <td style="color: red">Autorizado</td>
                        <td style="color: red; ">Autorizado</td>
                    </template>
                    <template v-if="documentacion[0].estado_resultado_audi_m4 ==2">
                    <td v-if="documentacion[0].evi_resultado_audi_m4   == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_onceavo=true , abrirModal_resultado_audi_m4(documentacion);" >Modificar</button></td>
                    <td v-if="documentacion[0].evi_resultado_audi_m4   == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_resultado_audi_m4    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                        <td style="color: #0e90d2">@{{ documentacion[0].comentario_resultado_audi_m4 }}</td>
                    </template>
                </tr>
                </template>
                <template v-if="documentacion[0].solic_adecuacion_recurso_m5  == 2">
                <tr>

                    <td>Modulo 5</td>
                    <td>e) Adecuación de los recursos.</td>


                    <td v-if="documentacion[0].evi_adecuacion_recurso_m5  == 1">SI</td>
                    <td v-if="documentacion[0].evi_adecuacion_recurso_m5  == 2">NO</td>
                    <template v-if="documentacion[0].estado_adecuacion_recurso_m5 ==1">
                        <td style="color: red; ">Autorizado</td>
                        <td style="color: red">Autorizado</td>
                        <td style="color: red; ">Autorizado</td>
                    </template>
                    <template v-if="documentacion[0].estado_adecuacion_recurso_m5 ==2">
                    <td v-if="documentacion[0].evi_adecuacion_recurso_m5  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_doceavo=true , abrirModal_adecuacion_recurso_m5(documentacion);" >Modificar</button></td>
                    <td v-if="documentacion[0].evi_adecuacion_recurso_m5  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_adecuacion_recurso_m5   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                    <td v-if="documentacion[0].evi_adecuacion_recurso_m5  == 2"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_doceavo=true , abrirModal_adecuacion_recurso_m5(documentacion);" >Modificar</button></td>
                    <td v-if="documentacion[0].evi_adecuacion_recurso_m5  == 2"></td>
                        <td style="color: #0e90d2">@{{ documentacion[0].comentario_adecuacion_recurso_m5 }}</td>
                    </template>
                </tr>
                </template>
                <template v-if="documentacion[0].solic_comunicacion_pertinente_m6  == 2">
                <tr>

                    <td>Modulo 6</td>
                    <td>f) Las comunciaciones pertinentes de las partes interesadas, incluidas las quejas.</td>
                    <td v-if="documentacion[0].evi_comunicacion_pertinente_m6   == 1">SI</td>
                    <template v-if="documentacion[0].estado_comunicacion_pertinente_m6 ==1">
                        <td style="color: red; ">Autorizado</td>
                        <td style="color: red">Autorizado</td>
                        <td style="color: red; ">Autorizado</td>
                    </template>
                    <template v-if="documentacion[0].estado_comunicacion_pertinente_m6 ==2">
                    <td v-if="documentacion[0].evi_comunicacion_pertinente_m6   == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_terceavo=true , abrirModal_comunicacion_pertinente_m6(documentacion);" >Modificar</button></td>
                    <td v-if="documentacion[0].evi_comunicacion_pertinente_m6   == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_comunicacion_pertinente_m6    }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                        <td style="color: #0e90d2">@{{ documentacion[0].comentario_comunicacion_pertinente_m6 }}</td>
                    </template>
                </tr>
                </template>
                <template v-if="documentacion[0].solic_oportunidades_mejora_m7  == 2">
                <tr>

                    <td>Modulo 7</td>
                    <td>g) Las oportunidades de mejora continua.</td>
                    <td v-if="documentacion[0].evi_oportunidades_mejora_m7  == 1">SI</td>
                    <td v-if="documentacion[0].evi_oportunidades_mejora_m7  == 2">NO</td>
                    <template v-if="documentacion[0].estado_oportunidades_mejora_m7 ==1">
                        <td style="color: red; ">Autorizado</td>
                        <td style="color: red">Autorizado</td>
                        <td style="color: red; ">Autorizado</td>
                    </template>
                    <template v-if="documentacion[0].estado_oportunidades_mejora_m7 ==2">
                    <td v-if="documentacion[0].evi_oportunidades_mejora_m7  == 1"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_cuartoceavo=true , abrirModal_oportunidades_mejora_m7(documentacion);" >Modificar</button></td>
                    <td v-if="documentacion[0].evi_oportunidades_mejora_m7  == 1"><a  target="_blank" href="/sub_vinculacion/@{{documentacion[0].pdf_oportunidades_mejora_m7   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                    <td v-if="documentacion[0].evi_oportunidades_mejora_m7  == 2"><button  class="btn btn-warning btn-sm" v-on:click="modificarse_cuartoceavo=true , abrirModal_oportunidades_mejora_m7(documentacion);" >Modificar</button></td>
                    <td v-if="documentacion[0].evi_oportunidades_mejora_m7  == 2"></td>
                        <td style="color: #0e90d2">@{{ documentacion[0].comentario_oportunidades_mejora_m7 }}</td>
                    </template>
                </tr>
                </template>
                </tbody>
            </table>
        </div>
    </div>
<div class="row">
    <div class="col-md-2 col-md-offset-5">
        <button  class="btn btn-success btn-lg btn-block" v-on:click="abrirModalenviar_modficiacion(documentacion);" >Enviar Documentación</button>
<p><br></p>
    </div>
</div>

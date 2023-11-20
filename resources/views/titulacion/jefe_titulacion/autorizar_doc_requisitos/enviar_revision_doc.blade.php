<template v-if="veri_constancia_ingles == 1"> {{--alumnos de no. cuenta menor 2010--}}
    <template v-if="docu.cal_acta_nac   == 1 && docu.cal_curp   == 1 &&
 docu.cal_certificado_prep   == 1 && docu.cal_certificado_tesvb   == 1 &&
docu.cal_constancia_ss   == 1 && docu.cal_certificado_acred_ingles   == 1 &&
docu.evi_constancia_adeudo   == 1  && docu.cal_opcion_titulacion == 1 && docu.cal_acta_residencia == 1 &&
docu.cal_pago_titulo   == 1  && docu.cal_pago_contancia == 1
&&
docu.cal_pago_derecho_ti   == 1  && docu.cal_pago_integrante_jurado == 1">

        <template v-if="docu.estado_acta_nac   == 1 && docu.estado_curp   == 1 &&
 docu.estado_certificado_prep   == 1 && docu.estado_certificado_tesvb   == 1 &&
docu.estado_constancia_ss   == 1 && docu.estado_certificado_acred_ingles   == 1 &&
docu.evi_constancia_adeudo   == 1  && docu.estado_opcion_titulacion == 1 &&  docu.estado_acta_residencia == 1 &&
docu.estado_pago_titulo   == 1  && docu.estado_pago_contancia == 1
&&
docu.estado_pago_derecho_ti   == 1  && docu.estado_pago_integrante_jurado == 1">
        <div class="row">
            <div class="col-md-3 col-md-offset-5">

                <button  class="btn btn-success btn-lg btn-block" v-on:click="abrirModalautorizar_Doc();" >Autorizar Documentación</button>


                <p><br/></p>
            </div>
        </div>
        </template>
        <template v-else>
            <div class="row">
                <div class="col-md-2 col-md-offset-5">

                    <button  class="btn btn-success btn-lg btn-block" v-on:click="abrirModalenviar_modificaciones();" >Enviar correcciones</button>


                    <p><br/></p>
                </div>
            </div>
        </template>
    </template>

</template>
<template v-if="veri_constancia_ingles == 2">
    <template v-if="veri_egel == 0">
        <template v-if="docu.cal_acta_nac   == 1 && docu.cal_curp   == 1 &&
 docu.cal_certificado_prep   == 1 && docu.cal_certificado_tesvb   == 1 &&
docu.cal_constancia_ss   == 1  &&
docu.evi_constancia_adeudo   == 1
&&
 docu.cal_opcion_titulacion == 1 &&
docu.cal_pago_titulo   == 1  && docu.cal_pago_contancia == 1
&&
docu.cal_pago_derecho_ti   == 1  && docu.cal_pago_integrante_jurado == 1 && docu.cal_pago_concepto_autenticacion == 1">

            <template v-if="docu.estado_acta_nac   == 1 && docu.estado_curp   == 1 &&
 docu.estado_certificado_prep   == 1 && docu.estado_certificado_tesvb   == 1 &&
docu.estado_constancia_ss   == 1  &&
docu.evi_constancia_adeudo   == 1  &&
 docu.estado_opcion_titulacion == 1 &&
docu.estado_pago_titulo   == 1  && docu.estado_pago_contancia == 1
&&
docu.estado_pago_derecho_ti   == 1  && docu.estado_pago_integrante_jurado == 1 && docu.estado_pago_concepto_autenticacion == 1">
                <div class="row">
                    <div class="col-md-3 col-md-offset-5">

                        <button  class="btn btn-success btn-lg btn-block" v-on:click="abrirModalautorizar_Doc();" >Autorizar Documentación</button>


                        <p><br/></p>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="row">
                    <div class="col-md-2 col-md-offset-5">

                        <button  class="btn btn-success btn-lg btn-block" v-on:click="abrirModalenviar_modificaciones();" >Enviar correcciones</button>


                        <p><br/></p>
                    </div>
                </div>
            </template>
        </template>
    </template>
    <template v-if="veri_egel == 1">
        <template v-if="docu.cal_acta_nac   == 1 && docu.cal_curp   == 1 &&
 docu.cal_certificado_prep   == 1 && docu.cal_certificado_tesvb   == 1 &&
docu.cal_constancia_ss   == 1  &&
docu.evi_constancia_adeudo   == 1  && docu.cal_reporte_result_egel == 1
&&
 docu.cal_opcion_titulacion == 1 &&
docu.cal_pago_titulo   == 1  && docu.cal_pago_contancia == 1
&&
docu.cal_pago_derecho_ti   == 1  && docu.cal_pago_integrante_jurado == 1 && docu.cal_pago_concepto_autenticacion == 1">

            <template v-if="docu.estado_acta_nac   == 1 && docu.estado_curp   == 1 &&
 docu.estado_certificado_prep   == 1 && docu.estado_certificado_tesvb   == 1 &&
docu.estado_constancia_ss   == 1  &&
docu.evi_constancia_adeudo   == 1  && docu.estado_reporte_result_egel == 1 &&
 docu.estado_opcion_titulacion == 1 &&
docu.estado_pago_titulo   == 1  && docu.estado_pago_contancia == 1
&&
docu.estado_pago_derecho_ti   == 1  && docu.estado_pago_integrante_jurado == 1 && docu.estado_pago_concepto_autenticacion == 1">
                <div class="row">
                    <div class="col-md-3 col-md-offset-5">

                        <button  class="btn btn-success btn-lg btn-block" v-on:click="abrirModalautorizar_Doc();" >Autorizar Documentación</button>


                        <p><br/></p>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="row">
                    <div class="col-md-2 col-md-offset-5">

                        <button  class="btn btn-success btn-lg btn-block" v-on:click="abrirModalenviar_modificaciones();" >Enviar correcciones</button>


                        <p><br/></p>
                    </div>
                </div>
            </template>
        </template>
    </template>

</template>
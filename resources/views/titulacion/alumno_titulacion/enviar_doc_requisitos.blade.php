
<template v-if="veri_constancia_ingles == 1"> {{--alumnos de no. cuenta menor 2010--}}
    <template v-if="docu.evi_acta_nac   == 1 && docu.evi_curp   == 1 &&
 docu.evi_certificado_prep   == 1 && docu.evi_certificado_tesvb   == 1 &&
docu.evi_constancia_ss   == 1 && docu.evi_certificado_acred_ingles   == 1 && docu.evi_acta_residencia   == 1 &&
docu.evi_opcion_titulacion   > 0 && docu.evi_pago_titulo   == 1 && docu.evi_pago_contancia   == 1
&& docu.evi_pago_derecho_ti   == 1 && docu.evi_pago_integrante_jurado   == 1">
        <div class="row">
            <div class="col-md-2 col-md-offset-5">

                    <button  class="btn btn-success btn-lg btn-block" v-on:click="abrirModalenviar();" >Enviar Documentación</button>


                <p><br/></p>
            </div>
        </div>
    </template>

</template>
<template v-if="veri_constancia_ingles == 2">

    <template v-if="veri_egel == 0">
        <template v-if="docu.evi_acta_nac   == 1 && docu.evi_curp   == 1 &&
 docu.evi_certificado_prep   == 1 && docu.evi_certificado_tesvb   == 1 &&
docu.evi_constancia_ss   == 1 && docu.evi_opcion_titulacion   > 0
&& docu.evi_pago_titulo   == 1 && docu.evi_pago_contancia   == 1
&& docu.evi_pago_derecho_ti   == 1 && docu.evi_pago_integrante_jurado   == 1 && docu.evi_pago_concepto_autenticacion    == 1 && ingles.estado_cert == 2">
            <div class="row">
                <div class="col-md-2 col-md-offset-5">

                    <button  class="btn btn-success btn-lg btn-block" v-on:click="abrirModalenviar();" >Enviar Documentación</button>


                    <p><br/></p>
                </div>
            </div>
        </template>
    </template>
    <template v-if="veri_egel == 1">

        <template v-if="docu.evi_acta_nac   == 1 && docu.evi_curp   == 1 &&
 docu.evi_certificado_prep   == 1 && docu.evi_certificado_tesvb   == 1 &&
docu.evi_constancia_ss   == 1 && docu.evi_opcion_titulacion   > 0 && docu.evi_reporte_result_egel == 1
&& docu.evi_pago_titulo   == 1 && docu.evi_pago_contancia   == 1
&& docu.evi_pago_derecho_ti   == 1 && docu.evi_pago_integrante_jurado   == 1 && docu.evi_pago_concepto_autenticacion    == 1 && ingles.estado_cert == 2">
            <div class="row">
                <div class="col-md-2 col-md-offset-5">

                    <button  class="btn btn-success btn-lg btn-block" v-on:click="abrirModalenviar();" >Enviar Documentación</button>


                    <p><br/></p>
                </div>
            </div>
        </template>
    </template>
</template>





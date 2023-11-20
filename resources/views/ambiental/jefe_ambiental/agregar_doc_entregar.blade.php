@extends('layouts.app')
@section('title', 'Ambiental')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading" style="text-align: center">PROCEDIMIENTO: {{$proc->nom_procedimiento}}<br> ENCARGADO: {{$proc->nombre}}</div>

            </div>
        </div>
    </div>
    <div id="reg_doc">
        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <p>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                    <a href="{{url("/ambiental/ver_periodos")}}">Periodos Ambiental</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <a href="{{url("/ambiental/ver_proc_ambiental/$id_periodo")}}">Procedimientos Registrados </a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span>Documentación del Procedimiento para entregar</span>
                </p>
                <br>
            </div>
        </div>
        <main class="col-md-12">
            <template v-if="activo == 0">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-danger">
                        <div class="panel-heading" style="text-align: center">Seleccionar los documentos  que entregará el encargado del procedimiento</div>

                    </div>
                </div>
            </div>
            </template>
            <template v-if="activo == 1">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-success">
                            <div class="panel-heading" style="text-align: center">los documentos  que entregará el encargado del procedimiento</div>

                        </div>
                    </div>
                </div>
            </template>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="text-align: center"><p>Modulo 1</p></div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="col-md-8">
                                <p style="font-size: 16px;">a) El estado de las acciones de las revisiones por la dirección previas.<br>
                                    <br/>
                                </p>
                            </div>
                            <div class="col-md-2" >
                                <input type="radio" style="transform: scale(2);" id="uno" value="1" v-model="encargado.doc1">
                                <label for="uno" style="font-size: 20px;">  . No   </label>

                            </div>
                            <div class="col-md-2" >

                                <input type="radio" id="dos" style="transform: scale(2);" value="2" v-model="encargado.doc1">
                                <label for="dos" style="font-size: 20px;">. Si</label>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="text-align: center"><p>Modulo 2</p></div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="col-md-8 ">
                                <p><b>b) Los cambios en:</b> <br> 1) Las cuestiones externas e internas que sean pertinentes
                                    al sistema  de gestión ambiental.
                                    <br/>
                                </p>
                            </div>
                            <div class="col-md-2" >
                                <input type="radio" style="transform: scale(2);" id="tres" value="1" v-model="encargado.doc2">
                                <label for="tres" style="font-size: 20px;">  . No   </label>

                            </div>
                            <div class="col-md-2" >

                                <input type="radio" id="cuatro" style="transform: scale(2);" value="2" v-model="encargado.doc2">
                                <label for="cuatro" style="font-size: 20px;">. Si</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="col-md-8 ">
                                <p>2) Las necesidades y expectativas de las partes interesadas , incluidos
                                    los requisitos legales y otros requisitos.

                                </p>
                            </div>
                            <div class="col-md-2" >
                                <input type="radio" style="transform: scale(2);" id="cinco" value="1" v-model="encargado.doc3">
                                <label for="cinco" style="font-size: 20px;">  . No   </label>

                            </div>
                            <div class="col-md-2" >
                                <input type="radio" id="seis" style="transform: scale(2);" value="2" v-model="encargado.doc3">
                                <label for="seis" style="font-size: 20px;">. Si</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="col-md-8">
                                <p>3) Sus aspectos ambientales  significativos.<br>
                                    <br/>
                                </p>
                            </div>
                            <div class="col-md-2" >
                                <input type="radio" style="transform: scale(2);" id="siete" value="1" v-model="encargado.doc4">
                                <label for="siete" style="font-size: 20px;">  . No   </label>

                            </div>
                            <div class="col-md-2" >
                                <input type="radio" id="ocho" style="transform: scale(2);" value="2" v-model="encargado.doc4">
                                <label for="ocho" style="font-size: 20px;">. Si</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="col-md-8">
                                <p>4) Los riesgos y oportunidades<br>
                                    <br/>
                                </p>
                            </div>
                            <div class="col-md-2" >
                                <input type="radio" style="transform: scale(2);" id="nueve" value="1" v-model="encargado.doc5">
                                <label for="nueve" style="font-size: 20px;">  . No   </label>

                            </div>
                            <div class="col-md-2" >
                                <input type="radio" id="diez" style="transform: scale(2);" value="2" v-model="encargado.doc5">
                                <label for="diez" style="font-size: 20px;">. Si</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="text-align: center"><p>Modulo 3</p></div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="col-md-8 ">
                                <p> <b>c) El grado en que se han logrado los objetivos ambientales.</b>
                                    <br/>
                                    1) Objetivos ambientales del S. de G. A.
                                </p>
                            </div>
                            <div class="col-md-2" >
                                <input type="radio" style="transform: scale(2);" id="once" value="1" v-model="encargado.doc6">
                                <label for="once" style="font-size: 20px;">  . No   </label>

                            </div>
                            <div class="col-md-2" >
                                <input type="radio" id="doce" style="transform: scale(2);" value="2" v-model="encargado.doc6">
                                <label for="doce" style="font-size: 20px;">. Si</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="col-md-8 ">
                                <p>
                                    2) Programa de G. A.
                                </p>
                            </div>
                            <div class="col-md-2" >
                                <input type="radio" style="transform: scale(2);" id="trece" value="1" v-model="encargado.doc7">
                                <label for="trece" style="font-size: 20px;">  . No   </label>

                            </div>
                            <div class="col-md-2" >
                                <input type="radio" id="catorce" style="transform: scale(2);" value="2" v-model="encargado.doc7">
                                <label for="catorce" style="font-size: 20px;">. Si</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="text-align: center"><p>Modulo 4</p></div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="col-md-8 ">
                                <p> <b>d) La información sobre el desempeño ambiental de la organización,
                                        incluidas las tendencias relativas a:</b> <br>
                                    1) No conformidades y acciones correctivas.
                                </p>
                            </div>
                            <div class="col-md-2" >
                                <input type="radio" style="transform: scale(2);" id="quince" value="1" v-model="encargado.doc8">
                                <label for="quince" style="font-size: 20px;">  . No   </label>

                            </div>
                            <div class="col-md-2" >
                                <input type="radio" id="diesiseis" style="transform: scale(2);" value="2" v-model="encargado.doc8">
                                <label for="diesiseis" style="font-size: 20px;">. Si</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="col-md-8 ">
                                <p>
                                    2) Resultados de seguimiento y medición.
                                </p>
                            </div>
                            <div class="col-md-2" >
                                <input type="radio" style="transform: scale(2);" id="diesisiete" value="1" v-model="encargado.doc9">
                                <label for="diesisiete" style="font-size: 20px;">  . No   </label>

                            </div>
                            <div class="col-md-2" >
                                <input type="radio" id="diesiocho" style="transform: scale(2);" value="2" v-model="encargado.doc9">
                                <label for="diesiocho" style="font-size: 20px;">. Si</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="col-md-8">
                                <p>
                                    3) Cumplimiento de los requisitos legales y otros requisitos.
                                </p>
                            </div>
                            <div class="col-md-2" >
                                <input type="radio" style="transform: scale(2);" id="diesinueve" value="1" v-model="encargado.doc10">
                                <label for="diesinueve" style="font-size: 20px;">  . No   </label>

                            </div>
                            <div class="col-md-2" >
                                <input type="radio" id="veinte" style="transform: scale(2);" value="2" v-model="encargado.doc10">
                                <label for="veinte" style="font-size: 20px;">. Si</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="col-md-8 ">
                                <p>
                                    4)Resultados de las auditorias.
                                </p>
                            </div>
                            <div class="col-md-2" >
                                <input type="radio" style="transform: scale(2);" id="veintiuno" value="1" v-model="encargado.doc11">
                                <label for="veintiuno" style="font-size: 20px;">  . No   </label>

                            </div>
                            <div class="col-md-2" >
                                <input type="radio" id="veintidos" style="transform: scale(2);" value="2" v-model="encargado.doc11">
                                <label for="veintidos" style="font-size: 20px;">. Si</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="text-align: center"><p>Modulo 5</p></div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="col-md-8 ">
                                <p>
                                    e)Adecuación de los recursos .
                                </p>
                            </div>
                            <div class="col-md-2" >
                                <input type="radio" style="transform: scale(2);" id="veintitres" value="1" v-model="encargado.doc12">
                                <label for="veintitres" style="font-size: 20px;">  . No   </label>

                            </div>
                            <div class="col-md-2" >
                                <input type="radio" id="veinticuatro" style="transform: scale(2);" value="2" v-model="encargado.doc12">
                                <label for="veinticuatro" style="font-size: 20px;">. Si</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="text-align: center"><p>Modulo 6</p></div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="col-md-8 ">
                                <p>
                                    f)Las comunicaciones pertinentes de las partes interesadas, incluidas las quejas.
                                </p>
                            </div>
                            <div class="col-md-2" >
                                <input type="radio" style="transform: scale(2);" id="veinticinco" value="1" v-model="encargado.doc13">
                                <label for="veinticinco" style="font-size: 20px;">  . No   </label>

                            </div>
                            <div class="col-md-2" >
                                <input type="radio" id="veintiseis" style="transform: scale(2);" value="2" v-model="encargado.doc13">
                                <label for="veintiseis" style="font-size: 20px;">. Si</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="text-align: center"><p>Modulo 7</p></div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="col-md-8 ">
                                <p>
                                    g)Las oportunidades de mejora continua.
                                </p>
                            </div>
                            <div class="col-md-2" >
                                <input type="radio" style="transform: scale(2);" id="veintisiete" value="1" v-model="encargado.doc14">
                                <label for="veintisiete" style="font-size: 20px;">  . No   </label>

                            </div>
                            <div class="col-md-2" >
                                <input type="radio" id="veintiocho" style="transform: scale(2);" value="2" v-model="encargado.doc14">
                                <label for="veintiocho" style="font-size: 20px;">. Si</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-4">


                    <template v-if="encargado.doc1   != 0 &&
                      encargado.doc2   != 0 &&
                       encargado.doc3   != 0 &&
                        encargado.doc4   != 0 &&
                         encargado.doc5   != 0 &&
                          encargado.doc6   != 0 &&
                           encargado.doc7   != 0 &&
                            encargado.doc8   != 0 &&
                             encargado.doc9   != 0 &&
                              encargado.doc10   != 0 &&
                               encargado.doc11   != 0 &&
                                encargado.doc12   != 0 &&
                                 encargado.doc13   != 0 &&
                                  encargado.doc14   != 0 ">
                        <template v-if="activo == 0">
                            <button  class="btn btn-success btn-lg btn-block" v-on:click="Registrar_dat();" >Documentación para autorizar</button>
                        </template>
                        <template v-if="activo == 1">
                           {{-- <button  class="btn btn-warning btn-lg btn-block" v-on:click="Modificar_dat();" >Modificar Documentación para autorizar</button>
--}}
                        </template>
                        </template>


                    <p><br/></p>
                </div>
            </div>
        </main>
        <div  class="modal" :class="{mostrar:modal}" >
            <div class="modal-dialog ">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" @click="cerrarModal_enviar();">&times;</button>
                        <h4 class="modal-title" style=" text-align: center;">Notificación de Registro</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <h5  style="text-align: justify">¿ La documentación seleccionada de entregar es corrrecta?</h5>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" @click="cerrarModal_enviar();">Cerrar</button>
                            <button type="button" class="btn btn-success" @click="estado_guardar=true,guardar_enviar();" :disabled="estado_guardar">Aceptar</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div  class="modal" :class="{mostrar:modal_mod}" >
            <div class="modal-dialog ">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" @click="cerrarModal_mod_enviar();">&times;</button>
                        <h4 class="modal-title" style=" text-align: center;">Notificación de Modificación Registro</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <h5  style="text-align: justify">¿ La documentación seleccionada de entregar es correcta?</h5>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" @click="cerrarModal_mod_enviar();">Cerrar</button>
                            <button type="button" class="btn btn-success" @click="guardar_enviar_mod();" :disabled="estadoguardar">Aceptar</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        new Vue({
            el:"#reg_doc",

            data(){
                return {
                    //objeto donde se va a guardar los datos de un procedimiento
                    encargado:{
                        id_encargado:0,
                        id_periodo_amb:0,
                        doc1:0,
                        doc2:0,
                        doc3:0,
                        doc4:0,
                        doc5:0,
                        doc6:0,
                        doc7:0,
                        doc8:0,
                        doc9:0,
                        doc10:0,
                        doc11:0,
                        doc12:0,
                        doc13:0,
                        doc14:0,

                    },
                    modal:0,
                    modal_mod:0,
                    estado_guardar:false,
                      activaciones:[],
                    documentacion:[],
                    activo:0,





                }
            },
            methods:{
                async Documentacion() {
                    //llamar datos al controlador
                    const contar = await axios.get('/ambiental/estado_registro_encargado/{{$id_periodo}}/{{$id_encargado}}');
                    this.activaciones = contar.data;
                    this.activo = this.activaciones;
                    if(this.activo == 0){
                        this.encargado.doc1=0;
                        this.encargado.doc2=0;
                        this.encargado.doc3=0;
                        this.encargado.doc4=0;
                        this.encargado.doc5=0;
                        this.encargado.doc6=0;
                        this.encargado.doc7=0;
                        this.encargado.doc8=0;
                        this.encargado.doc9=0;
                        this.encargado.doc10=0;
                        this.encargado.doc11=0;
                        this.encargado.doc12=0;
                        this.encargado.doc13=0;
                        this.encargado.doc14=0;

                    }else{
                        const documentacion = await axios.get('/ambiental/ver_documentacion_encargado/{{$id_encargado}}');
                        this.documentacion = documentacion.data;
                        this.encargado.doc1=this.documentacion[0].solic_estado_acc_m1;
                        this.encargado.doc2=this.documentacion[0].solic_cuestion_ambas_per_m2;
                        this.encargado.doc3=this.documentacion[0].solic_necesidades_espectativas_m2;
                        this.encargado.doc4=this.documentacion[0].solic_aspecto_ambiental_m2;
                        this.encargado.doc5=this.documentacion[0].solic_riesgo_oportu_m2;
                        this.encargado.doc6=this.documentacion[0].solic_grado_objetivo_m3;
                        this.encargado.doc7=this.documentacion[0].solic_programa_gestion_m3;
                        this.encargado.doc8=this.documentacion[0].solic_noconformid_correctivas_m4;
                        this.encargado.doc9=this.documentacion[0].solic_resu_seg_med_m4;
                        this.encargado.doc10=this.documentacion[0].solic_cumplimiento_req_m4;
                        this.encargado.doc11=this.documentacion[0].solic_resultado_audi_m4;
                        this.encargado.doc12=this.documentacion[0].solic_adecuacion_recurso_m5;
                        this.encargado.doc13=this.documentacion[0].solic_comunicacion_pertinente_m6;
                        this.encargado.doc14=this.documentacion[0].solic_oportunidades_mejora_m7;

                    }




                },
                //meetodo para mostrar tabla
                async  Registrar_dat(){
                    this.estado_guardar=false;
                    this.modal=1;

                },
                async  Modificar_dat(){
                    this.estado_guardar=false;
                    this.modal_mod=1;

                },
                async  cerrarModal_enviar(){
                    this.modal=0;

                },
                async  cerrarModal_mod_enviar(){
                    this.modal_mod=0;

                },

                async  guardar_enviar(){
                    this.estado_guardar=true;
                    const resultado=await axios.post('/ambiental/guardar_dat_doc/{{$id_periodo}}/{{$id_encargado}}',this.encargado);
                    this.Documentacion();
                    this.modal=0;
                    swal({
                        position: "top",
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 3500
                    });

                },
                async guardar_enviar_mod(){
                    this.estado_guardar=true;
                    const resultado=await axios.post('/ambiental/modificar_guardar_dat_doc/{{$id_periodo}}/{{$id_encargado}}',this.encargado);
                    this.Documentacion();
                    this.modal_mod=0;
                    swal({
                        position: "top",
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            },
            //funciones para cuando se cargue la vista
            async created(){
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
@extends('layouts.app')
@section('title', 'Titulación')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <p>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                    <a href="{{url("/titulacion/faltante_datos_alumno/".$id_carrera)}}">Estudiantes faltante entregar PDF en el centro de información</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span>Datos Personales del Estudiante Autorizados</span>
                </p>
                <br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"> Datos Personales del Estudiante<br>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        {{--
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        --}}
        <div id="reg_datos">

            <div class="panel panel-success">
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <div class="form-group">
                                <h3 for="nombre_proyecto">Correo electronico<b style="color:red; font-size:23px;">*</b></h3>
                                <h4 style="color: blue">@{{ docu.correo_electronico }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <div class="form-group">
                                <h3 for="nombre_proyecto">Fecha de emisión del certificado<b style="color:red; font-size:23px;">*</b></h3>
                                <h4 style="color: blue">@{{ docu.fecha_emision_certificado }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <div class="form-group">
                                <h3 for="nombre_proyecto">Fecha de registro del trámite de titulación<b style="color:red; font-size:23px;">*</b></h3>
                                <h4 style="color: blue">@{{ docu.fecha_reg_tramite_titulacion }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1 ">
                            <div class="form-group">
                                <h3 for="nombre_proyecto" >Fecha de pago de derecho de titulación<b style="color:red; font-size:23px;">*</b></h3>
                                <h4 style="color: blue">@{{ docu.fecha_pag_derechos_titulacion }}</h4>

                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <div class="form-group">
                                <h3 for="nombre_proyecto">Número de  cuenta<b style="color:red; font-size:23px;">*</b></h3>
                                <h4 style="color: blue">@{{ docu.no_cuenta }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3 for="nombre_proyecto">¿ Eres estudiante regular o de revalidación ?<b style="color:red; font-size:23px;">*</b></h3>
                                <template v-for="tipo_estudiante in tipos_estudiantes">
                                    <h4 style="color: blue;" v-if="docu.id_tipo_estudiante == tipo_estudiante.id_tipo_estudiante" >
                                        @{{tipo_estudiante.tipo_estudiante }}
                                    </h4>
                                </template>


                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <hr style=" height: 2px;
  background-color: lightblue;">



                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <p style="color: #942a25"> Ingresa tu nombre y apellidos como aparecen en tu acta de nacimiento, sin acentos o con acentos.</p>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-1">
                                <div class="form-group">
                                    <h3 for="nombre_proyecto">Nombre<b style="color:red; font-size:23px;">*</b></h3>
                                    <h4 style="color: blue">@{{ docu.nombre_al }}</h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <h3 for="nombre_proyecto">Apellido paterno<b style="color:red; font-size:23px;">*</b></h3>
                                    <h4 style="color: blue">@{{ docu.apaterno }}</h4>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <h3 for="nombre_proyecto">Apellido materno<b style="color:red; font-size:23px;">*</b></h3>
                                    <h4 style="color: blue">@{{ docu.amaterno }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <div class="form-group">
                                <h3 for="nombre_proyecto">Curp<b style="color:red; font-size:23px;">*</b></h3>
                                <h4 style="color: blue">@{{ docu.curp_al }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3 for="nombre_proyecto">Carrera<b style="color:red; font-size:23px;">*</b></h3>
                                <template v-for="carrera in carreras">
                                    <h4 style="color: blue;" v-if="docu.id_carrera == carrera.id_carrera" >
                                        @{{carrera.nombre }}
                                    </h4>
                                </template>


                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3 for="personal">Plan de Estudio<b style="color:red; font-size:23px;">*</b></h3>
                                <template v-for="plan in planes_estudios">
                                    <h4 style="color:blue;" v-if="docu.id_plan_estudio == plan.id_plan_estudio" >
                                        @{{plan.plan_estudio }}
                                    </h4>
                                </template>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <div class="form-group">
                                <h3 for="nombre_proyecto">Promedio General del TESVB<b style="color:red; font-size:23px;">*</b></h3>
                                <h4 style="color: blue; " >@{{ docu.promedio_general_tesvb }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h4 for="personal">¿ Reprobaste alguna materia ?<b style="color:red; font-size:23px;">*</b></h4>
                                <template v-for="responder in responder">
                                    <h4 style="color: blue" v-if="docu.reprobacion_mat == responder.id_respuesta" >
                                        @{{ responder.descripcion }}
                                    </h4>
                                </template>
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <div class="form-group">
                                <h3 for="nombre_proyecto">Fecha de ingreso al TESVB<b style="color:red; font-size:23px;">*</b></h3>
                                <h4 style="color: blue; " >@{{ docu.fecha_ingreso_tesvb }}</h4>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <div class="form-group">
                                <h3 for="nombre_proyecto">Fecha de egreso al TESVB<b style="color:red; font-size:23px;">*</b></h3>
                                <h4 style="color: blue; " >@{{ docu.fecha_egreso_tesvb }}</h4>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h4 for="personal">Número de semestres cursados<b style="color:red; font-size:23px;">*</b></h4>
                                <template v-for="numeros_sem in numeros_semestres">
                                    <h4 style="color: blue" v-if="docu.id_semestre == numeros_sem.id_semestre" >
                                        @{{numeros_sem.id_semestre }}
                                    </h4>
                                </template>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h4 for="personal">Opción de titulación<b style="color:red; font-size:23px;" >*</b></h4>
                                <template v-for="opcion in opciones_titulacion">
                                    <h4 style="color: blue" v-if="docu.id_opcion_titulacion == opcion.id_opcion_titulacion" >
                                        @{{ opcion.opcion_titulacion }}
                                    </h4>
                                </template>

                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <h3 for="domicilio3">Nombre del proyecto <b style="color:red; font-size:23px;">*</b></h3>
                                <h4 style="color: blue; " >@{{ docu.nom_proyecto }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <hr style=" height: 2px;
  background-color: lightblue;">
                        <h4 style="text-align: center; color: #942a25; ">Dirección</h4>


                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <h3 for="domicilio3">Calle<b style="color:red; font-size:23px;">*</b></h3>
                            <h4 style="color: blue; " >@{{ docu.calle_domicilio }}</h4>
                        </div>
                        <div class="col-md-3">
                            <h3 for="domicilio3">Número<b style="color:red; font-size:23px;">*</b></h3>
                            <h4 style="color: blue; " >@{{ docu.numero_domicilio }}</h4>

                        </div>
                        <div class="col-md-3">
                            <h3 for="domicilio3">Colonia o comunidad<b style="color:red; font-size:23px;">*</b></h3>

                            <h4 style="color: blue; " >@{{ docu.colonia_domicilio }}</h4>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <div class="form-group">
                                <h3 for="personal">Entidad Federativa<b style="color:red; font-size:23px;">*</b></h3>
                                <template v-for="estado in estados">
                                    <h4 style="color: blue" v-if="docu.entidad_federativa == estado.id_estado" >
                                        @{{ estado.nombre_estado }}
                                    </h4>
                                </template>
                            </div>
                        </div>
                        <div class="col-md-3 col-md-offset-1">
                            <div class="form-group">
                                <h3 for="personal">Municipio o Ciudad<b style="color:red; font-size:23px;">*</b></h3>
                                <template v-for="municipio in municipios">
                                    <h4 style="color: blue" v-if="docu.municipio_domicilio == municipio.id_municipio" >
                                        @{{ municipio.nombre_municipio }}
                                    </h4>
                                </template>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <hr style=" height: 2px;
  background-color: lightblue;">



                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1 ">
                            <h3 for="exampleInputEmail1">Telefono<b style="color:red; font-size:23px;">*</b></h3>
                            <h4 style="color: blue; " >@{{ docu.telefono }}</h4>

                        </div>

                        <div class="col-md-3 col-md-offset-1">
                            <div class="form-group">
                                <h3 for="nombre_proyecto">Jefe de división<b style="color:red; font-size:23px;">*</b></h3>
                                <h4 style="color: blue; " >@{{ docu.nombre_jefe }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <h3 for="domicilio3">Nombre de la empresa donde se realizó la Residencia Profesional <b style="color:red; font-size:23px;">*</b> </h3>
                                <h4 style="color: blue; " >@{{ docu.nom_empresa }}</h4>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <div class="form-group">
                                <h3 for="personal">Red Social que utilizas habitualmente</h3>
                                <template v-for="red_social in redes_sociales">
                                    <h4 style="color: blue" v-if="docu.id_red_social == red_social.id_red_social" >
                                        @{{ red_social.red_social }}
                                    </h4>
                                </template>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <h3 for="nombre_proyecto">¿Cuál es tu nombre de usuario de la red social </h3>
                                <h4 style="color: blue; " >@{{ docu.nombre_usuario_red }}</h4>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <h3 for="personal">Tipo de donación<b style="color:red; font-size:23px;">*</b></h3>
                                <template v-for="donacion in tipos_donaciones">
                                    <h4 style="color: blue" v-if="docu.id_tipo_donacion == donacion.id_tipo_donacion" >
                                        @{{ donacion.tipo_donacion }}
                                    </h4>
                                </template>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-2 col-md-offset-1">
                            <div class="form-group">
                                <h3 for="personal">Presentas alguna discapacidad<b style="color:red; font-size:23px;">*</b></h3>
                                <template v-for="responder in responder">
                                    <h4 style="color: blue" v-if="docu.presenta_discapacidad == responder.id_respuesta" >
                                        @{{ responder.descripcion }}
                                    </h4>
                                </template>

                            </div>
                        </div>
                        <template v-if="docu.presenta_discapacidad   == 1">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <h3 for="nombre_proyecto">¿ Cual ?<b style="color:red; font-size:23px;">*</b></h3>
                                    <h4 style="color: blue; " >@{{ docu.discapacidad_que_presenta }}</h4>
                                </div>
                            </div>
                        </template>
                        <div class="col-md-2 ">
                            <div class="form-group">
                                <h3 for="personal">Hablas alguna lengua indígena<b style="color:red; font-size:23px;">*</b></h3>
                                <template v-for="responder in responder">
                                    <h4 style="color: blue" v-if="docu.lengua_indigena == responder.id_respuesta" >
                                        @{{ responder.descripcion }}
                                    </h4>
                                </template>
                            </div>
                        </div>
                        <template v-if="docu.lengua_indigena   == 1">
                            <div class="col-md-3">
                                <h3 for="nombre_proyecto">¿ Cual ?<b style="color:red; font-size:23px;">*</b></h3>
                                <h4 style="color: blue; " >@{{ docu.habla_lengua_indigena }}</h4>

                            </div>
                        </template>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <div class="form-group">
                                <h3 for="personal">Nacionalidad<b style="color:red; font-size:23px;">*</b></h3>
                                <template v-for="nacionalidad in nacionalidades">
                                    <h4 style="color: blue" v-if="docu.id_nacionalidad == nacionalidad.id_nacionalidad" >
                                        @{{ nacionalidad.nacionalidad }}
                                    </h4>
                                </template>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3 for="domicilio3">Fecha de ingreso a la preparatoria o bachillerato que estudiaste <b style="color:red; font-size:23px;">*</b> </h3>
                                <h4 style="color: blue; " >@{{ docu.fecha_ingreso_preparatoria }}</h4>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3 for="domicilio3">Fecha de egreso a la preparatoria o bachillerato que estudiaste <b style="color:red; font-size:23px;">*</b> </h3>
                                <h4 style="color: blue; " >@{{ docu.fecha_egreso_preparatoria }}</h4>
                            </div>

                        </div>
                    </div>

                    <template v-if="docu.mencion_honorifica   == 1">
                        <div class="row">
                            <div class="col-md-5 col-md-offset-4">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h3 class="panel-title text-center">Con Mención honorifica<br>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-if="docu.mencion_honorifica   == 2">
                        <div class="row">
                            <div class="col-md-5 col-md-offset-4">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h3 class="panel-title text-center">Sin Mención honorifica<br>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <hr style=" height: 5px;
  background-color: black;">
                            <p></p>
                        </div>
                    </div>


                    <template v-if="docu.id_tipo_donaciones  == 2">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-5">
                                <h3 style="color: #942a25">Donacion de Equipo y/o Material didáctico</h3>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <p><br></p>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Nombre del equipo</th>
                                        <th>Descripcion del equipo</th>
                                        <th>folio fiscal</th>
                                        <th>Tienda</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="computo in computo" :key="computo.id_equipo_computo">
                                        <td>@{{ computo.nombre_equipo }}</td>
                                        <td>@{{ computo.descripcion }}</td>
                                        <td>@{{ computo.folio_fiscal }}</td>
                                        <td>@{{ computo.nombre_tienda }}</td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <hr style=" height: 5px;
  background-color: black;">
                                <p></p>
                            </div>
                        </div>

                    </template>
                    <div v-if="docu.id_tipo_donaciones  == 1">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-4">
                                <h3 style="color: #942a25">Donacion de Libros</h3>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <p><br></p>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Autor</th>
                                        <th>Editorial</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="libro in libros" :key="libro.id_titulo_libro">
                                        <td>@{{ libro.titulo }}</td>
                                        <td>@{{ libro.autor }}</td>
                                        <td>@{{ libro.editorial }}</td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <hr style=" height: 5px;
  background-color: black;">
                                <p></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>





        </div>

    </main>

    <script>
        new Vue({
            el:"#reg_datos",

            data(){
                return {

                    //lo inicialisamos el array
                    datos:[],
                    registro_hecho:[],
                    carreras:[],
                    planes_estudios:[],
                    opciones_titulacion:[],
                    respuestas:[],
                    numeros_semestres:[],
                    estados:[],
                    municipios:[],
                    tipos_donaciones:[],
                    responder:[],
                    contar_formulario:0,
                    estado_guardar_datos:false,
                    datos_registrados:[],
                    libros:[],
                    computo:[],
                    contar_libro:[],
                    contar_computo:[],
                    tipos_estudiantes:[],
                    redes_sociales:[],
                    nacionalidades:[],
                    estudios_antecedentes:[],


                    docu:{
                        id_reg_dato_alum: 0,
                        correo_electronico:"",
                        id_alumno:0,
                        fecha_emision_certificado:"",
                        fecha_reg_tramite_titulacion:"",
                        fecha_pag_derechos_titulacion:"",
                        no_cuenta:"",
                        id_tipo_estudiante:0,
                        nombre_al:"",
                        apaterno:"",
                        amaterno:"",
                        curp_al:"",
                        id_carrera:0,
                        id_semestre:0,
                        id_plan_estudio:0,
                        promedio_general_tesvb:0,
                        reprobacion_mat:0,
                        fecha_ingreso_tesvb:"",
                        fecha_egreso_tesvb:"",
                        num_sem_cursados:"",
                        id_opcion_titulacion:0,
                        nom_proyecto:"",
                        calle_domicilio:"",
                        numero_domicilio:"",
                        colonia_domicilio:"",
                        municipio_domicilio:0,
                        entidad_federativa:0,
                        telefono:"",
                        id_jefe_division:"",
                        nombre_jefe:"",
                        nom_empresa:"",
                        id_red_social:0,
                        nombre_usuario_red:"",
                        id_tipo_donacion:"",
                        id_tipo_donaciones:"",
                        presenta_discapacidad:0,
                        discapacidad_que_presenta:"",
                        lengua_indigena:0,
                        habla_lengua_indigena:"",
                        mencion_honorifica:0,
                        id_nacionalidad:0,
                        fecha_ingreso_preparatoria:"",
                        fecha_egreso_preparatoria:"",
                        id_tipo_estudio_antecedente:0,
                        id_estado_enviado:0,
                        comentario:"",


                    },
                    libro:{
                        titulo:"",
                        autor:"",
                        editorial:"",
                    },

                    lib:{
                        id_titulo_libro:0,
                        id_reg_dato_alum: 0,
                        titulo:"",
                        autor:"",
                        editorial:"",
                    },
                    comput:{
                        nombre_equipo :"",
                        descripcion :"",
                        folio_fiscal :"",
                        nombre_tienda :"",
                    },
                    comp:{
                        id_equipo_computo:0,
                        nombre_equipo :"",
                        descripcion :"",
                        folio_fiscal :"",
                        nombre_tienda :"",
                    },

                    id_tipo_descuento:0,
                    id_estado:0,
                    modal_agregar_libro:0,
                    modal_modificar_libro:0,
                    modal_agregar_computo:0,
                    modal_modificar_computo:0,
                    estado_guardar_libro:false,
                    estado_guardar_computo:false,
                    id_titulo_libro:0,
                    modal_eliminar_libro:0,
                    modal_eliminar_computo:0,
                    modal_enviar_datos:0,
                    estado_guardar_envio:false,
                    modal_enviar_moficaciones:0,
                    modal_autorizar_datos:0,
                    estado_guardar_envio_mod:false,
                    estado_guardar_autorizar:false,
                    comentario_modificacion:"",
                    modal_enviar_aurizacion:0,

                }
            },
            methods: {
                //meetodo para mostrar tabla
                async Documentacion() {
                    //llamar datos al controlador
                    swal({
                        title: "",
                        text: "Cargando...",
                        buttons: false,
                        closeOnClickOutside: false,
                        timer: 10000,
                        //icon: "success"
                    });

                    const contar = await axios.get('/titulacion/estado_reg_personales/{{$id_alumno}}');
                    this.registro_hecho = contar.data;
                    if(this.registro_hecho == 0){

                    }else{
                        const responder = await axios.get('/ambiental/respuestas/');
                        this.responder = responder.data;
                        const carreras = await axios.get('/titulacion/careras_tesvb/');
                        this.carreras = carreras.data;
                        const planes_estudios = await axios.get('/titulacion/planes_estudio_tesvb/');
                        this.planes_estudios = planes_estudios.data;
                        const respuestas = await axios.get('/titulacion/respuestas_tesvb/');
                        this.respuestas = respuestas.data;
                        const num_semestres = await axios.get('/titulacion/numeros_semestres_tesvb/');
                        this.numeros_semestres = num_semestres.data;
                        const opciones_titulacion = await axios.get('/titulacion/opciones_titulacion_tesvb/');
                        this.opciones_titulacion = opciones_titulacion.data;
                        const estados = await axios.get('/titulacion/entidades_federativas/');
                        this.estados = estados.data;
                        const datos = await axios.get('/titulacion/datos_personales/{{$id_alumno}}');
                        this.datos= datos.data;

                        const tipos_donaciones = await axios.get('/titulacion/tipo_donaciones/'+this.datos.id_tipo_descuento);
                        this.tipos_donaciones= tipos_donaciones.data;
                        const tipos_estudiantes= await axios.get('/titulacion/tipos_estudiantes/');
                        this.tipos_estudiantes= tipos_estudiantes.data;
                        const nacionalidades = await axios.get('/titulacion/nacionalidades/');
                        this.nacionalidades= nacionalidades.data;
                        const redes_sociales= await axios.get('/titulacion/tipos_redes_sociales/');
                        this.redes_sociales= redes_sociales.data;
                        const antecedentes_estudios = await axios.get('/titulacion/antecedentes_estudios/');
                        this.estudios_antecedentes = antecedentes_estudios.data;

                        const datos_registrados = await axios.get('/titulacion/ver_datos_alumno_registrados/{{$id_alumno}}');
                        this.datos_registrados= datos_registrados.data;
                        this.docu.id_reg_dato_alum= this.datos_registrados[0].id_reg_dato_alum;
                        this.docu.correo_electronico= this.datos_registrados[0].correo_electronico;
                        this.docu.id_alumno= this.datos_registrados[0].id_alumno;
                        this.docu.fecha_emision_certificado= this.datos_registrados[0].fecha_emision_certificado;
                        this.docu.fecha_reg_tramite_titulacion= this.datos_registrados[0].fecha_reg_tramite_titulacion;
                        this.docu.fecha_pag_derechos_titulacion= this.datos_registrados[0].fecha_pag_derechos_titulacion;
                        this.docu.no_cuenta= this.datos_registrados[0].no_cuenta;
                        this.docu.id_tipo_estudiante= this.datos_registrados[0].id_tipo_estudiante;
                        this.docu.nombre_al= this.datos_registrados[0].nombre_al;
                        this.docu.apaterno= this.datos_registrados[0].apaterno;
                        this.docu.amaterno= this.datos_registrados[0].amaterno;
                        this.docu.curp_al= this.datos_registrados[0].curp_al;
                        this.docu.id_carrera= this.datos_registrados[0].id_carrera;
                        this.docu.id_semestre= this.datos_registrados[0].id_semestre;
                        this.docu.id_plan_estudio= this.datos_registrados[0].id_plan_estudio;
                        this.docu.promedio_general_tesvb= this.datos_registrados[0].promedio_general_tesvb;
                        this.docu.reprobacion_mat= this.datos_registrados[0].reprobacion_mat;
                        this.docu.fecha_ingreso_tesvb= this.datos_registrados[0].fecha_ingreso_tesvb;
                        this.docu.fecha_egreso_tesvb= this.datos_registrados[0].fecha_egreso_tesvb;
                        this.docu.num_sem_cursados= this.datos_registrados[0].num_sem_cursados;
                        this.docu.id_opcion_titulacion= this.datos_registrados[0].id_opcion_titulacion;
                        this.docu.nom_proyecto= this.datos_registrados[0].nom_proyecto;
                        this.docu.calle_domicilio= this.datos_registrados[0].calle_domicilio;
                        this.docu.numero_domicilio= this.datos_registrados[0].numero_domicilio;
                        this.docu.colonia_domicilio= this.datos_registrados[0].colonia_domicilio;
                        this.docu.municipio_domicilio= this.datos_registrados[0].municipio_domicilio;
                        this.docu.entidad_federativa= this.datos_registrados[0].entidad_federativa;
                        const municipios = await axios.get('/titulacion/municipios/'+this.docu.entidad_federativa);
                        this.municipios = municipios.data;
                        this.docu.telefono= this.datos_registrados[0].telefono;
                        this.docu.id_jefe_division= this.datos_registrados[0].id_jefe_division;
                        this.docu.nombre_jefe= this.datos_registrados[0].nombre;
                        this.docu.nom_empresa= this.datos_registrados[0].nom_empresa;
                        this.docu.id_red_social= this.datos_registrados[0].id_red_social;
                        this.docu.nombre_usuario_red= this.datos_registrados[0].nombre_usuario_red;
                        this.docu.id_tipo_donacion= this.datos_registrados[0].id_tipo_donacion;
                        this.docu.id_tipo_donaciones= this.datos_registrados[0].id_tipo_donacion;
                        this.docu.presenta_discapacidad= this.datos_registrados[0].presenta_discapacidad;
                        this.docu.discapacidad_que_presenta= this.datos_registrados[0].discapacidad_que_presenta;
                        this.docu.lengua_indigena= this.datos_registrados[0].lengua_indigena;
                        this.docu.habla_lengua_indigena= this.datos_registrados[0].habla_lengua_indigena;
                        this.docu.mencion_honorifica= this.datos_registrados[0].mencion_honorifica;
                        this.docu.id_nacionalidad= this.datos_registrados[0].id_nacionalidad;
                        this.docu.fecha_egreso_preparatoria= this.datos_registrados[0].fecha_egreso_preparatoria;
                        this.docu.fecha_ingreso_preparatoria= this.datos_registrados[0].fecha_ingreso_preparatoria;
                        this.docu.id_tipo_estudio_antecedente= this.datos_registrados[0].id_antecedente_estudio;
                        this.docu.id_estado_enviado= this.datos_registrados[0].id_estado_enviado;
                        this.docu.comentario= this.datos_registrados[0].comentario;

                        if( this.docu.id_tipo_donaciones == 1){
                            this.libross();
                        }
                        if( this.docu.id_tipo_donaciones == 2){
                            this.computos();
                        }
                    }

                },
                async libross(){
                    const libros = await axios.get('/titulacion/ver_libros/'+this.docu.id_reg_dato_alum);
                    this.libros = libros.data;
                    const contar = await axios.get('/titulacion/contar_libros/'+this.docu.id_reg_dato_alum);
                    this.contar_libro = contar.data;

                },
                async computos(){
                    const computo = await axios.get('/titulacion/ver_material_computo/'+this.docu.id_reg_dato_alum);
                    this.computo = computo.data;
                    const contar = await axios.get('/titulacion/contar_computo/'+this.docu.id_reg_dato_alum);
                    this.contar_computo = contar.data;

                },
                async municipios_estado(event){
                    this.id_estado=event.target.value;
                    const municipios = await axios.get('/titulacion/municipios/'+this.id_estado);
                    this.municipios = municipios.data;
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
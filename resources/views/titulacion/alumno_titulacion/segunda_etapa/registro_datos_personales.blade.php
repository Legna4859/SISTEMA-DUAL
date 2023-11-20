@extends('layouts.app')
@section('title', 'Titulación')
@section('content')

    <main class="col-md-12">


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Enviar registro de datos personales para titulación  <br>
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
            <template v-if="registro_hecho == 0 ">
                <div class="panel panel-success">
                    <div class="panel-body">

                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Correo electronico<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="correo_electronico" name="correo_electronico" type="email" v-model="docu.correo_electronico"  placeholder="Ingresa tu correo electronico" style="" :disabled="true" required/>
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <label for="nombre_proyecto">Fecha de emisión del certificado<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="fecha_emision_certificado" name="fecha_emision_certificado" type="date" v-model="docu.fecha_emision_certificado"  placeholder="Selecciona la fecha de emisión del certificado " style="" required/>
                        <p v-if="docu.fecha_emision_certificado == ''" class="alert alert-danger">
                            Este campo es obligatorio
                        </p>
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <label for="nombre_proyecto">Fecha de registro del trámite de titulación<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="fecha_reg_tramite_titulacion" name="fecha_reg_tramite_titulacion" type="date" v-model="docu.fecha_reg_tramite_titulacion"  placeholder="Selecciona la fecha de registro del trámite de titulación" style="" required/>
                            <p v-if="docu.fecha_reg_tramite_titulacion == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-1 ">
                        <div class="form-group">
                            <label for="nombre_proyecto">Fecha de pago de derecho de titulación<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="fecha_pag_derechos_titulacion" name="fecha_pag_derechos_titulacion" type="date" v-model="docu.fecha_pag_derechos_titulacion"  placeholder="Selecciona la fecha de pago de derecho de titulación" style="" required/>
                            <p v-if="docu.fecha_pag_derechos_titulacion == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <label for="nombre_proyecto">Número de  cuenta<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="no_cuenta" name="no_cuenta" type="text" v-model="docu.no_cuenta"  placeholder="Ingresa tu No. cuenta" style="" onkeyup="javascript:this.value=this.value.toUpperCase();" required/>
                            <p v-if="docu.no_cuenta == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="personal">¿ Eres estudiante ?<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.id_tipo_estudiante" >
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="tipo_estudiante in tipos_estudiantes" :value="tipo_estudiante.id_tipo_estudiante">@{{tipo_estudiante.tipo_estudiante }}</option>
                            </select>
                            <p v-if="docu.id_tipo_estudiante == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
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
                                <label for="nombre_proyecto">Nombre<b style="color:red; font-size:23px;">*</b></label>
                                <input class="form-control"  id="nombre" name="nombre" type="text" v-model="docu.nombre_al"  placeholder="Ingresa tu nombre"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                                <p v-if="docu.nombre_al == ''" class="alert alert-danger">
                                    Este campo es obligatorio
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre_proyecto">Apellido paterno<b style="color:red; font-size:23px;">*</b></label>
                                <input class="form-control"  id="apaterno" name="apaterno" type="text" v-model="docu.apaterno"  placeholder="Ingresa tu apellido paterno"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                                <p v-if="docu.apaterno == ''" class="alert alert-danger">
                                    Este campo es obligatorio
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre_proyecto">Apellido materno<b style="color:red; font-size:23px;">*</b></label>
                                <input class="form-control"  id="amaterno" name="amaterno" type="text" v-model="docu.amaterno"  placeholder="Ingresa tu apellido materno"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                                <p v-if="docu.amaterno == ''" class="alert alert-danger">
                                    Este campo es obligatorio
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Curp<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="curp" name="curp" type="text" v-model="docu.curp_al"  placeholder="Ingresa tu curp"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();" :disabled="true" required/>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="personal">Carrera<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.id_carrera" :disabled="true">
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="carrera in carreras" :value="carrera.id_carrera">@{{carrera.nombre }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="personal">Plan de Estudio<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.id_plan_estudio">
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="plan in planes_estudios" :value="plan.id_plan_estudio">@{{plan.plan_estudio }}</option>
                            </select>
                            <p v-if="docu.id_plan_estudio == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Promedio General del TESVB<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="promedio_general_tesvb" name="promedio_general_tesvb" type="number" step="any" min="0" max="100"  v-model="docu.promedio_general_tesvb"  placeholder="Ingresa tu Promedio General del TESVB"  style="text-transform:uppercase;"    required/>
                            <p v-if="docu.promedio_general_tesvb == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="personal">¿ Reprobaste alguna materia ?<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.reprobacion_mat">
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="responder in responder" :value="responder.id_respuesta">@{{ responder.descripcion }}</option>
                            </select>
                            <p v-if="docu.reprobacion_mat == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <label for="nombre_proyecto">Fecha de ingreso al TESVB<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="fecha_ingreso_tesvb" name="fecha_ingreso_tesvb" type="date" v-model="docu.fecha_ingreso_tesvb"  placeholder="Selecciona la fecha de ingreso al TESVB" style="" required/>
                            <p v-if="docu.fecha_ingreso_tesvb == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Fecha de egreso al TESVB<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="fecha_egreso_tesvb" name="fecha_egreso_tesvb" type="date" v-model="docu.fecha_egreso_tesvb"  placeholder="Selecciona la fecha de egreso al TESVB" style="" required/>
                            <p v-if="docu.fecha_egreso_tesvb == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="personal">Número de semestres cursados<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.id_semestre">
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="numeros_sem in numeros_semestres" :value="numeros_sem.id_semestre">@{{numeros_sem.id_semestre }}</option>
                                <p v-if="docu.id_semestre > 8" class="alert alert-danger">
                                    Este campo es obligatorio
                                </p>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="personal">Opción de titulación<b style="color:red; font-size:23px;" >*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.id_opcion_titulacion" :disabled="true">
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="opcion in opciones_titulacion" :value="opcion.id_opcion_titulacion">@{{ opcion.opcion_titulacion }}</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="domicilio3">Nombre del proyecto <b style="color:red; font-size:23px;">*</b></label>
                            <textarea class="form-control" id="nom_proyecto" v-model="docu.nom_proyecto" name="nom_proyecto" rows="2"  onkeyup="javascript:this.value=this.value.toUpperCase();"  required></textarea>
                            <p v-if="docu.nom_proyecto ==''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <hr style=" height: 2px;
  background-color: lightblue;">
                        <h4 style="text-align: center; color: #942a25; "> Ingresa tu Dirección</h4>


                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <label for="domicilio3">Calle<b style="color:red; font-size:23px;">*</b></label>
                        <input class="form-control"  id="calle_domicilio" name="calle_domicilio" type="text" v-model="docu.calle_domicilio" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="Ingresa la calle de tu domicilio" style="" required/>
                        <p v-if="docu.calle_domicilio ==''" class="alert alert-danger">
                            Este campo es obligatorio
                        </p>
                    </div>
                    <div class="col-md-3">
                        <label for="domicilio3">Número<b style="color:red; font-size:23px;">*</b></label>
                        <input class="form-control"  id="numero_domicilio" name="numero_domicilio" type="text" v-model="docu.numero_domicilio" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="Ingresa el número de tu domicilio" style="" required/>
                        <p v-if="docu.numero_domicilio ==''" class="alert alert-danger">
                            Este campo es obligatorio
                        </p>
                    </div>
                    <div class="col-md-3">
                        <label for="domicilio3">Colonia o comunidad<b style="color:red; font-size:23px;">*</b></label>
                        <input class="form-control"  id="colonia_domicilio" name="colonia_domicilio" type="text" v-model="docu.colonia_domicilio" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="Ingresa la colonia de tu domicilio" style="" required/>
                        <p v-if="docu.colonia_domicilio ==''" class="alert alert-danger">
                            Este campo es obligatorio
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="personal">Entidad Federativa<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.entidad_federativa" v-on:change="municipios_estado($event)" >
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="estado in estados" :value="estado.id_estado">@{{ estado.nombre_estado }}</option>
                            </select>
                            <p v-if="docu.entidad_federativa  == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="personal">Municipio o Ciudad<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.municipio_domicilio" >
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="municipio in municipios" :value="municipio.id_municipio">@{{ municipio.nombre_municipio }}</option>
                            </select>
                            <p v-if="docu.municipio_domicilio  == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>

                </div>
                        <div class="row">
                            <hr style=" height: 2px;
  background-color: lightblue;">



                        </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-1 ">
                        <label for="exampleInputEmail1">Telefono<b style="color:red; font-size:23px;">*</b></label>
                        <input type="text" class="form-control" id="telefono"  name="telefono" v-model="docu.telefono" :disabled="true" required>
                        <p v-if="docu.telefono ==''" class="alert alert-danger">
                            Este campo es obligatorio
                        </p>
                    </div>

                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Jefe de división<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="nombre_jefe" name="nombre_jefe" type="text" v-model="docu.nombre_jefe"   style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();" :disabled="true"  required/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="domicilio3">Nombre de la empresa donde se realizó la Residencia Profesional <b style="color:red; font-size:23px;">*</b> </label>
                            <textarea class="form-control" id="nom_empresa" v-model="docu.nom_empresa" name="nom_empresa" rows="2" onkeyup="javascript:this.value=this.value.toUpperCase();"    required></textarea>
                        </div>
                        <p v-if="docu.nom_empresa ==''" class="alert alert-danger">
                            Este campo es obligatorio
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="personal">Red Social que utilizas habitualmente<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.id_red_social" >
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="red_social in redes_sociales" :value="red_social.id_red_social">@{{ red_social.red_social }}</option>
                            </select>
                            <p v-if="docu.id_red_social == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_proyecto">¿Cuál es tu nombre de usuario de la red social <b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="" name="nombre_usuario_red" type="text" v-model="docu.nombre_usuario_red"       required/>
                            <p v-if="docu.nombre_usuario_red == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="personal">Tipo de donación<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.id_tipo_donacion" >
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="donacion in tipos_donaciones" :value="donacion.id_tipo_donacion">@{{ donacion.tipo_donacion }}</option>
                            </select>
                            <p v-if="docu.id_tipo_donacion == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-2 col-md-offset-1">
                        <div class="form-group">
                            <label for="personal">Presentas alguna discapacidad<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.presenta_discapacidad" >
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="responder in responder" :value="responder.id_respuesta">@{{ responder.descripcion }}</option>
                            </select>
                            <p v-if="docu.presenta_discapacidad == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <template v-if="docu.presenta_discapacidad   == 1">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre_proyecto">¿ Cual ?<b style="color:red; font-size:23px;">*</b></label>
                                <input class="form-control"  id="discapacidad_que_presenta" name="discapacidad_que_presenta" type="text" v-model="docu.discapacidad_que_presenta"   style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                                <p v-if="docu.discapacidad_que_presenta == ''" class="alert alert-danger">
                                    Este campo es obligatorio
                                </p>
                            </div>
                        </div>
                    </template>
                    <div class="col-md-2 ">
                        <div class="form-group">
                            <label for="personal">Hablas alguna lengua indígena<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.lengua_indigena" >
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="responder in responder" :value="responder.id_respuesta">@{{ responder.descripcion }}</option>
                            </select>
                            <p v-if="docu.lengua_indigena == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <template v-if="docu.lengua_indigena   == 1">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre_proyecto">¿ Cual ?<b style="color:red; font-size:23px;">*</b></label>
                                <input class="form-control"  id="habla_lengua_indigena" name="habla_lengua_indigena" type="text" v-model="docu.habla_lengua_indigena"   style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                            </div>
                            <p v-if="docu.habla_lengua_indigena == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </template>
                </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-1">
                                <div class="form-group">
                                    <label for="personal">Selecciona tu nacionalidad<b style="color:red; font-size:23px;">*</b></label>
                                    <select class="form-control"  v-validate="'required'" v-model="docu.id_nacionalidad" >
                                        <option disabled selected hidden :value="0">Selecciona una opción</option>
                                        <option v-for="nacionalidad in nacionalidades" :value="nacionalidad.id_nacionalidad">@{{ nacionalidad.nacionalidad }}</option>
                                    </select>
                                    <p v-if="docu.id_nacionalidad == 0" class="alert alert-danger">
                                        Este campo es obligatorio
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="nombre_proyecto">Fecha de ingreso a la preparatoria o bachillerato que estudiaste<b style="color:red; font-size:23px;">*</b></label>
                                    <input class="form-control"  id="fecha_ingreso_preparatoria" name="fecha_ingreso_preparatoria" type="date" v-model="docu.fecha_ingreso_preparatoria"  placeholder="Selecciona fecha de egreso de la preparatoria o bachillerato que estudiaste" style="" required/>
                                    <p v-if="docu.fecha_ingreso_preparatoria == ''" class="alert alert-danger">
                                        Este campo es obligatorio
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="nombre_proyecto">Fecha de egreso de la preparatoria o bachillerato que estudiaste<b style="color:red; font-size:23px;">*</b></label>
                                    <input class="form-control"  id="fecha_egreso_preparatoria" name="fecha_egreso_preparatoria" type="date" v-model="docu.fecha_egreso_preparatoria"  placeholder="Selecciona fecha de egreso de la preparatoria o bachillerato que estudiaste" style="" required/>
                                    <p v-if="docu.fecha_egreso_preparatoria == ''" class="alert alert-danger">
                                        Este campo es obligatorio
                                    </p>
                                </div>
                            </div>
                        </div>

                <div class="row">
                    <div class="col-md-3 col-md-offset-5">
                        <button type="button " class="btn btn-primary btn-lg" @click="guardar_datos();" :disabled="estado_guardar_datos">Guardar datos</button>
<p><br></p>
                    </div>
                </div>

                    </div>

                </div>
            </template>
            <template v-if="registro_hecho >0 ">

                <template v-if="docu.id_estado_enviado == 1 ">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title text-center">Se envio correctamente tus datos personales de titulación para su revisión por el Departamento de Titulación</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-if=" docu.id_estado_enviado == 3 ">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title text-center">Se envio correctamente tus correcciones de tus datos personales de titulación para su revisión por el Departamento de Titulación</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-if="docu.id_estado_enviado == 4 ">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title text-center">Tus datos personales de titulación han sido autorizados, el siguiente paso es acudir al Centro de Información para entregar la información correspondiente  y si la opción por la que vas a titularte es alguna de las siguientes:
                                        Informe técnico de profesional, proyecto de investigación, tesis o tesina, deberás entregar el documento en PDF.</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-if="docu.id_estado_enviado == 5 ">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title text-center">Autorización exitosa, el siguiente paso es agendar cita en el Sistema de Citas para entregar la documentación de requisitos de titulación en fisico,  que fue autorizada anteriormente en el presente sistema . Descargar e imprimir los siguientes documentos :</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center">
                                            <p> <a class="btn btn-primary "
                                               onclick="window.open('{{url('/titulacion/pdf_proyecto_titulacion/'.$id_alumno)}}')">PDF de liberación para proyecto de titulación y titulación integral</a>
                                        </p>
                                        <p><br></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center">
                                            <a class="btn btn-primary "
                                               onclick="window.open('{{url('/titulacion/pdf_solicitud_opcion_titulacion/'.$id_alumno)}}')">PDF de solicitud de opción de titulación y titulación integral</a>
                                    <p><br></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center">
                                            <a class="btn btn-primary "
                                               onclick="window.open('{{url('/titulacion/pdf_constancia_no_incoveniencia/'.$id_alumno)}}')">PDF de la constancia de no incoveniencia</a>
                                        <p><br></p>
                                        </div>
                                    </div>
                                    <template v-if="veri_anterior_2010 == 0 ">
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center">
                                            <a class="btn btn-primary "
                                               onclick="window.open('{{url('/titulacion/pdf_constancia_liberación/'.$id_alumno)}}')">PDF de la constancia de liberación</a>
                                        <p><br></p>
                                    </div>
                                    </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-if="docu.id_estado_enviado == 2 ">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h3 class="panel-title text-center">
                                        <h4>Correcciones:</h4>
                                        <p>@{{ docu.comentario }}</p>

                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-if="docu.id_estado_enviado == 3 ">
                </template>
                <template v-if="docu.id_estado_enviado == 0 ||  docu.id_estado_enviado == 2">
                <div class="panel panel-success">
                    <div class="panel-body">

                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Correo electronico<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="correo_electronico" name="correo_electronico" type="email" v-model="docu.correo_electronico"  placeholder="Ingresa tu correo electronico" style="" :disabled="true" required/>
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <label for="nombre_proyecto">Fecha de emisión del certificado<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="fecha_emision_certificado" name="fecha_emision_certificado" type="date" v-model="docu.fecha_emision_certificado"  placeholder="Selecciona la fecha de emisión del certificado " style="" required/>
                            <p v-if="docu.fecha_emision_certificado == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <label for="nombre_proyecto">Fecha de registro del trámite de titulación<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="fecha_reg_tramite_titulacion" name="fecha_reg_tramite_titulacion" type="date" v-model="docu.fecha_reg_tramite_titulacion"  placeholder="Selecciona la fecha de registro del trámite de titulación" style="" required/>
                            <p v-if="docu.fecha_reg_tramite_titulacion == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-1 ">
                        <div class="form-group">
                            <label for="nombre_proyecto">Fecha de pago de derecho de titulación<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="fecha_pag_derechos_titulacion" name="fecha_pag_derechos_titulacion" type="date" v-model="docu.fecha_pag_derechos_titulacion"  placeholder="Selecciona la fecha de pago de derecho de titulación" style="" required/>
                            <p v-if="docu.fecha_pag_derechos_titulacion == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <label for="nombre_proyecto">Número de  cuenta<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="no_cuenta" name="no_cuenta" type="text" v-model="docu.no_cuenta"  placeholder="Ingresa tu No. cuenta" style="" onkeyup="javascript:this.value=this.value.toUpperCase();" required/>
                            <p v-if="docu.no_cuenta == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="personal">¿ Eres estudiante regular o de revalidación ?<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.id_tipo_estudiante" >
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="tipo_estudiante in tipos_estudiantes" :value="tipo_estudiante.id_tipo_estudiante">@{{tipo_estudiante.tipo_estudiante }}</option>
                            </select>
                            <p v-if="docu.id_tipo_estudiante == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
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
                                <label for="nombre_proyecto">Nombre<b style="color:red; font-size:23px;">*</b></label>
                                <input class="form-control"  id="nombre" name="nombre" type="text" v-model="docu.nombre_al"  placeholder="Ingresa tu nombre"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                                <p v-if="docu.nombre_al == ''" class="alert alert-danger">
                                    Este campo es obligatorio
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre_proyecto">Apellido paterno<b style="color:red; font-size:23px;">*</b></label>
                                <input class="form-control"  id="apaterno" name="apaterno" type="text" v-model="docu.apaterno"  placeholder="Ingresa tu apellido paterno"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                                <p v-if="docu.apaterno == ''" class="alert alert-danger">
                                    Este campo es obligatorio
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre_proyecto">Apellido materno<b style="color:red; font-size:23px;">*</b></label>
                                <input class="form-control"  id="amaterno" name="amaterno" type="text" v-model="docu.amaterno"  placeholder="Ingresa tu apellido materno"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                                <p v-if="docu.amaterno == ''" class="alert alert-danger">
                                    Este campo es obligatorio
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Curp<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="curp" name="curp" type="text" v-model="docu.curp_al"  placeholder="Ingresa tu curp"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();" :disabled="true" required/>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="personal">Carrera<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.id_carrera" :disabled="true">
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="carrera in carreras" :value="carrera.id_carrera">@{{carrera.nombre }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="personal">Plan de Estudio<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.id_plan_estudio">
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="plan in planes_estudios" :value="plan.id_plan_estudio">@{{plan.plan_estudio }}</option>
                            </select>
                            <p v-if="docu.id_plan_estudio == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Promedio General del TESVB<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="promedio_general_tesvb" name="promedio_general_tesvb" type="number" step="any" min="0" max="100"  v-model="docu.promedio_general_tesvb"  placeholder="Ingresa tu Promedio General del TESVB"  style="text-transform:uppercase;"    required/>
                            <p v-if="docu.promedio_general_tesvb == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="personal">¿ Reprobaste alguna materia ?<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.reprobacion_mat">
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="responder in responder" :value="responder.id_respuesta">@{{ responder.descripcion }}</option>
                            </select>
                            <p v-if="docu.reprobacion_mat == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <label for="nombre_proyecto">Fecha de ingreso al TESVB<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="fecha_ingreso_tesvb" name="fecha_ingreso_tesvb" type="date" v-model="docu.fecha_ingreso_tesvb"  placeholder="Selecciona la fecha de ingreso al TESVB" style="" required/>
                            <p v-if="docu.fecha_ingreso_tesvb == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Fecha de egreso al TESVB<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="fecha_egreso_tesvb" name="fecha_egreso_tesvb" type="date" v-model="docu.fecha_egreso_tesvb"  placeholder="Selecciona la fecha de egreso al TESVB" style="" required/>
                            <p v-if="docu.fecha_egreso_tesvb == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="personal">Número de semestres cursados<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.id_semestre">
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="numeros_sem in numeros_semestres" :value="numeros_sem.id_semestre">@{{numeros_sem.id_semestre }}</option>
                                <p v-if="docu.id_semestre > 8" class="alert alert-danger">
                                    Este campo es obligatorio
                                </p>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="personal">Opción de titulación<b style="color:red; font-size:23px;" >*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.id_opcion_titulacion" :disabled="true">
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="opcion in opciones_titulacion" :value="opcion.id_opcion_titulacion">@{{ opcion.opcion_titulacion }}</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="domicilio3">Nombre del proyecto <b style="color:red; font-size:23px;">*</b></label>
                            <textarea class="form-control" id="nom_proyecto" v-model="docu.nom_proyecto" name="nom_proyecto" rows="2"  onkeyup="javascript:this.value=this.value.toUpperCase();"  required></textarea>
                            <p v-if="docu.nom_proyecto ==''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
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
                        <label for="domicilio3">Calle<b style="color:red; font-size:23px;">*</b></label>
                        <input class="form-control"  id="calle_domicilio" name="calle_domicilio" type="text" v-model="docu.calle_domicilio"  placeholder="Ingresa la calle de tu domicilio" style="" required/>
                        <p v-if="docu.calle_domicilio ==''" class="alert alert-danger">
                            Este campo es obligatorio
                        </p>
                    </div>
                    <div class="col-md-3">
                        <label for="domicilio3">Número<b style="color:red; font-size:23px;">*</b></label>
                        <input class="form-control"  id="numero_domicilio" name="numero_domicilio" type="text" v-model="docu.numero_domicilio"  placeholder="Ingresa el número de tu domicilio" style="" required/>
                        <p v-if="docu.numero_domicilio ==''" class="alert alert-danger">
                            Este campo es obligatorio
                        </p>
                    </div>
                    <div class="col-md-3">
                        <label for="domicilio3">Colonia o Comunidad<b style="color:red; font-size:23px;">*</b></label>
                        <input class="form-control"  id="colonia_domicilio" name="colonia_domicilio" type="text" v-model="docu.colonia_domicilio"  placeholder="Ingresa la colonia de tu domicilio" style="" required/>
                        <p v-if="docu.colonia_domicilio ==''" class="alert alert-danger">
                            Este campo es obligatorio
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="personal">Entidad Federativa<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.entidad_federativa" v-on:change="municipios_estado($event)" >
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="estado in estados" :value="estado.id_estado">@{{ estado.nombre_estado }}</option>
                            </select>
                            <p v-if="docu.entidad_federativa  == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="personal">Municipio o Ciudad<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.municipio_domicilio" >
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="municipio in municipios" :value="municipio.id_municipio">@{{ municipio.nombre_municipio }}</option>
                            </select>
                            <p v-if="docu.municipio_domicilio  == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <hr style=" height: 2px;
  background-color: lightblue;">



                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-1 ">
                        <label for="exampleInputEmail1">Telefono<b style="color:red; font-size:23px;">*</b></label>
                        <input type="tel" class="form-control" id="telefono"  name="telefono" v-model="docu.telefono" :disabled="true" required>
                        <p v-if="docu.telefono ==''" class="alert alert-danger">
                            Este campo es obligatorio
                        </p>
                    </div>

                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Jefe de división<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="nombre_jefe" name="nombre_jefe" type="text" v-model="docu.nombre_jefe"   style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();" :disabled="true"  required/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="domicilio3">Nombre de la empresa donde se realizó la Residencia Profesional <b style="color:red; font-size:23px;">*</b> </label>
                            <textarea class="form-control" id="nom_empresa" v-model="docu.nom_empresa" name="nom_empresa" rows="2"    required></textarea>
                        </div>
                        <p v-if="docu.nom_empresa ==''" class="alert alert-danger">
                            Este campo es obligatorio
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="personal">Red Social que utilizas habitualmente<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.id_red_social" >
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="red_social in redes_sociales" :value="red_social.id_red_social">@{{ red_social.red_social }}</option>
                            </select>
                            <p v-if="docu.id_red_social == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_proyecto">¿Cuál es tu nombre de usuario de la red social <b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="" name="nombre_usuario_red" type="text" v-model="docu.nombre_usuario_red"       required/>
                            <p v-if="docu.nombre_usuario_red == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="personal">Tipo de donación<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.id_tipo_donacion" >
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="donacion in tipos_donaciones" :value="donacion.id_tipo_donacion">@{{ donacion.tipo_donacion }}</option>
                            </select>
                            <p v-if="docu.id_tipo_donacion == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-2 col-md-offset-1">
                        <div class="form-group">
                            <label for="personal">Presentas alguna discapacidad<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.presenta_discapacidad" >
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="responder in responder" :value="responder.id_respuesta">@{{ responder.descripcion }}</option>
                            </select>
                            <p v-if="docu.presenta_discapacidad == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <template v-if="docu.presenta_discapacidad   == 1">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre_proyecto">¿ Cual ?<b style="color:red; font-size:23px;">*</b></label>
                                <input class="form-control"  id="discapacidad_que_presenta" name="discapacidad_que_presenta" type="text" v-model="docu.discapacidad_que_presenta"   style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                                <p v-if="docu.discapacidad_que_presenta == ''" class="alert alert-danger">
                                    Este campo es obligatorio
                                </p>
                            </div>
                        </div>
                    </template>
                    <div class="col-md-2 ">
                        <div class="form-group">
                            <label for="personal">Hablas alguna lengua indígena<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control"  v-validate="'required'" v-model="docu.lengua_indigena" >
                                <option disabled selected hidden :value="0">Selecciona una opción</option>
                                <option v-for="responder in responder" :value="responder.id_respuesta">@{{ responder.descripcion }}</option>
                            </select>
                            <p v-if="docu.lengua_indigena == 0" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                    <template v-if="docu.lengua_indigena   == 1">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre_proyecto">¿ Cual ?<b style="color:red; font-size:23px;">*</b></label>
                                <input class="form-control"  id="habla_lengua_indigena" name="habla_lengua_indigena" type="text" v-model="docu.habla_lengua_indigena"   style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                            </div>
                            <p v-if="docu.habla_lengua_indigena == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </template>
                </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-1">
                                <div class="form-group">
                                    <label for="personal">Selecciona tu nacionalidad<b style="color:red; font-size:23px;">*</b></label>
                                    <select class="form-control"  v-validate="'required'" v-model="docu.id_nacionalidad" >
                                        <option disabled selected hidden :value="0">Selecciona una opción</option>
                                        <option v-for="nacionalidad in nacionalidades" :value="nacionalidad.id_nacionalidad">@{{ nacionalidad.nacionalidad }}</option>
                                    </select>
                                    <p v-if="docu.id_nacionalidad == 0" class="alert alert-danger">
                                        Este campo es obligatorio
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="nombre_proyecto">Fecha de ingreso a la preparatoria o bachillerato que estudiaste<b style="color:red; font-size:23px;">*</b></label>
                                    <input class="form-control"  id="fecha_ingreso_preparatoria" name="fecha_ingreso_preparatoria" type="date" v-model="docu.fecha_ingreso_preparatoria"  placeholder="Selecciona fecha de egreso de la preparatoria o bachillerato que estudiaste" style="" required/>
                                    <p v-if="docu.fecha_ingreso_preparatoria == ''" class="alert alert-danger">
                                        Este campo es obligatorio
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="nombre_proyecto">Fecha de egreso de la preparatoria o bachillerato que estudiaste<b style="color:red; font-size:23px;">*</b></label>
                                    <input class="form-control"  id="fecha_egreso_preparatoria" name="fecha_egreso_preparatoria" type="date" v-model="docu.fecha_egreso_preparatoria"  placeholder="Selecciona fecha de egreso de la preparatoria o bachillerato que estudiaste" style="" required/>
                                    <p v-if="docu.fecha_egreso_preparatoria == ''" class="alert alert-danger">
                                        Este campo es obligatorio
                                    </p>
                                </div>
                            </div>
                        </div>

                <template v-if="docu.mencion_honorifica   == 1">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Con Mención honorifica<br>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                </template>

                <div class="row">
                    <div class="col-md-3 col-md-offset-5">
                        <button type="button " class="btn btn-primary btn-lg" @click="modificar_datos();" >Modificar datos</button>
                        <p><br></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <hr style=" height: 5px;
  background-color: black;">
                        <p></p>
                    </div>
                </div>

                <template v-if="docu.id_tipo_donaciones  == 3">
                    <template v-if="docu.id_estado_enviado == 0">
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5"><p><br></p>
                            <button   @click="enviar_datos_alumno();"  title="Enviar datos"  type="button" class="btn btn-success btn-lg flotante">
                                Enviar datos
                            </button>
                            <p><br></p>
                        </div>
                    </div>
                    </template>
                    <template v-if="docu.id_estado_enviado == 2">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-5"><p><br></p>
                                <button   @click="enviar_datos_alumno_mod();"  title="Enviar correcciones de tus datos"  type="button" class="btn btn-success btn-lg flotante">
                                    Enviar correcciones
                                </button>
                                <p><br></p>
                            </div>
                        </div>
                    </template>
                </template>
                <template v-if="docu.id_tipo_donaciones  == 2">
                    <div class="row">
                        <div class="col-md-3 col-md-offset-5">
                               <h3 style="color: #942a25">Agregar donacion de Equipo y/o Material didáctico</h3>
                            <button data-toggle="modal"  @click="agregar_donacion_computo();" data-tooltip="true" data-placement="left" title="Agregar registro de donación de Equipo y/o Material didáctico"  type="button" class="btn btn-success btn-lg flotante">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </button>
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
                                    <th>Tienda</th>
                                    <th>Modificar</th>
                                    <th>Eliminar</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="computo in computo" :key="computo.id_equipo_computo">
                                    <td>@{{ computo.nombre_equipo }}</td>
                                    <td>@{{ computo.descripcion }}</td>
                                    <td>@{{ computo.folio_fiscal }}</td>
                                    <td>@{{ computo.nombre_tienda }}</td>
                                    <td> <button  class="btn btn-primary btn-sm" v-on:click="modificar_computo(computo);" >Modificar</button></td>
                                    <td> <button  class="btn btn-danger btn-sm" v-on:click="eliminar_computo(computo);" >Eliminar</button></td>

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
                    <template v-if="contar_computo  > 0">
                        <template v-if="docu.id_estado_enviado == 0">
                            <div class="row">
                                <div class="col-md-2 col-md-offset-5"><p><br></p>
                                    <button   @click="enviar_datos_alumno();"  title="Enviar datos"  type="button" class="btn btn-success btn-lg flotante">
                                        Enviar datos
                                    </button>
                                    <p><br></p>
                                </div>
                            </div>
                        </template>
                        <template v-if="docu.id_estado_enviado == 2">
                            <div class="row">
                                <div class="col-md-2 col-md-offset-5"><p><br></p>
                                    <button   @click="enviar_datos_alumno_mod();"  title="Enviar correcciones de tus datos"  type="button" class="btn btn-success btn-lg flotante">
                                        Enviar correcciones
                                    </button>
                                    <p><br></p>
                                </div>
                            </div>
                        </template>
                    </template>
                </template>
                <div v-if="docu.id_tipo_donaciones  == 1">
                    <div class="row">
                        <div class="col-md-3 col-md-offset-4">
                            <h3 style="color: #942a25">Agregar donacion de Libros</h3>
                            <button data-toggle="modal" @click="agregar_donacion_libro();" data-tooltip="true" data-placement="left" title="Agregar registro de donación de libros"  type="button" class="btn btn-success btn-lg ">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </button>
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
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="libro in libros" :key="libro.id_titulo_libro">
                                    <td>@{{ libro.titulo }}</td>
                                    <td>@{{ libro.autor }}</td>
                                    <td>@{{ libro.editorial }}</td>
                                    <td> <button  class="btn btn-primary btn-sm" v-on:click="modificar_libro(libro);" >Modificar</button></td>
                                    <td> <button  class="btn btn-danger btn-sm" v-on:click="eliminar_libro(libro);" >Eliminar</button></td>

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
                    <template v-if="contar_libro  > 0">
                        <template v-if="docu.id_estado_enviado == 0">
                            <div class="row">
                                <div class="col-md-2 col-md-offset-5"><p><br></p>
                                    <button   @click="enviar_datos_alumno();"  title="Enviar datos"  type="button" class="btn btn-success btn-lg flotante">
                                        Enviar datos
                                    </button>
                                    <p><br></p>
                                </div>
                            </div>
                        </template>
                        <template v-if="docu.id_estado_enviado == 2">
                            <div class="row">
                                <div class="col-md-2 col-md-offset-5"><p><br></p>
                                    <button   @click="enviar_datos_alumno_mod();"  title="Enviar correcciones de tus datos"  type="button" class="btn btn-success btn-lg flotante">
                                        Enviar correcciones
                                    </button>
                                    <p><br></p>
                                </div>
                            </div>
                        </template>

                    </template>
                </div>
                    </div>
                </div>


                @include('titulacion.alumno_titulacion.segunda_etapa.modal_agregar_libro')
                @include('titulacion.alumno_titulacion.segunda_etapa.modal_modificar_libro')
                @include('titulacion.alumno_titulacion.segunda_etapa.modal_eliminar_libro')
                @include('titulacion.alumno_titulacion.segunda_etapa.modal_agregar_computo')
                @include('titulacion.alumno_titulacion.segunda_etapa.modal_modificar_computo')
                @include('titulacion.alumno_titulacion.segunda_etapa.modal_eliminar_computo')
                @include('titulacion.alumno_titulacion.segunda_etapa.modal_enviar')
                    @include('titulacion.alumno_titulacion.segunda_etapa.modal_enviar_modificacion')
                </template>
            </template>

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
                    veri_anterior_2010:[],
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
                        id_tipo_donacion:0,
                        id_tipo_donaciones:0,
                        presenta_discapacidad:0,
                        discapacidad_que_presenta:"",
                        lengua_indigena:0,
                        habla_lengua_indigena:"",
                        mencion_honorifica:0,
                        id_nacionalidad:0,
                        fecha_ingreso_preparatoria:"",
                        fecha_egreso_preparatoria:"",
                    //    id_tipo_estudio_antecedente:0,
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
                    modal_enviar_datos_mod:0,
                    estado_guardar_envio_mod:false,

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
                        timer: 7000,
                        //icon: "success"
                    });

                    const contar = await axios.get('/titulacion/estado_reg_personales/{{$id_alumno}}');
                    this.registro_hecho = contar.data;
                    if(this.registro_hecho == 0){
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

                        const nacionalidades = await axios.get('/titulacion/nacionalidades/');
                        this.nacionalidades= nacionalidades.data;

                        const antecedentes_estudios = await axios.get('/titulacion/antecedentes_estudios/');
                        this.estudios_antecedentes = antecedentes_estudios.data;

                        const tipos_estudiantes= await axios.get('/titulacion/tipos_estudiantes/');
                        this.tipos_estudiantes= tipos_estudiantes.data;
                        const redes_sociales= await axios.get('/titulacion/tipos_redes_sociales/');
                        this.redes_sociales= redes_sociales.data;






                        this.docu.id_alumno =this.datos.id_alumno;
                       this.docu.correo_electronico= this.datos.correo_electronico;
                       this.docu.curp_al = this.datos.curp;
                       this.docu.id_carrera= this.datos.id_carrera;
                       this.docu.id_semestre = this.datos.id_semestre;
                       this.id_tipo_descuento = this.datos.id_tipo_descuento;
                       this.docu.id_opcion_titulacion = this.datos.id_opcion_titulacion;
                       this.docu.nombre_jefe = this.datos.nombre_jefe;
                       this.docu.id_jefe_division = this.datos.id_personal;
                        this.docu.telefono = this.datos.telefono;



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
                        const veri_ante_2010= await axios.get('/titulacion/veri_ante_2010/{{$id_alumno}}');
                        this.veri_anterior_2010 = veri_ante_2010.data;
                        const nacionalidades = await axios.get('/titulacion/nacionalidades/');
                        this.nacionalidades= nacionalidades.data;
                        const tipos_estudiantes= await axios.get('/titulacion/tipos_estudiantes/');
                        this.tipos_estudiantes= tipos_estudiantes.data;
                        const redes_sociales= await axios.get('/titulacion/tipos_redes_sociales/');
                        this.redes_sociales= redes_sociales.data;

                        const tipos_donaciones = await axios.get('/titulacion/tipo_donaciones/'+this.datos.id_tipo_descuento);
                        this.tipos_donaciones= tipos_donaciones.data;

                            const datos_registrado = await axios.get('/titulacion/ver_datos_alumno_registrados/{{$id_alumno}}');
                            this.datos_registrados= datos_registrado.data;

                        const antecedentes_estudios = await axios.get('/titulacion/antecedentes_estudios/');
                        this.estudios_antecedentes = antecedentes_estudios.data;

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
                       // this.docu.id_tipo_estudio_antecedente= this.datos_registrados[0].id_antecedente_estudio;

                            this.docu.id_estado_enviado= this.datos_registrados[0].id_estado_enviado;
                        this.docu.comentario= this.datos_registrados[0].comentario;

                            if( this.docu.id_tipo_donacion == 1){
                               this.libross();
                            }
                            if( this.docu.id_tipo_donacion == 2){
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
                async guardar_datos(){

                 if(this.docu.fecha_emision_certificado !="" ){
                   this.contar_formulario++;
                 }else{
                     this.contar_formulario=0;
                     swal({
                         position: "top",
                         type: "warning",
                         title: "Ingresa fecha de emisión del certificado",
                         showConfirmButton: false,
                         timer: 3500
                     });
                 }
                 if(this.contar_formulario == 1){
                     if(this.docu.fecha_reg_tramite_titulacion !="" ){
                         this.contar_formulario++;
                     }else{
                         this.contar_formulario=0;
                         swal({
                             position: "top",
                             type: "warning",
                             title: "Ingresa fecha del registro del trámite de Titulación",
                             showConfirmButton: false,
                             timer: 3500
                         });
                     }
                 }
                    if(this.contar_formulario == 2){
                        if(this.docu.fecha_pag_derechos_titulacion !="" ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa fecha de pago de derecho de Titulación",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 3){
                        if(this.docu.no_cuenta !="" ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa número de cuenta",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 4){
                        if(this.docu.id_tipo_estudiante !="" ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona si eres estudiante regular o de revalidación",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }




                    if(this.contar_formulario == 5){
                        if(this.docu.nombre_al !="" ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa tu nombre",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 6){
                        if(this.docu.apaterno !="" ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa tu apellido paterno",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 7){
                        if(this.docu.amaterno !="" ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa tu apellido materno",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 8){

                        if(this.docu.id_plan_estudio > 0 ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona plan de estudios",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 9){
                        if(this.docu.promedio_general_tesvb > 0 ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa promedio general del TESVB",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 10){
                        if(this.docu.reprobacion_mat > 0){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona si reprorbaste alguna materia",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 11){
                        if(this.docu.fecha_ingreso_tesvb != ""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa  fecha de ingreso al TESVB ",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 12){
                        if(this.docu.fecha_egreso_tesvb != ""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa  fecha de egreso al TESVB ",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 13){
                        if(this.docu.nom_proyecto != ""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa  nombre de proyecto ",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 14){
                        if(this.docu.calle_domicilio != ""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa  el nombre de la calle de tu domicilio",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 15){
                        if(this.docu.numero_domicilio != ""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa  el numero de tu domicilio",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 16){
                        if(this.docu.colonia_domicilio != ""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa  la colonia o comunidad de tu domicilio",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 17){
                        if(this.docu.entidad_federativa >0){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona entidad federativa",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 18){
                        if(this.docu.municipio_domicilio >0){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona ciudad o municipio",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 19){
                        if(this.docu.nom_empresa !=""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa nombre de la empresa donde se realizó la Residencia Profesional",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 20){
                        if(this.docu.id_red_social !=""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona Red Social que utilizas habitualmente",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 21){
                        if(this.docu.nombre_usuario_red !=""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa tu nombre de usuario de la red social",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }

                    if(this.contar_formulario == 22){
                        if(this.docu.id_tipo_donacion >0){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona Tipo de donación",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 23) {
                        if (this.docu.presenta_discapacidad > 0) {
                            if (this.docu.presenta_discapacidad == 1) {
                                if (this.docu.discapacidad_que_presenta != "") {
                                    this.contar_formulario++;
                                } else {
                                    this.contar_formulario=0;
                                    swal({
                                        position: "top",
                                        type: "warning",
                                        title: "Ingresa que discapacidad presentas",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }

                            } else {
                                this.contar_formulario++;
                            }
                        }
                        else{
                            this.contar_formulario = 0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona si Presentas alguna discapacidad ",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 24) {
                        if (this.docu.lengua_indigena > 0) {
                            if (this.docu.lengua_indigena == 1) {
                                if (this.docu.habla_lengua_indigena != "") {
                                    this.contar_formulario++;
                                } else {
                                    this.contar_formulario=0;
                                    swal({
                                        position: "top",
                                        type: "warning",
                                        title: "Ingresa que la lengua indigena que hablas",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }

                            } else {
                                this.contar_formulario++;
                            }
                        }
                        else{
                            this.contar_formulario = 0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona si hablas alguna lengua indígena ",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 25){
                        if(this.docu.id_nacionalidad >0){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona tu nacionalidad",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 26){
                        if(this.docu.fecha_ingreso_preparatoria !=''){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona fecha de ingreso de la preparatoria o bachillerato que estudiaste",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 27){
                        if(this.docu.fecha_egreso_preparatoria !=''){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona fecha de egreso de la preparatoria o bachillerato que estudiaste",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }

                    if(this.contar_formulario == 28){
                        this.estado_guardar_datos=true;
                        const resultado= await axios.post('/titulacion/registrar_datos_alumno/', this.docu);
                        this.contar_formulario=0;
                        this.Documentacion();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 10000
                        });

                    }







                },
                async modificar_datos(){

                    if(this.docu.fecha_emision_certificado !="" ){
                        this.contar_formulario++;
                    }else{
                        this.contar_formulario=0;
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Ingresa fecha de emisión del certificado",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                    if(this.contar_formulario == 1){
                        if(this.docu.fecha_reg_tramite_titulacion !="" ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa fecha del registro del trámite de Titulación",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 2){
                        if(this.docu.fecha_pag_derechos_titulacion !="" ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa fecha de pago de derecho de Titulación",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 3){
                        if(this.docu.no_cuenta !="" ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa número de cuenta",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 4){
                        if(this.docu.id_tipo_estudiante !="" ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona si eres estudiante regular o de revalidación",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }




                    if(this.contar_formulario == 5){
                        if(this.docu.nombre_al !="" ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa tu nombre",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 6){
                        if(this.docu.apaterno !="" ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa tu apellido paterno",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 7){
                        if(this.docu.amaterno !="" ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa tu apellido materno",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 8){

                        if(this.docu.id_plan_estudio > 0 ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona plan de estudios",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 9){
                        if(this.docu.promedio_general_tesvb > 0 ){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa promedio general del TESVB",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 10){
                        if(this.docu.reprobacion_mat > 0){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona si reprorbaste alguna materia",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 11){
                        if(this.docu.fecha_ingreso_tesvb != ""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa  fecha de ingreso al TESVB ",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 12){
                        if(this.docu.fecha_egreso_tesvb != ""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa  fecha de egreso al TESVB ",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 13){
                        if(this.docu.nom_proyecto != ""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa  nombre de proyecto ",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 14){
                        if(this.docu.calle_domicilio != ""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa  el nombre de la calle de tu domicilio",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 15){
                        if(this.docu.numero_domicilio != ""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa  el numero de tu domicilio",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 16){
                        if(this.docu.colonia_domicilio != ""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa  la colonia o comunidad de tu domicilio",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 17){
                        if(this.docu.entidad_federativa >0){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona entidad federativa",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 18){
                        if(this.docu.municipio_domicilio >0){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona ciudad o municipio",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 19){
                        if(this.docu.nom_empresa !=""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa nombre de la empresa donde se realizó la Residencia Profesional",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 20){
                        if(this.docu.id_red_social !=""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona Red Social que utilizas habitualmente",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 21){
                        if(this.docu.nombre_usuario_red !=""){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa tu nombre de usuario de la red social",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }

                    if(this.contar_formulario == 22){
                        if(this.docu.id_tipo_donacion >0){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona Tipo de donación",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 23) {
                        if (this.docu.presenta_discapacidad > 0) {
                            if (this.docu.presenta_discapacidad == 1) {
                                if (this.docu.discapacidad_que_presenta != "") {
                                    this.contar_formulario++;
                                } else {
                                    this.contar_formulario=0;
                                    swal({
                                        position: "top",
                                        type: "warning",
                                        title: "Ingresa que discapacidad presentas",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }

                            } else {
                                this.contar_formulario++;
                            }
                        }
                        else{
                            this.contar_formulario = 0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona si Presentas alguna discapacidad ",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 24) {
                        if (this.docu.lengua_indigena > 0) {
                            if (this.docu.lengua_indigena == 1) {
                                if (this.docu.habla_lengua_indigena != "") {
                                    this.contar_formulario++;
                                } else {
                                    this.contar_formulario=0;
                                    swal({
                                        position: "top",
                                        type: "warning",
                                        title: "Ingresa que la lengua indigena que hablas",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }

                            } else {
                                this.contar_formulario++;
                            }
                        }
                        else{
                            this.contar_formulario = 0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona si hablas alguna lengua indígena ",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 25){
                        if(this.docu.id_nacionalidad >0){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona tu nacionalidad",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 26){
                        if(this.docu.fecha_ingreso_preparatoria !=''){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona fecha de ingreso de la preparatoria o bachillerato que estudiaste",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    if(this.contar_formulario == 27){
                        if(this.docu.fecha_egreso_preparatoria !=''){
                            this.contar_formulario++;
                        }else{
                            this.contar_formulario=0;
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona fecha de egreso de la preparatoria o bachillerato que estudiaste",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }

                    if(this.contar_formulario == 28){
                        this.estado_guardar_datos=true;
                        const resultado= await axios.post('/titulacion/modificar_datos_alumno/', this.docu);
                        this.contar_formulario=0;
                        this.Documentacion();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Modificación exitosa",
                            showConfirmButton: false,
                            timer: 10000
                        });

                    }







                },
                async agregar_donacion_libro(){
                    this.modal_agregar_libro=1;
                    this.libro.titulo="";
                    this.libro.autor="";
                    this.libro.editorial="";
                    this.estado_guardar_libro=false;
                },
                async guardar_libro(){
                    if(this.libro.titulo !="" && this.libro.autor !="" && this.libro.editorial !="" ){
                        this.estado_guardar_libro=true;
                        const resultado= await axios.post('/titulacion/registrar_libro/'+this.docu.id_reg_dato_alum, this.libro);
                        this.cerrarModal_agregar_libro();
                        this.libross();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else{
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Hay campos vacios",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                },
                async modificar_libro(libro){
                        this.lib.id_titulo_libro=libro.id_titulo_libro;
                        this.lib.id_reg_dato_alum=libro.id_reg_dato_alum;
                        this.lib.titulo=libro.titulo;
                        this.lib.autor=libro.autor;
                        this.lib.editorial=libro.editorial;
                    this.modal_modificar_libro=1;

                },

                async modificacion_libro(){
                    if(this.lib.titulo !="" && this.lib.autor !="" && this.lib.editorial !="" ){
                        const resultado= await axios.post('/titulacion/modificacion_libro/', this.lib);
                        this.cerrarModal_modificar_libro();
                        this.libross();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Modificación exitosa",
                            showConfirmButton: false,
                            timer: 3500

                        });

                    }else{
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Hay campos vacios",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                },
                async enviar_datos_alumno(){
                    this.modal_enviar_datos=1;
                    this.estado_guardar_envio=false;
                      },

                async enviar_datos_alumno_mod(){
                    this.modal_enviar_datos_mod=1;
                    this.estado_guardar_envio_mod=false;
                },
                async enviar_registro_datos(){
                    this.estado_guardar_envio=true;
                    const resultado= await axios.post('/titulacion/enviar_datos_alumno/'+this.docu.id_reg_dato_alum);
                    this.cerrarModal_enviar_datos();
                    this.Documentacion();
                    swal({
                        position: "top",
                        type: "success",
                        title: "Envio exitoso",
                        showConfirmButton: false,
                        timer: 7000
                    });
                },
                async enviar_registro_datos_mod(){
                    this.estado_guardar_envio_mod=true;
                    const resultado= await axios.post('/titulacion/enviar_datos_alumno_mod/'+this.docu.id_reg_dato_alum);
                    this.cerrarModal_enviar_datos_mod();
                    this.Documentacion();
                    swal({
                        position: "top",
                        type: "success",
                        title: "Envio exitoso",
                        showConfirmButton: false,
                        timer: 3000
                    });

                },
                async eliminar_libro(libro){
                    this.lib.id_titulo_libro=libro.id_titulo_libro;
                    this.lib.id_reg_dato_alum=libro.id_reg_dato_alum;
                    this.lib.titulo=libro.titulo;
                    this.lib.autor=libro.autor;
                    this.lib.editorial=libro.editorial;
                    this.modal_eliminar_libro=1;
                },
                async eliminacion_libro(){
                    const resultado= await axios.post('/titulacion/eliminacion_libro/', this.lib);
                    this.cerrarModal_eliminar_libro();
                    this.libross();
                    swal({
                        position: "top",
                        type: "success",
                        title: "Eliminación exitosa",
                        showConfirmButton: false,
                        timer: 3500
                    });
                },
                async agregar_donacion_computo(){
                    this.modal_agregar_computo=1;
                    this.comput.nombre_equipo="";
                    this.comput.descripcion="";
                    this.comput.folio_fiscal="";
                    this.comput.nombre_tienda="";
                    this.estado_guardar_computo=false;
                },
                async guardar_agregar_computo(){
                    if(this.comput.nombre_equipo !="" && this.comput.descripcion !="" && this.comput.folio_fiscal !="" && this.comput.nombre_tienda !=""  ){
                        this.estado_guardar_computo=true;
                        const resultado= await axios.post('/titulacion/registrar_computo/'+this.docu.id_reg_dato_alum, this.comput);
                        this.cerrarModal_agregar_computo();
                        this.computos();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else{
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Hay campos vacios",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                },
                async modificar_computo(computo){
                    this.modal_modificar_computo=1;
                    this.comp.id_equipo_computo=computo.id_equipo_computo;
                    this.comp.nombre_equipo=computo.nombre_equipo;
                    this.comp.descripcion =computo.descripcion;
                    this.comp.folio_fiscal=computo.folio_fiscal;
                    this.comp.nombre_tienda=computo.nombre_tienda;
                },
                async guardar_modificar_computo(){
                    if(this.comp.nombre_equipo !="" && this.comp.descripcion !="" && this.comp.folio_fiscal !="" && this.comp.nombre_tienda !=""  ){
                        const resultado= await axios.post('/titulacion/modificar_computo/', this.comp);
                        this.cerrarModal_modificar_computo();
                        this.computos();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Modificación exitosa",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else{
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Hay campos vacios",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                },
                async eliminar_computo(computo){
                    this.comp.id_equipo_computo=computo.id_equipo_computo;
                    this.comp.nombre_equipo=computo.nombre_equipo;
                    this.comp.descripcion =computo.descripcion;
                    this.comp.folio_fiscal=computo.folio_fiscal;
                    this.comp.nombre_tienda=computo.nombre_tienda;
                    this.modal_eliminar_computo=1;
                },
                async eliminacion_computo(){
                    const resultado= await axios.post('/titulacion/eliminacion_computo/', this.comp);
                    this.cerrarModal_eliminar_computo();
                    this.computos();
                    swal({
                        position: "top",
                        type: "success",
                        title: "Eliminación exitosa",
                        showConfirmButton: false,
                        timer: 3500
                    });
                },

                async cerrarModal_agregar_libro(){
                    this.modal_agregar_libro=0;
                },
                async cerrarModal_modificar_libro(){
                    this.modal_modificar_libro=0;
                },
                async cerrarModal_eliminar_libro(){
                    this.modal_eliminar_libro=0;
                },
                async cerrarModal_agregar_computo(){
                    this.modal_agregar_computo=0;
                },
                async cerrarModal_modificar_computo(){
                    this.modal_modificar_computo=0;
                },
                async cerrarModal_eliminar_computo(){
                    this.modal_eliminar_computo=0;
                },
                async cerrarModal_enviar_datos() {
                    this.modal_enviar_datos=0;
                },
                async cerrarModal_enviar_datos_mod(){
                    this.modal_enviar_datos_mod=0;
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
            overflow-y: scroll;
            display: list-item;
            opacity: 1;
            background: rgba(44,38,75,0.849);
        }
    </style>

@endsection
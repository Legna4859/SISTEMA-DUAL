@extends('layouts.app')
@section('title', 'Titulación')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/titulacion/alumnos_registrar_datos_dep/$registro_datos->id_carrera")}}">Estudiantes para registar datos</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Registrar datos del estudiante titulado</span>

            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Registrar datos del estudiante titulado  <br>
                    </h3>
                </div>
            </div>
        </div>
    </div>

    @if($estado_reg_datos == 0)

        <form id="form_guardar_datos_alumno" class="form" action="{{url("/titulacion/registrar_formulario_datos/dato_alumno/$id_alumno")}}" role="form" method="POST" >
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-3 col-md-offset-1">
                    <div class="form-group">
                        <label for="numero_cuenta">Número de cuenta</label>
                        <input class="form-control required" id="cuenta" name="cuenta"  readonly value="{{ $registro_datos->no_cuenta }}" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="clave_carrera">Clave de  la carrera</label>
                        <input class="form-control required" id="id_clave_carrera" name="id_clave_carrera"  type="hidden"  value="{{ $clave_carrera->id_clave_carrera }}"  required />
                        <input class="form-control required" id="clave_carrera" name="clave_carrera" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly value="{{ $clave_carrera->clave }}"  required />
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label for="nombre_carrera">Nombre de la carrera</label>
                        <input class="form-control required" id="nombre_carrera" name="nombre_carrera"  readonly value="{{ $registro_datos->carrera }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-1">
                    <div class="form-group">
                        <label for="nombre_estudiante">Nombre del estudiante </label>
                        <input class="form-control required" id="nombre_estudiante" name="nombre_estudiante"  readonly value="{{ $registro_datos->nombre_al }}" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="apaterno_estudiante">Apellido paterno del estudiante </label>
                        <input class="form-control required" id="apaterno_estudiante" name="apaterno_estudiante"  readonly value="{{ $registro_datos->apaterno }}" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="amaterno_estudiante">Apellido materno del estudiante </label>
                        <input class="form-control required" id="amaterno_estudiante" name="amaterno_estudiante"  readonly value="{{ $registro_datos->amaterno }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-1">
                    <div class="form-group">
                        <label for="entidad_federativa_estudiante">Entidad federativa donde vive el estudiante </label>
                        <input class="form-control required" id="entidad_federativa_estudiante" name="entidad_federativa_estudiante"  readonly value="ESTADO DE {{ $registro_datos->nombre_estado }}" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dropdown">
                        <label for="id_nacionalidad">Nacionalidad del estudiante</label>
                        <input class="form-control required" id="id_nacionalidad" name="id_nacionalidad"  type="hidden"  value="{{ $registro_datos->id_nacionalidad }}"  required />
                        <input class="form-control required" id="nacionalidad" name="nacionalidad" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly value="{{ $registro_datos->nacionalidad }}"  required />

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="clave_carrera">Genero</label>
                        <input class="form-control required" id="id_genero" name="id_genero"  type="hidden"  value="{{ $genero->id_genero }}"  required />
                        <input class="form-control required" id="genero" name="genero" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly value="{{ $genero->genero }}"  required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-1">
                    <div class="dropdown">
                        <label for="id_genero">Sexo</label>
                        <input class="form-control required" id="id_sexo" name="id_sexo"  type="hidden"  value="{{ $sexo->id_sexo }}"  required />
                        <input class="form-control required" id="sexo" name="sexo" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly value="{{ $sexo->sexo }}"  required />

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="curp">CURP </label>
                        <input class="form-control required" id="curp" name="curp"  readonly value="{{ $registro_datos->curp_al }}" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="edad">Edad </label>
                        <input class="form-control required" id="edad" name="edad" readonly value="{{ $edad }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-1">
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de nacimiento </label>
                        <input class="form-control required" id="fecha_nacimiento" name="fecha_nacimiento" readonly value="{{ $fecha_nacimiento }}" />
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label for="tipo_estudiante">¿ Es estudiante?</label>
                        <input class="form-control required" id="tipo_estudiante" name="tipo_estudiante"  readonly value="{{ $registro_datos->tipo_estudiante }}" />
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label for="id_opcion_titulacion">Opción de titulación</label>
                        <input class="form-control required" id="id_opcion_titulacion" name="id_opcion_titulacion"  readonly value="{{ $registro_datos->opcion_titulacion }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 col-md-offset-1">
                    <div class="dropdown">
                        <label for="id_preparatoria">Preparatoria</label>
                        <input class="form-control required" id="id_preparatoria" name="id_preparatoria"  type="hidden"  value="{{ $descuentos_alumn->id_preparatoria }}"  required />
                        <input class="form-control required" id="preparatoria" name="preparatoria" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly value="{{ $descuentos_alumn->preparatoria }} ( Entidad federativa: {{ $descuentos_alumn->nom_entidad }} )"  required />

                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-1">
                    <div class="form-group">
                        <?php  $fecha_ingreso_preparatoria=date("d-m-Y",strtotime($registro_datos->fecha_ingreso_preparatoria)) ?>
                        <label for="id_preparatoria">Fecha de ingreso a la preparatoria</label>
                        <input class="form-control datepicker fecha_inicio_prep"   type="text"  id="fecha_inicio_preparatoria" name="fecha_inicio_preparatoria" data-date-format="dd/mm/yyyy" placeholder="DD/MM/YYYY" readonly value="{{ $fecha_ingreso_preparatoria }}" required>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="form-group">
                        <?php  $fecha_egreso_preparatoria=date("d-m-Y",strtotime($registro_datos->fecha_egreso_preparatoria)) ?>

                        <label for="id_preparatoria">Fecha de egreso a la preparatoria</label>
                        <input class="form-control datepicker fecha_final_prep"   type="text"  id="fecha_final_preparatoria" name="fecha_final_preparatoria" data-date-format="dd/mm/yyyy" placeholder="DD/MM/YYYY" readonly value="{{ $fecha_egreso_preparatoria }}" required >
                    </div>
                </div>

            </div>
            <div class="row">

                <div class="col-md-3 col-md-offset-1 ">
                    <div class="dropdown">
                        <label for="id_numero_titulacion">Seleccionar folio de titulación</label>
                        <select class="form-control" id="id_numero_titulacion" name="id_numero_titulacion" required>
                            <option disabled selected hidden>Selecciona una opción</option>
                            @foreach($titulos_disponibles as $titulo)
                                <option value="{{$titulo->id_numero_titulo}}"> {{$titulo->abreviatura_folio_titulo}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label for="numero_foja_titulo">Número de la foja del título</label>
                        <input class="form-control " id="numero_foja_titulo" name="numero_foja_titulo" type="number"  value="{{ $datos_alumnos->numero_foja_titulo }}" required />
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label for="numero_libro_titulo">Número del libro del título</label>
                        <input class="form-control " id="numero_libro_titulo" name="numero_libro_titulo"   type="number"  value="{{ $datos_alumnos->numero_libro_titulo }}"  required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-1">
                    <div class="form-group">
                        <label for="hora_titulacion">Hora de titulación</label>
                        <input class="form-control " id="hora_titulacion" name="hora_titulacion"  readonly type="text" value="{{ $reg_fecha_titulacion->hora }}"  required/>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label for="fecha_titulacion">Fecha de titulación</label>
                        <input class="form-control " id="fecha_titulacion" name="fecha_titulacion" readonly type="text" value="{{ $reg_fecha_titulacion->fecha_titulacion }}"  required/>
                    </div>
                </div>
                <div class="col-md-3">

                        <label for="id_tipo_titulo">Titulo obtenido</label>
                        <div class="form-group">
                            <input class="form-control required" id="id_tipo_titulo" name="id_tipo_titulo"  type="hidden"  value="{{ $titulo_obtenido->id_tipo_titulo }}"  required />
                            <input class="form-control required" id="tipo_titulo" name="tipo_titulo" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly value="{{ $titulo_obtenido->tipo_titulo }}"  required />

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-1">
                    <div class="dropdown">
                        <label for="id_decision">Decisión del jurado</label>
                        <select class="form-control" id="id_decision" name="id_decision" required>
                            <option disabled selected hidden>Selecciona una opción</option>
                            @foreach($tipos_decisiones as $tipos_decisiones)
                                <option value="{{$tipos_decisiones->id_decision}}"> {{$tipos_decisiones->decision}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <?php  $fecha_ingreso_tesvb=date("d-m-Y",strtotime($registro_datos->fecha_ingreso_tesvb)) ?>

                        <label for="fecha_ingreso_tesvb">Fecha de ingreso al TESVB</label>
                        <input class="form-control datepicker fecha_ingreso_tec"   type="text"  id="fecha_ingreso_tesvb" name="fecha_ingreso_tesvb" data-date-format="dd/mm/yyyy" placeholder="DD/MM/YYYY" value="{{ $fecha_ingreso_tesvb }}" readonly required>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="form-group">
                        <?php  $fecha_egreso_tesvb=date("d-m-Y",strtotime($registro_datos->fecha_egreso_tesvb)) ?>

                        <label for="fecha_ingreso_tesvb">Fecha de egreso aL TESVB</label>
                        <input class="form-control datepicker fecha_egreso_tec"   type="text"  id="fecha_egreso_tesvb" name="fecha_egreso_tesvb" data-date-format="dd/mm/yyyy" placeholder="DD/MM/YYYY"  value="{{ $fecha_egreso_tesvb }}" readonly required >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-1">
                    <div class="dropdown">
                        <label for="id_fundamento_legal">Selecciona fundamento legal del servicio social</label>
                        <select class="form-control" id="id_fundamento_legal" name="id_fundamento_legal" required>
                            <option disabled selected hidden>Selecciona una opción</option>
                            @foreach($fundamentos_legal_s_s as $fundamento)
                                <option value="{{$fundamento->id_fundamento_legal}}"> {{$fundamento->fundamento_legal}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="dropdown">
                        <label for="id_autorizacion_reconocimiento">Selecciona autorización de reconocimiento</label>
                        <select class="form-control" id="id_autorizacion_reconocimiento" name="id_autorizacion_reconocimiento" required >
                            <option disabled selected hidden>Selecciona una opción</option>
                            @foreach($autorizaciones_reconocimiento as $autorizacion)
                                <option value="{{$autorizacion->id_autorizacion_reconocimiento}}"> {{$autorizacion->autorizacion_reconocimiento}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </form>
        <div class="row">

            <div class="col-md-3 col-md-offset-5">
                <p></p>
                <button type="button" id="guardar_datos" class="btn btn-primary btn-lg"  >Guardar datos</button>
                <p><br></p>
            </div>
        </div>

    @elseif($estado_reg_datos == 1)
            @if($estado_folio_titulo == 0)
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-danger">
                            <div class="panel-heading">El estudiante no cuenta con folio de titulo.

                               <p> Para registrar un folio de titulo al estudiante seguir los siguientes pasos:</p>
                                <p>- Dar clic en el modulo catalogo de titulacion</p>
                                <p>- Elegir la opción de registrar tomos de titulos </p>
                                <p>- Seleccionar el tomo activado</p>
                                <p>- Dar clic en la opcion ver titulos</p>
                                <p>- Seleccionar un folio de titulo para el estudiante</p>
                            </div>

                        </div>
                    </div>
                </div>
            @else
        <div class="row">
            <div class="col-md-10 col-md-offset-1">


                <div class="panel panel-info">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-4">
                                <label for="numero_cuenta" style="color: #1f6fb2">Número de cuenta</label>
                                <h4>{{ $registro_datos->no_cuenta }}</h4>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="clave_carrera" style="color: #1f6fb2">Clave de  la carrera</label>
                                    <h4>{{ $datos_alumnos->clave }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label for="nombre_carrera" style="color: #1f6fb2">Nombre de la carrera</label>
                                    <h4>{{ $registro_datos->carrera }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre_estudiante" style="color: #1f6fb2">Nombre del estudiante </label>
                                    <h4> {{ $registro_datos->nombre_al }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="apaterno_estudiante" style="color: #1f6fb2">Apellido paterno del estudiante </label>
                                    <h4>{{ $registro_datos->apaterno }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="amaterno_estudiante" style="color: #1f6fb2">Apellido materno del estudiante </label>
                                    <h4>{{ $registro_datos->amaterno }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="entidad_federativa_estudiante" style="color: #1f6fb2">Entidad federativa donde vive el estudiante </label>
                                    <h4> ESTADO DE {{ $registro_datos->nombre_estado }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dropdown">
                                    <label for="id_nacionalidad" style="color: #1f6fb2">Nacionalidad del estudiante</label>
                                    <h4> {{ $datos_alumnos->nacionalidad }}</h4>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dropdown">
                                    <label for="id_genero" style="color: #1f6fb2">Genero</label>
                                    <h4> {{ $datos_alumnos->genero }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="dropdown">
                                    <label for="id_genero" style="color: #1f6fb2">Sexo</label>
                                    <h4> {{ $datos_alumnos->sexo }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="curp" style="color: #1f6fb2">CURP </label>
                                    <h4>{{ $registro_datos->curp_al }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edad" style="color: #1f6fb2">Edad </label>
                                    <h4>{{ $edad }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha_nacimiento" style="color: #1f6fb2">Fecha de nacimiento </label>
                                    <h4>{{ $fecha_nacimiento }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label for="tipo_estudiante" style="color: #1f6fb2">¿ Es estudiante?</label>
                                    <h4>{{ $registro_datos->tipo_estudiante }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label for="id_opcion_titulacion" style="color: #1f6fb2">Opción de titulación</label>
                                    <h4>{{ $registro_datos->opcion_titulacion }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 ">
                                <div class="dropdown">
                                    <label for="id_preparatoria" style="color: #1f6fb2">Preparatoria</label>
                                    <h4>Nombre de la preparatoria: {{ $datos_alumnos->preparatoria }} Entidad Federativa: {{ $datos_alumnos->nom_entidad }}</h4>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="id_preparatoria" style="color: #1f6fb2">Fecha de ingreso a la preparatoria</label>
                                    <h4> {{ $datos_alumnos->fecha_ingreso_preparatoria }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label for="id_preparatoria" style="color: #1f6fb2">Fecha de egreso a la preparatoria</label>
                                    <h4> {{ $datos_alumnos->fecha_egreso_preparatoria }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label for="folio_titulo" style="color: #1f6fb2">Folio del titulo</label>
                                    <h4> {{ $datos_alumnos->abreviatura_folio_titulo }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label for="numero_foja_titulo" style="color: #1f6fb2">Número de la foja del título</label>
                                    <h4> {{ $datos_alumnos->numero_foja_titulo }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="numero_libro_titulo" style="color: #1f6fb2">Número del libro del título</label>
                                    <h4> {{ $datos_alumnos->numero_libro_titulo }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="hora_titulacion" style="color: #1f6fb2">Hora de titulación</label>
                                    <h4>{{ $reg_fecha_titulacion->hora }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label for="fecha_titulacion" style="color: #1f6fb2">Fecha de titulación</label>
                                    <h4>{{ $reg_fecha_titulacion->fecha_titulacion }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dropdown">
                                    <label for="id_tipo_titulo"style="color: #1f6fb2">Titulo obtenido</label>
                                    <h4> {{ $datos_alumnos->tipo_titulo }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="dropdown">
                                    <label for="id_decision" style="color: #1f6fb2">Decisión del jurado</label>
                                    <h4> {{ $datos_alumnos->decision }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha_ingreso_tesvb"style="color: #1f6fb2">Fecha de ingreso al TESVB</label>
                                    <h4> {{ $datos_alumnos->fecha_ingreso_tesvb }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label for="fecha_ingreso_tesvb" style="color: #1f6fb2">Fecha de egreso aL TESVB</label>
                                    <h4> {{ $datos_alumnos->fecha_egreso_tesvb }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label for="fecha_ingreso_tesvb" style="color: #1f6fb2">Fundamento legal del servicio social</label>
                                    <h4> {{ $datos_alumnos->fundamento_legal }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label for="fecha_ingreso_tesvb" style="color: #1f6fb2">Autorización de reconocimiento</label>
                                    <h4> {{ $datos_alumnos->autorizacion_reconocimiento }}</h4>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-2 col-md-offset-4">
                                <p></p>
                                <p></p>
                                <a class="pull-right btn_edit_info" href="#" ><span
                                            style="font-size:30px;"
                                            aria-hidden="true"
                                            class="glyphicon glyphicon-cog"
                                            data-toggle="tooltip"
                                            title="Editar datos del estudiante " id="editar_datos_alumnos"></span></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        @if($oficio_recursos == null)
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <h4 style="text-align: center">Registrar datos del oficio de recursos</h4>
                            <div class="row">
                                <form id="form_guardar_oficio_recursos" class="form" action="{{url("/titulacion/registrar_oficio_recursos/$id_alumno")}}" role="form" method="POST" >
                                    {{ csrf_field() }}
                                    <div class="col-md-4  col-md-offset-1">
                                        <div class="form-group">
                                            <label for="fecha_oficio_recurso">Fecha de registro del oficio de recurso</label>
                                            <input class="form-control datepicker "   type="text"  id="fecha_oficio_recurso" name="fecha_oficio_recurso" data-date-format="dd/mm/yyyy" placeholder="DD/MM/YYYY" value="{{ $reg_fecha_titulacion->fecha_titulacion }}" readonly required>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="numero_oficio_recurso">Número del oficio de recurso</label>
                                            <input class="form-control required" id="numero_oficio_recurso" name="numero_oficio_recurso" onkeyup="javascript:this.value=this.value.toUpperCase();"  value="" />
                                        </div>
                                    </div>
                                </form>
                                <div class="col-md-2">
                                    <p></p>
                                    <p></p>
                                    <button type="button " class="btn btn-primary btn-lg" id="guardar_oficio_recursos" >Guardar</button>

                                </div>
                            </div>
                            <div class="row">

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <h4 style="text-align: center">Datos del oficio de recursos</h4>
                            <div class="row">
                                <div class="col-md-4  col-md-offset-1">
                                    <div class="form-group">
                                        <h4 style="text-align: center">Fecha de registro del oficio de recurso</h4>
                                        <h4 style="text-align: center; color: #1f6fb2">{{ $oficio_recursos->fecha_oficio_recursos }}</h4>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h4 style="text-align: center">Número del oficio de recurso</h4>
                                        <h4 style="text-align: center; color: #1f6fb2">{{ $oficio_recursos->numero_oficio_recursos }}</h4>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <p></p>
                                    <p></p>
                                    <a class="pull-right btn_edit_info"  ><span
                                                style="font-size:30px;"
                                                aria-hidden="true"
                                                class="glyphicon glyphicon-cog"
                                                data-toggle="tooltip"
                                                title="Editar datos del oficio de recursos" id="editar_oficio_recursos"></span></a>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            @if($acta_titulacion->id_autorizar == 0)
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <h4 style="text-align: center">Registrar datos de la acta de titulacion</h4>
                                <form id="form_guardar_datos_acta_titulacion" class="form" action="{{url("/titulacion/registrar_datos_acta_titulacion/$id_alumno")}}" role="form" method="POST" >
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-3  col-md-offset-1">
                                            <div class="form-group">
                                                <label for="numero_acta_titulación">Número de la acta de titulación</label>
                                                <input class="form-control"   type="hidden"  id="id_acta_titulacion" name="id_acta_titulacion"  value="{{ $acta_titulacion->id_acta_titulacion }}"  required>

                                                <input class="form-control"   type="text"  id="numero_acta_titulacion" readonly name="numero_acta_titulacion"  value="{{ $acta_titulacion->numero_acta_titulacion }}"  required>

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="numero_libro_acta_titulacion	">Número del libro de actas de titulación</label>
                                                <input class="form-control required" id="numero_libro_acta_titulacion" readonly name="numero_libro_acta_titulacion" value="{{ $acta_titulacion->numero_libro_acta_titulacion }}"  type="text"   value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="foja_acta_titulacion">Número de foja de la acta de titulación</label>
                                                <input class="form-control"   type="text"  id="foja_acta_titulacion" readonly name="foja_acta_titulacion" value="{{ $acta_titulacion->foja_acta_titulacion }}"    required>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-1">
                                            <div class="form-group">
                                                <label for="hora_conformidad_acta">Hora de conformidad de la acta  de titulación</label>
                                                <input id="hora_conformidad_acta" class="form-control time" type="time" name="hora_conformidad_acta"  />
                                            </div>
                                        </div>
                                        <div class="col-md-4  col-md-offset-1">
                                            <div class="form-group">
                                                <label for="fecha_conformidad_acta">Fecha de conformidad de la acta  de titulación</label>
                                                <input class="form-control datepicker "   type="text"  id="fecha_conformidad_acta" name="fecha_conformidad_acta" value="{{ $reg_fecha_titulacion->fecha_titulacion }}" readonly data-date-format="dd/mm/yyyy" placeholder="DD/MM/YYYY" required>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-1">
                                            <div class="form-group">
                                                <label for="hora_levantamiento_acta">Hora de levantamiento de la acta  de titulación</label>
                                                <input id="hora_levantamiento_acta" class="form-control time" type="time" name="hora_levantamiento_acta"  />
                                            </div>
                                        </div>
                                        <div class="col-md-4  col-md-offset-1">
                                            <div class="form-group">
                                                <label for="fecha_levantamiento_acta">Fecha de levantamiento de la acta  de titulación</label>
                                                <input class="form-control datepicker "   type="text"  id="fecha_levantamiento_acta" name="fecha_levantamiento_acta" value="{{ $reg_fecha_titulacion->fecha_titulacion }}" readonly data-date-format="dd/mm/yyyy" placeholder="DD/MM/YYYY" required>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-5">
                                        <p></p>
                                        <p></p>
                                        <button type="button " class="btn btn-primary btn-lg" id="guardar_acta_titulacion" >Guardar</button>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <h4 style="text-align: center">Datos de la acta de titulacion</h4>
                                <div class="row">
                                    <div class="col-md-3  col-md-offset-1">
                                        <div class="form-group">
                                            <h4 style="text-align: center">Número de la acta de titulación</h4>
                                            <h4 style="text-align: center; color: #1f6fb2">{{ $acta_titulacion->numero_acta_titulacion}}</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h4 style="text-align: center">Número del libro de actas de titulación</h4>
                                            <h4 style="text-align: center; color: #1f6fb2">{{ $acta_titulacion->numero_libro_acta_titulacion }}</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h4 style="text-align: center">Número de foja de la acta de titulación</h4>
                                            <h4 style="text-align: center; color: #1f6fb2">{{ $acta_titulacion->foja_acta_titulacion }}</h4>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-md-offset-1">
                                        <div class="form-group">
                                            <h4 style="text-align: center">Hora de conformidad de la acta  de titulación</h4>
                                            <h4 style="text-align: center; color: #1f6fb2">{{ $acta_titulacion->hora_conformidad_acta }}</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-4  col-md-offset-1">
                                        <div class="form-group">
                                            <h4 style="text-align: center">Fecha de conformidad de la acta  de titulación</h4>
                                            <h4 style="text-align: center; color: #1f6fb2">{{ $reg_fecha_titulacion->fecha_titulacion }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-md-offset-1">
                                        <div class="form-group">
                                            <h4 style="text-align: center">Hora de levantamiento de la acta  de titulación</h4>
                                            <h4 style="text-align: center; color: #1f6fb2">{{ $acta_titulacion->hora_levantamiento_acta }}</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-4  col-md-offset-1">
                                        <div class="form-group">
                                            <h4 style="text-align: center">Fecha de levantamiento de la acta  de titulación</h4>
                                            <h4 style="text-align: center; color: #1f6fb2">{{ $reg_fecha_titulacion->fecha_titulacion }}</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 col-md-offset-4">
                                        <p></p>
                                        <p></p>
                                        <a class="pull-right btn_edit_info"  ><span
                                                    style="font-size:30px;"
                                                    aria-hidden="true"
                                                    class="glyphicon glyphicon-cog"
                                                    data-toggle="tooltip"
                                                    title="Editar datos del acta de titulación" id="editar_datos_titulacion"></span></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @if($registro_datos->mencion_honorifica == 1)
                    @if($datos_mencion_honorifica != '')
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="panel panel-info">
                                    <div class="panel-body">
                                        <h4 style="text-align: center">Datos de la  mención honorifica</h4>
                                        <div class="row">
                                            <div class="col-md-4  col-md-offset-1">
                                                <div class="form-group">
                                                    <h4 style="text-align: center">Número de registro de la mencion honorifica</h4>
                                                    <h4 style="text-align: center; color: #1f6fb2">{{  $datos_mencion_honorifica->no_registro }}</h4>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h4 style="text-align: center">Fecha de registro de la mencion honorifica</h4>
                                                    <h4 style="text-align: center; color: #1f6fb2">{{  $reg_fecha_titulacion->fecha_titulacion }}</h4>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-1">
                                                <div class="form-group">
                                                    <h4 style="text-align: center">Número de libro de registro</h4>
                                                    <h4 style="text-align: center; color: #1f6fb2">{{  $datos_mencion_honorifica->libro_registro }}</h4>
                                                </div>
                                            </div>


                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-5">

                                <button type="button" class="btn btn-success btn-lg" id="guardar_autorizacion" >Autorizar datos</button>

                                <p><br></p>
                            </div>
                        </div>

                        <div class="modal fade" id="modal_modificar_mencion_honorifica" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <form id="form_mod_mencion_honorifica" class="form" action="{{url("//titulacion/descargar_acta_mencion_honoriica/$id_alumno")}}" role="form" method="POST" >
                                        {{ csrf_field() }}
                                        <div class="modal-header bg-info">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title text-center" id="myModalLabel">Modificar datos de la mención honorifica</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-10 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label for="numero_acta_titulación">Número de registro de la mencion honorifica</label>
                                                        <input class="form-control"   type="text"  id="numero_registro" name="no_registro" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$datos_mencion_honorifica->no_registro}}"  required>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label for="numero_libro_acta_titulacion">Fecha de registro de la mencion honorifica</label>
                                                        <input class="form-control required" id="fecha_registro_mencion" name="fecha_registro_mencion" value="{{ $reg_fecha_titulacion->fecha_titulacion }}" readonly type="text"   value="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label for="libro_registro ">Número de libro de registro</label>
                                                        <input class="form-control"   type="number"  id="libro_registro" name="libro_registro" value="{{ $datos_mencion_honorifica->libro_registro}}"   required>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                            <button   type="submit" style="" class="btn btn-primary"  >Guardar modificación</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="panel panel-info">
                                    <div class="panel-body">
                                        <h4 style="text-align: center">Registrar datos de la  mención honorifica</h4>
                                        <form id="form_guardar_datos_mencion" class="form" action="{{url("/titulacion/registrar_datos_mencion/$id_alumno")}}" role="form" method="POST" >
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-4  col-md-offset-1">
                                                    <div class="form-group">
                                                        <label for="numero_acta_titulación">Número de registro de la mencion honorifica</label>
                                                        <input class="form-control"   type="text"  id="numero_registro" name="no_registro" onkeyup="javascript:this.value=this.value.toUpperCase();" value=""  required>

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="numero_libro_acta_titulacion">Fecha de registro de la mencion honorifica</label>
                                                        <input class="form-control required" id="fecha_registro_mencion" name="fecha_registro_mencion" value="{{ $reg_fecha_titulacion->fecha_titulacion }}" readonly type="text"   value="" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="libro_registro ">Número de libro de registro</label>
                                                        <input class="form-control"   type="number"  id="libro_registro" name="libro_registro" value=""   required>

                                                    </div>
                                                </div>

                                            </div>

                                        </form>
                                        <div class="row">
                                            <div class="col-md-2 col-md-offset-5">
                                                <p></p>
                                                <p></p>
                                                <button type="button " class="btn btn-primary btn-lg" id="guardar_mencion_honorifica" >Guardar</button>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @else
                <div class="row">
                    <div class="col-md-3 col-md-offset-5">

                        <button type="button" class="btn btn-success btn-lg" id="guardar_autorizacion" >Autorizar datos</button>

                        <p><br></p>
                    </div>
                </div>
                    @endif
            @endif

            @endif
            <div class="modal fade" id="modal_modificar_oficio_recursos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="form_agregar_periodo" class="form" action="{{url("/titulacion/guardar_modificacion_oficio_recursos/$id_alumno")}}" role="form" method="POST" >
                            {{ csrf_field() }}
                            <div class="modal-header bg-info">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-center" id="myModalLabel">Modificar datos del oficio recursos</h4>
                            </div>
                            <div class="modal-body">
                                <div id="contenedor_modificar_oficio_recursos">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button  id="guardar_mod_rec" type="submit" style="" class="btn btn-primary"  >Guardar modificación</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_modificar_acta_titulacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form id="form_mod_acta_titulacion" class="form" action="{{url("/titulacion/guardar_modificacion_acta_titulacion/$id_alumno")}}" role="form" method="POST" >
                            {{ csrf_field() }}
                            <div class="modal-header bg-info">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-center" id="myModalLabel">Modificar datos de la acta de titulación</h4>
                            </div>
                            <div class="modal-body">
                                <div id="contenedor_modificar_acta_titulacion">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button  id="guardar_mod_acta" type="submit" style="" class="btn btn-primary"  >Guardar modificación</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        @endif
        <style >
            /*
Full screen Modal
*/
            .fullscreen-modal .modal-dialog {
                margin: 0;
                margin-right: auto;
                margin-left: auto;
                width: 100%;
            }
            @media (min-width: 768px) {
                .fullscreen-modal .modal-dialog {
                    width: 750px;
                }
            }
            @media (min-width: 992px) {
                .fullscreen-modal .modal-dialog {
                    width: 970px;
                }
            }
            @media (min-width: 1200px) {
                .fullscreen-modal .modal-dialog {
                    width: 1500px;
                }
            }
        </style>
        <div class="modal fullscreen-modal fade" id="modal_modificar_dat_al" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">

                <div class="modal-content">
                    <form id="form_mod_dat_al" class="form" action="{{url("/titulacion/guardar_modificacion_dat_estudiante/$id_alumno")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Modificar datos del estudiante</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_modificar_dat_al">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button  id="guardar_mod_dat" type="submit" style="" class="btn btn-primary"  >Guardar modificación</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_autorizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form  class="form" action="{{url("/titulacion/guardar_autorizaciondatos_registrados/$id_alumno")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Autorizacion de datos del estudiante</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <h4>¿ Seguro que quieres autorizar los datos registrados del estudiante ?</h4>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button   type="submit" style="" class="btn btn-primary"  >Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    @endif
    <script type="text/javascript">
        $(document).ready( function() {
            $('#guardar_mod_rec').click(function (){
                swal({
                    type: "success",
                    title: "Registro exitoso",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
            $( '.fecha_inicio_prep').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',

            });
            $( '.fecha_final_prep').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',

            });
            $( '.fecha_ingreso_tec').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',

            });
            $( '.fecha_egreso_tec').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',

            });
            $( '.fecha_oficio_rec').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',

            });

            $( '.fecha_conformidad').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',

            });

            $( '.fecha_levantamiento_a').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',

            });

            $('#guardar_datos').click(function (){

                var id_nacionalidad = $("#id_nacionalidad").val();
                if(id_nacionalidad != null){
                    var id_preparatoria = $("#id_preparatoria").val();
                    if(id_preparatoria != null){
                        var fecha_inicio_preparatoria = $("#fecha_inicio_preparatoria").val();
                        if(fecha_inicio_preparatoria != ''){
                            var fecha_final_preparatoria = $("#fecha_final_preparatoria").val();
                            if(fecha_final_preparatoria != ''){
                                    var id_numero_titulacion = $("#id_numero_titulacion").val();
                                    if(id_numero_titulacion != null){
                                        var id_decision = $("#id_decision").val();
                                        if(id_decision != null){
                                            var fecha_ingreso_tesvb = $("#fecha_ingreso_tesvb").val();
                                            if(fecha_ingreso_tesvb != ''){
                                                var fecha_egreso_tesvb = $("#fecha_egreso_tesvb").val();
                                                if(fecha_egreso_tesvb != ''){
                                                    var id_fundamento_legal = $("#id_fundamento_legal").val();
                                                    if(id_fundamento_legal != null){
                                                        var id_autorizacion_reconocimiento = $("#id_autorizacion_reconocimiento").val();
                                                        if(id_autorizacion_reconocimiento != null){

                                                            var fecha_egreso_tesvb = $("#fecha_egreso_tesvb").val();
                                                            if(fecha_egreso_tesvb != ''){
                                                                var numero_foja_titulo = $("#numero_foja_titulo").val();
                                                                if(numero_foja_titulo != ''){
                                                                    var numero_libro_titulo = $("#numero_libro_titulo").val();
                                                                    if(numero_libro_titulo != '') {
                                                                        $("#form_guardar_datos_alumno").submit();
                                                                        $("#guardar_datos").attr("disabled", true);
                                                                        swal({
                                                                            type: "success",
                                                                            title: "Registro exitoso",
                                                                            showConfirmButton: false,
                                                                            timer: 1500
                                                                        });
                                                                    }else{
                                                                        swal({
                                                                            position: "top",
                                                                            type: "warning",
                                                                            title: "Ingresa número de libro de título",
                                                                            showConfirmButton: false,
                                                                            timer: 3500
                                                                        });
                                                                    }
                                                                }else{
                                                                    swal({
                                                                        position: "top",
                                                                        type: "warning",
                                                                        title: "Ingresa número de la foja de título",
                                                                        showConfirmButton: false,
                                                                        timer: 3500
                                                                    });
                                                                }


                                                            }else{
                                                                swal({
                                                                    position: "top",
                                                                    type: "warning",
                                                                    title: "Selecciona autorización de reconocimiento",
                                                                    showConfirmButton: false,
                                                                    timer: 3500
                                                                });
                                                            }

                                                        }else{
                                                            swal({
                                                                position: "top",
                                                                type: "warning",
                                                                title: "Selecciona autorización de reconocimiento",
                                                                showConfirmButton: false,
                                                                timer: 3500
                                                            });
                                                        }
                                                    }else{
                                                        swal({
                                                            position: "top",
                                                            type: "warning",
                                                            title: "Selecciona fundamento legal del servicio social",
                                                            showConfirmButton: false,
                                                            timer: 3500
                                                        });
                                                    }
                                                }else{
                                                    swal({
                                                        position: "top",
                                                        type: "warning",
                                                        title: "Selecciona fecha de egreso al tesvb",
                                                        showConfirmButton: false,
                                                        timer: 3500
                                                    });
                                                }
                                            }else{
                                                swal({
                                                    position: "top",
                                                    type: "warning",
                                                    title: "Selecciona fecha de ingreso al tesvb",
                                                    showConfirmButton: false,
                                                    timer: 3500
                                                });
                                            }
                                        }else{
                                            swal({
                                                position: "top",
                                                type: "warning",
                                                title: "Selecciona decisión del jurado",
                                                showConfirmButton: false,
                                                timer: 3500
                                            });
                                        }
                                    }else{
                                        swal({
                                            position: "top",
                                            type: "warning",
                                            title: "Selecciona folio de titulación",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }


                            }else{
                                swal({
                                    position: "top",
                                    type: "warning",
                                    title: "Selecciona fecha de egreso a la preparatoria",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }
                        }else{
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona fecha de ingreso a la preparatoria",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }else{
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Selecciona preparatoria que curso el estudiante.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                }else{
                    swal({
                        position: "top",
                        type: "warning",
                        title: "Selecciona la nacionalidad del estudiante.",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });


            $('#guardar_mencion_honorifica').click(function (){
                var numero_registro = $("#numero_registro").val();

                if(numero_registro != ''){
                    var libro_registro = $("#libro_registro").val();

                    if(libro_registro != ''){
                        $("#guardar_mencion_honorifica").attr("disabled", true);
                    $("#form_guardar_datos_mencion").submit();

                    swal({
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    }else{
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Ingresa número del libro de registro.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }else{
                    swal({
                        position: "top",
                        type: "warning",
                        title: "Ingresa número de registro de la mencion honorifica.",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            });
            $("#guardar_oficio_recursos").click(function (){
                var fecha_oficio_recurso = $("#fecha_oficio_recurso").val();

                if( fecha_oficio_recurso != ''){
                    var numero_oficio_recurso = $("#numero_oficio_recurso").val();
                    if(numero_oficio_recurso != ''){
                        $("#form_guardar_oficio_recursos").submit();
                        $("#guardar_oficio_recursos").attr("disabled", true);
                        swal({
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 1500
                        });

                    }else{
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Ingresa número de registro del oficio de recursos.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                }else{
                    swal({
                        position: "top",
                        type: "warning",
                        title: "Ingresa fecha de registro del oficio de recursos.",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            });
            $("#editar_oficio_recursos").click(function (){

                var id_alumno={{ $id_alumno }};

                $.get("/titulacion/modificar_oficio_recursos/"+id_alumno,function(request){
                    $("#contenedor_modificar_oficio_recursos").html(request);
                    $("#modal_modificar_oficio_recursos").modal('show');

                });
            });
            $("#editar_mencion_honorifica").click(function (){
                    $("#modal_modificar_mencion_honorifica").modal('show');
            });

            $("#editar_datos_titulacion").click(function (){

                var id_alumno={{ $id_alumno }};

                $.get("/titulacion/modificar_datos_acta_titulacion/"+id_alumno,function(request){
                    $("#contenedor_modificar_acta_titulacion").html(request);
                    $("#modal_modificar_acta_titulacion").modal('show');

                });
            });
            $("#guardar_acta_titulacion").click(function (){
                var numero_acta_titulación = $("#numero_acta_titulación").val();

                if(numero_acta_titulación != ''){

                    var numero_libro_acta_titulacion = $("#numero_libro_acta_titulacion").val();
                    if(numero_libro_acta_titulacion != ''){
                        var foja_acta_titulacion = $("#foja_acta_titulacion").val();
                        if(foja_acta_titulacion != ''){
                            var hora_conformidad_acta = $("#hora_conformidad_acta").val();
                            if(hora_conformidad_acta != ''){
                                var fecha_conformidad_acta = $("#fecha_conformidad_acta").val();
                                if(fecha_conformidad_acta != ''){
                                    var hora_levantamiento_acta = $("#hora_levantamiento_acta").val();
                                    if(hora_levantamiento_acta != ''){
                                        var fecha_levantamiento_acta = $("#fecha_levantamiento_acta").val();
                                        if(fecha_levantamiento_acta != ''){

                                            $("#form_guardar_datos_acta_titulacion").submit();
                                            $("#guardar_acta_titulacion").attr("disabled", true);
                                            swal({
                                                type: "success",
                                                title: "Registro exitoso",
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                        }
                                        else{
                                            swal({
                                                position: "top",
                                                type: "warning",
                                                title: "Selecciona la fecha de levantamiento de la acta  de titulación.",
                                                showConfirmButton: false,
                                                timer: 3500
                                            });
                                        }
                                    }
                                    else{
                                        swal({
                                            position: "top",
                                            type: "warning",
                                            title: "Selecciona la hora de levantamiento de la acta  de titulación.",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }
                                }
                                else{
                                    swal({
                                        position: "top",
                                        type: "warning",
                                        title: "Selecciona la fecha de conformidad de la acta  de titulación.",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }
                            }
                            else{
                                swal({
                                    position: "top",
                                    type: "warning",
                                    title: "Selecciona la hora de conformidad de la acta  de titulación.",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }
                        }
                        else{
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa número de foja de la acta de titulación.",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    else{
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Ingresa número del libro de actas de titulación.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                }else{
                    swal({
                        position: "top",
                        type: "warning",
                        title: "Ingresa número de la acta de titulación.",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_mod_acta").click(function (){
                var numero_acta_ti = $("#numero_acta_ti").val();

                if(numero_acta_ti != ''){

                    var numero_libro_acta_ti = $("#numero_libro_acta_ti").val();
                    if(numero_libro_acta_ti != ''){

                        var foja_acta_ti = $("#foja_acta_ti").val();
                        if(foja_acta_ti != ''){

                            var hora_conformidad_acta_ti = $("#hora_conformidad_acta_ti").val();
                            if(hora_conformidad_acta_ti != ''){

                                var fecha_conformidad_acta_ti = $("#fecha_conformidad_acta_ti").val();
                                if(fecha_conformidad_acta_ti != ''){

                                    var hora_levantamiento_acta_ti = $("#hora_levantamiento_acta_ti").val();
                                    if(hora_levantamiento_acta_ti != ''){

                                        var fecha_levantamiento_acta_ti = $("#fecha_levantamiento_acta_ti").val();
                                        if(fecha_levantamiento_acta_ti != ''){

                                            $("#form_mod_acta_titulacion").submit();
                                            $("#guardar_mod_acta").attr("disabled", true);
                                            swal({
                                                type: "success",
                                                title: "Modificación exitosa",
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                        }
                                        else{
                                            swal({
                                                position: "top",
                                                type: "warning",
                                                title: "Selecciona la fecha de levantamiento de la acta  de titulación.",
                                                showConfirmButton: false,
                                                timer: 3500
                                            });
                                        }
                                    }
                                    else{
                                        swal({
                                            position: "top",
                                            type: "warning",
                                            title: "Selecciona la hora de levantamiento de la acta  de titulación.",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }
                                }
                                else{
                                    swal({
                                        position: "top",
                                        type: "warning",
                                        title: "Selecciona la fecha de conformidad de la acta  de titulación.",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }
                            }
                            else{
                                swal({
                                    position: "top",
                                    type: "warning",
                                    title: "Selecciona la hora de conformidad de la acta  de titulación.",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }
                        }
                        else{
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa número de foja de la acta de titulación.",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                    else{
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Ingresa número del libro de actas de titulación.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                }else{
                    swal({
                        position: "top",
                        type: "warning",
                        title: "Ingresa número de la acta de titulación.",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#editar_datos_alumnos").click(function (){
                var id_alumno={{ $id_alumno }};

                $.get("/titulacion/modificar_datos_estudiante_dep/"+id_alumno,function(request){
                    $("#contenedor_modificar_dat_al").html(request);
                    $("#modal_modificar_dat_al").modal('show');

                });
            });
            $("#guardar_mod_dat").click(function (){
                swal({
                    type: "success",
                    title: "Modificación exitosa",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
            $("#guardar_autorizacion").click(function (){
                $("#modal_autorizacion").modal('show');

            });
        });


    </script>
@endsection
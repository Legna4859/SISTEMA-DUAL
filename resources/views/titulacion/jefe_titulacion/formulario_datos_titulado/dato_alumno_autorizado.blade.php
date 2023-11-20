@extends('layouts.app')
@section('title', 'Titulación')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/titulacion/alumnos_autorizados_carrera/$registro_datos->id_carrera")}}">Estudiantes titulados</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Datos autorizados del estudiante titulado</span>

            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Datos autorizados del estudiante titulado  <br>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    @if($estado_titulo ->id_numero_titulo == 0)
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">El o la estudiante {{ $registro_datos->nombre_al }} {{ $registro_datos->apaterno }} {{ $registro_datos->amaterno }} no tiene registrado número de folio o fue modificado <br>
                        </h3>
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
                                    <h4>{{ $datos_alumnos->edad }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha_nacimiento" style="color: #1f6fb2">Fecha de nacimiento </label>
                                    <h4>{{ $datos_alumnos->fecha_nacimiento }}</h4>
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

                    </div>
                </div>
            </div>
        </div>


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


                            </div>


                        </div>
                    </div>
                </div>
            </div>
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



                            </div>
                        </div>
                    </div>
                </div>
        @if($datos_alumnos->mencion_honorifica == 1)
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
            @endif
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Nombre del documento</th>
                            <th>Estado</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Acta de titulación profesional</td>
                            <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/descargar_acta_titulacion/'.$reg_fecha_titulacion->id_alumno )}}')">Imprimir</button></td>



                        </tr>
                        <tr>
                            <td>Oficios de recursos</td>
                            <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/descargar_oficio_recursos/'.$reg_fecha_titulacion->id_alumno )}}')">Imprimir</button></td>


                        </tr>
                        <tr>
                            <td>Acta de extensión de examen profesional</td>
                            <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/descargar_acta_extención_examen/'.$reg_fecha_titulacion->id_alumno )}}')">Imprimir</button></td>

                        </tr>
                        <tr>
                            <td>Certificación de antecedentes académicos</td>
                            <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/descargar_certificado_antecedentes/'.$reg_fecha_titulacion->id_alumno )}}')">Imprimir</button></td>

                        </tr>
                        @if($registro_datos->mencion_honorifica == 1)
                        <tr>
                            <td>Acta de mención honorifica</td>
                            <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/descargar_acta_mencion_honoriica/'.$reg_fecha_titulacion->id_alumno )}}')">Imprimir</button></td>

                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



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
@endif

@endsection
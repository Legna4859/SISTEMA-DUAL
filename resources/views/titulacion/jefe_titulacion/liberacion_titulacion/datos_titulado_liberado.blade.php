@extends('layouts.app')
@section('title', 'Titulacion')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/titulacion/registro_titulados_carrera/$registro1->id_carrera")}}">Ver titulados liberados </a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Datos del estudiante titulado</span>

            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10  col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Datos del estudiante titulado</h3>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p style="text-align: center;"><b>DATOS DE REGISTRO PARA TITULACIÓN DEL ESTUDIANTE</b></p>
                            <p><b>NO. CUENTA:</b>  {{ $registro1->no_cuenta }}</p>
                            <p><b>NOMBRE DEL ESTUDIANTE: </b>   {{ $registro1->nombre_al }} {{ $registro1->apaterno }} {{ $registro1->amaterno }}</p>
                            <p><b>FECHA DE REGISTRO PARA TITULACIÓN: </b>  {{ $registro1->fecha_registro }}</p>
                            <p><b>DESCUENTO DE TITULACIÓN: </b>  {{ $registro1->tipo_desc }}</p>
                            <p><b>TELEFONO: </b>  {{ $registro1->telefono }}</p>
                            <p><b>NOMBRE DE LA PREPARATORIA: </b>  {{ $preparatoria->preparatoria }}</p>
                            <p><b>TIPO DE ESTUDIO ANTECEDENTE DE LA PREPARATORIA: </b>  {{ $preparatoria->tipo_estudio_antecedente }}</p>
                            <p><b>TIPO EDUCATIVO ANTECEDENTE DE LA PREPARATORIA: </b>  {{ $preparatoria->tipo_educativo_atecedente }}</p>
                            <p><b>ENTIDAD FEDERATIVA DE LA PREPARATORIA: </b>  {{ $preparatoria->nom_entidad }}</p>
                            <p><b>CLAVE DE LA ENTIDAD FEDERATIVA DE LA PREPARATORIA: </b>  {{ $preparatoria->clave_entidad }}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p style="text-align: center;"><b>DOCUMENTACIÓN DE REQUISITOS PARA TITULACIÓN DEL ESTUDIANTE</b></p>
                            <p><b>Oficio de requisitos para trámite de titulación: </b>   <a  target="_blank"  href="/titulacion/pdf_requisitos_tramite_titulacion/{{$documentacion_requisitos->id_alumno   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></p>

                            <p><b>Acta de nacimiento:</b>   <a  target="_blank" href="/titulacion/{{$documentacion_requisitos->pdf_acta_nac   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></p>
                            <p><b>Curp:</b>   <a  target="_blank" href="/titulacion/{{$documentacion_requisitos->pdf_curp   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></p>
                            <p><b>Certificado de preparatoria legalizado (Documento legalizado y escaneado por los dos lados):</b>   <a  target="_blank" href="/titulacion/{{$documentacion_requisitos->pdf_certificado_prep   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></p>
                            <p><b>Certificado del TESVB (Documento escaneado por los dos lados):</b>   <a  target="_blank" href="/titulacion/{{$documentacion_requisitos->pdf_certificado_tesvb   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></p>
                            <p><b>Constancia de liberación del Servicio Social:</b>   <a  target="_blank" href="/titulacion/{{$documentacion_requisitos->pdf_constancia_ss   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></p>
                            <p><b>Constancia de Acreditación del Idioma Ingles:</b>   <a  target="_blank" href="/certificado_ingles/{{$certificado_ingles->pdf_certificado   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></p>
                            @if($estado_egel == 1)
                            <p><b>Reporte individual de resultados del EGEL (ceneval) :</b>   <a  target="_blank" href="/titulacion/{{$documentacion_requisitos->pdf_reporte_result_egel   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></p>
                            @endif
                            <p>Opcion de titulación:
                                    @if($documentacion_requisitos->id_opcion_titulacion == 1)
                                        <b>I. Informe de residencia</b> Caratula final de residencia
                                    @elseif($documentacion_requisitos->id_opcion_titulacion == 2)
                                    <b>II. Proyecto de Innovación</b>  Constancia de Viabilidad
                                    @elseif($documentacion_requisitos->id_opcion_titulacion == 3)
                                    <b>III. Proyecto de investigación</b> Constancia de Viabilidad
                                    @elseif($documentacion_requisitos->id_opcion_titulacion == 4)
                                    <b>IV. Informe de Estancia</b> Constancia de Viabilidad
                                    @elseif($documentacion_requisitos->id_opcion_titulacion == 5)
                                    <b>V. Tesis</b> Constancia de Viabilidad
                                    @elseif($documentacion_requisitos->id_opcion_titulacion == 6)
                                    <b>VI. Tesina</b>  Constancia de Viabilidad
                                    @elseif($documentacion_requisitos->id_opcion_titulacion == 7)
                                    <b>VII. Otros : Ceneval</b> Testimonio del examen EGEL
                                    @elseif($documentacion_requisitos->id_opcion_titulacion == 8)
                                    <b>VII. Otros : Examen por área del conocimiento</b>  No se necesita documento
                                    @elseif($documentacion_requisitos->id_opcion_titulacion == 9)
                                    <b>VII. Otros : Experiencia Profesional</b> Constancia de Viabilidad
                                        @elseif($documentacion_requisitos->id_opcion_titulacion == 10)
                                            <b>VII. Otros : Incubación de negocio</b>  Constancia de Viabilidad
                                     @elseif($documentacion_requisitos->id_opcion_titulacion == 11)
                                    <b>VII. Otros : Modalidad dual</b> Constancia de estudios en el programa dual
                                        @endif
                                @if($documentacion_requisitos->id_opcion_titulacion != 8)
                                 <a  target="_blank" href="/titulacion/{{$documentacion_requisitos->pdf_opcion_titulacion   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                              @endif
                            </p>
                            <p><b>Constancia de No Adeudo:</b>   <a  target="_blank" href="/titulacion/{{$documentacion_requisitos->pdf_constancia_adeudo   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></p>
                            <p><b>Pago de registro de título profesional de licenciatura con timbre holograma: </b>   <a  target="_blank" href="/titulacion/{{$documentacion_requisitos->pdf_pago_titulo   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></p>
                            <p><b>Pago de constancia de no adeudo: </b>   <a  target="_blank" href="/titulacion/{{$documentacion_requisitos->pdf_pago_contancia   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></p>
                            <p><b>Pago de derecho de titulación: </b>   <a  target="_blank" href="/titulacion/{{$documentacion_requisitos->pdf_pago_derecho_ti   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></p>
                            <p><b>Pago de integrantes a jurado: </b>   <a  target="_blank" href="/titulacion/{{$documentacion_requisitos->pdf_pago_integrante_jurado   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></p>
                            <p><b>Pago por concepto de autenticación de títulos profesionales diplomas o grados académicos electrónicos, para escuelas estatales oficiales o particulares incorporadas de: licenciatura o posgrado, por cada uno.: </b>   <a  target="_blank" href="/titulacion/{{$documentacion_requisitos->pdf_pago_concepto_autenticacion   }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></p>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p style="text-align: center;"><b>DATOS PERSONALES DEL ESTUDIANTE</b></p>
                            <p><b>Correo electronico: </b>  {{ $datos_personales->correo_electronico }}</p>
                            <p><b>Fecha de emisión del certificado: </b>  {{ $datos_personales->fecha_emision_certificado }}</p>
                            <p><b>Fecha de registro del trámite de titulación: </b>  {{ $datos_personales->fecha_reg_tramite_titulacion }}</p>
                            <p><b>Fecha de pago de derecho de titulación: </b>  {{ $datos_personales->fecha_pag_derechos_titulacion }}</p>
                            <p><b>¿ Eres estudiante regular o de revalidación ?: </b>  {{ $datos_personales->tipo_estudiante }}</p>
                            <p><b>Curp: </b>  {{ $datos_personales->curp_al }}</p>
                            <p><b>Carrera: </b>  {{ $datos_personales->carrera }}</p>
                            <p><b>Plan de Estudio: </b>  {{ $datos_personales->plan_estudio }}</p>
                            <p><b>Promedio General del TESVB: </b>  {{ $datos_personales->promedio_general_tesvb }}</p>
                            <p><b>¿ Reprobaste alguna materia ?: </b>@if($datos_personales->reprobacion_mat == 2 )  NO @else SI  @endif</p>
                            <p><b>Fecha de ingreso al TESVB: </b>  {{ $datos_personales->fecha_ingreso_tesvb }}</p>
                            <p><b>Fecha de egreso al TESVB: </b>  {{ $datos_personales->fecha_egreso_tesvb }}</p>
                            <p><b>Número de semestres cursados: </b>  {{ $datos_personales->id_semestre }}</p>
                            <p><b>Nombre del proyecto: </b>  {{ $datos_personales->nom_proyecto }}</p>
                            <p><b>Jefe de división: </b>  {{ $datos_personales->nombre_jefe_division }}</p>
                            <p><b>Nombre de la empresa donde se realizó la Residencia Profesional: </b>  {{ $datos_personales->nom_empresa }}</p>
                            <p><b>Red Social que utilizas habitualmente: </b>  {{ $datos_personales->red_social }}</p>
                            <p><b>¿Cuál es tu nombre de usuario de la red social ?: </b>  {{ $datos_personales->nombre_usuario_red }}</p>
                            <p><b>Tipo de donación: </b>  {{ $datos_personales->tipo_donacion }}</p>
                            <p><b>Presentas alguna discapacidad: </b>  </b>@if($datos_personales->presenta_discapacidad == 2 )  NO @else SI <b>¿Cuál? {{ $datos_personales->discapacidad_que_presenta }}</b> @endif</p>
                            <p><b>Hablas alguna lengua indígena: </b> </b>@if($datos_personales->lengua_indigena == 2 )  NO @else SI <b>¿Cuál? {{ $datos_personales->habla_lengua_indigena }}</b> @endif</p>
                            <p><b>Nacionalidad: </b>  {{ $datos_personales->nacionalidad }}</p>
                            <p><b>Fecha de ingreso a la preparatoria o bachillerato que estudiaste: </b>  {{ $datos_personales->fecha_ingreso_preparatoria }}</p>
                            <p><b>Fecha de egreso a la preparatoria o bachillerato que estudiaste: </b>  {{ $datos_personales->fecha_egreso_preparatoria }}</p>
                            <p><b>Mención honorifica: </b> @if($datos_personales->mencion_honorifica == 2) SIN MENCIÓN HONORIFICA @else CON MENCIÓN HONORIFICA @endif</p>
                            <p style="text-align: center;"><b>DOMICILIO DEL ESTUDIANTE </b></p>
                            <p><b>Calle: </b>  {{ $datos_personales->calle_domicilio }}</p>
                            <p><b>Número: </b>  {{ $datos_personales->numero_domicilio }}</p>
                            <p><b>Colonia o comunidad: </b>  {{ $datos_personales->colonia_domicilio }}</p>
                            <p><b>Municipio o Ciudad: </b>  {{ $datos_personales->nombre_municipio }}</p>
                            <p><b>Entidad Federativa: </b>  ESTADO DE {{ $datos_personales->nombre_estado }}</p>

                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                @if($datos_personales->id_tipo_donacion == 1)
                                    <p style="text-align: center;"><b>DONACIÓN DE LIBROS</b></p>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>TITULO</th>
                                            <th>AUTOR</th>
                                            <th>EDITORIAL</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($libros as $libro)
                                                <tr>
                                                    <td>{{ $libro->titulo }}</td>
                                                    <td>{{ $libro->autor }}</td>
                                                    <td>{{ $libro->editorial }}</td>
                                                </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                @elseif($datos_personales->id_tipo_donacion == 2)
                                    <p style="text-align: center;"><b>DONACIÓN DE EQUIPO DE COMPUTO</b></p>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>NOMBRE DEL EQUIPO</th>
                                                <th>DESCRIPCIÓN DEL EQUIPO</th>
                                                <th>FOLIO FISCAL</th>
                                                <th>TIENDA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($equipos_computo as $computo)
                                            <tr>
                                                <td>{{ $computo->nombre_equipo }}</td>
                                                <td>{{ $computo->descripcion }}</td>
                                                <td>{{ $computo->folio_fiscal }}</td>
                                                <td>{{ $computo->nombre_tienda }}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                @endif

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p style="text-align: center;"><b>DATOS DEL JURADO DEL ESTUDIANTE</b></p>
                            <p><b>Nombre de la sala: </b>{{ $datos_jurado->nombre_sala }} </p>
                            <p><b>Fecha de titulación: </b>{{ $datos_jurado->fecha_titulacion }} </p>
                            <p><b>Hora de titulación: </b>{{ $hora->hora }} </p>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Jurado</th>
                                            <th>Nombre del integrante de jurado</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Presidente </td>
                                            <td>{{ $dato_presidente->nombre }}</td>
                                        </tr>
                                        <tr>
                                            <td>Secretario</td>
                                            <td>{{ $dato_secretario->nombre }}</td>
                                        </tr>
                                        <tr>
                                            <td>Vocal</td>
                                            <td>{{ $dato_vocal->nombre }}</td>
                                        </tr>
                                        <tr>
                                            <td>Suplente</td>
                                            <td>{{ $dato_suplente->nombre }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Nombre del documento </th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Oficio de notificación del Jurado (Jefe de División) </td>
                                                <td>
                                                    Fecha del oficio: <b>{{ $datos_jurado->fecha_oficio_noti_jurado_jefe }}</b> <br>
                                                    Número de oficio: <b>{{ $datos_jurado->oficio_noti_jurado_jefe }}</b> <br>
                                                    <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/pdf_oficio_notificacion_jefe/'.$datos_jurado->id_fecha_jurado_alumn)}}')">Imprimir oficio</button>
                                                </td>
                                        </tr>
                                        <tr>
                                            <td>Oficio de notificación del Jurado (Estudiante) </td>
                                                <td>
                                                    Fecha del oficio: <b>{{ $datos_jurado->fecha_oficio_noti_jurado_estudiante }}</b> <br>
                                                    Número de oficio: <b>{{ $datos_jurado->oficio_noti_jurado_estudiante }}</b> <br>
                                                    <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/pdf_oficio_notificacion_estudiante/'.$datos_jurado->id_fecha_jurado_alumn)}}')">Imprimir oficio</button>
                                                </td>
                                        </tr>
                                        <tr>
                                            <td>Carta de compromiso</td>
                                            <td>
                                                <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/pdf_carta_compromiso/'.$datos_jurado->id_fecha_jurado_alumn)}}')">Imprimir oficio</button>
                                            </td>
                                        </tr>
                                        @if($datos_jurado->honorifica == 1)
                                            <tr>
                                                <td>Mención honorifica</td>
                                                    <td>
                                                        Fecha del oficio: <b>{{ $datos_jurado->fecha_mencion_honorifica }}</b> <br>
                                                        Número de oficio: <b>{{ $datos_jurado->mencion_honorifica }}</b> <br>
                                                        <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/pdf_mencion_honorifica/'.$datos_jurado->id_fecha_jurado_alumn)}}')">Imprimir oficio</button>
                                                    </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p style="text-align: center;"><b>DATOS DEL ESTUDIANTE REGISTRADOS POR EL DEPARTAMENTO DE TITULACIÓN</b></p>
                            <p><b>CLAVE DE LA CARRERA:</b>  {{ $datos_reg_dep->clave }}</p>
                            <p><b>GENERO DEL ESTUDIANTE: </b>   {{ $datos_reg_dep->genero }}</p>
                            <p><b>SEXO DEL ESTUDIANTE: </b>  {{ $datos_reg_dep->sexo }}</p>
                            <p><b>EDAD DEL ESTUDIANTE: </b>  {{ $datos_reg_dep->edad }}</p>
                            <p><b>FECHA DE NACIMIENTO DEL ESTUDIANTE: </b>  {{ $datos_reg_dep->fecha_nacimiento }}</p>
                            <p><b>FOLIO DE TITULACIÓN DEL ESTUDIANTE: </b>  {{ $datos_reg_dep->abreviatura_folio_titulo }}</p>
                            <p><b>NÚMERO DE FOJA DE TITULO DEL ESTUDIANTE: </b>  {{ $datos_reg_dep->numero_foja_titulo }}</p>
                            <p><b>NÚMERO DE LIBRO DE TITULO DEL ESTUDIANTE: </b>  {{ $datos_reg_dep->numero_libro_titulo }}</p>
                            <p><b>TITULO OBTENIDO DEL ESTUDIANTE: </b>  {{ $datos_reg_dep->tipo_titulo }}</p>
                            <p><b>DESICIÓN DEL JURADO: </b>  {{ $datos_reg_dep->decision }}</p>
                            <p><b>FUNDAMENTO LEGAL DEL SERVICIO SOCIAL: </b>  {{ $datos_reg_dep->fundamento_legal }}</p>
                            <p><b>AUTORIZACIÓN DE RECONOCIMIENTO: </b>  {{ $datos_reg_dep->autorizacion_reconocimiento }}</p>
                            <p><b>NÚMERO DE OFICIO DE RECURSOS: </b>  {{ $oficio_recursos->numero_oficio_recursos }}</p>
                            <p><b>NÚMERO DE ACTA DE TITULACIÓN: </b>  {{ $acta_titulacion->numero_acta_titulacion }}</p>
                            <p><b>NÚMERO DE LIBRO DE ACTAS DE TITULACIÓN: </b>  {{ $acta_titulacion->numero_libro_acta_titulacion }}</p>
                            <p><b>HORA DE CONFORMIDAD  DE LA ACTA DE TITULACIÓN: </b>  {{ $acta_titulacion->hora_conformidad_acta }}</p>
                            <p><b>HORA DE LEVANTAMIENTO  DE LA ACTA DE TITULACIÓN: </b>  {{ $acta_titulacion->hora_levantamiento_acta }}</p>
                            @if($datos_jurado->honorifica == 1)
                            <p><b>NÚMERO DE REGISTRO DE MENCIÓN HONORIFICA: </b>  {{ $datos_mencion_honorifica->no_registro }}</p>
                            <p><b>NÚMERO DE LIBRO DE REGISTRO DE MENCIÓN HONORIFICA: </b>  {{ $datos_mencion_honorifica->libro_registro }}</p>
                                @endif

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <p><br></p>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Nombre del documento</th>
                                    <th>Acción</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Acta de titulación profesional</td>
                                    <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/descargar_acta_titulacion/'.$datos_reg_dep->id_alumno )}}')">Imprimir</button></td>



                                </tr>
                                <tr>
                                    <td>Oficios de recursos</td>
                                    <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/descargar_oficio_recursos/'.$datos_reg_dep->id_alumno )}}')">Imprimir</button></td>


                                </tr>
                                <tr>
                                    <td>Acta de extensión de examen profesional</td>
                                    <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/descargar_acta_extención_examen/'.$datos_reg_dep->id_alumno )}}')">Imprimir</button></td>

                                </tr>
                                <tr>
                                    <td>Certificación de antecedentes académicos</td>
                                    <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/descargar_certificado_antecedentes/'.$datos_reg_dep->id_alumno )}}')">Imprimir</button></td>

                                </tr>
                                @if($datos_reg_dep->mencion_honorifica == 1)
                                    <tr>
                                        <td>Acta de mención honorifica</td>
                                        <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/descargar_acta_mencion_honoriica/'.$datos_reg_dep->id_alumno )}}')">Imprimir</button></td>

                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>





@endsection
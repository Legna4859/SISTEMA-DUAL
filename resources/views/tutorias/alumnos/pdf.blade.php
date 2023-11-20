<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/popper.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/estilo.css')}}" type="text/css">
    <link rel="stylesheet" href={{asset("css/app.css")}} type="text/css">
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/datapicker.js')}}"></script>
    <script src="{{asset('js/highcharts.js')}}"></script>
    <link type="text/css" rel="stylesheet" href="{{asset('css/all.css')}}">
<style>
.pbu{
    margin: 1.75% 0;
}
.sizeF{
    font-size:.74em;
}
.sizeFCel{
    font-size:.811em;
}
</style>
</head>
    <body>
        <div class="container">
            <div class="row">
                <div class="card col-12 mb-2">
                    <div class="card-body text-capitalize">

                        <div class="row border border-dark sizeF text-center font-weight-bolder">
                                <div class="col-11 bg-secondary border border-dark sizeF text-center">
                                        <div class="row bg-secondary">
                                            <div class="col-12 bg-success text-white text-center ">
                                                <h6 class="pbu"><strong>EXPEDIENTE DEL TUTORADO</strong></h6>
                                            </div>
                                            <div class="col-12 bg-success text-white border border-dark text-center ">
                                                    <h6 class="pbu">DATOS GENERALES</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <img src="{{asset('img/ff.jpg')}}" class=" rounded center"  width="90em" height="80em">

                        </div>
                        <div class="row border border-dark sizeF text-uppercase text-center">
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Carrera</p></div>
                            <div class="col-3 border border-dark sizeF"><p>{{$carreras[$datos[0]->id_carrera-1]->nombre}}</p></div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Periodo</p></div>
                            <div class="col-3 border border-dark sizeF"><p>{{$periodos[$datos[0]->id_periodo-1]->periodo}}</p></div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Grupo</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$grupos[$datos[0]->id_grupo-1]->grupo}}</p></div>

                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Edad</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[0]->edad}}</p></div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Sexo</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[0]->trabaja==1?'M':'F'}}</p></div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Semestre</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$semestres[$datos[0]->id_semestre-1]->descripcion}}</p></div>
                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Estado Civil</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$estadoC[$datos[0]->id_estado_civil-1]->desc_ec}}</p></div>


                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder" >Alumno</div>
                            <div class="col-4 border border-dark sizeF"><p>{{$datos[0]->nombre}}</p></div>
                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Fecha de Nacimiento</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[0]->fecha_nacimientos}}</p></div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>No.Hijos</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[0]->no_hijos}}</p></div>
                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Lugar de Nacimiento</p></div>
                            <div class="col-4 border border-dark sizeF"><p>{{$datos[0]->lugar_naciemientos}}</p></div>


                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Email</p></div>
                            <div class="col-3 border border-dark sizeF"><p>{{$datos[0]->correo}}</p></div>
                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Nivel Socio-economico</p></div>
                            <div class="col-1 border border-dark sizeF">
                                <p>
                                    @if ($datos[0]->id_nivel_economico==1)
                                        Alto
                                    @endif

                                    @if ($datos[0]->id_nivel_economico==2)
                                        Medio
                                    @endif
                                    @if($datos[0]->id_nivel_economico==3)
                                        Bajo
                                    @endif


                                </p>
                            </div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Tel.Casa</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[0]->tel_casa}}</p></div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Cel</p></div>
                            <div class="col-1 border border-dark sizeFCel"><p>{{$datos[0]->cel}}</p></div>
                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Dirección</p></div>
                            <div class="col-5 border border-dark sizeF"><p>{{$datos[0]->direccion}}</p></div>

                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Numero de Cuenta</p></div>
                            <div class="col-1 border border-dark sizeFCel"><p>{{$datos[0]->no_cuenta}}</p></div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Trabaja</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[0]->trabaja==1?'Si':'No'}}</p></div>
                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Ocupacion alumno</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[0]->ocupacion}}</p></div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Horario</p></div>
                            <div class="col-3 border border-dark sizeF"><p>{{$datos[0]->horario}}</p></div>


                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Estado</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[0]->estado==1?'Regular':'Irregular'}}</p></div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Turno</p></div>
                            <div class="col-1 border border-dark sizeF">
                                <p>
                                    @if ($datos[0]->turno==1)
                                        Matutino
                                    @endif

                                    @if ($datos[0]->turno==2)
                                        Vespertino
                                    @endif
                                    @if($datos[0]->turno==3)
                                        Mixto
                                    @endif
                                </p>
                            </div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Beca</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[0]->beca==1?'Si':'No'}}</p></div>
                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Tipo de Beca</p></div>
                            <div class="col-8 border border-dark sizeF"><p>{{$datos[0]->tipo_beca}}</p></div>
                        </div>
                        <div class="row border border-dark sizeF text-uppercase text-center">
                            <div class="col-12 bg-success text-white border border-dark text-center ">
                                    <h6 class="pbu">ANTECEDENTES ACADEMICOS</h6>
                            </div>
                                <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Bachillerato:</p></div>
                                <div class="col-1 border border-dark sizeF"><p>{{$datos[1]->id_bachillerato==1?'Tecnico':'General'}}</p></div>
                                <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Otros estudios:</p></div>
                                <div class="col-3 border border-dark sizeF"><p>{{$datos[1]->otros_estudios}}</p></div>
                                <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Años en que curso el Bachillerato:</p></div>
                                <div class="col-1 border border-dark sizeF"><p>{{$datos[1]->años_curso_bachillerato>5?'Mas':$datos[1]->años_curso_bachillerato}}</p></div>

                                <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Año Terminacion:</p></div>
                                <div class="col-1 border border-dark sizeF"><p>{{$datos[1]->año_terminacion}}</p></div>
                                <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Escuela de Procedencia:</p></div>
                                <div class="col-5 border border-dark sizeF"><p>{{$datos[1]->escuela_procedente}}</p></div>
                                <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Promedio:</p></div>
                                <div class="col-1 border border-dark sizeF"><p>{{$datos[1]->promedio}}</p></div>

                                <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Materias Reprobadas en Bachillerato:</p></div>
                                <div class="col-5 border border-dark sizeF"><p>{{$datos[1]->materias_reprobadas}}</p></div>
                                <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Otra Carrera Iniciada:</p></div>
                                <div class="col-1 border border-dark sizeF"><p>{{$datos[1]->otra_carrera_ini==1?'Si':'No'}}</p></div>

                                <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Institucion:</p></div>
                                <div class="col-5 border border-dark sizeF"><p>{{$datos[1]->institucion}}</p></div>
                                <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Semestres cursados:</p></div>
                                <div class="col-1 border border-dark sizeF"><p>{{$datos[1]->semestres_cursados}}</p></div>
                                <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Te gusta la carrera elegida?:</p></div>
                                <div class="col-1 border border-dark sizeF"><p>{{$datos[1]->tegusta_carrera_elegida==1?'Si':'No'}}</p></div>


                                <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Por que?:</p></div>
                                <div class="col-4 border border-dark sizeF"><p>{{$datos[1]->porque_carrera_elegida}} </p></div>
                                <div class="col-5 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Suspensión de Estudios después de terminado el bachillerato:</p></div>
                                <div class="col-1 border border-dark sizeF"><p>{{$datos[1]->suspension_estudios_bachillerato==1?'Si':'No'}}</p></div>


                                <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Razones de SUSPENSIÓN DE ESTUDIOS DESPUÉS DE TERMINADO EL BACHILLERATO</p></div>
                                <div class="col-8 border border-dark sizeF"><p>{{$datos[1]->razones_suspension_estudios}}</p></div>

                                <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Te estimula tu familia en tus estudios?:</p></div>
                                <div class="col-1 border border-dark sizeF"><p>{{$datos[1]->teestimula_familia==1?'Si':'No'}}</p></div>
                                <div class="col-6 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Tuviste otras opciones vocacionales o preferencias por otras carreras?:</p></div>
                                <div class="col-1 border border-dark sizeF"><p>{{$datos[1]->otras_opciones_vocales==1?'Si':'No'}}</p></div>


                                <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Cuales opciones vocacionales o preferencias?:</p></div>
                                <div class="col-3 border border-dark sizeF"><p>{{$datos[1]->cuales_otras_opciones_vocales}}</p></div>
                                <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Tienes información sobre el perfil profesional de la carrera?:</p></div>
                                <div class="col-2 border border-dark sizeF"><p>{{$datos[1]->sabedel_perfil_profesional}}</p></div>

                        </div>

                        <div class="row border border-dark sizeF text-uppercase text-center">
                            <div class="col-12 bg-success text-white border border-dark text-center ">
                                <h6 class="pbu">DATOS FAMILIARES</h6>
                            </div>
                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Nombre del padre:</p></div>
                            <div class="col-3 border border-dark sizeF"><p>{{$datos[2]->nombre_padre}}</p></div>
                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Edad:</p></div>
                            <div class="col-3 border border-dark sizeF"><p>{{$datos[2]->edad_padre}}</p></div>

                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Ocupación:</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[2]->ocupacion_padre}}</p></div>
                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Lugar de residencia:</p></div>
                            <div class="col-5 border border-dark sizeF"><p>{{$datos[2]->lugar_residencia_padre}}</p></div>

                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Nombre de la madre:</p></div>
                            <div class="col-3 border border-dark sizeF"><p>{{$datos[2]->nombre_madre}}</p></div>
                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Edad:</p></div>
                            <div class="col-3 border border-dark sizeF"><p>{{$datos[2]->edad_madre}}</p></div>

                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Ocupación:</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[2]->ocupacion_madre}}</p></div>
                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Lugar de residencia:</p></div>
                            <div class="col-5 border border-dark sizeF"><p>{{$datos[2]->lugar_residencia_madre}}</p></div>

                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>No. de Hermanos:</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[2]->no_hermanos}}</p></div>
                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Lugar que ocupas entre ellos:</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[2]->lugar_ocupas}}</p></div>
                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Actualmente vives:</p></div>
                            <div class="col-2 border border-dark sizeF">
                                <p>

                                    @if ($datos[2]->id_opc_vives==1)
                                        Con los padres
                                    @endif

                                    @if ($datos[2]->id_opc_vives==2)
                                         Con otros estudiantes
                                    @endif
                                    @if($datos[2]->id_opc_vives==3)
                                         Con tios u otros familiares
                                    @endif
                                    @if($datos[2]->id_opc_vives==4)
                                         Solo
                                    @endif

                                </p>
                            </div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>No.de personas:</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[2]->no_personas}}</p></div>

                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Perteneces a una etnia indigena:</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[2]->etnia_indigena==1?'Si':'No'}}</p></div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Cual?:</p></div>
                            <div class="col-3 border border-dark sizeF"><p>{{$datos[2]->cual_etnia}}</p></div>
                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Hablas una lengua indigena:</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[2]->hablas_lengua_indigena==1?'Si':'No'}}</p></div>

                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Quién sostiene economicamente tu hogar</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[2]->sostiene_economia_hogar}}</p></div>
                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Consideras a tu familia:</p></div>
                            <div class="col-2 border border-dark sizeF">
                                <p>
                                    @if ($datos[2]->id_familia_union==1)
                                        Unida
                                    @endif

                                    @if ($datos[2]->id_familia_union==2)
                                        Muy unida
                                    @endif
                                    @if($datos[2]->id_familia_union==3)
                                        Disfuncional
                                    @endif
                                </p>
                            </div>


                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Nombre del tutor:</p></div>
                            <div class="col-4 border border-dark sizeF"><p>{{$datos[2]->nombre_tutor}}</p></div>
                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Parentezco:</p></div>
                            <div class="col-3 border border-dark sizeF"><p>{{$datos[2]->id_parentesco}}</p></div>
                        </div>

                        <div class="row border border-dark sizeF text-uppercase text-center">
                            <div class="col-12 bg-success text-white border border-dark text-center ">
                                <h6 class="pbu">HABITOS DE ESTUDIO</h6>
                            </div>
                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Tiempo dedicado a estudiar fuera de clase:</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[3]->tiempo_empelado_estudiar==3?'2 horas':'3 horas'}}</p></div>
                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Como es tu forma de trabajo intelectual</p></div>
                            <div class="col-2 border border-dark sizeF">
                                <p>
                                    @if ($datos[3]->id_opc_intelectual==1)
                                        Muy rápido
                                    @endif

                                    @if ($datos[3]->id_opc_intelectual==2)
                                        Rápido
                                    @endif
                                    @if($datos[3]->id_opc_intelectual==3)
                                        Regular
                                    @endif
                                    @if($datos[3]->id_opc_intelectual==4)
                                        Lento
                                    @endif
                                    @if($datos[3]->id_opc_intelectual==5)
                                        Muy lento
                                    @endif
                                </p>
                            </div>

                            <div class="col-7 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Tu forma de estudio mas utilizada:</p></div>
                            <div class="col-5 border border-dark sizeF"><p>{{$datos[3]->forma_estudio}}</p></div>

                            <div class="col-5 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Como empleas tu tiempo libre?</p></div>
                            <div class="col-7 border border-dark sizeF"><p>{{$datos[3]->tiempo_libre}}</p></div>

                            <div class="col-7 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Asignaturas preferidas:</p></div>
                            <div class="col-5 border border-dark sizeF"><p>{{$datos[3]->asignatura_preferida}}</p></div>

                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Por qué?</p></div>
                            <div class="col-8 border border-dark sizeF"><p>{{$datos[3]->porque_asignatura}}</p></div>

                            <div class="col-7 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Asignaturas que te han sido dificiles:</p></div>
                            <div class="col-5 border border-dark sizeF"><p>{{$datos[3]->asignatura_dificil}}</p></div>

                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Por qué?</p></div>
                            <div class="col-8 border border-dark sizeF"><p>{{$datos[3]->porque_asignatura_dificil}}</p></div>

                            <div class="col-7 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Qué opinas de ti mismo como estudiante</p></div>
                            <div class="col-5 border border-dark sizeF"><p>{{$datos[3]->opinion_tu_mismo_estudiante}}</p></div>
                        </div>

                        <div class="row border border-dark sizeF text-uppercase text-center">
                            <div class="col-12 bg-success text-white border border-dark text-center ">
                                <h6 class="pbu">FORMACIÓN INTEGRAL/SALUD</h6>
                            </div>
                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Practicas regualmente algun deporte?</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[4]->practica_deporte==1?'Si':'No'}}</p></div>
                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Especificar:</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[4]->especifica_deporte}}</p></div>

                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Practicas alguna actividad artistica?</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[4]->practica_artistica==1?'Si':'No'}}</p></div>
                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Especificar:</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[4]->especifica_artistica}}</p></div>

                            <div class="col-7 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Tu pasatiempo favorito:</p></div>
                            <div class="col-5 border border-dark sizeF"><p>{{$datos[4]->pasatiempo}}</p></div>

                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Practicas en actividades culturales, sociales?</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[4]->actividades_culturales==1?'Si':'No'}}</p></div>
                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Especificar:</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[4]->cuales_act}}</p></div>

                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Cómo consideras tu estado de salud?</p></div>
                            <div class="col-2 border border-dark sizeF">
                                <p>
                                    @if ($datos[4]->estado_salud==1)
                                        Excelente
                                    @endif

                                    @if ($datos[4]->estado_salud==2)
                                        Buena
                                    @endif
                                    @if($datos[4]->estado_salud==3)
                                        Regular
                                    @endif
                                    @if($datos[4]->estado_salud==4)
                                        Mala
                                    @endif
                                </p>
                            </div>
                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Padeces alguna enfermedad cronica?</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[4]->enfermedad_cronica==1?'Si':'No'}}</p></div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Especificar:</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[4]->especifica_enf_cron}}</p></div>

                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Tus padres padecen alguna enfermedad cronica?</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[4]->enf_cron_padre==1?'Si':'No'}}</p></div>
                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Especificar:</p></div>
                            <div class="col-3 border border-dark sizeF"><p>{{$datos[4]->especifica_enf_cron_padres}}</p></div>

                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Te han realizado una operación médico-quirurjica?</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[4]->operacion==1?'Si':'No'}}</p></div>
                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>De qué:</p></div>
                            <div class="col-3 border border-dark sizeF"><p>{{$datos[4]->deque_operacion}}</p></div>

                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Padeces alguna enfermedad visual?</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[4]->enfer_visual==1?'Si':'No'}}</p></div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Especificar:</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[4]->especifica_enf}}</p></div>
                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Usas lentes?</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[4]->usas_lentes==1?'Sí':'NO'}}</p></div>


                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Toma medicamento controlado?</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[4]->medicamento_controlado==1?'Sí':'No'}}</p></div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Especificar:</p></div>
                            <div class="col-3 border border-dark sizeF"><p>{{$datos[4]->especifica_medicamento}}</p></div>
                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Estatura:</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[4]->estatura}}</p></div>
                            <div class="col-1 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Peso:</p></div>
                            <div class="col-1 border border-dark sizeF"><p>{{$datos[4]->peso}}</p></div>

                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>¿Has tenido alguna enfermedad grave?</p></div>
                            <div class="col-2 border border-dark sizeF"><p>{{$datos[4]->accidente_grave==1?'Si':'No'}}</p></div>
                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Relata brevemente:</p></div>
                            <div class="col-3 border border-dark sizeF"><p>{{$datos[4]->relata_breve}}</p></div>

                        </div>

                        <div class="row border border-dark sizeF text-uppercase text-center">
                            <div class="col-12 bg-success text-white border border-dark text-center ">
                                <h6 class="pbu">ÁREA PSICOPEDAGOGICA</h6>
                            </div>

                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Rendimiento escolar:</p></div>
                            <div class="col-1 border border-dark sizeF">
                                <p>
                                    @if ($datos[5]->rendimiento_escolar==1)
                                        Excelente
                                    @endif

                                    @if ($datos[5]->rendimiento_escolar==2)
                                        Muy bien
                                    @endif
                                    @if($datos[5]->rendimiento_escolar==3)
                                        Bien
                                    @endif
                                    @if($datos[5]->rendimiento_escolar==4)
                                        Regular
                                    @endif
                                    @if($datos[5]->rendimiento_escolar==5)
                                        Mala
                                    @endif
                                </p>
                            </div>
                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Dominio del propio idioma:</p></div>
                            <div class="col-1 border border-dark sizeF">
                                <p>
                                    @if ($datos[5]->dominio_idioma==1)
                                        Excelente
                                    @endif

                                    @if ($datos[5]->dominio_idioma==2)
                                        Muy bien
                                    @endif
                                    @if($datos[5]->dominio_idioma==3)
                                        Bien
                                    @endif
                                    @if($datos[5]->dominio_idioma==4)
                                        Regular
                                    @endif
                                    @if($datos[5]->dominio_idioma==5)
                                        Mala
                                    @endif
                                </p>
                            </div>
                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Otro idioma:</p></div>
                            <div class="col-1 border border-dark sizeF">
                                <p>
                                    @if ($datos[5]->otro_idioma==1)
                                        Excelente
                                    @endif

                                    @if ($datos[5]->otro_idioma==2)
                                        Muy bien
                                    @endif
                                    @if($datos[5]->otro_idioma==3)
                                        Bien
                                    @endif
                                    @if($datos[5]->otro_idioma==4)
                                        Regular
                                    @endif
                                    @if($datos[5]->otro_idioma==5)
                                        Mala
                                    @endif
                                </p>
                            </div>
                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Conocimientos de cómputo:</p></div>
                            <div class="col-1 border border-dark sizeF">
                                <p>
                                    @if ($datos[5]->conocimiento_compu==1)
                                        Excelente
                                    @endif

                                    @if ($datos[5]->conocimiento_compu==2)
                                        Muy bien
                                    @endif
                                    @if($datos[5]->conocimiento_compu==3)
                                        Bien
                                    @endif
                                    @if($datos[5]->conocimiento_compu==4)
                                        Regular
                                    @endif
                                    @if($datos[5]->conocimiento_compu==5)
                                        Mala
                                    @endif
                                </p>
                            </div>


                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Aptitudes especiales:</p></div>
                            <div class="col-1 border border-dark sizeF">
                                <p>
                                    @if ($datos[5]->aptitud_especial==1)
                                        Excelente
                                    @endif

                                    @if ($datos[5]->aptitud_especial==2)
                                        Muy bien
                                    @endif
                                    @if($datos[5]->aptitud_especial==3)
                                        Bien
                                    @endif
                                    @if($datos[5]->aptitud_especial==4)
                                        Regular
                                    @endif
                                    @if($datos[5]->aptitud_especial==5)
                                        Mala
                                    @endif
                                </p>
                            </div>
                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Comprensión y Retención en clase:</p></div>
                            <div class="col-1 border border-dark sizeF">
                                <p>
                                    @if ($datos[5]->comprension==1)
                                        Excelente
                                    @endif

                                    @if ($datos[5]->comprension==2)
                                        Muy bien
                                    @endif
                                    @if($datos[5]->comprension==3)
                                        Bien
                                    @endif
                                    @if($datos[5]->comprension==4)
                                        Regular
                                    @endif
                                    @if($datos[5]->comprension==5)
                                        Mala
                                    @endif

                                </p>
                            </div>
                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Preparación y presentación de exámenes:</p></div>
                            <div class="col-1 border border-dark sizeF">
                                <p>
                                    @if ($datos[5]->preparacion==1)
                                        Excelente
                                    @endif

                                    @if ($datos[5]->preparacion==2)
                                        Muy bien
                                    @endif
                                    @if($datos[5]->preparacion==3)
                                        Bien
                                    @endif
                                    @if($datos[5]->preparacion==4)
                                        Regular
                                    @endif
                                    @if($datos[5]->preparacion==5)
                                        Mala
                                    @endif
                                </p>
                            </div>


                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Aplicación de estrategias de aprendizaje y estudio:</p></div>
                            <div class="col-2 border border-dark sizeF">
                                <p>
                                    @if ($datos[5]->estrategias_aprendizaje==1)
                                        Excelente
                                    @endif

                                    @if ($datos[5]->estrategias_aprendizaje==2)
                                        Muy bien
                                    @endif
                                    @if($datos[5]->estrategias_aprendizaje==3)
                                        Bien
                                    @endif
                                    @if($datos[5]->estrategias_aprendizaje==4)
                                        Regular
                                    @endif
                                    @if($datos[5]->estrategias_aprendizaje==5)
                                        Mala
                                    @endif
                                </p>
                            </div>
                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Organización en actividades de estudio:</p></div>
                            <div class="col-2 border border-dark sizeF">
                                <p>
                                    @if ($datos[5]->organizacion_actividades==1)
                                        Excelente
                                    @endif

                                    @if ($datos[5]->organizacion_actividades==2)
                                        Muy bien
                                    @endif
                                    @if($datos[5]->organizacion_actividades==3)
                                        Bien
                                    @endif
                                    @if($datos[5]->organizacion_actividades==4)
                                        Regular
                                    @endif
                                    @if($datos[5]->organizacion_actividades==5)
                                        Mala
                                    @endif
                                </p>
                            </div>


                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Concentración durante el estudio:</p></div>
                            <div class="col-2 border border-dark sizeF">
                                <p>
                                    @if ($datos[5]->concentracion==1)
                                        Excelente
                                    @endif

                                    @if ($datos[5]->concentracion==2)
                                        Muy bien
                                    @endif
                                    @if($datos[5]->concentracion==3)
                                        Bien
                                    @endif
                                    @if($datos[5]->concentracion==4)
                                        Regular
                                    @endif
                                    @if($datos[5]->concentracion==5)
                                        Mala
                                    @endif

                                </p>
                            </div>
                            <div class="col-5 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Solución de problemas y aprendizaje de las matemáticas:</p></div>
                            <div class="col-2 border border-dark sizeF">
                                <p>
                                    @if ($datos[5]->solucion_problemas==1)
                                        Excelente
                                    @endif

                                    @if ($datos[5]->solucion_problemas==2)
                                        Muy bien
                                    @endif
                                    @if($datos[5]->solucion_problemas==3)
                                        Bien
                                    @endif
                                    @if($datos[5]->solucion_problemas==4)
                                        Regular
                                    @endif
                                    @if($datos[5]->solucion_problemas==5)
                                        Mala
                                    @endif
                                </p>
                            </div>


                            <div class="col-3 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Condiciones ambientales durante el estudio:</p></div>
                            <div class="col-1 border border-dark sizeF">
                                <p>
                                    @if ($datos[5]->condiciones_ambientales==1)
                                        Excelente
                                    @endif

                                    @if ($datos[5]->condiciones_ambientales==2)
                                        Muy bien
                                    @endif
                                    @if($datos[5]->condiciones_ambientales==3)
                                        Bien
                                    @endif
                                    @if($datos[5]->condiciones_ambientales==4)
                                        Regular
                                    @endif
                                    @if($datos[5]->condiciones_ambientales==5)
                                        Mala
                                    @endif
                                </p>
                            </div>
                            <div class="col-4 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Búsqueda bibliografica e integración de información:</p></div>
                            <div class="col-1 border border-dark sizeF">
                                <p>
                                    @if ($datos[5]->busqueda_bibliografica==1)
                                        Excelente
                                    @endif

                                    @if ($datos[5]->busqueda_bibliografica==2)
                                        Muy bien
                                    @endif
                                    @if($datos[5]->busqueda_bibliografica==3)
                                        Bien
                                    @endif
                                    @if($datos[5]->busqueda_bibliografica==4)
                                        Regular
                                    @endif
                                    @if($datos[5]->busqueda_bibliografica==5)
                                        Mala
                                    @endif
                                </p>
                            </div>
                            <div class="col-2 border border-dark sizeF bg-success text-white font-weight-bolder"><p>Trabajo en equipo:</p></div>
                            <div class="col-1 border border-dark sizeF">
                                <p>
                                    @if ($datos[5]->trabajo_equipo==1)
                                        Excelente
                                    @endif

                                    @if ($datos[5]->trabajo_equipo==2)
                                        Muy bien
                                    @endif
                                    @if($datos[5]->trabajo_equipo==3)
                                        Bien
                                    @endif
                                    @if($datos[5]->trabajo_equipo==4)
                                        Regular
                                    @endif
                                    @if($datos[5]->trabajo_equipo==5)
                                        Mala
                                    @endif
                                </p>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>

    </body>

</html>
<script>
    $(document).ready(function () {
        //window.print();
    });
</script>

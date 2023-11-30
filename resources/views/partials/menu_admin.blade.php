@section('menu')
    <?php
    //   $permiso_noregis=Session::get('personal_noregis');

    //dd(session());
    $personal_noregis = session()->has('personal_noregis') ? session()->has('personal_noregis') : false;
    $palumno = session()->has('palumno') ? session()->has('palumno') : false;
    $alumno_act = session()->has('alumno_act') ? session()->has('alumno_act') : false;
    $profesor_conact = session()->has('profesor_conact') ? session()->has('profesor_conact') : false;
    $profesor_sinact = session()->has('profesor_sinact') ? session()->has('profesor_sinact') : false;
    $jefe_division = session()->has('jefe_division') ? session()->has('jefe_division') : false;
    $directivo = session()->has('directivo') ? session()->has('directivo') : false;
    $consultas = session()->has('consultas') ? session()->has('consultas') : false;
    $sin_permiso = session()->has('sin_permiso') ? session()->has('sin_permiso') : false;
    $desa = session()->has('desa') ? session()->has('desa') : false;
    $ver_eva = session()->has('ver_eva') ? session()->has('ver_eva') : false;
    $ver_carga = session()->has('ver_carga') ? session()->has('ver_carga') : false;
    $verrifica_carga = session()->has('verrifica_carga') ? session()->has('verrifica_carga') : false;
    $escolar = session()->has('escolar') ? session()->has('escolar') : false;
    $jefe_personal = session()->has('personal') ? session()->has('personal') : false;
    $id_unidad_admin = session()->has('id_unidad_admin') ? session()->has('id_unidad_admin') : false;
    $jefe_computo = session()->has('computo') ? session()->has('computo') : false;
    $jefe_residencia = session()->has('residencia') ? session()->has('residencia') : false;
    $profesor_ingles = session()->has('profesor_ingles') ? session()->has('profesor_ingles') : false;
    $personal_academia = session()->has('personal_academia') ? session()->has('personal_academia') : false;
    $revisor = session()->has('revisor') ? session()->has('revisor') : false;
    $seguimiento_alumno = session()->has('seguimiento_alumno') ? session()->has('seguimiento_alumno') : false;
    $seguimiento_asesor = session()->has('seguimiento_asesor') ? session()->has('seguimiento_asesor') : false;
    $departamento_titulacion = session()->has('titulacion') ? session()->has('titulacion') : false;
    $direccion_finanzas = session()->has('finanzas') ? session()->has('finanzas') : false;
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?php
                $unidad = Session::get('id_unidad_admin');
                ;

                ?>
                @if($id_unidad_admin == true)
                    <div class="col-md-2 ">
                      {{--  <span class="badge badge-pill badge-primary" style="background: #c5d2b0; margin: 10px;"><a
                                    href="{{url('/notificaciones/redireccionar/validar')}}">Solicitud de oficios <b
                                        id="solicitud"></b></a></span>
                      --}}
                    </div>
                    @if($unidad==26)


                        <div class="col-md-2 col-md-offset-2">
                            {{--
                            <span class="badge badge-pill badge-primary"
                                  style="background: #b6d2ce; margin: 10px;">  <a>Validacion oficios <b
                                            id="oficios"></b></a></span>
                             --}}

                        </div>



                    @endif
                    @if($unidad==23)


                        <div class="col-md-2 col-md-offset-2">
                            {{--
                            <span class="badge badge-pill badge-primary"
                                  style="background: #b6d2ce; margin: 10px;">  <a>Validacion oficios <b
                                            id="oficiospersonal"></b></a></span>
                             --}}
                        </div>



                    @endif

                @endif

            </div>
            <div class="col-md-6" style="text-align: right;">
                <?php
                $nombre = Session::get('nombre');
                $cambio_c = Session::get('cambio_carreras');
                $carreras = Session::get('carreras');
                $usuario = Session::get('usuario_alumno');
                $nperiodo = Session::get('nombre_periodo');
                ?>
                @if($jefe_division==true || $consultas==true)
                    <?php
                    $nombre_carrera = Session::get('nombre_carrera');
                    $id_carrera = Session::get('id_carrera');
                    ?>
                    <span class="badge badge-pill badge-primary" style="background: #43a1d2; margin: 10px;"><label>{{$nombre}} . {{ $nombre_carrera }} </label> {{ $nperiodo }}</span>
                @else

                    @if($profesor_ingles==true)
                        <?php
                        $nombre_ingles = Session::get('nombre_ingles');
                        $nombre_periodo_ingles = Session::get('nombre_periodo_ingles');
                        ?>

                        <span class="badge badge-pill badge-primary"
                              style="background: #43a1d2; margin: 10px;">  <label>{{$nombre_ingles}}  </label>  {{ $nombre_periodo_ingles }}</span>

                    @else
                        <span class="badge badge-pill badge-primary"
                              style="background: #43a1d2; margin: 10px;"> <label>{{$nombre}}  </label> {{ $nperiodo }}</span>
                    @endif
                @endif
            </div>
        </div>
        <div class="row ">
            <div class="">
                <nav class="navbar navbar-default navbar-static-top">
                    <div class="navbar-header">
                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->

                    </div>

                    <div class="collapse navbar-collapse " id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        @if($profesor_conact==true || $jefe_division==true || $directivo==true ||$desa==true || $profesor_sinact==true)
                            <ul class="nav navbar-nav navbar-right">

                                <!-- Authentication Links -->
                                <li class="dropdown bloqueo tooltip-options link" data-toggle="tooltip"
                                    data-placement="top" title="{{ $nperiodo }}<br>Cambia periodo aqui">
                                    <a id="periodo" href="#" class="dropdown-toggle" data-toggle="dropdown"
                                       role="button" aria-expanded="false">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                        @if($cambio_c==1)
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown tooltip-options link" data-toggle="tooltip" data-placement="top"
                                    title="CAMBIO DE CARRERA">
                                    <a id="selectCarrera" href="#" class="dropdown-toggle" data-toggle="dropdown"
                                       role="button" aria-expanded="false">
                                        <span class="glyphicon glyphicon-education"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        @foreach($carreras as $carrera)
                                            <li>
                                                <a href="/recarga_personal/{{ $carrera->id_carrera }}">{{ $carrera->nombre }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        @endif
                    <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-left ">
                            <!-- Authentication Links -->

                            <li class="dropdown bloqueo">
                                <a href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                   class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Salir
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>

                        <!--MENU PROFESOR CON ACT-->
                        @if($profesor_conact==true)
                            <?php
                            $id_perso = Session::get('id_perso');
                            ?>
                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Duales
                                        <span class="caret"></span>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{url('/duales/mentor_calificar')}}">Calificar Alumnos Duales</a></li>
                                        </ul>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-left docente uno">
                                <li class="dropdown">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Complementarias
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/planeacion_actividad')}}">Planeación de Actividades</a>
                                        </li>
                                        <li><a href="{{url('/consulta_general')}}">Evaluación </a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-left docente uno">
                                <li class="dropdown">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Datos P.
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/docente/{{ $usuario }}/edit">Editar</a></li>
                                    </ul>
                                </li>
                            </ul>
                                @if($id_unidad_admin != true)
                            <ul class="nav navbar-nav navbar-left docente uno">
                                <li class="dropdown">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Evaluacion Docente
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/reportes2/{{$id_perso}}/{{1}}/{{0}}">Resultados de Evaluación</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                                @endif
                            <ul class="nav navbar-nav">
                                <li class="dropdown"><a href="/docente/{{$id_perso}}/carreras">Calificaciones</a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-left docente uno" style="">
                                <li class="dropdown">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Residencia
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        @if($personal_academia==true)
                                            <li><a href="{{url('/residencia/agregar_anteproyecto_asesores')}}">Agregar
                                                    asesores</a></li>
                                        @endif
                                        
                                        @if($revisor==true)
                                            <li><a href="{{url('/residencia/revisores_anteproyecto/')}}">Revisar
                                                    proyecto de residencia </a></li>
                                        @endif
                                    </ul>
                                </li>
                            </ul>
                            @if($seguimiento_asesor==true)
                                <ul class="nav navbar-nav">
                                    <li class="dropdown"><a href="/residencia/seguimiento_asesor">Seguimiento de
                                            Residencia</a></li>
                                </ul>
                            @endif

                        @endif

                    <!--MENU DESARROLLO-->
                        <!--MENU PROFESOR SIN ACT-->
                        @if($profesor_sinact==true ||$desa==true)
                            <?php
                            $id_perso = Session::get('id_perso');
                            ?>
                            <ul class="nav navbar-nav navbar-left docente uno">
                                <li class="dropdown">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Datos P.
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/docente/{{ $usuario }}/edit">Editar</a></li>
                                    </ul>
                                </li>
                            </ul>
                        @endif
                        @if($profesor_sinact==true)
                            @if($id_unidad_admin != true)
                            <ul class="nav navbar-nav navbar-left docente uno">
                                <li class="dropdown">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Evaluacion Docente
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/reportes2/{{$id_perso}}/{{1}}/{{0}}">Resultados de Evaluación</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            @endif
                                @if($id_unidad_admin != true)
                            <ul class="nav navbar-nav">
                                <li class="dropdown"><a href="/docente/{{$id_perso}}/carreras">Calificaciones</a></li>
                            </ul>
                                @endif
                                @if($id_unidad_admin != true)
                            <ul class="nav navbar-nav navbar-left docente uno" style="">
                                <li class="dropdown">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Residencia
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        @if($personal_academia==true)
                                            <li><a href="{{url('/residencia/agregar_anteproyecto_asesores')}}">Agregar asesores</a></li>
                                        @endif
                                        @if($revisor==true)
                                            <li><a href="{{url('/residencia/revisores_anteproyecto/')}}">Revisar
                                                    proyecto de residencia </a></li>
                                        @endif
                                    </ul>
                                </li>
                            </ul>
                                @endif
                            @if($seguimiento_asesor==true)
                                <ul class="nav navbar-nav">
                                    <li class="dropdown"><a href="/residencia/seguimiento_asesor">Seguimiento de
                                            Residencia</a></li>
                                </ul>
                            @endif
                        @endif
                        <?php $tipo_p = Session::get('tipo_persona'); ?>
                        @if($tipo_p== 2)
                            @if($id_unidad_admin != true)
                            <ul class="nav navbar-nav" style="">
                                <li class="dropdown"><a href="{{url('tutorias/')}}">Tutorias</a></li>
                            </ul>
                            @else
                                @if($desa==true || $jefe_division == true )
                                <ul class="nav navbar-nav" style="">
                                    <li class="dropdown"><a href="{{url('tutorias/')}}">Tutorias</a></li>
                                </ul>
                                @endif
                            @endif
                        @endif
                        @if($id_unidad_admin ==true)
                            @if($unidad==19)
                                <ul class="nav navbar-nav navbar-left">
                                    <li class="dropdown">
                                    <li><a href="{{url('/ingles/')}}">Ingles</a></li>
                                    </li>


                                </ul>
                            @endif
                        @endif
                    <!-- MENU JEFE de computo-->
                        @if($jefe_computo==true)

                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown bloqueo">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Datos P.
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/docente/{{ $usuario }}/edit">Editar</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown">
                                <li><a href="{{url('/laboratorios/laboratorios/')}}">Laboratorios </a></li>
                                </li>


                            </ul>

                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown bloqueo">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Servicios Escolares<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/computo/calificar')}}">Calificar </a></li>
                                        <li><a href="{{url('/servicios_escolares/evaluaciones_cc_academico')}}">Cambio de Periodo</a></li>
                                        <li><a href="{{url('/computo/ver_cal/promedios')}}">Promedios  >= 90</a></li>
                                    </ul>
                                </li>
                            </ul>
                            {{--
                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown">
                                <li><a href="{{url('/computo/registrar_imagen/')}}">Registrar imagen </a></li>
                                </li>
                            </ul>
                           --}}
                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown bloqueo">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Herramientas<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/centro_computo/activar_armar_horarios/')}}">Activar armar horarios</a></li>
                                        <li><a href="{{url('/centro_computo/registro_estudiantes_correo/')}}">Registro de usuarios en el sistema</a></li>

                                    </ul>
                                </li>
                            </ul>

                           @endif
                    <!-- MENU JEFE personal-->
                        @if($jefe_personal==true)

                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown bloqueo">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Datos P.
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/docente/{{ $usuario }}/edit">Editar</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown bloqueo">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Cargos del Personal<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/docente')}}">Personal del TESVB</a></li>
                                        <li><a href="{{url('/generales/cargos')}}">Categoría Personal</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown">
                                <li><a href="{{url('/oficios/evaluacion')}}">Validar Oficios </a></li>
                                </li>

                                <li class="dropdown bloqueo">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Plantilla Personal<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/departamento/plantilla')}}">Agregar Plantilla</a></li>
                                        <li><a href="{{url('/departamentoplantilla/ver')}}">Ver Plantilla</a></li>
                                    </ul>
                                </li>

                            </ul>
                        @endif
                    <!-- MENU JEFE division-->
                        @if($jefe_division==true)
                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown bloqueo">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Datos P.
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/docente/{{ $usuario }}/edit">Editar</a></li>
                                    </ul>
                                </li>
                            </ul>

                            <ul class="nav navbar-nav navbar-left dos">
                                <li class="dropdown bloqueo">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Complementarias
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/docente_actividad')}}">Asignar Docente a Actividad</a></li>
                                        <li><a href="{{url('/alumnos_actividades')}}">Liberar Solicitud Alumnos</a></li>
                                        <li><a href="{{url('/libera_planeacion')}}">Liberar Planeación Docente</a></li>
                                        <li><a href="{{url('/constancias')}}">Constancia Individual</a></li>
                                        <li><a href="{{url('/constancia_gen')}}">Constancia General</a></li>
                                        {{--     <li><a href="{{url('/datos_historicos')}}">Datos Históricos</a></li> --}}
                                    </ul>
                                </li>
                            </ul>


                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown bloqueo">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false">
                                        Evaluacion <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{url('/buscar_profesores_carrera')}}">
                                                Profesores
                                            </a>
                                        </li>
                                    <!--<li>
                                        <a href="{{url('/buscar_alumnos')}}">
                                          Alumnos
                                        </a>
                                    </li>-->
                                    </ul>
                                </li>
                            </ul>

                            <ul class="nav navbar-nav navbar-left">
                                <li style="display:yes" class="dropdown bloqueo">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Horarios<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                       <li ><a href="{{url('/horarios/armar_horarios')}}">Armar Horarios</a></li>
                                        <li><a href="{{url('/horarios/hrs_grupos/jefes')}}">Ver Horarios Grupos</a></li>
                                        <li><a href="{{url('/horarios/hrs_aulas/jefes')}}">Ver Horarios Aulas</a></li>
                                        <li><a href="{{url('/profesores/materias')}}">Profesores Materias</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown bloqueo">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Formatos<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/formatos/distribucion')}}">Distrib.de hrs. frente a
                                                grupo</a></li>
                                        <li><a href="{{url('/formatos/relacion')}}">Relación de personal docente</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown bloqueo">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Plantilla<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/plantilla/docentes')}}">Agregar Docentes</a></li>
                                        <li><a href="{{url('/plantilla/ver')}}">Ver Plantilla</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown bloqueo">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Generales<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-submenu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Academico</a>
                                            <ul class="dropdown-menu der">
                                                <li><a href="{{url('/reticulass')}}">Reticulas</a></li>
                                                <li><a href="{{url('/docente')}}">Docentes</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="{{url('/generales/situaciones')}}">Situación Profesional</a></li>
                                        <li><a href="{{url('/generales/perfiles')}}">Perfil</a></li>
                                        <li><a href="{{url('/generales/edificios')}}">Edificios</a></li>
                                        <li><a href="{{url('/generales/aulas')}}">Aulas</a></li>
                                    </ul>
                                </li>
                                <li class="bloqueo"><a href="{{url('/servicios_escolares/estadisticas/indice_reprobacion/'.$id_carrera)}}">Indice Reprobación</a></li>

                                <li class="bloqueo"><a href="{{url($id_carrera.'/docentes')}}">Calificaciones</a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-left ">
                                <li class="dropdown bloqueo">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Residencia
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/residencia/asignar_revisores')}}">Asignar Revisores</a>
                                        </li>
                                        <li><a href="{{url('/residencia/asignar_academia')}}">Asignar Academia</a></li>
                                        <li style=""><a href="{{url('/residentes/carrera_oficio_aceptacion')}}">Oficio de aceptación</a></li>
                                        <li style=""><a href="{{url('/residentes/carrera')}}">Calificaciones de los residentes</a></li>
                                    </ul>
                                </li>
                            </ul>

                            @endif

                    <!--MENU DESARROLLO ACADEMICO-->
                        @if($desa==true )
                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown bloqueo">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false">
                                        Evaluacion Docente<span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{url('/buscar_profesores')}}">
                                                Profesores
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{url('/buscar_alumnos')}}">
                                                Alumnos
                                            </a>
                                        </li>

                                    </ul>

                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Horarios<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/horarios/hrs_grupos')}}">Ver Horarios Grupos</a></li>
                                        <li><a href="{{url('/horarios/hrs_aulas')}}">Ver Horarios Aulas</a></li>
                                        <li><a href="{{url('/hrs_carrera')}}">Horas por carrera</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{url('/servicios_escolares/evaluaciones_academicas')}}">Evaluaciones</a>
                                </li>
                            </ul>
                        @endif


                    <!--CONTROL ESCOLAR-->
                        @if($escolar==true || $directivo==true)
                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown bloqueo">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false">
                                        Control Escolar <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{url('/validacion_de_carga')}}">
                                                Revision de cargas
                                            </a>
                                        </li>
                                        <li><a href="/servicios_escolares/carreras_calificaciones" class="">Evaluaciones</a></li>
                                        <li><a href="/servicios_escolares/estadisticas" class="">Estadísticas</a></li>
                                        <li><a href="/servicios_escolares/bitacora_periodos" class="">Modificaciones en
                                                periodos</a></li>
                                        <li><a href="/servicios_escolares/bitacora_evaluaciones" class="">Modificaciones
                                                en evaluaciones ordinarias</a></li>
                                        <li><a href="/servicios_escolares/bitacora_evaluaciones_sumativas" class="">Modificaciones
                                                en evaluaciones sumativas</a></li>
                                        <li>
                                            <a href="/servicios_escolares/alumnos/carrera" class="">Datos de los alumnos
                                                por carrera</a>
                                            </li>
                                            <li>
                                            <a href="/duales/gestion_academica" class="">Getión de Académica de Alumnos Duales</a>
                                            </li>
                                        @if($escolar==true)
                                        <li>
                                            <a href="{{url('/cct/registros/')}}">Instituciones educativas</a>
                                           {{-- <a href="{{url('/agregar_escuelas_procedencia/')}}">Agregar escuelas de procedencias</a> --}}
                                        </li>
                                            <li>
                                                <a href="{{url('/servicios_escolares/promedio_semestre/')}}">Promedios de los alumnos del periodo</a>
                                            </li>
                                            <li>
                                                <a href="{{url('/servicios_escolare/concentrados_calificaciones/')}}">Concentrado de Calificaciones</a>
                                            </li>
                                            <li>
                                                <a href="{{url('/duales/concentrado_calificaciones_duales/')}}">Concentrado de Calificaciones de Alumnos Duales</a>
                                            </li>
                                            <li>
                                                <a href="{{url('/servicios_escolares/historial_academico/')}}">Historial Académico de los estudiantes</a>
                                            </li>
                                            <li>
                                                <a href="{{url('/servicios_escolares/bajas_temporales/')}}">Bajas temporales de los estudiantes</a>
                                            </li>
                                            <li>
                                                <a href="{{url('/servicios_escolares/bajas_definitivas/')}}">Bajas definitivas de los estudiantes</a>
                                            </li>
                                            <li>
                                                <a href="{{url('/servicios_escolares/plan_estudio/')}}">Agregar Plan  de estudio</a>
                                            </li>
                                            <li>
                                                <a href="{{url('/servicios_escolares/especialidades/')}}">Agregar Especialidad</a>
                                            </li>
                                            <li>
                                                <a href="{{url('/servicios_escolares/modificaciones_cargas_cademicas/')}}">Ver historial de mod. cargas academicas</a>
                                            </li>
                                            <li style="display:block;">
                                                <a href="{{url('/servicios_escolares/registrar_semestre_alumnos/carrera')}}">Registrar semestre al estudiante nuevo registro</a>
                                            </li>
                                            <li style="display:none;">
                                                <a href="{{url('/servicios_escolares/carrera_estudiantes_desactivados/')}}">Ver estudiantes inactivos </a>
                                            </li>
                                            <li style="display:block;">
                                                <a href="{{url('/servicios_escolares/carrera_actualizar_semestre_periodo/')}}">Ver periodos de actualizacion de semestre estudiantes </a>
                                            </li>

                                        @endif
                                    </ul>
                                </li>
                                @if($escolar==true)
                                    <ul class="nav navbar-nav navbar-left" style="">
                                        <li><a href="{{url('/beca_estimulo/escolares/autorizar')}}">Solicitudes de Beca</a></li>
                                    </ul>

                                    <li class="dropdown bloqueo tooltip-options link" data-toggle="tooltip"
                                        data-placement="top" title="{{ $nperiodo }}<br>Cambia periodo aqui">
                                        <a id="periodo" href="#" class="dropdown-toggle" data-toggle="dropdown"
                                           role="button" aria-expanded="false">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    <!--DEPARTAMENTO DE RECIDENCIA-->
                        @if($jefe_residencia == true)
                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown bloqueo" style="display: none">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false">
                                        Servicio social <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="/servicio_social/departamento_revision_primera_etapa/" class="">Autorizacion de Documentacion 1ra Etapa</a></li>
                                        <li><a href="/servicio_social/ingresar_contancia/departamento/" class="">Carta de Presentación-Aceptación </a></li>
                                        <li><a href="/servicio_social/asignar_tipo_servicio/" class="">Asignar Tipo de Servicio a Alumno </a></li>

                                    </ul>
                                </li>
                                <li class="dropdown bloqueo">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false">
                                        Seg. Anteproyecto <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li style=""><a href="/residencia/ver_anteproyectos_revisores" class="">Anteproyectos Autorizados por los Revisores</a></li>
                                        <li style=""><a href="/residencia/autorizar_anteproyecto" class="">Autorizar Documentación de Alta de Residencia </a></li>
                                        <li><a href="/residencia/anteproyectos_autorizados/" class="">Anteproyectos Autorizados por el Departamento</a></li>
                                        <li><a href="/residencia/evalucion_anteproyecto" class="">Periodos Revisión</a>
                                        </li>
                                        <li><a href="/residencia/empresa" class="">Empresa</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown bloqueo">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false">
                                        Seg. Residencia <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                           <li><a href="/residencia/departamento_residencia" class="">Proyectos</a></li>
                                        <li><a href="/residencia/estadisticas_residencia" class="">Estadisticas</a></li>
                                        <li><a href="/residencia/autorizar_imprimir_acta" class="">Autorizar impresión de acta de residenciaa</a></li>
                                        <li><a href="/residencia/revision_documentos_finales" class="">Autorizar Documentación de Liberación de Residencia</a></li>
                                    </ul>
                                </li>

                            </ul>
                            <ul class="nav navbar-nav navbar-left alumno">

                                <li class="dropdown bloqueo tooltip-options link" data-toggle="tooltip"
                                    data-placement="top" title="{{ $nperiodo }}<br>Cambia periodo aqui">
                                    <a id="periodo" href="#" class="dropdown-toggle" data-toggle="dropdown"
                                       role="button" aria-expanded="false">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    <!--departamento de titulacion-->
                        @if($departamento_titulacion==true)
                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown bloqueo">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Datos P.
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/docente/{{ $usuario }}/edit">Editar</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-left tres" style="">
                                <li class="dropdown">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Titulación
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/titulacion/registro_alumnos_titulacion/')}}">Registrar alumnos para Titulación</a></li>
                                        <li><a href="{{url('/titulacion/autorizar_doc_requisitos/')}}">Autorizar documentación de requisitos de Titulación</a></li>
                                        <li><a href="{{url('/titulacion/autorizar_datos_personales/')}}">Autorizar datos personales de los estudiantes de Titulación</a></li>
                                        <li><a href="{{url('/titulacion/validacion_agregar_jurado/carreras/')}}">Validación para agregar jurado</a></li>
                                        <li><a href="{{url('/titulacion/autorizar_jurado_estudiantes/')}}">Autorizar jurado de los estudiantes de Titulación</a></li>
                                        <li><a href="{{url('/titulacion/calendario_estudiantes_autorizado/')}}">Consultar Titulaciones por día</a></li>
                                        <li><a href="{{url('/titulacion/formulario_datos_titulado/inicio/carrera/')}}">Autorizar titulaciones</a></li>
                                        <li><a href="{{url('/titulacion/relacion de documentos/inicio/')}}">Relación  de documentos</a></li>
                                        <li><a href="{{url('/titulacion/liberacion_titulado_carrera/')}}">Ver alumnos titulados liberados</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-left tres" style="">
                                <li class="dropdown">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Catalogos Titulacion
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/titulacion/reg_catalogo_tomos_titulo/')}}">Registrar Tomos de titulos</a></li>
                                        <li><a href="{{url('/titulacion/agregar_escuelas_preparatorias/')}}">Registrar escuelas preparatorias</a></li>


                                    </ul>
                                </li>
                            </ul>
                            @endif
                    <!--MENU DIRECTIVO-->
                        @if($directivo==true || $consultas==true || $directivo==10)
                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Datos P.
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/docente/{{ $usuario }}/edit">Editar</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-left tres">
                                <li class="dropdown">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Complementarias
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/nueva_actividad')}}">Registrar Nueva Actividad</a></li>
                                        <li><a href="{{url('/solicitud_alumnos')}}">Solicitud Alumnos</a></li>
                                        <li><a href="{{url('/datos_estadisticos')}}">Datos Estadísticos</a></li>
                                        <li><a href="{{url('/datos_historicos_graficos')}}">Datos Históricos</a></li>
                                    </ul>
                                </li>
                            </ul>

                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown bloqueo">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false">
                                        Evaluacion Doc. <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{url('/buscar_profesores')}}">
                                                Profesores
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{url('/buscar_alumnos')}}">
                                                Alumnos
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                            <ul class="nav navbar-nav">
                                {{--  --}}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Horarios<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/horarios/horarios_docentes')}}">Ver Horarios Docentes</a>
                                        </li>
                                        <li><a href="{{url('/horarios/hrs_grupos')}}">Ver Horarios Grupos</a></li>
                                        <li><a href="{{url('/horarios/hrs_aulas')}}">Ver Horarios Aulas</a></li>
                                        <li><a href="{{url('/hrs_carrera')}}">Horas por carrera</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Formatos<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/formatos/con_edu')}}">Concentrado Estructura Educ.</a></li>
                                        <li><a href="{{url('/formatos/distribucion')}}">Distrib.de hrs. frente a
                                                grupo</a></li>
                                        <li><a href="{{url('/formatos/relacion')}}">Relación de personal docente</a>
                                        </li>
                                        <li><a href="{{url('/formatos/horas_docentes/')}}">Horas por docentes</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Plantilla<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/plantilla/ver')}}">Ver Plantilla</a></li>
                                        <li><a href="{{url('/plantilla/educativa')}}">Plantilla Educativa</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Generales<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-submenu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Academico</a>
                                            <ul class="dropdown-menu der">
                                                <li><a href="{{url('/reticulass')}}">Reticulas</a></li>
                                                <li><a href="{{url('/docente')}}">Docentes</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="{{url('/generales/edificios')}}">Edificios</a></li>
                                        <li><a href="{{url('/generales/aulas')}}">Aulas</a></li>
                                        @if($directivo==true)
                                            <li><a href="{{url('/generales/situaciones')}}">Situación Profesional</a>
                                            </li>
                                            <li><a href="{{url('/generales/perfiles')}}">Perfil</a></li>
                                            <li><a href="{{url('/generales/carreras')}}">Carreras</a></li>
                                            <li><a href="{{url('/generales/extra_clases')}}">Extra Clase</a></li>
                                            <li><a href="{{url('/generales/cargos')}}">Categoría Docente</a></li>
                                            <li><a href="{{url('/generales/jefaturas')}}">Jefaturas de División</a></li>
                                            <li><a href="{{url('/personales')}}">Asignación de Permisos</a></li>
                                            <li><a href="{{url('/generales/unidad_administrativa')}}">Unidades
                                                    Administrativas</a></li>

                                            <li><a href="{{url('/generales/jefe_unidad_administrativa')}}">Jefes
                                                    Unidades Administrativas</a></li>
                                        @endif
                                    </ul>
                                </li>
                            </ul>
                        @endif
                        {{-- ///jefes de unidades--}}
                        @if($id_unidad_admin||$directivo)


                            <ul class="nav navbar-nav">
                                <li class="dropdown bloq">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Riesgos y Oportuni.<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">

                                        <li><a href="{{url('/riesgos/proceso')}}">Registro Procesos</a></li>
                                        <li class="dropdown-submenu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Registro
                                                Catálogos Riesgos</a>
                                            <ul class="dropdown-menu der">
                                                <li><a href="{{url('/riesgos/riesgo')}}">Riesgos</a></li>
                                                <li><a href="{{url('/riesgos/seleccion')}}">Selecciones</a></li>
                                                <li><a href="{{url('/riesgos/tipoeva')}}">Tipo Evaluación</a></li>
                                                <li><a href="{{url('/riesgos/factor')}}">Factor</a></li>
                                                <li><a href="{{url('/riesgos/tipof')}}">Tipo Factor</a></li>
                                                <li><a href="{{url('/riesgos/estrategia')}}">Estrategias</a></li>
                                                <li><a href="{{url('/riesgos/decision')}}">Nivel Decisión</a></li>
                                                <li><a href="{{url('/riesgos/clasifica')}}">Clasificación Riesgo</a>
                                                </li>
                                                <li><a href="{{url('/riesgos/sistema')}}">Categoria del Proceso</a></li>
                                            </ul>
                                        </li>


                                        <li class="dropdown-submenu"><a href="#" class="dropdown-toggle"
                                                                        data-toggle="dropdown">Registro Catálogos
                                                Oportunidades</a>
                                            <ul class="dropdown-menu der">
                                                <li><a href="{{url('/riesgos/mejoracliente')}}">Mejoras del Cliente</a>
                                                </li>

                                                <li><a href="{{url('/riesgos/mejorareputacion')}}">Reputacion
                                                        Institucional</a></li>
                                                <li><a href="{{url('/riesgos/mejorasgc')}}">Mejora SGC</a></li>
                                                <li><a href="{{url('/riesgos/potencialapertura')}}">Potencial Apertura
                                                        Nuevos Programas de Estudio</a></li>
                                                <li><a href="{{url('/riesgos/potencialcosto')}}">Potencial Costo de
                                                        Implementación</a></li>
                                                <li><a href="{{url('/riesgos/potencialcrecimiento')}}">Potencial de
                                                        Crecimiento de la Matrícula Actual</a></li>
                                                <li><a href="{{url('/riesgos/probabilidad')}}">Registra Probabilidad</a>
                                                </li>
                                                <li><a href="{{url('/riesgos/ocurrenciasp')}}">Registra Ocurrencias
                                                        Previas</a></li>
                                                <li><a href="{{url('/riesgos/calificacion')}}">Registra Calificación
                                                        Máxima</a></li>

                                            </ul>
                                        </li>
                                        {{--<li><a href="{{url('/riesgos/registroriesgos')}}">Registro Riesgos</a></li>--}}
                                        <li><a href="{{url('/riesgos/partes')}}">Partes Interesadas </a></li>
                                        {{--                                    <li><a href="{{url('/riesgos/add_partes')}}">Agregar Partes Interesadas</a></li>--}}
                                        @if($directivo || $unidad==10)
                                            <li><a href="{{url('/riesgos/seguimiento')}}">Seguimiento</a></li>
                                            <li><a href="{{url('riesgos/seguimiento/tabla')}}">Cronograma</a></li>

                                        @endif
                                    </ul>
                                </li>


                            </ul>
                            <ul class="nav navbar-nav">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Oficios Com.<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        @if($unidad==26)
                                            <li><a href="{{url('/oficios/evaluacionsubdirecion')}}">Validar Oficios </a>
                                            </li>
                                        @endif
                                        <li><a href="{{url('/oficios/solicitud')}}">Solicitud Oficio</a></li>
                                        <li><a href="{{url('/oficios/registrosoficio')}}">Ver Oficios</a></li>

                                    </ul>
                                </li>
                            </ul>
                        @endif
                        {{-- centro de informacion ---}}
                        <?php $id_per = Session::get('usuario_alumno'); ?>
                        @if( $id_per == 2630 )

                            <ul class="nav navbar-nav navbar-left alumno">

                                <li class="dropdown">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown"
                                       role="button" aria-haspopup="true" aria-expanded="false">Titulación

                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/titulacion/autorizacion_entrega_cd')}}">Autorizar entrega de PDF</a></li>
                                        <li><a href="{{url('/titulacion/documento_titulacion_autorizado/')}}">Documento de Titulacion autorizado de los estudiantes</a></li>
                                         </ul>
                                </li>
                            </ul>
                         @endif
                        {{--inicio encargados del procedimiento de ambiental --}}
                        <?php $encargado_ambiental = Session::get('encargado_ambiental'); ?>
                        @if($encargado_ambiental == true)
                            <ul class="nav navbar-nav navbar-left" style="">

                                <li class="dropdown">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown"
                                       role="button" aria-haspopup="true" aria-expanded="false">Procedimiento Amb.

                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/ambiental/enviar_documentacion/')}}">Enviar evidencias del procedimiento</a></li>
                                        <li><a href="{{url('/ambiental/historial_documentacion/')}}">Historial de las evidencias procedimiento</a></li>

                                    </ul>
                                </li>
                            </ul>
                        @endif
                        {{--fin encargados del procedimiento de ambiental --}}

                        {{--Menú SGC--}}
                        @if($id_unidad_admin)

                            <ul class="nav navbar-nav">
                                <li class="dropdown bloq">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Auditorías<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">

                                            <li><a href="{{url('/auditorias/actividades')}}">Actividades para la
                                                    agenda</a></li>
                                            <li><a href="{{url('/auditorias/auditores')}}">Auditores</a></li>
                                            <li><a href="{{url('/auditorias/generales')}}">Catalogo Generales</a></li>
                                            <li><a href="{{url('/auditorias/procesos')}}">Procesos</a></li>

                                        <li><a href="{{url('/auditorias/programas')}}">Programa de auditorías</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        @endif

                        {{--inicio constancia de adeudo --}}
                        @if($id_unidad_admin == true || $id_per ===2630 || $id_per ===2662  || $escolar == true)

                            <ul class="nav navbar-nav navbar-left alumno">

                                <li class="dropdown">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown"
                                       role="button" aria-haspopup="true" aria-expanded="false">Adeudos de Estudiantes

                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/solicitud_adeudo/')}}">Registrar alumnos con adeudo </a></li>
                                          @if($unidad == 16 || $unidad == 28 || $escolar == true)
                                          <li><a href="{{url('/constancia_adeudo/')}}">Constancias de no adeudo </a></li>
                                          @endif
                                        @if($id_per ===2662)
                                        <li><a href="{{url('/ver_carrera_encuestas_adeudo//')}}">Adeudo de Encuestas </a></li>
                                        @endif
                                    </ul>
                                </li>
                            </ul>
                            @if($unidad == 14 || $unidad == 20  )

                                <ul class="nav navbar-nav navbar-left alumno">

                                    <li class="dropdown bloqueo tooltip-options link" data-toggle="tooltip"
                                        data-placement="top" title="{{ $nperiodo }}<br>Cambia periodo aqui">
                                        <a id="periodo" href="#" class="dropdown-toggle" data-toggle="dropdown"
                                           role="button" aria-expanded="false">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        @endif
                        {{-- direccion de administracion y finanzas---}}
                        @if($direccion_finanzas == true || $unidad == 24 || $unidad == 25 || $unidad == 1 || $unidad == 2 )
                            @if($direccion_finanzas == true || $unidad == 24 || $unidad == 25)
                              <ul class="nav navbar-nav">
                                  <li class="dropdown">
                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Req. Anteproyecto<span
                                                  class="caret"></span></a>
                                      <ul class="dropdown-menu">
                                          <li><a href="{{url('/presupuesto_anteproyecto/techo_presupuestal/')}}">Techo presupuestal</a></li>
                                          <li><a href="{{url('/presupuesto_anteproyecto/periodos_anteproyecto/')}}">Periodos de anteproyectos</a></li>
                                          <li><a href="{{url('/presupuesto_anteproyecto/revicion_requisiciones_anteproyecto/')}}">Revisión de  requisiciones</a></li>
                                          <li><a href="{{url('/presupuesto_anteproyecto/requisiciones_autorizadas_proyecto/')}}">Requisiciones autorizadas de los proyectos</a></li>
                                          <li><a href="{{url('/presupuesto_anteproyecto/inicio_historial_anteproyecto/')}}">Historiales de los anteproyectos del los presupuestos</a></li>

                                      </ul>
                                  </li>
                              </ul>
                            @endif
                                @if($direccion_finanzas == true || $unidad == 24 || $unidad == 25 || $unidad == 1 || $unidad == 2 )
                                      <ul class="nav navbar-nav">
                                          <li class="dropdown">
                                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Catalogo de Requisiciones<span
                                                          class="caret"></span></a>
                                              <ul class="dropdown-menu">
                                                  @if($direccion_finanzas == true || $unidad == 24 || $unidad == 25 )
                                                  <li style=""><a href="{{url('/presupuesto_anteproyecto/partida_presupuestal/')}}">Partidas presupuestales</a></li>
                                                 @endif
                                                  <li><a href="{{url('/presupuesto_anteproyecto/proyectos_presupuestales/')}}">Proyectos presupuestales</a></li>
                                                  <li><a href="{{url('/presupuesto_anteproyecto/proyectos_metas/')}}">Metas de los proyectos presupuestales</a></li>
                                              </ul>
                                          </li>
                                      </ul>
                                @endif
                                @if($direccion_finanzas == true || $unidad == 24 || $unidad == 25)
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Presupuesto autorizado<span
                                                        class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{url('/presupuesto_autorizado/agregar_presupesto_partida/')}}">Agregar presupuesto autorizado</a></li>
                                                <li><a href="{{url('/presupuesto_autorizado/presupesto_partida_copia/')}}">Presupuesto autorizado para modificar</a></li>
                                                <li><a href="{{url('/presupuesto_autorizado/departamentos_presupesto_partida/')}}">Departamentos con presupuesto autorizado</a></li>
                                                <li><a href="{{url('/presupuesto_autorizado/revisar_solicitudes/')}}">Revisión de solicitudes</a></li>
                                                <li><a href="{{url('/presupuesto_autorizado/solicitudes_autorizadas_departamentos')}}">Solicitudes autorizadas liberadas</a></li>
                                                <li><a href="{{url('/presupuesto_autorizado/inicio_presupuesto_autorizado_historial/')}}">Historial de presupuesto autorizado</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                @endif
                        @endif
                      {{--fin constancia de adeudo --}}
                      @if($id_unidad_admin)

                          @if($unidad == 40 || $unidad == 1)
                              @if($unidad == 40 )
                              <ul class="nav navbar-nav navbar-left" style="">
                                  <li><a href="{{url('/ipomex/mostrar_fracciones/contralor_ver_ipomex/')}}">Ipomex</a></li>
                              </ul>
                              @else
                                  <ul class="nav navbar-nav">
                                      <li class="dropdown bloq">
                                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Ipomex<span
                                                      class="caret"></span></a>
                                          <ul class="dropdown-menu">
                                              <li><a href="{{url('/ipomex/mostrar_fracciones/contralor_ver_ipomex/')}}">Ver jefes con fracciones</a></li>
                                              <li><a href="{{url('/ipomex/mostrar_fracciones')}}">Ver mis fracciones</a></li>

                                          </ul>
                                      </li>
                                  </ul>
                                  @endif
                              @else
                          <ul class="nav navbar-nav navbar-left" style="">
                              <li><a href="{{url('/ipomex/mostrar_fracciones')}}">Ipomex</a></li>
                          </ul>
                          @endif
                          <?php $id_per = Session::get('usuario_alumno'); ?>

                          @if($unidad == 5 )
                          <ul class="nav navbar-nav navbar-left" style="">
                              <li><a href="{{url('/beca_estimulo/academico/autorizar')}}">Solicitudes de beca</a></li>
                          </ul>
                          @endif
                          @if($unidad == 26)
                              <ul class="nav navbar-nav navbar-left alumno">

                                  <li class="dropdown">
                                      <a class="dropdown-toogle" href="" data-toggle="dropdown"
                                         role="button" aria-haspopup="true" aria-expanded="false">Solicitudes

                                          <span class="caret"></span></a>
                                      <ul class="dropdown-menu">
                                          <li><a href="{{url('/beca_estimulo/academico/autorizar')}}">Solicitudes de beca</a></li>
                                          <li><a href="{{url('/solicitud/prorroga_autorizar')}}">Solicitud de prorroga</a></li>
                                      </ul>
                                  </li>
                                  <li><a href="{{url('/residencia/carreras_proyectos')}}">Residencia</a></li>

                              </ul>

                          @endif
                              @if($unidad == 17)
                                  <ul class="nav navbar-nav navbar-left alumno" style="">

                                      <li class="dropdown">
                                          <a class="dropdown-toogle" href="" data-toggle="dropdown"
                                             role="button" aria-haspopup="true" aria-expanded="false">Evidencias Inf. Doc.

                                              <span class="caret"></span></a>
                                          <ul class="dropdown-menu">
                                              <li><a href="{{url('/ambiental/ver_procedimientos/')}}">Procedimientos</a></li>
                                              <li><a href="{{url('/ambiental/ver_encargados/')}}">Encargados de los Procedimientos</a></li>
                                              <li><a href="{{url('/ambiental/ver_periodos/')}}">Periodos de Envió de Documentación</a></li>
                                              <li><a href="{{url('/ambiental/ver_documentacion_ambiental/')}}">Autorizar Documentación</a></li>
                                              <li><a href="{{url('/ambiental/historial_ambiental_departamento/')}}">Historial Documentación Ambiental</a></li>

                                          </ul>
                                      </li>

                                  </ul>

                              @endif


                             <ul class="nav navbar-nav" style="display: none">
                                  <li class="dropdown bloq">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">P.A.AC <span
                                              class="caret"></span></a>
                                  <ul class="dropdown-menu">
                                      <li class="dropdown-submenu">
                                          @if($unidad == 1)
                                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Catálogo</a>
                                              <ul class="dropdown-menu der">
                                                  <li><a href="{{url('/paa/programa_paa')}}">Programa</a></li>
                                                  <li><a href="{{url('/paa/subprograma_paa')}}">Subprograma</a></li>
                                                  <li><a href="{{url('/paa/acciones_paa')}}">Acción</a></li>
                                                  <li><a href="{{url('/paa/unidad_medida_paa')}}">Unidad de medida</a>
                                                  </li>

                                              </ul>
                                          @endif
                                      </li>
                                      <li class="dropdown-submenu">
                                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">OPCIONES DE
                                              P.A.AC</a>
                                          <ul class="dropdown-menu der">
                                              <li><a href="{{url('/paa/generarpaa')}}">Generar</a></li>
                                              <li><a href="{{url('/paa/subprograma_paa')}}">Modificar P.A.A</a></li>
                                              <li><a href="{{url('/paa/acciones_paa')}}">Cargar evidencia</a></li>
                                              <li><a href="{{url('/paa/unidad_medida_paa')}}">Modificar</a></li>

                                          </ul>
                                      </li>
                                  </ul>
                                  </ul>
                                      <ul class="nav navbar-nav">
                                          <li class="dropdown">
                                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Req. de Mat. Anteproyecto<span
                                                          class="caret"></span></a>
                                              <ul class="dropdown-menu">
                                                  <li><a href="{{url('/presupuesto_anteproyecto/registrar_requerimientos_anteproyecto/')}}">Registrar requisición de materiales del anteproyecto</a>
                                                  </li>
                                              </ul>
                                          </li>
                                      </ul>
                              <ul class="nav navbar-nav">
                                  <li class="dropdown">
                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Solicitudes de req. del presupuesto autorizado<span
                                                  class="caret"></span></a>
                                      <ul class="dropdown-menu">
                                          <li>
                                              <a href="{{url('/presupuesto_autorizado/agregar_req_solicitud_autorizadas/')}}">Registrar requisiciones a las solicitudes autorizadas</a>
                                          </li>
                                          <li>
                                              <a href="{{url('/presupuesto_autorizado/solicitudes_aut_departamento/')}}">Ver solicitudes autorizadas liberadas</a>
                                          </li>
                                      </ul>
                                  </li>
                              </ul>
                              @endif




                              <!--MENU ALUMNO-->
                                  @if($palumno==true)
                                      <?php $tipo_p = Session::get('tipo_persona'); ?>


                                      <?php $semestre = Session::get('semestre');?>
                                      <ul class="nav navbar-nav navbar-left alumno">

                                          <li class="dropdown">

                                              <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                                 aria-haspopup="true" aria-expanded="false">Complementarias
                                                  <span class="caret"></span></a>
                                              <ul class="dropdown-menu">
                                                  <li><a href="{{url('/consulta_actividades')}}">Registrar</a></li>
                                                  <li><a href="{{url('/evidencias_alumnos')}}">Evidencias</a></li>
                                                  <li><a href="{{url('/liberacion_alumno')}}">Liberación</a></li>
                                                  <li><a href="{{url('/creditos')}}">Créditos</a></li>
                                              </ul>
                                          </li>
                                      </ul>

                                      <ul class="nav navbar-nav navbar-left alumno">

                                          <li class="dropdown">
                                              <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                                 aria-haspopup="true" aria-expanded="false">Datos Alumno(a)
                                                  <span class="caret"></span></a>
                                              <ul class="dropdown-menu">
                                                  <li><a href="{{url('/datos_alumno')}}">Actualizar</a></li>
                                                  @if($ver_carga==false)
                                                      <li><a href="{{url('/carga_academica')}}">Llenar Carga
                                                              Académica</a></li>
                                                  @endif
                                                  <li><a href="{{url('/checar_carga')}}">Ver Carga Académica</a>
                                                  </li>
                                                  {{--
                                                  <li><a href="{{url('/alumno/academico/cal')}}">Promedio Academico</a>
                                                  </li>
                                                  --}}

                                              </ul>
                                          </li>
                                      </ul>
                                          <ul class="nav navbar-nav navbar-left">
                                              <li class="dropdown">
                                              <li><a href="{{url('/ingles/')}}">Ingles</a></li>
                                              </li>
                                          </ul>
                                          <ul class="nav navbar-nav navbar-left" style="">
                                              <li class="dropdown">
                                              <li><a href="{{url('/tutorias/')}}">Tutorias</a></li>
                                              </li>
                                          </ul>

                                      @if($ver_eva==true)
                                          <ul class="nav navbar-nav navbar-left alumno">

                                              <li class="dropdown">
                                                  <a class="dropdown-toogle" href="" data-toggle="dropdown"
                                                     role="button" aria-haspopup="true" aria-expanded="false">Evaluacion
                                                      Docente
                                                      <span class="caret"></span></a>
                                                  <ul class="dropdown-menu">
                                                      <li><a href="{{url('/evaluacion_alumno')}}">Iniciar
                                                              Evaluación</a></li>
                                                  </ul>
                                              </li>
                                          </ul>
                                      @endif
                                      <ul class="nav navbar-nav navbar-left">
                                          <li><a href="{{url('/calificaciones')}}">Calificaciones</a></li>
                                          @if($escolar !=true)
                                          <li class="dropdown bloqueo tooltip-options link" data-toggle="tooltip"
                                              data-placement="top" title="{{ $nperiodo }}<br>Cambia periodo aqui">
                                              <a id="periodo" href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                 role="button" aria-expanded="false">
                                                  <span class="glyphicon glyphicon-calendar"></span>
                                              </a>
                                          </li>
                                              @endif
                                      </ul>
                                          <ul class="nav navbar-nav navbar-left alumno">

                                              <li class="dropdown">
                                                  <a class="dropdown-toogle" href="" data-toggle="dropdown"
                                                     role="button" aria-haspopup="true" aria-expanded="false">Solicitudes

                                                      <span class="caret"></span></a>
                                                  <ul class="dropdown-menu">
                                                      <li><a href="{{url('/beca_estimulo/')}}">Solicitud del Estimulo al D. E.</a></li>
                                                      <li style=""><a href="{{url('/solicitud/prorroga')}}">Solicitud de prorroga</a></li>
                                                      <li style=""><a href="{{url('/verificacion_adeudo_alumno/')}}">Solicitud de  constancia de no adeudo</a></li>

                                                  </ul>
                                              </li>
                                          </ul>

                                      <div style="">

                                          @if($semestre >= 8)
                                              <?php $registrar_residencia = Session::get('registrar_residencia');?>
                                              <?php $anteproyecto_aceptado = Session::get('anteproyecto_aceptado');?>
                                              <?php $registro_empresa = Session::get('registro_empresa');?>
                                              <?php $estado_reg_anteproyecto = Session::get('estado_reg_anteproyecto');?>
                                              <ul class="nav navbar-nav navbar-left" style="">

                                                  <li class="dropdown">
                                                      <a class="dropdown-toogle" href="" data-toggle="dropdown"
                                                         role="button" aria-haspopup="true" aria-expanded="false">Datos
                                                          Residencia Profesional
                                                          <span class="caret"></span></a>
                                                      <ul class="dropdown-menu">
                                                          @if($registrar_residencia == true)
                                                              <li>
                                                                  <a href="{{url('/residencia/registrar_anteproyecto')}}">Registrar Anteproyecto</a>
                                                              </li>

                                                              @if($estado_reg_anteproyecto == true)
                                                                  <li>
                                                                      <a href="{{url('/residencia/correcciones_anteproyecto/')}}">Correciones anteproyecto</a>
                                                              </li>
                                                              @endif
                                                                  @if($anteproyecto_aceptado == true)
                                                                  <li><a href="{{url('/residencia/agregar_empresa')}}">Agregar
                                                                          empresa</a></li>
                                                                  @endif
                                                              @if($registro_empresa == true)
                                                                  <li><a href="#" onclick="window.open('{{url('/residencia/dictamen_anteproyecto')}}')">Dictamen Anteproyecto</a></li>
                                                                  <li style="" ><a href="{{url('/residencia/registrar_solicitud_residencia')}}">Registrar datos de la solicitud de residencia</a></li>
                                                                  <li style="display: none"><a href="{{url('/residencia/documentos_alta_residencia')}}">Enviar documentos de alta de residencia</a></li>

                                                              @endif
                                                          @else
                                                                  @if($estado_reg_anteproyecto == true)
                                                                  <li>
                                                                      <a href="{{url('/residencia/correcciones_anteproyecto/')}}">Correciones anteproyecto</a>
                                                                      </li>
                                                                  @endif
                                                                  @if($anteproyecto_aceptado == true)
                                                                      <li><a href="{{url('/residencia/agregar_empresa')}}">Agregar
                                                                              empresa</a></li>
                                                                  @endif
                                                                  @if($registro_empresa == true)
                                                                      <li><a href="#" onclick="window.open('{{url('/residencia/dictamen_anteproyecto')}}')">Dictamen Anteproyecto</a></li>
                                                                          <li style="" ><a href="{{url('/residencia/registrar_solicitud_residencia')}}">Registrar datos de la solicitud de residencia</a></li>

                                                                      <li style="display: none"><a href="{{url('/residencia/documentos_alta_residencia')}}">Enviar documentos de alta de residencia</a></li>

                                                                  @endif
                                                          @endif
                                                      </ul>
                                                  </li>
                                              </ul>


                                          @endif
                                          @if($seguimiento_alumno == true)
                                                  <ul class="nav navbar-nav navbar-left alumno" >

                                                      <li class="dropdown">
                                                          <a class="dropdown-toogle" href="" data-toggle="dropdown"
                                                             role="button" aria-haspopup="true" aria-expanded="false">Seguimiento Residencia
                                                              <span class="caret"></span></a>
                                                          <ul class="dropdown-menu">
                                                              <li><a href="{{url('/residencia/seguimiento_residencia')}}">Mostrar Seguimiento
                                                                      de Residencia</a></li>
                                                              <li style="display: none"><a href="{{url('/residencia/enviar_documentacion/alumno/')}}">Enviar documentación de Liberación de Residencia</a></li>

                                                          </ul>
                                                      </li>
                                                  </ul>

                                          @endif
                                              @if($semestre >= 5)
                                                  <ul class="nav navbar-nav navbar-left alumno" style="display: none">

                                                      <li class="dropdown">
                                                          <a class="dropdown-toogle" href="" data-toggle="dropdown"
                                                             role="button" aria-haspopup="true" aria-expanded="false">Servicio Social
                                                              <span class="caret"></span></a>
                                                          <ul class="dropdown-menu">
                                                              <li><a href="{{url('/servicio_social/docuemtacion_priemra_etapa/')}}">Documentación de la primera etapa S.S.</a></li>
                                                              <li><a href="{{url('/servicio_social/enviocartapresentacionalumno/alumno/')}}">Envio de  Carta de Presentación-Aceptación</a></li>

                                                          </ul>
                                                      </li>
                                                  </ul>
                                              @endif
                                              <?php $reg_alum_ti = Session::get('reg_alum_ti');?>
                                              <?php $ti_segunda_etapa = Session::get('ti_segunda_etapa');?>
                                              <?php $ti_tercera_parte = Session::get('ti_tercera_parte');?>

                                              @if($reg_alum_ti == true)
                                                  <ul class="nav navbar-nav navbar-left alumno" style="">

                                                      <li class="dropdown">
                                                          <a class="dropdown-toogle" href="" data-toggle="dropdown"
                                                             role="button" aria-haspopup="true" aria-expanded="false">Titulación
                                                              <span class="caret"></span></a>
                                                          <ul class="dropdown-menu">
                                                              <li><a href="{{url('/titulacion/documentacion_requisitos_titulacion/')}}">Documentación de los requisitos de Titulación (1ra Etapa)</a></li>
                                                              @if($ti_segunda_etapa == true)
                                                              <li style=""><a href="{{url('/titulacion/reg_datos_personales/segunda_etapa/')}}">Registro de Datos Personales (2da Etapa)</a></li>
                                                              @endif
                                                              @if($ti_tercera_parte == true)
                                                                  <li style=""><a href="{{url('/titulacion/registro_jurado/')}}">Registro de jurado (3ra etapa)</a></li>

                                                              @endif

                                                              <li style="display: none"><a href="{{url('/titulacion/pruebas/')}}">2 parte</a></li>

                                                          </ul>
                                                      </li>
                                                  </ul>
                                              @endif
                                      </div>


                                  @endif
                              <!--MENU    PROFESOR  DE INGLES-->
                                  @if($profesor_ingles==true)
                                          <ul class="nav navbar-nav navbar-left">
                                              <li class="dropdown">
                                              <li><a href="{{url('/ingles/')}}">Ingles</a></li>
                                              </li>
                                          </ul>
                                   @endif

                        <!--Incidencias-->
                        <?php   $personal_tesvb=Session::get('personal_tesvb');?>
                        @if( $personal_tesvb == true)
                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown bloqueo">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-hapopup="true" aria-expanded="false"> Incidencias de Asistencia <span
                                                class="caret"> </span></a>
                                    <ul class="dropdown-menu">
                                        @if($jefe_division==true || $directivo==true || $direccion_finanzas==true  || $jefe_personal==true ||$id_unidad_admin==true )
                                            <li><a href="{{url('/incidencias/validar_oficios')}}">Validar oficios</a></li>
                                        @endif
                                        @if( !$id_unidad_admin)
                                            <li><a href="{{url('/incidencias/solicitar_oficio')}}">Solicitar oficio</a></li>
                                            <li><a href="{{url('/incidencias/articulos_evidencia')}}">Subir evidencia</a></li>
                                            <li><a href="{{url('/incidencias/historial_docentesSo')}}">Historial oficios</a></li>
                                            <li><a href="{{url('/incidencias/historial_docentesEv')}}">Historial evidencias</a></li>
                                        @endif
                                        @if($jefe_personal==true)
                                            <li><a href="{{url('/incidencias/historial_oficios')}}">Historial de oficios</a></li>
                                            <li><a href="{{url('/incidencias/historial_evidencias')}}">Historial de evidencias</a></li>
                                            <li><a href="{{url('/incidencias/reportes_incidencias')}}">Reportes</a></li>
                                        @endif


                                    </ul>
                                </li>
                            </ul>
                        @endif

                        <!--AGREGAR DUALES ALUMNOS/MENTORES-->
                        @if($jefe_division==true)
                        <ul class="nav navbar-nav navbar-left">
                            <li class="dropdown bloqueo">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false"> Asignar Duales<span
                                            class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{url('/duales/agregar_alumnos_dual')}}">Agregar Alumnos Duales</a></li>
                                    <li><a href="{{url('/duales/llenar_carga_academica_dual')}}">Llenar Cargas Academicas</a></li>
                                    <li><a href="{{url('/duales/Agregar_docentes_duales')}}">Agregar Mentores Duales</a></li>
                                </ul>
                            </li>
                        </ul>
                        @endif
                        <?php
                        $unidad = Session::get('id_unidad_admin');
                        ?>
                        @if($unidad == 25)
                            <ul class="nav navbar-nav ">
                                <li class="dropdown">
                                    <a class="dropdown-toogle" href="" data-toggle="dropdown"
                                       role="button" aria-haspopup="true" aria-expanded="false" style="background-color: lightyellow">Inventario TESVB
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/SectorAux')}}">Sector Auxiliar</a></li>
                                        <li class="dropdown-submenu"><a class="test" href="#">Bienes</a>
                                            <ul class="dropdown-menu">
                                                <li class="dropdown-submenu"><a class="test" href="#">Gestionar atributos del Bien</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="{{url('/Marcas')}}">Marcas</a></li>
                                                        <li><a href="{{url('/Provedores')}}">Proveedores</a></li>
                                                        <li><a href="{{url('/Modelos')}}">Modelos</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="{{url('/Bienes')}}">Registro, Gestión y consulta de Bienes</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="{{url('/Categorias')}}">Categorías</a></li>
                                        <li class="dropdown-submenu"><a class="test" href="#">Resguardos</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{'/Resguardos'}}">Asignacion y Consulta de Resguardos</a></li>
                                                <li><a href="{{'/Resguardos-Consulta'}}">Tarjetas de Resguardo</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown-submenu"><a class="test" href="#">Padrón de Bienes</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{'/Resguardos-Padron'}}">Padron del TESVB</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="{{url('/Areas')}}">Historial Departamentos</a></li>
                                        <li class="dropdown-submenu"><a class="test" href="#">Reportes</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{'/Reportes'}}">Reportes en Excel</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        @endif

                  </div>


              </nav>
          </div>
      </div>
  </div>
  {{--modificar actividad--}}
  <div class="modal fade" id="modal_modificar_periodo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <form class="form" action="" role="form" method="POST">
                  {{ csrf_field() }}
                  <div class="modal-header bg-info">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                  aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title text-center" id="myModalLabel">Modificar periodo</h4>
                  </div>
                  <div id="contenedor_modificar_periodo">


                  </div>

                  <div class="modal-footer">
                  </div>
              </form>
          </div>

      </div>
  </div>
  {{--fin modificar actividad--}}
  <script type="text/javascript">
      function cargar() {
          $("#oficios").empty();
          $.get("/mostrar_validacion", function (request) {
              $('#oficios').append("<span class='badge'><b>" + request.ofs + "</b></span>");
          });
      }

      function cargarpersonal() {
          $("#oficiospersonal").empty();
          $.get("/mostrar_validacion_personal", function (request) {
              $('#oficiospersonal').append("<span class='badge'><b>" + request.ofp + "</b></span>");
          });
      }
/*
      function notificacionesof() {
          $("#solicitud").empty();
          $.get("/notificaciones/oficios", function (request) {
              $('#solicitud').append("<span class='badge'><b>" + request.ofsl + "</b></span>");
          });
      }
      */


      $(document).ready(function () {
          $(".periodo_ingles").click(function (event) {
              var periodo_ing = $(this).attr('id');
              $.get("/profesores_ingles/periodos/" + periodo_ing, function (request) {
                  $("#contenedor_modificar_periodo").html(request);
                  $("#modal_modificar_periodo").modal('show');
              });

          });
          $(".link").tooltip({html: true});
          /*
          var img = "<?php  echo $unidad;?>";
          if (img == 26) {

              $.get("/mostrar_validacion", function (request) {
                  $('#oficios').append("<span class='badge'><b>" + request.ofs + "</b></span>");
              });
              setInterval(cargar, 30000);
          }
          if (img == 23) {

              $.get("/mostrar_validacion_personal", function (request) {
                  $('#oficiospersonal').append("<span class='badge'><b>" + request.ofp + "</b></span>");
              });
              setInterval(cargarpersonal, 30000);
          }
          */
          /*var unidadades = "<?php  echo $id_unidad_admin;?>";
          if (unidadades == true) {
              $.get("/notificaciones/oficios", function (request) {
                  $('#solicitud').append("<span class='badge'><b>" + request.ofsl + "</b></span>");
              });
              setInterval(notificacionesof, 30000);
          }
          */
      });
  </script>
    <script>
        $(document).ready(function(){
            $('.dropdown-submenu a.test').on("click", function(e){
                $(this).next('ul').toggle();
                e.stopPropagation();
                e.preventDefault();
            });
        });
    </script>
    <style>
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
        }
    </style>
@endsection

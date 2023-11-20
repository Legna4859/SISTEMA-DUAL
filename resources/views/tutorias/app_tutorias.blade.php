<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> * Tutorias *</title>
    <!-- Scripts -->
    <script src="{{ asset('js/js_tutorias/app.js') }}"></script>
    <script src="{{asset('js/js_tutorias/highcharts.js')}}"></script>
    <script src="{{asset('js/js_tutorias/highcharts-export.js')}}"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <link href="{{ asset('css/css_tutorias/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css_tutorias/estilo.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css_tutorias/bootstrap-DataTable.css') }}" rel="stylesheet">


    <link type="text/css" rel="stylesheet" href="{{asset('css/css_tutorias/all.css')}}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset("css/css_tutorias/app.css")}}" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <title>@yield("title")</title>
    <link rel="stylesheet" href="{{ asset('assets/css/estilos.css') }}">
    <link rel='stylesheet' href='{{ asset('css/css_tutorias/fullcalendar.css') }}' />

    <script src="{{ asset('js/js_tutorias/moment.min.js') }}" defer></script>
    <script src="{{ asset('js/js_tutorias/fullcalendar.min.js') }}" defer></script>
    <script src="{{ asset('js/js_tutorias/locale/es.js') }}" defer></script>
    <link href="{{ asset('open-iconic-master/font/css/open-iconic-bootstrap.css') }}" rel="stylesheet" >

</head>
<body>
<header id="header" >
    <div  class="colorheader col-12 card "  >
        <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-1"></div>
            <div class="col-xs-1 col-sm-1 col-md-1">
                <img id="logo1" src="{{ asset('img/logos/gem.png') }}" />
            </div>
            <div class="col-xs1 col-sm-1 col-md-1">
                <img id="logo2" src="{{ asset('img/logos/EdoMEXvertical.png') }}" />
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 lineas text-center pt-3">
                <h5 class="font-weight-bold">Sistema de Seguimiento al Programa Institucional de Tutorias para Educación Superior</h5>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2">
                <img id="logo3" src="{{ asset ('assets/img/tes.png') }}" />
            </div>
        </div>
    </div>
</header>
<br>

<div id="app" class="container">
    @if(Session::get('nombre'))
        <div class="row">
            <div class="col-12 text-right ">
                <h5> <span class="badge badge-primary">{{ Session::get('nombre')}}    Periodo: {{ Session::get('nombre_periodo')}} </span></h5>
            </div>
        </div>
    @endif
    @if(Session::has('tutor_asignado'))
        <div class="row">
            <div class="col-12 text-right ">
                <h5> <span class="badge badge-info">Tutor {{ Session::get('tutor_asignado')}}     {{ Session::get('generacion_asignada')}} </span></h5>
            </div>
        </div>
    @endif
    <nav class="navbar navbar-expand-md navbar-light shadow-sm subm bg-white">
        <div class="container" >
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="active left"><a href="{{url('/')}}" title="Regresar al sistema academico"> <i class="fa fa-arrow-alt-circle-left" style="font-size:25px;color:#d2cd21;margin: 5px"></i> </a></li>

                @if (Session::has('tutor_asignado'))

                        <li class="nav-item">
                            <a class="nav-link" href="/tutorias/inicioalu">Expediente</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href=/tutorias/actividad>Actividades</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href=/tutorias/calendario>Calendario de Actividades</a>
                        </li>
                        @if(Session::get('estado_eva') == true)
                            <li>
                                <a class="nav-link text-dark" href="/tutoras_evaluacion/evaluacion_al_tutor/">Evaluación al Tutor</a>
                            </li>
                        @endif

                    @else

                        @guest

                        @else
                            @if (Session::get('jefe'))
                                <div class="dropdown">
                                    <a class="dropdown-toggle btn border-0" type="button" id="MenuJefe" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Tutorías
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="MenuJefe">
                                        <a class="dropdown-item" href="/tutorias/jefevista">Tutores y Coordinador</a>
                                        <a class="dropdown-item" href="/tutorias/asignacovista">Asigna Coordinador</a>
                                        <a class="dropdown-item" href="/tutorias/asignatuvista">Asigna Tutor</a>
                                        <a class="dropdown-item" href="/tutorias/alumnos">Estudiantes</a>
                                       <a class="dropdown-item" href="/tutoras_evaluacion/resultado_tutorias_jefe/">Evaluación al Tutor</a>

                                    </div>
                                </div>
                            @endif
                            @if (Session::get('tutor'))
                                <div class="dropdown">
                                    <a class="dropdown-toggle btn border-0" type="button" id="MenuTutor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Tutorías
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="MenuTutor">
                                        <a class="dropdown-item" href="/tutorias/tutorvista">{{\Illuminate\Support\Facades\Session::get('tutor')>1?'Grupos Tutorías':'Grupo Tutorías'}}</a>
                                        <!--<a class="dropdown-item" href="/eventos">Eventos</a>-->
                                        <a class="dropdown-item" href="/tutorias/seguimiento">Seguimiento</a>
                                        <a class="dropdown-item" href="/tutorias/desercion">Deserción</a>
                                        <a class="dropdown-item" href="/tutorias/repsemestral">Reporte Semestral</a>
                                        <a class="dropdown-item" href="/tutoras_evaluacion/resultado_tutorias/">Evaluación al tutor</a>
                                        @if(Session::get('estado_eva') == false)
                                            <a class="dropdown-item" href="/tutoras_evaluacion/auto_eveluacion/">Cuestionario al tutor</a>
                                        @endif
                                        <!--<a class="dropdown-item" href="/planeaciontutor">Planeación</a>-->
                                    </div>
                                </div>
                            @endif
                            @if (Session::get('coordinador'))
                                <div class="dropdown">
                                    <a class="dropdown-toggle btn border-0" type="button" id="MenuCoordinador" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Coordinador
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="MenuCoordinador">
                                        <a class="dropdown-item" href="/tutorias/carreras">{{ \Illuminate\Support\Facades\Session::get('coordinador')>1 ? 'Programas educativos':'Programa educativo' }}</a>
                                        <!--<a class="dropdown-item" href="/coordina_carrera">Planeación</a>-->
                                        <a class="dropdown-item" href="/tutoras_evaluacion/resultado_tutorias_jefe/">Evaluación al Tutor</a>
                                        <a class="dropdown-item" href="/tutorias/reportecoordinador/repsemestralcarrera">Reporte Semestral</a>

                                    </div>
                                </div>
                            @endif
                            @if (Session::get('coordinadorgeneral'))
                                <div class="dropdown">
                                    <a class="dropdown-toggle btn border-0" type="button" id="MenuCoordinador" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Coordinador Institucional
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="MenuCoordinadorGeneral">
                                        <a class="dropdown-item" href="/tutorias/planeacioncoorgen">Planeación</a>
                                       {{-- <a class="dropdown-item" href="/tutorias/revision">Revisar Sugerencias</a>--}}
                                        <a class="dropdown-item" href="/tutorias/estadisticas/carreras">Programas educativos</a>
                                        <a class="dropdown-item" href="/tutoras_evaluacion/resultado_tutorias_cordinador/">Evaluación al tutor</a>
                                        <a class="dropdown-item" href="/tutorias/reporteinstitucional/repsemestral_ins">Reporte Semestral</a>
                                    </div>
                                </div>
                            @endif
                            @if (Session::get('desarrollo'))
                                <div class="dropdown">
                                    <a class="dropdown-toggle btn border-0" type="button" id="MenuCoordinador" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Desarrollo Académico
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="MenuDesarrollo">
                                        <a class="dropdown-item" href="/tutorias/desarrollovista">Coordinador Institucional</a>
                                        <a class="dropdown-item" href="/tutorias/asignacorgenvista">Asigna Coordinador Institucional</a>
                                        <a class="dropdown-item" href="/tutorias/planeaciondesarrollo">Planeación</a>
                                       {{-- <a class="dropdown-item" href="/tutorias/revisiondesarrollo">Ver Sugerencias</a>--}}
                                        <a class="dropdown-item" href="/tutorias/estadisticas/carreras">Programas educativos</a>
                                        <a class="dropdown-item" href="/tutoras_evaluacion/resultado_tutorias_cordinador/">Evaluación al Tutor</a>
                                        <a class="dropdown-item" href="/tutorias/evaluacion_tutor/estado/">Activacion de Evaluacion al Tutor</a>
                                    </div>
                                </div>

                            @endif

                        @endguest
                            <li class="nav-item">
                                <a class="nav-link" id="periodo" href="#" title="periodos">  <i class="fa fa-calendar" style="font-size:25px;color:#b7432e"></i></a>
                            </li>
                    @endif



                    <li class="nav-item">
                        <a href="{{ url('/logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                           class="nav-link" data-toggle="dropdown" role="button" aria-expanded="false">
                            Salir
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>


            </div>
        </div>
    </nav>
        @section('part_modal_periodos')
            @if (!Auth::guest())
                @include('partials.periodos')
            @endif
        @show
    <main class="py-4">
        <div class="container">

            @yield('content')
        </div>
    </main>
</div>
<br>
<footer class="colorfooter col-12 footer-responsive" style="text-align: center">
    <div class="row">
        <div class=" col-md-12" style="text-align: center">
            Tecnológico de Estudios Superiores Valle de Bravo
            Gobierno Del Estado De México
        </div>
    </div>
    <div class="row">
        <div class=" col-md-12" style="text-align: center">
        Km. 30 de la Carretera Federal Monumento-Valle de Bravo Ejido de San Antonio de la Laguna Valle de Bravo C.P 51200
    </div>
    </div>
    <div class="row">
        <div class=" col-md-12" style="text-align: center">
         Algunos Derechos Reservados 2011 Gobierno del Estado de México | <strong>Dudas y comentarios Webmaster</strong>
    </div>
    </div>
</footer>
</body>
</html>

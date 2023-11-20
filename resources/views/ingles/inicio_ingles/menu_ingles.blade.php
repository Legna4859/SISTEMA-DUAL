@section('menu_ingles')
    <div class="container">
<div class="row">
<?php
    $unidad = Session::get('id_unidad_admin');
    $palumno = session()->has('palumno') ? session()->has('palumno') : false;
    $profesor_ingles = session()->has('profesor_ingles') ? session()->has('profesor_ingles') : false;
    $nombre = Session::get('nombre');
?>


        <?php     $nombre_periodo = Session::get('nombre_periodo_ingles'); ?>
        <?php     $periodo_ingles = Session::get('periodo_ingles'); ?>
    @if($profesor_ingles==true)
        <?php $nombre_ingles = Session::get('nombre_ingles');?>
            <div class="col-md-4 " style="">
                            <span class="badge badge-pill badge-primary" style="background: #a5d2c7; margin: 10px;">{{ $nombre_ingles }} </span>

            </div>

    @elseif($palumno==true || $unidad == 19)
        <div class="col-md-4 " style="">
            <span class="badge badge-pill badge-primary" style="background: #a5d2c7; margin: 10px;">{{ $nombre }} </span>

        </div>
    @endif
        <div class="col-md-4 col-md-offset-4" style="">
                            <span class="badge badge-pill badge-primary" style="background: #a5d2c7; margin: 10px;"> <a
                                        class="periodo_ingles" href="#" id="{{$periodo_ingles}}"> Periodo de Ingles: {{$nombre_periodo}}<span
                                            class="glyphicon glyphicon-book"
                                            style="font-size:15px;color:red"></span></a>   </span>

        </div>



   </div>
        <div class="row">
            <div class="col-md-12">
            <nav class="navbar navbar-light" style="background-color: #f0fddc; margin-top: 15px;">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button class="navbar-toggle collapsed btn-lg" style="background: #dfeeec" type="button" data-toggle="collapse" data-target="#myNavbar">
                            <span class="glyphicon glyphicon-list"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar" >
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
                        @if($profesor_ingles==true)
                        <?php $id_usuario = Session::get('id_usuario');?>
                        <ul class="nav navbar-nav navbar-left docente">
                            <li class="dropdown">
                                <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">Datos P.
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="/profesores_ingles/modificar/{{ $id_usuario }}/">Editar</a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                        @endif
                        @if($unidad==19 )
                        <ul class="nav navbar-nav navbar-left">
                            <li class="dropdown">
                            <li><a href="{{url('/armar_plantilla/profesore_ingles')}}">Facilitadores de
                                    ingles</a></li>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Horarios<span
                                            class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{url('/agregar_profesor/ingles_periodo/')}}">Agregar plantilla
                                            al periodo</a></li>
                                    <li><a href="{{url('/ingles_horarios/agregar')}}">Armar horarios</a></li>
                                    <li><a href="{{url('/ingles/mostrar_horarios_profesores')}}">Horarios de los
                                            Facilitadores</a></li>
                                    <li><a href="{{url('/ingles/mostrar_horario_profesor_grupo/')}}">Horarios
                                            por grupo</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                            <li><a href="{{url('/ingles/mostrar_niveles')}}">Niveles</a></li>
                            </li>
                            <li class="dropdown">
                            <li><a href="{{url('/ingles_horarios/mostrar_grupo')}}">Grupos</a></li>
                            </li>
                            <li class="dropdown">
                            <li><a href="{{url('/ingles/mostrar_periodos')}}">Periodos intersemestrales</a>
                            </li>
                            <li class="dropdown">
                            <li><a href="{{url('/ingles/autorizacion_cargas/')}}">Cargas academicas</a>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">Calificaciones
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">

                                    <li><a href="{{url('/ingles/profesores/calificaciones')}}">Calificaciones</a>
                                    </li>
                                    <li style=" "><a href="{{url('/ingles/ver_cal_coordinador_ingles/')}}">Boleta de Calificaciones</a></li>
                                    <li style=" "><a href="{{url('/titulacion/ingles_carreras/')}}">Certificado de Acreditacion</a></li>
                                    <li ><a href="{{url('/ingles/historial_academico_alumno/')}}">Historial de Calificaciones</a></li>

                                </ul>
                            </li>

                        </ul>
                            <ul class="nav navbar-nav navbar-left" style="">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Validación de Vouchers<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/ingles/vouchers_validacion')}}">Vouchers En Espera de validación</a></li>
                                        <li><a href="{{url('/ingles/vouchers_aceptados')}}">Vouchers Aceptados</a></li>
                                        <li><a href="{{url('/ingles/vouchers_rechazados')}}">Vouchers Rechazados</a></li>
                                        <li><a href="{{url('/ingles/maximo_grupo_alumnos')}}">Maximo de Estudiantes por Periodo</a></li>
                                    </ul>
                                </li>
                            </ul>

                        @endif
                        @if($palumno==true)
                        <ul class="nav navbar-nav navbar-left" style="">
                            <li class="dropdown">
                                <a class="dropdown-toogle" href="" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">Carga academica de ingles
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{url('/ingles_horarios/cargar_voucher_pago')}}">Cargar voucher de pago</a></li>
                                    <li><a href="{{url('/ingles_horarios/llenar_carga_academica/')}}">Registrar carga academica de ingles</a></li>
                                    <li><a href="{{url('/ingles_horarios/revision_carga_academica/')}}">Ver carga academica de ingles</a></li>
                                    <li><a href="{{url('/ingles/ver_cal_alumno_ingles/')}}">Ver calificaciones de ingles</a></li>

                                </ul>
                            </li>
                        </ul>
                        @endif
                        @if($profesor_ingles==true)
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="{{url('/ingles/Calificaciones')}}">Calificaciones</a></li>
                                <li class="dropdown">

                            </ul>
                        @endif
                        @if($profesor_ingles!=true)
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="{{url('/')}}"><span class="glyphicon glyphicon-arrow-left"></span>  Regresar</a></li>
                            <li class="dropdown">

                        </ul>
                        @endif


                    </div>
                </div>
            </nav>
        </div>
        </div>
    </div>

    {{--modificar periodo--}}
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
    {{--fin modificar periodo--}}
    <script type="text/javascript">
        $(document).ready(function () {
            $(".periodo_ingles").click(function (event) {
                var periodo_ing = $(this).attr('id');
                $.get("/profesores_ingles/periodos/" + periodo_ing, function (request) {
                    $("#contenedor_modificar_periodo").html(request);
                    $("#modal_modificar_periodo").modal('show');
                });

            });
        });
    </script>
    @endsection
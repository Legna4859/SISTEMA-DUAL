@extends('layouts.app')
@section('title', 'Servicio Social')
@section('content')
    <main>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Carta de Presentación-Aceptación</h3>
                    </div>
                </div>
            </div>

            <div class="row col-md-11 col-md-offset-1">
                <ul class="nav nav-tabs">
                    <li><a href="{{ url('/servicio_social/ingresar_contancia/departamento/' ) }}" >Enviar Carta de Presentación</a></li>
                    <li class="active"><a href="#">En proceso de Modificación</a>
                    </li>
                    <li>
                        <a href="{{ url('/servicio_social/proceso_revicion_cartapresentacion/departamento/' ) }}" >Estudiantes para Revisión Carta P.</a>
                    </li>
                    <li>
                        <a href="{{ url('/servicio_social/proceso_autorizadas_cartapresentacion/departamento/' ) }}" >Cartas de presentación Autorizadas</a>
                    </li>



                </ul>

                <div class="tab-content ">
                    <div role="tabpanel" class="tab-pane active" id="uno">

                        <div class=" col-md-9 col-md-offset-1">

                            </br></br></br>

                            <table class="table table-bordered " Style="background: white;" id="tabla_enviar_costancia">
                                <thead>
                                <tr>
                                    <th>No. CUENTA</th>
                                    <th>NOMBRE DE ALUMNO(A)</th>
                                    <th>CARRERA</th>
                                    <th>CORREO ELECTRONICO</th>
                                    <th>NOMBRE DEL PERIODO</th>


                                </tr>
                                </thead>
                                <tbody>

                                @foreach($alumnos as $alumno)
                                    <tr>
                                        <th>{{$alumno["cuenta"]}}</th>
                                        <td>{{$alumno["nombre"]}} </td>
                                        <td>{{$alumno["carrera"]}}</td>
                                        <td>{{$alumno["correo_electronico"]}}</td>
                                        <td>{{$alumno["nombre_periodo"]}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>



                </div>
            </div>

        </div>


    </main>

@endsection
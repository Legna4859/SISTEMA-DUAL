@extends('layouts.app')
@section('title', 'Titulación')
@section('content')
    <main>
        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <p>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                    <a href="{{url("/titulacion/autorizar_jurado_estudiantes")}}">Programas de Estudios</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span>Autorización de Jurado de titulación </span>

                </p>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Autorización de Jurado de titulación <br> ({{ $carrera->nombre }})</h3>
                    </div>
                </div>
            </div>

            <div class="row col-md-11 col-md-offset-1">
                <ul class="nav nav-tabs">
                    <li>
                        <a href="{{ url('/titulacion/autorizar_jurado_estudiantes_carrera/'.$id_carrera ) }}" >Autorizar jurado de titulación</a>
                    </li>
                    <li>
                        <a href="{{ url('/titulacion/proceso_modificacion_jurado/'.$id_carrera ) }}" >En proceso de modificación</a>
                    </li>
                    <li class="active"><a href="#">Estudiantes con jurado autorizado</a>
                    </li>




                </ul>

                <div class="tab-content ">
                    <div role="tabpanel" class="tab-pane active" id="uno">

                        <div class=" col-md-12 ">
                            <br>

                            <table class="table table-bordered " Style="background: white;" id="tabla_revicion">
                                <thead>
                                <tr>
                                    <th>No. CUENTA</th>
                                    <th>NOMBRE DE ALUMNO(A)</th>
                                    <th>CARRERA</th>
                                    <th>CORREO ELECTRONICO</th>
                                    <th>TELEFONO</th>
                                    <th>ACCIÓN</th>



                                </tr>
                                </thead>
                                <tbody>

                                @foreach($alumnos_autorizados as $alumno)
                                    <tr>
                                        <th>{{$alumno->no_cuenta }}</th>
                                        <td>{{$alumno->apaterno }} {{$alumno->amaterno }} {{$alumno->nombre_al }} </td>
                                        <td>{{$alumno->carrera}}</td>
                                        <td>{{$alumno->correo_electronico}}</td>
                                        <td>{{$alumno->telefono}}</td>
                                            <td>
                                                <a class="btn btn-primary" href="{{asset('/titulacion/ver_jurado_estudiante_autorizado/'.$alumno->id_alumno)}}" >Ver jurado</a>
                                            </td>



                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>



                </div>
            </div>

        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#tabla_revicion').DataTable();



            });
        </script>

    </main>

@endsection
@extends('layouts.app')
@section('title', 'Titulación')
@section('content')
    <main><div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <p>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                    <a href="{{url("/titulacion/autorizar_datos_personales/")}}">Programas de Estudios</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span>Datos personales de los estudiantes de titulación </span>
                </p>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Datos personales de los estudiantes de titulación <br> ({{ $carrera->nombre }})</h3>
                    </div>
                </div>
            </div>

            <div class="row col-md-11 col-md-offset-1">
                <ul class="nav nav-tabs">
                    <li>
                        <a href="{{ url('/titulacion/carrera_alum_reg_datos/'.$id_carrera ) }}" >Autorizar datos personales de los estudiantes de titulación</a>
                    </li>
                    <li class="active">
                        <a href="#">En proceso de modificación</a>
                    </li>
                    <li>
                        <a href="{{ url('/titulacion/faltante_datos_alumno/'.$id_carrera ) }}" >Estudiantes faltante entregar PDF en el centro de información</a>
                    </li>
                    <li>
                        <a href="{{ url('/titulacion/autorizados_datos_alumno/'.$id_carrera ) }}" >Estudiantes con datos personales autorizados</a>
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



                                </tr>
                                </thead>
                                <tbody>

                                @foreach($registro_alumnos as $alumno)
                                    <tr>
                                        <th>{{$alumno->no_cuenta }}</th>
                                        <td>{{$alumno->apaterno }} {{$alumno->amaterno }} {{$alumno->nombre_al }} </td>
                                        <td>{{$alumno->carrera}}</td>
                                        <td>{{$alumno->correo_electronico}}</td>
                                        <td>{{$alumno->telefono}}</td>


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
@extends('layouts.app')
@section('title', 'Titulación')
@section('content')
    <main>
        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <p>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                    <a href="{{url("/titulacion/autorizar_doc_requisitos/")}}">Programas de Estudios</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span>Documentacion de requisitos de titulación</span>

                </p>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Documentacion de requisitos de titulación <br> ({{ $carrera->nombre }})</h3>
                    </div>
                </div>
            </div>

            <div class="row col-md-11 col-md-offset-1">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#">Autorizar Documentación de requisitos de titulación</a>
                    </li>
                   <li>
                        <a href="{{ url('/titulacion/proceso_modificacion_doc_requisitos/'.$id_carrera ) }}" >En proceso de Modificación</a>
                    </li>
                    <li>
                        <a href="{{ url('/titulacion/autorizados_doc_requisitos/'.$id_carrera ) }}" >Estudiantes con Documentación de Requisitos Autorizada</a>
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
                                    <th>ACCIÓN</th>



                                </tr>
                                </thead>
                                <tbody>

                                @foreach($array_alumnos as $alumno)
                                    <tr>
                                        <th>{{$alumno["cuenta"]}}</th>
                                        <td>{{$alumno["nombre"]}} </td>
                                        <td>{{$alumno["carrera"]}}</td>
                                        <td>{{$alumno["correo_electronico"]}}</td>
                                        @if($alumno['id_estado_enviado']== 1)
                                            <td>
                                                <a class="btn btn-primary" href="{{asset('/titulacion/revisar_doc_requisitos/'.$alumno["id_alumno"])}}" id="{{ $alumno['id_alumno'] }}">Autorizar</a>
                                            </td>
                                        @elseif($alumno['id_estado_enviado']== 3)
                                            <td>
                                                <a class="btn btn-primary" href="{{asset('/titulacion/revisar_doc_requisitos/'.$alumno["id_alumno"])}}">Autorizar modificación</a>
                                            </td>
                                        @endif
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
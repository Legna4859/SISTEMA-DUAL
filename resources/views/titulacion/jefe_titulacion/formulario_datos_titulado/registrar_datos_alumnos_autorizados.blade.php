@extends('layouts.app')
@section('title', 'titulacion')
@section('content')
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <p>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                    <a href="{{url("/titulacion/formulario_datos_titulado/inicio/carrera")}}">Programas de Estudios</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span>Autorización de titulaciones </span>

                </p>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"> </h3>
                        <h3 class="panel-title text-center">Autorización de titulaciones<br> ({{ $carrera->nombre }})</h3>
                    </div>
                </div>
            </div>

        </div>

        <div class="row col-md-11 col-md-offset-1">
            <ul class="nav nav-tabs">
                <li>
                    <a href="{{ url('/titulacion/autorizar_titulacion_alumnos/'.$id_carrera ) }}" >Estudiantes para autorizar titulación</a></li>
                <li class="active"><a href="#">Estudiantes autorizados para agregar datos</a>
                </li>
                <li>
                    <a href="{{ url('/titulacion/alumnos_autorizados_carrera/'.$id_carrera ) }}" >Estudiantes titulados</a>
                </li>





            </ul>
            <p>
                <br>
            </p>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <table id="tabla_envio" class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>No. cuenta</th>
                        <th>Nombre del estudiante</th>
                        <th>Correo electronico</th>
                        <th>Telefono</th>
                        <th>Imprimir acta de titulación</th>
                        <th>Acción</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($alumnos as $alumno)
                        <tr>
                            <td>{{$alumno->cuenta}}</td>
                            <td>{{$alumno->nombre}} {{$alumno->apaterno}} {{$alumno->amaterno}}</td>
                            <td>{{$alumno->correo_electronico}}</td>
                            <td>{{$alumno->telefono}}</td>
                                <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/descargar_acta_titulacion/'.$alumno->id_alumno )}}')">Imprimir</button></td>

                            <td><button class="btn btn-primary " onclick="window.location='{{ url('/titulacion/formulario_registrar_datos_al_ti/'.$alumno->id_alumno) }}'">Registrar datos</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </main>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#tabla_envio").DataTable( {
                "order": [[ 3, "desc" ]]
            } );

            $("#tabla_envio").on('click','.edita',function(){
                var idof=$(this).attr('id');

                $.get("/oficios/mostrar/"+idof,function (request) {
                    $("#contenedor_mostrar").html(request);
                    $("#modal_mostrar").modal('show');
                });
            });


        });
    </script>
@endsection
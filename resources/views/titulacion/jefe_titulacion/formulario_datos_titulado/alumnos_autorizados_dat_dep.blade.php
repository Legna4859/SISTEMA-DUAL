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
                <li>
                    <a href="{{ url('/titulacion/alumnos_registrar_datos_dep/'.$id_carrera ) }}" >Estudiantes autorizados para agregar datos</a>
                </li>
                <li class="active"><a href="#">Estudiantes titulados</a>
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
                          <th>Acción</th>
                        <th>Acción</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datos_alum as $dato)
                        <tr>
                            <td>{{$dato['cuenta']}}</td>
                            <td>{{$dato['nombre']}}</td>
                            <td>{{$dato['correo_electronico']}}</td>
                            <td>{{$dato['telefono']}}</td>

                            <td><button class="btn btn-primary " onclick="window.location='{{ url('/titulacion/formulario_datos_titulado_autorizado/dato_alumno/'.$dato['id_alumno'] ) }}'">Ver datos autorizados</button>
                                </td>
                            <td><button class="btn btn-success liberar_alumno " id="{{ $dato['id_alumno'] }}">Liberar titulado</button>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </main>
    {{--Modal de agregar--}}
    <div class="modal fade" id="modal_liberar_alumno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Liberar titulado</h4>
                </div>
                <form id="form_agregar_alumno" class="form" action="{{url("/titulacion/guardar_liberacion_alumno/")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div id="contenedor_liberar_alumno">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button  id="guardar_registro" type="submit" style="" class="btn btn-primary"  >Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#tabla_envio").DataTable( {
                "order": [[ 3, "desc" ]]
            } );
                $("#tabla_envio").on('click','.liberar_alumno',function (){
                var id_alumno=$(this).attr('id');
                $.get("/titulacion/liberacion_alumno/"+id_alumno,function (request) {
                    $("#contenedor_liberar_alumno").html(request);
                    $("#modal_liberar_alumno").modal('show');
                });
                });
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
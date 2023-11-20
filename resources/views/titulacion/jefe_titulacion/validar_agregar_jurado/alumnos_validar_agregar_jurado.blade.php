@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/titulacion/validacion_agregar_jurado/carreras")}}">Programas de Estudios</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Autorizacion de registrar jurado </span>

            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10  col-md-offset-1">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title text-center">Autorizacion de registrar jurado  <br>( {{ $carrera->nombre }})</h3>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4  col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Autorizar estudiantes</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <table id="table_autorizar" class="table table-bordered table-resposive">
                            <thead>
                            <tr>
                                <th>No. Cuenta</th>
                                <th>Nombre del alumno</th>
                                <th>Autorizar</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($autorizar_alumnos as $alumno)

                                <tr>
                                    <td>{{ $alumno->no_cuenta }} </td>
                                    <td>{{ $alumno->nombre_al }} {{ $alumno->apaterno }} {{ $alumno->amaterno }}</td>
                                    <td><button type="button" class="btn btn-primary autorizar_reg_jurado" data-id="{{ $alumno->id_fecha_jurado_alumn }}">Autorizar</button></td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7 ">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Estudiantes autorizados</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <table id="table_autorizados" class="table table-bordered table-resposive">
                            <thead>
                            <tr>
                                <th>No. Cuenta</th>
                                <th>Nombre del alumno</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($autorizados_alumnos as $alumno)

                                <tr>
                                    <td>{{ $alumno->no_cuenta }} </td>
                                    <td>{{ $alumno->nombre_al }} {{ $alumno->apaterno }} {{ $alumno->amaterno }}</td>
                                   </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--Modal autorizar agregar jurado--}}
    <div class="modal fade" id="modal_autorizar_agregar_jurado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Autorizar los datos del estudiante registrados</h4>
                </div>
                <form id="form__autorizar_agregar_jurado" class="form" action="{{url("/titulacion/guardar_autorizar_agregar_jurado/")}}" role="form" method="POST" enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div id="contenedor_autorizar_agregar_jurado">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button   type="submit" style="" class="btn btn-primary"  >Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_autorizar').DataTable();
            $('#table_autorizados').DataTable();
        } );
        $("#table_autorizar").on('click','.autorizar_reg_jurado',function(){
            var id_fecha_jurado_alumn=$(this).data('id');

            $.get("/titulacion/autorizacion_jurado_alumno/"+id_fecha_jurado_alumn,function (request) {
                $("#contenedor_autorizar_agregar_jurado").html(request);
                $("#modal_autorizar_agregar_jurado").modal('show');
            });
        });
    </script>

@endsection
@extends('layouts.app')
@section('title', 'Datos Generales')
@section('content')
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-4 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Alumnos por carreras</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-3">
            <a href="/generar_excel/datos_generales/" class="btn btn-success">Exportar Datos Generales de los Estudiantes <span class="oi oi-document p-1"></span></a>
            </div>
        </div>
            <div class="row">

                <div class="col-md-4 col-md-offset-3">
                    <div class="form-group">
                        <div class="dropdown">
                            <label for="deparamento">Carreras</label>
                            <select name="carrera" id="carrera" class="form-control ">
                                <option>Selecciona carrera</option>
                                @foreach($carreras as $carrera)
                                    @if($carrera->id_carrera==$carrerita)
                                        <option value="{{$carrera->id_carrera}}" selected="selected">{{$carrera->nombre}}</option>
                                    @else
                                        <option value="{{$carrera->id_carrera}}" >{{$carrera->nombre}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <br>
                        </div>
                    </div>

                </div>
                <br>
                <br>
            </div>
        @if($ver == 1)
            <div class="row">
                <div class="col-md-8 col-md-offset-1">
                    <table class="table table-bordered" id="paginar_table">
                        <thead>
                        <tr>
                            <th>Cuenta</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Ver datos del alumno</th>
                            <th>Mostrar calificaciones</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($alumnos as $alumno)
                            <tr>
                                <td>{{$alumno->cuenta}}</td>
                                <td>{{$alumno->nombre}}</td>
                                <td>{{$alumno->apaterno}} {{$alumno->amaterno}} </td>
                                <td class="text-center">
                                    <button class="btn btn-primary mostrar" id="{{ $alumno->id_alumno }}"><i class="glyphicon glyphicon-list"></i></button>
                                </td>
                                <td class="text-center">
                                    <a onclick="window.open('{{url('/servicios_escolares/alumnos/mostrar_calificaciones/'.$alumno->id_alumno)}}')"><i class="glyphicon glyphicon-th em2"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif



    </main>
    <div class="modal fade" id="modal_mostrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Datos de  Alumno</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_mostrar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready( function() {
            $("#carrera").on('change',function(e){
                var id_carrera= $("#carrera").val();
//alert(id_carrera);
                window.location.href='/servicios_escolares/alumnos/generales/'+id_carrera ;
                //  }

            });
            $('#paginar_table').DataTable();
            $("#paginar_table").on('click','.mostrar',function(){
                var idof=$(this).attr('id');

                $.get("/servicios_escolares/alumnos/mostrar/"+idof,function (request) {
                    $("#contenedor_mostrar").html(request);
                    $("#modal_mostrar").modal('show');
                });
            });
        });
    </script>
@endsection
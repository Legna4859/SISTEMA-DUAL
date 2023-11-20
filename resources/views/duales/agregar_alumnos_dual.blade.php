@extends('layouts.app')
@section('title', 'Agregar Alumnos en Plantilla')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">ALUMNOS CANDIDATOS A SER DUALES</h3>
                        </div>
                    </div>
                    <table id="paginar_table" class="table table-bordered " style="text-align: center">
                        <thead >
                        <tr class="info">
                            <th style="text-align: center">No. de Cuenta</th>
                            <th style="text-align: center">Nombre</th>
                            <th style="text-align: center">Apellido Paterno</th>
                            <th style="text-align: center">Apellido Materno</th>
                            <th style="text-align: center">A Plantilla</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($array_estudiantes as $estudiante)
                            <tr>
                                <b><td>{{ $estudiante['cuenta'] }}</td></b>
                                <b><td>{{ $estudiante['nombre'] }}</td></b>
                                <b><td>{{ $estudiante['apaterno'] }}</td></b>
                                <b><td>{{ $estudiante['amaterno'] }}</td></b>
                                <b><td class="text-center">
                                    <a class="agrega" data-id="{{ $estudiante['id_alumno'] }}"><span class="glyphicon glyphicon-log-in em2" aria-hidden="true"></span></a>
                                </td>
                                </b>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">ALUMNOS DUALES EN PLANTILLA</h3>
                        </div>
                    </div>

                    <table id="paginar_tabla" class="table table-bordered" style="text-align: center">
                        <thead>
                        <tr class="info">
                            <th style="text-align: center">Nombre del alumno</th>
                            <th style="text-align: center">Eliminar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($plantillas as $plantilla)
                            <tr>
                                <td>{{$plantilla->nombre ." ". $plantilla->apaterno ." ". $plantilla->amaterno}}</td>
                                <td class="text-center">
                                    <a class="elimina" data-id_alumno="{{ $plantilla->id_duales_actuales }}">
                                        <span class="glyphicon glyphicon-trash em2" aria-hidden="true" style="color: crimson"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- MODAL PARA AGREGAR ALUMNOS A PLANTILLA -->
        <div id="modal_agrega" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <form action="{{url("/duales/guardar_alumno_dual")}}" method="POST" role="form" id="form_alumno_crea">
                            {{ csrf_field() }}
                            <input type="hidden" id="alumno" name="alumno" value="" />
                            <b>¿Realmente deseas agregar a éste alumno a plantilla?</b>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-dismiss="modal" style="background: crimson;color: whitesmoke;">Cancelar <span class="glyphicon glyphicon-remove-sign"></span></button>
                            <button id="confirma_agrega" type="button" class="btn btn-success">Aceptar <span class="glyphicon glyphicon-saved"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL PARA ELIMINAR ALUMNOS-->
        <div id="modal_elimina" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <form action="" method="POST" role="form" id="form_delete">
                            {{method_field('DELETE') }}
                            {{ csrf_field() }}
                            <b>¿Realmente deseas eliminar éste elemento?</b>
                            <input type="hidden" id="eliminar_alumno" name="eliminar_alumno" value="">
                            <div class="modal-footer">
                                <button type="button" class="btn" data-dismiss="modal" style="background: crimson;color: whitesmoke;">Cancelar
                                 <span class="glyphicon glyphicon-remove-sign"></span></button>
                                <button id="confirma_elimina" type="button" class="btn btn-success">Aceptar <span class="glyphicon glyphicon-saved"></span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL PARA AGREGAR MATERIAS -->
        <form id="form_ver_materias" class="form" role="form" method="POST">
            <div class="modal fade bs-example-modal-lg" id="modal_materias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info" style="text-align: center">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <b><h4 class="modal-title" id="myModalLabel">MATERIAS</h4></b>
                        </div>
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <input type="hidden" id="alumnM" name="alumnM" value="">
                            <input type="hidden" id="materias" name="materias" value="">
                            <div class="row">
                                <div id="contenedor_materias">

                                </div>
                            </div>
                        </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success acepta">Agregar</button>
                            </div>
                    </div>
                </div>
            </div>
        </form>

    </main>

    <script>
        $(document).ready(function() {

            $('#paginar_table').DataTable();

            $('#paginar_tabla').DataTable();

            $("#paginar_table").on('click', '.agrega', function () {
                var id_alumno = $(this).data('id');
                //alert(id_alumno);
                $('#alumno').val(id_alumno);
                $('#modal_agrega').modal('show');
            });

            $("#paginar_tabla").on('click', '.elimina', function () {
                var id_duales_actuales=$(this).data('id_alumno');
                //alert(id_duales_actuales);
                $('#eliminar_alumno').val(id_duales_actuales);
                $('#modal_elimina').modal('show');

            });

            $("#confirma_agrega").click(function(event){
                var id_alumno = $("#id_alumno").val();
                $("#form_alumno_crea").submit();
            });

            $("#confirma_elimina").click(function(event){
                var eliminar_alumno = $("#eliminar_alumno").val()
               // alert(eliminar_alumno);
                $("#form_delete").attr("action","/duales/Eliminar_dual/"+eliminar_alumno)
                $("#form_delete").submit();
            });
        });
    </script>

@endsection


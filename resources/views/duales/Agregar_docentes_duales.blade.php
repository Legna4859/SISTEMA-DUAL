@extends('layouts.app')
@section('title', 'Agregar Mentores duales en Plantilla')
@section('content')

    <main class="col-md-12">
        <div class="row" style="padding: 1em">
            <div class="col-md-12">
                <div class="col-md-6 col-md-offset-1" style="text-align: center;padding: 1.5em">
                     <button type="button" style="background: green; border-radius: 500px; color: whitesmoke;" class="btn btn-large" data-toggle="modal" data-target="#myModal">Agregar Mentor al Alumno Dual
                     <span class="glyphicon glyphicon glyphicon-upload"></span>
                     </button>
                     
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12 col-md-offset-1">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title text-center">AGREGAR PROFESORES DUALES A ALUMNOS</h3>
                                    </div>
                                </div>

                                <table id="paginar_table" class="table table-bordered " style="text-align: center">
                                    <thead>
                                    <tr class="info">
                                        <th style="text-align: center"><strong>Nombre del Docente</strong></th>
                                        <th style="text-align: center"><strong>No. Cuenta</strong></th>
                                        <th style="text-align: center"><strong>Nombre del Alumno Dual</strong></th>
                                        <th style="text-align: center"><strong>Apellido Paterno</strong></th>
                                        <th style="text-align: center"><strong>Apellido Materno</strong></th>
                                        <th style="text-align: center"><strong>Acciones</strong></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($datos as $dato)
                                        <tr>
                                            <td>
                                                {{$dato->titulo}} {{$dato->profesor}}
                                            </td>
                                            <td>{{$dato->cuenta}}</td>
                                            <td>{{$dato->nombre}}</td>
                                            <td>{{$dato->apaterno}}</td>
                                            <td>{{$dato->amaterno}}</td>
                                            <td class="text-center">
                                                <a class="elimina" data-id_duales_actuales="{{ $dato->id_duales_actuales }}" data-id_personal="{{$dato->id_personal}}">
                                                    <span class="glyphicon glyphicon-trash em2" aria-hidden="true" style="color: crimson"></span>
                                                </a>
                                            </td>
                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>

                            <!--MODAL PARA AGREGAR ALUMNOS DUALES-->
                            <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title" style="text-align:center">Agregar Mentores Duales</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{url("/duales/guardar_mentor_dual")}}" method="POST" role="form" id="form_guardar_dual">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                <div class="col-md-10 col-md-offset-1 text-center">
                                                    <label for="exampleInputEmail1"> Seleccione un docente para asignarlo como mentor dual</label>
                                                    <select class="form-control text-center" placeholder="selecciona una Opcion" id="id_profesor" name="id_profesor" required>
                                                        <option disabled selected>Selecciona una opción</option>
                                                        @foreach($docentes as $docente)
                                                            <option value="{{$docente->id_personal}}">{{$docente->nombre}}</b></option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 col-md-offset-1 text-center">
                                                    <label for="exampleInputEmail1"> Asigne mentor dual a un alumno</label>
                                                    <select class="form-control text-center" placeholder="selecciona una Opcion" id="id_alumno" name="id_alumno" required>
                                                        <option disabled selected>Selecciona una opción</option>
                                                        @foreach($estudiantes as $estudiante)
                                                            <option value="{{$estudiante->id_alumno}}">{{$estudiante->nombre}} {{$estudiante-> apaterno}} {{$estudiante-> amaterno}}</b></option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" id="btn_guardar" style="border-radius: 500px">Guardar
                                            <span class="glyphicon glyphicon-floppy-saved"></span></button>
                                            <button type="button" class="btn" data-dismiss="modal" style="border-radius: 500px;color: whitesmoke;background: crimson">Salir
                                            <span class="glyphicon 	glyphicon glyphicon-log-out"></span></button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                    </div>
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

    </main>

    <script type="text/javascript">
        $(document).ready( function()
        {
            $('#paginar_table').DataTable();
            $("#btn_guardar").click(function ()
            {
                    var id_profesor = $("#id_profesor").val();
                    if(id_profesor == null)
                    {
                     swal(
                         {
                         position: "top",
                         type: "warning",
                         title: "Selecciona Profesor.",
                         showConfirmButton: false,
                         timer: 3500
                     });
                 }
                else
                    {
                        var id_alumno = $("#id_alumno").val();
                        if(id_alumno == null)
                        {
                         swal(
                             {
                             position: "top",
                             type: "warning",
                             title: "Selecciona Alumno.",
                             showConfirmButton: false,
                             timer: 3500
                         });
                    }
                    else
                    {
                     $("#btn_guardar").attr("disabled", true);
                     $("#form_guardar_dual").submit();
                     swal(
                         {
                         position: "top",
                         type: "success",
                         title: "Registro Exitoso",
                         showConfirmButton: false,
                         timer: 3500
                     });
                 }
             }
          });

            $("#paginar_table").on('click', '.elimina', function () {
                var id_duales_actuales=$(this).data('id_duales_actuales');
                //alert(id_duales_actuales);
                $('#eliminar_alumno').val(id_duales_actuales);
                $('#modal_elimina').modal('show');

            });
            $("#confirma_elimina").click(function(event){
                var eliminar_alumno = $("#eliminar_alumno").val()
                //alert(eliminar_alumno);
                $("#form_delete").attr("action","/duales/Eliminar_dual/"+eliminar_alumno)
                $("#form_delete").submit();
                swal(
                    {
                        position: "top",
                        type: "success",
                        title: "Registro Borrado Exitosamente",
                        showConfirmButton: false,
                        timer: 3500
                    });
            });

        });
    </script>

@endsection

@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">REGISTRO DE SEMESTRE QUE INGRESO AL TESVB LOS ESTUDIANTES <br>{{$carrera->nombre}}</h3>
                    <h5 class="panel-title text-center">(ESTUDIANTES)</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <div class="panel panel-info">

                <div class="panel-body">
                    <h3 style="background: #3f9ae5; color: #0c0c0c"> Estudiantes sin semestre</h3>

                    <table class="table table-bordered " Style="background: white;" id="tablas_alumnos">
                        <thead>
                        <tr>
                            <th>No. CUENTA</th>
                            <th>NOMBRE DE ALUMNO(A)</th>
                            <th>AGREGAR SEMESTRE</th>
                            {{--
                            <th>DESACTIVAR</th>
                            --}}

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($alumnos as $alumno)
                            <tr>
                                <th>{{$alumno->cuenta}}</th>
                                <td>{{$alumno->nombre}} {{$alumno->apaterno}} {{$alumno->amaterno}}</td>
                                <td style="text-align: center">
                                    <button title="Agregar semestre" id="{{ $alumno->id_alumno }}"  class="btn btn-primary agregar_semestre" >
                                      Agregar
                                    </button>
                                    </td>
                                {{--
                                <td style="text-align: center;">
                                    <button title="Desactivar estudiante" id="{{ $alumno->id_alumno }}"  class="btn btn-danger desactivar_alumno" >
                                        Desactivar
                                    </button>
                                </td>
                                --}}
                            </tr>
                        @endforeach



                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-5 ">
            <div class="panel panel-info">

                <div class="panel-body">
                    <h3 style="background: #3f9ae5; color: #0c0c0c"> Estudiantes con semestre registrado</h3>
                    <table class="table table-bordered " Style="background: white;" id="tablas_alumnos_reg">
                        <thead>
                        <tr>
                            <th>No. CUENTA</th>
                            <th>NOMBRE DE ALUMNO(A)</th>
                            <th>SEMESTRE</th>
                            <th>PERIODO DE INGRESO AL TESVB</th>
                            <th>ELIMINAR</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($reg_alumnos as $alumn)
                            <tr>
                                <th>{{$alumn->cuenta}}</th>
                                <td>{{$alumn->nombre}} {{$alumn->apaterno}} {{$alumn->amaterno}}</td>
                                <td>{{$alumn->semestre}}</td>
                                <td>{{$alumn->periodo}}</td>
                                <td style="text-align: center">
                                    <button title="Eliminar registro" id="{{ $alumn->id_semestres_al }}"  class="btn btn-danger eliminar_registro" >
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach



                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    {{-- agregar semestre a estudiante--}}
    <div class="modal fade" id="modal_agregar_semestre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar semestre al estudiante</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_agregar_semestre">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_agregar_semestre"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- eliminar semestre a estudiante--}}
    <div class="modal fade" id="modal_eliminar_semestre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Eliminar registro del estudiante</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_eliminar_semestre">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_eliminar_semestre"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--  desactivar estudiante--}}
    <div class="modal fade" id="modal_desactivar_estudiante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Desactivar estudiante</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_desactivar_estudiante">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_desactivar_estudiante"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#tablas_alumnos').DataTable();
            $('#tablas_alumnos_reg').DataTable();
        });
        $("#tablas_alumnos").on('click','.agregar_semestre',function(){
            var id_alumno=$(this).attr('id');
            $.get("/servicios_escolares/agregar_semestre_al/"+id_alumno,function (request) {
                $("#contenedor_agregar_semestre").html(request);
                $("#modal_agregar_semestre").modal('show');
            });
        });
        $("#tablas_alumnos").on('click','.desactivar_alumno',function(){
            var id_alumno=$(this).attr('id');

            $.get("/servicios_escolares/desactivar_al/"+id_alumno,function (request) {
                $("#contenedor_desactivar_estudiante").html(request);
                $("#modal_desactivar_estudiante").modal('show');
            });
        });
        $("#guardar_agregar_semestre").click(function (){
            var id_periodo = $("#id_periodo").val();
            if(id_periodo != null){
                var id_semestre = $("#id_semestre").val();
                if(id_semestre != null){
                    $("#form_guardar_semestre").submit();
                    $("#guardar_agregar_semestre").attr("disabled", true);
                    swal({
                        position: "top",
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }else{
                    swal({
                        position:"top",
                        type: "error",
                        title: "Selecciona semestre que ingreso",
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            }else{
                swal({
                    position:"top",
                    type: "error",
                    title: "Selecciona periodo que ingreso el estudiante",
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
       $("#tablas_alumnos_reg").on('click','.eliminar_registro',function (){
           var id_semestre_al=$(this).attr('id');

           $.get("/servicios_escolares/eliminar_semestre_al/"+id_semestre_al,function (request) {
               $("#contenedor_eliminar_semestre").html(request);
               $("#modal_eliminar_semestre").modal('show');
           });
       });
       $("#guardar_eliminar_semestre").click(function (){
           $("#form_guardar_eliminar_sem").submit();
           $("#guardar_eliminar_semestre").attr("disabled", true);
           swal({
               position: "top",
               type: "success",
               title: "Eliminación exitosa",
               showConfirmButton: false,
               timer: 3500
           });
       });
       $("#guardar_desactivar_estudiante").click(function (){
           $("#form_guardar_desactivar_est").submit();
           $("#guardar_desactivar_estudiante").attr("disabled", true);
           swal({
               position: "top",
               type: "success",
               title: "Desactivación exitosa",
               showConfirmButton: false,
               timer: 3500
           });
       });


    </script>
@endsection
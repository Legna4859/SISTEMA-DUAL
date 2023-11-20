@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">ACTUALIZACIÓN DE SEMESTRE A ESTUDIANTES<br>{{$carrera->nombre}}</h3>
                    <h3 class="panel-title text-center">PERIODO ACTIVO<br>{{$periodo_activo->periodo}}</h3>

                    <h5 class="panel-title text-center">(ESTUDIANTES)</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-md-offset-5">

                    <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Actualizacion del semestre" data-target="#modal_actualizacion_sem" type="button" class="btn btn-success btn-lg flotante">
                     Actualizar semestre
                    </button>
                    <p><br></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <h3 style="background: #3f9ae5; color: #0c0c0c"> Estudiantes sin semestre actualizado en este periodo</h3>

            <div class="panel panel-info">

                <div class="panel-body">

                    <table class="table table-bordered " Style="background: white;" id="tablas_alumnos">
                        <thead>
                        <tr>
                            <th>No. CUENTA</th>
                            <th>NOMBRE DE ALUMNO(A)</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($reg_alumnos as $alum)
                            <tr>
                                <th>{{$alum->cuenta}}</th>
                                <td>{{$alum->nombre}} {{$alum->apaterno}} {{$alum->amaterno}}</td>


                            </tr>
                        @endforeach



                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-5 ">
            <h3 style="background: #3f9ae5; color: #0c0c0c"> Estudiantes con semestre actualizado en este periodo</h3>

            <div class="panel panel-info">

                <div class="panel-body">

                    <table class="table table-bordered " Style="background: white;" id="tablas_alumnos_act">
                        <thead>
                        <tr>
                            <th>No. CUENTA</th>
                            <th>NOMBRE DE ALUMNO(A)</th>
                            <th>SEMESTRE</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($alumnos_act as $alumno)
                            <tr>
                                <th>{{$alumno->cuenta}}</th>
                                <td>{{$alumno->nombre}} {{$alumno->apaterno}} {{$alumno->amaterno}}</td>
                                <td>{{$alumno->semestre}}</td>


                            </tr>
                        @endforeach



                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    {{--  activar estudiante--}}
    <div class="modal fade" id="modal_actualizacion_sem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Actualizar semestre</h4>
                </div>
                <div class="modal-body">
                    <form  id="form_guardar_actualizacion" action="{{url("/servicios_escolares/guardar_act_sem_al/".$periodo_activo->id_periodo."/".$carrera->id_carrera)}}" role="form" method="POST" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                    <h3 style="text-align: center">¿Seguro(a) que quieres actualizar el semestre a los estudiantes?</h3>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_actualizacion"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {

            $('#tablas_alumnos').DataTable();
            $('#tablas_alumnos_act').DataTable();

            $("#guardar_actualizacion").click(function (){
                $("#form_guardar_actualizacion").submit();
                $("#guardar_actualizacion").attr("disabled", true);
                swal({
                    position: "top",
                    type: "success",
                    title: "Actualización exitosa",
                    showConfirmButton: false,
                    timer: 3500
                });
            });
        });
    </script>
@endsection
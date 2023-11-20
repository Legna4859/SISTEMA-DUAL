@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">ESTUDIANTES INACTIVOS ( QUE NO SE LE AREGARIA SEMESTRE)<br>{{$carrera->nombre}}</h3>

                    <h5 class="panel-title text-center">(ESTUDIANTES)</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-info">

                <div class="panel-body">

                    <table class="table table-bordered " Style="background: white;" id="tablas_alumnos">
                        <thead>
                        <tr>
                            <th>No. CUENTA</th>
                            <th>NOMBRE DE ALUMNO(A)</th>
                            <th>ACTIVAR</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($alumnos as $alumno)
                            <tr>
                                <th>{{$alumno->cuenta}}</th>
                                <td>{{$alumno->nombre}} {{$alumno->apaterno}} {{$alumno->amaterno}}</td>
                                <td style="text-align: center">
                                    <button title="Activar estudiante" id="{{ $alumno->id_alumno }}"  class="btn btn-primary activar_estudiante" >
                                        Activar
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
    {{--  activar estudiante--}}
    <div class="modal fade" id="modal_activacion_estudiante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Activar estudiante</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_activacion_estudiante">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_activar_estudiante"  class="btn btn-primary" >Aceptar</button>
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
        $("#tablas_alumnos").on('click','.activar_estudiante',function(){
            var id_alumno=$(this).attr('id');
            $.get("/servicios_escolares/activacion_estudiante_seme/"+id_alumno,function (request) {
                $("#contenedor_activacion_estudiante").html(request);
                $("#modal_activacion_estudiante").modal('show');
            });
            $("#guardar_activar_estudiante").click(function (){
                $("#form_guardar_activar_est").submit();
                $("#guardar_activar_estudiante").attr("disabled", true);
                swal({
                    position: "top",
                    type: "success",
                    title: "Activación exitosa",
                    showConfirmButton: false,
                    timer: 3500
                });
            });
        });
    </script>
@endsection
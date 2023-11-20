@extends('layouts.app')
@section('title', 'Proyectos')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"> Proyectos del {{ $year }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-1 col-md-offset-2">
            <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nuevo proyecto" data-target="#modal_crear_proyecto" type="button" class="btn btn-success btn-lg flotante">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <p><br></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table class="table table-bordered" id="registros_proyectos">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Nombre del proyecto</th>
                    <th>Modificar</th>
                    <th>Estado</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; ?>
                @foreach($proyectos as $proyecto)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $proyecto->nombre_proyecto }}</td>
                        <td>
                            <button data-toggle="tooltip" data-placement="top" id="{{$proyecto->id_proyecto }}" title="Modificar proyecto" class="btn btn btn-primary h-primary_m pl-5 pr-5 modificar_proyecto">Modificar proyecto</button>
                        </td>
                        <td style="text-align: center">
                            @if($proyecto->id_estado == 0)
                            <button data-toggle="tooltip" data-placement="top" id="{{$proyecto->id_proyecto }}" title="Activar" class="btn btn btn-success h-primary_m pl-5 pr-5 activar_proy">Activar</button>
                                @elseif($proyecto->id_estado == 1)
                                <h4 style="text-align: center">Activado</h4>
                                <button data-toggle="tooltip" data-placement="top" id="{{$proyecto->id_proyecto }}" title="Desactivar" class="btn btn btn-danger h-primary_m pl-5 pr-5 desactivar_proy">Desactivar</button>

                            @endif
                        </td>

                    </tr>
                @endforeach



                </tbody>
            </table>
        </div>
    </div>

    {{-- modal crear proyecto--}}

    <div class="modal fade" id="modal_crear_proyecto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar proyecto</h4>
                </div>
                <div class="modal-body">

                    <form id="form_agregar" class="form" action="{{url("/presupuesto_anteproyecto/guardar_proyecto/")}}" role="form" method="POST" >
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label>Agregar nombre del proyecto</label>
                                    <input class="form-control "   type="text"  id="nombre_proyecto"  onkeyup="javascript:this.value=this.value.toUpperCase();" name="nombre_proyecto"  >
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_proyecto"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal modificar proyecto--}}

    <div class="modal fade" id="modal_modificacion_proyecto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar proyecto</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_modificacion_proyecto">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_modificacion_proyecto"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal activar proyecto--}}

    <div class="modal fade" id="modal_activar_proyecto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Activar proyecto</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_activar_proyecto">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_activar_proyecto"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal desactivar proyecto--}}

    <div class="modal fade" id="modal_desactivar_proyecto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Desactivar proyecto</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_desactivar_proyecto">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_desactivar_proyecto"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script type="text/javascript">
        $(document).ready( function() {

            $("#guardar_proyecto").click(function (){
                var nombre_proyecto = $('#nombre_proyecto').val();

                if( nombre_proyecto != ''){

                        $("#form_agregar").submit();
                        $("#guardar_proyecto").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "El campo nombre del proyecto no debe ser vacio",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#registros_proyectos").on('click','.modificar_proyecto',function(){
                var id_proyecto =$(this).attr('id');

                $.get("/presupuesto_anteproyecto/modificar_proyecto/"+id_proyecto,function (request) {
                    $("#contenedor_modificacion_proyecto").html(request);
                    $("#modal_modificacion_proyecto").modal('show');
                });
            });

            $("#registros_periodos").on('click','.modificar_periodo',function(){
                var id_periodo =$(this).attr('id');

                $.get("/presupuesto_anteproyecto/modificar_periodos_anteproyecto/"+id_periodo,function (request) {
                    $("#contenedor_modificacion").html(request);
                    $("#modal_modificacion").modal('show');
                });
            });
            $("#guardar_modificacion_proyecto").click(function (){
                $("#form_modificar_proyecto").submit();
                $("#guardar_modificacion_proyecto").attr("disabled", true);
            });
            $(".activar_proy").click(function (){
                var id_proyecto =$(this).attr('id');

                $.get("/presupuesto_anteproyecto/activar_proyecto/"+id_proyecto,function (request) {
                    $("#contenedor_activar_proyecto").html(request);
                    $("#modal_activar_proyecto").modal('show');
                });
            });

            $("#guardar_activar_proyecto").click(function (){
                $("#form_activar_proyecto").submit();
                $("#guardar_activar_proyecto").attr("disabled", true);
            });
            $(".desactivar_proy").click(function (){
                var id_proyecto =$(this).attr('id');

                $.get("/presupuesto_anteproyecto/desactivar_proyecto/"+id_proyecto,function (request) {
                    $("#contenedor_desactivar_proyecto").html(request);
                    $("#modal_desactivar_proyecto").modal('show');
                });
            });
            $("#guardar_desactivar_proyecto").click(function (){
                $("#form_desactivar_proyecto").submit();
                $("#guardar_desactivar_proyecto").attr("disabled", true);
            });


        });
    </script>
@endsection
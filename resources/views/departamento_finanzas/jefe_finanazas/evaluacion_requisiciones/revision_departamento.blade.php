@extends('layouts.app')
@section('title', 'Revisión de requisiciones')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/presupuesto_anteproyecto/revicion_requisiciones_anteproyecto")}}">Revisión de requisiciones de los departamentos </a>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <span >Requisiciones del departamento </span>

            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Revisión de requisiciones del anteproyecto de presupuesto {{ $datos_jefe->year_requisicion }}<br>
                    (NOMBRE DEL JEFE(A) DEL DEPARTAMENTO O JEFATURA: <b>{{ $datos_jefe->titulo }} {{ $datos_jefe->nombre }})</b><br>
                    (NOMBRE DEL DEPARTAMENTO O JEFATURA: <b>{{ $datos_jefe->nom_departamento }}</b></h3>
                      </div>
            </div>
        </div>
        <br>
    </div>




    <div class="row">
        <div class="col-md-2 col-md-offset-2">
            <p></p>
        </div>
    </div>

    @foreach($requisiciones2 as $requisicion)
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-warning">
                    <div class="panel-heading">

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <h4 style="text-align: center; color: #0c0c0c">PARTIDA PRESUPUESTAL: <b>{{ $requisicion['nombre_partida'] }}</b></h4>
                                <h4 style="text-align: center; color: #0c0c0c">MES: <b>{{ $requisicion['mes'] }}</b></h4>
                                <h5 style="text-align: center; color: #0c0c0c">JUSTIFICACIÓN: <b>{{ $requisicion['justificacion'] }}</b></h5>
                                <h4 style="text-align: center; color: #0c0c0c">PROYECTO: <b>{{ $requisicion['nombre_proyecto'] }}</b></h4>
                                <h5 style="text-align: center; color: #0c0c0c">META: <b>{{ $requisicion['meta'] }}</b></h5>
                            </div>
                        </div>
                        @if( $requisicion['id_autorizacion']  == 0)
                                @if($requisicion['comentario']  != '' )
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <h4 style="color: #942a25; background: white">COMENTARIO MODIFICACIÓN: <b>{{ $requisicion['comentario']  }}</b></h4>
                                    </div>

                                </div>
                                @endif
                            <div class="row">
                                <div class="col-md-2 col-md-offset-5">
                                    <button class="btn btn-success btn-lg" onclick="window.location='{{ url('/presupuesto_anteproyecto/revisicion_bienes_servicios_departamento/'.$requisicion['id_actividades_req_ante'].'/'.$id_req_mat_ante ) }}'">Revisar requisición</button>
                                </div>

                            </div>
                        @else
                                @if( $requisicion['id_autorizacion']  == 2)
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading" style="text-align: center">Permiso de modificar.<br>
                                                COMENTARIO:  <b>{{ $requisicion['comentario']  }}</b></div>
                                        </div>
                                    </div>
                                </div>

                                @endif
                                    @if( $requisicion['id_autorizacion']  == 4)
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-2">
                                                <div class="panel panel-success">
                                                    <div class="panel-heading" style="text-align: center">
                                                        Requisición autorizada
                                                        <div class="row">
                                                            <div class="col-md-2 col-md-offset-4">
                                                                <button class="btn btn-default btn-lg" onclick="window.location='{{ url('/presupuesto_anteproyecto/ver_autorizacion_bienes_servicios_departamento/'.$requisicion['id_actividades_req_ante'].'/'.$id_req_mat_ante ) }}'">Ver requisición autorizada</button>
                                                            </div>

                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                    @endif
                                    @if( $requisicion['id_autorizacion']  == 3)
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-2">
                                                <div class="panel panel-danger">
                                                    <div class="panel-heading" style="text-align: center">Requisión rechazada<br>
                                                        COMENTARIO DE PORQUE SE RECHAZÓ :  <b>{{ $requisicion['comentario']  }}</b></div>
                                                </div>
                                            </div>
                                        </div>

                                    @endif

                        @endif
                    </div>
                </div>

            </div>

            @endforeach
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <p><br></p>
        </div>
    </div>
            @if($numero_requisicion == $total_req_cal )
                @if($total_mod == 0)
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5">
                            <button  id="{{ $id_req_mat_ante }}"  class="btn btn-primary btn-lg  autorizar_requisiciones" >Enviar notificación
                            </button>
                        </div>
                    </div>

               @else
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5">
                            <button  id="{{ $id_req_mat_ante }}"  class="btn btn-success btn-lg  mod_requisiciones" >Enviar notificación
                            </button>
                        </div>
                    </div>
                @endif
           @endif
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <p><br></p>
                </div>
            </div>

            {{-- modal enviar modificaciones --}}

            <div class="modal fade" id="modal_enviar_modificacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Enviar modificaciones</h4>
                        </div>
                        <div class="modal-body">
                            <form id="form_enviar_modificaciones" action="{{url("/presupuesto_anteproyecto/enviar_modificaciones_depart/")}}" method="POST" role="form" >
                                {{ csrf_field() }}
                                <input type="hidden" id="id_req_mat_ante" name="id_req_mat_ante" value="">
                                <h2 style="text-align: center;">¿ Seguro(a) que quiere enviar las modificaciones al jefe(a) de departamento o jefatura</h2>
                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_enviar_modificaciones"  class="btn btn-primary" >Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- modal enviar autorizacion --}}

            <div class="modal fade" id="modal_enviar_autorizacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Enviar notificación</h4>
                        </div>
                        <div class="modal-body">
                            <form id="form_enviar_autorizacion" action="{{url("/presupuesto_anteproyecto/enviar_autorizacion_depart/")}}" method="POST" role="form" >
                                {{ csrf_field() }}
                                <input type="hidden" id="id_req_mat_antep" name="id_req_mat_antep" value="">
                                <h2 style="text-align: center;">¿Seguro(a) que quiere enviar notificación de que ya se revisaron toda las requisiciones ?</h2>
                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_enviar_autorizacion"  class="btn btn-primary" >Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $(".mod_requisiciones").click(function (){
                        var id_req_mat_ante = $(this).attr('id');
                        $('#id_req_mat_ante').val(id_req_mat_ante);
                        $("#modal_enviar_modificacion").modal('show');
                    });
                    $("#guardar_enviar_modificaciones").click(function (){
                        $("#form_enviar_modificaciones").submit();
                        $("#guardar_enviar_modificaciones").attr("disabled", true);
                    });
                    $(".autorizar_requisiciones").click(function (){
                        var id_req_mat_ante = $(this).attr('id');
                        $('#id_req_mat_antep').val(id_req_mat_ante);
                        $("#modal_enviar_autorizacion").modal('show');
                    });
                    $("#guardar_enviar_autorizacion").click(function (){
                        $("#form_enviar_autorizacion").submit();
                        $("#guardar_enviar_autorizacion").attr("disabled", true);
                    });

                });
            </script>
@endsection
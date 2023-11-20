@extends('layouts.app')
@section('title', 'Requisicion de materiales')
@section('content')
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Requisiciones de materiales {{ $year }}</h3>
                </div>
            </div>
        </div>
    </div>
    @if($estado_periodo == 0)
        <div class="row">
            <div class="col-md-8  col-md-offset-2">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">No se ha registrado el periodo de envio de requisiciones de materiales.</h3>
                    </div>
                </div>
            </div>
        </div>
    @else
        @if($estado_fecha == 1)
            @if($registros == null)
                    <div class="row">
                        <div class="col-md-4  col-md-offset-4 text-center">
                            <div class="panel panel-success">
                                <div class="panel-body">
                                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal_envia_requisicion">Iniciar envió de requisiciones de materiales </button>
                                   </div>
                            </div>
                        </div>
                    </div>
            @else
                    @if($registros->id_estado_requisicion == 0 )
                        <div class="row">
                            <div class="col-md-4  col-md-offset-4 text-center">
                                <div class="panel panel-success">
                                    <div class="panel-body">
                                        <h4>Año de las requisiciones de materiales del anteproyecto: {{ $registros->year_requisicion }}</h4>
                                        <button type="button" class="btn btn-primary center" onclick="window.location=('{{url('/presupuesto_anteproyecto/registro_inicio_req_ant/'.$registros->id_req_mat_ante)}}')">Registrar requisiciones de materiales</button>   </div>
                                </div>
                            </div>
                        </div>

                    @endif

                    @if($registros->id_estado_requisicion == 1 )
                        <div class="row">
                            <div class="col-md-6  col-md-offset-3 text-center">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h4>Se enviaron correctamente tus requisiciones de materiales del anteproyecto: {{ $registros->year_requisicion }}</h4>
                                    </div>
                            </div>
                        </div>

                    @endif
                            @if($registros->id_estado_requisicion == 2 )
                                <div class="row">
                                    <div class="col-md-4  col-md-offset-4 text-center">
                                        <div class="panel panel-success">
                                            <div class="panel-body">
                                                <h4>Año de requisiciones de materiales de anteproyecto: {{ $registros->year_requisicion }}</h4>
                                                <h5>Hacer las modificaciones correspondientes que aparecen en los comentarios al ingresar</h5>
                                                <button type="button" class="btn btn-success center" onclick="window.location=('{{url('/presupuesto_anteproyecto/modificar_requisicones/'.$registros->id_req_mat_ante)}}')">Modificaciones de requisiciones de materiales</button>   </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                                   @if($registros->id_estado_requisicion == 3 )
                                    <div class="row">
                                        <div class="col-md-6  col-md-offset-3 text-center">
                                            <div class="panel panel-success">
                                                <div class="panel-heading">
                                                    <h4>Se enviaron correctamente tus modificaciones de tus requisiciones de materiales del anteproyecto: {{ $registros->year_requisicion }}</h4>
                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                        @if($registros->id_estado_requisicion == 4 )
                                            <div class="row">
                                                <div class="col-md-6  col-md-offset-3 text-center">
                                                    <div class="panel panel-success">
                                                        <div class="panel-heading">
                                                            <h4>Tus requisiciones ya fueron revisadas.</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4  col-md-offset-4 text-center">
                                                    <div class="panel panel-success">
                                                        <div class="panel-body">
                                                            <h4>Año de requisiciones de materiales de anteproyecto: {{ $registros->year_requisicion }}</h4>
                                                            <h5>Ver las requisiciones autorizadas</h5>
                                                            <button type="button" class="btn btn-success center" onclick="window.location=('{{url('/presupuesto_anteproyecto/ver_requisiciones_autorizadas/'.$registros->id_req_mat_ante)}}')">Requisiciones de materiales</button>   </div>
                                                    </div>
                                                </div>
                                            </div>

                                                @endif


            @endif

        @elseif($estado_fecha == 2)
            <div class="row">
                <div class="col-md-8  col-md-offset-2">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <?php
                            $fecha_inicio= date('d-m-Y', strtotime($periodo->fecha_inicio));
                            $fecha_final= date('d-m-Y', strtotime($periodo->fecha_final));
                            ?>
                            <h3 class="panel-title text-center">El periodo todavía no empieza o ya termino, las fechas establecidas para el envió de requisiciones  de materiales son las siguientes : {{ $fecha_inicio }} al  {{ $fecha_final }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($estado_fecha == 3)
            <div class="row">
                <div class="col-md-8  col-md-offset-2">
                    <div class="panel panel-danger">
                        <div class="panel-heading">

                            <h3 class="panel-title text-center">El periodo ya fue finalizado por la Dirección de Administración y Finanzas.</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
    <div class="modal fade" id="modal_envia_requisicion" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Notificación de inicio de envió</h4>
                </div>
                <form id="form_envio" class="form" action="{{url("/presupuesto_anteproyecto/registrar_inicio_req_ant/")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                <div class="modal-body">
                    <p>Iniciar envió de requisiciones de materiales  </p>
                </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_envio"  class="btn btn-primary" >Aceptar</button>
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        $(document).ready( function() {
            $("#guardar_envio").click(function (){
                $("#form_envio").submit();
                $("#guardar_envio").attr("disabled", true);
            });
        });
    </script>


@endsection
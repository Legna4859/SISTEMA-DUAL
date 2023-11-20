@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Periodos de calificaciones')
@section('content')
    <?php
    $unidad = Session::get('id_unidad_admin');
    ?>
    @if($cuenta_periodos == 0)
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">PERIODOS PARA EVALUAR HABILIDADES <br>NIVEL:{{$nivel}} GRUPO:{{$id_grupo}}</h3>
                </div>
                <div class="panel-body">
                    <hr style="border: 1px solid black"/>
                    <div class="row col-md-12">
                            <div class="col-md-4 col-md-offset-2 text-center" style="margin-bottom: 5px">
                                <div style="border: 3px solid #cbf7af;border-radius: 5px; padding: 5px">
                                    <div class="card-body">
                                        <h2>SPEAKING</h2>
                                        <h6 class="text-danger">No asignado</h6>
                                        <button data-toggle="tooltip" data-placement="top" id="1" title="Modificar fecha" class="btn btn btn-primary h-primary_m pl-5 pr-5 agregar">Asignar fecha</button></span>

                                    </div>
                                </div>
                            </div>
                        <div class="col-md-4 col-md-offset-1 text-center" style="margin-bottom: 5px">
                            <div style="border: 3px solid #cbf7af;border-radius: 5px; padding: 5px">
                                <div class="card-body">
                                    <h2>WRITING,READING, LISTENING</h2>
                                    <h6 class="text-danger">No asignado</h6>
                                    <button data-toggle="tooltip" data-placement="top"  title="Modificar fecha" class="btn btn btn-primary h-primary_m pl-5 pr-5" disabled>Asignar fecha</button></span>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    @elseif($cuenta_periodos == 1)
        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">PERIODOS PARA EVALUAR HABILIDADES <br>NIVEL:{{$nivel}} GRUPO:{{$id_grupo}}</h3>
                    </div>
                    <div class="panel-body">
                        <hr style="border: 1px solid black"/>
                        <div class="row col-md-12">
                            <div class="col-md-4 col-md-offset-2 text-center" style="margin-bottom: 5px">
                                <div style="border: 3px solid #cbf7af;border-radius: 5px; padding: 5px">
                                    <div class="card-body">
                                        <h2>SPEAKING</h2>
                                        <?php  $fecha_periodo=date("d-m-Y ",strtotime($periodo1[0]->fecha)) ?>
                                        <h6>{{$fecha_periodo }}</h6>
                                        @if($periodo1[0]->evaluada==1)
                                            <a href="#!" class="btn btn-success tooltip-options link" data-toggle="tooltip" data-placement="top" title="Evaluación realizada"><span class="oi oi-check p-1"></span></a>
                                        @elseif($periodo1[0]->evaluada==0)
                                            <a href="#!" class="btn btn-danger text-white tooltip-options link" data-toggle="tooltip" data-placement="top" title="Evaluación pendiente"><span class="oi oi-clock"></span></a>
                                           @if($unidad == 19)
                                                <button data-toggle="tooltip" data-placement="top" id="1" title="Modificar fecha" class="btn btn btn-primary h-primary_m pl-5 pr-5 modificar"><span class="oi oi-pencil p-1"></span></button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-md-offset-1 text-center" style="margin-bottom: 5px">
                                <div style="border: 3px solid #cbf7af;border-radius: 5px; padding: 5px">
                                    <div class="card-body">
                                        <h2>WRITING,READING, LISTENING</h2>
                                        <h6 class="text-danger">No asignado</h6>
                                        <button data-toggle="tooltip" data-placement="top" id="2" title="Modificar fecha" class="btn btn btn-primary h-primary_m pl-5 pr-5 agregar">Asignar fecha</button></span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    @else
        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">PERIODOS PARA EVALUAR HABILIDADES <br>NIVEL:{{$nivel}} GRUPO:{{$id_grupo}}</h3>
                    </div>
                    <div class="panel-body">
                        <hr style="border: 1px solid black"/>
                        <div class="row col-md-12">
                            <div class="col-md-4 col-md-offset-2 text-center" style="margin-bottom: 5px">
                                <div style="border: 3px solid #cbf7af;border-radius: 5px; padding: 5px">
                                    <div class="card-body">
                                        <h2>SPEAKING</h2>
                                        <?php  $fecha_periodo1=date("d-m-Y ",strtotime($periodo1[0]->fecha)) ?>
                                        <h6>{{$fecha_periodo1 }}</h6>
                                        @if($periodo1[0]->evaluada==1)
                                            <a href="#!" class="btn btn-success tooltip-options link" data-toggle="tooltip" data-placement="top" title="Evaluación realizada"><span class="oi oi-check p-1"></span></a>
                                        @elseif($periodo1[0]->evaluada==0)
                                            <a href="#!" class="btn btn-danger text-white tooltip-options link" data-toggle="tooltip" data-placement="top" title="Evaluación pendiente"><span class="oi oi-clock"></span></a>
                                            @if($unidad == 19)
                                                <button data-toggle="tooltip" data-placement="top" id="1" title="Modificar fecha" class="btn btn btn-primary h-primary_m pl-5 pr-5 modificar"><span class="oi oi-pencil p-1"></span></button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-md-offset-1 text-center" style="margin-bottom: 5px">
                                <div style="border: 3px solid #cbf7af;border-radius: 5px; padding: 5px">
                                    <div class="card-body">
                                        <h2>WRITING,READING, LISTENING</h2>
                                        <?php  $fecha_periodo2=date("d-m-Y ",strtotime($periodo2[0]->fecha)) ?>
                                        <h6>{{$fecha_periodo2 }}</h6>
                                        @if($periodo2[0]->evaluada==1)
                                            <a href="#!" class="btn btn-success tooltip-options link" data-toggle="tooltip" data-placement="top" title="Evaluación realizada"><span class="oi oi-check p-1"></span></a>
                                        @elseif($periodo2[0]->evaluada==0)
                                            <a href="#!" class="btn btn-danger text-white tooltip-options link" data-toggle="tooltip" data-placement="top" title="Evaluación pendiente"><span class="oi oi-clock"></span></a>
                                            @if($unidad == 19)
                                                <button data-toggle="tooltip" data-placement="top" id="2" title="Modificar fecha" class="btn btn btn-primary h-primary_m pl-5 pr-5 modificar"><span class="oi oi-pencil p-1"></span></button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endif

    <div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form_agregar_periodo_ingles" class="form" action="{{url("/ingles/calificaciones/crear_periodos")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Generar Fecha de Evaluación</h4>
                    </div>
                    <div class="modal-body">
                        <div id="contenedor_registro">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  id="guardar_periodo" type="button" style="" class="btn btn-primary"  >Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_modificar_per" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form_mod_periodo_ingles" class="form" action="{{url("/ingles/modificacion_per/")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar Fecha de Evaluación</h4>
                    </div>
                    <div class="modal-body">
                        <div id="contenedor_modificar_per">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button    id="modif_periodo" type="button"  style="" class="btn btn-primary"  >Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        $(document).ready( function() {
            $(".modificar").click(function (event) {
                var id_unidad=$(this).attr('id');

                var id_nivel = "<?php  echo $id_nivel;?>";
                var id_grupo = "<?php  echo $id_grupo;?>";
                $.get("/ingles/modificar_per/"+id_unidad+"/"+id_nivel+"/"+id_grupo,function (request) {
                    $("#contenedor_modificar_per").html(request);
                    $("#modal_modificar_per").modal('show');
                });

            });
            $("#modif_periodo").click(function(event) {
                var fech = $("#fecha_periodo").val();
                if (fech != "") {


                    $("#form_mod_periodo_ingles").submit();
                    $("#modif_periodo").attr("disabled", true);

                } else {
                    swal({
                        position: "top",
                        type: "error",
                        title: "La fecha no debe ser vacia",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".agregar").click(function (event) {
                var id_unidad=$(this).attr('id');

                var id_nivel = "<?php  echo $id_nivel;?>";
                var id_grupo = "<?php  echo $id_grupo;?>";

                $.get("/ingles/registro_periodo_ingles/"+id_unidad+"/"+id_nivel+"/"+id_grupo,function (request) {
                    $("#contenedor_registro").html(request);
                    $("#modal_registro").modal('show');
                });
            });
            $("#guardar_periodo").click(function(event) {
                var fech = $("#fecha_periodo").val();
                if (fech != "") {


                    $("#form_agregar_periodo_ingles").submit();
                    $("#guardar_periodo").attr("disabled", true);

                } else {
                    swal({
                        position: "top",
                        type: "error",
                        title: "La fecha no debe ser vacia",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
        });
    </script>
@endsection
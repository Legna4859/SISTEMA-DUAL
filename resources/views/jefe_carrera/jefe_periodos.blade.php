@extends('layouts.app')
@section('title', 'Periodos J.C.')
@section('content')
    <!--div class="col-md-10 col-xs-10 col-md-offset-1">
        <div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title text-center">HA TERMINADO EL PERIODO DE REGISTRO</h3>
    </div>  </div>  </div--->
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">PERIODOS PARA EVALUAR UNIDADES</h3>
                </div>
                <div class="panel-body">
                    <div class="row col-md-12">
                        <label for="" class="col-md-12 text-center">{{$nom_carrera}}</label>
                        <label for="" class="col-md-6 text-left">
                            Materia: {{ $tot_unidades->nombre }}
                            <br>
                            Grupo: {{$grupo}}
                        </label>
                        <label for="" class="col-md-6 text-right">
                            Clave: {{ $tot_unidades->clave }}
                            <br>
                            No. Unidades: {{ $tot_unidades->unidades }}
                        </label>
                    </div>
                    <br><br><br>
                    <hr style="border: 1px solid black"/>
                    <div class="row col-md-12">
                    @foreach( $array_perio as $periodo)
                            <div class="col-md-3 text-center" style="margin-bottom: 5px">
                                <div style="border: 3px solid #d9edf7;border-radius: 5px; padding: 5px">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <strong>UNIDAD {{($periodo['id_unidad']==1 ? 'I' :
                                                ($periodo['id_unidad']==2 ? 'II' :
                                                    ($periodo['id_unidad']==3 ? 'III' :
                                                        ($periodo['id_unidad']==4 ? 'IV' :
                                                            ($periodo['id_unidad']==5 ? 'V' :
                                                                ($periodo['id_unidad']==6 ? 'VI' :
                                                                    ($periodo['id_unidad']==7 ? 'VII' :
                                                                        ($periodo['id_unidad']==8 ? 'VIII' :
                                                                            ($periodo['id_unidad']==9 ? 'IX' :
                                                                                ($periodo['id_unidad']==10 ? 'X' :
                                                                                    ($periodo['id_unidad']==11 ? 'XI' :
                                                                                        ($periodo['id_unidad']==12 ? 'XII' :
                                                                                            ($periodo['id_unidad']==13 ? 'XIII' :
                                                                                                ($periodo['id_unidad']==14 ? 'XIV' :
                                                                                                    ($periodo['id_unidad']==15 ? 'XV' : ' ' )))))))))))))))}}
                                            </strong>
                                        </h5>
                                        <p class="card-text">
                                        <h5><strong>Fecha limite para cargar  calificaciones de la unidad</strong></h5>
                                        @if($periodo['status']==1)
                                            <?php  $fecha_periodo=date("d-m-Y ",strtotime($periodo['fecha'])) ?>
                                            <h6>{{$fecha_periodo }}</h6>
                                            @if($periodo['evaluada']==1)
                                                <a href="#!" class="btn btn-success tooltip-options link" data-toggle="tooltip" data-placement="top" title="Evaluación realizada"><span class="oi oi-check p-1"></span></a>
                                            @elseif($periodo['evaluada']==0)
                                                <a href="#!" class="btn btn-danger text-white tooltip-options link" data-toggle="tooltip" data-placement="top" title="Evaluación pendiente"><span class="oi oi-clock"></span></a>
                                                <!--button data-toggle="tooltip" data-placement="top" id="{{$periodo['id_unidad'] }}" title="Modificar fecha" class="btn btn btn-primary h-primary_m pl-5 pr-5 modificar"><span class="oi oi-pencil p-1"></span></button--->

                                            @endif

                                        @elseif($periodo['status']==2)
                                            <h6 class="text-danger">No asignado</h6>
                                            <button data-toggle="tooltip" data-placement="top" id="{{$periodo['id_unidad'] }}" title="Modificar fecha" class="btn btn btn-primary h-primary_m pl-5 pr-5 agregar">Asignar fecha</button>
                                            {{---     <span data-toggle="modal" data-target="#{{$periodo['id_materia']  }}modal_evaluaciones{{$periodo['id_unidad']}}"><button data-toggle="tooltip" data-placement="top" title="Modificar fecha" class="btn btn btn-primary h-primary_m pl-5 pr-5" {{ ($i!=0 && isset($uni_asignadas[$i-1]) ? 'enable' : ($i==0) ? 'enable':'disabled') }}>Asignar fecha</button></span>
                                            --}}
                                        @elseif($periodo['status']==3)
                                            <h6 class="text-danger">No asignado</h6>
                                            <button data-toggle="tooltip" data-placement="top"  title="Modificar fecha" class="btn btn btn-primary h-primary_m pl-5 pr-5" disabled>Asignar fecha</button>

                                            @endif
                                            </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div>

        </div>
    </div>
    <form id="form_periodoss" class="form" action="{{url("/docente/acciones/crear_periodos")}}" role="form" method="POST" >
    <div class="modal fade" id="modal_reg_periodo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                    {{ csrf_field() }}
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Generar Fecha de Evaluación</h4>
                    </div>
                    <div class="modal-body">
                        <div id="contenedor_mostrar_periodo">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_periodoss" type="button"  class="btn btn-primary" >Guardar</button>
                    </div>

            </div>
        </div>
    </div>
    </form>
    <div class="modal fade" id="modal_modificar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form_modificar" class="form" action="{{url("/docente/acciones/modificar_periodo")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar Fecha de Evaluación</h4>
                    </div>
                    <div id="contenedor_modificar">

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!---script type="text/javascript">

        $(document).ready( function() {
            $(".agregar").click(function (event) {
                var idof=$(this).attr('id');
                var id_materia = "<?php  echo $id_materia;?>";
                var id_grupo = "<?php  echo $id_grupo;?>";

                $.get("/docente/regperiodos/"+idof+"/"+id_materia+"/"+id_grupo,function (request) {
                    $("#contenedor_mostrar_periodo").html(request);
                    $("#modal_reg_periodo").modal('show');
                });

            });
            $(".modificar").click(function (event) {
                var idof=$(this).attr('id');
                var id_materia = "<?php  echo $id_materia;?>";
                var id_grupo = "<?php  echo $id_grupo;?>";
                var id_docente = "<?php  echo $id_docente;?>";

                $.get("/docente/acciones/modificar_periodo/"+idof+"/"+id_materia+"/"+id_grupo+"/"+id_docente,function (request) {
                    $("#contenedor_modificar").html(request);
                    $("#modal_modificar").modal('show');
                });;


            });
            $("#guardar_periodoss").click(function(event){
                var fech = $("#fecha_s").val();
                if (fech != "") {


                    $("#form_periodoss").submit();
                    $("#guardar_periodoss").attr("disabled", true);

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

            $("#modificar_periodo").click(function(event){
                $("#form_modificar").submit();
            });
            $("#form_modificar").validate({
                rules: {
                    fecha_s : "required",
                },
            });
        });
    </script--->

@endsection
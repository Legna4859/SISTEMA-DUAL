@extends('layouts.app')
@section('title', 'Techo presupuestal')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/presupuesto_anteproyecto/techo_presupuestal")}}">Registro de proyectos </a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Registrar capitulos</span>
            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h2 class="panel-title text-center"> Techo presupuestal del Anteproyecto {{ $year }}</h2>
                </div>
            </div>
        </div>
    </div>
    @if($contar_f !== 0)
        <?php setlocale(LC_MONETARY, 'es_MX');
        ?>

    @endif


    @foreach($presupuestos_anteproyectos as $presupuesto)
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-1">
                                {{--  <button type="button" class="btn btn-primary modificar_proyecto" id="{{$presupuesto['id_presupuesto'] }}" title="Modificar proyecto" > <span class="glyphicon glyphicon-cog" aria-hidden="true"></span></button>
--}}
                            </div>

                            <div class="col-md-9">
                                <h5>NOMBRE DEL PROYECTO: <b>{{ $presupuesto['nombre_proyecto'] }}</b></h5>
                            </div>
                            <div class="col-md-2">
                                 <button type="button" class="btn btn-success agregar_capitulos" id="{{$presupuesto['id_presupuesto'] }}" title="Agregar capitulos" > <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        @if($contar_f !== 0)
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th style=""></th>
                                            <th style="background:grey;color: #0c0c0c;"></th>
                                            <th style="background: grey;color: #0c0c0c;" COLSPAN="4"> FUENTE DE FINANCIAMIENTO $</th>
                                            <th style="background: grey;color: #0c0c0c;"colspan="4">FUENTE DE FINANCIAMIENTO %</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: center">EDITAR</th>
                                            <th style="background:grey;color: #0c0c0c;">CAPITULO</th>
                                            <th style="text-align: center">ESTATAL</th>
                                            <th style="text-align: center">FEDERAL</th>
                                            <th style="text-align: center">PROPIOS</th>
                                            <th style="text-align: center">TOTAL</th>
                                            <th style="text-align: center">ESTATAL</th>
                                            <th style="text-align: center">FEDERAL</th>
                                            <th style="text-align: center">PROPIOS</th>
                                            <th style="text-align: center">TOTAL</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($presupuesto['fuentes_f'] as $fuentes)

                                            <tr>
                                                <td style="text-align: right">
                                                    <button class="btn btn-primary modificar_capitulo" id="{{ $fuentes['id_fuente_financiamiento'] }}" ><i class="glyphicon glyphicon-cog em2"></i></button>

                                                </td>
                                                <td style="background: grey;color: #0c0c0c; text-align: center;">{{ $fuentes['nombre_capitulo'] }}</td>
                                                <?php
                                                $presupuesto_estatal=$fuentes['presupuesto_estatal'];
                                                $presupuesto_estatal= number_format($presupuesto_estatal, 2, '.', ',');
                                                ?>
                                                <td style="text-align: right">{{ $presupuesto_estatal }}</td>
                                                <?php
                                                $presupuesto_federal=$fuentes['presupuesto_federal'];
                                                $presupuesto_federal= number_format($presupuesto_federal, 2, '.', ',');
                                                ?>
                                                <td style="text-align: right">{{ $presupuesto_federal }}</td>
                                                <?php
                                                $presupuesto_propios=$fuentes['presupuesto_propios'];
                                                $presupuesto_propios= number_format($presupuesto_propios, 2, '.', ',');
                                                ?>
                                                <td style="text-align: right">{{ $presupuesto_propios}}</td>
                                                <?php
                                                $total_presupuesto=$fuentes['total_presupuesto'];
                                                $total_presupuesto= number_format($total_presupuesto, 2, '.', ',');
                                                ?>
                                                <td style="text-align: right">{{ $total_presupuesto }}</td>
                                                @if($fuentes['financiamiento_estatal'] == 0)
                                                    <td style="text-align: right">-</td>
                                                    @else
                                                <td style="text-align: right">{{ round($fuentes['financiamiento_estatal'],4) }}</td>
                                                @endif
                                                @if($fuentes['financiamiento_federal'] == 0)
                                                    <td style="text-align: right">-</td>
                                                @else
                                                <td style="text-align: right">{{ round($fuentes['financiamiento_federal'],4) }}</td>
                                                @endif
                                                @if($fuentes['financiamiento_propios'] == 0)
                                                    <td style="text-align: right">-</td>
                                                @else
                                                <td style="text-align: right">{{ round($fuentes['financiamiento_propios'],4) }}</td>
                                                @endif
                                                <td style="text-align: right">{{ round($fuentes['total_financiamiento'],4) }}</td>

                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <?php
                                            $total_presupuesto_estatal=$presupuesto['total_presupuesto_estatal'];
                                            $total_presupuesto_estatal= number_format($total_presupuesto_estatal, 2, '.', ',');
                                            ?>
                                            <td style="text-align: right"><b>{{ $total_presupuesto_estatal }}</b></td>
                                            <?php
                                            $total_presupuesto_federal=$presupuesto['total_presupuesto_federal'];
                                            $total_presupuesto_federal= number_format($total_presupuesto_federal, 2, '.', ',');
                                            ?>
                                            <td  style="text-align: right"><b>{{ $total_presupuesto_federal }}</b></td>
                                            <?php
                                            $total_presupuesto_propios=$presupuesto['total_presupuesto_propios'];
                                            $total_presupuesto_propios= number_format($total_presupuesto_propios, 2, '.', ',');
                                            ?>
                                            <td  style="text-align: right"><b>{{ $total_presupuesto_propios }}</b></td>
                                            <?php
                                            $total_total_presupuesto=$presupuesto['total_total_presupuesto'];
                                            $total_total_presupuesto= number_format($total_total_presupuesto, 2, '.', ',');
                                            ?>
                                            <td  style="text-align: right"><b>{{ $total_total_presupuesto }}</b></td>
                                            @if($presupuesto['total_financiamiento_estatal'] == 0)
                                                <td style="text-align: right">-</td>
                                            @else
                                            <td  style="text-align: right"><b>{{ round($presupuesto['total_financiamiento_estatal'],4) }}</b></td>
                                            @endif
                                            @if($presupuesto['total_financiamiento_federal'] == 0)
                                                <td style="text-align: right">-</td>
                                            @else
                                            <td  style="text-align: right"><b>{{ round($presupuesto['total_financiamiento_federal'],4) }}</b></td>
                                            @endif
                                            @if($presupuesto['total_financiamiento_propios'] == 0)
                                                <td style="text-align: right">-</td>
                                            @else
                                            <td  style="text-align: right"><b>{{ round($presupuesto['total_financiamiento_propios'],4) }}</b></td>
                                            @endif
                                            <td  style="text-align: right"><b>{{ $presupuesto['total_total_financiamiento'] }}</b></td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <?php
                                    $total_gastos_operativos=$presupuesto['total_gastos_operativos'] ;
                                    $total_gastos_operativos= number_format($total_gastos_operativos, 2, '.', ',');
                                    ?>
                                    <h4 style="background: yellow;color: #0c0c0c">GASTO OPERATIVO (2000, 3000, 4000, 5000 Y 6000)     <b>{{$total_gastos_operativos }}</b> </h4>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach




    {{-- modal agregar capitulo--}}

    <div class="modal fade" id="modal_agregar_capitulo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar capitulo </h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_agregar_capitulo">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_activacion_periodo"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal modificar capitulo--}}

    <div class="modal fade" id="modal_mod_capitulo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar capitulo </h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_mod_capitulo">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_mod_capitulo"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready( function() {


            $("#guardar_anteproyecto").click(function (){
                var id_proyecto = $('#id_proyecto').val();
                if(id_proyecto != null){

                    $("#form_agregar_proyecto").submit();
                    $("#guardar_anteproyecto").attr("disabled", true);

                }
                else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Seleccionar proyecto",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });

            $(".agregar_capitulos").click(function (){
                var id_presupuesto =$(this).attr('id');
                $.get("/presupuesto_anteproyecto/techo_presupuestal/agregar_fuentes_financiamiento/"+id_presupuesto,function (request) {
                    $("#contenedor_agregar_capitulo").html(request);
                    $("#modal_agregar_capitulo").modal('show');
                });

            });
            $(".modificar_capitulo").click(function (){
                var id_fuente_financiamiento =$(this).attr('id');
                $.get("/presupuesto_anteproyecto/techo_presupuestal/mod_fuentes_financiamiento/"+id_fuente_financiamiento,function (request) {
                    $("#contenedor_mod_capitulo").html(request);
                    $("#modal_mod_capitulo").modal('show');
                });
            });
            $("#guardar_activacion_periodo").click(function (){
                var id_capitulo = $('#id_capitulo').val();
                if(id_capitulo != null)
                {
                    var presupuesto_estatal = $('#presupuesto_estatal').val();
                    if( isNaN(presupuesto_estatal ) == false){
                        var presupuesto_federal = $('#presupuesto_federal').val();
                        if(isNaN(presupuesto_federal) == false){
                            var presupuesto_propios = $('#presupuesto_propios').val();
                            if(isNaN(presupuesto_propios) == false){
                                $("#form_agregar_capitulo").submit();
                                $("#guardar_activacion_periodo").attr("disabled", true);
                            }else{
                                swal({
                                    position: "top",
                                    type: "error",
                                    title: "Ingresa cantidad de fuente de financiamiento propios en número",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }

                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Ingresa cantidad de fuente de financiamiento federal en número",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }else{
                        swal({
                            position: "top",
                            type: "error",
                            title: "Ingresa cantidad de fuente de financiamiento estatal en número",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona capitulo",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_mod_capitulo").click(function (){

                var presupuesto_estatal = $('#presupuesto_estatal_mod').val();
                if( isNaN(presupuesto_estatal ) == false){
                    var presupuesto_federal = $('#presupuesto_federal_mod').val();
                    if(isNaN(presupuesto_federal) == false){
                        var presupuesto_propios = $('#presupuesto_propios_mod').val();
                        if(isNaN(presupuesto_propios) == false){
                            $("#form_modificar_capitulo").submit();
                            $("#guardar_mod_capitulo").attr("disabled", true);
                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Ingresa cantidad de fuente de financiamiento propios en número",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }

                    }else{
                        swal({
                            position: "top",
                            type: "error",
                            title: "Ingresa cantidad de fuente de financiamiento federal en número",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Ingresa cantidad de fuente de financiamiento estatal en número",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }


            });

        });
    </script>
@endsection
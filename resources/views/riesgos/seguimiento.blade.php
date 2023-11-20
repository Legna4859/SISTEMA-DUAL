@extends('layouts.app')
@section('title', 'Seguimiento')
@section('content')

    <main class="col-md-12">
        <div class="row">
            {{--<div class="col-md-10 col-xs-10 col-md-offset-1">--}}
            {{--<p>--}}
            {{--<span class="glyphicon glyphicon-arrow-right"></span>--}}
            {{--<a href="{{url("/home")}}">Home</a>--}}
            {{--<span class="glyphicon glyphicon-chevron-right"></span>--}}
            {{--<span>Registro Procesos</span>--}}
            {{--</p>--}}
            {{--<br>--}}
            {{--</div>--}}
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Seguimiento del sistema de riesgos y oportunidades</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div id="accordion" class="panel-group">
                    @foreach($unidades as $unidad)
                        <div class="panel">
                            <div class="panel-heading bg-success">
                                <a data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseunidades{{$unidad->id_unidad_admin}}"
                                   class="btn_open_panel">{{$unidad->nom_departamento}}</a>
                            </div>
                            <div id="collapseunidades{{$unidad->id_unidad_admin}}" class="panel-collapse collapse ">
                                <div class="panel-body">
                                    <div class="row">
                                        <div id="accordion2" class="panel-group">
                                            @foreach($unidad->proceso_unidad as $unidad_proceso)

                                                @if(isset($unidad_proceso->proceso[0]))
                                                    @if($unidad_proceso->proceso[0]->id_sistema!=3)
                                                <div class="panel">
                                                    <div class="panel-heading">
                                                        <a data-toggle="collapse" data-parent="#accordion2"
                                                           href="#collapse2{{$unidad_proceso->id_proceso_unidad}}"
                                                           class="btn_open_panel">{{isset($unidad_proceso->proceso[0]->des_proceso)?$unidad_proceso->proceso[0]->des_proceso:"Sin datos"}}</a>
                                                    </div>
                                                    <div id="collapse2{{$unidad_proceso->id_proceso_unidad}}"
                                                         class="panel-collapse collapse ">
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <ul class="nav nav-pills mb-3" id="pills-tab"
                                                                        role="tablist">
                                                                        <li class="nav-item">
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" id="pills-profile-tab"
                                                                               data-toggle="pill"
                                                                               href="#riesgos{{$unidad_proceso->id_proceso_unidad}}"
                                                                               role="tab" aria-controls="pills-profile"
                                                                               aria-selected="false">Riesgos</a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" id="pills-contact-tab"
                                                                               data-toggle="pill"
                                                                               href="#oportunidades{{$unidad_proceso->id_proceso_unidad}}"
                                                                               role="tab" aria-controls="pills-contact"
                                                                               aria-selected="false">Oportunidades</a>
                                                                        </li>
                                                                    </ul>


                                                                    <div class="tab-content" id="pills-tabContent">
                                                                        <div class="tab-pane fade"
                                                                             id="riesgos{{$unidad_proceso->id_proceso_unidad}}"
                                                                             role="tabpanel"
                                                                             aria-labelledby="pills-profile-tab">

                                                                            @foreach($unidad_proceso->procesoParte as $parte)
                                                                                @if($parte->id_proceso==$unidad_proceso->id_proceso)
                                                                                    @foreach ($parte->requisitos as $requisito)
                                                                                        @foreach ($requisito->riesgosunidad($unidad->id_unidad_admin) as $riesgo)
                                                                                            {{--riesgo mostrar--}}

                                                                                            <div class="panel panel-info">
                                                                                                <div class="panel-heading">
                                                                                                    <h3 class="panel-title text-center">Riesgo: {{$riesgo->des_riesgo}}</h3>
                                                                                                </div>
                                                                                            </div>
                                                                                            <table class="table">
                                                                                                <thead>
                                                                                                <tr>
                                                                                                    <th scope="col">
                                                                                                        Acciones
                                                                                                    </th>
                                                                                                    <th scope="col">
                                                                                                        Fecha
                                                                                                    </th>
                                                                                                    <th>Modificar</th>
                                                                                                </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                @foreach ($riesgo->registro_riesgo as $registro_riesgo)
                                                                                                    @foreach ($registro_riesgo->factorRiesgo as $factor_riesgo)
                                                                                                        @foreach ($factor_riesgo->riAcciones as $acciones)

                                                                                                            <tr>
                                                                                                                <td>{{$acciones->accion}}</td>
                                                                                                                <td id="date_riesgo{{$acciones->id_estrategia_a}}">{{$acciones->fecha}}</td>
                                                                                                                <td>
                                                                                                                    <a class="pull-right btn_edit_date_accion" data-toggle="modal" data-target="#modal_edit_date_accion" data-url="" data-id="{{$acciones->id_estrategia_a}}" data-value="{{$acciones->fecha}}"><span aria-hidden="true" class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Editar accion"></span></a>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        @endforeach
                                                                                                    @endforeach
                                                                                                @endforeach
                                                                                                </tbody>
                                                                                            </table>
                                                                                        @endforeach
                                                                                    @endforeach
                                                                                @endif
                                                                            @endforeach

                                                                        </div>
                                                                        <div class="tab-pane fade"
                                                                             id="oportunidades{{$unidad_proceso->id_proceso_unidad}}"
                                                                             role="tabpanel"
                                                                             aria-labelledby="pills-contact-tab">
                                                                            @foreach($unidad_proceso->procesoParte  as $parte)
                                                                                @if($parte->id_proceso==$unidad_proceso->id_proceso)
                                                                                    @foreach ($parte->requisitos as $requisito)
                                                                                        @foreach ($requisito->oportunidadesunidad($unidad->id_unidad_admin) as $oportunidad)
                                                                                            {{--riesgo mostrar--}}
                                                                                            <div class="panel panel-info">
                                                                                                <div class="panel-heading">
                                                                                                    <h3 class="panel-title text-center">Oporunidad: {{$oportunidad->des_oportunidad}}</h3>
                                                                                                </div>
                                                                                            </div>
                                                                                            <table class="table">
                                                                                                <thead>
                                                                                                <tr>
                                                                                                    <th scope="col">
                                                                                                        Acciones
                                                                                                    </th>
                                                                                                    <th scope="col">
                                                                                                        Fecha
                                                                                                    </th>
                                                                                                    <th>Modificar</th>
                                                                                                </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                @foreach ($oportunidad->ri_o_planseguimiento as $plan_seguimiento)

                                                                                                            <tr>
                                                                                                                <td>{{$plan_seguimiento->des_planseguimiento}}</td>
                                                                                                                <td id="date_oportunidad{{$plan_seguimiento->id_planseguimiento}}">{{$plan_seguimiento->fecha}}</td>
                                                                                                                <td>
                                                                                                                <a class="pull-right btn_edit_date_accion_oportunidad" data-toggle="modal" data-target="#modal_edit_date_accion" data-url="" data-id="{{$plan_seguimiento->id_planseguimiento}}" data-value="{{$plan_seguimiento->fecha}}"><span aria-hidden="true" class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Editar accion"></span></a>
                                                                                                                </td>
                                                                                                            </tr>

                                                                                                @endforeach
                                                                                                </tbody>
                                                                                            </table>
                                                                                        @endforeach
                                                                                    @endforeach
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


    </main>

@section('cont_modals_edit_dates')
    @include('riesgos.partials.edit_dates')
@show

<script type="text/javascript">
    $(document).ready(function(){
        var ban=false;
       $(".btn_edit_date_accion_oportunidad").click(function(){
           ban=false;
           $("#form_edit_date_riesgo").attr("action","{{url("riesgos/seguimiento/date_oportunidad")}}/"+$(this).data("id"));
           $("#fecha_final_edit_ri").val($(this).data("value"));
           $("#id_date_riesgo").val($(this).data("id"));
       });
        $(".btn_edit_date_accion").click(function(){
            ban=true;
            $("#form_edit_date_riesgo").attr("action","{{url("riesgos/seguimiento/date_riesgo")}}/"+$(this).data("id"));
            $("#fecha_final_edit_ri").val($(this).data("value"));
            $("#id_date_riesgo").val($(this).data("id"));
        });
       $("#update_date_riesgo").click(function(){
           $("#form_edit_date_riesgo").serialize();
           $.post($("#form_edit_date_riesgo").attr("action"), $("#form_edit_date_riesgo").serialize(),function(res){
               if(ban)
                    $("#date_riesgo"+ $("#id_date_riesgo").val()).html($("#fecha_final_edit_ri").val());
               else
                   $("#date_oportunidad"+ $("#id_date_riesgo").val()).html($("#fecha_final_edit_ri").val());

               $("#modal_edit_date_accion").modal("hide");
           })
       });

        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            language: 'es',
            autoclose: true,
            startDate: '+1d',

        });
    });
</script>
@endsection
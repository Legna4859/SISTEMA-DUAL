@extends('layouts.app')
@section('title', 'Techo presupuestal historial')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/presupuesto_anteproyecto/inicio_historial_anteproyecto")}}">Años de los historiales de los anteproyectos</a>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/presupuesto_anteproyecto/inicio_historial_anteproyecto_year/".$id_year)}}">Menú del historial del anteproyecto del presupuesto {{ $year }} </a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Ver historial del techo presupuestal del anteproyecto {{ $year }} </span>
            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h2 class="panel-title text-center">Historial del techo presupuestal del Anteproyecto {{ $year }}</h2>
                </div>
            </div>
        </div>
    </div>


    <?php setlocale(LC_MONETARY, 'es_MX');
    ?>


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

                                                <td style="background: grey;color: #0c0c0c; text-align: center;">{{ $fuentes['nombre_capitulo'] }}</td>
                                                    <?php
                                                    $presupuesto_estatal=$fuentes['presupuesto_estatal'];
                                                    $presupuesto_estatal = number_format($presupuesto_estatal, 2, '.', ',');
                                                    //  $presupuesto_estatal="$ " . number_format($presupuesto_estatal, 0, ",", ".")
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
                                                @if($fuentes['total_financiamiento'] == 0)
                                                    <td style="text-align: right">-</td>
                                                @else
                                                    <td style="text-align: right">{{ $fuentes['total_financiamiento'] }}</td>
                                                @endif

                                            </tr>
                                        @endforeach
                                        <tr>

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
                                <div class="col-md-6 col-md-offset-2">
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
    @if($contar_f !== 0)
            <?php

            $capitulo1_estatal=0;
            $capitulo1_federal=0;
            $capitulo1_propios=0;
            $total_capitulo1_total=0;
            $capitulo2_estatal=0;
            $capitulo2_federal=0;
            $capitulo2_propios=0;
            $total_capitulo2_total=0;
            $capitulo3_estatal=0;
            $capitulo3_federal=0;
            $capitulo3_propios=0;
            $total_capitulo3_total=0;
            $capitulo4_estatal=0;
            $capitulo4_federal=0;
            $capitulo4_propios=0;
            $total_capitulo4_total=0;
            $capitulo5_estatal=0;
            $capitulo5_federal=0;
            $capitulo5_propios=0;
            $total_capitulo5_total=0;
            $capitulo6_estatal=0;
            $capitulo6_federal=0;
            $capitulo6_propios=0;
            $total_capitulo6_total=0;
            $total_techo_estatal=0;
            $total_techo_federal=0;
            $total_techo_propios=0;
            $total_gasto_operativo=0;
            foreach ($presupuestos_anteproyectos as $pre){
                foreach ($pre['fuentes_f'] as $fuentes){
                    if($fuentes['id_capitulo'] == 1){
                        $capitulo1_estatal=$capitulo1_estatal+$fuentes['presupuesto_estatal'];
                        $capitulo1_federal=$capitulo1_federal+$fuentes['presupuesto_federal'];
                        $capitulo1_propios=$capitulo1_propios+$fuentes['presupuesto_propios'];
                        $total_capitulo1_total=$total_capitulo1_total+$fuentes['total_presupuesto'];
                    }
                    if($fuentes['id_capitulo'] == 2){
                        $capitulo2_estatal=$capitulo2_estatal+$fuentes['presupuesto_estatal'];
                        $capitulo2_federal=$capitulo2_federal+$fuentes['presupuesto_federal'];
                        $capitulo2_propios=$capitulo2_propios+$fuentes['presupuesto_propios'];
                        $total_capitulo2_total=$total_capitulo2_total+$fuentes['total_presupuesto'];
                    }
                    if($fuentes['id_capitulo'] == 3){
                        $capitulo3_estatal=$capitulo3_estatal+$fuentes['presupuesto_estatal'];
                        $capitulo3_federal=$capitulo3_federal+$fuentes['presupuesto_federal'];
                        $capitulo3_propios=$capitulo3_propios+$fuentes['presupuesto_propios'];
                        $total_capitulo3_total=$total_capitulo3_total+$fuentes['total_presupuesto'];
                    }
                    if($fuentes['id_capitulo'] == 4){
                        $capitulo4_estatal=$capitulo4_estatal+$fuentes['presupuesto_estatal'];
                        $capitulo4_federal=$capitulo4_federal+$fuentes['presupuesto_federal'];
                        $capitulo4_propios=$capitulo4_propios+$fuentes['presupuesto_propios'];
                        $total_capitulo4_total=$total_capitulo4_total+$fuentes['total_presupuesto'];
                    }
                    if($fuentes['id_capitulo'] == 5){
                        $capitulo5_estatal=$capitulo5_estatal+$fuentes['presupuesto_estatal'];
                        $capitulo5_federal=$capitulo5_federal+$fuentes['presupuesto_federal'];
                        $capitulo5_propios=$capitulo5_propios+$fuentes['presupuesto_propios'];
                        $total_capitulo5_total=$total_capitulo5_total+$fuentes['total_presupuesto'];
                    }
                    if($fuentes['id_capitulo'] == 6){
                        $capitulo6_estatal=$capitulo6_estatal+$fuentes['presupuesto_estatal'];
                        $capitulo6_federal=$capitulo6_federal+$fuentes['presupuesto_federal'];
                        $capitulo6_propios=$capitulo6_propios+$fuentes['presupuesto_propios'];
                        $total_capitulo6_total=$total_capitulo6_total+$fuentes['total_presupuesto'];
                    }
                }
                $total_techo_estatal=$total_techo_estatal+$pre['total_presupuesto_estatal'];
                $total_techo_federal=$total_techo_federal+$pre['total_presupuesto_federal'];
                $total_techo_propios=$total_techo_propios+$pre['total_presupuesto_propios'];

            }
            $total_presupuesto_total=$total_techo_estatal+$total_techo_federal+$total_techo_propios;
            $total_gasto_operativo=$total_capitulo2_total+$total_capitulo3_total+$total_capitulo4_total+$total_capitulo5_total+$total_capitulo6_total;
            $total_porcentaje_total_estatal=0;
            $total_porcentaje_total_federal=0;
            $total_porcentaje_total_propios=0;
            if($total_techo_estatal!= 0){
                $total_porcentaje_total_estatal=round($total_techo_estatal/$total_presupuesto_total,4);
            }
            if($total_techo_federal!= 0){
                $total_porcentaje_total_federal=round($total_techo_federal/$total_presupuesto_total,4);
            }
            if($total_techo_propios!= 0){
                $total_porcentaje_total_propios=round($total_techo_propios/$total_presupuesto_total,4);
            }
            $total_porcentaje_total=$total_porcentaje_total_estatal+$total_porcentaje_total_federal+$total_porcentaje_total_propios;
            $total_pocentaje_cap1=0;
            $total_pocentaje_cap2=0;
            $total_pocentaje_cap3=0;
            $total_pocentaje_cap4=0;
            $total_pocentaje_cap5=0;
            $total_pocentaje_cap6=0;
            if($capitulo1_estatal == 0){
                $porcentaje_cap1_estatal=0;

            }else{
                $porcentaje_cap1_estatal=round($capitulo1_estatal/$total_capitulo1_total,4);
                $total_pocentaje_cap1= round($total_pocentaje_cap1+$porcentaje_cap1_estatal,2);
            }
            if($capitulo1_federal == 0){
                $porcentaje_cap1_federal=0;
            }else{
                $porcentaje_cap1_federal=round($capitulo1_federal/$total_capitulo1_total,4);
                $total_pocentaje_cap1= round($total_pocentaje_cap1+$porcentaje_cap1_federal,2);
            }
            if($capitulo1_propios == 0){
                $porcentaje_cap1_propios=0;
            }else{
                $porcentaje_cap1_propios=round($capitulo1_propios/$total_capitulo1_total,4);
                $total_pocentaje_cap1= round($total_pocentaje_cap1+$porcentaje_cap1_propios,2);
            }
            ///2
            if($capitulo2_estatal == 0){
                $porcentaje_cap2_estatal=0;

            }else{
                $porcentaje_cap2_estatal=round($capitulo2_estatal/$total_capitulo2_total,4);

                $total_pocentaje_cap2= round($total_pocentaje_cap2+$porcentaje_cap2_estatal,2);
            }
            if($capitulo2_federal == 0){
                $porcentaje_cap2_federal=0;
            }else{
                $porcentaje_cap2_federal=round($capitulo2_federal/$total_capitulo2_total,4);
                $total_pocentaje_cap2= round($total_pocentaje_cap2+$porcentaje_cap2_federal,2);
            }
            if($capitulo2_propios == 0){
                $porcentaje_cap2_propios=0;
            }else{
                $porcentaje_cap2_propios=round($capitulo2_propios/$total_capitulo2_total,4);
                $total_pocentaje_cap2= round($total_pocentaje_cap2+$porcentaje_cap2_propios,2);
            }
            ///3
            if($capitulo3_estatal == 0){
                $porcentaje_cap3_estatal=0;
            }else{
                $porcentaje_cap3_estatal=round($capitulo3_estatal/$total_capitulo3_total,4);
                $total_pocentaje_cap3= round($total_pocentaje_cap3+$porcentaje_cap3_estatal,2);
            }
            if($capitulo3_federal == 0){
                $porcentaje_cap3_federal=0;
            }else{
                $porcentaje_cap3_federal=round($capitulo3_federal/$total_capitulo3_total,4);
                $total_pocentaje_cap3= round($total_pocentaje_cap3+$porcentaje_cap3_federal,2);
            }
            if($capitulo3_propios == 0){
                $porcentaje_cap3_propios=0;
            }else{
                $porcentaje_cap3_propios=round($capitulo3_propios/$total_capitulo3_total,4);
                $total_pocentaje_cap3= round($total_pocentaje_cap3+$porcentaje_cap3_propios,2);
            }
            ///4
            if($capitulo4_estatal == 0){
                $porcentaje_cap4_estatal=0;
            }else{
                $porcentaje_cap4_estatal=round($capitulo4_estatal/$total_capitulo4_total,4);
                $total_pocentaje_cap4= round($total_pocentaje_cap4+$porcentaje_cap4_estatal,2);
            }
            if($capitulo4_federal == 0){
                $porcentaje_cap4_federal=0;
            }else{
                $porcentaje_cap4_federal=round($capitulo4_federal/$total_capitulo4_total,4);
                $total_pocentaje_cap4= round($total_pocentaje_cap4+$porcentaje_cap4_federal,2);
            }
            if($capitulo4_propios == 0){
                $porcentaje_cap4_propios=0;
            }else{
                $porcentaje_cap4_propios=round($capitulo4_propios/$total_capitulo4_total,4);
                $total_pocentaje_cap4= round($total_pocentaje_cap4+$porcentaje_cap4_propios,2);
            }
            ///5
            if($capitulo5_estatal == 0){
                $porcentaje_cap5_estatal=0;
            }else{
                $porcentaje_cap5_estatal=round($capitulo5_estatal/$total_capitulo5_total,4);
                $total_pocentaje_cap5= round($total_pocentaje_cap5+$porcentaje_cap5_estatal,2);
            }
            if($capitulo5_federal == 0){
                $porcentaje_cap5_federal=0;
            }else{
                $porcentaje_cap5_federal=round($capitulo5_federal/$total_capitulo5_total,4);
                $total_pocentaje_cap5= round($total_pocentaje_cap5+$porcentaje_cap5_federal,2);
            }
            if($capitulo5_propios == 0){
                $porcentaje_cap5_propios=0;
            }else{
                $porcentaje_cap5_propios=round($capitulo5_propios/$total_capitulo5_total,4);
                $total_pocentaje_cap5= round($total_pocentaje_cap5+$porcentaje_cap5_propios,2);
            }
            ///6
            if($capitulo6_estatal == 0){
                $porcentaje_cap6_estatal=0;
            }else{
                $porcentaje_cap6_estatal=round($capitulo6_estatal/$total_capitulo6_total,4);
                $total_pocentaje_cap6= round($total_pocentaje_cap6+$porcentaje_cap6_estatal,2);
            }
            if($capitulo6_federal == 0){
                $porcentaje_cap6_federal=0;
            }else{
                $porcentaje_cap6_federal=round($capitulo6_federal/$total_capitulo6_total,4);
                $total_pocentaje_cap6= round($total_pocentaje_cap6+$porcentaje_cap6_federal,2);
            }
            if($capitulo6_propios == 0){
                $porcentaje_cap6_propios=0;
            }else{
                $porcentaje_cap6_propios=round($capitulo6_propios/$total_capitulo6_total,4);
                $total_pocentaje_cap6= round($total_pocentaje_cap6+$porcentaje_cap6_propios,2);
            }
            ?>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-primary">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <h2>TOTAL DE TECHO PRESUPUESTAL</h2>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>

                                        <th style="background:grey;color: #0c0c0c;"></th>
                                        <th style="background: grey;color: #0c0c0c;" COLSPAN="4"> FUENTE DE FINANCIAMIENTO $</th>
                                        <th style="background: grey;color: #0c0c0c;"colspan="4">FUENTE DE FINANCIAMIENTO %</th>
                                    </tr>
                                    <tr>

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
                                    <tr>
                                            <?php

                                            $capitulo1_estatal= number_format($capitulo1_estatal, 2, '.', ',');
                                            $capitulo1_federal=number_format($capitulo1_federal, 2, '.', ',');
                                            $capitulo1_propios=number_format($capitulo1_propios, 2, '.', ',');
                                            $total_capitulo1_total=number_format($total_capitulo1_total, 2, '.', ',');

                                            ?>
                                        <td style="wibackground:grey;color: #0c0c0c;">CAPITULO 1</td>
                                        <td style="text-align: right;">{{ $capitulo1_estatal }}</td>
                                        <td style="text-align: right;">{{ $capitulo1_federal }}</td>
                                        <td style="text-align: right;">{{ $capitulo1_propios }}</td>
                                        <td style="text-align: right;">{{ $total_capitulo1_total }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap1_estatal }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap1_federal }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap1_propios }}</td>
                                        <td style="text-align: right;">{{ $total_pocentaje_cap1 }}</td>

                                    </tr>
                                    <tr>
                                            <?php

                                            $capitulo2_estatal= number_format($capitulo2_estatal, 2, '.', ',');
                                            $capitulo2_federal=number_format($capitulo2_federal, 2, '.', ',');
                                            $capitulo2_propios=number_format($capitulo2_propios, 2, '.', ',');
                                            $total_capitulo2_total=number_format($total_capitulo2_total, 2, '.', ',');

                                            ?>
                                        <td style="background:grey;color: #0c0c0c;">CAPITULO 2</td>
                                        <td style="text-align: right;">{{ $capitulo2_estatal }}</td>
                                        <td style="text-align: right;">{{ $capitulo2_federal }}</td>
                                        <td style="text-align: right;">{{ $capitulo2_propios }}</td>
                                        <td style="text-align: right;">{{ $total_capitulo2_total }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap2_estatal }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap2_federal }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap2_propios }}</td>
                                        <td style="text-align: right;">{{ $total_pocentaje_cap2 }}</td>

                                    </tr>
                                    <tr>
                                            <?php

                                            $capitulo3_estatal= number_format($capitulo3_estatal, 2, '.', ',');
                                            $capitulo3_federal=number_format($capitulo3_federal, 2, '.', ',');
                                            $capitulo3_propios=number_format($capitulo3_propios, 2, '.', ',');
                                            $total_capitulo3_total=number_format($total_capitulo3_total, 2, '.', ',');

                                            ?>
                                        <td style="background:grey;color: #0c0c0c;">CAPITULO 3</td>
                                        <td style="text-align: right;">{{ $capitulo3_estatal }}</td>
                                        <td style="text-align: right;">{{ $capitulo3_federal }}</td>
                                        <td style="text-align: right;">{{ $capitulo3_propios }}</td>
                                        <td style="text-align: right;">{{ $total_capitulo3_total }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap3_estatal }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap3_federal }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap3_propios }}</td>
                                        <td style="text-align: right;">{{ $total_pocentaje_cap3 }}</td>

                                    </tr>
                                    <tr>
                                            <?php

                                            $capitulo4_estatal= number_format($capitulo4_estatal, 2, '.', ',');
                                            $capitulo4_federal=number_format($capitulo4_federal, 2, '.', ',');
                                            $capitulo4_propios=number_format($capitulo4_propios, 2, '.', ',');
                                            $total_capitulo4_total=number_format($total_capitulo4_total, 2, '.', ',');

                                            ?>
                                        <td style="background:grey;color: #0c0c0c;">CAPITULO 4</td>
                                        <td style="text-align: right;">{{ $capitulo4_estatal }}</td>
                                        <td style="text-align: right;">{{ $capitulo4_federal }}</td>
                                        <td style="text-align: right;">{{ $capitulo4_propios }}</td>
                                        <td style="text-align: right;">{{ $total_capitulo4_total }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap4_estatal }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap4_federal }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap4_propios }}</td>
                                        <td style="text-align: right;">{{ $total_pocentaje_cap4 }}</td>

                                    </tr>
                                    <tr>
                                            <?php

                                            $capitulo5_estatal= number_format($capitulo5_estatal, 2, '.', ',');
                                            $capitulo5_federal=number_format($capitulo5_federal, 2, '.', ',');
                                            $capitulo5_propios=number_format($capitulo5_propios, 2, '.', ',');
                                            $total_capitulo5_total=number_format($total_capitulo5_total, 2, '.', ',');

                                            ?>
                                        <td style="background:grey;color: #0c0c0c;">CAPITULO 5</td>
                                        <td style="text-align: right;">{{ $capitulo5_estatal }}</td>
                                        <td style="text-align: right;">{{ $capitulo5_federal }}</td>
                                        <td style="text-align: right;">{{ $capitulo5_propios }}</td>
                                        <td style="text-align: right;">{{ $total_capitulo5_total }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap5_estatal }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap5_federal }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap5_propios }}</td>
                                        <td style="text-align: right;">{{ $total_pocentaje_cap5 }}</td>

                                    </tr>
                                    <tr>
                                            <?php
                                            $capitulo6_estatal= number_format($capitulo6_estatal, 2, '.', ',');
                                            $capitulo6_federal=number_format($capitulo6_federal, 2, '.', ',');
                                            $capitulo6_propios=number_format($capitulo6_propios, 2, '.', ',');
                                            $total_capitulo6_total=number_format($total_capitulo6_total, 2, '.', ',');

                                            ?>
                                        <td style="background:grey;color: #0c0c0c;">CAPITULO 6</td>
                                        <td style="text-align: right;">{{ $capitulo6_estatal }}</td>
                                        <td style="text-align: right;">{{ $capitulo6_federal }}</td>
                                        <td style="text-align: right;">{{ $capitulo6_propios }}</td>
                                        <td style="text-align: right;">{{ $total_capitulo6_total }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap6_estatal }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap6_federal }}</td>
                                        <td style="text-align: right;">{{ $porcentaje_cap6_propios }}</td>
                                        <td style="text-align: right;">{{ $total_pocentaje_cap6 }}</td>
                                    </tr>
                                    <tr>
                                            <?php
                                            $total_techo_estatal= number_format($total_techo_estatal, 2, '.', ',');
                                            $total_techo_federal=number_format($total_techo_federal, 2, '.', ',');
                                            $total_techo_propios=number_format($total_techo_propios, 2, '.', ',');
                                            $total_presupuesto_total=number_format($total_presupuesto_total, 2, '.', ',');
                                            ?>
                                        <td style="background:grey;color: #0c0c0c;"></td>
                                        <td style="text-align: right;">{{ $total_techo_estatal }}</td>
                                        <td style="text-align: right;">{{ $total_techo_federal }}</td>
                                        <td style="text-align: right;">{{ $total_techo_propios }}</td>
                                        <td style="text-align: right;">{{ $total_presupuesto_total }}</td>
                                        @if($total_porcentaje_total_estatal == 0)
                                            <td style="text-align: right">-</td>
                                        @else
                                            <td style="text-align: right;">{{ $total_porcentaje_total_estatal }}</td>
                                        @endif
                                        @if($total_porcentaje_total_federal == 0)
                                            <td style="text-align: right">-</td>
                                        @else
                                            <td style="text-align: right;">{{ $total_porcentaje_total_federal }}</td>
                                        @endif
                                        @if($total_porcentaje_total_propios == 0)
                                            <td style="text-align: right">-</td>
                                        @else
                                            <td style="text-align: right;">{{ $total_porcentaje_total_propios }}</td>
                                        @endif
                                        @if($total_porcentaje_total == 0)
                                            <td style="text-align: right">-</td>
                                        @else
                                            <td style="text-align: right;">{{ $total_porcentaje_total }}</td>
                                        @endif

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-2">
                                    <?php

                                    $total_gasto_operativo= number_format($total_gasto_operativo, 2, '.', ',');
                                    ?>
                                <h4 style="background: yellow;color: #0c0c0c">GASTO OPERATIVO (2000, 3000, 4000, 5000 Y 6000)     <b>{{$total_gasto_operativo }}</b> </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <!-- Modal de agregar proyecto -->
    <div class="modal fade" id="modal_agregar_proyecto" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar proyecto</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <form id="form_agregar_proyecto" class="form" action="{{url("/presupuesto_anteproyecto/techo_presupuestal/agregar_proyecto/")}}" role="form" method="POST" >
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="dropdown">
                                            <label for="exampleInputEmail1">Selecciona proyecto</label>
                                            <select class="form-control  "placeholder="selecciona una Opcion" id="id_proyecto" name="id_proyecto" required>
                                                <option disabled selected hidden>Selecciona una opción</option>
                                                @foreach($proyectos as $proyecto)
                                                    <option value="{{$proyecto->id_proyecto}}" data-esta="{{$proyecto->nombre_proyecto }}">{{ $proyecto->nombre_proyecto }} </option>
                                                @endforeach
                                            </select>
                                            <br>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_anteproyecto"  class="btn btn-primary" >Guardar</button>
                </div>
            </div>

        </div>
    </div>
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
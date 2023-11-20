@extends('layouts.app')
@section('title', 'Estadisticas por Edad')
@section('content')
<?php  $tot_datos=0; ?>
<div class="row ">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-primary">
            <div class="panel-heading" style="text-align: center;">DATOS ESTADISTICOS DE LOS ESTUDIANTES DEL TESVB POR EDAD</div>

        </div>
    </div>
</div>
<div class="row ">
    <div class="col-md-8 col-md-offset-2">
<div class="panel panel-info" style="margin :5px 0px">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#edad_generales" style="text-decoration: none;">DATOS GENERALES</a>
        </h4>
    </div>
    <div id="edad_generales" class="panel-collapse collapse ">
        <div class="panel-body">
            <div class="col-md-6">
                <a href="/generar_excel/edades" class="btn btn-success">Exportar información <span class="oi oi-document p-1"></span></a>
                <table class="table table-hover text-center my-0 border-table">
                    <thead>
                    <tr class="text-center">
                        <th class="text-center">EDAD</th>
                        <th class="text-center">CANTIDAD</th>
                        <th class="text-center">PORCENTAJE</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php  $sum_otros_e=0; ?>
                    @foreach($edades as $edad)
                        <tr class="">
                            <td>{{ $edad['edad'] }}</td>
                            <td>{{ $edad['cantidad'] }}</td>
                            <td>{{ round( (($edad['cantidad']*100)/ $edad['tot_edad']),1 ) }}%</td>
                            <?php  $tot_datos+=$edad['cantidad']; ?>
                        </tr>
                        @if($edad['cantidad']<20)
                            <?php
                            $sum_otros_e+=$edad['cantidad'];
                            ?>
                        @else
                        @endif
                    @endforeach
                    <tr>
                        <td>TOTAL</td>
                        <td>{{$tot_datos}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6 text-center" id="container_edad"></div>
        </div>
    </div>
</div>
@foreach($carreras as$carrera)
    <div class="panel panel-info" style="margin :5px 0px">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#edad_{{ $carrera['id_carrera'] }}" style="text-decoration: none;">{{$carrera['nom_carrera']}}</a>
            </h4>
        </div>
        <div id="edad_{{ $carrera['id_carrera'] }}" class="panel-collapse collapse ">
            <div class="panel-body">
                <div class="col-md-6">
                    <table class="table table-hover text-center my-0 border-table">
                        <thead>
                        <tr class="text-center">
                            <th class="text-center">EDAD</th>
                            <th class="text-center">CANTIDAD</th>
                            <th class="text-center">PORCENTAJE</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $tot_mun=0 ?>
                        @foreach($carrera['edades'] as $edad)
                            <tr class="">
                                <td>{{ $edad['edad'] }}</td>
                                <td>{{ $edad['cantidad'] }}</td>
                                <td>{{ round((($edad['cantidad']*100)/$carrera['tot_edades']),1) }}%</td>
                                <?php $tot_mun+=$edad['cantidad'] ?>
                            </tr>
                        @endforeach
                        <tr>
                            <td>TOTAL</td>
                            <td>{{$tot_mun}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6 text-center" id="container_edad_{{ $carrera['id_carrera'] }}"></div>
            </div>
        </div>
    </div>
@endforeach
    </div>
</div>
<script language="JavaScript">
    $(document).ready(function() {

// Build the chart
        Highcharts.chart('container_edad', {
            chart: {
                width: 350,
                height: 350,
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Datos Generales'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Porcentaje',
                colorByPoint: true,
                data: [
                        @foreach($edades as $edad)
                        @if($edad['cantidad']>=20)
                    {
                        name: '{{ $edad['edad'] }}',
                        y: {{ $edad['cantidad'] }},
                    },
                        @else

                        @endif
                        @endforeach
                    {
                        name: 'OTROS',
                        y: {{ $sum_otros_e }},
                    },
                ]
            }]
        });
        @foreach($carreras as$carrera)
        Highcharts.chart('container_edad_{{ $carrera['id_carrera'] }}', {
            chart: {
                width: 350,
                height: 350,
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Datos Generales'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Porcentaje',
                colorByPoint: true,
                data: [
                        <?php  $sum_otros_edad=0; ?>
                        @foreach($carrera['edades'] as $edad)
                            @if($edad['cantidad']<20)
                            <?php
                            $sum_otros_edad+=$edad['cantidad'];
                            ?>
                            @else
                            @endif
                        @if($edad['cantidad']>=20)
                    {
                        name: '{{ $edad['edad'] }}',
                        y: {{ $edad['cantidad'] }},
                    },
                        @else

                        @endif
                        @endforeach
                    {
                        name: 'OTROS',
                        y: {{ $sum_otros_edad }},
                    },
                ]
            }]
        });
        @endforeach
    });
</script>
@endsection
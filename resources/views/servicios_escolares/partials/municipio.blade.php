@extends('layouts.app')
@section('title', 'Estadisticas por Municipio')
@section('content')
<?php  $tot_datos=0; ?>
<div class="row ">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-primary">
            <div class="panel-heading" style="text-align: center;">DATOS ESTADISTICOS DE LOS ESTUDIANTES DEL TESVB POR MUNICIPIO</div>

        </div>
    </div>
</div>
<div class="row ">
    <div class="col-md-8 col-md-offset-2">
<div class="panel panel-info" style="margin :5px 0px">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#mun_generales" style="text-decoration: none;">DATOS GENERALES</a>
        </h4>
    </div>
    <div id="mun_generales" class="panel-collapse collapse ">
        <div class="panel-body">
            <div class="col-md-6">
                <a href="/generar_excel/municipios" class="btn btn-success">Exportar información <span class="oi oi-document p-1"></span></a>
                <table class="table table-hover text-center my-0 border-table">
                    <thead>
                    <tr class="text-center">
                        <th class="text-center">MUNICIPIO</th>
                        <th class="text-center">CANTIDAD</th>
                        <th class="text-center">PORCENTAJE</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php  $sum_otros=0; ?>
                    @foreach($municipios as $municipio)
                        <tr class="">
                            <td>{{ $municipio['municipio'] }}</td>
                            <td>{{ $municipio['cantidad'] }}</td>
                            <td>{{ round((($municipio['cantidad']*100)/$municipio['total']),1) }}%</td>
                            <?php  $tot_datos+=$municipio['cantidad']; ?>
                        </tr>
                        @if($municipio['cantidad']<25)
                            <?php
                            $sum_otros+=$municipio['cantidad'];
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
            <div class="col-md-6 text-center" id="container">

            </div>
        </div>
    </div>
</div>
@foreach($carreras as$carrera)
    <div class="panel panel-info" style="margin :5px 0px">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#mun_{{ $carrera['id_carrera'] }}" style="text-decoration: none;">{{$carrera['nom_carrera']}}</a>
            </h4>
        </div>
        <div id="mun_{{ $carrera['id_carrera'] }}" class="panel-collapse collapse ">
            <div class="panel-body">
                <div class="col-md-6">
                    <table class="table table-hover text-center my-0 border-table">
                        <thead>
                        <tr class="text-center">
                            <th class="text-center">MUNICIPIO</th>
                            <th class="text-center">CANTIDAD</th>
                            <th class="text-center">PORCENTAJE</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $tot_mun=0 ?>
                        @foreach($carrera['municipios'] as $municipio)
                            <tr class="">
                                <td>{{ $municipio['municipio'] }}</td>
                                <td>{{ $municipio['cantidad'] }}</td>
                                <td>{{ round((($municipio['cantidad']*100)/ $carrera['tot_municipio']),1) }}%</td>
                                <?php $tot_mun+=$municipio['cantidad'] ?>
                            </tr>
                        @endforeach
                            <tr>
                                <td>TOTAL</td>
                                <td>{{$tot_mun}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6" id="container_mun_{{ $carrera['id_carrera'] }}">

                </div>
            </div>
        </div>
    </div>
@endforeach
    </div>
</div>
<script language="JavaScript">
    $(document).ready(function() {

// Build the chart
        Highcharts.chart('container', {
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
                    @foreach($municipios as $municipio)
                        @if($municipio['cantidad']>=25)
                        {
                            name: '{{ $municipio['municipio'] }}',
                            y: {{ $municipio['cantidad'] }},
                        },
                        @else

                        @endif
                    @endforeach
                        {
                            name: 'OTROS',
                            y: {{ $sum_otros }},
                        },
                ]
            }]
        });
        @foreach($carreras as$carrera)
        Highcharts.chart('container_mun_{{ $carrera['id_carrera'] }}', {
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
                    <?php  $sum_otros_carrera=0; ?>
                    @foreach($carrera['municipios'] as $municipio)
                        @if($municipio['cantidad']<7)
                        <?php
                        $sum_otros_carrera+=$municipio['cantidad'];
                        ?>
                        @else
                        @endif
                        @if($municipio['cantidad']>=7)
                        {
                            name: '{{ $municipio['municipio'] }}',
                            y: {{ $municipio['cantidad'] }},
                        },
                        @else

                        @endif
                    @endforeach
                    {
                        name: 'OTROS',
                        y: {{ $sum_otros_carrera }},
                    },
                ]
            }]
        });
        @endforeach
    });
</script>
@endsection
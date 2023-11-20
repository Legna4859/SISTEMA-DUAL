@extends('layouts.app')
@section('title', 'Estadisticas por Genero')
@section('content')
    <?php $totg_masc=0; $totg_fem=0; $tot_gnral=0 ?>
    @foreach($carreras as $carrera)
        <?php  $totg_masc+=$carrera['tot_masculino']; $totg_fem+=$carrera['tot_femenino']; $tot_gnral+=$carrera['tot_masculino']+$carrera['tot_femenino']?>
    @endforeach
    <div class="row ">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading" style="text-align: center;">DATOS ESTADISTICOS DE LOS ESTUDIANTES DEL TESVB POR GENERO</div>

            </div>
        </div>
    </div>
<div class="row ">
    <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-info" style="margin :5px 0px">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#ca_generales" style="text-decoration: none;">DATOS GENERALES</a>
            </h4>
        </div>
        <div id="ca_generales" class="panel-collapse collapse ">
            <div class="panel-body">
                <div class="col-md-6" style="padding-top: 5%">
                    <table class="table table-hover text-center my-0 border-table">
                        <thead>
                        <tr class="text-center">
                            <th colspan="1"></th>
                            <th class="text-center">MASCULINO</th>
                            <th class="text-center">FEMENINO</th>
                            <th class="text-center">TOTAL</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>TOTAL</td>
                            <td>{{ $totg_masc }}</td>
                            <td>{{ $totg_fem }}</td>
                            <td>{{ $tot_gnral }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="col-md-12" style="text-align: center">
                        <a href="/generar_excel/alumnos" class="btn btn-success">Exportar información <span class="oi oi-document p-1"></span></a>
                    </div>
                </div>
                <div class="col-md-4" id="container_al"></div>
            </div>
        </div>
    </div>
    @foreach($carreras as $carrera)
        <div class="panel panel-info" style="margin :5px 0px">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#ca_{{ $carrera['id_carrera'] }}" style="text-decoration: none;">{{$carrera['nom_carrera']}}</a>
                </h4>
            </div>
            <div id="ca_{{ $carrera['id_carrera'] }}" class="panel-collapse collapse ">
                <div class="panel-body">
                    <div class="col-md-6">
                        <table class="table table-hover text-center my-0 border-table">
                            <thead>
                            <tr class="text-center">
                                <th class="text-center">SEMESTRE</th>
                                <th class="text-center">MASCULINO</th>
                                <th class="text-center">FEMENINO</th>
                                <th class="text-center">TOTAL</th>
                                <th class="text-center">PORCENTAJE</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- */ $name = 'pablo'; /*--}}
                            @foreach($carrera['semestres'] as $semestre)
                                <tr class="">
                                    <td>{{ $semestre['nom_semestre'] }}</td>
                                    @foreach($semestre['datos'] as $dato)
                                        <td>{{ $dato['masculino'] }}</td>
                                        <td>{{ $dato['femenino'] }}</td>
                                        <td>{{ $dato['total'] }}</td>
                                        <td>{{ round(( $dato['total'] * 100 )  / (($carrera['tot_masculino'])+($carrera['tot_femenino'])),1) }} %</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            <tr>
                                <td>TOTAL</td>
                                <td>{{ $carrera['tot_masculino'] }}</td>
                                <td>{{ $carrera['tot_femenino'] }}</td>
                                <td>{{($carrera['tot_masculino'])+($carrera['tot_femenino'])}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6" id="content_chart_{{ $carrera['id_carrera'] }}">

                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
    <br>
</div>
    <script>
        $(document).ready(function() {

// Build the chart
            Highcharts.chart('container_al', {
                chart: {
                    width: 300,
                    height: 200,
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
                        {
                            name: 'Masculino',
                            y: {{ $totg_masc }},
                        },
                        {
                            name: 'Femenino',
                            y: {{ $totg_fem }},
                        },
                    ]
                }]
            });
            @foreach($carreras as $carrera)
            Highcharts.chart('content_chart_{{ $carrera['id_carrera'] }}', {
                chart: {
                    width: 400,
                    height: 500,
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
                            @foreach($carrera['semestres'] as $semestre)
                        {
                            name: '{{ $semestre['nom_semestre'] }}',
                            @foreach($semestre['datos'] as $dato)
                            y: {{ $dato['total'] }},
                            @endforeach
                        },
                        @endforeach
                    ]
                }]
            });
            @endforeach
        });
    </script>
@endsection
@extends('layouts.app')
@section('title', 'Residencia')
@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Estadisticas institucionales</h3>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9 col-md-offset-1">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#">Carreras</a></li>
                <li>
                    <a href="{{url('/residencia/giro_estadisticas')}}">Por giro</a>
                </li>
                <li>
                    <a href="{{url('/residencia/sector_estadisticas')}}">Por sector</a>
                </li>
                <li>
                    <a href="{{url('/residencia/empresa_institucional/')}}">Por empresa</a>
                </li>

            </ul>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-body">

                    <table id="table_enviado" class="table table-bordered table-resposive">
                        <thead>
                        <tr>
                            <th>Nombre de la carrera</th>
                            <th>Total de estudiantes</th>
                            <th>Porcentaje</th>


                        </tr>
                        </thead>
                        <tbody>
                        @foreach($array_carrera as $carrera)

                            <tr>
                                <td>{{ $carrera['carrera'] }}</td>
                                <td>{{ $carrera['total'] }}</td>
                                <td>{{ $carrera['porcentaje'] }}%</td>


                            </tr>


                        @endforeach
                        <tr>
                            <td>Total</td>
                            <td>{{$total_anteproyecto}}</td>
                            <td>100 %</td>

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-11 col-md-offset-1" id="container">

        </div>
        <br>
        <br>
    </div>
    <div class="row">

        <br>
        <br>
    </div>
    <script language="JavaScript">
        $(document).ready(function() {


            Highcharts.chart('container', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Estadisticas de estudiantes por carrera'
                },


                accessibility: {
                    announceNewData: {
                        enabled: true
                    },
                    point: {
                        valueSuffix: '%'
                    }
                },

                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}: {point.y:.2f}%'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
                },


                series: [
                    {
                        name: "Carrera",
                        colorByPoint: true,
                        data: [

                                @foreach($array_carrera as $carrera)
                            {
                                name: '{{ $carrera['carrera'] }}',
                                y: {{ $carrera['porcentaje'] }},
                                color: "{{ $carrera['color'] }}",
                            },
                                @endforeach


                            ]
                    }
                ],


            });
        });
        </script>
@endsection
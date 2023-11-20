@extends('layouts.app')
@section('title', 'Residencia')
@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Estadisticas Institucional</h3>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9 col-md-offset-1">
            <ul class="nav nav-tabs">
                <li>
                    <a href="{{url('/residencia/institucional_estadisticas')}}">Carreras</a>
                </li>
                <li>
                    <a href="{{url('/residencia/giro_estadisticas')}}">Por giro</a>
                </li>
                <li>
                    <a href="{{url('/residencia/sector_estadisticas')}}">Por sector</a>
                </li>
                <li class="active"><a href="#">Por Empresa</a></li>
            </ul>
            <br>
        </div>
    </div>



            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-body">

                            <table id="table_enviado" class="table table-bordered table-resposive">
                                <thead>
                                <tr>
                                    <th>Nombre de la empresa</th>
                                    <th>Total </th>
                                    <th>Porcentaje</th>
                                    <th>Total alumnos por carrera</th>


                                </tr>
                                </thead>
                                <tbody>
                                @foreach($array_empresa as $empresa)

                                    <tr>
                                        <td>{{ $empresa['nombre'] }}</td>
                                        <td>{{ $empresa['total'] }}</td>
                                        <td>{{ $empresa['porcentaje'] }} %</td>
                                        <td>
                                            @foreach($empresa['array_al'] as  $al)
                                               <b>Carrera: </b> {{ $al['carrera'] }}
                                                <b>Total de alumnos: </b>{{ $al['total'] }}
                                            @endforeach

                                        </td>



                                    </tr>


                                @endforeach
                                <tr>
                                    <td>Total</td>
                                    <td>{{$si}}</td>
                                    <td>100 %</td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2" id="container">

                </div>
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
                            text: 'Porcentaje de las empresas'
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
                                name: "Empresa",
                                colorByPoint: true,
                                data: [

                                        @foreach($array_empresa as $empresa)
                                    {
                                        name: '{{ $empresa['nombre'] }}',
                                        y: {{ $empresa['porcentaje'] }},



                                    },
                                    @endforeach


                                ]
                            }
                        ],


                    });
                });
            </script>


@endsection
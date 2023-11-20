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
                <li>
                    <a href="{{url('/residencia/institucional_estadisticas')}}">Carreras</a>
                </li>
                <li class="active"><a href="#">Por giro</a></li>
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
                            <th>Tipo de giro</th>
                            <th>Total </th>
                            <th>Porcentaje</th>


                        </tr>
                        </thead>
                        <tbody>
                        @foreach($array_giro as $giro)

                            <tr>
                                <td>{{ $giro['giro'] }}</td>
                                <td>{{ $giro['total'] }}</td>
                                <td>{{ $giro['porcentaje'] }}%</td>


                            </tr>


                        @endforeach
                        <tr>
                            <td>Total</td>
                            <td>{{$total_giro}}</td>
                            <td>100 %</td>

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3" id="container">

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
                    text: 'Porcentaje de tipo de giro de la empresa'
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
                        name: "Tipo de giro",
                        colorByPoint: true,
                        data: [

                                @foreach($array_giro as $giro)
                            {
                                name: '{{ $giro['giro'] }}',
                                y: {{ $giro['porcentaje'] }},
                              @if($giro['id_giro'] ==1)
                              color: "#43a1d2",
                                @elseif($giro['id_giro'] ==2)
                                color: "#50d24c",
                                @elseif($giro['id_giro'] ==3)
                                color: "#d2c747",
                                @endif


                            },
                            @endforeach


                        ]
                    }
                ],


            });
        });
    </script>
@endsection
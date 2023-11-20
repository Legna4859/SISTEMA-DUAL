@extends('layouts.app')
@section('title', 'Residencia')
@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Estadisticas por carrera</h3>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9 col-md-offset-1">
            <ul class="nav nav-tabs">
                <li>
                    <a href="{{url('/residencia/carreras_estadisticas')}}">Por giro</a>
                </li>
                <li>
                    <a href="{{url('/residencia/carrera_sector_estadisticas/')}}">Por sector</a>
                </li>
                <li class="active"><a href="#">Por empresa </a></li>

            </ul>
            <br>
        </div>
    </div>
    @if($mostrar == 0)
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="dropdown">
                    <label for="exampleInputEmail1">Elige carrrera<b style="color:red; font-size:23px;">*</b></label>
                    <select class="form-control  "placeholder="selecciona una Opcion" id="carrera" name="carrera" required>
                        <option disabled selected hidden>Selecciona una opción</option>
                        @foreach($carreras as $carrera)
                            <option value="{{$carrera->id_carrera}}" data-esta="{{$carrera->nombre}}">{{$carrera->nombre}}</option>
                        @endforeach
                    </select>
                    <br>
                </div>
            </div>
            <br>
        </div>
    @elseif($mostrar == 1)
        @if($no_hay_alumnos == 0)
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="dropdown">
                        <label for="exampleInputEmail1">Elige carrrera<b style="color:red; font-size:23px;">*</b></label>
                        <select class="form-control  "placeholder="selecciona una Opcion" id="carrera" name="carrera" required>
                            <option disabled selected hidden>Selecciona una opción</option>
                            @foreach($carreras as $carrera)
                                @if($carrera->id_carrera==$id_carrera)
                                    <option value="{{$carrera->id_carrera}}" selected="selected">{{$carrera->nombre}}</option>
                                @else
                                    <option value="{{$carrera->id_carrera}}" >{{$carrera->nombre}}</option>
                                @endif
                            @endforeach
                        </select>
                        <br>
                    </div>
                </div>
                <br>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">No tiene residentes en este periodo</h3>
                        </div>

                    </div>
                </div>
            </div>
        @elseif($no_hay_alumnos ==1)
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="dropdown">
                        <label for="exampleInputEmail1">Elige carrrera<b style="color:red; font-size:23px;">*</b></label>
                        <select class="form-control  "placeholder="selecciona una Opcion" id="carrera" name="carrera" required>
                            <option disabled selected hidden>Selecciona una opción</option>
                            @foreach($carreras as $carrera)
                                @if($carrera->id_carrera==$id_carrera)
                                    <option value="{{$carrera->id_carrera}}" selected="selected">{{$carrera->nombre}}</option>
                                @else
                                    <option value="{{$carrera->id_carrera}}" >{{$carrera->nombre}}</option>
                                @endif
                            @endforeach
                        </select>
                        <br>
                    </div>
                </div>
                <br>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-primary">
                        <div class="panel-body">

                            <table id="table_enviado" class="table table-bordered table-resposive">
                                <thead>
                                <tr>
                                    <th>Nombre de la empresa</th>
                                    <th>Total </th>
                                    <th>Porcentaje</th>


                                </tr>
                                </thead>
                                <tbody>
                                @foreach($array_empresa as $empresa)

                                    <tr>
                                        <td>{{ $empresa['nombre'] }}</td>
                                        <td>{{ $empresa['total'] }}</td>
                                        <td>{{ $empresa['porcentaje'] }} %</td>


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
        @endif
    @endif
    <script type="text/javascript">
        $(document).ready(function() {
            $("#carrera").on('change',function(e){
                var carrera= $("#carrera").val();
                window.location.href='/residencia/carrera_empresa_mostrar/'+carrera ;


            });
        });
    </script>
@endsection
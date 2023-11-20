@extends('layouts.app')
@section('title', 'Inicio')
@section('content')
    <?php
    $direccion=Session::get('ip');
    ?>
    <script>





        $(document).ready(function() {

            Highcharts.chart('mostrar_graficas', {
                chart: {
                    type: 'column',
                    width: 1000,
                    x:150,
                },
                title: {
                    text: 'Resultado Grafico:'
                },

                xAxis: {
                    type: 'category',
                    title: {
                        text: 'Aspectos evaluados'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Porcentaje'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.2f}%'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:6px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
                },

                series: [{
                    name: 'CRITERIO',
                    colorByPoint: true,
                    data:
                        [
                                @foreach($preguntas2 as $datos_pregunta)
                            {
                                @if($datos_pregunta["id_criterio"]==0)

                                        @elseif($datos_pregunta["id_criterio"]==1)
                                name: 'A',
                                @elseif($datos_pregunta["id_criterio"]==2)
                                name: 'B',
                                @elseif($datos_pregunta["id_criterio"]==3)
                                name: 'C',
                                @elseif($datos_pregunta["id_criterio"]==4)
                                name: 'D',
                                @elseif($datos_pregunta["id_criterio"]==5)
                                name: 'E',
                                @elseif($datos_pregunta["id_criterio"]==6)
                                name: 'F',
                                @elseif($datos_pregunta["id_criterio"]==7)
                                name: 'G',
                                @elseif($datos_pregunta["id_criterio"]==8)
                                name: 'H',
                                @elseif($datos_pregunta["id_criterio"]==9)
                                name: 'I',
                                @elseif($datos_pregunta["id_criterio"]==10)
                                name: 'J',
                                @endif
                                y: {{$datos_pregunta["calificacion"]}},
                                @if($datos_pregunta["calificacion"]>=0 && $datos_pregunta["calificacion"]<=3.24)
                                color: "#FF69B4",
                                @elseif($datos_pregunta["calificacion"]>=3.25 && $datos_pregunta["calificacion"]<=3.74)
                                color: "#FF69B4",
                                @elseif($datos_pregunta["calificacion"]>=3.75 && $datos_pregunta["calificacion"]<=4.24)
                                color: "#FF69B4",
                                @elseif($datos_pregunta["calificacion"]>=4.25 && $datos_pregunta["calificacion"]<=4.74)
                                color: "#FF4500",
                                @elseif($datos_pregunta["calificacion"]>=4.75 && $datos_pregunta["calificacion"]<=5)
                                color: "#4169E1",
                                @endif




                            },
                                @endforeach
                            {
                                name: 'PROMEDIO GENERAL',
                                y: {{$promedio_t}},
                                color: "#2ab27b",

                            },

                        ]
                }]


            });
            $('#imprime').click(function () {
//alert("hola");

                var opcion={
                    chart: {
                        type: 'column'
                    },

                    exporting: {
                        url: 'http://177.244.44.90:8006'
                    },


                    plotOptions:{
                        column:{
                            stacking:'normal'
                        }
                    },
                    xAxis: {
                        categories:arreglorrubross
                    },

                    yAxis:{
                        stackLabels: {
                            enabled: true,


                            format:"x",
                        },
                    },





                    plotOptions: {
                        column: {
                            stacking: 'normal',
                            dataLabels: {
                                enabled: true,
                                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                            }
                        }
                    },


                    series:seriesData_global

                };
                console.log(opcion)



            });

            $('#cerrar').click(function(){
                window.close();
            });


            $('#exportar').click(function(){


                var chart=$('#mostrar_graficas').highcharts();
                console.log(chart.getSVG());


                var direccion="177.244.44.90:8006/";
//var direccionimg="hola";
                var obj = {},
                    exportUrl = 'http://'+direccion;
                obj.type = 'image/png';
                obj.async = true;
                obj.svg=chart.getSVG();

                $.ajax({
                    type: 'post',
                    url: exportUrl,
                    data: obj,
                    success: function (data) {
                        console.log(exportUrl+data);
                        // alert(direccionimg);
                        //var imgContainer = $("#formgeneral");
                        //$('<img>').attr('src', exportUrl + data).attr('width', '250px').appendTo(imgContainer);
                        // $('<a>or Download Here</a>').attr('href', exportUrl + data).appendTo(imgContainer);
                        // $('<input type="text" class="form-control"  placeholder="" id="dir_imagen" name="dir_imagen" value="exportUrl+data">').appendTo(imgContainer);

                        var direccionimg=exportUrl+data;

                        //alert(direccionimg);
                        $("#dir_imagen").val(direccionimg);
                        $("#formgeneral").submit();

                    }

                });







            });







        });
    </script>
    <main>
        <div>
            <div class="col-md-1 ">
                <div class="col-md-11 col-md-offset-1">
                    <a id="cerrar" class="btn btn-success "><span class="glyphicon glyphicon-arrow-left"  aria-hidden="true"></span> </a>
                </div>
            </div>

            <div class="col-md-8 col-md-offset-1">

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">REPORTE EVALUACIÓN DOCENTE</h3>
                    </div>
                </div>
            </div>
        </div>
        <div id="imgContainer" >
            <div class="col-sm-4 col-md-4 " id="derecho">


                <div class="col-sm-12 col-md-12 ">
                    <div class="col-sm-7 col-md-7">

                        <a href="/reportes2/{{$id_profesor}}/{{1}}/{{0}}" class="btn btn-primary crear" ><span class="glyphicon glyphicon-list-alt"  aria-hidden="true"></span> Grafica General</a>
                    </div>
                    <div class="col-sm-5 col-md-5" >
                        <a id="exportar" class="btn btn-primary crear" target="_blank"><span class="glyphicon glyphicon-print"  aria-hidden="true"></span> Imprimir</a>

                    </div>
                </div>
                </br>
                </br>

                <div >

                    <div class="panel-group" id="accordion">
                        @foreach($carreras as$carrera)
                            <div class="panel panel-default ">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#{{ $carrera ["id_carrera"] }}"><span class="glyphicon ">
                            </span>{{$carrera["nombre_carrera"]}}</a> <a href="/reportes2/{{$id_profesor}}/{{2}}/{{$carrera["id_carrera"]}}"><span class="glyphicon glyphicon-list-alt 5em" aria-hidden="true" ></span></a></th>

                                    </h4>
                                </div>

                                <div id="{{ $carrera ["id_carrera"] }}" class="panel-collapse collapse ">
                                    <div class="panel-body">

                                        <table class="table table-bordered " Style="background: white;" id="example">
                                            <thead>
                                            <tr>
                                                <th>MATERIAS</th>
                                                <th>GRUPO</th>
                                                <th>CONSULTAR</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($carrera["materias"] as $materia)
                                                <tr>
                                                    <th>{{$materia["nombre_materia"]}}</th>
                                                    <th>{{$materia["nombre_grupo"]}}</th>
                                                    <th class="text-center"><a href="/reportes2/{{$materia["id_hrs"]}},{{$materia["nombre_materia"]}},{{$materia["nombre_grupo"]}},{{$materia["idcarrera"]}},{{$id_profesor}}/{{3}}/{{0}}"><span class="glyphicon glyphicon-list-alt 5em" style="font-size:22px;" aria-hidden="true" ></span></a></th>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-sm-8 col-md-8 ">

                <table class="table table-bordered " Style="background: white;" id="aceptados">


                    <tr>
                        <th class="col-md-3">DOCENTE:</th>
                        <th class="col-md-2">PROMEDIO GENERAL</th>
                        <th class="col-md-1">DESCRIPCIÓN</th>
                    </tr>
                    </tr>


                    <tr>
                        <td scope="col"> {{$profesor}}</td>
                        <td style="text-align:center;" scope="col">{{$promedio_t}}</td>
                        @if($promedio_t>=0 &&$promedio_t<=3.24)
                            <td style="text-align:center;">DESEMPEÑO INSUFICIENTE</td>
                        @elseif($promedio_t>=3.25 && $promedio_t<=3.74)
                            <td style="text-align:center;">SUFICIENTE</td>
                        @elseif($promedio_t>=3.75 && $promedio_t<=4.24)
                            <td style="text-align:center;">BUENO</td>
                        @elseif($promedio_t>=4.25 && $promedio_t<=4.74)
                            <td style="text-align:center;">NOTABLE</td>
                        @elseif($promedio_t>=4.75 && $promedio_t<=5)
                            <td style="text-align:center;">EXCELENTE</td>
                        @endif
                    </tr>


                </table>

                <div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>MATERIA</th>
                            <th>
                                ALUMNOS INSCRITOS</th>
                            <th>ALUMNOS EVALUARON</th>
                            <th>PROMEDIO</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mat_evaluacion as$por)
                            <tr>
                                <td >{{$por['materia']}}</td>
                                <td style="text-align:center;">{{$por['total']}}</td>
                                <td style="text-align:center;">{{$por['total_si']}}</td>
                                <td style="text-align:center;">{{$por['promedio']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            </br>

        </div>

        <div class="col-md-12">


        </div>
        <!--<input id="exportar" type="button">-->

        <div class="col-md-3 " >
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Aspectos evaluados</th>
                    <th>Puntuaje</th>
                    <th>Calificación</th>
                </tr>
                </thead>
                <tbody>
                @foreach($preguntas2 as $datos_pregunta)
                    <tr>
                        @if($datos_pregunta["id_criterio"]==0)

                        @elseif($datos_pregunta["id_criterio"]==1)
                            <td style="text-align:center;">A</td>
                        @elseif($datos_pregunta["id_criterio"]==2)
                            <td style="text-align:center;">B</td>
                        @elseif($datos_pregunta["id_criterio"]==3)
                            <td style="text-align:center;">C</td>
                        @elseif($datos_pregunta["id_criterio"]==4)
                            <td style="text-align:center;">D</td>
                        @elseif($datos_pregunta["id_criterio"]==5)
                            <td style="text-align:center;">E</td>
                        @elseif($datos_pregunta["id_criterio"]==6)
                            <td style="text-align:center;">F</td>
                        @elseif($datos_pregunta["id_criterio"]==7)
                            <td style="text-align:center;">G</td>
                        @elseif($datos_pregunta["id_criterio"]==8)
                            <td style="text-align:center;">H</td>
                        @elseif($datos_pregunta["id_criterio"]==9)
                            <td style="text-align:center;">I</td>
                        @elseif($datos_pregunta["id_criterio"]==10)
                            <td style="text-align:center;">J</td>
                        @endif
                        <td style="text-align:center;">{{ $datos_pregunta["calificacion"] }}</td>
                        @if($datos_pregunta["calificacion"]>=0 && $datos_pregunta["calificacion"]<=3.24)
                            <td style="text-align:center;">DESEMPEÑO INSUFICIENTE</td>
                        @elseif($datos_pregunta["calificacion"]>=3.25 && $datos_pregunta["calificacion"]<=3.74)
                            <td style="text-align:center;">SUFICIENTE</td>
                        @elseif($datos_pregunta["calificacion"]>=3.75 && $datos_pregunta["calificacion"]<=4.24)
                            <td style="text-align:center;">BUENO</td>
                        @elseif($datos_pregunta["calificacion"]>=4.25 && $datos_pregunta["calificacion"]<=4.74)
                            <td style="text-align:center;">NOTABLE</td>
                        @elseif($datos_pregunta["calificacion"]>=4.75 && $datos_pregunta["calificacion"]<=5)
                            <td style="text-align:center;">EXCELENTE</td>
                        @endif


                    </tr>

                @endforeach
                <tr>
                    <td style="text-align:center;">TOTAL</td>
                    <td style="text-align:center;">{{$promedio_t}}</td>

                    @if($promedio_t>=0 &&$promedio_t<=3.24)
                        <td style="text-align:center;">DESEMPEÑO INSUFICIENTE</td>
                    @elseif($promedio_t>=3.25 && $promedio_t<=3.74)
                        <td style="text-align:center;">SUFICIENTE</td>
                    @elseif($promedio_t>=3.75 && $promedio_t<=4.24)
                        <td style="text-align:center;">BUENO</td>
                    @elseif($promedio_t>=4.25 && $promedio_t<=4.74)
                        <td style="text-align:center;">NOTABLE</td>
                    @elseif($promedio_t>=4.75 && $promedio_t<=5)
                        <td style="text-align:center;">EXCELENTE</td>
                    @endif
                </tr>

                </tbody>
            </table>

        </div>
        <div id="mostrar_graficas" class="col-sm-10 col-md-6"  >


        </div>

        <div clas="rows">


            <div class="col-md-10 col-md-offset-1" >
                </br></br></br>
                <table class="table table-bordered " Style="background: white;" id="aceptados">


                    <tr>
                        <th class="col-md-2">Criterio</th>
                        <th class="col-md-4">Pregunta</th>
                        <th class="col-md-1">Calificacion</th>
                        <th class="col-md-5">Observacion</th>
                    </tr>
                    @foreach($preguntas2 as $pre)
                        <tr>
                            <th scope="rowgroup" rowspan="{{$pre['cantidad']}}">
                                <div style="text-align:center;">{{$pre["nombre_criterio"]}}</div>
                                </br>  </br>
                                <div style="text-align:center;">{{$pre["calificacion"]}}</div>
                                </br>
                                <div style="text-align:center;">
                                    @if($pre["calificacion"]>=0 && $pre["calificacion"]<=3.24)
                                        DESEMPEÑO INSUFICIENTE
                                    @elseif($pre["calificacion"]>=3.25 && $pre["calificacion"]<=3.74)
                                        SUFICIENTE
                                    @elseif($pre["calificacion"]>=3.75 && $pre["calificacion"]<=4.24)
                                        BUENO
                                    @elseif($pre["calificacion"]>=4.25 && $datos_pregunta["calificacion"]<=4.74)
                                        NOTABLE
                                    @elseif($pre["calificacion"]>=4.75 && $pre["calificacion"]<=5)
                                        EXCELENTE
                                    @endif
                                </div>


                        </tr>

                        @foreach($pre["preguntas"] as $preg)
                            <tr>
                                <td scope="col">{{$preg['pregunta']}}</td>
                                <td style="text-align:center;" scope="col">{{$preg['calificacion']}}</td>
                                <td scope="col">{{$preg['observacion']}}</td>
                            </tr>


                        @endforeach


                    @endforeach
                </table>


            </div>
        </div>

        <form class="form" role="form" method="POST" id="formgeneral" action="/imprime_grafica"  style="display:none;">
            <!-- Tab panes -->

            {{ csrf_field()}}

            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="uno">



                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                        <label for="exampleInputEmail1">Curp<b style="color:red; font-size:23px;">*</b></label>
                        <input type="text" class="form-control"  placeholder="" id="dir_imagen" name="dir_imagen" value="">
                        <input type="text" class="form-control"  placeholder="" id="hrs_prof" name="id_hrs" value="{{$g_id_hrs}}" >
                        <input type="text" class="form-control"  placeholder="" id="condi" name="condi" value="{{$condi}}" >
                        <input type="text" class="form-control"  placeholder="" id="carrera" name="carrera" value="{{$g_carrera}}">
                        <input type="text" class="form-control"  placeholder="" id="id_profesor" name="id_profesor" value="{{$id_profesor}}">


                    </div>

                </div>
            </div>
        </form>

    </main>



@endsection


@extends('tutorias.app_tutorias')
@section('content')
    <script>
        $(document).ready(function()
        {
            Highcharts.chart('ver_grafica', {
                chart: {
                    type: 'column',
                    width: 1000,
                    x:1000,
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
                    headerFormat: '<span style="font-size:3px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
                },

                series: [{
                    name: 'CRITERIO',
                    colorByPoint: true,
                    data:
                        [
                                @foreach ($datos as $dato)
                            {
                                name: 'A',
                                y: {{$dato->gestion }},
                            },
                                @endforeach
                                @foreach ($datos as $dato)
                            {
                                name: 'B',
                                y: {{$dato->actitud }},
                            },
                                @endforeach
                                @foreach ($datos as $dato)
                            {
                                name: 'C',
                                y: {{$dato->disponibilidad_confianza}},
                            },
                                @endforeach
                                @foreach ($datos as $dato)
                            {
                                name: 'D',
                                y: {{$dato->servicios_del_programa_de_tutoria}},
                            },
                                @endforeach
                                @foreach ($datos as $dato)
                            {
                                name: 'E',
                                y: {{$dato->tus_logros_y_avances}},
                            },
                            @endforeach
                        ]
                }]

            });
            $('#exportar').click(function()
            {


                var chart=$('#ver_grafica').highcharts();
                console.log(chart.getSVG());


                var direccion="177.244.44.90:8006/";
                //var direccionimg="hola";
                var obj = {},
                    exportUrl = 'http://'+direccion;
                obj.type = 'image/png';
                obj.async = true;
                obj.svg=chart.getSVG();

                $.ajax
                ({
                    type: 'post',
                    url: exportUrl,
                    data: obj,
                    success: function (data)
                    {
                        console.log(exportUrl+data);
                        // alert(direccionimg);
                        //var imgContainer = $("#formgeneral");
                        //$('<img>').attr('src', exportUrl + data).attr('width', '250px').appendTo(imgContainer);
                        // $('<a>or Download Here</a>').attr('href', exportUrl + data).appendTo(imgContainer);
                        // $('<input type="text" class="form-control"  placeholder="" id="dir_imagen" name="dir_imagen" value="exportUrl+data">').appendTo(imgContainer);

                        var direccionimg=exportUrl+data;


                        $("#dir_imagen").val(direccionimg);
                        $("#formgeneral").submit();

                    }
                });
            });
        });
    </script>


    <div class="row">
        <div class="col-10 offset-1">
            <div class="card bg-info text-white text-center">
                <h4 >Carrera: {{ $datos[0]->carrera }}</h4>
                <h4 >Tutor: {{ $datos[0]->nombre_tutor }}</h4>
                <h4 >Semestre: {{ $datos[0]->grupo }}</h4>
            </div>

        </div>
    </div>
    <div class="row">
        <p></p>
    </div>

    <div class="row">
        <div class="col-2 offset-9">
            <a id="exportar" class="btn btn-primary crear" target="_blank"><span class="glyphicon glyphicon-print"  aria-hidden="true"></span> Imprimir</a>

        </div>
    </div>
    <div class="row">
        <p></p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="ver_grafica">

            </div>
        </div>
    </div>

    <div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Aspectos Evaluados</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>A</th>
                <td>Percepción respecto a tu tutor(a) en la Gestión</td>
            </tr>
            <tr>
                <td>B</td>
                <td>Percepción respecto a tu tutor(a) en la Actitud</td>
            </tr>
            <tr>
                <th>C</th>
                <td>Percepción respecto a tu tutor(a) en la disponibilidad y confianza</td>
            </tr>
            <tr>
                <td>D</td>
                <td>Percepción respecto a los servicios del programa de Tutoría</td>
            </tr>
            <tr>
                <th>E</th>
                <td>Percepción respecto a tus logros y avances</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div style="display: none">
        <form class="form" roles="form" action="/tutorias/evaluacion_tutor/imprime_grafica" method="post" id="formgeneral" >
            {{ csrf_field() }}
            <div class="form-group">
                <input type="text" id="id_asigna_tutor" name="id_asigna_tutor" value="{{$datos[0]->id_asigna_tutor}}" class="form-control">
                <input type="text" id="dir_imagen" name="dir_imagen" value="" class="form-control">
            </div>
        </form>
    </div>
@endsection

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
                                y: {{$dato->satisfacion }},
                            },
                                @endforeach
                                @foreach ($datos as $dato)
                            {
                                name: 'B',
                                y: {{$dato->necesidades }},
                            },
                                @endforeach
                                @foreach ($datos as $dato)
                            {
                                name: 'C',
                                y: {{$dato->factores}},
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
                <h4 >Autoevaluación</h4>
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
    <div>
    <div class="row">
        <p><center><strong>Cuestionario al tutor</strong></center></p>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Pregunta</th>
                <th></th>
                <th><label align="right" class="text-right">Resultado</label></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($preguntas as $pregunta)
            <tr>
                <th scope="row"><label><strong>{{$pregunta->id_eva_cuestionario}}</strong></label></th>
                <td colspan="2"><label>{{$pregunta->descripcion}}</label></td>
                <td><label>{{$pregunta->cal}}</label></td>
            </tr>
            @endforeach
            @foreach ($datos as $dato)
                <tr>
                    <td>Comentario: </td>
                    <td>{{$dato->comentario}}</td>
                </tr>
            @endforeach   
        </tbody>
    </table>
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
                <td>Satisfacción de su desempeño como tutor</td>
            </tr>
            <tr>
                <td>B</td>
                <td>Necesidades de formación</td>
            </tr>
            <tr>
                <th>C</th>
                <td>Factores que afectan mi desempeño como tutor</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div style="display: none">
        <form class="form" roles="form" action="/tutorias/cuestionario_tutor/imprime_grafica" method="post" id="formgeneral" >
            {{ csrf_field() }}
            <div class="form-group">
                <input type="text" id="id_asigna_tutor" name="id_asigna_tutor" value="{{$datos[0]->id_asigna_tutor}}" class="form-control">
                <input type="text" id="dir_imagen" name="dir_imagen" value="" class="form-control">
            </div>
        </form>
    </div>



@endsection
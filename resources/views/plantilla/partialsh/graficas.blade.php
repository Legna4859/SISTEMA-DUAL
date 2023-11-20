
<div id="div_grafica">

</div>

<script>

  $(document).ready(function() {
    var arreglo_periodos=[];
    var arreglo_actividades=[];

    var arreglo_clase={!!$arregloclase!!};
    var arreglo_extra={!!$arregloextra!!};
    var arreglo_totales={!!$arreglototal!!};

@foreach($periodos as $periodo)
    arreglo_periodos[arreglo_periodos.length]="{{$periodo->periodo}}";
@endforeach

@foreach($act_extras as $extras)
    arreglo_actividades[arreglo_actividades.length]="{{$extras->descripcion}}";
@endforeach

    Highcharts.chart('div_grafica', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Historial de hrs del docente: {{ $nombre }}'
        },
        xAxis: {
            categories: arreglo_periodos
        },
        yAxis: {
            min: 0,
            allowDecimals: false,
            title: {
                text: 'Total de Horas'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
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
        series: [{
            name: 'Hrs.Extra Clase',
            data: arreglo_extra
        }, {
            name: 'Hrs. Clase',
            data: arreglo_clase
        }]
    });

});

</script>


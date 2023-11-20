@extends('layouts.app')
@section('title', 'Historicos')
@section('content')

<main class="col-md-12">
    <form>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">Datos Históricos</div>
                    </div>
                    </br></br>
                    <div lass="col-md-6" id="grafica">
    
                    </div>
            </div>
        </div>
        <div class="boton col-md-10 col-md-offset-5 regis">
            <a href="{{url("/generar_excel")}}" class="btn btn-primary" target="_blank"><span class="glyphicon glyphicon-export em"  aria-hidden="true"></span>Exportar</a>
  </div>
</form>

</main>
<script>
 $(document).ready(function(){

  var arreglo_carreras=[];
  var arreF=[];
  var arreM=[];
  var ciclos="{{$numero_carreras}}";

 var mujeres={!!$arregloF!!};
 var hombres={!!$arregloM!!};

  @foreach($carreras as $carreras)
  
    arreglo_carreras[arreglo_carreras.length]="{{$carreras->nombre}}";
  @endforeach

  $(function () {
    Highcharts.setOptions({
    colors: ['#0D4092','#97087D']
});
    Highcharts.chart('grafica', {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: arreglo_carreras
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total de Alumnos por Carrera'
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
            name: 'Masculino',
            data:hombres
        }, {
            name: 'Femenino',
            data:mujeres
        }
        ]
    });
});
});
</script>
@endsection
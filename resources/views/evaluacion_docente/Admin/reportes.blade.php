@extends('layouts.app')
@section('title', 'Inicio')
@section('content')

<script type="text/javascript">


  ///prueba cambios
	var opcion;
 var arreglorrubross;
 var seriesData_global;
 var yAxis;
 var ponderacion_general;
 var valores=[];

 var data2;

valores[0]=1;
valores[1]=2;
valores[2]=3;
valores[3]=4;
valores[4]=5;
valores[5]=6;
valores[6]=7;
valores[7]=8;
valores[8]=9;
valores[9]=10;
/////////////////////////////////////////////////////////////////////////GRAFICA GENERAL
    @if (isset($grafica1)||isset($grafica3))
      var titulografica="{{$grafica_condicion}}";
       var rubros="";
       var puntos="";
      var cadena;
       var arreglorubros=[];
       var arreglopuntos=[];
       //var series=[];    
      // console.log(promedios);
''
      @foreach($rubros as $rubro)
       
        rubros+="'{{$rubro->rubros}}',";
        arreglorubros[arreglorubros.length]="{{$rubro->rubros}}";

      @endforeach
 arreglorrubross=arreglorubros;
  
   // cadena='{!!$cadena!!}';
  //alert(cadena);

       $(function () {

var seriesData={!!$cadena!!};
seriesData_global=seriesData;
//console.log(seriesData);

var ponderacion = ["0","No Suficiente","1","Suficiente","2","Bien","3","Muy Bien","4", "Excelente","5"];
ponderacion_general=ponderacion;

Highcharts.chart('mostrar_graficas', {
        chart: {
            type: 'column'
        },
        exporting:{url:'/img'},
        title: {
            text:titulografica
        },
        xAxis: {
            categories:arreglorubros
        },
        yAxis: {
            min: 0,



               max:seriesData.length*5,
            tickInterval: seriesData.length/2,
             labels: {
                 formatter: function() {
                 //console.log(this.value/seriesData.length);
                return( ponderacion[this.value/seriesData.length*2]);
                }
            },



            title: {
                text: 'Total fruit consumption'
            },
            stackLabels: {
                enabled: true,


                  formatter: function() {
                        
                        return (this.total/ seriesData.length).toPrecision(3) ;
                          
                    },





                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'center',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: false,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
           
            formatter:function(){
              //  console.log(this.series)
                  return('<b>'+this.x+'</b><br/>'+this.series.name+': '+((this.y).toPrecision(3))+'<br>Promedio: '+(this.total/seriesData.length).toPrecision(3))
                }
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
        series: seriesData

    },function(data){

      console.log(data);
    });

 

      
     
            
  

opcion= {
        chart: {
            type: 'column'
        },
        exporting:{url:'/img'},
        title: {
            text:titulografica
        },
        xAxis: {
            categories:arreglorubros


        },
        yAxis: {
            min: 0,

//console.log(data.series);

               max:seriesData.length*5,
            tickInterval: seriesData.length/2,
             labels: {
                 formatter: function() {
                 //console.log(this.value/seriesData.length);
                return( ponderacion[this.value/seriesData.length*2]);
                }
            },







            title: {
                text: 'Total fruit consumption'
            },
            stackLabels: {
                enabled: true,


                  formatter: function() {
                        
                        return (this.total/ seriesData.length).toPrecision(3) ;
                       
                    },





                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'center',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: false,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
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
        }



});
    @endif





    //////////////////////////////////////////////////////////////////POR MATERIAS


    @if (isset($grafica2))
    


       var rubros="";
       var puntos="";

       var arreglorubros=[];
       var seriesData=[];
      var materia="";
       materia+="{{$grafica_condicion}}"
//alert(materia);
      @foreach($rubros as $rubro)
       
        rubros+="'{{$rubro->rubros}}',";
        arreglorubros[arreglorubros.length]="{{$rubro->rubros}}";

      @endforeach
        @foreach($arreglofinal as $arreglofin)
       // console.log("{{$arreglofin}}");
         seriesData[seriesData.length]=({{$arreglofin}});


      @endforeach
//alert(seriesData.length);

      $(function () {


      var ponderacion = ["0","No Suficiente","1","Suficiente","2","Bien","3","Muy Bien","4", "Excelente","5"];
    Highcharts.chart('mostrar_graficas', {
        chart: {
            type: 'column'
        },
        title: {
            text:materia
        },
        xAxis: {
            categories:arreglorubros
        },
        yAxis: {
            min: 0,

             max:seriesData.length*5,
            tickInterval: seriesData.length/2,
             labels: {
                 formatter: function() {
                 console.log(this.value/seriesData.length);
                return(ponderacion[this.value/seriesData.length*2]);
                }
            },





            title: {
                text: 'Total fruit consumption'
            },
            stackLabels: {
                enabled: true,
                formatter: function() {
                        
                        return (this.total) ;
                            
                    },
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
           
            formatter:function(){
              //  console.log(this.series)
                  return('<b>'+this.x+'</b><br/>'+this.series.name+': '+((this.y).toPrecision(3))+'<br>Promedio: '+(this.total).toPrecision(3))
                }
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
           name: 'Criterio',
            data:seriesData
        }]
    });
});
//alert(arreglorubros);

    @endif





$(document).ready(function() {

$('#imprime').click(function () {


var opcion={
     chart: {
            type: 'column'
        },

    exporting: {
        url: 'http://localhost'
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




$('#exportar').click(function(){


  var chart=$('#mostrar_graficas').highcharts();
  console.log(chart.getSVG());




    var obj = {},
    exportUrl = 'http://export.highcharts.com/';
    obj.type = 'image/png';
    obj.async = true;
    obj.svg=chart.getSVG();

    $.ajax({
        type: 'post',
        url: exportUrl,
        data: obj,
        success: function (data) {
          console.log(exportUrl+data);
         // alert('ok');
            var imgContainer = $("#imgContainer");
            $('<img>').attr('src', exportUrl + data).attr('width', '250px').appendTo(imgContainer);
            $('<a>or Download Here</a>').attr('href', exportUrl + data).appendTo(imgContainer);

        }
    });


});
  /////////////////////////////////////////////////////////////////



} );



</script>



<main>

<button id="export">get image</button>
<div id="imgContainer"></div>

<div class="col-md-12">
 
        <div class="col-sm-4 col-md-4" >
          <div><div class="col-sm-6 col-md-6"><button><a href="/reportes/{{$solo_id_profesor}}">GRAFICA GENERAL<span class="glyphicon glyphicon-list-alt 5em" aria-hidden="true" ></span></a></button></div>
            <div class="col-sm-6 col-md-6"><button><a href="#" id="imprime">Imprimir<span class="glyphicon glyphicon-list-alt 5em" aria-hidden="true" ></span></a></button></div>
           </div>
          
            </br> </br> 
            <div class="panel-group" id="accordion">
              @foreach($carreras as$carrera) 
              <div class="panel panel-default ">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#{{ $carrera ["id_carrera"] }}"><span class="glyphicon ">
                            </span>{{$carrera["nombre_carrera"]}}</a> <a href="/promedio_carrera/{{$carrera["id_carrera"]}},{{$solo_id_profesor}}"><span class="glyphicon glyphicon-list-alt 5em" aria-hidden="true" ></span></a></th>
                                                  
                        </h4>
                    </div>

                    <div id="{{ $carrera ["id_carrera"] }}" class="panel-collapse collapse ">
                        <div class="panel-body">

                            <table class="table table-bordered " Style="background: white;" id="example">
                                   <thead>
                                          <tr>
                                                  <th>Materias</th>
                                                  <th>GRUPO</th>
                                                  <th>CONSULTAR</th>                                               
                                           </tr>
                                    </thead>
                                    <tbody>
                                             @foreach($carrera["materias"] as $materia)
                                          <tr>
                                                  <th>{{$materia["nombre_materia"]}}</th>
                                                  <th>{{$materia["nombre_grupo"]}}</th>
                                                  <th><a href="/promedio/{{$materia["id_hrs"]}},{{$solo_id_profesor}},{{$materia["nombre_materia"]}},{{$materia["nombre_grupo"]}},{{$materia["idcarrera"]}}"><span class="glyphicon glyphicon-list-alt 5em" aria-hidden="true" ></span></a></th>
                                                  
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

            <input id="exportar" type="button">
          <div id="mostrar_graficas" class="col-sm-7 col-md-7" >
            

          </div>
         
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
          <div style="text-align:center;">{{$pre["observacioncri"]}}</div>
          
          
    </tr>

     @foreach($pre["preguntas"] as $preg)
     <tr>
        <td scope="col">{{$preg['pregunta']}}</td>
        <td scope="col">{{$preg['calificacion']}}</td>
        <td scope="col">{{$preg['observacion']}}</td>
    </tr>

          
     @endforeach
 
   
@endforeach
 </table>


</div>
</div>
</main>	



@endsection
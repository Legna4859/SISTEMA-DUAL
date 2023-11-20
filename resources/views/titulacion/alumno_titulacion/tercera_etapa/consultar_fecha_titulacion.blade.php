@extends('layouts.app')
@section('title', 'Titulación')
@section('content')

    <main class="col-md-12">


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h1 class="panel-title text-center">Enviar registro de jurado y fecha de titulación</h1>
                    </div>
                </div>
            </div>
        </div>

        @if($estado == 0)
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="row">
                                <h3 style="text-align: center">Consultar semana para titularme</h3>
                            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-1">
                    <div class="form-group">
                        <label for="deparamento">Selecciona fecha inicial</label>
                        <div class='input-group date' data-date-format="dd/mm/yyyy" id='fecha_inicial' >
                            <input type='text' id="fecha_inicial1" class="form-control" required />
                            <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar">
                                     </span>
                                    </span>
                        </div>

                    </div>

                </div>
                <div class="col-md-3">

                    <div id="siguiente" class="form-group"></div>
                </div>
                <div class="col-md-3">

                    <div id="boton" ></div>
                </div>
            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($estado == 1)


        @endif



    </main>

    <script type="text/javascript">
        $(document).ready( function() {
            $('#fecha_inicial').datepicker({
                daysOfWeekDisabled: [0,2,3,4,5,6],
                autoclose: true,
                language: 'es',
                startDate: '-8d',
            });
            $("#fecha_inicial").change(function(e){

                var fecha_inicial= e.target.value;
                var dias = 4;
                var dia=fecha_inicial.substring(0,2);
                var mes=fecha_inicial.substring(3,5);
                var year=fecha_inicial.substring(6,10);

                var nueva_fecha=year+'/'+mes+'/'+dia;
                var TuFecha = new Date(nueva_fecha);

                TuFecha.setDate(TuFecha.getDate() + dias);
                //formato de salida para la fecha
                var  resultado = TuFecha.getFullYear() + '/' +
                    (TuFecha.getMonth() + 1) + '/' + TuFecha.getDate();
                var dia1=resultado.substring(8,10);
                var mes2=resultado.substring(5,7);
                var year2=resultado.substring(0,4);

                var nueva_fecha_final =dia1+'/'+mes2+'/'+year2;


                $('#siguiente').empty();
                $('#siguiente').append('<label for="fecha final">Fecha final</label>' +
                    '<input class="form-control" id="fecha_final" value="'+nueva_fecha_final+'" readonly/>' );
                $('#boton').empty();
                $('#boton').append('<label for="fecha final"><br></label><br>' +
                    ' <button  id="ver_consulta_fecha" class="btn btn-info">Consutar</button>');

            });
            $("#boton").on('click','#ver_consulta_fecha',function(event) {
                var fecha_i=$("#fecha_inicial1").val();
                var fecha_f=$("#fecha_final").val();
                var fecha_inicial = fecha_i.split("/").reverse().join("-");
                var fecha_final = fecha_f.split("/").reverse().join("-");

                window.location.href='/titulacion/consultar_fechas_titulacion/'+fecha_inicial+'/'+fecha_final ;

            });
        });


    </script>

    <style>
        .mostrar{
            display: list-item;
            opacity: 1;
            background: rgba(44,38,75,0.849);
        }
    </style>

@endsection
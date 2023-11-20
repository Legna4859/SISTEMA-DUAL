@extends('layouts.app')
@section('title', 'Personal en Plantilla')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Consultar Laboratorios</h3>
                    </div>
                </div>
            </div>
        </div>

        {{ csrf_field() }}
        <div class="row">

            <div class="col-md-3 col-md-offset-1">
                <div class="form-group">
                    <div class="dropdown">
                        <label for="laboratorio">Laboratorios del Centro de Computo</label>
                        <select name="laboratorio" id="laboratorio" class="form-control " >
                            <option  disabled selected hidden>Selecciona Laboratorio</option>
                            @foreach($laboratorios as $laboratorio)

                                <option value="{{$laboratorio->id_laboratorio}}" >{{$laboratorio->descripcion}}</option>

                            @endforeach
                        </select>
                        <br>
                    </div>
                </div>

            </div>
            <div id="mostrar" style="display:none;">
                <div class="col-md-3 ">

                    <div class="form-group">
                        <label for="deparamento">Selecciona fecha Inicial</label>
                        <div class='input-group date' data-date-format="yyyy/mm/dd" id='datetimepicker11' >
                            <input type='text' id="fecha_inicial" class="form-control" required />
                            <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar">
                                     </span>
                                    </span>
                        </div>

                    </div>

                    <script type="text/javascript">
                        $(function () {
                            $('#datetimepicker11').datepicker({
                                daysOfWeekDisabled: [0,2,3,4,5,6],
                                autoclose: true,
                                language: 'es'
                            });
                        });

                    </script>
                </div>
                <div class="col-md-2">
                    <label for="fecha final">Fecha final</label>
                    <div id="soli" class="form-group"></div>
                </div>
            </div>
        </div>
        </div>

        <br>
        <br>

        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <button id="guardar_solicitud" class="btn btn-info">Mostrar</button>
                <br>
                <br>
            </div>
        </div>



    </main>

    <script type="text/javascript">

        $(document).ready( function() {
            $("#guardar_solicitud").click(function (event) {
                var laboratorio=$("#laboratorio").val();
                var fecha_i=$("#fecha_inicial").val();
                var fecha_f=$("#fecha_final").val();

                var fecha_inicial = fecha_i.split("/").reverse().join("-");
                var fecha_final = fecha_f.split("/").reverse().join("-");

                window.location.href='/laboratorios/mostrar/'+laboratorio+'/'+fecha_inicial+'/'+fecha_final ;
            });
            $("#laboratorio").change(function() {
                $("#mostrar").css("display", "inline");
            });
            $("#datetimepicker11").change(function(e){
                console.log(e);
                var fech= e.target.value;
                var TuFecha = new Date(fech);
                var dias = 5;
                //nueva fecha sumada
                TuFecha.setDate(TuFecha.getDate() + dias);
                //formato de salida para la fecha
                var  resultado = TuFecha.getFullYear() + '/' +
                    (TuFecha.getMonth() + 1) + '/' + TuFecha.getDate();
                $('#soli').empty();
                $('#soli').append('<input class="form-control" id="fecha_final" value="'+resultado+'"/>');
                // alert(resultado);

            });


        });
    </script>

@endsection
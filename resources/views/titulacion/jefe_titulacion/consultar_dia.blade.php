@extends('layouts.app')
@section('title', 'Titulación')
@section('content')
    <main>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">TITULACIONES AUTORIZADAS</h3>
                    </div>
                </div>
            </div>
        </div>
        @if($estado_consulta_dia == 0)
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading" style="text-align: center">
                        <div class="form-group">
                         <label for="deparamento">Selecciona la fecha del dia a consultar</label>
                         <div class='input-group date' data-date-format="dd/mm/yyyy" id='fecha_dia' >
                         <input type='text' id="fecha_dia1" class="form-control" required />
                          <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar">
                                     </span>
                                    </span>
                             </div>

                </div>
                        <button  id="ver_consulta_fecha" class="btn btn-info">Consutar</button>

                    </div>
                </div>
            </div>
        </div>
        @elseif($estado_consulta_dia == 1)

            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <div class="form-group">
                                <label for="deparamento">Selecciona la fecha del dia a consultar</label>
                                <div class='input-group date' data-date-format="dd/mm/yyyy" id='fecha_dia' >
                                    <input type='text' id="fecha_dia2" class="form-control"  value="{{$fecha_dia}}" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar">
                                     </span>
                                    </span>
                                </div>

                            </div>
                            <button  id="ver_consulta_fecha2" class="btn btn-info">Consutar</button>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h1 style="text-align: center">Dia: {{ $fecha_dia }}</h1>
                </div>
            </div>
        <div class="row">
            <div class="col-md-6">
                <h1 style="text-align: center; color: #1c7430">SALA DE AUDITORIO</h1>
            </div>
            <div class="col-md-6">
                <h1 style="text-align: center; color: #1c7430">SALA DE VINCULACIÓN</h1>
            </div>
        </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="list-group">
                        <a  class="list-group-item active" style="text-align: center; background: #95999c; font-size: 25px;">{{ $horas[0]->horario_dia }}</a>
                        @foreach($sala1 as $alumno1)
                            @if($horas[0]->id_horarios_dias == $alumno1['id_horarios_dias'])
                                <a  class="list-group-item">
                                    <h3 style="color: #2b2b2b">NO. CUENTA:  {{ $alumno1['no_cuenta'] }}</h3>
                                    <h4> NOMBRE DEL ESTUDIANTE: {{ $alumno1['nombre_al'] }} {{ $alumno1['apaterno'] }}  {{ $alumno1['amaterno'] }}</h4>
                                    <h5>CARRERA: {{ $alumno1['carrera'] }} </h5>
                                    <p>PRESIDENTE: {{ $alumno1['presidente'] }}</p>
                                    <p>SECRETARIO: {{ $alumno1['secretario'] }}</p>
                                    <p>VOCAL: {{ $alumno1['vocal'] }}</p>
                                    <p>SUPLENTE: {{ $alumno1['suplente'] }}</p>
                                </a>
                              @endif


                        @endforeach

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="list-group">
                        <a  class="list-group-item active" style="text-align: center; background: #95999c; font-size: 25px;">{{ $horas[0]->horario_dia }}</a>
                        @foreach($sala2 as $alumno2)
                            @if($horas[0]->id_horarios_dias == $alumno2['id_horarios_dias'])
                                <a  class="list-group-item">
                                    <h3 style="color: #2b2b2b">NO. CUENTA:  {{ $alumno2['no_cuenta'] }}</h3>
                                    <h4> NOMBRE DEL ESTUDIANTE: {{ $alumno2['nombre_al'] }} {{ $alumno2['apaterno'] }}  {{ $alumno2['amaterno'] }}</h4>
                                    <h5>CARRERA: {{ $alumno2['carrera'] }} </h5>
                                    <p>PRESIDENTE: {{ $alumno2['presidente'] }}</p>
                                    <p>SECRETARIO: {{ $alumno2['secretario'] }}</p>
                                    <p>VOCAL: {{ $alumno2['vocal'] }}</p>
                                    <p>SUPLENTE: {{ $alumno2['suplente'] }}</p>
                                </a>
                            @endif


                        @endforeach

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="list-group">
                        <a  class="list-group-item active" style="text-align: center; background: #95999c; font-size: 25px;">{{ $horas[1]->horario_dia }}</a>

                        @foreach($sala1 as $alumno1)
                            @if($horas[1]->id_horarios_dias == $alumno1['id_horarios_dias'])
                                <a  class="list-group-item">
                                    <h3 style="color: #2b2b2b">NO. CUENTA:  {{ $alumno1['no_cuenta'] }}</h3>
                                    <h5> NOMBRE DEL ESTUDIANTE: {{ $alumno1['nombre_al'] }} {{ $alumno1['apaterno'] }}  {{ $alumno1['amaterno'] }}</h5>
                                    <h4>CARRERA: {{ $alumno1['carrera'] }} </h4>
                                    <p>PRESIDENTE: {{ $alumno1['presidente'] }}</p>
                                    <p>SECRETARIO: {{ $alumno1['secretario'] }}</p>
                                    <p>VOCAL: {{ $alumno1['vocal'] }}</p>
                                    <p>SUPLENTE: {{ $alumno1['suplente'] }}</p>

                                </a>
                            @endif


                        @endforeach

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="list-group">
                        <a  class="list-group-item active" style="text-align: center; background: #95999c; font-size: 25px;">{{ $horas[1]->horario_dia }}</a>

                        @foreach($sala2 as $alumno2)
                            @if($horas[1]->id_horarios_dias == $alumno2['id_horarios_dias'])
                                <a  class="list-group-item">
                                    <h3 style="color: #2b2b2b">NO. CUENTA:  {{ $alumno2['no_cuenta'] }}</h3>
                                    <h5> NOMBRE DEL ESTUDIANTE: {{ $alumno2['nombre_al'] }} {{ $alumno2['apaterno'] }}  {{ $alumno2['amaterno'] }}</h5>
                                    <h4>CARRERA: {{ $alumno2['carrera'] }} </h4>
                                    <p>PRESIDENTE: {{ $alumno2['presidente'] }}</p>
                                    <p>SECRETARIO: {{ $alumno2['secretario'] }}</p>
                                    <p>VOCAL: {{ $alumno2['vocal'] }}</p>
                                    <p>SUPLENTE: {{ $alumno2['suplente'] }}</p>

                                </a>
                            @endif


                        @endforeach

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="list-group">
                        <a  class="list-group-item active" style="text-align: center; background: #95999c; font-size: 25px;">{{ $horas[2]->horario_dia }}</a>

                        @foreach($sala1 as $alumno1)
                            @if($horas[2]->id_horarios_dias == $alumno1['id_horarios_dias'])
                                <a  class="list-group-item">
                                    <h3 style="color: #2b2b2b">NO. CUENTA:  {{ $alumno1['no_cuenta'] }}</h3>
                                    <h5> NOMBRE DEL ESTUDIANTE: {{ $alumno1['nombre_al'] }} {{ $alumno1['apaterno'] }}  {{ $alumno1['amaterno'] }}</h5>
                                    <h4>CARRERA: {{ $alumno1['carrera'] }} </h4>
                                    <p>PRESIDENTE: {{ $alumno1['presidente'] }}</p>
                                    <p>SECRETARIO: {{ $alumno1['secretario'] }}</p>
                                    <p>VOCAL: {{ $alumno1['vocal'] }}</p>
                                    <p>SUPLENTE: {{ $alumno1['suplente'] }}</p>

                                </a>
                            @endif


                        @endforeach

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="list-group">
                        <a  class="list-group-item active" style="text-align: center; background: #95999c; font-size: 25px;">{{ $horas[2]->horario_dia }}</a>

                        @foreach($sala2 as $alumno2)
                            @if($horas[2]->id_horarios_dias == $alumno2['id_horarios_dias'])
                                <a  class="list-group-item">
                                    <h3 style="color: #2b2b2b">NO. CUENTA:  {{ $alumno2['no_cuenta'] }}</h3>
                                    <h5> NOMBRE DEL ESTUDIANTE: {{ $alumno2['nombre_al'] }} {{ $alumno2['apaterno'] }}  {{ $alumno2['amaterno'] }}</h5>
                                    <h4>CARRERA: {{ $alumno2['carrera'] }} </h4>
                                    <p>PRESIDENTE: {{ $alumno2['presidente'] }}</p>
                                    <p>SECRETARIO: {{ $alumno2['secretario'] }}</p>
                                    <p>VOCAL: {{ $alumno2['vocal'] }}</p>
                                    <p>SUPLENTE: {{ $alumno2['suplente'] }}</p>

                                </a>
                            @endif


                        @endforeach

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="list-group">
                        <a  class="list-group-item active" style="text-align: center; background: #95999c; font-size: 25px;">{{ $horas[3]->horario_dia }}</a>

                        @foreach($sala1 as $alumno1)
                            @if($horas[3]->id_horarios_dias == $alumno1['id_horarios_dias'])
                                <a  class="list-group-item">
                                    <h3 style="color: #2b2b2b">NO. CUENTA:  {{ $alumno1['no_cuenta'] }}</h3>
                                    <h5> NOMBRE DEL ESTUDIANTE: {{ $alumno1['nombre_al'] }} {{ $alumno1['apaterno'] }}  {{ $alumno1['amaterno'] }}</h5>
                                    <h4>CARRERA: {{ $alumno1['carrera'] }} </h4>
                                    <p>PRESIDENTE: {{ $alumno1['presidente'] }}</p>
                                    <p>SECRETARIO: {{ $alumno1['secretario'] }}</p>
                                    <p>VOCAL: {{ $alumno1['vocal'] }}</p>
                                    <p>SUPLENTE: {{ $alumno1['suplente'] }}</p>

                                </a>
                            @endif


                        @endforeach

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="list-group">
                        <a  class="list-group-item active" style="text-align: center; background: #95999c; font-size: 25px;">{{ $horas[3]->horario_dia }}</a>

                        @foreach($sala2 as $alumno2)
                            @if($horas[3]->id_horarios_dias == $alumno2['id_horarios_dias'])
                                <a  class="list-group-item">
                                    <h3 style="color: #2b2b2b">NO. CUENTA:  {{ $alumno2['no_cuenta'] }}</h3>
                                    <h5> NOMBRE DEL ESTUDIANTE: {{ $alumno2['nombre_al'] }} {{ $alumno2['apaterno'] }}  {{ $alumno2['amaterno'] }}</h5>
                                    <h4>CARRERA: {{ $alumno2['carrera'] }} </h4>
                                    <p>PRESIDENTE: {{ $alumno2['presidente'] }}</p>
                                    <p>SECRETARIO: {{ $alumno2['secretario'] }}</p>
                                    <p>VOCAL: {{ $alumno2['vocal'] }}</p>
                                    <p>SUPLENTE: {{ $alumno2['suplente'] }}</p>

                                </a>
                            @endif


                        @endforeach

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="list-group">
                        <a  class="list-group-item active" style="text-align: center; background: #95999c; font-size: 25px;">{{ $horas[4]->horario_dia }}</a>

                        @foreach($sala1 as $alumno1)
                            @if($horas[4]->id_horarios_dias == $alumno1['id_horarios_dias'])
                                <a  class="list-group-item">
                                    <h3 style="color: #2b2b2b">NO. CUENTA:  {{ $alumno1['no_cuenta'] }}</h3>
                                    <h5> NOMBRE DEL ESTUDIANTE: {{ $alumno1['nombre_al'] }} {{ $alumno1['apaterno'] }}  {{ $alumno1['amaterno'] }}</h5>
                                    <h4>CARRERA: {{ $alumno1['carrera'] }} </h4>
                                    <p>PRESIDENTE: {{ $alumno1['presidente'] }}</p>
                                    <p>SECRETARIO: {{ $alumno1['secretario'] }}</p>
                                    <p>VOCAL: {{ $alumno1['vocal'] }}</p>
                                    <p>SUPLENTE: {{ $alumno1['suplente'] }}</p>

                                </a>
                            @endif


                        @endforeach

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="list-group">
                        <a  class="list-group-item active" style="text-align: center; background: #95999c; font-size: 25px;">{{ $horas[4]->horario_dia }}</a>

                        @foreach($sala2 as $alumno2)
                            @if($horas[4]->id_horarios_dias == $alumno2['id_horarios_dias'])
                                <a  class="list-group-item">
                                    <h3 style="color: #2b2b2b">NO. CUENTA:  {{ $alumno2['no_cuenta'] }}</h3>
                                    <h5> NOMBRE DEL ESTUDIANTE: {{ $alumno2['nombre_al'] }} {{ $alumno2['apaterno'] }}  {{ $alumno2['amaterno'] }}</h5>
                                    <h4>CARRERA: {{ $alumno2['carrera'] }} </h4>
                                    <p>PRESIDENTE: {{ $alumno2['presidente'] }}</p>
                                    <p>SECRETARIO: {{ $alumno2['secretario'] }}</p>
                                    <p>VOCAL: {{ $alumno2['vocal'] }}</p>
                                    <p>SUPLENTE: {{ $alumno2['suplente'] }}</p>

                                </a>
                            @endif


                        @endforeach

                    </div>
                </div>
            </div>

            @endif

        <script type="text/javascript">
            $(document).ready( function() {
                $('#fecha_dia').datepicker({
                    daysOfWeekDisabled: [0,6],
                    autoclose: true,
                    language: 'es',

                });

                $("#ver_consulta_fecha").click(function (){

                    var fecha_dia=$("#fecha_dia1").val();
                    var fecha_dia = fecha_dia.split("/").reverse().join("-");
                    var fecha_dia = fecha_dia.split("-").reverse().join("-");

                    window.location.href='/titulacion/consultar_fecha_dia_titulacion_autorizadas/'+fecha_dia ;

                });
                $("#ver_consulta_fecha2").click(function (){

                    var fecha_dia=$("#fecha_dia2").val();
                    var fecha_dia = fecha_dia.split("/").reverse().join("-");
                    var fecha_dia = fecha_dia.split("-").reverse().join("-");

                    window.location.href='/titulacion/consultar_fecha_dia_titulacion_autorizadas/'+fecha_dia ;

                });
            });


        </script>

    </main>

@endsection
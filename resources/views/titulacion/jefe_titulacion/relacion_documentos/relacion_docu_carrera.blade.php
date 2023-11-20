@extends('layouts.app')
@section('title', 'Titulación')
@section('content')
    <main>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 style="text-align: center">RELACIÓN DE DOCUMENTOS <br>
                            @if($estado_consulta_dia > 0)
                            Fecha consultada: {{ $fecha }}</h3>
                            @endif
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
            @if($contar_relacion_actas_ti == 0)
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 style="text-align: center">No hay titulaciones en este día </h3>

                            </div>
                        </div>
                    </div>
                </div>
            @else
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Relación de documentos</th>
                                    <th>Ver documento</th>
                                    <th>No. de estudiante titulado</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Relación de títulos</td>
                                    <td><button type="button" class="btn btn-primary center" onclick="window.location='{{url('/titulacion/relacion_titulos/'.$fecha)}}'">Ver Documento </button></td>
                                    <td>{{ $contar_relacion_actas_ti}}</td>
                                </tr>
                                <tr>
                                    <td>Relación de actas de titulación</td>
                                    <td><button type="button" class="btn btn-primary center" onclick="window.location='{{url('/titulacion/relacion_actas_titulos/'.$fecha)}}'">Ver Documento </button></td>
                                    <td>{{ $contar_relacion_actas_ti}}</td>

                                </tr>
                                <tr>
                                    <td>Relación de mención honorifica</td>
                                    <td><button type="button" class="btn btn-primary center" onclick="window.location='{{url('/titulacion/relacion_mencion_honorifica/'.$fecha)}}'">Ver Documento </button></td>
                                    <td>{{ $contar_relacion_mencion}}</td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
            </div>
            @endif

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

                    window.location.href='/titulacion/consultar_fecha_dia_relacion_doc/'+fecha_dia ;

                });
                $("#ver_consulta_fecha2").click(function (){

                    var fecha_dia=$("#fecha_dia2").val();
                    var fecha_dia = fecha_dia.split("/").reverse().join("-");
                    var fecha_dia = fecha_dia.split("-").reverse().join("-");

                    window.location.href='/titulacion/consultar_fecha_dia_relacion_doc/'+fecha_dia ;

                });
            });


        </script>



@endsection
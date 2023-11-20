@extends('layouts.app')
@section('title', 'Docentes en Plantilla')
@section('content')

    <script>
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            e.target // newly activated tab
            e.relatedTarget // previous active tab
        })
    </script>

    <div id="contenedor_horarios">

    </div>

    <main class="col-md-12">

        <?php $jefe_division=session()->has('jefe_division')?session()->has('jefe_division'):false;
        $directivo=session()->has('directivo')?session()->has('directivo'):false;
        $consultas=session()->has('consultas')?session()->has('consultas'):false; ?>

        <div class="row">
            <div class="col-md-7 col-md-offset-2 col-sm-6 col-sm-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">PLANTILLA</h3>
                    </div>
                    <div class="panel-body">
                        @if($directivo==1 ||$consultas==1)
                            <input type="hidden" id="tipo" name="tipo" value="1">
                            <div class="col-md-5 col-md-offset-1">
                                <div class="dropdown">
                                    <label for="dropdownMenu1">Carrera</label>
                                    <select name="selectCarrera" id="selectCarrera" class="form-control ">
                                        <option disabled selected>Selecciona carrera...</option>
                                        @foreach($carreras as $carrera)
                                            @if($carrera->id_carrera==$id_carrera)
                                                <option value="{{$id_carrera}}" selected="selected">{{$carrera->nombre}}</option>
                                            @else
                                                <option value="{{$carrera->id_carrera}}" >{{$carrera->nombre}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if(isset($ver))
                                <div class="col-md-6 col-sm-6" id="div_cargo">
                                    <div class="dropdown-center">
                                        <label for="selectCargo">Cargo</label>
                                        <select name="selectCargo" id="selectCargo" class="form-control ">
                                            <option disabled selected>Selecciona cargo...</option>
                                            @foreach($cargos as $cargo)
                                                @if($cargo->id_cargo==$id_cargo)
                                                    <option value="{{$cargo->id_cargo}}" selected="selected">{{$cargo->cargo}}</option>
                                                @else
                                                    <option value="{{$cargo->id_cargo}}" >{{$cargo->cargo}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6 col-sm-6" id="div_cargo" style="display:none;">
                                    <div class="dropdown-center">
                                        <label for="selectCargo">Cargo</label>
                                        <select name="selectCargo" id="selectCargo" class="form-control ">
                                            <option disabled selected>Selecciona cargo...</option>
                                            @foreach($cargos as $cargo)
                                                <option value="{{$cargo->id_cargo}}" >{{$cargo->cargo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                        @else
                            <input type="hidden" id="tipo" name="tipo" value="2">
                            <div class="col-md-6 col-sm-6" id="div_cargo">
                                <div class="dropdown-center">
                                    <label for="selectCargo">Cargo</label>
                                    <select name="selectCargo" id="selectCargo" class="form-control ">
                                        <option disabled selected>Selecciona cargo...</option>
                                        @foreach($cargos as $cargo)
                                            @if($cargo->id_cargo==$id_cargo)
                                                <option value="{{$cargo->id_cargo}}" selected="selected">{{$cargo->cargo}}</option>
                                            @else
                                                <option value="{{$cargo->id_cargo}}" >{{$cargo->cargo}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if(isset($ver))
                <div class="row" id="contenedor_p">
                    <div class="col-md-11">
                        <table class="table table-bordered table-hover tabla-grande">
                            <tr>
                                <th>Nombre</th>
                                <th>Asignatura</th>
                                <th>Actividad</th>
                                <th>No. Grupos</th>
                                <th>NO. HORAS X ASIGNATURA</th>
                                <th>TOTAL HORAS X ASIGNATURA</th>
                                <th>TOTAL HORAS DOCENTE</th>
                                <th>RFC</th>
                                <th>CLAVE ISSEMYM</th>
                                <th>FECHA INGRESO TESVB</th>
                                <th>FECHA NUEVO C.</th>
                                <th>PERFIL</th>
                                <th>OBSERVACIONES</th>
                            </tr>

                            @foreach($docentes as $docente)
                                <?php
                                $num_col=count($docente["materias"]);
                                $first=true;
                                ?>
                                @foreach($docente["materias"] as $dat_materia)

                                    @if($first)
                                        <?php $first=false;?>
                                        <tr>
                                            <td class="horario_prof" id="{{ $docente["id_personal"]}}" rowspan="{{ $num_col }}" valign="middle">{{ $docente["nombre"]}}</td>

                                            <td>{{ $dat_materia['nombre_materia'] }}</td>
                                            <td>{{ $dat_materia['actividad'] }}</td>
                                            <td>{{ $dat_materia['no_grupos'] }}</td>
                                            <td>{{ $dat_materia['horas_totales'] }}</td>
                                            <td>{{ $dat_materia['total'] }}</td>
                                            <td id="{{ $docente["id_personal"]}}" class="graficas" rowspan="{{ $num_col }}">{{ $docente["f_total"]}}</td>
                                            <td rowspan="{{ $num_col }}">{{ $docente["rfc"]}}</td>
                                            <td rowspan="{{ $num_col }}">{{ $docente["clave"]}}</td>
                                            <td rowspan="{{ $num_col }}">{{ $docente["fch_ingreso_tesvb"]}}</td>
                                            <td rowspan="{{ $num_col }}">{{ $fecha_nuevo }}</td>
                                            <td rowspan="{{ $num_col }}">{{ $docente["descripcion"]}}</td>
                                            <td rowspan="{{ $num_col }}">{{ $docente["observaciones"] }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>{{ $dat_materia['nombre_materia'] }}</td>
                                            <td>{{ $dat_materia['actividad'] }}</td>
                                            <td>{{ $dat_materia['no_grupos'] }}</td>
                                            <td>{{ $dat_materia['horas_totales'] }}</td>
                                            <td>{{ $dat_materia['total'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </table>
                    </div>

                    <div class="col-md-3 col-md-offset-5">
                        TOTAL HORAS PLANTILLA: {{ $total_plantilla }}
                    </div>
                </div>
                <br>
                <div class="col-md-1 col-md-offset-5 regis">
                    <a href="/excel_plantilla/{{ $id_carrera }}/{{ $id_cargo }}" class="btn btn-primary" target="_blank"><span class="glyphicon glyphicon-print"  aria-hidden="true"></span>   Imprimir</a>
                </div>
            <!--<div class="col-md-2 cont">
  <a href="/pdf_plantilla/{{ $id_cargo }}" class="btn btn-primary crear" target="_blank"><span class="glyphicon glyphicon-print"  aria-hidden="true"></span> Imprimir</a>
                        </div>-->
            @endif
        </div>



        <!-- Modal para ver graficas -->
        <div class="modal fade bs-example-modal-lg" id="modal_graficas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button id="acepta2" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">HISTORIAL DE HORAS DOCENTE</h4>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <input type="hidden" id="prof" name="prof" value="">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <div class="dropdown">
                                    <select name="selectCiclo" id="selectCiclo" class="form-control">
                                        <option disabled selected>Selecciona ciclo...</option>
                                        <option value="1" >{{ "Marzo-Agosto" }}</option>
                                        <option value="2" >{{ "Septiembre-Febrero" }}</option>
                                    </select>
                                </div>
                            </div>
                            <div id="contenedor_graficas">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="acepta" type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>



    <script>
        function bloqueo()
        {
            $.blockUI({
            });
        }

        $(document).ready(function() {

            $(".horario_prof").click(function()
            {
                $("#contenedor_horarios").empty();
                var id=$(this).attr('id');

                $.get("/plantilla/horario/"+id,function(request)
                {
                    $("#contenedor_horarios").html(request);
                });
            });

            $(".graficas").click(function()
            {
                var idp=$(this).attr('id');
                $('#selectCiclo').data('idp',idp);
                $('#modal_graficas').modal('show');
            });

            $("#selectCiclo").on('change',function(e)
            {
                bloqueo();
                var idp=($(this).data('idp'));
                var idc= $("#selectCiclo").val();

                $("#contenedor_graficas").empty();
                $.get("/graficas/"+idp+"/"+idc,function(request)
                {
                    $("#contenedor_graficas").html(request);
                    $.unblockUI();
                });
            });

            $("#acepta").click(function()
            {
                $("#contenedor_graficas").empty();
                $('#selectCiclo').val($('#selectCiclo > option:first').val());
            });
            $("#acepta2").click(function()
            {
                $("#contenedor_graficas").empty();
                $('#selectCiclo').val($('#selectCiclo > option:first').val());
            });

            $("#selectCarrera").on('change',function(e){
                $("#div_cargo").show(1000);
                $('#selectCargo').val($('#selectCargo > option:first').val());
                $("#contenedor_p").hide();

            });

            $("#selectCargo").on('change',function(e){
                bloqueo();
                var tipo=$("#tipo").val();
                if(tipo==1)//directivo
                {
                    var id_carrera= $("#selectCarrera").val();
                    var id_cargo= $("#selectCargo").val();
                    window.location.href='/plantilla/datos/'+id_carrera +'/'+id_cargo;
                    $.unblockUI();
                }
                else if(tipo==2)
                {
                    bloqueo();
                    var id_carrera=0;
                    var id_cargo= $("#selectCargo").val();
                    window.location.href='/plantilla/datos/'+id_carrera +'/'+id_cargo;
                    $.unblockUI();
                }

            });
        });

    </script>

@endsection

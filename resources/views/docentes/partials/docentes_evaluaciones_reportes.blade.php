@extends('layouts.app')
@section('title', 'Evaluaciones')
@section('content')
    <?php $dia = date("d"); $mes = date("m"); $anio = date("Y");$dia_v = date("d"); $mes_v = date("m"); $anio_v = date("Y");?>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">REGISTRO DE CALIFICACIONES</h3>

                </div>
            </div>
        </div>
    </div>
    @if(!isset($nom_materia))
        <div class="row col-md-12">
            <div class="col-md-5 col-md-offset-4">
                <label class=" alert alert-danger text-center" data-toggle="tab"><h3>No hay alumnos inscritos en esta
                        materia
                    </h3></label>
            </div>
        </div>
    @else
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel">
                <div class="panel-body">
                    <div class="row col-md-12">
                        <label for="" class="col-md-12 text-center">{{$nom_carrera}}</label>
                        <label for="" class="col-md-6 text-left">
                            Materia: {{$nom_materia}}
                            <br>
                            Grupo: {{$grupo}}
                        </label>
                        <label for="" class="col-md-6 text-right">
                            Clave: {{$clave_m}}
                            <br>
                            No. Unidades: {{$unidades}}
                        </label>
                        <label for="" class="col-md-12 text-right">
                            <a href="{{url("reportes/reporte_docente",[$id_docente,$id_materia,$id_grupo])}}"  target="_blank" class="btn btn-success center">Reporte docente</a>
                            <a href="{{url("reportes/reporte_canalizacion",[$id_docente,$id_materia,$id_grupo])}}" target="_blank" class="btn btn-success center">Reporte canalización</a>
                            <a href="{{url("reportes/reporte_tutor",[$id_docente,$id_materia,$id_grupo])}}"  target="_blank" class="btn btn-success center">Reporte tutor</a>
                            <button type="button" class="btn btn-success center"
                                    onclick="window.open('{{url('genera_listas', ['id_docente' => $id_docente,'id_materia' => $id_materia,'id_grupo' => $id_grupo,'unidades' => $unidades])}}')">
                                Lista de asistencia
                            </button>

                            <input type="{{ $esc_pormateria ? 'hidden' : ($habilitaPDF==2 ? 'button' : 'hidden') }}"
                                   class="btn btn-primary tooltip-options link" id="link_genera_pdf"
                                   name="link_genera_pdf" data-token="{{ csrf_token() }}" data-toggle="tooltip"
                                   data-placement="top" title="Generar acta de calificaciones" target="_blank"
                                   value="Acta Ordinaria">
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel">
                <div class="panel-body">
                    <table class="table table-striped col-md-12">
                        <thead class="">
                        <tr class="text-center" style="background:#dddddd;color:black">
                            <th rowspan="2" class="text-center" style="display: table-cell;vertical-align: middle;">NP
                            </th>
                            <th rowspan="2" class="text-center" style="display: table-cell;vertical-align: middle;">No.
                                CTA
                            </th>
                            <th rowspan="2" class="text-center" style="display: table-cell;vertical-align: middle;">
                                NOMBRE DEL ALUMNO
                            </th>
                            <th colspan="{{ $unidades+2 }}" class="text-center">UNIDADES</th>
                        </tr>
                        <tr>
                            @for ($i = 0; $i < $unidades; $i++)
                                <th class="text-center">
                                    {{($i==0 ? 'I' :
                                            ($i==1 ? 'II' :
                                                    ($i==2 ? 'III' :
                                                            ($i==3 ? 'IV' :
                                                                    ($i==4 ? 'V' :
                                                                            ($i==5 ? 'VI' :
                                                                                    ($i==6 ? 'VII' :
                                                                                            ($i==7 ? 'VIII' :
                                                                                                    ($i==8 ? 'IX' :
                                                                                                            ($i==9 ? 'X' :
                                                                                                                    ($i==10 ? 'XI' :
                                                                                                                            ($i==11 ? 'XII' :
                                                                                                                                    ($i==12 ? 'XIII' :
                                                                                                                                            ($i==13 ? 'XIV' :
                                                                                                                                                    ($i==14 ? 'XV' : ' ' )))))))))))))))}}
                                </th>
                            @endfor
                            <th class="text-center">PROMEDIO</th>
                            <th class="text-center">T.E.</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $porcentaje_gen = 0; $cont_gen = 0;?>
                        @foreach($alumnos as $alumno)
                            @php $cont_na=0;
                            @endphp
                            <tr class="text-center">
                                <td class="text-center">{{$alumno['np']}}</td>
                                <td class="text-center"
                                    style=" {!! $alumno['curso']=='REPETICION' ? 'background:#ffee62; color:orange' : ($alumno['curso']=='ESPECIAL' ? 'background:#a94442; color:white' : '') !!} "> {{$alumno['cuenta']}}</td>
                                <td class="text-left">{{$alumno['nombre']}}</td>
                                <?php  $cont = 0; $id_unidad_res = 0; $evalPrevia = false;$evalPreviabtn = false;?>
                                @forelse($alumno['calificaciones'] as $calificacion)
                                    <?php  $cont++; $id_unidad_res = ($calificacion['id_unidad'] != 0 ? $calificacion['id_unidad'] : "0")?>
                                    @if(($cont)<=$unidades)
                                        @if( ($cont)==$calificacion['id_unidad'])
                                            @php
                                                if($calificacion['calificacion']<70)
                                                $cont_na++;
                                            @endphp
                                            <td style="background: {{ $calificacion['calificacion']>=70 ? ' ' : '#FFEE62' }}"
                                                data-id-eval="{{ $calificacion['id_evaluacion'] }}"
                                                data-id-unidad="{{ $calificacion['id_unidad'] }}">
                                                {{ $calificacion['calificacion']>=70 ? $calificacion['calificacion'] : 'N.A'  }}
                                                {!! $calificacion['modificado']==1 ? '<span class="oi oi-info tooltip-options link" style="background:#bf5329;border-radius: 100%; color:white; padding:5px; font-size: 7px" data-toggle="tooltip" data-placement="top" title="La calificación fue modificada"></span>' : ''  !!}
                                                <?php $evalPrevia = true; $evalPreviabtn = true;?>
                                            </td>
                                        @else

                                        @endif
                                    @else

                                    @endif
                                @empty

                                @endforelse
                                <?php  $unidades_restantes = $unidades - $cont; ?>
                                @for ($i = 1; $i <= $unidades_restantes; $i++)
                                    @if( empty($uni_asignadas[$i-1]))
                                        <td>0</td>
                                    @else
                                        @if(isset($uni_asignadas[$cont]))
                                            <?php $dia = date("d"); $mes = date("m"); $anio = date("Y");$dia_v = date("d", strtotime((date("d-m-Y", strtotime($uni_asignadas[$evalPrevia ? ($cont) : ($i - 1)]->{'fecha'}))) . "+ 0 days"));$mes_v = date("m", strtotime((date("d-m-Y", strtotime($uni_asignadas[$evalPrevia ? ($cont) : ($i - 1)]->{'fecha'}))) . "+ 0 days"));$anio_v = date("Y", strtotime((date("d-m-Y", strtotime($uni_asignadas[$evalPrevia ? ($cont) : ($i - 1)]->{'fecha'}))) . "+ 0 days"));?>
                                            @if($anio<=$anio_v)
                                                @if($mes<=$mes_v)
                                                    @if($dia<=$dia_v || $mes<$mes_v)
                                                        @if($id_unidad_res+$i==1)
                                                            <td class="text-center"><input
                                                                        id="error_{{$alumno['id_carga_academica']}}"
                                                                        type="text" value="0"
                                                                        class=" text-center calificacion_{{$id_unidad_res+$i}} input_calificacion"
                                                                        style="width:7em; border-radius: 4px"
                                                                        data-contna="{{$cont_na}}"
                                                                        data-id="{{$alumno['id_carga_academica']}}"
                                                                        name="calificacion_{{$id_unidad_res+$i}}" {{$alumno['especial_bloq']==1 ? 'disabled':''}}>
                                                                @if($alumno['especial_bloq']!=1 )
                                                                <div id="cont{{$alumno['id_carga_academica']}}"
                                                                     style="display: none">


                                                                    <select name=""
                                                                            id="opcion{{$alumno['id_carga_academica']}}"
                                                                            data-id="{{$alumno['id_carga_academica']}}"
                                                                            class="opciones">
                                                                        <option value="0" disabled="" selected>¿Motivo
                                                                            por el cual reprobó?
                                                                        </option>
                                                                        <option value="1">Faltas</option>
                                                                        <option value="2">Responsabilidad</option>
                                                                        <option value="3">Otro</option>
                                                                    </select>
                                                                    <br>
                                                                    <input
                                                                            id="otro{{$alumno['id_carga_academica']}}"
                                                                            type="text" value=""
                                                                            class=" text-center input_otros"
                                                                            style="width:9em; border-radius: 4px; display: none;"
                                                                            data-id="{{$alumno['id_carga_academica']}}"
                                                                            name="calificacion_{{$id_unidad_res+$i}}" {{$alumno['especial_bloq']==1 ? 'disabled':''}}>
                                                                    <br>
                                                                    <select name=""
                                                                            id="canaliza{{$alumno['id_carga_academica']}}"
                                                                            data-id="{{$alumno['id_carga_academica']}}"
                                                                            style="display: none">
                                                                        <option value="0" disabled="" selected>
                                                                            Canalización
                                                                        </option>
                                                                        @foreach($canalizaciones as $canalizacion)
                                                                            <option value="{{$canalizacion->id}}">{{$canalizacion->descripcion}}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </div>
                                                                    @endif
                                                            </td>
                                                        @else
                                                            @if($evalPrevia)
                                                                <td class="text-center"><input
                                                                            id="error_{{$alumno['id_carga_academica']}}"
                                                                            type="text" value="0"
                                                                            class=" text-center calificacion_{{$id_unidad_res+$i}} input_calificacion"
                                                                            style="width:7em; border-radius: 4px"
                                                                            data-id="{{$alumno['id_carga_academica']}}"
                                                                            data-contna="{{$cont_na}}"
                                                                            name="calificacion_{{$id_unidad_res+$i}}"

                                                                            {{$alumno['especial_bloq']==1 ? 'disabled':''}}>

                                                                    @if($alumno['especial_bloq']!=1 )
                                                                    <div id="cont{{$alumno['id_carga_academica']}}"
                                                                         style="display: none">


                                                                        <select name=""
                                                                                id="opcion{{$alumno['id_carga_academica']}}"
                                                                                data-id="{{$alumno['id_carga_academica']}}"
                                                                                class="opciones">
                                                                            <option value="0" disabled="" selected>
                                                                                ¿Motivo por el cual reprobó?
                                                                            </option>
                                                                            <option value="1">Faltas</option>
                                                                            <option value="2">Responsabilidad</option>
                                                                            <option value="3">Otro</option>
                                                                        </select>
                                                                        <br>
                                                                        <input
                                                                                id="otro{{$alumno['id_carga_academica']}}"
                                                                                type="text" value=""
                                                                                class=" text-center input_otros"
                                                                                style="width:9em; border-radius: 4px; display: none; color:black;"
                                                                                data-id="{{$alumno['id_carga_academica']}}"
                                                                                name="calificacion_{{$id_unidad_res+$i}}" {{$alumno['especial_bloq']==1 ? 'disabled':''}}>
                                                                        <br>

                                                                        <select name=""
                                                                                id="canaliza{{$alumno['id_carga_academica']}}"
                                                                                data-id="{{$alumno['id_carga_academica']}}"
                                                                                style="display: none">
                                                                            <option value="0" disabled="" selected>
                                                                                Canalización
                                                                            </option>
                                                                            @foreach($canalizaciones as $canalizacion)
                                                                                <option value="{{$canalizacion->id}}">{{$canalizacion->descripcion}}</option>
                                                                            @endforeach

                                                                        </select>
                                                                    </div>
                                                                        @endif
                                                                </td>
                                                                <?php $evalPrevia = false;?>
                                                            @else
                                                                <td>0</td>
                                                            @endif
                                                        @endif
                                                    @else
                                                        <td>0</td>
                                                    @endif
                                                @else
                                                    <td>0</td>
                                                @endif
                                            @else
                                                <td>0</td>
                                            @endif
                                        @else
                                            <td class="text-center">0</td>
                                        @endif
                                    @endif
                                @endfor
                                <?php  $porcentaje_gen += $alumno['promedio'] >= 70 ? '1' : '0'; $cont_gen++;?>
                                @if($alumno['promedio']>=70)
                                    <td style="background:white; ">{{ $alumno['promedio'] }}</td>
                                @else
                                    <td style="background: #a94442; ">{{$alumno['promedio']}}</td>
                                @endif
                                <td>{!! $alumno['curso']=='NORMAL' && $alumno['esc_alumno'] ? 'ESC'  : ( $alumno['curso']=='NORMAL' ? 'O'  : ($alumno['curso']=='REPETICION' && $alumno['esc_alumno'] ? 'ESC2' : ($alumno['curso']=='REPETICION' ? 'O2' : ($alumno['curso']=='ESPECIAL' ? 'CE' : ($alumno['curso']=='GLOBAL' ? 'EG': '' )))))!!}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="{{3+$cont}}"></td>
                            <?php  $unidades_restantes = $unidades - $cont; ?>
                            @for ($i = 1; $i <= $unidades_restantes; $i++)
                                @if( empty($uni_asignadas[$i-1]))
                                @else
                                    @if(isset($uni_asignadas[$cont]))
                                        <?php $dia = date("d"); $mes = date("m"); $anio = date("Y");$dia_v = date("d", strtotime((date("d-m-Y", strtotime($uni_asignadas[$evalPreviabtn ? ($cont) : ($i - 1)]->{'fecha'}))) . "+ 0 days"));$mes_v = date("m", strtotime((date("d-m-Y", strtotime($uni_asignadas[$evalPreviabtn ? ($cont) : ($i - 1)]->{'fecha'}))) . "+ 0 days"));$anio_v = date("Y", strtotime((date("d-m-Y", strtotime($uni_asignadas[$evalPreviabtn ? ($cont) : ($i - 1)]->{'fecha'}))) . "+ 0 days"));?>
                                        @if($anio<=$anio_v)
                                            @if($mes<=$mes_v)
                                                @if($dia<=$dia_v || $mes<$mes_v)
                                                    @if($id_unidad_res+$i==1)
                                                        <td class="text-center"><input style="width: 7em" type="button"
                                                                                       class="btn btn-primary tooltip-options link"
                                                                                       id="guardar_calificacion"
                                                                                       name="guardar_calificacion"
                                                                                       data-token="{{ csrf_token() }}"
                                                                                       data-id_unidad="{{$id_unidad_res+$i}}"
                                                                                       data-toggle="tooltip"
                                                                                       data-placement="top"
                                                                                       title="La fecha limite para evaluar la unidad es {{ $dia_v }}-{{ $mes_v }}-{{ $anio_v }}"
                                                                                       value="guardar">


                                                        </td>
                                                    @else
                                                        @if($evalPreviabtn)
                                                            <td class="text-center"><input style="width: 7em"
                                                                                           type="button"
                                                                                           class="btn btn-primary tooltip-options link"
                                                                                           id="guardar_calificacion"
                                                                                           name="guardar_calificacion"
                                                                                           data-token="{{ csrf_token() }}"
                                                                                           data-id_unidad="{{$id_unidad_res+$i}}"
                                                                                           data-toggle="tooltip"
                                                                                           data-placement="top"
                                                                                           title="La fecha limite para evaluar la unidad es {{ $dia_v }}-{{ $mes_v }}-{{ $anio_v }}"
                                                                                           value="guardar"></td>
                                                            <?php $evalPreviabtn = false;?>
                                                        @else
                                                        @endif
                                                    @endif
                                                @else
                                                @endif
                                            @else
                                            @endif
                                        @else
                                        @endif
                                    @else
                                    @endif
                                @endif
                            @endfor
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            @foreach($porcentajes as $porcentaje)
                                <td class="text-center"
                                    style="background: {{ $porcentaje['porcentaje']>=70 ? '#3c763d' : '#a94442' }}; color: #ffffff">{{ $porcentaje['porcentaje'] }}
                                    %
                                </td>
                            @endforeach
                            <?php  $imp_porcentaje = (($porcentaje_gen * 100) / $cont_gen);?>
                            <td class="text-center"
                                style="background: {{ $imp_porcentaje>=70 ? '#3c763d' : '#a94442' }}; color: #ffffff">{{ round($imp_porcentaje,2) }}
                                %
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- Modal adeudo en los departamentos -->
        <div class="modal fade" id="modal_adeudo"  role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                     {{--  <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                        <h4 class="modal-title " style="text-align: center">Alerta</h4>
                    </div>
                    <div class="modal-body">
                        <p style="text-align: center">	<strong>No cuentas con ningún estudiante en sumativa, dar clic en el botón aceptar </strong></p>
                        <form class="form" id="form_aceptar" action="{{url("/docente/guardar_sin_alumnos_ensumativa/$id_docente/$id_materia/$id_grupo/")}}" role="form" method="POST" >
                            {{ csrf_field() }}
                        </form>
                        <p style="text-align: center;"><button type="button" class="btn btn-primary" id="guardar_notificacion">Aceptar</button></p>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_mensaje" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="text-align: center">Atento aviso</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <strong>“Estimado(a) docente se le recuerda que el acceso a clases de los estudiantes debe ser conforme a las listas de asistencias que emite esta plataforma con fundamento en el art. 30 del reglamento para estudiantes del TESVB.”</strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>

            </div>
        </div>
    @endif
    <script type="text/javascript">


        $(document).ready(function () {

            var mostrar_mensaje = "<?php echo $mostrar_mensaje  ?>";
            if(mostrar_mensaje == 1){
                $('#modal_mensaje').modal('show');
            }

            var estado_reprobado = "<?php echo $estado_reprobado  ?>";
            if(estado_reprobado == 1){

                    $('#modal_adeudo').modal('show');
                $('#modal_adeudo').modal({backdrop: 'static', keyboard: false});
            }
            const total_unidades ={{$unidades}};
            $(".input_calificacion").keyup(function () {
                var id = $(this).data("id");
                var uni_na = $(this).data("contna");
                if ($(this).val() < 70) {
                    $("#cont" + id).show();
                    if ((uni_na + 1) / total_unidades >= 0.4) {
                        $("#canaliza" + id).show();
                    } else
                        $("#canaliza" + id).hide();

                } else {
                    $("#cont" + id).hide();
                }
            });
            $(".opciones").change(function () {
                var id = $(this).data("id");

                if ($(this).val() == 3) {
                    $("#otro" + id).show();

                } else {
                    $("#otro" + id).hide();
                }
            })
            $("#guardar_notificacion").click(function (){
                $("#guardar_notificacion").attr("disabled", true);
                $("#form_aceptar").submit();
                swal({
                    position: "top",
                    type: "success",
                    title: "Aceptación exitosa",
                    showConfirmButton: false,
                    timer: 3500
                });

            });

            $("#link_genera_pdf").click(function (event) {
                var link = "/generar_pdf?id_docente=" + {{ $id_docente }} +"&id_materia=" + {{ $id_materia }} +"&unidades=" + {{ $unidades }}+"&id_grupo=" + {{ $id_grupo }}+"";
                window.open(link);
            });

            $("#guardar_calificacion").click(function () {

                var calificaciones = {alumno: []};
                var id_unidad = $(this).data("id_unidad");
                var token = $(this).data("token");
                var cal_noValida = false;
                var cal_reprobatoria = false;
                var opcion = false;
                var otro = false;
               var canaliza_ban=false;
                var cal_rep = 0;
                $(".calificacion_" + id_unidad).each(function () {
                    var uni_na=$(this).data("contna");
                    if(!$(this).is(":disabled")) {
                        var id_carga_academica = $(this).data("id");
                        var calificacion = $(this).val();
                        var valopcion = $("#opcion" + id_carga_academica).val();
                        var valotro = $("#otro" + id_carga_academica).val();
                        var canaliza = $("#canaliza" + id_carga_academica).val();
                        document.getElementById("error_" + id_carga_academica).style.backgroundColor = "white";
                        document.getElementById("error_" + id_carga_academica).style.color = "black";
                        if (calificacion < 0 || calificacion > 100 || !/^([0-9])*$/.test(calificacion)) {
                            cal_noValida = true;
                            document.getElementById("error_" + id_carga_academica).style.color = "white";
                            document.getElementById("error_" + id_carga_academica).style.backgroundColor = "#cd4545";
                        } else if (calificacion >= 0 && calificacion < 70) {
                            cal_reprobatoria = true;
                            cal_rep++;
                            document.getElementById("error_" + id_carga_academica).style.color = "white";
                            document.getElementById("error_" + id_carga_academica).style.backgroundColor = "#f3a333";
                            if ($("#opcion" + id_carga_academica).val() == 0 || $("#opcion" + id_carga_academica).val() == null) {
                                opcion = true;
                                document.getElementById("cont" + id_carga_academica).style.color = "white";
                                $("#opcion" + id_carga_academica).css("color", "black");
                                $("#canaliza" + id_carga_academica).css("color", "black");
                                document.getElementById("cont" + id_carga_academica).style.backgroundColor = "#cd4545";
                                $("#cont" + id_carga_academica).show()
                            } else if ($("#opcion" + id_carga_academica).val() == 3 && $("#otro" + id_carga_academica).val() == "") {
                                $("#otro" + id_carga_academica).show();
                                otro = true;
                                document.getElementById("cont" + id_carga_academica).style.color = "white";
                                document.getElementById("cont" + id_carga_academica).style.backgroundColor = "#cd4545";
                                $("#otro" + id_carga_academica).css("color", "black");

                            } else {
                                document.getElementById("cont" + id_carga_academica).style.color = "black";
                                document.getElementById("cont" + id_carga_academica).style.backgroundColor = "white";
                            }
                            //  console.log((uni_na + 1) / total_unidades)
                            //console.log($("#canaliza" + id_carga_academica).val())
                            if ((uni_na + 1) / total_unidades >= 0.4 && $("#canaliza" + id_carga_academica).val() == null) {
                                canaliza_ban = true;
                                $("#canaliza" + id_carga_academica).show();

                            }


                        }
                        calificaciones.alumno.push({
                            "id_carga_academica": id_carga_academica,
                            "calificacion": calificacion,
                            "id_unidad": id_unidad,
                            "opcion": valopcion,
                            "otro": valotro,
                            "canaliza": canaliza,
                        });
                    }
                });
                var data_cal = JSON.stringify(calificaciones);
                if (cal_noValida || opcion || otro||canaliza_ban) {
                    console.log(cal_noValida+"--"+opcion+"--"+otro+"--"+canaliza_ban)
                    swal({
                        type: "error",
                        title: cal_noValida ? "Existen calificaciones erroneas" : "Falta información",
                        text: cal_noValida ? 'las calificaciones erroneas estan marcadas en rojo' : opcion ? "Elige un opción por la cual no se acreditó la unidad y de ser necesario canalización" : "Agrega el valor por el cual no se acreditó la unidad",
                        showConfirmButton: true,
                    });
                } else {
                    if (cal_reprobatoria) {
                        //pide confirmacion
                        Swal({
                            title: 'Ingreso ' + (cal_rep == 1 ? '' + cal_rep + ' calificación reprobatoria' : '' + cal_rep + ' calificaciones reprobatorias'),
                            html: "¿Esta seguro que desea continuar?<br> <h6>Ingresa las sugerencias de acciones preventivas para disminuir los índices de reprobación.</h6>",
                            type: 'warning',
                            input: 'textarea',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, continuar',
                            cancelButtonText: 'Cancelar',
                            inputValidator: (value) => {
                                if (!value) {
                                    return 'Ingresa las acciones preventivas!'
                                }
                            }
                        }).then((result) => {
                            // console.log(result)

                            if (result.value) {
                                $("#guardar_calificacion").attr("disabled", true);
                                $.post('/docente/acciones/{{ $id_docente }}/{{ $id_materia }}/{{ $id_grupo }}/' + id_unidad + '/insert_calificacion', {
                                    _token: token,
                                    calificaciones: data_cal,
                                    acciones: result.value
                                }, function (request) {
                                    swal({
                                        type: "success",
                                        title: "Registro exitoso",
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(function (result) {
                                        location.reload(true);
                                    });
                                });
                            }

                        })
                    } else {
                        $("#guardar_calificacion").attr("disabled", true);
                        $.post('/docente/acciones/{{ $id_docente }}/{{ $id_materia }}/{{ $id_grupo }}/' + id_unidad + '/insert_calificacion', {
                            _token: token,
                            calificaciones: data_cal
                        }, function (request) {
                            swal({
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function (result) {
                                location.reload(true);
                            });
                        });

                    }
                }
            });
        });
    </script>
@endsection

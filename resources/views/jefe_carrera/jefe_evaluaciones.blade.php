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
    @if(!isset($alumnos))
        <div class="row col-md-12">
            <div class="col-md-5 col-md-offset-4">
                <label class=" alert alert-danger text-center"  data-toggle="tab" ><h3>No hay alumnos inscritos en esta materia
                    </h3></label>
            </div>
        </div>
    @else
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel">
                <div class="panel-body">
                    <div class="row col-md-12">
                        <label for="" class="col-md-12 text-center">{{$nom_carrera}}</label>
                        <h4><label for="" class="col-md-4 col-md-offset-4 text-center label label-success">{{$nom_docente}}</label></h4>
                        <label for="" class="col-md-6 text-left">
                            Materia: {{$mat->nombre}}
                            <br>
                            Grupo: {{$grupo}}
                        </label>
                        <label for="" class="col-md-6 text-right">
                            Clave: {{$mat->clave}}
                            <br>
                            No. Unidades: {{$mat->unidades}}
                        </label>
                        <label for="" class="col-md-12 text-right">
                            <button type="button" class="btn btn-success center" onclick="window.open('{{url('genera_listas', ['id_docente' => $id_docente,'id_materia' => $id_materia,'id_grupo' => $id_grupo,'unidades' => $unidades])}}')">Lista de asistencia</button>
                            <input type="{{ ($habilitaPDF==1 ? 'button' : 'hidden') }}" class="btn btn-primary tooltip-options " id="cal_duales" name="cal_duales" data-toggle="tooltip" data-placement="top" title="Terminar_calificar duales" target="_blank" value="Terminar de calificar duales">
                            <input type="{{ $esc_pormateria ? 'hidden' : ($habilitaPDF==2 ? 'button' : 'hidden') }}" class="btn btn-primary tooltip-options link" id="link_genera_pdf" name="link_genera_pdf" data-toggle="tooltip" data-placement="top" title="Generar acta de calificaciones" target="_blank" value="Acta Ordinaria">
                            <input type="{{ $esc_pormateria ? 'hidden' : ($habilitaPDF==2 ? 'button' : 'hidden') }}" class="btn btn-info tooltip-options link" id="link_genera_pdf_jc" name="link_genera_pdf_jc" data-toggle="tooltip" data-placement="top" title="Generar acta de calificaciones" target="_blank" value="Acta Ordinaria con nuevo responsable">
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
                                                            <th rowspan="2" class="text-center" style="display: table-cell;vertical-align: middle;"></th>
																<th rowspan="2" class="text-center" style="display: table-cell;vertical-align: middle;">NP</th>
																<th rowspan="2" class="text-center" style="display: table-cell;vertical-align: middle;">No. CTA</th>
																<th rowspan="2" class="text-center" style="display: table-cell;vertical-align: middle;">NOMBRE DEL ALUMNO</th>
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
                        <?php  $porcentaje_gen=0; $cont_gen=0;?>
                        @foreach($alumnos as $alumno)
                            <tr class="text-center">
                                @if($alumno['estado_validacion'] == 9)
                                    <td class="text-center" style="background: #0089ec;">A. Dual--></td>
                                @else
                                    <td ></td>
                                @endif
                                @if($alumno['estado_validacion'] == 9)
                                    <td class="text-center" style="background: #0089ec;">{{$alumno['np']}}</td>
                                    @else
                                <td class="text-center">{{$alumno['np']}}</td>
                                @endif
                                <td class="text-center" style=" {!! $alumno['curso']=='REPETICION' ? 'background:#ffee62; color:orange' : ($alumno['curso']=='ESPECIAL' ? 'background:#a94442; color:white' : '') !!} "> {{$alumno['cuenta']}}</td>
                                    @if($alumno['estado_validacion'] == 9)
                                        <td class="text-left" style="background: #0089ec;">{{$alumno['nombre']}}</td>
                                    @else
                                        <td class="text-left">{{$alumno['nombre']}}</td>
                                    @endif

                                <?php  $cont=0; $id_unidad_res=0; $evalPrevia=false;$evalPreviabtn=false;?>
                                @forelse($alumno['calificaciones'] as $calificacion)
                                    <?php  $cont++; $id_unidad_res=($calificacion['id_unidad'] !=0 ? $calificacion['id_unidad'] : "0")?>
                                    @if(($cont)<=$unidades)
                                        @if( ($cont)==$calificacion['id_unidad'])
                                            <td style="background: {{ $calificacion['calificacion']>=70 ? ' ' : '#FFEE62' }}" data-id-eval="{{ $calificacion['id_evaluacion'] }}" data-id-unidad="{{ $calificacion['id_unidad'] }}">
                                                {{ $calificacion['calificacion']>=70 ? $calificacion['calificacion'] : 'N.A'  }}
                                                {!! $calificacion['modificado']==1 ? '<span class="oi oi-info tooltip-options link" style="background:#bf5329;border-radius: 100%; color:white; padding:5px; font-size: 7px" data-toggle="tooltip" data-placement="top" title="La calificación fue modificada"></span>' : ''  !!}
                                                <?php $evalPrevia=true; $evalPreviabtn=true;?>
                                            </td>
                                        @else

                                        @endif
                                    @else

                                    @endif
                                @empty

                                @endforelse
                                <?php  $unidades_restantes=$unidades-$cont; ?>
                                @for ($i = 1; $i <= $unidades_restantes; $i++)
                                    @if( empty($uni_asignadas[$i-1]))

                                        <td>0</td>
                                    @else
                                        @if(isset($uni_asignadas[$cont]))
                                            <?php $dia = date("d"); $mes = date("m"); $anio = date("Y");$dia_v=date("d",strtotime((date("d-m-Y", strtotime($uni_asignadas[$evalPrevia ? ($cont) :($i-1) ]->{'fecha'} )))."+ 0 days"));$mes_v=date("m",strtotime((date("d-m-Y", strtotime($uni_asignadas[$evalPrevia ? ($cont) :($i-1) ]->{'fecha'} )))."+ 0 days"));$anio_v=date("Y",strtotime((date("d-m-Y", strtotime($uni_asignadas[$evalPrevia ? ($cont) :($i-1) ]->{'fecha'} )))."+ 0 days"));?>
                                            @if($anio<=$anio_v)
                                                @if($mes<=$mes_v)
                                                    @if($dia<=$dia_v || $mes<$mes_v)
                                                        @if($alumno['baja'] == 1)
                                                                <td style="background:yellow;">N.A</td>
                                                         @else
                                                        @if($id_unidad_res+$i==1)
                                                            <td class="text-center"><input id="error_{{$alumno['id_carga_academica']}}" type="text" value="0" class=" text-center calificacion_{{$id_unidad_res+$i}}" style="width:7em; border-radius: 4px" data-id="{{$alumno['id_carga_academica']}}" name="calificacion_{{$id_unidad_res+$i}}" {{$alumno['especial_bloq']==1 ? 'disabled':''}}></td>
                                                        @else
                                                            @if($evalPrevia)
                                                                <td class="text-center"><input id="error_{{$alumno['id_carga_academica']}}" type="text" value="0" class=" text-center calificacion_{{$id_unidad_res+$i}}" style="width:7em; border-radius: 4px" data-id="{{$alumno['id_carga_academica']}}" name="calificacion_{{$id_unidad_res+$i}}" {{$alumno['especial_bloq']==1 ? 'disabled':''}}></td>
                                                                <?php $evalPrevia=false;?>
                                                            @else
                                                                        @if($alumno['baja'] == 1)
                                                                            <td style="background:yellow;">N.A</td>
                                                                        @else
                                                                            <td>0</td>
                                                                        @endif
                                                            @endif
                                                        @endif
                                                            @endif
                                                    @else
                                                            @if($alumno['baja'] == 1)
                                                                <td style="background:yellow;">N.A</td>
                                                            @else
                                                                <td>0</td>
                                                            @endif
                                                    @endif
                                                @else
                                                        @if($alumno['baja'] == 1)
                                                            <td style="background:yellow;">N.A</td>
                                                        @else
                                                        <td>0</td>
                                                            @endif
                                                @endif
                                            @else

                                                    @if($alumno['baja'] == 1)
                                                        <td style="background:yellow;">N.A</td>
                                                    @else
                                                        <td>0</td>
                                                    @endif
                                            @endif
                                        @else

                                                @if($alumno['baja'] == 1)
                                                    <td style="background:yellow;">N.A</td>
                                                @else
                                                    <td>0</td>
                                                @endif
                                        @endif
                                    @endif
                                @endfor
                                <?php  $porcentaje_gen+=$alumno['promedio']>=70 ? '1' : '0'; $cont_gen++;?>
                                    @if($alumno['estado_validacion'] == 10)
                                        <td style="background: #a94442; ">BAJA</td>
                                        @else
                                @if($alumno['promedio']>=70 )
                                    <td style="background:white; " >{{ $alumno['promedio'] }}</td>
                                @else
                                    <td style="background: #a94442; ">{{$alumno['promedio']}}</td>
                                @endif
                                    @endif
                                    <td>{!! $alumno['curso']=='NORMAL' && $alumno['esc_alumno'] ? 'ESC'  : ( $alumno['curso']=='NORMAL' ? 'O'  : ($alumno['curso']=='REPETICION' && $alumno['esc_alumno'] ? 'ESC2' : ($alumno['curso']=='REPETICION' ? 'O2' : ($alumno['curso']=='ESPECIAL' ? 'CE' : ($alumno['curso']=='GLOBAL' ? 'EG': '' )))))!!}</td>
                           @if($habilitaPDF==1)
                                        @if($alumno['estado_validacion'] == 9)
                                            <td class="text-center"><input style="width: 7em" type="button" class="btn btn-primary calificar_dual" data-id_carga="{{$alumno['id_carga_academica']}}"   value="Calificar"></td>
                                        @endif
                               @endif
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="{{4+$cont}}"></td>
                            <?php  $unidades_restantes=$unidades-$cont; ?>
                            @for ($i = 1; $i <= $unidades_restantes; $i++)
                                @if( empty($uni_asignadas[$i-1]))
                                @else
                                    @if(isset($uni_asignadas[$cont]))
                                        <?php $dia = date("d"); $mes = date("m"); $anio = date("Y");$dia_v=date("d",strtotime((date("d-m-Y", strtotime($uni_asignadas[$evalPreviabtn ? ($cont) :($i-1) ]->{'fecha'} )))."+ 0 days"));$mes_v=date("m",strtotime((date("d-m-Y", strtotime($uni_asignadas[$evalPreviabtn ? ($cont) :($i-1) ]->{'fecha'} )))."+ 0 days"));$anio_v=date("Y",strtotime((date("d-m-Y", strtotime($uni_asignadas[$evalPreviabtn ? ($cont) :($i-1) ]->{'fecha'} )))."+ 0 days"));?>
                                        @if($anio<=$anio_v)
                                            @if($mes<=$mes_v)
                                                @if($dia<=$dia_v || $mes<$mes_v)
                                                    @if($id_unidad_res+$i==1)
                                                        <td class="text-center" ><input style="width: 7em" type="button" class="btn btn-primary tooltip-options link" id="guardar_cal" name="guardar_cal" data-token="{{ csrf_token() }}" data-id_unidad="{{$id_unidad_res+$i}}" data-toggle="tooltip" data-placement="top" title="La fecha limite para evaluar la unidad es {{ $dia_v }}-{{ $mes_v }}-{{ $anio_v }}" value="guardar" ></td>
                                                    @else
                                                        @if($evalPreviabtn)
                                                            <td class="text-center"><input style="width: 7em" type="button" class="btn btn-primary tooltip-options link" id="guardar_cal" name="guardar_cal" data-token="{{ csrf_token() }}" data-id_unidad="{{$id_unidad_res+$i}}" data-toggle="tooltip" data-placement="top" title="La fecha limite para evaluar la unidad es {{ $dia_v }}-{{ $mes_v }}-{{ $anio_v }}" value="guardar"></td>
                                                            <?php $evalPreviabtn=false;?>
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
                            <td colspan="4"></td>
                            @foreach($porcentajes as $porcentaje)
                                <td class="text-center" style="background: {{ $porcentaje['porcentaje']>=70 ? '#3c763d' : '#a94442' }}; color: #ffffff">{{ round($porcentaje['porcentaje'],2) }}%</td>
                            @endforeach

                            <td class="text-center" style="background: {{ $imp_porcentaje>=70 ? '#3c763d' : '#a94442' }}; color: #ffffff">{{ round($imp_porcentaje,2) }}%</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade" id="modal_calificar_duales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="calificar_duales" class="form" action="{{url("/registrar_cal_duales/")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Calificar a estudiante dual</h4>
                    </div>
                    <div id="contenedor_cal_duales">

                    </div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button  id="calificacion_duales" type="button"   class="btn btn-primary " >Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="modal_termino_calificar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="" method="POST" role="form" id="form_termino_calificar">
                    {{ csrf_field() }}
                <div class="modal-body">

                        ¿Ya se termino de evaluar a los estudiantes duales?
                </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input id="confirma_termino" type="button" class="btn btn-danger" value="Aceptar"></input>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal adeudo en los departamentos -->
    <div class="modal fade" id="modal_adeudo"  role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
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
    <script type="text/javascript">
        $(document).ready(function()
        {
            var mostrar_mensaje = "<?php echo $mostrar_mensaje  ?>";
            if(mostrar_mensaje == 1){
                $('#modal_mensaje').modal('show');
            }

            var estado_reprobado = "<?php echo $estado_reprobado  ?>";
            if(estado_reprobado == 1){

                $('#modal_adeudo').modal('show');
                $('#modal_adeudo').modal({backdrop: 'static', keyboard: false});
            }
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


            $("#link_genera_pdf").click(function(event) {
                var link="/generar_pdf?id_docente="+ {{ $id_docente }} +"&id_materia="+ {{ $id_materia }} +"&unidades="+ {{ $unidades }}+"&id_grupo="+ {{ $id_grupo }}+"";
                window.open(link);
            });
            $("#link_genera_pdf_jc").click(function(event) {
                var link="/generar_pdf/jc?id_docente="+ {{ $id_docente }} +"&id_materia="+ {{ $id_materia }} +"&unidades="+ {{ $unidades }}+"&id_grupo="+ {{ $id_grupo }}+"&nomjefe={{ Session::get('nombre') }}";
                window.open(link);
            });
            $("#cal_duales").click(function(event) {

                $('#modal_termino_calificar').modal('show');
            });
            $("#calificacion_duales").click(function(event){
                $("#calificacion_duales").attr("disabled", true);
                $("#calificar_duales").submit();
            });
            $("#confirma_termino").click(function(event){
                $("#confirma_termino").attr("disabled", true);
                var id_materia="{{ $id_materia }}";
                var id_grupo="{{ $id_grupo }}";
                $("#form_termino_calificar").attr("action","/termino/evaluacion/dual/"+id_materia+"/"+id_grupo)
                $("#form_termino_calificar").submit();
            });
            $(".calificar_dual").click(function(event) {
                var id_carga_academica=$(this).data("id_carga");
                //alert(id_carga_academica);
                $.get("/calificar_duales/"+id_carga_academica,function (request) {
                    $("#contenedor_cal_duales").html(request);
                    $("#modal_calificar_duales").modal('show');
                });
            });

            $("#guardar_cal").click(function ()
            {
                var calificaciones= { alumno:[] };
                var id_unidad=$(this).data("id_unidad");
                var token=$(this).data("token");
                cal_noValida=false;
                cal_reprobatoria=false;
                var cal_rep=0;
                $(".calificacion_"+id_unidad).each(function () {
                    var id_carga_academica=$(this).data("id");
                    var calificacion=$(this).val();
                    document.getElementById("error_"+id_carga_academica).style.backgroundColor = "white";
                    document.getElementById("error_"+id_carga_academica).style.color = "black";
                    if(calificacion<0 || calificacion>100 || !/^([0-9])*$/.test(calificacion))
                    {
                        cal_noValida=true;
                        document.getElementById("error_"+id_carga_academica).style.color = "white";
                        document.getElementById("error_"+id_carga_academica).style.backgroundColor = "#cd4545";
                    }
                    else if(calificacion>=0 && calificacion<70)
                    {
                        cal_reprobatoria=true;
                        cal_rep++;
                        document.getElementById("error_"+id_carga_academica).style.color = "white";
                        document.getElementById("error_"+id_carga_academica).style.backgroundColor = "#f3a333";
                    }
                    calificaciones.alumno.push({
                        "id_carga_academica" : id_carga_academica,
                        "calificacion" : calificacion,
                        "id_unidad" : id_unidad
                    });
                });
                var data_cal = JSON.stringify(calificaciones);
                if(cal_noValida)
                {
                    swal({
                        type: "error",
                        title: "Existen calificaciones erroneas",
                        text: 'las calificaciones erroneas estan marcadas en rojo',
                        showConfirmButton: true,
                    });
                }
                else
                {
                    if(cal_reprobatoria)
                    {
                        //pide confirmacion
                        Swal({
                            title: 'Ingreso '+(cal_rep==1 ? ''+cal_rep+' calificación reprobatoria': ''+cal_rep+' calificaciones reprobatorias'),
                            text: "¿Esta seguro que desea continuar?",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, continuar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.value) {
                                $("#guardar_cal").attr("disabled", true);
                                $.post('/docente/acciones/{{ $id_docente }}/{{ $id_materia }}/{{ $id_grupo }}/'+id_unidad+'/insert_calificacion',{_token:token,calificaciones:data_cal},function(request)
                                {
                                    swal({
                                        type: "success",
                                        title: "Registro exitoso",
                                        showConfirmButton: false,
                                        timer: 1500
                                    }). then(function(result)
                                    {
                                        location.reload(true);
                                    });
                                });
                            }
                        })
                    }
                    else
                    {
                        $("#guardar_cal").attr("disabled", true);
                        $.post('/docente/acciones/{{ $id_docente }}/{{ $id_materia }}/{{ $id_grupo }}/'+id_unidad+'/insert_calificacion',{_token:token,calificaciones:data_cal},function(request)
                        {
                            swal({
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 1500
                            }). then(function(result)
                            {
                                location.reload(true);
                            });
                        });
                    }
                }
            });
        });
    </script>
@endsection

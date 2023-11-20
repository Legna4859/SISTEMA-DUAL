@extends('layouts.app')
@section('title', 'Evaluaciones Sumativas')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">EVALUACIÓN SUMATIVA DE COMPLEMENTACIÓN</h3>
                </div>
            </div>
        </div>
    </div>
    @if(!isset($nom_materia))
        <div class="row col-md-12">
            <div class="col-md-5 col-md-offset-4">
                <label class=" alert alert-danger text-center"  data-toggle="tab" ><h3>No hay alumnos inscritos en esta materia
                    </h3></label>
            </div>
        </div>
    @elseif($habilitaPDF==1)
        <div class="row col-md-12">
            <div class="col-md-5 col-md-offset-4">
                <label class=" alert alert-danger text-center"  data-toggle="tab" ><h3>No ha terminado de calificar a los estudiantes duales
                    </h3></label>
            </div>
        </div>
    @else
        @if($calificar_sumativa->sumativa == 0)
        <div class="row col-md-12">
            <div class="col-md-6 col-md-offset-3">
                <label class=" alert alert-danger text-center"  data-toggle="tab" ><h5>Antes de registrar calificaciones de sumativas imprimir la Acta ordinaria.
                    </h5></label>
            </div>
        </div>
        @endif
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
                            @if($calificar_sumativa->sumativa == 0)
                            @else
                                <input type="button" class="btn btn-primary tooltip-options link" id="link_genera_pdf" name="link_genera_pdf" data-token="{{ csrf_token() }}" data-toggle="tooltip" data-placement="top" title="Generar acta de calificaciones" target="_blank" value="Imprimir PDF">

                            @endif
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
                                <?php  $cont=0;?>
                                @forelse($alumno['calificaciones'] as $calificacion)
                                    <?php  $cont++;?>
                                    @if(($cont)<=$unidades)
                                        @if( ($cont)==$calificacion['id_unidad'])

                                            @if($alumno['especial_bloq']==1)
                                                <td style="background: #FFEE62;">N.A</td>
                                            @else
                                                @if($esc_pormateria)
                                                    <td style="background: {{ $calificacion['calificacion']>=70 ? ' ' : '#FFEE62' }}">{{$calificacion['calificacion'] >= 70 ? $calificacion['calificacion'] : "N.A"}}</td>
                                                @else
                                                    @if($calificacion['calificacion']<70 && $calificacion['esc'])
                                                        <td><input id="error_{{$calificacion['id_evaluacion']}}" type="text" class=" text-center calificacion_sumativa" value="{{$calificacion['calificacion']}}" style="width:7em; border-radius: 4px; background: #fff48c;" data-id="{{$alumno['id_carga_academica']}}" data-id-unidad="{{ $calificacion['id_unidad'] }}" name="calificacion_sumativa" data-id-eval="{{ $calificacion['id_evaluacion'] }}"></td>
                                                    @else
                                                        <td style="background: {{ $calificacion['calificacion']>=70 ? ' ' : '#FFEE62' }}">{{$calificacion['calificacion']}}</td>
                                                    @endif
                                                @endif
                                            @endif
                                        @else

                                        @endif
                                    @else

                                    @endif
                                @empty


                                @endforelse
                                    @if($alumno['estado_validacion'] ==10)

                                        <?php $comparar=$unidades-1; ?>
                                        @if($cont == $comparar )
                                        @else
                                            @for($i=0; $i<=$comparar-$cont;$i++)
                                                <td style="background: #FFEE62;">N.A</td>
                                            @endfor
                                        @endif
                                        @endif
                                            <?php  $porcentaje_gen+=$alumno['repeticion'] == false ? '1' : '0'; $cont_gen++;?>
                                            @if($alumno['estado_validacion'] ==10)
                                                <td style="background: #a94442; ">BAJA</td>
                                            @else
                                                @if($alumno['promedio']>=70 and $alumno['repeticion'] == false)
                                                    <td style="background:white; " >{{ $alumno['promedio'] }}</td>
                                                @else
                                                    <td style="background: #a94442; ">N.A</td>
                                                @endif

                                              @endif
                                <td>{!! $alumno['curso']=='NORMAL' && $alumno['esc_alumno'] ? 'ESC'  : ( $alumno['curso']=='NORMAL' ? 'O'  : ($alumno['curso']=='REPETICION' && $alumno['esc_alumno'] ? 'ESC2' : ($alumno['curso']=='REPETICION' ? 'O2' : ($alumno['curso']=='ESPECIAL' ? 'CE' : ($alumno['curso']=='GLOBAL' ? 'EG': '' )))))!!}</td>
                            </tr>
                        @endforeach
                        <tr>
                            @if($calificar_sumativa->sumativa == 0)
                                <td colspan="{{4+$cont}}"></td>
                                <td class="text-center" ><input style="width: 7em" type="button" class="btn btn-primary tooltip-options link" id="guardar_cal" name="guardar_cal" data-token="{{ csrf_token() }}" data-id_unidad="unidades" data-toggle="tooltip" data-placement="top" title="Guardar evaluación sumativa" value="guardar" ></td>

                            @else
                                @endif
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
    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#link_genera_pdf").click(function(event) {
                var link="/generar_pdf_sumativas?id_docente="+ {{ $id_docente }} +"&id_materia="+ {{ $id_materia }} +"&unidades="+ {{ $unidades }}+"&id_grupo="+ {{ $id_grupo }}+"";
                window.open(link);
            });

            $("#guardar_cal").click(function ()
            {
                var calificaciones= { alumno:[] };
                var token=$(this).data("token");
                cal_noValida=false;
                cal_reprobatoria=false;
                var cal_rep=0;
                $(".calificacion_sumativa").each(function () {
                    var id_carga_academica=$(this).data("id");
                    var calificacion=$(this).val();
                    var id_unidad=$(this).data("id-unidad");
                    var id_eval=$(this).data("id-eval");
                    document.getElementById("error_"+id_eval).style.backgroundColor = "white";
                    document.getElementById("error_"+id_eval).style.color = "black";
                    if(calificacion<0 || calificacion>100 || !/^([0-9])*$/.test(calificacion))
                    {
                        cal_noValida=true;
                        document.getElementById("error_"+id_eval).style.color = "white";
                        document.getElementById("error_"+id_eval).style.backgroundColor = "#cd4545";
                    }
                    else if(calificacion>=0 && calificacion<70)
                    {
                        cal_reprobatoria=true;
                        cal_rep++;
                        document.getElementById("error_"+id_eval).style.color = "white";
                        document.getElementById("error_"+id_eval).style.backgroundColor = "#f3a333";
                    }
                    calificaciones.alumno.push({
                        "id_eval" : id_eval,
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
                                $.post('/docente/acciones/{{ $id_docente }}/{{ $id_materia }}/{{ $id_grupo }}/sumativas',{_token:token,calificaciones:data_cal},function(request)
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
                        $.post('/docente/acciones/{{ $id_docente }}/{{ $id_materia }}/{{ $id_grupo }}/sumativas',{_token:token,calificaciones:data_cal},function(request)
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

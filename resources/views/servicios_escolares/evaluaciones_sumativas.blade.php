@extends('layouts.app')
@section('title', 'Calificaciones')
@section('content')
    @if($estado_sumativa ==0)
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-2" style="text-align: center;">
                                <a    href="{{url('/servicios_escolares/evaluaciones/'.$id_carrera)}}"><span class="glyphicon glyphicon-arrow-left" style="font-size:15px;color:#363636"></span><br>Regresar</a>
                            </div>
                            <div class="col-md-4 col-md-offset-1 " style="text-align: center;">
                                <h3 class="panel-title text-center">CALIFICACIONES SUMATIVAS</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
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
                    </div>
                </div>
            </div>
        </div>
        </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">No se han registrado calificaciones de sumativas</h3>
                </div>
            </div>
        </div>
    </div>

    @else
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-2" style="text-align: center;">
                                <a    href="{{url('/servicios_escolares/evaluaciones/'.$id_carrera)}}"><span class="glyphicon glyphicon-arrow-left" style="font-size:15px;color:#363636"></span><br>Regresar</a>
                            </div>
                            <div class="col-md-4 col-md-offset-1 " style="text-align: center;">
                                <h3 class="panel-title text-center">CALIFICACIONES SUMATIVAS</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-8">
                <a href="/generar_excel/acta_sumativa/{{ $id_docente }}/{{ $id_materia }}/{{ $id_grupo }}" class="btn btn-success" target="_blank"><span class="glyphicon glyphicon-print"  aria-hidden="true"></span>Exportar a excel</a>
            </div>
        </div>
        <div class="row">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <div class="panel">
                    <div class="panel-body">
                        <table class="table table-striped col-md-12">
                            <thead class="">
                            <tr class="text-center">
                                <th class="text-center"></th>
                                <th class="text-center">NP.</th>
                                <th class="text-center">No. CTA</th>
                                <th class="text-center">ALUMNO</th>
                                @for ($i = 0; $i < $mat->unidades; $i++)
                                    <th class="text-center">UNIDAD
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
                                <th class="text-center">ACCIONES</th>
                            </tr>
                            <tbody>
                            <?php  $porcentaje_gen=0; $cont_gen=0;?>
                            @foreach($alumnos as $alumno)
                                <tr class="text-center">
                                    @if($alumno['estado_validacion'] == 9)
                                        <td class="text-center" style="background: #0089ec;">Dual--></td>
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
                                    <?php  $cont=0; ?>
                                    @forelse($alumno['calificaciones'] as $calificacion)
                                        <?php  $cont++; ?>
                                        @if(($cont)<=$mat->unidades)
                                            @if( ($cont)==$calificacion['id_unidad'])
                                                <td style="background: {{ $calificacion['calificacion']>=70 ? ' ' : '#FFEE62' }}" data-id-eval="{{ $calificacion['id_evaluacion'] }}" data-id-unidad="{{ $calificacion['id_unidad'] }}">
                                                    {{ $calificacion['calificacion']>=70 ? $calificacion['calificacion'] : 'N.A'  }}
                                                    {!! $calificacion['modificado']==1 ? '<span class="oi oi-info tooltip-options link" style="background:#bf5329;border-radius: 100%; color:white; padding:5px; font-size: 7px" data-toggle="tooltip" data-placement="top" title="La calificación fue modificada"></span>' : ''  !!}
                                                </td>
                                            @else

                                            @endif
                                        @else

                                        @endif
                                    @empty

                                    @endforelse
                                    <?php  $unidades_restantes=$mat->unidades-$cont; ?>
                                    @for ($i = 0; $i < $unidades_restantes; $i++)
                                        @if($alumno['baja'] == 1)
                                            <td style="background:yellow;">N.A</td>
                                        @else
                                            <td>0</td>
                                        @endif
                                    @endfor
                                    @if($alumno['estado_validacion'] == 10)
                                        <td style="background: #a94442; ">BAJA</td>
                                    @else

                                        <td style="background: {{ $alumno['sumativa'] == false ? '' : '#a94442;color:white;' }}">{{  $alumno['sumativa'] == false ? $alumno['promedio'] : 'N.A' }}</td>
                                    @endif
                                    <td>{!! $alumno['curso']=='NORMAL' && $alumno['esc_alumno'] ? 'ESC'  : ( $alumno['curso']=='NORMAL' ? 'O'  : ($alumno['curso']=='REPETICION' && $alumno['esc_alumno'] ? 'ESC2' : ($alumno['curso']=='REPETICION' ? 'O2' : ($alumno['curso']=='ESPECIAL' ? 'CE' : ($alumno['curso']=='GLOBAL' ? 'EG': '' )))))!!}</td>
                                    <td><span data-toggle="modal" data-target="#modifica_cal_{{$alumno['cuenta']}}"><a href="#!" class="btn btn-primary tooltip-options link" data-token="{{ csrf_token() }}" data-toggle="tooltip" data-placement="top" title="Modificar calificaciones"><span class="glyphicon glyphicon-pencil"></span></a></span></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4"></td>
                                @foreach($porcentajes as $porcentaje)
                                    <td class="text-center" style="background: {{ $porcentaje['porcentaje']>=70 ? '#3c763d' : '#a94442' }}; color: #ffffff">{{round( $porcentaje['porcentaje'],2) }}%</td>
                                @endforeach

                                <td class="text-center" style="background: {{ $imp_porcentaje>=70 ? '#3c763d' : '#a94442' }}; color: #ffffff">{{  round($imp_porcentaje,2) }} %</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                @foreach($alumnos as $alumno)
                    <div class="modal fade" id="modifica_cal_{{$alumno['cuenta']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Modificar Calificación</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group text-center">
                                        <label class="text-right">Alumno: {{ $alumno['nombre'] }}</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha_inicio" class="col-form-label">Seleccionar calificación que desea modificar:</label>
                                        <select class="form-control" name="calificacion{{$alumno['cuenta']}}" id="calificacion{{$alumno['cuenta']}}">
                                            @forelse($alumno['calificaciones'] as $calificacion)
                                                <option data-calificacion="{{$calificacion['calificacion']}}" value="{{ $calificacion['id_evaluacion'] }}">Unidad {{ $calificacion['id_unidad'] }} / Calificación = {{ $calificacion['calificacion'] }} </option>
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="fecha_inicio" class="col-form-label">Ingrese la nueva calificación:</label>
                                        <input type="text" class="form-control" id="cal_update{{$alumno['cuenta']}}" name="cal_update{{$alumno['cuenta']}}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary h-secondary_m" data-dismiss="modal">Cancelar</button>
                                    <button type="" class="btn btn-primary h-primary_m" name="modifica_calificacion{{$alumno['cuenta']}}" id="modifica_calificacion{{$alumno['cuenta']}}">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function()
            {
                @foreach($alumnos as $alumno)
                $("#modifica_calificacion{{$alumno['cuenta']}}").on("click",function()
                {
                   // alert('hola');
                    //aqui modifica
                    var docente="{{$nom_docente}}";
                    var id_materia="{{$id_materia}}";
                    var id_evaluacion=$("#calificacion{{$alumno['cuenta']}}").val();
                    var cal_anterior=$("#calificacion{{$alumno['cuenta']}}").children('option:selected').data("calificacion");
                    var calificacion=$("#cal_update{{$alumno['cuenta']}}").val();
                    if(cal_anterior==calificacion)
                    {
                        swal({
                            position:"",
                            type: "error",
                            title: "Error",
                            text: 'Esta intentando guardar la misma calificación',
                            showConfirmButton: true,
                        });
                    }
                    else if(calificacion<0 || calificacion>100 || !/^([0-9])*$/.test(calificacion))
                    {
                        swal({
                            position:"",
                            type: "error",
                            title: "Error",
                            text: 'La calificación que intenta ingresar esta fuera del rango valido',
                            showConfirmButton: true,
                        });
                    }
                    /*
										condicion para no permitir que se modifique de aprobatoria a reprobatoria
										else if(cal_anterior>=70 && calificacion<70)
                    {
                        swal({
                            position:"",
                            type: "error",
                            title: "Error",
                            text: 'No puede colocar calificación reprobatoria, cuando previamente ya ha sido aprobado',
                            showConfirmButton: true,
                        });
                    }*/
                    else if(calificacion>0 && calificacion<70)
                    {
                        Swal({
                            title: 'Ingreso una calificación reprobatoria',
                            text: "¿Esta seguro que desea continuar?",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, continuar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.value) {
                                $.get('/servicios_escolares/modificaCalificacionSumativa',{id_evaluacion:id_evaluacion,calificacion:calificacion,id_materia:id_materia,docente:docente},function(request)
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
                        $.get('/servicios_escolares/modificaCalificacionSumativa',{id_evaluacion:id_evaluacion,calificacion:calificacion,id_materia:id_materia,docente:docente},function(request)
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
                });
                @endforeach
            });
        </script>
    @endif

    @endsection
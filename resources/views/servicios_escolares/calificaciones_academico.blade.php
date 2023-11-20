@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">CALIFICACIONES</h3>
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
    @else
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel">
                <div class="panel-body">
                    <div class="row col-md-12">
                        <label for="" class="col-md-12 text-center">{{$nom_carrera}}</label>
                        <h4><label for="" class="col-md-4 col-md-offset-4 text-center label label-success">{{$nom_docente}}</label></h4>
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
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel">
                <div class="panel-body">
                    <table class="table table-striped col-md-12">
                        <thead class="">
                        <tr class="text-center">
                            <th class="text-center">NP.</th>
                            <th class="text-center">No. CTA</th>
                            <th class="text-center">ALUMNO</th>
                            @for ($i = 0; $i < $unidades; $i++)
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
                        </tr>
                        <tbody>
                        <?php  $porcentaje_gen=0; $cont_gen=0;?>
                        @foreach($alumnos as $alumno)
                            <tr class="text-center">
                                <td class="text-center">{{$alumno['np']}}</td>
                                <td class="text-center" style=" {!! $alumno['curso']=='REPETICION' ? 'background:#ffee62; color:orange' : ($alumno['curso']=='ESPECIAL' ? 'background:#a94442; color:white' : '') !!} "> {{$alumno['cuenta']}}</td>
                                <td class="text-left">{{$alumno['nombre']}}</td>
                                <?php  $cont=0; ?>
                                @forelse($alumno['calificaciones'] as $calificacion)
                                    <?php  $cont++; ?>
                                    @if(($cont)<=$unidades)
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
                                <?php  $unidades_restantes=$unidades-$cont; ?>
                                @for ($i = 0; $i < $unidades_restantes; $i++)
                                    <td>0</td>
                                @endfor
                                <?php  $porcentaje_gen+=$alumno['promedio']>=70 ? '1' : '0'; $cont_gen++;?>
                                <td style="background: {{ $alumno['promedio']>=70 ? '' : '#a94442;color:white;' }}">{{ $alumno['promedio'] }}</td>
                                <td>{!! $alumno['curso']=='NORMAL' && $alumno['esc_alumno'] ? 'ESC'  : ( $alumno['curso']=='NORMAL' ? 'O'  : ($alumno['curso']=='REPETICION' && $alumno['esc_alumno'] ? 'ESC2' : ($alumno['curso']=='REPETICION' ? 'O2' : ($alumno['curso']=='ESPECIAL' ? 'CE' : ($alumno['curso']=='GLOBAL' ? 'EG': '' )))))!!}</td>
                                 </tr>
                        @endforeach
                        <tr>
                            <td colspan="3"></td>
                            @foreach($porcentajes as $porcentaje)
                                <td class="text-center" style="background: {{ $porcentaje['porcentaje']>=70 ? '#3c763d' : '#a94442' }}; color: #ffffff">{{ $porcentaje['porcentaje'] }}%</td>
                            @endforeach
                            <?php  $imp_porcentaje=(($porcentaje_gen*100)/$cont_gen);?>
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

        });
    </script>
@endsection

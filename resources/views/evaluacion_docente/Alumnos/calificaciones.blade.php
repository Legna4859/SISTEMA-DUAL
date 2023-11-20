@extends('layouts.app')
@section('title', 'Calificaciones')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Calificaciones</h3>
                </div>
            </div>
        </div>
    </div>
    @if($estado_validacion_carga->estado == 0)
        <div class="text-center">
            <div class="col-md-6 col-md-offset-3">
                <label class=" alert alert-danger"  data-toggle="tab" >Aun no has dado de alta tu carga academica!
                </label>
            </div>
        </div>
      @else
        @if($estado_residencia == 1)
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-success">
                    <div class="panel-body">
                <table class="table text-center col-md-12">
                    <thead  >
                    <tr>
                        <th class="text-center ">NOMBRE</th>
                        <th class="text-center">PROMEDIO RESIDENCIA O ESTADO</th>
                    </tr>
                    </thead>
                <tbody>
                <tr class="text-center">
                    <td class="text-center" style="text-align: center">RESIDENCIA</td>
                        @if($proceso == 1)
                        <td class="text-center" style="text-align: center">PROCESO DE REGISTRO DE AUTORIZACIÓN DE ANTEPROYECTO</td>
                        @endif
                    @if($proceso == 2)
                        <td class="text-center" style="text-align: center">PROCESO DE SEGUIMIENTO DE RESIDENCIA</td>
                    @endif
                    @if($proceso == 3)
                        <td class="text-center" style="text-align: center">{{ $cal_residencia }}</td>
                    @endif
                </tr>
                </tbody>

                </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            @if($array_materias!=null)
            <div class="col-md-12">
                <table class="table text-center col-md-12">
                    <thead class="bg-info" >
                    <tr style="border: 2px solid #3097d1">
                        <th class="text-center ">MATERIA</th>
                        @for ($i = 0; $i < $mayor_unidades; $i++)
                            <th class="text-center">
                                {{($i==0 ? 'I' : ($i==1 ? 'II' :($i==2 ? 'III' :($i==3 ? 'IV' :($i==4 ? 'V' :($i==5 ? 'VI' :($i==6 ? 'VII' :($i==7 ? 'VIII' :($i==8 ? 'IX' :($i==9 ? 'X' :($i==10 ? 'XI' :($i==11 ? 'XII' :($i==12 ? 'XIII' :($i==13 ? 'XIV' :($i==14 ? 'XV' : ' ' )))))))))))))))}}
                            </th>
                        @endfor
                        <th class="text-center">PROMEDIO</th>
                        <th class="text-center"> T.E.</th>
                    </tr>
                    </thead>
                    <tbody style="border: 2px solid #3097d1">
                    <?php $promedio_sum=0; $num_materias=0;?>
                    @foreach($array_materias as $materias)
                        <?php $cont_res=0;?>
                        <tr>
                            <th class="text-center">{{ $materias['materia'] }}</th>
                            @foreach($materias['calificaciones'] as $calificaciones)
                                @if($calificaciones != null)
                                    <td style="background: {{ $calificaciones['calificacion']>=70 ? ' ' : '#FFEE62' }}">
                                        {{ $calificaciones['calificacion']>=70 ? $calificaciones['calificacion'] : 'N.A'  }}
                                    </td>
                                    <?php $cont_res++; ?>
                                @else
                                @endif
                            @endforeach
                            @for ($i = 0; $i < ($mayor_unidades-$cont_res); $i++)
                                @if($materias['unidades'] <= ($cont_res+$i) )
                                    <td class="bg-info"></td>
                                @else
                                    <td>0</td>
                                @endif
                            @endfor
                            <td style="background: {{ $materias['promedio']>=70 ? '' : '#a94442;color:white;' }}">{{ $materias['promedio']>=70 ?  $materias['promedio'] : 'N.A' }}</td>
                            <?php $materias['promedio'] !=0 ? $promedio_sum+=$materias['promedio']  : 0 ; $num_materias++; ?>
                            <td>{!! $materias['curso']=='NORMAL' && $materias['esc_alumno'] ? 'ESC'  : ( $materias['curso']=='NORMAL' ? 'O'  : ($materias['curso']=='REPETICION' && $materias['esc_alumno'] ? 'ESC2' : ($materias['curso']=='REPETICION' ? 'O2' : ($materias['curso']=='ESPECIAL' ? 'CE' : ($materias['curso']=='GLOBAL' ? 'EG': '' )))))!!}</td>
                        </tr>
                    @endforeach
                        <tr>
                            <td colspan="1" ></td>
                            <td colspan="{{$mayor_unidades}}" class="text-center"><strong>PROMEDIO</strong></td>
                            <?php $promedio=$promedio_sum/($num_materias==0 ? 1 : $num_materias) ?>
                            <td>{{ $pro=number_format($promedio, 2, '.', '') }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <table class="table table-striped col-md-12">
                    <thead class="bg-info" >
                    <tr style="border: 2px solid #3097d1">
                        <th class="col-md-4 ">DOCENTE</th>
                        <th class="col-md-7 ">MATERIA</th>
                        <th class="col-md-1 ">GRUPO</th>
                    </tr>
                    </thead>
                    <tbody style="border: 2px solid #3097d1">
                    @foreach($profesores as $profesor)
                        <tr>
                        <td>{{$profesor->nombre}}</td>
                        <td>{{$profesor->materias}}</td>
                        <td>{{$profesor->id_semestre}}0{{$profesor->grupo}}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
    @endif

@endsection

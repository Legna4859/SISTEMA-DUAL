@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')

    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">CONCENTRADO DE CALIFICACIONES DUALES</h3>
                    <h3 class="panel-title text-center">MATERIA: {{ $materia_seleccionada[0]->materias }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-xs-10 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Concentrado de Calificaciones Completo</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-xs-10 col-md-offset-2">
            <table class="table table-bordered col-md-12">
                <thead class="">
                <tr class="text-center info">
                    <th class="text-center" >CLAVE</th>
                    <th class="text-center" >PROFESOR</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    @foreach($materia_seleccionada as $mate)
                        <td style="text-align:center">{{ $mate->clave }}</td>
                    @endforeach
                    @foreach($datos as $dato)
                        <td style="text-align:center">{{ $dato->titulo . " " . $dato->profesor }}</td>
                    @endforeach
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel">
                <div class="panel-body">
                    <table class="table table-bordered col-md-12">
                        <thead class="">
                        <tr class="text-center info">
                            <th class="text-center">NP.</th>
                            <th class="text-center">No. CTA</th>
                            <th class="text-center">ALUMNO</th>
                            <th class="text-center">PROMEDIO MATERIA</th>
                            <th class="text-center">PROMEDIO GENERAL</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($alumnos as $alumno)
                            <tr>
                                <td style="text-align:center">{{ $loop->iteration }}</td>
                                <td style="text-align:center">{{ $alumno->cuenta }}</td>
                                <td style="text-align:center">{{ $alumno->nombre . " " . $alumno->apaterno . " " . $alumno->amaterno }}</td>
                                @php
                                    $promedio_alumno = 0;
                                    $promedio_general = 0; // Asegúrate de definir $promedio_general
                                    $bajas = 0;
                                @endphp
                                @foreach($array_materias as $materias)
                                    <td style="text-align: center;background: {{ $materias['promedio'] >= 70 ? '' : '#a94442;color:white;' }}">
                                        {{ $materias['promedio'] >= 70 ? $materias['promedio'] : 'N.A' }}
                                    </td>
                                    @php
                                        $promedio_alumno += $materias['promedio'];
                                    @endphp
                                @endforeach
                                <td style="text-align: center;background: {{ $promedio_alumno / count($array_materias) >= 70 ? '' : '#a94442;color:white;' }}">
                                    {{ number_format($promedio_alumno / count($array_materias), 2, '.', '') }}
                                </td>
                            </tr>
                        @endforeach
                        <?php
                        $numero_materia=0;
                        $creditos_finales=0;
                        $total_creditos_grupo=0;
                        $total_aprobados_grupo=0;
                        ?>
                        <tr>
                            <td colspan="3" class="text-right" >
                                Meta Real
                            </td>
                            @foreach($com as $califi)
                                <td class="text-center" >
                                        <?php
                                        $numero_materia++;
                                        $creditos_finales+=$califi['creditos'];
                                        ?>

                                    @if($califi['aprobados']==0)
                                        0%
                                    @else
                                            <?php
                                            $meta_real=($califi['aprobados']*100)/$califi['total'];
                                            $meta_real=number_format($meta_real, 2, '.', ' ');
                                            ?>
                                        {{ $meta_real }}%
                                    @endif

                                </td>
                            @endforeach

                            <td style="text-align: center">
                                @if($numero_alumno != 0)
                                        <?php
                                        $indice_final_aprobacion = ($numero_promedio_aprobado * 100) / $numero_alumno;
                                        $indice_final_aprobacion = number_format($indice_final_aprobacion, 2, '.', ' ');
                                        ?>
                                    {{ $indice_final_aprobacion }}%
                                @else
                                    0%
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right" >
                                Alumnos Que Cursan La Materia
                            </td>
                            @foreach($com as $califi)
                                <td class="text-center" >
                                    {{$califi['total']}}
                                </td>

                            @endforeach
                            <td style="text-align: center">{{ $numero_alumno }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right" >
                                Alumnos Aprobados
                            </td>
                            @foreach($com as $califi)
                                <td class="text-center" >
                                    {{$califi['aprobados']}}
                                </td>

                            @endforeach
                            <td style="text-align: center">{{ $numero_promedio_aprobado }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right" >
                                Alumnos Reprobados
                            </td>
                            @foreach($com as $califi)
                                <td class="text-center" >
                                    {{$califi['reprobados']}}
                                </td>

                            @endforeach
                            <td style="text-align: center">{{ $numero_promedio_reprobado }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right" >
                                Indice de Reprobación
                            </td>
                            @foreach($com as $califi)
                                <td class="text-center" >
                                    @if($califi['reprobados']==0)
                                        0%
                                    @else
                                            <?php $indice_r=($califi['reprobados']*100)/$califi['total'];
                                            $indice_r=number_format($indice_r, 2, '.', ' ');?>
                                        {{ $indice_r }}%
                                    @endif
                                </td>

                            @endforeach
                            <td style="text-align: center">
                                @if($numero_alumno != 0)
                                        <?php
                                        $indice_final_reprobacion = ($numero_promedio_reprobado * 100) / $numero_alumno;
                                        $indice_final_reprobacion = number_format($indice_final_reprobacion, 2, '.', ' ');
                                        ?>
                                    {{ $indice_final_reprobacion }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right" >
                                Promedio De La Materia
                            </td>
                            @foreach($com as $califi)
                                <td class="text-center" >
                                    @if($califi['total']==0)
                                        0.00
                                    @else
                                            <?php $promedio=($califi['suma_promedios'])/$califi['total'];
                                            $promedio=number_format($promedio, 2, '.', ' '); ?>
                                        {{ $promedio }}
                                    @endif
                                </td>

                            @endforeach
                            <td style="text-align: center">
                                @if($promedio==0)
                                    0.00
                                @else
                                        <?php  $pro_f=$promedio;
                                        $pro_f=number_format($pro_f, 2, '.', ' ');?>
                                    {{$pro_f}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right" >
                                Alumnos Baja
                            </td>
                            @foreach($com as $califi)
                                <td class="text-center" >
                                    {{$califi['bajas']}}
                                </td>
                            @endforeach
                            <td style="text-align: center"> {{ $bajas }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right" >
                                Indice de Deserción
                            </td>
                            @foreach($com as $califi)
                                <td class="text-center" >
                                    @if($califi['bajas']==0)
                                        0%
                                    @else
                                            <?php $indice_desercion=($califi['bajas']*100)/($califi['total']+$califi['bajas']);
                                            $indice_desercion=number_format($indice_desercion, 2, '.', ' ');?>
                                        {{ $indice_desercion }}%
                                    @endif
                                </td>

                            @endforeach
                            <td style="text-align: center">
                                @if($bajas ==0)
                                    0.00 %
                                @else
                                        <?php  $total_al=$numero_alumno+$bajas;
                                        $indice_desercion_final=($bajas*100)/$total_al;
                                        $indice_desercion_final=number_format($indice_desercion_final, 2, '.', ' ');?>
                                    {{ $indice_desercion_final }} %
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right">
                                Créditos por Materia
                            </td>
                            @foreach($com as $califi)
                                <td class="text-center">
                                    @if(is_numeric($califi['creditos']))
                                        {{ $califi['creditos'] }}
                                    @else
                                        <!-- Manejo del caso en que la variable no es numérica -->
                                        {{ $califi['creditos'] }}
                                    @endif
                                </td>

                            @endforeach
                            <td style="text-align: center">{{ is_numeric($creditos_finales) ? $creditos_finales : '' }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right">
                                Total De Créditos Cursados En La Materia
                            </td>
                            @foreach($com as $califi)
                                <td class="text-center">
                                    @php
                                        $total_creditos = is_numeric($califi['creditos']) ? $califi['creditos'] * $califi['total'] : 0;
                                        $total_creditos_grupo += $total_creditos;
                                    @endphp
                                    {{ $total_creditos }}
                                </td>

                            @endforeach
                            <td style="text-align: center">{{ $total_creditos_grupo }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right">
                                Total De Créditos Aprobados
                            </td>
                            @foreach($com as $califi)
                                <td class="text-center">
                                    @php
                                        $total_creditos_a = is_numeric($califi['creditos']) ? $califi['creditos'] * $califi['aprobados'] : 0;
                                        $total_aprobados_grupo += $total_creditos_a;
                                    @endphp
                                    {{ $total_creditos_a }}
                                </td>
                            @endforeach
                            <td style="text-align: center">{{ $total_aprobados_grupo }}</td>
                        </tr>
                        <!-- ... Resto de tu código ... -->

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="padding: 1.0em">
        <div class="col-md-10 col-xs-10 col-md-offset-5">
            @foreach($array_materias as $materia)
                <a href="{{ url('/duales/exportar_concentrado/'. $materia['id_materia']) }}" class="btn btn-warning" style="color:black">
                    Exportar Concentrado <span class="oi oi-document p-1"></span>
                </a>
            @endforeach
        </div>
</div>


@endsection

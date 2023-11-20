<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $mat->nombre }}</title>
</head>
<body>
<?php
$mes=strftime("%B");
if ($mes=="January") $mes="Enero";
if ($mes=="February") $mes="Febrero";
if ($mes=="March") $mes="Marzo";
if ($mes=="April") $mes="Abril";
if ($mes=="May") $mes="Mayo";
if ($mes=="June") $mes="Junio";
if ($mes=="July") $mes="Julio";
if ($mes=="August") $mes="Agosto";
if ($mes=="September") $mes="Septiembre";
if ($mes=="October") $mes="Octubre";
if ($mes=="November") $mes="Noviembre";
if ($mes=="December") $mes="Diciembre";
$fecha_actual = strftime("%d")." ".$mes." ".strftime("%Y");
?>
<img src="img/edom.png" alt="" width="25%">
<img src="img/logo3.PNG" alt="" width="30%" style="margin-left: 44%;">
    <h5 style="text-align: center; background: #cccccc;margin-top:1%">ACTA DE CALIFICACIONES ORDINARIAS</h5>
    <h6 style="margin-top: -30px">
        <br>CARRERA: {{ $nom_carrera }}
        <br>ASIGNATURA: {{ $mat->nombre }}
        <br>CLAVE: {{ $mat->clave }}
        <br>PROFESOR: {{  $profesor->titulo }} {{  $profesor->nombre }}
    </h6>
    <div style="text-align: right; margin-top: -100px">
        <h6 style="margin-left: 500px; background: #cccccc; text-align: center">GRUPO: {{ $grupos }} </h6>
        <h6 style="margin-left: 500px;text-align:center;margin-top:-25px">
            SEMESTRE {{ $periodoAct }}
            <br>
            {{$fecha_actual}}
        </h6>
    </div>



    <div class="col-md-12 col-xs-10 col-md-offset-1">
        <div class="panel">
            <div class="panel-body">
                <table style="font-size: 11px;  text-align: center;" cellspacing="0" cellpadding="0">
                    <thead style="background: #CCCCCC;">
                    <tr>
                        <th rowspan="2" style="border:1px solid black; width: 13px">NP</th>
                        <th rowspan="2" style="border:1px solid black">No. CTA</th>
                        <th rowspan="2" style="border:1px solid black; font-size: 11px;">ALUMNO</th>
												<th colspan="{{ $unidades+2 }}" style="border:1px solid black">UNIDADES</th>
										</tr>
										<tr>
												@for ($i = 0; $i < $unidades; $i++)
                            <th style="border:1px solid black; font-size: 14px;">
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
                        <th style="border:1px solid black">PROMEDIO</th>
                        <th style="border:1px solid black; font-size: 11px;" >T.E.</th>
                    </tr>
                    <tbody>
                    <?php  $porcentaje_gen=0; $cont_gen=0;?>
                    @foreach($alumnos as $alumno)
                        <tr class="text-center" style=" font-size: 11px;">
                            <td style="border: 1px solid black">{{$alumno['np']}}</td>
                            <td style="border: 1px solid black; {!! $alumno['curso']=='REPETICION' ? 'background:#ffee62; color:orange' : ($alumno['curso']=='ESPECIAL' ? 'background:#a94442; color:white' : '') !!}">{{$alumno['cuenta']}}</td>
                            @if($alumno['estado_validacion'] ==9)
                                <td style="background:#b2b6fd ; border: 1px solid black;text-align: left;padding-left:2%;">{{$alumno['nombre']}}</td>
                                @else
                                @if($alumno['carrera']== 1)
                                    <td style="border: 1px solid black;text-align: left;padding-left:2%;">{{$alumno['nombre']}}</td>


                                @else
                                    <td style="background: lightgray; border: 1px solid black;text-align: left;padding-left:2%;">{{$alumno['nombre']}}</td>

                                @endif    @endif

                            <?php  $cont=0; $id_unidad_res=0; $evalPrevia=false;$evalPreviabtn=false;?>
                            @forelse($alumno['calificaciones'] as $calificacion)
                                <?php  $cont++; $id_unidad_res=($calificacion['id_unidad'] !=0 ? $calificacion['id_unidad'] : "0")?>
                                @if(($cont)<=$unidades)
                                    @if( ($cont)==$calificacion['id_unidad'])
                                        <td style="border: 1px solid black; background: {{ $calificacion['calificacion']>=70 ? ' ' : '#FFEE62' }}" data-id-eval="{{ $calificacion['id_evaluacion'] }}" data-id-unidad="{{ $calificacion['id_unidad'] }}">
                                            {{ $calificacion['calificacion']>=70 ? $calificacion['calificacion'] : 'N.A.'  }}
                                         </td>
                                    @else
                                    @endif
                                @else

                                @endif
                            @empty

                            @endforelse

                            <?php  $unidades_restantes=$unidades-$cont; ?>
                            @for ($i = 1; $i <= $unidades_restantes; $i++)
                                <td style="background: #FFEE62;border: 1px solid black ">N.A.</td>
                            @endfor
                            <?php  $porcentaje_gen+=$alumno['promedio']>=70 ? '1' : '0'; $cont_gen++;?>
                            @if($alumno['estado_validacion'] ==10)
                                <td style="background: #a94442;border: 1px solid black ">BAJA</td>
                                @else

                            @if($alumno['promedio']>=70)
                                <td style="background:white; border: 1px solid black " >{{ $alumno['promedio'] }}</td>
                            @else
                                <td style="background: #a94442;border: 1px solid black ">{{$alumno['promedio']}}</td>
                            @endif
                            @endif
                                <td style="border: 1px solid black">{!! $alumno['curso']=='NORMAL' && $alumno['esc_alumno'] ? 'ESC'  : ( $alumno['curso']=='NORMAL' ? 'O'  : ($alumno['curso']=='REPETICION' && $alumno['esc_alumno'] ? 'ESC2' : ($alumno['curso']=='REPETICION' ? 'O2' : ($alumno['curso']=='ESPECIAL' ? 'CE' : ($alumno['curso']=='GLOBAL' ? 'EG': '' )))))!!}</td>

                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3"></td>
                        @foreach($porcentajes as $porcentaje)
                            <td style="border: 1px solid black;background: {{ $porcentaje['porcentaje']>=70 ? '#3c763d' : '#a94442' }}; color: #ffffff">{{ round($porcentaje['porcentaje'],2) }}%</td>
                        @endforeach

                        <td style="border: 1px solid black; font-size: 11px; background: {{ $imp_porcentaje>=70 ? '#3c763d' : '#a94442' }}; color: #ffffff">{{ round($imp_porcentaje,2) }}%</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <hr style="text-align:center;margin-top:10%;width: 30%">
            <h6 style="text-align:center;margin-top:0%;">{{  $profesor->titulo }} {{  $profesor->nombre }}</h6>
        </div>
    </div>
</body>
</html>

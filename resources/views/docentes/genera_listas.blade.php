<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista PDF</title>
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
<h5 style="text-align: center; background: #cccccc;margin-top:1%">LISTA DE ASISTENCIA</h5>
<h6 style="margin-top: -30px">
    <br>CARRERA: {{ $nom_carrera }}
    <br>ASIGNATURA: {{ $mat->nombre }}
    <br>CLAVE: {{ $mat->clave }}
    <br>PROFESOR: {{  $profesor->titulo }} {{  $profesor->nombre }}
</h6>
<div style="text-align: right; margin-top: -100px">
    <h6 style="margin-left: 500px; background: #cccccc; text-align: center">GRUPO: {{ $grupo }} </h6>
    <h6 style="margin-left: 500px;text-align:center;margin-top:-25px">
        SEMESTRE: {{ $periodoAct }}
        <br>
        {{$fecha_actual}}
    </h6>
</div>
<div class="col-md-12 col-xs-10 col-md-offset-1">
    <div class="panel">
        <div class="panel-body">
            <table style="font-size: 10px; text-align: center;" cellspacing="0" cellpadding="0">
                <thead style="background: #CCCCCC;">
                <tr>
                    <th rowspan="2" style="border:1px solid black;width:20px;">NP</th>
                    <th rowspan="2" style="border:1px solid black;width:60px">No. CTA</th>
                    <th rowspan="2" style="border:1px solid black; width:150px"  >NOMBRE DEL ALUMNO</th>
                    <th colspan="31" style="border:1px solid black;width:12px;font-size:7px">MES DE: ________________________________________</th>
                </tr>
                <tr>
                    @for ($i = 1; $i <= 31; $i++)
                        <th style="border:1px solid black;width:12px;font-size:7px">
                            {{ $i }}
                        </th>
                    @endfor
                </tr>
                <tbody>
                @foreach($alumnos as $alumno)
                    <tr class="text-center">
                        <td style="border: 1px solid black;">{{$alumno['np']}}</td>
                        <td style="border: 1px solid black; {!! $alumno['curso']=='REPETICION' ? 'background:#ffee62; color:orange' : ($alumno['curso']=='ESPECIAL' ? 'background:#a94442; color:white' : '') !!}">{{$alumno['cuenta']}}</td>
                        @if($alumno['estado_validacion']== 9 and $alumno['carrera']== 1 )
                            <td style=" background: #a3b0c9; border: 1px solid black;text-align: left;padding-left:2%;">{{$alumno['nombre']}}</td>

                        @else
                            @if($alumno['carrera']== 1)
                                <td style="border: 1px solid black;text-align: left;padding-left:2%;">{{$alumno['nombre']}}</td>


                            @else
                                   <td style="background: lightgray; border: 1px solid black;text-align: left;padding-left:2%;">{{$alumno['nombre']}}</td>

                            @endif

                            @endif
                        @for ($i = 1; $i <= 31; $i++)
                            @if($alumno['estado_validacion']== 9)
                                <th style="background:#a3b0c9 ;border:1px solid black;">
                            @else
                                @if($alumno['carrera']== 1)
                            <th style=" border:1px solid black;">
                                @else
                                    <th style="background: lightgray; border:1px solid black;">
                                @endif
                            </th>
                            @endif
                        @endfor
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <hr style="text-align:center;margin-top:10%;width: 30%">
        <h6 style="text-align:center;margin-top:0%;">{{  $profesor->titulo }} {{  $profesor->nombre }}</h6>
    </div>
</div>
</body>
</html>

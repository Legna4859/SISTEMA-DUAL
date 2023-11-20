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
    <br>CARRERA: {{ $nombre_periodo->carrera }}
</h6>
<h6 style="margin-top: -30px">
    <br>
    GRUPO: {{ $datos_grupo->grup }} </h6>

<h6 style="margin-top: -30px">
    <br>
        SEMESTRE: {{ $nombre_periodo->periodo }}
</h6>
    <h6 style="margin-top: -30px">
        <br>
        {{$fecha_actual}}
    </h6>


<div class="col-md-12 ">
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
                <?php $np=1; ?>
                @foreach($estudiantes as $estudiante)
                    <tr class="text-center">
                        <td style="border: 1px solid black;">{{ $np++ }}</td>
                        <td style="border: 1px solid black;  color: black">{{$estudiante->cuenta}}</td>
                        <td style=" border: 1px solid black; text-align: left;padding-left:2%;">{{$estudiante->apaterno}} {{$estudiante->amaterno}} {{$estudiante->nombre}}</td>





                        @for ($i = 1; $i <= 31; $i++)

                                <th style="border:1px solid black;">
                                @endfor
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
</body>
</html>

@extends('layouts.app')
@section('title', 'Servicios Escolares')
@section('content')
    <?php $hoy = date("Y-m-d");?>
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">

                        <div class="col-md-2" style="text-align: center;">
                            <a    href="{{url('/servicios_escolares/evaluaciones/'.$id_carrera)}}"><span class="glyphicon glyphicon-arrow-left" style="font-size:15px;color:#363636"></span><br>Regresar</a>
                        </div>
                        <div class="col-md-4 col-md-offset-1 " style="text-align: center;">
                            <h3 class="panel-title text-center">PERIODOS PARA EVALUAR UNIDADES</h3>
                        </div>

                    </div>

                </div>
                <div class="panel-body">
                    <div class="row col-md-12">
                        <label for="" class="col-md-12 text-center">{{$nom_carrera}}</label>
                        <h4><label for="" class="col-md-4 col-md-offset-4 text-center label label-success">{{$nom_docente}}</label></h4>
                        <label for="" class="col-md-6 text-left">
                            Materia: {{ $tot_unidades->nombre }}
                            <br>
                            Grupo: {{$grupo}}
                        </label>
                        <label for="" class="col-md-6 text-right">
                            Clave: {{ $tot_unidades->clave }}
                            <br>
                            No. Unidades: {{ $tot_unidades->unidades }}
                        </label>
                    </div>
                    <br><br><br><br>
                    <hr style="border: 1px solid black"/>
                    <div class="row col-md-12">
                        <table class="table text-center my-0 border-table">
                            <thead>
                            <tr class="text-center">
                                <th class="text-center">Unidad</th>
                                <th class="text-center">Fecha de evaluación</th>
                                <th class="text-center">Estado</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($array_perio as $periodo)
                                <tr>
                                    <td> <strong>UNIDAD {{($periodo['id_unidad']==1 ? 'I' :
                                                ($periodo['id_unidad']==2 ? 'II' :
                                                    ($periodo['id_unidad']==3 ? 'III' :
                                                        ($periodo['id_unidad']==4 ? 'IV' :
                                                            ($periodo['id_unidad']==5 ? 'V' :
                                                                ($periodo['id_unidad']==6 ? 'VI' :
                                                                    ($periodo['id_unidad']==7 ? 'VII' :
                                                                        ($periodo['id_unidad']==8 ? 'VIII' :
                                                                            ($periodo['id_unidad']==9 ? 'IX' :
                                                                                ($periodo['id_unidad']==10 ? 'X' :
                                                                                    ($periodo['id_unidad']==11 ? 'XI' :
                                                                                        ($periodo['id_unidad']==12 ? 'XII' :
                                                                                            ($periodo['id_unidad']==13 ? 'XIII' :
                                                                                                ($periodo['id_unidad']==14 ? 'XIV' :
                                                                                                    ($periodo['id_unidad']==15 ? 'XV' : ' ' )))))))))))))))}}
                                        </strong></td>

                                    @if($periodo['status']==1)
                                        <?php  $fecha_periodo=date("d-m-Y ",strtotime($periodo['fecha'])) ?>
                                        <td><strong>{{$fecha_periodo}} </strong>{!! $hoy==$periodo['fecha'] ? '<span class="oi oi-info tooltip-options link" style="background:#bf5329;border-radius: 100%; color:white; padding:5px;" data-toggle="tooltip" data-placement="top" title="La fecha para registrar calificaciones finaliza hoy"></span>' : ''  !!} </td>

                                        @if($periodo['evaluada']==1)
                                            <td><a href="#!" class="btn btn-success tooltip-options link" data-toggle="tooltip" data-placement="top" title="Evaluación realizada"><span class="oi oi-check p-1"></span></a></td>
                                        @elseif($periodo['evaluada']==0)
                                            <td><a href="#!" class="btn btn-danger text-white tooltip-options link" data-toggle="tooltip" data-placement="top" title="Evaluación pendiente"><span class="oi oi-clock"></span></a></td>
                                        @endif
                                    @else
                                        <td class="text-center"><strong>No asignado</strong></td>
                                        <td><a href="#!" class="btn btn-warning text-white tooltip-options link" data-toggle="tooltip" data-placement="top" title="Aun no se ha asignado la fecha de evaluación"><span class="oi oi-warning p-1"></span></a></td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
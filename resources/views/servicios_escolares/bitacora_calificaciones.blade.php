@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">EVALUACIONES MODIFICADAS</h3>
                </div>
                <div class="panel-body">
                    <table class="table text-center my-0 border-table">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">Docente</th>
                                <th class="text-center">Materia</th>
                                <th class="text-center">Unidad</th>
                                <th class="text-center">Calificación modificada</th>
                                <th class="text-center">Calificación actual</th>
                            </tr>
                        </thead>
												<tbody>
												@foreach($array_evaluaciones as $bt_evaluaciones)
														<tr>
																<td>{{$bt_evaluaciones->{'docente'} }}</td>
																<td>{{$bt_evaluaciones->{'materia'} }}</td>
																<td>Unidad {{$bt_evaluaciones->{'unidad'} }}</td>
																<td>{{$bt_evaluaciones->{'cal_antigua'} }}</td>
																<td>{{$bt_evaluaciones->{'cal_nueva'} }}</td>
														</tr>
														@endforeach
												</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

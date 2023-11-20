@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Calificaciones de Ingles')
@section('content')
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><b>Calificaciones del Periodo {{$periodo->periodo_ingles}}</b></h3>
                    </div>
                </div>
            </div>
	</div>
	@if($estado_calificacion_ingles == 0)
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><b>¡¡¡No hay calificaciones en este periodo!!!</b></h3>
                    </div>
                </div>
            </div>
			
		</div>
	@else
	<div class="row">	
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<table id="table_calificacion" class="table table-bordered text-center" style="table-layout:fixed;">
                    <thead>
                    <tr>
                        <th style="text-align: center; color: black;">Skill</th>
                        <th style="text-align: center; color: black;">Grade</th>
                    </tr>
                    </thead>
                    <tbody>
                    	<?php $promedio=0 ?>
                    @foreach($ver_estado_cal as $ver_estado_calicacion)
                        <tr>
                        	<?php $promedio=$promedio+$ver_estado_calicacion->calificacion ?>
                        	@if($ver_estado_calicacion->id_unidad == 1)
                        	<td style="color:black;">Speaking</td>
                        	@if($ver_estado_calicacion->calificacion<80)
                        	<td style="background:crimson;color: white;">{{$ver_estado_calicacion->calificacion}}</td>
                        	@else
                        	<td><b>{{$ver_estado_calicacion->calificacion}}</b></td>
                        	@endif
                        	@elseif($ver_estado_calicacion->id_unidad == 2)
                        	<td style="color:black;">Writing</td>
                        	@if($ver_estado_calicacion->calificacion<80)
                        	<td style="background:crimson;color: white;">{{$ver_estado_calicacion->calificacion}}</td>
                        	@else
                        	<td><b>{{$ver_estado_calicacion->calificacion}}</b></td>
                        	@endif
                        	@elseif($ver_estado_calicacion->id_unidad == 3)
                        	<td style="color:black;">Reading</td>
                        	@if($ver_estado_calicacion->calificacion<80)
                        	<td style="background:crimson;color: white;">{{$ver_estado_calicacion->calificacion}}</td>
                        	@else
                        	<td><b>{{$ver_estado_calicacion->calificacion}}</b></td>
                        	@endif
                        	@elseif($ver_estado_calicacion->id_unidad == 4)
                        	<td style="color:black;">Listening</td>
                        	@if($ver_estado_calicacion->calificacion<80)
                        	<td style="background:crimson;color: white;">{{$ver_estado_calicacion->calificacion}}</td>
                        	@else
                        	<td><b>{{$ver_estado_calicacion->calificacion}}</b></td>
                        	@endif
                        	@endif
                        </tr>
                    @endforeach
                    <tr><td style="color:black;"><b>Promedio General</b></td><td><b>{{round($promedio/4)}}</b></td></tr>
                    </tbody>
                </table>
			</div>
            <div class="row">
    <div class="col-md-2 col-md-offset-4">
        <div style="padding: 1.5em;">
                <div class="d-grid gap-2 d-md-flex" style="size: 25px; margin-top: 1.5em; margin-bottom: 1.5em; align-items: center; display: flex; justify-content: center">
                        <button type="button" class="btn" style="background-color: green; position:absolute;left: 40%;width:250px; height:50px; border-radius: 2em"
                             onclick="window.open('{{url('/ingles/imprimir_calificacion_ingles_alumno/'.$alumnoscal->id_alumno)}}')">
                                <strong style="color:white;"><b>Imprimir Boleta</b></strong>
                        </button>
                </div>
        </div>  
    </div>
</div>
	@endif
</div>

@endsection

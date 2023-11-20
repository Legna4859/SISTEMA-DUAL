@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">PROMEDIOS DE LOS ALUMNOS POR PERIODO <br> {{$nombre_carrera}}</h3>
                    <h5 class="panel-title text-center">(SEMESTRES)</h5>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        @foreach($grupos as $grupo)
            <div class="col-md-4 col-md-offset-1">
                <div class="panel panel-success">
                    <div class="panel-heading" style="text-align: center"><h3>SEMESTRE <br>{{$grupo->descripcion}}</h3><br><button type="button" class="btn btn-info" onclick="window.open('{{ url('/servicios_escolares/promedio_alumno_grupo/'.$id_carrera."/".$grupo->id_semestre ) }}')">Mostrar Alumnos </button></div>
                </div>
            </div>
        @endforeach

    </div>

@endsection
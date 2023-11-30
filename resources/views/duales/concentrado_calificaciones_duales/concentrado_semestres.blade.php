@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">CONCENTRADO DE CALIFICACIONES DUALES <br> {{$nombre_carrera}}</h3>
                    <h5 class="panel-title text-center">(SEMESTRES)</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    @foreach($grupos as $grupo)
            @if($grupo->id_semestre >= 6)
        <div class="col-md-4 col-md-offset-1">
            <div class="panel panel-warning">
                <div class="panel-heading" style="text-align: center">
                <h3>{{$grupo->id_semestre}}0{{$grupo->grupo}}</h3><br>
                <button type="button" class="btn" 
                onclick="window.open('{{ url('/duales/concentrado_calificaciones_duales/materias/'.$grupo->id_carrera."/".$grupo->id_semestre."/".$grupo->grupo ) }}')" 
                style="background:crimson;color:whitesmoke;border-radius: 35px;">
                Mostrar Materias <span class="glyphicon glyphicon-level-up"></span>
                </button>
            </div>
            </div>
        </div>
        @endif
        @endforeach

    </div>

@endsection
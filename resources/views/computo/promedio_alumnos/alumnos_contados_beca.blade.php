@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">PROMEDIO DE LOS ALUMNOS </h3>
                    <h5 class="panel-title text-center">CARRERA:{{ $carrera->nombre }}</h5>
                </div>
                <div class="panel-body">

                   <p>Total de alumnos con promedio mayor o igual 95 = {{  $contar_alumnos_100 }}</p>
                    <p>Total de alumnos con 90 a 94 sin sumativa = {{ $contar_alumnos_50_sin_s }}</p>
                    <p>Total de alumnos con mayor o igual a 95 con sumativa = {{ $contar_alumnos_50_con_s }}</p>
                    <h3>Total= {{$total}}</h3>
                </div>
            </div>
        </div>
    </div>
    <div>
    </div>
@endsection
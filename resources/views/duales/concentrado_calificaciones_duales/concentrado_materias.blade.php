@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
<div class="row">
    <div class="col-md-10 col-xs-10 col-md-offset-1">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title text-center">CONCENTRADO DE CALIFICACIONES DUALES <br>{{$nombre_carrera}} <br> {{$id_semestre}}0{{$grupo}}</h3>
                <h5 class="panel-title text-center">(MATERIAS)</h5>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-xs-10 col-md-offset-2">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title text-center">Concentrado de Calificaciones por Materia</h3>
            </div>
        </div>
    </div>
</div>


<div class="row">
                <div class="col-md-8 col-xs-10 col-md-offset-2">
                     <table class="table table-bordered col-md-12" >
                        <thead>
                        <tr class="info">
                            <th class="text-center">CLAVE</th>
                            <th class="text-center">MATERIA</th>
                            <th class="text-center">CONCENTRADO DE CALIFICACIONES</th>
                        </tr>
                        </tr>
                        </thead>
                        <tbody>

                      @foreach($array_materias as $materia)
    <tr class="text-center">
        <td>{{ $materia['clave'] }}</td>
        <td>{{ $materia['nombre'] }}</td>
        <td colspan="3">
            <a href="{{ url('/duales/concentrado_calificaciones_duales/concentrado_alumnos_materias/' . $materia['id_materia']) }}" class="btn btn-success">
                Concentrado de Calificaciones <span class="oi oi-book p-1"></span>
            </a>
        </td>
    </tr>
@endforeach


                        </tbody>
                    </table>
                </div>
            </div>

@endsection
@extends('tutorias.app_tutorias')
@section('content')


    <div class="row">
        <div class="col-10 offset-1">
            <div class="card bg-info text-white text-center">
                <h4 >Estudiantes sin registro</h4>
                <h4 >Carrera: {{ $carrera->nombre }}</h4>
                <h5>Tutor: {{ $tutor->nombre }}</h5>
                <h5>Semestre: {{ $tutor->semestre }}</h5>
            </div>

        </div>
    </div>
    <div class="row">
        <p></p>
    </div>
    <div class="row">
        <p></p>
    </div>
    <div class="row">
        <div class="col-10 offset-1">
    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>Nombre</th>
            <th>Numero de cuenta</th>
        </tr>
        @foreach ($alumnos_registro as $alumno)
            <tr>
                <td>{{$alumno->nombre}}</td>
                <td>{{$alumno->cuenta}}</td>
            </tr>
        @endforeach
    </table>
        </div>
    </div>

@endsection

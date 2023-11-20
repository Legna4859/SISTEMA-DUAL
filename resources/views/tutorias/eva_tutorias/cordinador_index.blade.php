@extends('tutorias.app_tutorias')
@section('content')


    <div class="row">
        <div class="col-10 offset-1">
            <div class="card bg-info text-white text-center">
                <h4 >Carrera: {{ $carrera->nombre }}</h4>
            </div>

        </div>
    </div>
    <div class="row">
        <p></p>
    </div>


    <div class="row">
        <div class="col-4 offset-1">
        <a  class="btn btn-success" href="{{url('/tutorias/evaluacion_tutor/exportar_exel_carrera_tutorias/'.$id_carrera.' ')}}">Exportar alumnos sin registro</a>
        </div>
        <!--div class="col-4 offset-1">
        <a  class="btn btn-success" href="{{url('/tutorias/evaluacion_tutor/exportar_exel_carrera_tutores/')}}">Exportar tutores sin registro</a>
        </div-->
    </div>
    <div class="row">
        <div class="col-4 offset-1">
            <p></p>
        </div>
    </div>
    <div class="row">
        <div class="col-10 offset-1">
    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>Grupo</th>
            <th>Nombre del Tutor</th>
            <th>Evaluación al tutor</th>
            <th>Estudiantes sin registro</th>
            <th>Autoevaluación</th>
            <th>Seguimiento al Desempeño</th>
        </tr>
        @foreach ($tutores as $tutor)
            <tr>
                <td>{{$tutor->grupo}}</td>
                <td>{{$tutor->nombre_tutor}}</td>
                @if(Session::get('estado_eva_f') == true)
                <th>
                    <a  class="btn btn-warning" href="{{url('/tutoras_evaluacion/resultado_tutorias_cordinador/evaluacion_tutor/'.$tutor->id_grupo_semestre.'/'.$tutor->grupo.'/ '.$tutor->carrera.'/ ')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16">
                            <path d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5v12h-2V2h2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z"/>
                        </svg>
                    </a>
                </th>
                @else
                    <th>
                        <a>El periodo, esta en evaluacion o no se ha registrado</a>
                    </th>
                @endif
                <th>
                    <a class="btn btn-light" href="{{url('/tutoras_evaluacion/resultado_tutorias_cordinador/registro_alumnos/'.$tutor->id_asigna_generacion.'/'.$id_carrera)}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
                        </svg>
                    </a>
                </th>
                <th>
                    <a class="btn btn-light" href="{{url('/tutorias_evaluacion/auto_eveluacion/grafica/'.$tutor->id_grupo_semestre.'/'.$tutor->grupo.'/ '.$tutor->carrera.'/')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
                        <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5H3z"/>
                        <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
                    </svg>
                    </a>
                </th>
                <th>
                    <a class="btn btn-light" href="{{url('/seguimiento_tutorias/formulario/'.$tutor->id_grupo_semestre.'/'.$tutor->grupo.'/ '.$tutor->carrera.'/')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-heading" viewBox="0 0 16 16">
                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                            <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z"/>
                        </svg>
                    </a>
                </th>
            </tr>
        @endforeach
    </table>
        </div>
    </div>
@endsection

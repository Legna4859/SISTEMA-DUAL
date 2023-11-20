@extends('tutorias.app_tutorias')
@section('content')
    <div class="row">
        <div class="col-10 offset-1">
            <div class="card bg-info text-white text-center">
                <h4 >Cuestionario al tutor</h4>
            </div>

        </div>
    </div>
    <p>

    </p>
    <div class="row">
        <div class="col-4 offset-1">
        <a  class="btn btn-success" href="{{url('/tutorias/evaluacion_tutor/exportar_exel_carrera_tutores/')}}">Exportar tutores sin registro</a>
        </div>
        <div class="col-4 offset-1">
        <a  class="btn btn-success" href="{{url('/tutorias/tutores_sin_registro')}}">Tutores sin registro</a>
        </div>
    </div>
    <p>

    </p>
    <div class="row">
        <div class="col-10 offset-1">
            <div class="card bg-info text-white text-center">
                <h4 >Programas de estudio</h4>
            </div>

        </div>
    </div>
    <div class="row">
        <p></p>
    </div>
    <div class="row">
        <div class="col-10 offset-1">


    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>Carrera</th>
            <th>Resultado</th>
        </tr>
        @foreach ($carreras as $carrera)
            <tr>
                <td>{{$carrera->nombre}}</td>
                <th>
                    <a  class="btn btn-info" href="{{url('/tutoras_evaluacion/resultado_tutorias_cordinador/carrera/'.$carrera->id_carrera.'/')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                        </svg>
                    </a>
                </th>
            </tr>
        @endforeach
    </table>
        </div>
    </div>
@endsection

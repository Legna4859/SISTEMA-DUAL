@extends('tutorias.app_tutorias')
@section('content')
    <div class="row">
        <div class="col-10 offset-1">
            <div class="card bg-info text-white text-center">
                <h3>Resultados de evaluación al tutor</h3>
            </div>

        </div>
    </div>
    <div class="row">
        <p></p>
    </div>
    <div class="row">
        <div class="col-12">
    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>Carrera</th>
            <th>Grupo</th>
            <th>Resultado</th>
        </tr>
        @foreach ($tutores as $tutor)
            <tr>
                <td>{{$tutor->carrera}}</td>
                <td>{{$tutor->grupo}}</td>
                <th>
                    @if(Session::get('estado_eva_f') == true)
                        <a  class="btn btn-warning" href="{{url('/tutoras_evaluacion/resultado_grafica/'.$tutor->id_grupo_semestre.'/ ')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16">
                                <path d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5v12h-2V2h2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z"/>
                            </svg>
                        </a>
                    @else
                        <a>El periodo esta en evaluacion o no se ha registrado</a>
                    @endif
                </th>
            </tr>
        @endforeach
    </table>
        </div>
    </div>
@endsection

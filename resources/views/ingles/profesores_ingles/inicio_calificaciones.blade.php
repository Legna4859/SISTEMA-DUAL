@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Calificaciones de ingles')
@section('content')
    <main class="col-md-12">
        <div class="row">
            <div class="col-sm-4 col-md-offset-4">
                <div class="panel panel-info " >
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Calificaciones de ingles</h3>
                    </div>

                </div>

            </div>
        </div>
        @if($cuenta_niveles == 0)
            <div class="row">
                <div class="col-sm-4 col-md-offset-4">
                    <div class="panel panel-danger " >
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">No se le han asignado grupos en este periodo</h3>
                        </div>

                    </div>

                </div>
            </div>
            @else
        <div class="row">
            @foreach($niveles as $nivel)
            <div class="col-sm-4 col-md-offset-1">
                <div class="panel panel-default " style="border: 2px solid #43a1d2; border-radius: 7px; padding-right: 0">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">NIVEL: {{ $nivel->nivel }} <br> GRUPO: {{ $nivel->grupo }}
                            <br>
                            <a href="/ingles/Calificaciones/periodos_ingles/{{ $nivel->id_nivel }}/{{ $nivel->id_grupo }}" class="btn btn-primary tooltip-options link" data-toggle="tooltip" data-placement="top" title="Periodos"><span class="oi oi-calendar"></span></a>
                            <a href="/ingles/Calificaciones/mostrar_alumnos/{{ $nivel->id_nivel }}/{{ $nivel->id_grupo }}" class="btn btn-primary tooltip-options link" data-toggle="tooltip" data-placement="top" title="Evaluaciones"><span class="oi oi-pencil"></span></a>

                        </h3>

                    </div>

                </div>
            </div>
                @endforeach

        </div>
            @endif


    </main>
@endsection
@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Autorización de titulaciones <br> (PROGRAMAS DE ESTUDIO) </h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-6 col-md-offset-3">
                        <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                            @foreach($carreras as $carrera)
                                <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" onclick="window.location='{{ url('/titulacion/autorizar_titulacion_alumnos/'.$carrera->id_carrera ) }}'" href="" >{{  $carrera->nombre }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
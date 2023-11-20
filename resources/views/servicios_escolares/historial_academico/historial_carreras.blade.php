@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">HISTORIAL ACADÉMICO</h3>
                    <h5 class="panel-title text-center">(PROGRAMAS DE ESTUDIO)</h5>
                </div>
                <div class="panel-body">

                    <div class="col-md-4">
                        <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                            @foreach($carreras as $carrera)
                                <li style="margin-top: 0px">
                                    <a style="border-bottom: 2px solid black;text-align: center" data-toggle="pill" href="#" onclick="window.location='{{ url('/servicios_escolares/historial_academico/carrera/'.$carrera->id_carrera ) }}'" >   {{$carrera->nombre}}</a>
                                </li>

                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div>
    </div>
@endsection
@extends('layouts.app')
@section('title', 'Ambiental')
@section('content')

    <main class="col-md-12">


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Enviar documentación del procedimiento del Periodo: {{ $periodo[0]->nombre_periodo_amb }}</h3>
                    </div>
                </div>
            </div>
        </div>

            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">

                            @foreach($procedimientos as $procedimiento)
                            <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" href="#" onclick="window.location='{{ url('/ambiental/ver_estado_documentacion/'.$procedimiento->id_encargado ) }}'" >   {{$procedimiento->nom_procedimiento}}</a></li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


    </main>



@endsection

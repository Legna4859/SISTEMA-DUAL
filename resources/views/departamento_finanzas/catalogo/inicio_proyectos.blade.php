@extends('layouts.app')
@section('title', 'Proyectos registrados')
@section('content')
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Metas de los proyectos presupuestales del anteproyecto {{ $year }} <br>(Proyectos registrados)</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-6 col-md-offset-3">
                        <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                            @foreach($proyectos as $proyecto)
                                <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" onclick="window.location='{{ url('presupuesto_anteproyecto/metas_presupuestales/'.$proyecto->id_proyecto ) }}'" href="" >{{  $proyecto->nombre_proyecto }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
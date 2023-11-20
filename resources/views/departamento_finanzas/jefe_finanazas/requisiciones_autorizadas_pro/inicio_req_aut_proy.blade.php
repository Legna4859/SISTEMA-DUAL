@extends('layouts.app')
@section('title', 'Requisiciones de los proyectos')
@section('content')
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Requisiciones autorizadas de los proyectos del anteproyecto de presupuesto {{ $year }}</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-6 col-md-offset-3">
                        <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                            @foreach($registro_proyectos as $registro)
                                {{--
                                <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" onclick="window.location='{{ url('/presupuesto_anteproyecto/proyecto_requisiciones_anteproyecto/'.$registro->id_presupuesto ) }}'" href="" >{{  $registro->nombre_proyecto }}</a></li>
                          --}}
                                <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" onclick="window.location='{{ url('/presupuesto_anteproyecto/proyecto_inicio_anteproyecto/'.$registro->id_presupuesto ) }}'" href="" >{{  $registro->nombre_proyecto }}</a></li>

                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
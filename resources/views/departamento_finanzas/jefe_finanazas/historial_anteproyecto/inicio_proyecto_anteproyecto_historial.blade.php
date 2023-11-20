@extends('layouts.app')
@section('title', 'Historial del anteproyecto')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/presupuesto_anteproyecto/historial_anteproyecto_proyectos/".$id_year)}}">Historial de los proyectos del anteproyecto de presupuesto {{ $year }} </a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Menu del proyecto seleccionado del año {{ $proyecto->year }}</span>
            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Historial de las requisiciones autorizadas del anteproyecto {{ $proyecto->year }} <br>
                        {{ $proyecto->nombre_proyecto }}
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-6 col-md-offset-3">
                        <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                            <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" onclick="window.location='{{ url('/presupuesto_anteproyecto/presupuesto_total_anteproyecto_historial/'.$id_presupuesto ) }}'" href="" >Presupuesto total del proyecto(completo)</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-md-offset-3">
                        <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                            <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" onclick="window.location='{{ url('/presupuesto_anteproyecto/proyecto_capitulo_anteproyecto_historial/'.$id_presupuesto ) }}'" href="" >Por capitulos(completo)</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-md-offset-3">
                        <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                            <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" onclick="window.location='{{ url('/presupuesto_anteproyecto/proyecto_meses_anteproyecto_historial/'.$id_presupuesto ) }}'" href="" >Por mes(completo)</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-md-offset-3">
                        <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                            <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" onclick="window.location='{{ url('/presupuesto_anteproyecto/proyecto_meta_anteproyecto_historial/'.$id_presupuesto ) }}'" href="" >Por meta(completo)</a></li>
                        </ul>
                    </div>

                    <div class="col-md-6 col-md-offset-3">
                        <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                            <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" onclick="window.location='{{ url('/presupuesto_anteproyecto/presupuesto_total_anteproyecto_inc_historial/'.$id_presupuesto ) }}'" href="" >Presupuesto total del proyecto(sin partidas presupuestales en 0)</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-md-offset-3">
                        <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                            <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" onclick="window.location='{{ url('/presupuesto_anteproyecto/proyecto_capitulo_anteproyecto_inc_historial/'.$id_presupuesto ) }}'" href="" >Por capitulos(sin partidas presupuestales en 0)</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-md-offset-3">
                        <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                            <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" onclick="window.location='{{ url('/presupuesto_anteproyecto/proyecto_meses_anteproyecto_inc_historial/'.$id_presupuesto ) }}'" href="" >Por mes(sin partidas presupuestales en 0)</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-md-offset-3">
                        <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                            <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" onclick="window.location='{{ url('/presupuesto_anteproyecto/proyecto_metas_anteproyecto_inc_historial/'.$id_presupuesto ) }}'" href="" >Por meta(sin partidas presupuestales en 0)</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
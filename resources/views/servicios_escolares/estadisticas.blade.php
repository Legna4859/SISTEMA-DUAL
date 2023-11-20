@extends('layouts.app')
@section('title', 'Estadisticas')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">DATOS ESTADÍSTICOS DEL TESVB</h3>
                </div>
                <div class="panel-body">
                    <div class="row col-md-12">
                        <div>
                            <ul class="nav nav-pills nav-stacked col-md-2" style="border: 2px solid black; border-radius: 7px; padding-right: 0">
                                <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" onclick="window.open('{{url('/servicios_escolares/estadisticas/genero')}}')">Estudiantes</a></li>
                                <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" onclick="window.open('{{url('/servicios_escolares/estadisticas/municipios')}}')">Municipio</a></li>
                                <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" onclick="window.open('{{url('/servicios_escolares/estadisticas/edad')}}')">Edad</a></li>
                                <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill"onclick="window.open('{{url('/servicios_escolares/estadisticas/carreras_indice_reprobacion')}}')">Indices de Reprobación</a></li>
                            </ul>

                        </div>
                    </div></div></div></div>
    </div>
@endsection
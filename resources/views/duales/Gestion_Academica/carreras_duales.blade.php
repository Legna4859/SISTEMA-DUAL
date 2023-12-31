@extends('layouts.app')
@section('title', 'Gestión Académica')
@section('content')

    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">GESTIÓN ACADÉMCIA DE ALUMNOS DUALES</h3>
                    <h5 class="panel-title text-center">(PROGRAMAS DE ESTUDIO)</h5>
                </div>
                <div class="panel-body">
                        <div class="col-md-4">
                            <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                                @foreach($carreras as $carrera)
                                    <li style="margin-top: 0px" class="text-center">
                                        <a style="border-bottom: 2px solid black;" data-toggle="pill" href="#" onclick="window.location='{{ url('/duales/gestion_academica/docentes') }}'" >   
                                        {{$carrera->nombre}}
                                    </a>
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

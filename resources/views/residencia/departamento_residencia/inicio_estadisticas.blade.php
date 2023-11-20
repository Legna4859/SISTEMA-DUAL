@extends('layouts.app')
@section('title', 'Residencia')
@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Ver estadisticas de residencia</h3>
                </div>
                <div class="panel-body">
                    <div class="row col-md-12">
                        <div>
                            <ul class="nav nav-pills nav-stacked col-md-8 col-md-offset-2" style="border: 2px solid black; border-radius: 7px; padding-right: 0">

                                <li><a href="{{url('/residencia/institucional_estadisticas')}}" style="border-bottom: 2px solid black;">Institucional</a></li>
                                <li><a   href="{{url('/residencia/carreras_estadisticas')}}" style="border-bottom: 2px solid black;">Por carrera</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')
@section('title', 'Titulacion')
@section('content')

    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Ver titulados liberados <br>(PROGRAMAS DE ESTUDIO) </h3>
                </div>
                <div class="panel-body " >
                    <div class="row">
                        <div class="col-md-2 col-md-offset-8">
                            <button type="button" class="btn btn-success" onclick="window.location='{{ url('/titulacion/exportar_alumnos_liberados/' ) }}'">Exportar titulados</button>
                            <p><br><br></p>
                        </div>
                    </div>

                    <div class="col-md-6 col-md-offset-3">
                        <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                            @foreach($carreras as $carrera)
                                <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" href="#" onclick="window.location='{{ url('/titulacion/registro_titulados_carrera/'.$carrera->id_carrera ) }}'" >   {{$carrera->nombre}}</a></li>

                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>




@endsection
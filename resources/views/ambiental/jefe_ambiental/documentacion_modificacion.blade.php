@extends('layouts.app')
@section('title', 'Ambiental')
@section('content')
    <main class="col-md-12">


        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Proceso de Modificación de Documentación de los Procedimientos del {{ $periodo[0]->nombre_periodo_amb }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                <ul class="nav nav-tabs">
                    <li  > <a href="{{url('/ambiental/ver_documentacion_ambiental')}}">Autorizar documentación</a></li>
                    <li class="active" ><a href="#">Proceso de Modificación</a>
                    </li>

                    <li  > <a href="{{url('/ambiental/documentacion_autorizada/')}}">Documentación Autorizada</a></li>
                </ul>
                <br>
            </div>
        </div>
        <div class="row">
            <div  class="col-md-10 col-lg-offset-1">
                <table id="tabla_envio" class="table table-bordered table-resposive">
                    <thead>
                    <tr>

                        <th>Procedimiento</th>
                        <th>Nombre del encargado</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($encargados as $encargado)
                    <tr >
                        <td>{{ $encargado->nom_procedimiento }}</td>
                        <td>{{ $encargado->nombre }}</td>


                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
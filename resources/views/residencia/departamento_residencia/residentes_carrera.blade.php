@extends('layouts.app')
@section('title', 'Anteproyecto Institucional')
@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Proyectos de Residencia  del periodo {{ $periodo->periodo  }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-body">

                    <table id="table_enviado" class="table table-bordered table-resposive">
                        <thead>
                        <tr>
                            <th>No. cuenta</th>
                            <th>Nombre del alumno</th>
                            <th>Nombre del proyecto</th>
                            <th>Asesor</th>
                            <th>Ver calificaciones </th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($anteproyectos as $anteproyecto)

                            <tr>
                                <td>{{$anteproyecto->cuenta}}</td>
                                <td>{{$anteproyecto->nombre}} {{$anteproyecto->apaterno}}  {{$anteproyecto->amaterno}}</td>
                                <td>{{$anteproyecto->nom_proyecto}}</td>
                                <td>{{$anteproyecto->profesor}}</td>
                                <td>   <button class="btn btn-primary" onclick="window.location='{{ url('/residentes/alumno/'.$anteproyecto->id_anteproyecto ) }}'"><i class="glyphicon glyphicon-pencil em2"></i></button>
                                </td>

                            </tr>


                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
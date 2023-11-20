@extends('layouts.app')
@section('title', 'Seguimiento')
@section('content')
    <div class="row">
        <div class="col-md-10  col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Seguimiento de Residencia</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <table id="table_enviado" class="table table-bordered table-resposive">
                            <thead>
                            <tr>
                                <th>No. Cuenta</th>
                                <th>Nombre del alumno</th>
                                <th>Nombre del proyecto</th>
                                <th>Calificar</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($segumientos_proyectos as $anteproyecto)

                                <tr>
                                    <td>{{ $anteproyecto->cuenta }} </td>

                                    <td>{{ $anteproyecto->nombre }} {{ $anteproyecto->apaterno }} {{ $anteproyecto->amaterno }}</td>
                                    <td>{{ $anteproyecto->nom_proyecto }}</td>
                                    @if($anteproyecto->autorizacion_departamento == 1)
                                    <td><button type="button" class="btn btn-light" onclick="window.location='{{ url('/residencia/seguimiento_alumno/'.$anteproyecto->id_anteproyecto ) }}'" title="Revisar anteproyecto"><i class="glyphicon glyphicon-pencil text-info" style="font-size: 20px;"></i></button>
                                    </td>
                                    @else
                                        <td>No han sido autorizado sus documentos   por el Departamento de Servicio Social y Residencia Profesional </td>
                                    @endif
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
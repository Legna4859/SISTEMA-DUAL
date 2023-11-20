@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10  col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Anteproyecto para revisar</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <table id="table_enviado" class="table table-bordered table-resposive">
                            <thead>
                            <tr>
                                <th>No. Cuenta</th>
                                <th>Nombre del alumno</th>
                                <th>Nombre del anteproyecto</th>
                                <th>Revisar</th>
                                <th>No. de revisión</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($anteproyectos as $anteproyecto)

                                <tr>
                                    <td>{{ $anteproyecto->cuenta }} </td>

                                    <td>{{ $anteproyecto->nombre }} {{ $anteproyecto->apaterno }} {{ $anteproyecto->amaterno }}</td>
                                    <td>{{ $anteproyecto->nom_proyecto }}</td>
                                    <td><button type="button" class="btn btn-light" onclick="window.location='{{ url('/residencia/revisar_anteproyecto/'.$anteproyecto->id_anteproyecto.'/'.$id_profesor ) }}'" title="Revisar anteproyecto"><i class="glyphicon glyphicon-pencil text-info" style="font-size: 20px;"></i></button>
                                    </td>
                                    @if($anteproyecto->numero_evaluacion ==1)
                                        <td>PRIMERA REVISIÓN</td>
                                        @elseif($anteproyecto->numero_evaluacion ==2)
                                        <td>SEGUNDA REVISIÓN</td>
                                    @elseif($anteproyecto->numero_evaluacion ==3)
                                        <td>TERCERA REVISIÓN</td>
                                    @elseif($anteproyecto->numero_evaluacion ==4)
                                        <td>CUARTA REVISIÓN</td>
                                    @elseif($anteproyecto->numero_evaluacion ==5)
                                        <td>QUINTA REVISIÓN</td>
                                    @elseif($anteproyecto->numero_evaluacion ==6)
                                        <td>SEXTA REVISIÓN</td>
                                    @elseif($anteproyecto->numero_evaluacion ==7)
                                        <td>SEPTIMA REVISIÓN</td>
                                    @elseif($anteproyecto->numero_evaluacion ==8)
                                        <td>OCTAVA REVISIÓN</td>
                                    @elseif($anteproyecto->numero_evaluacion ==9)
                                        <td>NOVENA REVISIÓN</td>
                                    @elseif($anteproyecto->numero_evaluacion ==10)
                                        <td>DECIMA REVISIÓN</td>
                                        @else
                                        <td></td>
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
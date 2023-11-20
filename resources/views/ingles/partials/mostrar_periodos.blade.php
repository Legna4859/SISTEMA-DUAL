@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Periodos de ingles')
@section('content')
    <main class="col-md-12">

        <div class="row">

            <div class="col-md-6 col-md-offset-3 ">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Periodos de ingles</h3>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <table id="table_enviado" class="table table-bordered text-center" style="table-layout:fixed;">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Periodo</th>
                        <th>Fecha inicial</th>
                        <th>Fecha final</th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($periodos as $periodo)
                        <tr>
                            <td>{{ $periodo->id_periodo_ingles }}</td>
                            <td>{{ $periodo->periodo_ingles }}</td>
                            <td>{{ $periodo->fecha_inicio_ingles }}</td>
                            <td>{{ $periodo->fecha_final_ingles }}</td>
                        </tr>

                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>

    </main>
@endsection
@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Grupos de ingles')
@section('content')
    <main class="col-md-12">

        <div class="row">

            <div class="col-md-6 col-md-offset-3 ">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Grupos de ingles</h3>
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
                        <th>Grupos</th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($grupos as $grupo)
                        <tr>
                            <td>{{ $grupo->id_grupo_ingles }}</td>
                            <td>{{ $grupo->descripcion }}</td>
                        </tr>

                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>

    </main>
@endsection
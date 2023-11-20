@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Niveles de ingles')
@section('content')
    <main class="col-md-12">

        <div class="row">

            <div class="col-md-6 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Niveles de ingles</h3>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-2">
                <table id="table_enviado" class="table table-bordered text-center" style="table-layout:fixed;">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nivel </th>
                        <th>Clave</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($niveles as $nivel)
                        <tr>
                            <td>{{$nivel->id_niveles_ingles}}</td>
                            <td>{{$nivel->descripcion}}</td>
                            <td>{{$nivel->clave}}</td>
                        </tr>

                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>

    </main>
@endsection
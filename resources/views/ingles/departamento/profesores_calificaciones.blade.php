@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Facilitadores de ingles')
@section('content')
    <main class="col-md-12">

        <div class="row">

            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Calificaciones de los Facilitadores de Ingles</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6 col-md-offset-3">
                <table id="paginar_table" class="table table-bordered ">
                    <thead>
                    <tr>
                        <th>Nombre del facilitador</th>
                        <th>Mostrar Grupos</th>

                    </tr>
                    </thead>

                    <tbody>
                    @foreach($profesores as $profesor)
                        <tr>
                            <td>{{ $profesor->apellido_paterno }} {{ $profesor->apellido_materno }} {{ $profesor->nombre }}</td>
                            <td>
                                <a href="/ingles/profesores/calificacion_profesor/{{ $profesor->id_profesores }}"><span class="glyphicon glyphicon-list-alt em6" aria-hidden="true"></span></a>
                            </td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
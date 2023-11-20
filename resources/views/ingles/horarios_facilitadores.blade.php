@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Facilitadores de ingles')
@section('content')
    <main class="col-md-12">

        <div class="row">

            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Facilitadores de Ingles del periodo {{ $periodo->periodo_ingles }}</h3>
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
                        <th>Mostrar horario</th>

                    </tr>
                    </thead>

                    <tbody>
                    @foreach($profesores as $profesor)
                        <tr>
                            <td>{{ $profesor->nombre }} {{ $profesor->apellido_paterno }} {{ $profesor->apellido_materno }}</td>
                            <td>
                                <a href="/ingles/mostrar_horario_profesor/{{ $profesor->id_profesores }}"><span class="glyphicon glyphicon-list-alt em6" aria-hidden="true"></span></a>
                            </td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
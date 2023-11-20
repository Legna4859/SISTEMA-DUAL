@extends('layouts.app')
@section('title', 'Areas')
@section('content')
    <main class="main">
        <div class="container">
                <div class="panel panel-info">
                    <div class="panel-heading center-block">
                        <h2 class="panel-title text-center">Departamentos del TESVB</h2>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="card">
                    <div class="card-body">
                            <table class="table table-bordered table-striped table-sm" style="background-color: lightyellow">
                                <thead>
                                <tr>
                                    <th style="color: darkblue; text-align: center">No. Depto</th>
                                    <th style="color: darkblue; text-align: center">Nombre del Departamento</th>
                                    <th style="color: darkblue; text-align: center">Encargado del Departamento</th>

                                </tr>
                                </thead>
                                @foreach($jefes_unidades as $area)<!-- se crea un objeto para acceder a los datos-->
                                <tbody>
                                <tr>
                                    <td style="text-align: center">{{$area->id_unidad_admin}}</td>
                                    <td style="text-align: center">{{$area->nom_departamento}}</td>
                                    <td style="text-align: center">{{$area->nombre}}</td>


                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                                 <!--para la paginacion-->
                    </div>
                </div>
            </div>

    </main>


@endsection
@extends('layouts.app')
@section('title', 'Categorías')
@section('content')
    <main class="main">
        <div class="container">
            <div class="panel panel-info">
                <div class="panel-heading center-block">
                    <h2 class="panel-title text-center">Categorias del TESVB</h2>
                </div>
            </div>
                <div>
                    @if($categorias->isEmpty())
                        <div style="text-align: center; background-color: lightgoldenrodyellow">No hay Categorias</div><br>
                    @else
                        <table class="table table-bordered table-striped table-sm" style="background-color: lightyellow">
                            <thead>
                            <tr>
                                <th>No.de Registro</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            @foreach($categorias as $categoria)<!-- se crea un objeto para acceder a los datos-->
                            <tbody>
                                    <!--<tr>
                                        <td>{!! $categoria->id !!}</td>
                                        <td>{!! $categoria->nombre !!}</td>  //otra manera de listar los registros
                                        <td>{!! $categoria->descripcion !!}</td>
                                    </tr>-->
                                    <tr>
                                        <td>{{$categoria->id}}</td>
                                        <td>{{$categoria->nombre}}</td>
                                        <td>{{$categoria->descripcion}}</td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                            {{$categorias->links()}}<!--para la paginacion-->
                    @endif
                </div>
        </div>
    </main>


@endsection
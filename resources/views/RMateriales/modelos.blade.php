@extends('layouts.app')
@section('title', 'Modelos')
@section('content')
    <main class="main">
        <div class="container">
                <div class="panel panel-info">
                    <div class="panel-heading center-block">
                        <h1 class="panel-title text-center" style="font-size: large">Registrar Y Gestionar Modelos</h1>
                    </div>
                </div>
            <div class="form-group col-md-4">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="open">Agregar Modelo</button>
            </div>
            <form method="get" action="{{route('buscarmod')}}">
                <div class="form-group col-md-6">
                    <input class="form-control" type="search" name="buscarpor" placeholder="Buscar por Palabra " aria-label="Search"
                           autocomplete="off">


                </div>
                <button type="submit" class="btn btn-default col-md-1">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </form>

            <form method="post" action="{{route('guardarmodelo')}}" id="form">
                @csrf
                <!-- Modal -->
                <div class="modal" tabindex="-1" role="dialog" id="myModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="alert alert-danger" style="display:none"></div>
                            <div class="modal-header">

                                <h3 class="modal-title" style="text-align: center">Agregar Nuevo Modelo</h3>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div align="center" class="form-group col-md-6">
                                        <label for="Name">Nombre del Modelo:</label>
                                        <input type="text" class="form-control" name="modelo" id="modelo" required
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button  class="btn btn-success" type="submit">Guardar Modelo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="container-fluid" >
            <div class="container">
                <div class="card-body">
                    @if($modelos->isEmpty())
                        <div style="text-align: center; background-color: lightgoldenrodyellow">No hay Modelos</div><br>
                    @else
                        <table class="table table-bordered table-striped table-sm" style="color: black;text-align: center; background-color: lightyellow"  >
                            <thead>
                            <tr>
                                <th style="text-align: center">Nombre del Modelo</th>
                                <th style="text-align: center ">Opciones</th >
                                <th style="text-align: center ">Estado</th >

                            </tr>
                            </thead>
                            @foreach($modelos as $modelo)<!-- se crea un objeto para acceder a los datos-->
                            <tbody>
                            <tr>
                                <td>{{$modelo->modelo}}</td>
                                <td>
                                    @if($modelo-> condicion == 1)
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{$modelo->id}}">Editar</button> <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target='#desModal{{$modelo->id}}'>Desactivar</button>
                                        <!--Modal Editar -->
                                        <form method="POST" action="{{route('editarmod',$modelo->id)}}" >
                                            @csrf @method('PUT')

                                            <div class="modal" tabindex="-1" role="dialog" id="editModal{{$modelo->id}}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="alert alert-danger" style="display:none"></div>
                                                        <div class="modal-header">

                                                            <h3 class="modal-title" >Actualizar Modelo</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="Name">Nombre del Modelo:</label>
                                                                    <input type="text" class="form-control" name="modelo" value="{{$modelo->modelo}}" id="modelo">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button  class="btn btn-success" type="submit">Actualizar Modelo</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--Modal Editar -->
                                        <!--Modal Desactivar -->
                                        <form method="POST" action="{{route('desactivarmod',$modelo->id)}}" >
                                            @csrf @method('PUT')

                                            <div class="modal" tabindex="-1" role="dialog" id="desModal{{$modelo->id}}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="alert alert-danger" style="display:none"></div>
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" style="color: black" >Desactivar Modelo</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4 style="color: red">¿Desea Desactivar el Modelo?</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                                                            <button  class="btn btn-danger btn-sm" type="submit">Desactivar Modelo</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--Modal Desactivar -->
                                    @else
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target='#actModal{{$modelo->id}}'>Activar</button>

                                        <!--Modal Activar -->
                                        <form method="POST" action="{{route('activarmod',$modelo->id)}}" >
                                            @csrf @method('PUT')

                                            <div class="modal" tabindex="-1" role="dialog" id="actModal{{$modelo->id}}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="alert alert-danger" style="display:none"></div>
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" style="color: black" >Activar Modelo</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4>¿Desea Activar el Modelo?</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                                                            <button  class="btn btn-success btn-sm" type="submit">Activar Modelo</button>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--Modal Activar -->

                                    @endif
                                </td>
                                <td>
                                    @if($modelo-> condicion == 1)
                                        <span class="text-success" style="color: green">Activo</span>
                                    @else
                                        <span class="text-danger">Inactivo</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        {{$modelos->links()}}<!--para la paginacion-->
                    @endif
                </div>
            </div>
        </div>

    </main>
@endsection
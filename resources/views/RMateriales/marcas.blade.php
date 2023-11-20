@extends('layouts.app')
@section('title', 'Marcas')
@section('content')


    <main class="main">

        <div class="container">
                <div class="panel panel-info">

                    <div class="panel-heading center-block">
                        <h2 class="panel-title text-center" style="font-size: large">Registrar y Gestionar Marcas</h2>
                    </div>
            </div>
            <div class="container">
            <div class="form-group col-md-4">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="open">Agregar Marca</button>
            </div>
                <form method="get" action="{{route('buscarmar')}}">
                <div class="form-group col-md-6">
                <input class="form-control" type="search" name="buscarpor" placeholder="Buscar Marca " aria-label="Search"
                autocomplete="off">
                </div>
                <button type="submit" class="btn btn-default col-md-1">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
                </form>
            <form id="form" name="formmarca" method="post" action="{{route('guardarmarca')}}">
                @csrf
                <!-- Modal Insertar -->
                <div class="modal" tabindex="-1" role="dialog" id="myModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="alert alert-danger" style="display:none"></div>
                            <div class="modal-header">
                                <h3 class="modal-title" style="text-align: center">Agregar Nueva Marca</h3>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger" style="display: none"></div>

                                <div class="row">
                                    <div align="center" class="form-group col-md-6">
                                        <label for="Name">Nombre de la Marca:</label>
                                        <input type="text" class="form-control" name="marca" id="marca"
                                               style="text-transform: uppercase" required>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit"  class="btn btn-success"  >Guardar Marca</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
            </div>
            <!--Modal Insertar-->
            @if(Session::has('message'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('message')}}
                </div>
            @endif
        </div>
        <br>
        <!-- listado de marcas -->
        <div class="container-fluid" >
            <div class="container">

                <div class="card-body">
                    @if($marcas->isEmpty())
                        <div style="text-align: center; background-color: lightgoldenrodyellow">No hay Marcas</div><br>
                    @else
                        <table class="table table-bordered table-striped table-sm" style="color: green;text-align: center; background-color: lightyellow" >
                            <thead>
                            <tr>
                                <th style="text-align: center">Nombre de la Marca</th>
                                <th style="text-align: center">Opciones</th>
                                <th style="text-align: center">Estado</th>
                            </tr>
                            </thead>
                            @foreach($marcas as $marca)<!-- se crea un objeto para acceder a los datos-->
                            <tbody>
                            <tr>
                                <td>{{$marca->marca}}</td>
                                <td>

                                @if($marca-> condicion == 1)

                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{$marca->id}}">Editar</button> <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target='#desModal{{$marca->id}}'>Desactivar</button>
                                    <!--Modal Editar -->
                                    <form method="POST" action="{{route('editarmarca',$marca->id)}}" >
                                        @csrf @method('PUT')

                                        <div class="modal" tabindex="-1" role="dialog" id="editModal{{$marca->id}}">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="alert alert-danger" style="display:none"></div>
                                                    <div class="modal-header">

                                                        <h3 class="modal-title" style="text-align: center">Actualizar Marca</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="form-group col-md-4">
                                                                <label for="Name">Nombre de la Marca:</label>
                                                                <input type="text" class="form-control" name="marca" value="{{$marca->marca}}" id="marca">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        <button  class="btn btn-success" type="submit">Actualizar Marca</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!--Modal Editar -->
                                    <!--Modal Desactivar -->
                                    <form method="POST" action="{{route('desactivarmar',$marca->id)}}" >
                                        @csrf @method('PUT')

                                        <div class="modal" tabindex="-1" role="dialog" id="desModal{{$marca->id}}">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="alert alert-danger" style="display:none"></div>
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" style="color: black" >Desactivar Marcas</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4 style="color: red">¿Desea Desactivar la Marca?</h4>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                                                        <button  class="btn btn-danger btn-sm" type="submit">Desactivar Marca</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!--Modal Desactivar -->
                                @else

                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target='#actModal{{$marca->id}}'>Activar</button>

                                        <!--Modal Activar -->
                                        <form method="POST" action="{{route('activarmar',$marca->id)}}" >
                                            @csrf @method('PUT')

                                            <div class="modal" tabindex="-1" role="dialog" id="actModal{{$marca->id}}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="alert alert-danger" style="display:none"></div>
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" style="color: black" >Activar Marcas</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4>¿Desea Activar la Marca?</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                                                            <button  class="btn btn-success btn-sm" type="submit">Activar Marca</button>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--Modal Activar -->
                                    @endif

                                </td>
                                <td>
                                    @if($marca-> condicion == 1)
                                        <span class="text-success">Activo</span>
                                    @else
                                        <span class="text-danger">Desactivado</span>
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                        </table>
                        {{$marcas->links()}}<!--para la paginacion-->
                    @endif
                </div>
            </div>
        </div>



    </main>



@endsection
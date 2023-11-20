@extends('layouts.app')
@section('title', 'Provedores')
@section('content')
    <main class="main">
        <div class="container">
                <div class="panel panel-info">
                    <div class="panel-heading center-block">
                        <h2 class="panel-title text-center" style="font-size: large">Registrar y Gestionar Proveedores</h2>
                    </div>
                </div>
            <div class="container">
                <button type="button" class="btn btn-primary form-group col-md-2" data-toggle="modal" data-target="#myModal" id="open">Agregar Proveedor</button>

                <div align="center" class="form-group col-md-10">
                    <!-- Formulario para Busqueda -->

                    <form method="get" action="{{route('buscarprov')}}">
                        <div class="col-md-5" >
                            <select name="tipo" id="" class="form-control" >
                                <option disabled >Seleccione el tipo</option>
                                <option value="nombre">nombre</option>
                                <option value="contacto">contacto</option>
                                <option value="email">email</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" type="search" name="buscarpor" placeholder="Buscar Proveedor "
                                   autocomplete="off" aria-label="Search" >


                        </div>
                        <button type="submit" class="btn btn-default col-md-1">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>

                    </form>
                    <!-- Fin formulario -->
                </div>
                <form method="post" action="{{route('guardarprov')}}" id="form">
                    @csrf
                <!-- Modal Insertar -->
                <div class="modal" tabindex="-1" role="dialog" id="myModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="alert alert-danger" style="display:none"></div>
                            <div class="modal-header">

                                <h3 class="modal-title" style="text-align: center">Agregar Nuevo Proveedor</h3>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div align="center" class="form-group col-md-6">
                                        <label for="Name">Nombre del Proveedor:</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" autocomplete="off" required>
                                    </div>
                                    <div align="center" class="form-group col-md-6">
                                        <label for="Name">Contacto:</label>
                                        <input type="text" class="form-control" name="contacto" id="contacto" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row">
                                    <div align="center" class="form-group col-md-6" >
                                        <label for="Name">email:</label>
                                        <input type="text" class="form-control" name="email" id="email" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button  class="btn btn-success" type="submit">Guardar Proveedor</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <!-- Modal Insertar -->
        </div>
        <br>

        <div class="container-fluid" >
            <div class="container">
                <div class="card-body">
                    @if($provedores->isEmpty())
                        <div style="text-align: center; background-color: lightgoldenrodyellow">No hay Proveedores</div><br>
                    @else
                        <table class="table table-bordered table-striped table-sm" style="color: black;text-align: center; background-color: lightyellow" >
                            <thead>
                            <tr>

                                <th style="text-align: center">Nombre del Proveedor</th>
                                <th style="text-align: center">Telefono</th>
                                <th style=" text-align: center">Email</th>
                                <th style="text-align: center ">Opciones</th>
                                <th style="text-align: center ">Estado</th>
                            </tr>
                            </thead>
                            @foreach($provedores as $provedor)<!-- se crea un objeto para acceder a los datos-->
                            <tbody>
                            <tr>

                                <td>{{$provedor->nombre}}</td>
                                <td>{{$provedor->contacto}}</td>
                                <td>{{$provedor->email}}</td>
                                <td>
                                    @if($provedor-> condicion == 1)
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{$provedor->id}}">Editar</button> <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target='#desModal{{$provedor->id}}'>Desactivar</button>
                                        <!--Modal Editar -->
                                        <form method="POST" action="{{route('editarprov',$provedor->id)}}" >
                                            @csrf @method('PUT')

                                            <div class="modal" tabindex="-1" role="dialog" id="editModal{{$provedor->id}}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="alert alert-danger" style="display:none"></div>
                                                        <div class="modal-header">

                                                            <h3 class="modal-title" >Actualizar Proveedor</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label for="Name">Nombre del Proveedor:</label>
                                                                    <input type="text" class="form-control" name="nombre" value="{{$provedor->nombre}}" id="nombre">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="Name">Contacto:</label>
                                                                    <input type="text" class="form-control" name="contacto" id="contacto" value="{{$provedor->contacto}}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="Name">Email:</label>
                                                                    <input type="text" class="form-control" name="email" id="email" value="{{$provedor->email}}">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button  class="btn btn-success" type="submit">Actualizar Proveedor</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--Modal Editar -->
                                        <!--Modal Desactivar -->
                                        <form method="POST" action="{{route('desactivarprov',$provedor->id)}}" >
                                            @csrf @method('PUT')

                                            <div class="modal" tabindex="-1" role="dialog" id="desModal{{$provedor->id}}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="alert alert-danger" style="display:none"></div>
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" style="color: black" >Desactivar Proveedor</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4 style="color: red">¿Desea Desactivar el Proveedor?</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                                                            <button  class="btn btn-danger btn-sm" type="submit">Desactivar Proveedor</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--Modal Desactivar -->
                                    @else
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target='#actModal{{$provedor->id}}'>Activar</button>

                                        <!--Modal Activar -->
                                        <form method="POST" action="{{route('activarprov',$provedor->id)}}" >
                                            @csrf @method('PUT')

                                            <div class="modal" tabindex="-1" role="dialog" id="actModal{{$provedor->id}}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="alert alert-danger" style="display:none"></div>
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" style="color: black" >Activar Proveedor</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4>¿Desea Activar el Proveedor?</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                                                            <button  class="btn btn-success btn-sm" type="submit">Activar Proveedor</button>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--Modal Activar -->

                                    @endif
                                </td>
                                <td>
                                    @if($provedor-> condicion == 1)
                                        <span class="text-success" style="color: green">Activo</span>
                                    @else
                                        <span class="text-danger" style="color: red">Inactivo</span>
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                        </table>
                        {{$provedores->links()}}<!--para la paginacion-->
                    @endif
                </div>
            </div>
        </div>

    </main>



@endsection
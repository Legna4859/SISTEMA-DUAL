@extends('layouts.app')
@section('title', 'Editar Resguardario')
@section('content')
    <main class="main">

        <div class="container">
            <div class="panel panel-info">

                <div class="panel-heading center-block">
                    <h2 class="panel-title text-center" style="font-size: large">Cambiar de Resguardatario</h2>
                </div>
            </div>
            <div align="center" class="container-fluid">
                <!-- Formulario para Busqueda -->

                <form method="get" action="{{route('buscarres')}}">
                    <div class="col-md-5" >
                        <select name="tipo" id="" class="form-control" >
                            <option disabled >Seleccione el tipo</option>
                            <option value="nombre">nombre</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" type="search" name="buscarpor" placeholder="Buscar " aria-label="Search" >
                    </div>
                    <button type="submit" class="btn btn-default col-md-1">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>

                </form>
                <!-- Fin formulario -->
            </div>
            <br>
            <div class="container-fluid" >
                <div class="container-fluid">
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm" style="color: black;text-align: center; background-color: lightyellow"  >
                            <thead>
                            <tr>

                                <th style="text-align: center">Resguardatario:</th>
                                <th style="text-align: center">Categoría:</th>
                                <th style="text-align: center">Nombre del Bien:</th>
                                <th style="text-align: center">Cambio de Resguardatario:</th>

                            </tr>
                            </thead>
                            @foreach($resguardos as $res)<!-- se crea un objeto para acceder a los datos-->
                            <tbody>
                            <tr>
                                <td>{{$res->sectores->nombre}}</td>
                                <td>{{$res->bienes->categorias->nombre}}</td>
                                <td>{{$res->bienes->nombre}}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editModal{{$res->id}}">Cambiar </button>
                                    <!--Modal Editar -->
                                    <form method="POST" action="{{route('editarres',$res->id)}}" >
                                        @csrf @method('PUT')

                                        <div class="modal" tabindex="-1" role="dialog" id="editModal{{$res->id}}">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="alert alert-danger" style="display:none"></div>
                                                    <div class="modal-header">
                                                        <h3 class="modal-title" style="text-align: center">Actualizar Resguardo Actual</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="form-group col-md-6" align="center">
                                                                <label for="Name">Seleccione el Bien a Resguardar:</label>
                                                                <select name="id_sector" id="inputId_sector" class="form-control" required>
                                                                    <option value="">Seleccione el bien</option>
                                                                    @foreach($sectores as $sector)
                                                                        <option value="{{$sector->id}}" {{($sector->id) ? 'selected ' :''}}>{{$sector->nombre}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        <button  class="btn btn-success" type="submit">Actualizar Resguardo</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </form>

                                    <!--Modal Editar -->
                                </td>

                                <!--lo borrado-->
                            </tr>

                            @endforeach
                        </table>
                        {{$resguardos->links()}}<!--para la paginacion-->
                    </div>
                </div>
            </div>

        </div>


    </main>



@endsection
@extends('layouts.app')
@section('title', 'Sectores Auxiliares')
@section('content')
    <main class="main">

        <div class="container">
            <div class="panel panel-info">

                <div class="panel-heading center-block">
                    <h2 class="panel-title text-center" style="font-size: large">Registro, Gestión y Consulta de Resguardatarios</h2>
                </div>
            </div>
            <button type="button" class="btn btn-primary form-group col-md-2" data-toggle="modal" data-target="#myModal" id="open">Registrar Resguardatario</button>
                <div align="center" class="form-group col-md-10">
                    <!-- Formulario para Busqueda -->

                    <form method="get" action="{{route('buscar')}}">
                        <div class="col-md-5" >
                        <select name="tipo" id="" class="form-control" >
                            <option disabled >Seleccione el tipo</option>
                            <option value="nombre">nombre</option>
                            <option value="puesto">puesto</option>
                            <option value="csp">csp</option>
                            <option value="id_area">Número de Departamento</option>
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
            <form name="formsec" method="post" action="{{route('asignarsec')}}">
                @csrf
                <!-- Modal -->
                <div class="modal" tabindex="-1" role="dialog" id="myModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="alert alert-danger" style="display:none"></div>
                            <div class="modal-header">
                                <h3 class="modal-title" style="text-align: center">Registrar nuevo Resguardatario</h3>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-md-6" align="center">
                                        <label for="name">Departamento:</label>
                                        <select name="id_area" id="inputId_area" class="form-control" required >
                                            <option value="">Seleccione el Departamento</option>
                                            @foreach($departamentos as $depa)
                                            <option value="{{$depa['id_unidad_admin']}}">{{$depa['nom_departamento']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6" align="center">
                                        <label for="name">Nombre Completo:</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" required
                                        style="text-transform: uppercase" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6" align="center">
                                        <label for="name">Ingrese CSP:</label>
                                        <input type="number" class="form-control" name="csp" id="csp" required
                                        maxlength="10" autocomplete="off" placeholder="Clave de Servidor Público">
                                    </div>
                                    <div class="form-group col-md-6" align="center">
                                        <label for="name">Puesto Nominal:</label>
                                        <input type="text" class="form-control" name="puesto" id="puesto" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div align="center" class="form-group col-md-12">
                                        <label  for="name" >Fecha de Registro</label>
                                        <input  type="date"  min="2022-11-01" id="fechain" name="fechain" required>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button  class="btn btn-success" type="submit">Agregar Sector Público</button>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!--Modal para agregar-->
        </div>
        <div class="container-fluid" >
            <div class="container">

                <div class="card-body">
                    @if($sectores->isEmpty())
                        <div style="text-align: center; background-color: lightgoldenrodyellow">No hay Resguardatarios</div><br>
                    @else
                        <table class="table table-bordered table-striped table-sm" style="color: black;text-align: center; background-color: lightyellow" >
                            <thead>
                            <tr>
                                <th style="text-align: center">Departamento</th>
                                <th style="text-align: center">Nombre</th>
                                <th style="text-align: center">CSP</th>
                                <th style="text-align: center">Puesto</th>
                                <th style="text-align: center">Opciones</th>
                                <th style="text-align: center">Registro</th>
                                <th style="text-align: center">Estado</th>
                            </tr>
                            </thead>
                            @foreach($sectores as $sector)<!-- se crea un objeto para acceder a los datos-->
                            <tbody>
                            @if($sector-> condicion == 1)
                            <tr>

                                <td>{{$sector->departamentos->nom_departamento}}</td>
                                <td>{{$sector->nombre}}</td>
                                <td>{{$sector->csp}}</td>
                                <td>{{$sector->puesto}}</td>
                                <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{$sector->id}}">Editar</button>
                                    <br><br>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target='#desModal{{$sector->id}}'>Baja</button>

                                    <!--Modal Editar -->
                                        <form method="POST" action="{{route('editarsec',$sector->id)}}" >
                                            @csrf @method('PUT')

                                            <div class="modal" tabindex="-1" role="dialog" id="editModal{{$sector->id}}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="alert alert-danger" style="display:none"></div>
                                                        <div class="modal-header">
                                                            <h3 class="modal-title" >Editar Sector Auxiliar</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-6" align="center">
                                                                    <label for="name">Departamento:</label>
                                                                    <select name="id_area" id="inputId_area" class="form-control" required >
                                                                        <option value=" {{$sector->departamentos->id_unidad_admin}}">{{$sector->departamentos->nom_departamento}}</option>
                                                                        @foreach($departamentos as $sec)
                                                                            <option value="{{$sec->id_unidad_admin}}">{{$sec->nom_departamento}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-6" align="center">
                                                                    <label for="name">Nombre Completo:</label>
                                                                    <input type="text" class="form-control" name="nombre" id="nombre" required value="{{$sector->nombre}}"
                                                                           style="text-transform: uppercase" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-6" align="center">
                                                                    <label for="name">Editar CSP:</label>
                                                                    <input type="number" class="form-control" name="csp" id="csp" required value="{{$sector->csp}}"
                                                                           maxlength="10" autocomplete="off">
                                                                </div>
                                                                <div class="form-group col-md-6" align="center">
                                                                    <label for="name">Puesto Nominal:</label>
                                                                    <input type="text" class="form-control" name="puesto" id="puesto" value="{{$sector->puesto}}" required>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div align="center" class="form-group col-md-12">
                                                                    <label  for="name" >Editar Fecha de Registro</label>
                                                                    <input  type="date"  min="2022-11-01" id="fechain" name="fechain" value="{{$sector->fechain}}" required>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button  class="btn btn-success" type="submit">Actualizar Resguardatario</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--Modal Editar -->
                                    <!--Modal Desactivar -->
                                    <form method="POST" action="{{route('desactivarsec',$sector->id)}}" >
                                        @csrf @method('PUT')

                                        <div class="modal" tabindex="-1" role="dialog" id="desModal{{$sector->id}}">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="alert alert-danger" style="display:none"></div>
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" style="color: black" >Dar de Baja Resguardatario</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4 style="color: red">¿Desea Realmente dar de Baja?</h4>
                                                        <h6 style="color: black">La acción no se podrá revertir</h6>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                                                        <button  class="btn btn-danger btn-sm" type="submit">Dar de Baja</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!--Modal Desactivar -->
                                </td>

                                <td>{{$sector->fechain}}</td>
                                <td>
                                    @if($sector-> condicion == 1)
                                        <span class="text-success">Activo</span>
                                    @else
                                        <span class="text-danger">Desactivado</span>
                                    @endif
                                </td>
                                @else
                                    <td>{{$sector->departamentos->nom_departamento}}</td>
                                    <td>{{$sector->nombre}}</td>
                                    <td>{{$sector->csp}}</td>
                                    <td>{{$sector->puesto}}</td>
                                    <td>Desactivado</td>
                                    <td>{{$sector->fechain}}</td>
                                    <td>
                                        @if($sector-> condicion == 1)
                                            <span class="text-success">Activo</span>
                                        @else
                                            <span class="text-danger">Desactivado</span>
                                        @endif
                                    </td>

                                @endif
                            </tr>
                            @endforeach
                        </table>
                            {{$sectores->render()}}<!--para la paginacion-->
                    @endif
                </div>
            </div>
        </div>


    </main>



@endsection
@extends('layouts.app')
@section('title', 'Resguardos')
@section('content')
    <main class="main">
        <!--<link href="/css/select2.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        -->

        <div class="container">
            <div class="panel panel-info">

                <div class="panel-heading center-block">
                    <h2 class="panel-title text-center" style="font-size: large">Registro, Gestión y Consulta de Resguardos</h2>
                </div>
            </div>
            <div class="form-group col-md-2">
                <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal" id="open">Asignar Resguardo</button>
            </div>
            <div align="center" class="form-group col-md-10">
                <!-- Formulario para Busqueda -->

                <form method="get" action="{{route('buscarres')}}">
                    <div class="col-md-5" >
                        <select name="tipo" id="" class="form-control" >
                            <option disabled >Seleccione el tipo</option>
                            <option value="fecha">Año de Resguardo</option>
                            <option value="id_sector">Número de Resguardatario</option>
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
            <form name="forbien" method="post" action="{{route('agregares')}}">
                @csrf
                <!-- Modal -->

                <div class="modal" tabindex="-1" role="dialog" id="myModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="alert alert-danger" style="display:none"></div>
                            <div class="modal-header">

                                <h3 class="modal-title" style="text-align: center">Resguardar Nuevo Bien</h3>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-md-6" align="center">
                                        <label for="res_list">Resguardatario:</label>
                                        <!-- <select name="res_list[]" id="res_list" class="form-control col-md-6" multiple required></select> -->
                                        <select name="id_sector" id="inputId_sector" class="form-control" required>
                                            <option value="">Seleccione el Resguardatario</option>
                                            @foreach($sectores as $sec)
                                                <option value="{{$sec['id']}}">{{$sec['nombre']}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6" align="center">
                                        <label for="Name">Seleccione el Bien a Resguardar:</label>
                                        <select name="id_bienres" id="inputId_bienres" class="form-control" required>
                                            <option value="">Seleccione el bien</option>
                                            @foreach($bienes as $bien)
                                                <option value="{{$bien['id']}}">{{$bien['nombre']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6" align="center">
                                        <label for="Name" >Fecha de Resguardo:</label>
                                        <input type="date" class="form-control" name="fecha" id="fecha" required>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button  class="btn btn-success" type="submit">Resguardar Bien</button>

                            </div>
                        </div>
                    </div>
                </div>

            </form>
            <!--Modal para Agregar-->



        </div>
        <br>
        <div class="container-fluid" >
            <div class="container">
                <div class="card-body">
                    @if($resguardos->isEmpty())
                        <div style="text-align: center; background-color: lightgoldenrodyellow">No hay Resguardos Disponibles</div><br>
                    @else
                        <table class="table table-bordered table-striped table-sm" style="color: black;text-align: center; background-color: lightyellow"  >
                            <thead>
                            <tr>

                                <th style="text-align: center">No.:</th>
                                <th style="text-align: center">Resguardatario:</th>
                                <th style="text-align: center">Categoría:</th>
                                <th style="text-align: center">Nombre y Serie del Bien:</th>
                                <th style="text-align: center">Fecha de Resguardo:
                                <th style="text-align: center">Opciones:</th>



                            </tr>
                            </thead>

                                        <tbody>
                                        @foreach($resguardos as $res)<!-- se crea un objeto para acceder a los datos-->
                                        @foreach($res->sectores as $sect)
                                            @foreach($res->bienes as $bien)
                                        <tr>
                                            <td>{{$sect->id}}</td>
                                            <td>{{$sect->nombre}}</td>
                                            <td>{{$bien->categorias->nombre}}</td>
                                            <td>{{$bien->nombre}}<br>
                                                Serial: {{$bien->serie}}</td>
                                            <td>{{$res->fecha}}</td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{$res->id}}">Cambiar</button>
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
                                                                            <label for="Name">Cambio de Resguardatario:</label>
                                                                            <select name="id_sector" id="inputId_sector" class="form-control" required>
                                                                                <option value="{{$sect->id}}">{{$sect->nombre}}</option> <!-- se actualizo esta parte-->
                                                                                @foreach($sectores as $sector)
                                                                                    <option value="{{$sector->id}}">{{$sector->nombre}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-6" align="center">
                                                                            <label for="Name" >Fecha de Resguardo:</label>
                                                                            <input type="date" class="form-control" name="fecha" id="fecha"
                                                                                   value="{{$res->fecha}}" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-6" align="center">
                                                                            <label for="Name">Cambio de Bien:</label>
                                                                            <select name="id_bienres" id="inputId_bienres" class="form-control" required>
                                                                                <option value="{{$bien->id}}">{{$bien->nombre}}</option> <!-- se actualizo esta parte-->
                                                                                @foreach($bienes as $bien)
                                                                                    <option value="{{$bien->id}}">{{$bien->nombre}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                    <button  class="btn btn-success" type="submit">Actualizar Resguardo</button>

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
                                        @endforeach

                                        @endforeach
                                        </tbody>


                        </table>
                        {{$resguardos->links()}}<!--para la paginacion-->
                    @endif
                </div>
            </div>
        </div>


    <!--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script>
        $('#res_list').select2({
            dropdownParent:$("#myModal"),
            placeholder: "Busque un Resguardatario...",
            minimumInputLength: 2,
            ajax: {
                url: '/Resguardos/find',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    </script> -->
    </main>


@endsection
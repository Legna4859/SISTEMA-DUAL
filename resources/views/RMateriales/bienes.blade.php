@extends('layouts.app')
@section('title', 'Bienes')
@section('content')
    <main class="main">

        <div class="container">
            <div class="panel panel-info">

                <div class="panel-heading center-block">
                    <h2 class="panel-title text-center" style="font-size: large">Registro, Gestion y Consulta de Bienes</h2>
                </div>
            </div>
            <div class="form-group col-md-2">
            <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal" id="open">Dar de Alta Bien</button>
            </div>
                <div align="center" class="form-group col-md-10">
                <!-- Formulario para Busqueda -->

                <form method="get" action="{{route('buscarbien')}}">
                    <div class="col-md-5" >
                        <select name="tipo" id="" class="form-control" >
                            <option disabled >Seleccione el tipo</option>
                            <option value="nombre">Nombre del Bien</option>
                            <option value="nick">Nick</option>
                            <option value="num_inventario">Numero de inventario</option>
                            <option value="serie">Número de Serie</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" type="search" name="buscarpor" placeholder="Buscar " aria-label="Search">


                    </div>
                    <button type="submit" class="btn btn-default col-md-1">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>

                </form>
                <!-- Fin formulario -->
            </div>



            <form name="forbien" method="post" action="{{route('altabien')}}" enctype="multipart/form-data" accept-charset="UTF-8">
                @csrf
                <!-- Modal -->

                <div class="modal" tabindex="-1" role="dialog" id="myModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="alert alert-danger" style="display:none"></div>
                            <div class="modal-header">

                                <h3 class="modal-title" style="text-align: center">Agregar Nuevo Bien</h3>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-md-6" align="center">
                                        <label for="Name"  >Nombre del Bien:</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" autocomplete="off" required>
                                    </div>
                                    <div class="form-group col-md-6" align="center">
                                        <label for="Name">Categoría:</label>

                                        <select name="id_categoria" id="inputId_categoria" class="form-control">
                                            <option value="">Seleccione la Categoría</option>
                                            @foreach($categorias as $cate)
                                                <option value="{{$cate['id']}}">{{$cate['nombre']}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6" align="center">
                                        <label for="Name">Tipo de Bien:</label>
                                        <select name="id_tipob" id="inputId_tipob" class="form-control" required>
                                            <option value="">Seleccione el tipo de bien</option>
                                            @foreach($bienest as $bient)
                                                <option value="{{$bient['id']}}">{{$bient['tipob']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6" align="center">
                                        <label for="Name">Provedor:</label>
                                        <select name="id_provedor" id="inputId_provedor" class="form-control" required>
                                            <option value="">Seleccione Provedor</option>
                                            @foreach($provedores as $prove)
                                                <option value="{{$prove['id']}}">{{$prove['nombre']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4" align="center">
                                        <label for="Name" >Número de Inventario:</label>
                                        <input type="text" class="form-control" name="num_inventario" id="num_inventario" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" align="center">
                                        <label for="Name" >Nic del Bien:</label>
                                        <input type="text" class="form-control" name="nick" id="nick" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" align="center">
                                        <label for="Name">No. de Serie:</label>
                                        <input type="text" class="form-control" name="serie" id="serie" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-12" align="center">
                                        <label class="text-danger">Nota: Los campos Numero de Inventario, Nic y Serie no seran actualizables</label>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12" align="center">
                                        <label for="Name">Características:</label>
                                        <input type="text" class="form-control" name="caracteristicas" id="caracteristicas" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="form-group col-md-4" align="center">
                                        <label for="Name">Costo con IVA:</label>
                                        <input type="float" class="form-control" name="costo" id="costo">
                                    </div>
                                    <div class="form-group col-md-4" align="center">
                                        <label for="Name" >Color:</label>
                                        <select name="id_color" id="inputId_color" class="form-control" required>
                                            <option value="">Seleccione Color</option>
                                            @foreach($colores as $col)
                                                <option value="{{$col['id']}}">{{$col['color']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4" align="center">
                                        <label for="Name" >Tipo de adquisición:</label>
                                        <select name="id_tipoadqui" id="inputId_tipoadqui" class="form-control" required>
                                            <option value="">Seleccione tipo de adquisición</option>
                                            @foreach($adquisiciones as $adqui)
                                                <option value="{{$adqui['id']}}">{{$adqui['tipoadqui']}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4" align="center">
                                        <label for="Name" >Modelo:</label>
                                        <select name="id_modelo" id="inputId_modelo" class="form-control" required>
                                                <option value="">Seleccione Modelo</option>
                                            @foreach($modelos as $bienm)
                                                <option value="{{$bienm['id']}}">{{$bienm['modelo']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4" align="center">
                                        <label for="Name">Estado de Uso:</label>
                                        <select name="id_estado" id="inputId_estado" class="form-control" required>
                                                <option value="">S. estado de uso</option>
                                            @foreach($usos as $biene)
                                                <option value="{{$biene['id']}}">{{$biene['estado']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4" align="center">
                                        <label for="Name" >Marca:</label>
                                        <select name="id_marca" id="inputId_marca" class="form-control" required>
                                            <option value="">Seleccione la Marca</option>
                                            @foreach($marcas as $bienm)
                                                <option value="{{$bienm['id']}}">{{$bienm['marca']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4" align="center">
                                        <label for="Name"  >Fecha de Adquisicion:</label>
                                        <input type="date" class="form-control" name="fechadqui" id="fechadqui" required>
                                    </div>
                                    <div class="form-group col-md-8" align="center">
                                        <label for="Name"  >Capturar Factura:</label>
                                        <input type="text" class="form-control" name="factura" id="factura" required>
                                    </div>
                                </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button id="btngenera"  class="btn btn-success" type="submit">Agregar Bien</button>

                                </div>
                            </div>
                        </div>

                </div>


            </form>


        </div>
        <br>
        <div class="container-fluid" >
            <div class="container-fluid">
                <div class="card-body">
                    @if($bienes->isEmpty())
                        <div style="text-align: center; background-color: lightgoldenrodyellow">No hay Bienes Disponibles</div><br>
                    @else
                        <table class="table table-bordered table-striped  " style="color: black;text-align: center; background-color: lightyellow"  >
                            <thead>
                            <tr>

                                <th style="text-align: center">Nombre:</th>
                                <th style="text-align: center">Categoría:</th>
                                <th style="text-align: center">Caracteristicas (Marca,Modelo):</th>
                                <th style="text-align: center">No.Inventario:</th>
                                <th style="text-align: center">Nick:</th>
                                <th style="text-align: center">Serie:</th>
                                <th style="text-align: center">Costo:</th>
                                <th style="text-align: center">Fecha Adquisicion:</th>
                                <th style="text-align: center">Tipo:</th>
                                <th style="text-align: center">Estado:</th>
                                <th style="text-align: center">Opciones:</th>
                                <th style="text-align: center">Número de Factura:</th>



                            </tr>
                            </thead>
                            @foreach($bienes as $bien)<!-- se crea un objeto para acceder a los datos-->
                            <tbody>
                            <tr>
                                <td>{{$bien->nombre}}</td>
                                <td>{{$bien->categorias->nombre}}</td>
                                <td>{{$bien->caracteristicas}}<br>
                                    {{$bien->marcas->marca}}<br>
                                    {{$bien->modelos->modelo}}
                                    {{$bien->colores->color}}<br>
                                </td>
                                <td>{{$bien->num_inventario}}</td>
                                <td>{{$bien->nick}}</td>
                                <td>{{$bien->serie}}</td>
                                <td>{{$bien->costo}}</td>
                                <td>{{$bien->fechadqui}}</td>
                                <td>{{$bien->bienest->tipob}}</td>
                                <td>
                                    @if($bien-> condicion == 1)
                                        <span class="text-success">Activo</span>
                                    @else
                                        <span class="text-danger">Desactivado</span>
                                    @endif
                                </td>
                                <td>
                                    @if($bien-> condicion == 1 && $bien->categorias->condicion = 1)

                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{$bien->id}}">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                        </button><br><br>
                                        <button type="button" class="btn btn-danger btn-sm"  data-toggle="modal" data-target='#desModal{{$bien->id}}'>
                                        <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                         <!--Modal Editar -->
                                        <form method="post" action="{{route('editarbien',$bien->id)}}">
                                            @csrf @method('PUT')
                                            <!-- Modal -->
                                            <div class="modal" tabindex="-1" role="dialog" id="editModal{{$bien->id}}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title" style="text-align: center">Actualizar Bien</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-6" align="center">
                                                                    <label for="Name">Categoría:</label>
                                                                    <select name="id_categoria" id="selectId_categoria" class="form-control" required>
                                                                        <option value="{{$bien->categorias->id}}">{{$bien->categorias->nombre}}</option>
                                                                        @foreach($categorias as $cate)
                                                                            <option value="{{$cate->id}}" >{{$cate->nombre}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-6" align="center">
                                                                    <label for="Name"  >Nombre del Bien:</label>
                                                                    <input type="text" class="form-control" name="nombre" id="nombre"
                                                                           autocomplete="off" required value="{{$bien->nombre}}">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-6" align="center">
                                                                    <label for="Name">Tipo de Bien:</label>
                                                                    <select name="id_tipob" id="inputId_tipob" class="form-control" required>
                                                                        <option value="{{$bien->bienest->id}}">{{$bien->bienest->tipob}}</option>
                                                                        @foreach($bienest as $bient)
                                                                            <option value="{{$bient->id}}">{{$bient->tipob}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-6" align="center">
                                                                    <label for="Name">Provedor:</label>
                                                                    <select name="id_provedor" id="inputId_provedor" class="form-control" required>
                                                                        <option value="{{$bien->provedores->id}}">{{$bien->provedores->nombre}}</option>
                                                                        @foreach($provedores as $prove)
                                                                            <option value="{{$prove->id}}">{{$prove->nombre}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-4" align="center">
                                                                    <label for="Name">Número de Inventario:</label>
                                                                    <input type="text" class="form-control" name="num_inventario" id="num_inventario" required
                                                                           value="{{$bien->num_inventario}}" disabled>
                                                                </div>
                                                                <div class="form-group col-md-4" align="center">
                                                                    <label for="Name">Nick del Bien:</label>
                                                                    <input type="number" class="form-control" name="nick" id="nick"
                                                                           autocomplete="off" required value="{{$bien->nick}}" disabled>
                                                                </div>
                                                                <div class="form-group col-md-4" align="center">
                                                                    <label for="Name">No. de Serie:</label>
                                                                    <input type="text" class="form-control" name="serie" id="serie"
                                                                           autocomplete="off" required value="{{$bien->serie}}"disabled>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-12" align="center">
                                                                    <label for="Name">Características:</label>
                                                                    <input type="text" class="form-control" name="caracteristicas" id="caracteristicas"
                                                                           autocomplete="off" value="{{$bien->caracteristicas}}">
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="form-group col-md-4" align="center">
                                                                    <label for="Name">Costo con IVA:</label>
                                                                    <input type="float" class="form-control"  name="costo" id="costo" value="{{$bien->costo}}"
                                                                           autocomplete="off" required>
                                                                </div>
                                                                <div class="form-group col-md-4" align="center">
                                                                    <label for="Name" >Color:</label>
                                                                    <select name="id_color" id="inputId_color" class="form-control" required>
                                                                        <option value="{{$bien->colores->id}}">{{$bien->colores->color}}</option>
                                                                        @foreach($colores as $col)
                                                                            <option value="{{$col->id}}">{{$col->color}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-4" align="center">
                                                                    <label for="Name" >Tipo de adquisición:</label>
                                                                    <select disabled name="id_tipoadqui" id="inputId_tipoadqui" class="form-control" required>

                                                                    </select>
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="form-group col-md-4" align="center">
                                                                    <label for="Name" >Modelo:</label>
                                                                    <select name="id_modelo" id="inputId_modelo" class="form-control" required>
                                                                        <option value="{{$bien->modelos->id}}">{{$bien->modelos->modelo}}</option>
                                                                        @foreach($modelos as $bienm)
                                                                            <option value="{{$bienm->id}}">{{$bienm->modelo}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-4" align="center">
                                                                    <label for="Name">Estado de Uso:</label>
                                                                    <select name="id_estado" id="inputId_estado" class="form-control" required>
                                                                        <option value="{{$bien->usos->id}}">{{$bien->usos->estado}}</option>
                                                                        @foreach($usos as $biene)
                                                                            <option value="{{$biene->id}}">{{$biene->estado}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-4" align="center">
                                                                    <label for="Name" >Marca:</label>
                                                                    <select name="id_marca" id="id_marca" class="form-control" required>
                                                                        <option value="{{$bien->marcas->id}}">{{$bien->marcas->marca}}</option>
                                                                        <!-- se actualizo esta parte en cada uno de los select del formulario editar-->
                                                                        @foreach($marcas as $bienm)
                                                                            <option value="{{$bienm->id}}">{{$bienm->marca}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-4" align="center">
                                                                    <label for="Name"  >Fecha de Adquisicion:</label>
                                                                    <input type="date" class="form-control" name="fechadqui" id="fechadqui"
                                                                           value="{{$bien->fechadqui}}" required>
                                                                </div>
                                                                <div class="form-group col-md-8" align="center">
                                                                    <label for="Name"  >Número de Factura:</label>
                                                                    <input type="input" class="form-control" name="factura" id="factura"
                                                                           autocomplete="off" value="{{$bien->factura}}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button  class="btn btn-success" type="submit">Actualizar Bien</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                        <!--Modal Desactivar -->
                                        <form method="POST" action="{{route('desactivarbien',$bien->id)}}" >
                                            @csrf @method('PUT')

                                            <div class="modal" tabindex="-1" role="dialog" id="desModal{{$bien->id}}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="alert alert-danger" style="display:none"></div>
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" style="color: black" >Desactivar Bien</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4 style="color: red">¿Desea Desactivar el Bien?</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                                                            <button  class="btn btn-danger btn-sm" type="submit">Desactivar Bien</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--Modal Desactivar -->
                                    @else
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target='#actModal{{$bien->id}}'>
                                        <span class="glyphicon glyphicon-ok"></span>
                                        </button>

                                        <!--Modal Activar -->
                                        <form method="POST" action="{{route('activarbien',$bien->id)}}" >
                                            @csrf @method('PUT')

                                            <div class="modal" tabindex="-1" role="dialog" id="actModal{{$bien->id}}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="alert alert-danger" style="display:none"></div>
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" style="color: black" >Activar Bien</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4>¿Desea Activar el Bien?</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                                                            <button  class="btn btn-success btn-sm" type="submit">Activar Bien</button>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--Modal Activar -->

                                    @endif
                                </td>
                                <td>{{$bien->factura}}</td>


                            </tr>
                            @endforeach
                        </table>
                        {{$bienes->links()}}<!--para la paginacion-->
                    @endif
                </div>
            </div>
        </div>

    </main>
    <script>
        let btnsubmit = document.getElementById('btngenera');
        btnsubmit.onclick = function () {

        }
        function genera(user_input) {
            var qrfinal = document.querySelector('.qrcode-final');
            var qrcode = new QRCode(qrfinal,{

            });

        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>



@endsection
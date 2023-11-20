@extends('layouts.app')
@section('title', 'Acciones')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Acciones</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <table id="table_accion" class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Descripcion de la Accion</th>
                        <th>Unidad de Medida</th>
                        <th>Editar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($acciones as $accion)
                        <tr>
                            <td>{{$accion->nom_accion}}</td>
                            <td>{{$accion->nom_unimed}}</td>
                            <td>
                                <a href="#!" class="modificar" data-id="{{ $accion->id_accion}}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1 col-md-offset-2">
                <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nueva accion" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
            </div>
            <br><br>
        </div>
        <br><br>
    </main>


    <form class="form" role="form" method="POST" >
        <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar acción</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="desc_programa">Nombre de la acción</label>
                                    <input type="text" class="form-control"name="nombre_accion" placeholder="Nombre de la acción" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-12">

                            <div class="dropdown">
                                <label for="selectPersonal">Unidad de medida</label>
                                <select class="form-control" id="selectunidad" name="selectunidad" required >
                                    <option disabled selected hidden>Selecciona una opción</option>
                                    @foreach($unidades as $unidad)
                                        <option value="{{$unidad->id_unimed}}"> {{ $unidad->nom_unimed }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input id="save_unidad" type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="modal_modificar_accion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form" action="{{url("/paa/acciones_paa/modificar_accion")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar acción</h4>
                    </div>
                    <div id="contenedor_modificar_accion">


                    </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input  type="submit" class="btn btn-primary" value="Guardar"/>
                </div>
                </form>
            </div>

        </div>
    </div>


    <script>

        $(document).ready(function() {



            $(".modificar").click(function (event) {
                var id=$(this).data("id");

                $.get("/paa/acciones_paa/modificar/"+id,function (request) {
                    $("#contenedor_modificar_accion").html(request);
                    $("#modal_modificar_accion").modal('show');
                });;


            });

            $('#table_accion').DataTable( {

            } );

        });
    </script>
@endsection
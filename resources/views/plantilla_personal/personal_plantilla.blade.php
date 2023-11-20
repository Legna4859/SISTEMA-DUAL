@extends('layouts.app')
@section('title', 'Personal en Plantilla')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">PERSONAL</h3>
                        </div>
                    </div>
                    <table id="paginar_table" class="table table-bordered ">
                        <thead>
                        <tr>
                          {{--  <th>Eliminar</th>--}}
                            <th>Clave</th>
                            <th>Nombre</th>
                            <th>Perfil</th>
                            <th>Agregar a una unidad</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($personal as $personal)
                            <tr>

                                <td>{{ $personal->clave }}</td>
                                <td>{{ $personal->nombre }}</td>
                                <td>{{ $personal->descripcion }}</td>
                           {{--     <td class="text-center"> <a class="eliminarpersonal" id="{{ $personal->id_personal }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                                </td> --}}
                                <td class="text-center">
                                    <a class="agrega" id="{{ $personal->id_personal }}"><span class="glyphicon glyphicon-log-in em2" aria-hidden="true"></span></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">PERSONAL EN UNA UNIDAD</h3>
                        </div>
                    </div>
                    <table id="agregados" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Nombre de la unidad</th>
                            <th>Eliminar</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($plantillas as $plantilla)
                            <tr>
                                <td>{{ $plantilla->nombre }}</td>
                                <td>{{$plantilla->nom_departamento}}</td>
                                <td class="text-center">
                                    <a class="elimina" id="{{ $plantilla->id_personal }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- MODAL PARA ELIMINAR -->
        <div id="modal_elimina" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form action="" method="POST" role="form" id="form_delete">
                            {{method_field('DELETE') }}
                            {{ csrf_field() }}
                            ¿Realmente deseas eliminar éste elemento?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input id="confirma_elimina" type="button" class="btn btn-danger" value="Aceptar"></input>
                    </div>
                    </form>
            </div>
        </div>
        </div>

        <!-- MODAL PARA ELIMINAR -->
        <div id="modal_eliminado" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form action="" method="POST" role="form" id="form_delete">
                            {{method_field('DELETE') }}
                            {{ csrf_field() }}
                            ¿Realmente deseas eliminar éste elemento?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input id="confirma_eliminado" type="button" class="btn btn-danger" value="Aceptar"></input>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- MODAL PARA AGREGAR personal A unidades -->

        <form id="form_agregar" class="form"  role="form" method="POST" >
            <div class="modal fade" id="modal_agrega" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Agregar a la unidad</h4>
                        </div>
                        <div class="modal-body">
                         <div class="row">
                            {{ csrf_field() }}
                            <input type="hidden" id="idpersonal" name="idpersonal" value="">

                                <div class="col-md-8 col-md-offset-1">

                                    <div class="dropdown">
                                        <label for="unidad">Unidad Administrativa</label>
                                        <select class="form-control" placeholder="selecciona una Opcion" id="unidad" name="unidad" >
                                            <option disabled selected>Selecciona una opción</option>
                                            @foreach($unidades as $unidad)
                                                <option value="{{$unidad->id_unidad_admin}}" data-esta="{{$unidad->nom_departamento}}"> {{$unidad->nom_departamento}}</option>
                                            @endforeach
                                        </select>


                                    </div>
                                </div>
                            </div>
                    </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_agregado"  class="btn btn-primary">Agregar</button>
                            </div>
                        </div>
                    </div>
                </div>
        </form>

    </main>

    <script>
        $(document).ready(function() {
            $('#paginar_table').DataTable();
            $(".elimina").click(function(){
                var id=$(this).attr('id');
                $('#confirma_elimina').data('id',id);
                $('#modal_elimina').modal('show');
            });
            $('#agregados').DataTable( {
                "order": [[ 0, "desc" ]]
            } );

            $("#paginar_table").on('click','.agrega',function(){
                var id=$(this).attr('id');
                $('#idpersonal').val(id);
                $('#modal_agrega').modal('show');
            });
            $("#guardar_agregado").click(function(event){
                $("#form_agregar").submit();
            });
            $("#form_agregar").validate({
                rules: {

                    unidad: "required",
                },
            });

            $("#confirma_elimina").click(function(event){
                var id_personal=($(this).data('id'));
                $("#form_delete").attr("action","/departamento/plantilla/"+id_personal)
                $("#form_delete").submit();
            });

            $("#paginar_table").on('click','.eliminarpersonal',function(){
                var id=$(this).attr('id');
                $('#confirma_eliminado').data('id',id);
                $('#modal_eliminado').modal('show');
            });
            $("#confirma_eliminado").click(function(event){
                var id=($(this).data('id'));
                $("#form_delete").attr("action","/departamentoplantilla/elimina/"+id)
                $("#form_delete").submit();
            });

        });

    </script>

@endsection

@extends('layouts.app')
@section('title', 'Unidad de medida')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Unidad de medida</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-3">
                <table id="table_unidad" class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Unidad de medida</th>
                        <th>Editar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($unidadmedidas as $unidad)
                        <tr>
                            <td>{{$unidad->nom_unimed}}</td>
                            <td>
                                <a href="#!" class="modificar" data-id="{{ $unidad->id_unimed}}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                            </td>


                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1 col-md-offset-2">
                <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nueva unidad de medida" data-target="#modal_crear_unidad" type="button" class="btn btn-success btn-lg flotante">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
            </div>
            <br><br>
        </div>
        <br><br>
    </main>


    <form class="form" role="form" method="POST" >
        <div class="modal fade" id="modal_crear_unidad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar unidad de medida</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="desc_programa">Nombre de la unidad de medida</label>
                                    <input type="text" class="form-control"name="nombre_unidad" placeholder="Nombre de la unidad de medida" required>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input id="save_subprograma" type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form id="form_unidad_modificar" class="form" role="form" method="POST"  action="">
        <div class="modal fade" id="modal_modificar_unidad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Modificar unidad medida</h4>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="des_parte_modi">Nombre de la unidad de medida</label>
                                    <input type="text" class="form-control" id="unidad" name="unidad" placeholder="Nombre de la unidad" required>
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


    <script>

        $(document).ready(function() {


            $(".modificar").click(function(){
                var id=$(this).data("id");
                $.get("/paa/unidad_medida/modificar/"+id,function(res){
                    $("#form_unidad_modificar").attr("action","/paa/unida_medida/modificacion/"+id);
                    $("#unidad").val(res.nom_unimed);
                    $("#modal_modificar_unidad").modal("show");

                });
            });

            $('#table_unidad').DataTable( {

            } );

        });
    </script>
@endsection
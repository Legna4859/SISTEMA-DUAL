@extends('layouts.app')
@section('title', 'Programa')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Programa</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-3">
                <table class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Editar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($programas as $programa)
                        <tr>
                            <td>{{$programa->nom_programa}}</td>

                            <td>
                                <a href="#!" class="modificar" data-id="{{ $programa->id_programa}}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                            </td>


                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1 col-md-offset-2">
            <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nuevo programa" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
            </div>
            <br><br>
        </div>
        <br><br>
    </main>


    <form id="form_parte_crea" class="form" role="form" method="POST" >
        <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar programa</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="desc_programa">Nombre del programa</label>
                                    <input type="text" class="form-control"name="desc_programa" placeholder="Nombre del programa" required>
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

    <form id="form_programa_modificar" class="form" role="form" method="POST"  action="">
        <div class="modal fade" id="modal_modificar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Modificar Programa</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="des_parte_modi">Nombre del programa</label>
                                    <input type="text" class="form-control" id="nom_programa" name="nom_programa" placeholder="Nombre del programa" required>
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
                $.get("/paa/programa_paa/modificar/"+id,function(res){
                    $("#form_programa_modificar").attr("action","/paa/programa_paa/modificacion/"+id);
                    $("#nom_programa").val(res.nom_programa);
                    $("#modal_modificar").modal("show");

                });
            });



        });
    </script>
@endsection
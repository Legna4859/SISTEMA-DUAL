@extends('layouts.app')
@section('title', 'Unidades Administrativas')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                @if (session()->has('flash_notification.message'))
                    <div class="alert alert-{{ session('flash_notification.level') }}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! session('flash_notification.message') !!}
                    </div>
                @endif
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Unidades Administrativas</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <table class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Clave</th>
                        <th>Codigo</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($unidades as $unidad)
                        <tr>
                            <td>{{$unidad->nom_departamento}}</td>

                            <td>
                                {{ $unidad->clave }}
                            </td>
                            <td>
                                {{ $unidad->cod}}
                            </td>
                            <td>
                                <a href="#!" class="modificar" data-id="{{ $unidad->id_unidad_admin }}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                            </td>

                            <td>
                                <a class="elimina" data-id="{{ $unidad->id_unidad_admin }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div>
        <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nuevo departamento" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
    </div>
    <form id="form_unidad_crea" class="form" role="form" method="POST" >
        <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Agregar Unidad Administrativa</h4>
                        </div>
                        <div class="modal-body">

                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" name="nombre" placeholder="Nombre">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="clave">Clave</label>
                                        <input type="text" class="form-control"name="clave" placeholder="Nombre">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codigo">Codigo</label>
                                        <input type="number" class="form-control"name="codigo" placeholder="Nombre">
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

    <form id="form_unidad_modi" class="form" role="form" method="POST"  action="">
        <div class="modal fade" id="modal_modi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Modificar Unidad Administrativa</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nombre_modi">Nombre</label>
                                    <input type="text" class="form-control" id="nombre_modi" name="nombre_modi" placeholder="Nombre">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="clave_modi">Clave</label>
                                    <input type="text" class="form-control" id="clave_modi" name="clave_modi" placeholder="Nombre">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="codigo_modi">Codigo</label>
                                    <input type="number" class="form-control" id="codigo_modi" name="codigo_modi" placeholder="Nombre">
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

    <form action="" method="POST" role="form" id="form_delete">
        {{method_field('DELETE') }}
        {{ csrf_field() }}
    </form>
    <script>

        $('.colorpicker-component').colorpicker();

        $(document).ready(function() {

            $(".elimina").click(function(){
                var id=$(this).data('id');
                swal({
                    title: "Seguro que desea eliminar?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $("#form_delete").attr("action","/generales/unidad_administrativa/"+id)
                            $("#form_delete").submit();
                        }
                    });
            });
            $(".modificar").click(function(){
                var id=$(this).data("id");
                $.get("/generales/unidad_administrativa/"+id+"/edit",function(res){

                    $("#form_unidad_modi").attr("action","/generales/unidad_administrativa/"+id);

                    $("#nombre_modi").val(res.nom_departamento);
                    $("#clave_modi").val(res.clave);
                    $("#codigo_modi").val(res.cod);
                    $("#modal_modi").modal("show");

                });
            });


            $("#form_unidad_crea").validate({
                rules: {
                    nombre: {
                        required: true,
                    },
                    codigo: {
                        required: true,
                    },
                    clave: {
                        required: true,
                    },
                },
            });
            $("#form_unidad_modi").validate({
                rules: {
                    nombre_modi: {
                        required: true,
                    },
                    codigo_modi: {
                        required: true,
                    },
                    clave_modi: {
                        required: true,
                    },
                },
            });


        });
    </script>
@endsection
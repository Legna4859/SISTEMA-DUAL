@extends('layouts.app')
@section('title', 'Jefes Unidades Administrativas')
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
                        <th>Unidad</th>
                        <th>Jefe Area</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($jefes_unidades as $jefe_unidad)
                        <tr>
                            <td>{{$jefe_unidad->nom_departamento}}</td>

                            <td>
                                {{ $jefe_unidad->nombre }}
                            </td>

                            <td>
                                <a href="#!" class="modificar" data-id="{{ $jefe_unidad->id_unidad_persona }}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                            </td>

                            <td>
                                <a class="elimina" data-id="{{ $jefe_unidad->id_unidad_persona }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div>
        <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nuevo jefe de departamento" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
    </div>
    <form id="form_jefe_unidad_crea" class="form" role="form" method="POST" >
        <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Agregar Jefe Unidad Administrativa</h4>
                        </div>
                        <div class="modal-body">

                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="personal">Peronal</label>
                                        <select class="form-control" name="personal" id="personal">

                                            <option disabled value="" selected>Seleccione una opción</option>
                                            @foreach($personal as $persona)
                                                <option value="{{$persona->id_personal}}">{{$persona->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="unidad_administrativa">Unidad Administrativa</label>
                                        <select class="form-control" name="unidad_administrativa" id="unidad_administrativa">
                                            <option disabled value="" selected>Seleccione una opción</option>
                                            @foreach($unidad_administrativa as $unidad)
                                                <option value="{{$unidad->id_unidad_admin}}">{{$unidad->nom_departamento}}</option>
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

    <form id="form_jefe_unidad_modi" class="form" role="form" method="POST"  action="">
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="personal_modi">Peronal</label>
                                        <select class="form-control" name="personal_modi" id="personal_modi">
                                            <option disabled value="">Seleccione una opción</option>
                                            @foreach($personal as $persona)
                                                <option value="{{$persona->id_personal}}">{{$persona->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="unidad_administrativa_modi">Unidad Administrativa</label>
                                        <select class="form-control" name="unidad_administrativa_modi" id="unidad_administrativa_modi">
                                            <option disabled value="">Seleccione una opción</option>
                                            @foreach($unidad_administrativa as $unidad)
                                                <option value="{{$unidad->id_unidad_admin}}">{{$unidad->nom_departamento}}</option>
                                            @endforeach
                                        </select>
                                    </div>
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
                            $("#form_delete").attr("action","/generales/jefe_unidad_administrativa/"+id)
                            $("#form_delete").submit();
                        }
                    });
            });
            $(".modificar").click(function(){
                var id=$(this).data("id");
                $.get("/generales/jefe_unidad_administrativa/"+id+"/edit",function(res){

                    $("#form_jefe_unidad_modi").attr("action","/generales/jefe_unidad_administrativa/"+id);

                    $("#unidad_administrativa_modi").val(res.id_unidad_admin);
                    $("#personal_modi").val(res.id_personal);
                    $("#modal_modi").modal("show");

                });
            });


            $("#form_jefe_unidad_crea").validate({
                rules: {
                    personal: {
                        required: true,
                    },
                    unidad_administrativa: {
                        required: true,
                    },

                },
            });
            $("#form_jefe_unidad_modi").validate({
                rules: {
                    personal_modi: {
                        required: true,
                    },
                    unidad_administrativa_modi: {
                        required: true,
                    },
                },
            });


        });
    </script>
@endsection
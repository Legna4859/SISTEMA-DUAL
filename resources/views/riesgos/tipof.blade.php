@extends('layouts.app')
@section('title', 'tipo_f')
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
                        <h3 class="panel-title text-center">Tipo Factor</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <table class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($factores as $factor)
                        <tr>
                            <td>{{$factor->des_tf}}</td>

                            <td>
                                <a href="#!" class="modificar" data-id="{{ $factor->id_tipo_f }}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                            </td>

                            <td>
                                <a class="elimina" data-id="{{ $factor->id_tipo_f }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div>
        <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nuevo tipo factor" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
    </div>
    <form id="form_tipof_crea" class="form" role="form" method="POST" >
        <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar Tipo Factor</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="des_tipof">Descripción Tipo Factor</label>
                                    <input type="text" class="form-control"name="des_tipof" placeholder="Nombre">
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

    <form id="form_tipof_modi" class="form" role="form" method="POST"  action="">
        <div class="modal fade" id="modal_modi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Modificar Tipo Factor</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="des_tipof_modi">Descripción Tipo Factor</label>
                                    <input type="text" class="form-control" id="des_tipof_modi" name="des_tipof_modi" placeholder="Nombre">
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




Swal.fire({
                    title: '¿Seguro que desea eliminar?',
            type:'error',
                    showCancelButton: true,
                    confirmButtonText: `Aceptar`,
                    cancelButtonText: `Cancelar`,
                }).then((result) => {
  /* Read more about isConfirmed, isDenied below */
                    if (result.value) {
                            $("#form_delete").attr("action","/riesgos/tipof/"+id)
                            $("#form_delete").submit();
                        }
                    });
            });
            $(".modificar").click(function(){
                var id=$(this).data("id");
                $.get("/riesgos/tipof/"+id+"/edit",function(res){

                    $("#form_tipof_modi").attr("action","/riesgos/tipof/"+id);
                    $("#des_tipof_modi").val(res.des_tf);
                    $("#modal_modi").modal("show");
                });
            });


            $("#form_tipof_crea").validate({
                rules: {
                    des_tipof: {
                        required: true,
                    },
                    /* codigo: {
                         required: true,
                     },
                     clave: {
                         required: true,
                     },*/
                },
            });
            $("#form_tipof_modi").validate({
                rules: {
                    des_tipof_modi: {
                        required: true,
                    },
                    /* codigo: {
                         required: true,
                     },
                     clave: {
                         required: true,
                     },*/
                },
            });
        });
    </script>
@endsection
@extends('layouts.app')
@section('title', 'Potencial Costo')
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
                        <h3 class="panel-title text-center">Potencial Costo de Implementación</h3>
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
                    @foreach($potencialcostos as $potencialcosto)
                        <tr>
                            <td>{{$potencialcosto->des_potencialcosto}}</td>

                            <td>
                                <a href="#!" class="modificar" data-id="{{ $potencialcosto->id_potencialcosto }}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                            </td>

                            <td>
                                <a class="elimina" data-id="{{ $potencialcosto->id_potencialcosto}}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div>
        <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar Potencial Costo de Implementación" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
    </div>
    <form id="form_potencialcosto_crea" class="form" role="form" method="POST" >
        <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar Potencial Costo de Implementación</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="des_potencialcosto">Descripción Potencial Costo de Implementación</label>
                                    <input type="text" class="form-control"name="des_potencialcosto" placeholder="Nombre">
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

    <form id="form_potencialcosto_modi" class="form" role="form" method="POST"  action="">
        <div class="modal fade" id="modal_modi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Modificar Potencial Costo de Implementación</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="des_potencialcosto_modi">Descripción potencial costo</label>
                                    <input type="text" class="form-control" id="des_potencialcosto_modi" name="des_potencialcosto_modi" placeholder="Nombre">
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
  showCancelButton: true,
  confirmButtonText: `Aceptar`,
  denyButtonText: `Cancelar`,
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
                    if (result.value) {
                            $("#form_delete").attr("action","/riesgos/potencialcosto/"+id)
                            $("#form_delete").submit();
                        }
                    });
            });
            $(".modificar").click(function(){
                var id=$(this).data("id");
                $.get("/riesgos/potencialcosto/"+id+"/edit",function(res){

                    $("#form_potencialcosto_modi").attr("action","/riesgos/potencialcosto/"+id);
                    $("#des_potencialcosto_modi").val(res.des_potencialcosto);

                    $("#modal_modi").modal("show");
                });
            });


            $("#form_potencialcosto_crea").validate({
                rules: {
                    des_potencialcosto: {
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
            $("#form_potencialcosto_modi").validate({
                rules: {
                    des_potencialcosto_modi: {
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
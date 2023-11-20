@extends('layouts.app')
@section('title', 'Estrategia')
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
                    <h3 class="panel-title text-center">Estrategia</h3>
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
                @foreach($estrategias as $estrategia)
                    <tr>
                        <td>{{$estrategia->descripcion}}</td>
                        <td>
                            <a href="#!" class="modificar" data-id="{{ $estrategia->id_estrategia }}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                        </td>
                        <td>
                            <a class="elimina" data-id="{{ $estrategia->id_estrategia }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</main>

<div>
    <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nueva estrategia" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
    </button>
</div>
<form id="form_estrategia_crea" class="form" role="form" method="POST" >
    <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar Estrategia</h4>
                </div>
                <div class="modal-body">

                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descripcion">Descripción Estrategia</label>
                                <input type="text" class="form-control"name="descripcion" placeholder="Nombre">
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

<form id="form_estrategia_modi" class="form" role="form" method="POST"  action="">
    <div class="modal fade" id="modal_modi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar Estrategia</h4>
                </div>
                <div class="modal-body">

                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="des_estrategia_modi">Descripción Estrategia</label>
                                <input type="text" class="form-control" id="des_estrategia_modi" name="des_estrategia_modi" placeholder="Nombre">
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
                        $("#form_delete").attr("action","/riesgos/estrategia/"+id)
                        $("#form_delete").submit();
                    }
                });
        });
        $(".modificar").click(function(){
            var id=$(this).data("id");
            $.get("/riesgos/estrategia/"+id+"/edit",function(res){

                $("#form_estrategia_modi").attr("action","/riesgos/estrategia/"+id);
                $("#des_estrategia_modi").val(res.descripcion);
                $("#modal_modi").modal("show");
            });
        });
        $("#form_estrategia_crea").validate({
            rules: {
                descripcion: {
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
        $("#form_estrategia_modi").validate({
            rules: {
                des_estrategia_modi: {
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
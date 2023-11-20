@extends('layouts.app')
@section('title', 'Proceso')
@section('content')

    <main class="col-md-12">
        <div class="row">
            {{--<div class="col-md-10 col-xs-10 col-md-offset-1">--}}
                {{--<p>--}}
                    {{--<span class="glyphicon glyphicon-arrow-right"></span>--}}
                    {{--<a href="{{url("/home")}}">Home</a>--}}
                    {{--<span class="glyphicon glyphicon-chevron-right"></span>--}}
                    {{--<span>Registro Procesos</span>--}}
                {{--</p>--}}
                {{--<br>--}}
            {{--</div>--}}
            <div class="col-md-5 col-md-offset-3">
                @if (session()->has('flash_notification.message'))
                    <div class="alert alert-{{ session('flash_notification.level') }}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! session('flash_notification.message') !!}
                    </div>
                @endif
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Proceso, procedimiento o control de actividad</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <table class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Sistema</th>
                        <th>Agregar Partes Interesadas</th>
                        {{---<th>Editar</th>
                                                  <th>Eliminar</th>
                       --}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($procesos as $proceso)
                        <tr>
                            <td>{{$proceso->des_proceso}}</td>

                            <td>{{isset($proceso->sistema[0])?$proceso->sistema[0]->desc_sistema:""}}</td>
                            <td>
                                <a href="{{url("/riesgos/add_partes")."/".$proceso->id_proceso}}" ><span class="glyphicon glyphicon-th em2" aria-hidden="true"></span></a>
                            </td>  {{--
                            <td>
                                <a href="#!" class="modificar" data-id="{{ $proceso->id_proceso }}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                            </td>

                                                        <td>

                                                            <a class="elimina" data-id="{{ $proceso->id_proceso }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>

                            </td> --}}
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </main>
    {{--
       <div>
      {{--
           <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nuevo proceso" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
               <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
           </button>

    </div>
    <form id="form_proceso_crea" class="form" role="form" method="POST" >
        <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar Proceso</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="des_proceso">Descripción  proceso</label>
                                    <input type="text" class="form-control"name="des_proceso" placeholder="Nombre">
                                    <label for="id_sistema" class="col-form-label">Sistema</label>
                                    <select class="form-control" name="id_sistema" id="id_sistema">
                                        <option value="" disabled="true" selected="true">Seleccione una opción</option>
                                        @foreach($sistemas as $sistema)
                                            <option value="{{$sistema->id_sistema}}">{{$sistema->desc_sistema}}</option>
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

    <form id="form_proceso_modi" class="form" role="form" method="POST"  action="">
        <div class="modal fade" id="modal_modi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Modificar proceso</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="des_proceso_modi">Descripción proceso</label>
                                    <input type="text" class="form-control" id="des_proceso_modi" name="des_proceso_modi" placeholder="Nombre">
                                    <label for="id_sistema_edit" class="col-form-label">Sistema</label>

                                    <select class="form-control" name="id_sistema_edit" id="id_sistema_edit">
                                        <option value="" disabled="true" selected="true">Seleccione una opción</option>
                                        @foreach($sistemas as $sistema)
                                            <option value="{{$sistema->id_sistema}}">{{$sistema->desc_sistema}}</option>
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
                            $("#form_delete").attr("action","/riesgos/proceso/"+id)
                            $("#form_delete").submit();
                        }
                    });
            });
            $(".modificar").click(function(){
                var id=$(this).data("id");
                $.get("/riesgos/proceso/"+id+"/edit",function(res){
    console.log(res)
                    $("#form_proceso_modi").attr("action","/riesgos/proceso/"+id);
                    $("#des_proceso_modi").val(res.des_proceso);
                    $("#id_sistema_edit").val(res.id_sistema);

                    $("#modal_modi").modal("show");
                });
            });


            $("#form_proceso_crea").validate({
                rules: {
                    des_proceso: {
                        required: true,
                    },

                    id_sistemna: {
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
            $("#form_proceso_modi").validate({
                rules: {
                    des_proceso_modi: {
                        required: true,
                    },
                    id_sistema_edit: {
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
    </script>  --}}
@endsection
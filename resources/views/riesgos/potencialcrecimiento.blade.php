@extends('layouts.app')
@section('title', 'Potencial Crecimiento')
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
                        <h3 class="panel-title text-center">Potencial de Crecimiento de la Matrícula Actual</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <table class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Calificación</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($potencialcrecimientos as $potencialcrecimiento)
                        <tr>
                            <td>{{$potencialcrecimiento->des_potencialcrecimiento}}</td>
                            <td>{{$potencialcrecimiento->calificacion}}</td>


                            <td>
                                <a href="#!" class="modificar" data-id="{{ $potencialcrecimiento->id_potencialcrecimiento }}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                            </td>

                            <td>
                                <a class="elimina" data-id="{{ $potencialcrecimiento->id_potencialcrecimiento}}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div>
        <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar Potencial de Crecimiento de la Matrícula Actual" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
    </div>
    <form id="form_potencialcrecimiento_crea" class="form" role="form" method="POST" >
        <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar Potencial de Crecimiento de la Matrícula Actual</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="des_potencialcrecimiento">Descripción Potencial de Crecimiento de la Matrícula Actual</label>
                                    <input type="text" class="form-control"name="des_potencialcrecimiento" placeholder="Nombre">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="calificacion">Calificación</label>
                                    <select name="calificacion" id="calificacion" class="form-control">
                                        <option selected disabled> Elige Opción</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>

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

    <form id="form_potencialcrecimiento_modi" class="form" role="form" method="POST"  action="">
        <div class="modal fade" id="modal_modi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Modificar Potencial de Crecimiento de la Matrícula Actual</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="des_potencialcrecimiento_modi">Descripción Potencial de Crecimiento de la Matrícula Actual</label>
                                    <input type="text" class="form-control" id="des_potencialcrecimiento_modi" name="des_potencialcrecimiento_modi" placeholder="Nombre">
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="calificacion_modi">Calificación</label>
                                    <select name="calificacion_modi" id="calificacion_modi" class="form-control">
                                        <option selected disabled> Elige Opción</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>

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
                            $("#form_delete").attr("action","/riesgos/potencialcrecimiento/"+id)
                            $("#form_delete").submit();
                        }
                    });
            });
            $(".modificar").click(function(){
                var id=$(this).data("id");
                $.get("/riesgos/potencialcrecimiento/"+id+"/edit",function(res){

                    $("#form_potencialcrecimiento_modi").attr("action","/riesgos/potencialcrecimiento/"+id);
                    $("#des_potencialcrecimiento_modi").val(res.des_potencialcrecimiento);
                    $("#calificacion_modi").val(res.calificacion);
                    $("#modal_modi").modal("show");
                });
            });


            $("#form_potencialcrecimiento_crea").validate({
                rules: {
                    des_potencialcrecimiento: {
                        required: true,
                    },
                    calificacion: {
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
            $("#form_potencialcrecimiento_modi").validate({
                rules: {
                    des_potencialcrecimiento_modi: {
                        required: true,
                    },
                    calificacion_modi: {
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
@endsection/
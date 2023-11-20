@extends('layouts.app')
@section('title', 'Potencial Apertura')
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
                        <h3 class="panel-title text-center">Potencial de apertura de nuevos programas de estudio</h3>
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
                    @foreach($potencialaperturas as $potencialapertura)
                        <tr>
                            <td>{{$potencialapertura->des_potencialapertura}}</td>
                            <td>{{$potencialapertura->calificacion}}</td>


                            <td>
                                <a href="#!" class="modificar" data-id="{{ $potencialapertura->id_potencialapertura }}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                            </td>

                            <td>
                                <a class="elimina" data-id="{{ $potencialapertura->id_potencialapertura }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div>
        <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar Potencial de apertura de nuevos programas de estudio" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
    </div>
    <form id="form_potencialapertura_crea" class="form" role="form" method="POST" >
        <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar Potencial de apertura de nuevos programas de estudio</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="des_potencialapertura">Descripción Potencial de apertura de nuevos programas de estudio</label>
                                    <input type="text" class="form-control"name="des_potencialapertura" placeholder="Nombre">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="calificacion">Calificación</label>
                                    <select name="calificacion" id="calificacion" class="form-control">
                                        <option selected disabled> Elige Opción</option>
                                        @for($i=1 ;$i<=5;$i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor

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

    <form id="form_potencialapertura_modi" class="form" role="form" method="POST"  action="">
        <div class="modal fade" id="modal_modi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Modificar Potencial de apertura de nuevos programas de estudio</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="des_potencialapertura_modi">Descripción potencial apertura</label>
                                    <input type="text" class="form-control" id="des_potencialapertura_modi" name="des_potencialapertura_modi" placeholder="Nombre">
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="calificacion_modi">Calificación</label>
                                    <select name="calificacion_modi" id="calificacion_modi" class="form-control">
                                        @for($i=1 ;$i<=5;$i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor

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
                            $("#form_delete").attr("action","/riesgos/potencialapertura/"+id)
                            $("#form_delete").submit();
                        }
                    });
            });
            $(".modificar").click(function(){
                var id=$(this).data("id");
                $.get("/riesgos/potencialapertura/"+id+"/edit",function(res){

                    $("#form_potencialapertura_modi").attr("action","/riesgos/potencialapertura/"+id);
                    $("#des_potencialapertura_modi").val(res.des_potencialapertura);
                    $("#calificacion_modi").val(res.calificacion);
                    $("#modal_modi").modal("show");
                });
            });


            $("#form_potencialapertura_crea").validate({
                rules: {
                    des_potencialapertura: {
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
            $("#form_potencialapertura_modi").validate({
                rules: {
                    des_potencialapertura_modi: {
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
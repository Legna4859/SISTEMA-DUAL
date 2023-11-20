@extends('layouts.app')
@section('title', 'Actividades para la agenda')
@section('content')
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @if (session()->has('flash_notification.message'))
                    <div class="alert alert-{{ session('flash_notification.level') }}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! session('flash_notification.message') !!}
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <a href="#" class="add_actividad pull-right" data-type="2"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar actividad"></span></a>
                    <h3 class="panel-title text-center">Actividades para la agenda</h3>
                </div>
                @if(sizeof($actividades)>0)
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <th class="col-md-10">Descripción</th>
                            <th class="col-md-2">Acciones</th>
                            </thead>
                            <tbody>
                            @foreach($actividades as $actividad)
                                <tr>
                                    <td>{{$actividad->descripcion}}</td>
                                    <td class="text-center">
                                        <a href="#!" class="pull-left btn_edit_actividad" data-all="{{$actividad}}" data-toggle="tooltip" title="Editar actividad"><span class="glyphicon glyphicon-cog"></span></a>
                                        <a href="#!" class="pull-right btn_delete_actividad" data-id="{{$actividad->id_actividad}}" data-toggle="tooltip" title="Eliminar actividad"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
{{--                        <a href="#" class="add_actividad pull-right" data-type="2"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar actividad"></span></a>--}}
                    </div>
                @else
                    <div class="row">
                        <br>
                        <div class="col-md-10 col-md-offset-1 alert alert-danger" role="alert">No existen actividades registradas</div>
                    </div>

                @endif
            </div>
        </div>
    </main>


    <div class="modal fade" id="modal_add_actividad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Registro de actividad</h4>
                </div>
                <form id="form_add_actividad" class="form" role="form" method="POST" action="{{url('/auditorias/actividades')}}">
                    @csrf
                    <div class="modal-body">
                        @if($errors->any())
                            <div class="alert alert-danger errors" role="alert">
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion" placeholder="Descripción de la actividad"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edit_actividad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Editar actividad</h4>
                </div>
                <form id="form_edit_actividad" class="form" role="form" method="POST" action="{{url('/auditorias/actividades')}}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Descripción de la actividad">{{old('descripcion')}}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form  method="POST" role="form" id="form_delete_actividad">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>


    <script>
        $(document).ready(function () {

            $(".add_actividad").click(function () {
                $("#modal_add_actividad").modal('show');
            });

            $('.btn_edit_actividad').click(function () {
                var datos=$(this).data('all');
                $('#form_edit_actividad').attr('action',"{{url('auditorias/actividades')}}/"+datos['id_actividad'])
                $('#descripcion').val(datos['descripcion'])
                $("#modal_edit_actividad").modal('show');

            });

            $(".btn_delete_actividad").click(function(){
                var id=$(this).data('id');
                swal({
                    title: "Seguro que desea eliminar?",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Aceptar',
                })
                    .then((result) => {
                        if (result.value) { //Si presionas boton aceptar
                            $("#form_delete_actividad").attr("action","/auditorias/actividades/"+id)
                            $("#form_delete_actividad").submit();
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) { //Si presionas boton cancelar
                            swal.close()
                        }
                    });
            });

            @if($errors->any())
                $('#modal_add_actividad').modal('show');
                setTimeout(function () {
                    $('.errors').fadeOut(500);
                },5000)
            @endif

            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>

@endsection

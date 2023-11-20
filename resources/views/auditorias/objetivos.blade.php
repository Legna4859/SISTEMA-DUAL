<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 21/06/2019
 * Time: 11:08 AM
 */
?>
@extends('layouts.app')
@section('title', 'Objetivos')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @if (session()->has('flash_notification.message'))
                    <div class="alert alert-{{ session('flash_notification.level') }}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! session('flash_notification.message') !!}
                    </div>
                @endif
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Objetivos</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-resposive">
                            <thead>
                            <tr class="row">
                                <th class="col-md-11">Descripción del Objetivo</th>
                                <th class="col-md-1 text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($objetivos as $objetivo)
                                <tr class="row">
                                    <td class="col-md-11">
                                        {{$objetivo->descripcion}}
                                    </td>
                                    <td class="col-md-1 text-center">
                                        <a href="#!" class="btn_mod_objetivo" data-all="{{$objetivo}}"><span class="pull-left glyphicon glyphicon-cog" data-toggle="tooltip" title="Configurar objetivo"></span></a>
                                        <a href="#!" class="btn_delete_objetivo" data-id="{{$objetivo->id_objetivo}}"><span class="pull-right glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar objetivo"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <form  method="POST" role="form" id="form_delete_objetivo">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>


    <div>
        <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar objetivo" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
    </div>
    <form id="form_objetivo_crea" class="form" role="form" method="POST" action="{{url('auditorias/objetivos')}}">
        <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar Objetivo</h4>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descripcion">Objetivo</label>
                                    <input type="text" class="form-control"name="descripcion" placeholder="Descripción">
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

    <form id="form_mod_objetivo" class="form" role="form" method="POST"  action="">
        <div class="modal fade" id="modal_modi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Modificar Objetivo</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descripcion_modi">Objetivo</label>
                                    <input type="text" class="form-control" id="descripcion_modi" name="descripcion_modi" placeholder="Descripcion">
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

    <form action="" method="POST" role="form" id="form_delete_objetivo">
        {{method_field('DELETE') }}
        {{ csrf_field() }}
    </form>
    <script>

        $(document).ready(function() {

            $(".btn_delete_objetivo").click(function(){
                var id=$(this).data('id');
                swal({
                    title: "Seguro que desea eliminar?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $("#form_delete_objetivo").attr("action","/auditorias/objetivos/"+id)
                            $("#form_delete_objetivo").submit();
                        }
                    });
            });

            $(".btn_mod_objetivo").click(function(){
                var data=$(this).data("all");
                $("#form_mod_objetivo").attr("action","/auditorias/objetivos/"+data['id_objetivo']);
                $("#descripcion_modi").val(data['descripcion']);
                $("#modal_modi").modal("show");
            });

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
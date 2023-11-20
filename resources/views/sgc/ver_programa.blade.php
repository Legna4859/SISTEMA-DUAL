<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 09/07/2019
 * Time: 08:16 PM
 */
?>
@extends('layouts.app')
@section('title','Ver programa')
@section('content')
    @if(Session::get('errors'))
        <div class="alert alert-danger" role="alert">
            @foreach(Session::get('errors')->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </div>
        @if(Session::forget('errors'))@endif
    @endif
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
                @foreach($programas as $programa)
                <div class="panel-heading">
                    <a href="{{url('sgc/programa')}}/{{$programa->id_programa}}/edit" ><span class="pull-right glyphicon glyphicon-calendar" data-toggle="tooltip" title="Agendar auditorias"></span></a>
                    <h3 class="panel-title text-center">Programa de auditorías
                        <strong>
                            {{\Jenssegers\Date\Date::parse($programa->fecha_i)->format('F')}} - {{\Jenssegers\Date\Date::parse($programa->fecha_f)->format('F Y')}}
                        </strong>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Lugar: </label>
                            <p>{{$programa->lugar}}</p>
                        </div>
                        <div class="col-md-6">
                            <label>Alcance:</label>
                            <p>{{$programa->alcance}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Objetivos</label>
                            <a href="#" class="btn_add_obj"><span class="glyphicon glyphicon-plus"></span></a>
                            <input type="text" class="form-control" placeholder="Objetivo del programa">
                        </div>
                        <div class="col-md-6">
                            <label>Métodos</label>
                            <p>{{$programa->metodos}}</p>
{{--                            <a href="#" class="btn_add_metodo"><span class="glyphicon glyphicon-plus"></span></a>--}}
{{--                            <p>Para el presente programa de auditoría serán utilizados los métodos de:</p>--}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Responsabilidades:</label>
                            <p>{{$programa->responsabilidades}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    <form id="form_add_obj" class="form" role="form" method="POST" action="{{url("/sgc/programa")}}">
        <div class="modal fade" id="modal_add_obj" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar objetivo al programa</h4>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="alcance">Objetivo</label>
                                    <select class="form-control" name="objetivo">
                                        <option value="" disabled selected>Selecciona...</option>
                                        @foreach($objetivos as $objetivo)
                                            <option value="{{$objetivo->id_objetivo}}">{{$objetivo->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form id="form_add_metodo" class="form" role="form" method="POST" action="{{url("/sgc/programa")}}">
        <div class="modal fade" id="modal_add_metodo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar método al programa</h4>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Periodo</label>
                                    <div class="input-group input-daterange">
                                        <input type="text" class="form-control periodo" placeholder="Fecha de inicio" name="inicio">
                                        <div class="input-group-addon">a</div>
                                        <input type="text" class="form-control periodo" placeholder="Fecha de termino" name="fin">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="objetivo">Lugar</label>
                                    <textarea class="form-control"name="lugar" placeholder="Lugar de las auditorías"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="alcance">Alcance</label>
                                    <textarea class="form-control"name="alcance" placeholder="Alcance del programa de auditorías"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="alcance">Responsabilidades</label>
                                    <textarea class="form-control"name="responsabilidades" placeholder="Responsabilidades del programa de auditorías"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {

            $('.btn_add_obj').click(function () {
                $('#modal_add_obj').modal('show');
            });
            $('.btn_add_metodo').click(function () {
                $('#modal_add_metodo').modal('show');
            });


            $('[data-toggle="tooltip"]').tooltip();

        });
    </script>

@endsection

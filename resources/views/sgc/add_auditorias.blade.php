<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 09/07/2019
 * Time: 08:16 PM
 */
?>
@extends('layouts.app')
@section('title','Agendar auditorias')
@section('content')
    <style>
        .elementos > div {
            width: 100% !important;
        }
    </style>
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
{{--                @foreach($programas as $programa)--}}
{{--                    <div class="panel-heading">--}}
{{--                        <a href="#" class="btn_add_aud"><span class="pull-right glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar auditoria"></span></a>--}}
{{--                        <h3 class="panel-title text-center">Auditorias del programa--}}
{{--                            <strong>--}}
{{--                                {{\Jenssegers\Date\Date::parse($programa->fecha_i)->format('F')}} - {{\Jenssegers\Date\Date::parse($programa->fecha_f)->format('F Y')}}--}}
{{--                            </strong>--}}
{{--                        </h3>--}}
{{--                    </div>--}}
{{--                    <div class="panel-body">--}}

{{--                        <div class="row" ondrop="drop(event)" ondragover="allowDrop(event)">--}}
{{--                            <br>--}}
{{--                            @foreach($procesos as $proceso)--}}
{{--                                <div id="{{$proceso->id_proceso}}" class="col-md-3" draggable="true" ondragstart="drag(event)">--}}
{{--                                    <div  class="alert alert-danger" >{{$proceso->des_proceso}}</div>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}




{{--                        <div class="row">--}}
{{--                            @foreach($auditorias as $data_auditoria)--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <div class="panel panel-info">--}}
{{--                                        <div class="panel-heading">--}}
{{--                                            <a href="#" class="btn_delete_plan" data-id="{{$data_auditoria->id_auditoria}}"><span class="pull-right glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar Plan de Auditoria"></span></a>--}}
{{--                                            <a href="{{url('sgc/ver_plan_auditoria/')}}/{{$data_auditoria->id_auditoria}}">{{date('Y',strtotime($data_auditoria->fecha_i)).'-'.$loop->iteration}}</a>--}}
{{--                                            --}}{{--<p>{{$data_auditoria->fecha_i}}  al  {{$data_auditoria->fecha_f}}</p>--}}
{{--                                        </div>--}}
{{--                                        <div class="panel-body elementos row" data-agenda="{{$data_auditoria->id_auditoria}}" ondrop="drop(event)" ondragover="allowDrop(event)">--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                        <input type="button" id="ver_elementos" class="btn btn-primary" value="Ver"/>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
                @foreach($programas as $programa)
                    <div class="panel-heading">
                        <a href="#" class="btn_add_aud"><span class="pull-right glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar auditoria"></span></a>
                        <h3 class="panel-title text-center">Auditorias del programa
                            <strong>
                                {{\Jenssegers\Date\Date::parse($programa->fecha_i)->format('F')}} - {{\Jenssegers\Date\Date::parse($programa->fecha_f)->format('F Y')}}
                            </strong>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row droptrue" id="sortable1">
                            <br>
                            @foreach($procesos as $proceso)
                                <div id="{{$proceso->id_proceso}}" class="col-md-3">
                                    <div  class="alert alert-danger" >{{$proceso->des_proceso}}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            @foreach($auditorias as $data_auditoria)
                                <div class="col-md-4">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <a href="#" class="btn_delete_plan" data-id="{{$data_auditoria->id_auditoria}}"><span class="pull-right glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar Plan de Auditoria"></span></a>
                                            <a href="{{url('sgc/ver_plan_auditoria/')}}/{{$data_auditoria->id_auditoria}}">{{date('Y',strtotime($data_auditoria->fecha_i)).'-'.$loop->iteration}}</a>
                                            {{--<p>{{$data_auditoria->fecha_i}}  al  {{$data_auditoria->fecha_f}}</p>--}}
                                        </div>
                                        <div id="sortable2" class="panel-body elementos row droptrue" data-agenda="{{$data_auditoria->id_auditoria}}" ondrop="drop(event)" ondragover="allowDrop(event)">

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <input type="button" id="ver_elementos" class="btn btn-primary" value="Guardar"/>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <form action="{{url("/sgc/auditorias")}}" method="POST" id="form_ag_aud" class="form" role="form">
        <div class="modal fade" id="modal_add_aud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar auditoria al programa</h4>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Periodo</label>
                                <div class="input-group input-daterange">
                                    <input type="text" class="form-control periodo" placeholder="Fecha de inicio" name="fecha_i">
                                    <div class="input-group-addon">a</div>
                                    <input type="text" class="form-control periodo" placeholder="Fecha de termino" name="fecha_f">
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
            $(".btn_add_aud").click(function () {
                $("#modal_add_aud").modal('show');
            });


            @foreach($programas as $programa)
            $('.input-daterange').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                language : 'es',
                startDate : '{{$programa->fecha_i}}',
                startView: 1,
                maxViewMode: 1
            });

            @endforeach

            $('[data-toggle="tooltip"]').tooltip();

            $("#ver_elementos").click(function () {
                arreglo=[];
                $(".elementos").each(function () {
                    var agenda=$(this).data('agenda');
                    $(this).children().each(function () {
                        arreglo.push({
                            'agenda': agenda,
                            'proceso': $(this).attr('id')
                        });
                    })
                });
                console.log(arreglo)
                var t_proceso ="{{sizeof($procesos)}}";
                if(arreglo.length<t_proceso){
                    swal({
                        title: "Faltan procesos por asignar",
                        icon: 'error',
                        cancelButton: false,
                        dangerMode: true,
                    })
                }
                else{
                    swal({
                        title: "Guardando",
                        icon: 'success',
                        cancelButton: false,
                    }).then(function () {
                        $.ajax({
                            type: "GET",
                            url: "{{url('sgc/procesoAgenda/create')}}",
                            data: {arreglo:arreglo},
                            success: function(response) {
                                swal(
                                    "Sccess!",
                                    "Your note has been saved!",
                                    "success"
                                )
                            },
                            failure: function (response) {
                                swal(
                                    "Internal Error",
                                    "Oops, your note was not saved.", // had a missing comma
                                    "error"
                                )
                            }
                        });
                    })
                }
            });
        })

        $( function() {
            $( "div.droptrue" ).sortable({
                connectWith: "div",
                cursor: 'grabbing',
                placeholder: "alert alert-success",
                forcePlaceholderSize: true
            });

            $( "#sortable1, #sortable2, #sortable3" ).disableSelection();
        } );
    </script>
@endsection
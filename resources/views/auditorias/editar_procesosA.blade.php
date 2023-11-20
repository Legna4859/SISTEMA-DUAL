<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 09/07/2019
 * Time: 08:16 PM
 */
?>
@extends('layouts.app')
@section('title','Editar procesos del plan')
@section('content')
    @if(Session::get('errors'))
        <div class="alert alert-danger" role="alert">
            @foreach(Session::get('errors')->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </div>
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
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url('/auditorias/programas')}}">Programas de auditoría</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <a href="{{url('/auditorias/programas')}}/{{\Illuminate\Support\Facades\Session::get('id_programa')}}">Detalles del programa</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <a href="{{url('/auditorias/programas')}}/{{\Illuminate\Support\Facades\Session::get('id_programa')}}/edit">Planes del programa</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Editar procesos del plan</span>
            </p>
            <div class="panel panel-info">
                @foreach($auditorias as $auditoria)
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Editar procesos del plan de auditoría
                            <strong>
                                @if(\Jenssegers\Date\Date::parse($auditoria->fecha_i)->format('F')!=\Jenssegers\Date\Date::parse($auditoria->fecha_f)->format('F'))
                                    {{\Jenssegers\Date\Date::parse($auditoria->fecha_i)->format('F')}} - {{\Jenssegers\Date\Date::parse($auditoria->fecha_f)->format('F Y')}}
                                @else
                                    {{\Jenssegers\Date\Date::parse($auditoria->fecha_f)->format('F Y')}}
                                @endif
                            </strong>
                        </h3>
                    </div>
                    <div class="panel-body">
{{--                        <a href="#headingDisponibles" class="pull-right nuevos_procesos" data-toggle="tooltip" title="Agregar procesos"><span class="glyphicon glyphicon-plus"></span></a>--}}
                        <div id="asignados">

{{--                                <tbody>--}}
{{--                                <tr>--}}
{{--                                    @if($i=0)@endif--}}
{{--                                    @foreach($procesos as $proceso)--}}
{{--                                        @if(in_array($proceso->id_proceso,$procesosExistentes))--}}
{{--                                            @if($i++)@endif--}}
{{--                                            <td class="col-md-4">--}}
{{--                                                <label class="checkbox-inline"><input class="existentes" type="checkbox" data-id="{{$proceso->id_proceso}}" checked>{{ucfirst(mb_strtolower($proceso->des_proceso,'utf-8'))}}</label>--}}
{{--                                            </td>--}}
{{--                                        @endif--}}

{{--                                        @if($i==3)--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                @if($i=0)@endif--}}
{{--                                @endif--}}
{{--                                @endforeach--}}
{{--                                </tbody>--}}


                        </div>

                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-info">
                                <div class="panel-heading" role="tab" id="headingExisten">
                                    <h5 class="panel-title" role="button" data-toggle="collapse" class="btn_collapse_factor" data-parent="#accordion" href="#collapseExisten"  aria-expanded="true" aria-controls="collapseExisten">
                                        Procesos asignados
                                    </h5>
                                </div>
                                <div id="collapseExisten" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingExisten">
                                    <div class="panel-body">
                                        <table class="table table-bordered table-hover">
                                            <tbody>
                                            <tr>
                                                @foreach($procesosE as $proceso)
                                                    <td class="col-md-4">
                                                        <label class="checkbox-inline"><input class="existentes" type="checkbox" data-id="{{$proceso->id_auditoria_proceso}}" checked><strong>{{$proceso->clave.' '}}</strong>{{\App\audParseCase::parseProceso($proceso->des_proceso)}}</label>
                                                    </td>
                                                    @if(($loop->iteration%3)==0)
                                            </tr>
                                            <tr>
                                                @endif
                                                @endforeach
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-info">
                                <div class="panel-heading" role="tab" id="headingDisponibles">
                                    <h5 class="panel-title" role="button" data-toggle="collapse" class="btn_collapse_factor" data-parent="#accordion" href="#collapseDisponibles"  aria-expanded="true" aria-controls="collapseDisponibles">
                                        Procesos para asignar
                                    </h5>
                                </div>
                                <div id="collapseDisponibles" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingDisponibles">
                                    <div class="panel-body">
                                        <p><label for="" class="bg-success text-success">Procesos asignados en otros planes</label></p>
                                        <table class="table table-bordered table-hover">
                                            <tbody>
                                            <tr>
                                                @foreach($procesos as $proceso)
                                                    <td class="col-md-4">
                                                        <label class="checkbox-inline {{in_array($proceso->id_proceso,$procesosEnAgenda)?'bg-success text-success':''}}"><input class="seleccionable" type="checkbox" data-id="{{$proceso->id_proceso}}"><strong>{{$proceso->clave.' '}}</strong>{{\App\audParseCase::parseProceso($proceso->des_proceso)}}</label>
                                                    </td>
                                                    @if(($loop->iteration%3)==0)
                                            </tr>
                                            @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-success guardar">Guardar</button>
                    </div>
                    <form id="form_edit_procesos" action="{{url('auditorias/procesos_plan')}}/{{$auditoria->id_auditoria}}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="text" value="" hidden id="eliminar" name="eliminar">
                        <input type="text" value="" hidden id="agregar" name="agregar">
                    </form>
                @endforeach
            </div>
        </div>
    </main>



    <form  method="POST" role="form" id="form_delete_plan">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>

    <script>
        $(document).ready(function () {
            $('.guardar').click(function () {
                var eliminar=[];
                var agregar=[];
                $('.existentes:checkbox').each(function () {
                    if ($(this).prop('checked')==false){
                        eliminar.push($(this).data('id'));
                    }
                });
                $('.seleccionable:checkbox:checked').each(function () {
                    agregar.push($(this).data('id'));
                });
                if (eliminar.length>0 || agregar.length>0) {
                    swal({
                        title: "¿Seguro que desea realizar las modificaciones?",
                        allowOutsideClick: false,
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Aceptar',
                    })
                    .then((result) => {
                        if (result.value) { //Si presionas boton aceptar
                            $('#eliminar').val(JSON.stringify(eliminar));
                            $('#agregar').val(JSON.stringify(agregar));
                            $('#form_edit_procesos').submit();
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) { //Si presionas boton cancelar
                            swal.close()
                        }
                    })
                }
                else{
                    swal({
                        title: "No se han realizado modificaciones",
                        buttons: true,
                        dangerMode: true,
                    });
                }
            });


            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
@endsection
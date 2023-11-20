<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 06/07/2019
 * Time: 03:05 PM
 */
use Jenssegers\Date\Date;
?>
@extends('layouts.app')
@section('title', 'Programa de Auditorias')
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
                    @if($esLider)
                    <a href="#!" class="pull-right" data-toggle="modal" data-target="#modal_crea_aud"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar nuevo programa"></span></a>
                    @endif
                    <h3 class="panel-title text-center">Programas de auditorías</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="col-md-4">Periodo</th>
                            <th class="col-md-7">Lugar</th>
                            @if($esLider)<th class="col-md-1 text-center">Acciones</th>@endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($programas as $programa)
                            <tr class="bg-{{$programa->active==1?'warning':($programa->active==2?'danger':($programa->active==3?'success':''))}}">
                                <td>
                                    <a href="{{url('auditorias/programas/')}}/{{$programa->id_programa}}">{{Date::parse($programa->fecha_i)->format('F')}} - {{Date::parse($programa->fecha_f)->format('F Y')}}</a>
                                </td>
                                <td>
                                    {{$programa->lugar}}
                                </td>
                                @if($esLider)
                                <td class="text-center">

                                    @if($programa->active==0||$programa->active==2)
                                    <a href="#" class="btn_send_programa" data-id="{{$programa->id_programa}}"><span class="glyphicon glyphicon-send" data-toggle="tooltip" title="Enviar programa"></span></a>
                                    @endif
                                    {{--                                    <a href="{{url('auditorias/reporte_programa')}}/{{$programa->id_programa}}/edit" class="pull-left btn_informe_programa"><span class="glyphicon glyphicon-edit" data-toggle="tooltip" title="Ver Reporte del Programa de Auditoría"></span></a>--}}
                                    <a href="#" class="btn_delete_programa" data-id="{{$programa->id_programa}}"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar Programa de Auditoría"></span></a>

                                    @if($programa->observaciones && $programa->active==2)
                                            <a href="#" class="btn_observacion_programa" data-id="{{$programa->id_programa}}" data-value="{{$programa->observaciones}}"><span class="glyphicon glyphicon-zoom-in" data-toggle="tooltip" title="Observaciones"></span></a>
                                        @endif
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
{{--    <div>--}}
{{--        <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nueva auditoria" data-target="#modal_crea_aud" type="button" class="btn btn-success btn-lg flotante">--}}
{{--            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>--}}
{{--        </button>--}}
{{--    </div>--}}

    <form  method="POST" role="form" id="form_delete_programa">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>

    <form  method="POST" role="form" id="form_send_programa">
        <input type="hidden" value="{{$programa->observaciones}}" id="observacion_programa" name="observaciones">
        <input type="hidden" value="{{$programa->justificacion}}" id="justificacion_programa" name="justificacion">
        <input type="hidden" value="1" name="statePrograma">
        {{ csrf_field() }}
    </form>
    <form id="form_add_programa" class="form" role="form" method="POST" action="{{url("/auditorias/programas")}}">
        <div class="modal fade" id="modal_crea_aud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Registro de programa de auditorías</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-offset-1 col-md-10" id="errors">
                                @if(Session::get('errors'))
                                    <div class="alert alert-danger" role="alert">
                                        @foreach(\Illuminate\Support\Facades\Session::get('errors')->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Periodo</label>
                                    <div class="input-group input-daterange">
                                        <input type="text" class="form-control periodo" placeholder="Fecha de inicio" name="inicio" value="{{old('inicio')}}">
                                        <div class="input-group-addon">a</div>
                                        <input type="text" class="form-control periodo" placeholder="Fecha de término" name="fin" id="f_fin" value="{{old('fin')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="objetivo">Lugar</label>
                                    <input type="text" class="form-control"name="lugar" placeholder="Lugar de las auditorías" value="{{old('lugar')?old('lugar'):'Tecnológico de Estudios Superiores de Valle de Bravo'}}">
                                </div>
                                <div class="form-group">
                                    <label for="alcance">Alcance</label>
                                    <textarea class="form-control"name="alcance" placeholder="Alcance del programa de auditorías">{{old('alcance')?old('alcance'):'Serán auditados también aquellos cambios que afecten al Tecnológico y los resultados de auditorías anteriores.'}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="objetivo">Objetivo</label>
                                    <textarea class="form-control"name="objetivo" placeholder="Objetivo del programa de auditorías">{{old("objetivo")}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="metodos">Metodos</label>
                                    <textarea class="form-control"name="metodos" placeholder="Métodos a usar">{{old('metodos')?old('metodos'):'Para el presente programa de auditoría serán utilizados los métodos de:
                                        1.	Entrevista;
                                        2.	Muestreo; y
                                        3.	Revisión documental.'}}
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="alcance">Responsabilidades</label>
                                    <textarea class="form-control"name="responsabilidades" placeholder="Responsabilidades del programa de auditorías">{{old('responsabilidades')?old('responsabilidades'):'El Director General, el Coordinador del SGC, Auditor Líder y áreas del Tecnológico, intervienen en el proceso de auditorías. Las responsabilidades de cada uno de ellos, respecto del programa de auditoría se encuentran descritas en el Anexo 3, Matriz de responsabilidad y autoridad.'}}</textarea>
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
            $('.input-daterange').datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                language: 'es',
                startView: 1,
                maxViewMode: 2,
                minViewMode: 1
            });
            $('#p_inicio').datepicker({
                startDate: 0,
            });

            $(".btn_delete_programa").click(function(){
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
                        $("#form_delete_programa").attr("action","/auditorias/programas/"+id)
                        $("#form_delete_programa").submit();
                    }
                    else if (result.dismiss === Swal.DismissReason.cancel) { //Si presionas boton cancelar
                        swal.close()
                    }
                });
            });
            $(".btn_send_programa").click(function(){
                var id=$(this).data('id');
                swal({
                    title: "¿Seguro que desea enviar el programa?",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Aceptar',
                })
                    .then((result) => {
                        if (result.value) { //Si presionas boton aceptar
                            $("#form_send_programa").attr("action","/auditorias/validar_programa/"+id)
                            $("#form_send_programa").submit();
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) { //Si presionas boton cancelar
                            swal.close()
                        }
                    });
            });
            $(".btn_observacion_programa").click(function(){
                var id=$(this).data('id');

                var value=$(this).data('value');
                swal({
                    title: 'Observaciones',
                    text: value,
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: 'Cerrar',
                    confirmButtonText: 'Enviar justificación',
                    input: 'textarea',
                    inputLabel: 'Justificación',
                    inputPlaceholder: 'Escriba aquí su justificación...',
                    inputAttributes: {
                        'aria-label': 'Escriba aquí su justificación'
                    },
                    inputValue: '{{$programa->justificacion??""}}',

                    inputValidator: (value) => {
                        if (!value) {
                            return 'Necesitas escribir una justificación!'
                        }
                    }
                })
                    .then((result) => {
                        if (result.value) { //Si presionas boton aceptar

                            $("#justificacion_programa").val(result.value)
                            $("#form_send_programa").attr("action","/auditorias/validar_programa/"+id)
                            $("#form_send_programa").submit();
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) { //Si presionas boton cancelar
                            swal.close()
                        }


                    });
            });
            @if($errors->any())
                $('#modal_crea_aud').modal('show');
                setTimeout(function () {
                    $('#errors').fadeOut(500);
                },5000);

            @endif




            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    @if(Session::forget('errors'))@endif

@endsection

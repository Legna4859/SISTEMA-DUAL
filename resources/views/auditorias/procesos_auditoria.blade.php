<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 09/07/2019
 * Time: 08:16 PM
 */
?>
@extends('layouts.app')
@section('title','Planes del programa')
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
                @foreach($programas as $programa)
                    <a href="{{url('/auditorias/programas')}}/{{$programa->id_programa}}">Detalle del programa</a>
                @endforeach
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Planes del programa</span>
            </p>
            <div class="panel panel-info" id="planesExistentes">
                @foreach($programas as $programa)
                    <div class="panel-heading">
                        @if($esLider)
                            @if(sizeof($auditorias) < 5)
                                <a href="#" class="btn_add_plan" data-toggle="modal" data-target=".bs-example-modal-lg"><span class="pull-right glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar plan"></span></a>
                            @endif
                            {{--@if($porcentaje==100) cancelacion del porcentaje --}}
                            @if($programa->active==1)
                                <a href="#" class="btn_export" data-id="{{$programa->id_programa}}"><span class="pull-right glyphicon glyphicon-download-alt" data-toggle="tooltip" title="Exportar Programa">&nbsp</span></a>
                            @endif

                            {{--validar si es UIPPE--}}

                        @else
                            <!-- Example single danger button -->


                            @if($programa->active==1)
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Acciones
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li>
                                            <form action="{{url("auditorias/validar_programa",$programa->id_programa)}}" method="post">
                                                @csrf
                                                <input type="hidden" value="3" name="statePrograma">
                                                <button type="submit" class="btn btn-success">Aceptar programa</button>
                                            </form>
                                        </li>
                                        <li>
                                            <a href="#" class="btn_send_programa btn btn-danger text-white" data-id="{{$programa->id_programa}}" data-value="{{$programa->justificacion}}">Rechazar programa</a>
                                        </li>
                                    </ul>
                                </div>
                             @endif
                        @endif

                        <h3 class="panel-title text-center">Planes de auditoría para el programa
                            <strong>
                                {{\Jenssegers\Date\Date::parse($programa->fecha_i)->format('F')}} - {{\Jenssegers\Date\Date::parse($programa->fecha_f)->format('F Y')}}
                            </strong>
                        </h3>
                    </div>
                    <div class="panel-body">
                    @if(sizeof($auditorias) > 0)
                        <div class="progress" id="porcentaje">
                            <div class="progress-bar" role="progressbar" aria-valuenow="{{$porcentaje}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentaje}}%;">
                                {{$porcentaje}}% de los procesos
                            </div>
                        </div>
{{--                        <div class="row" id="planes">--}}
                        @foreach($auditorias as $data_auditoria)
                            @if(($loop->iteration%3)==0)
                            <div class="row">
                            @endif
                                <div class="col-md-4">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            @if($esLider)
                                                <a href="#" class="btn_delete_plan" data-id="{{$data_auditoria->id_auditoria}}"><span class="pull-right glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar Plan de Auditoria"></span></a>
                                                <a href="{{url('auditorias/procesos_plan/')}}/{{$data_auditoria->id_auditoria}}"><span class="pull-right glyphicon glyphicon-cog" data-toggle="tooltip" title="Editar procesos del Plan">&nbsp</span></a>
                                            @endif
                                            <a href="{{url('auditorias/planes/')}}/{{$data_auditoria->id_auditoria}}" data-toggle="tooltip" title="Ver detalles del Plan">{{date('Y',strtotime($data_auditoria->fecha_i)).'-'.$loop->iteration}}</a>
                                            {{'('.count($data_auditoria->getData($data_auditoria->id_auditoria))}}{{count($data_auditoria->getData($data_auditoria->id_auditoria))>1?' elementos)':' elemento)'}}
                                        </div>
                                        <div class="panel-body">
                                            @foreach($data_auditoria->getData($data_auditoria->id_auditoria) as $proceso)
                                                <div class="row">
                                                    <div class="col-md-{{$esLider?'9':'12'}}">
                                                        <li>
                                                            <strong>{{$proceso->clave.' '}}</strong>
                                                            {{\App\audParseCase::parseProceso($proceso->des_proceso)}}
                                                        </li>
                                                    </div>
                                                    @if($esLider)
                                                    <div class="col-md-3">
                                                        @if($proceso->observacion)
                                                            <a href="#" class="pull-right delete-observacion text-danger" data-id="{{$proceso->id_auditoria_proceso}}" data-toggle="tooltip" title="Eliminar observación del proceso {{$proceso->clave}}"><span class="glyphicon glyphicon-trash"></span></a>
                                                            <a href="#" class="pull-left edit-observacion" data-id="{{$proceso->id_auditoria_proceso}}" data-obs="{{$proceso->observacion}}" data-toggle="tooltip" title="Editar observación del proceso {{$proceso->clave}}"><span class="glyphicon glyphicon-pencil"></span></a>
                                                        @else
                                                            <a href="#" class="pull-right add-observacion text-success" data-id="{{$proceso->id_auditoria_proceso}}"  data-toggle="tooltip" title="Agregar observación al proceso {{$proceso->clave}}"><span class="glyphicon glyphicon-edit"></span></a>
                                                        @endif
                                                    </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @if(sizeof($auditorias) > 0 AND ($loop->iteration%3)==0)
                            </div>
                            @endif
                        @endforeach
                    @else
                        <div class="col-md-10 col-md-offset-1  alert alert-danger"role="alert">No se han encontrado planes de auditoria para este programa</div>
                    @endif
                        </div>
                    </div>
                @endforeach
            </div>

    </main>

    <div class="modal fade bs-example-modal-lg" id="modal_add_plan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <form method="post" action="{{url('auditorias/planes')}}" id="form_add_plan">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar plan al programa</h4>
                    </div>
                    <div class="moda-body">
                        <div class="col-md-12">
                            <label for="">Periodo para evaluar los procesos</label>
                            <div class="input-group input-daterange">
                                <input type="text" class="form-control periodo1" placeholder="Fecha de inicio" name="fecha_de_inicio">
                                <div class="input-group-addon">a</div>
                                <input type="text" class="form-control periodo2" placeholder="Fecha de término" name="fecha_de_fin">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <div class="col-md-8">
                                <label for="">Seleccione los procesos a auditar en el periodo establecido</label>
                                <br>
                                <p><label for="" class="bg-success text-success">Procesos que ya han sido agregados a un plan</label></p>
                            </div>
                            <div class="col-md-4">
                                <a href="#!" class="pull-right all_selection">Seleccionar todo <span class="glyphicon glyphicon-saved"></span></a>
                                <a href="#!" class="pull-left clear_selection">Limpiar selección <span class="glyphicon glyphicon-erase"></span></a>
                            </div>

                            <hr>
                            <div class="row">
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                    <tr>
                                        @foreach($procesos as $proceso)
                                            <td class="col-md-4">
                                                @if(\Illuminate\Support\Facades\Session::get('procesos'))
                                                    <label class="checkbox-inline {{in_array($proceso->id_proceso,$procesosEnAgenda)==true?'bg-success text-success':''}}"><input type="checkbox" data-id="{{$proceso->id_proceso}}" {{in_array($proceso->id_proceso,\Illuminate\Support\Facades\Session::get('procesos'))==true?'checked':''}}><strong>{{$proceso->clave.' '}}</strong>{{\App\audParseCase::parseProceso($proceso->des_proceso)}}</label>
                                                @else
                                                    <label class="checkbox-inline {{in_array($proceso->id_proceso,$procesosEnAgenda)==true?'bg-success text-success':''}}"><input type="checkbox" data-id="{{$proceso->id_proceso}}"><strong>{{$proceso->clave.' '}}</strong>{{\App\audParseCase::parseProceso($proceso->des_proceso)}}</label>
                                                @endif
                                            </td>
                                            @if(($loop->iteration%3)==0)
                                    </tr>
                                    @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <input name="random" type="text" value="{{str_random(20)}}" hidden>
                        <input name="procesos" id="procesos" type="text" value="" hidden>
                        <input type="text" name="id_programa" value="{{$programa->id_programa}}" hidden>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success guardar_plan">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modal_export_programa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Exportar programa de auditoría</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group formato-exportacion">
                        <label>Formato de exportación</label>

                        <div class="radio">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>
                                        <input class="formato" type="radio" name="formato" id="formato1" value="1">
                                        Excel
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label>
                                        <input class="formato" type="radio" name="formato" id="formato2" value="2">
                                        PDF
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group persona-aprueba">
                        <label>Persona que aprueba el programa</label>
                        <div class="radio">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>
                                        <input class="aprueba_formato" type="radio" name="aprueba_formato" id="formato1" value="1">
                                        Coordinadora del SGC
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label>
                                        <input class="aprueba_formato" type="radio" name="aprueba_formato" id="formato2" value="2">
                                        Director General
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="button" class="btn btn-primary btn-exportar" value="Exportar"/>
                </div>
            </div>
        </div>
    </div>

    {{--<div class="modal fade" id="modal_print_programa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Imprimir programa de auditoría</h4>
                </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Persona que aprueba el programa</label>
                            <select id="aprueba" class="form-control">
                                <option value="" selected disabled="true">Selecciona...</option>
                                <option value="1">Coordinador del Sistema de Gestión de la Calidad</option>
                                <option value="2">Director General</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="button" class="btn btn-primary btn-print" value="Ok"/>
                    </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_print_excel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Generar archivo Excel del programa de auditoría</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Persona que aprueba el programa</label>
                        <select id="apruebaExcel" class="form-control">
                            <option value="" selected disabled="true">Selecciona...</option>
                            <option value="1">Coordinadora del Sistema de Gestión de la Calidad</option>
                            <option value="2">Director General</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="button" class="btn btn-primary btn-save" value="Ok"/>
                </div>
            </div>
        </div>
    </div>--}}

    <div class="modal fade" id="modal_add_obs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <form id="form-add-obs" method="POST" action="">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar observación al proceso</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Observación</label>
                            <textarea class="form-control" name="observacion" rows="5" placeholder="Texto de la observación"></textarea>
                        </div>
                        {{--                        <input type="text" hidden name="id_auditoria_proceso" id="id_auditoria_proceso">--}}

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Ok"/>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modal_edit_obs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <form id="form-edit-obs" method="POST" action="">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Editar observación del proceso</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Observación</label>
                            <textarea class="form-control" name="observacion" rows="5" placeholder="Texto de la observación" id="observacion"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Ok"/>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <form  method="POST" role="form" id="form_delete_plan">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>

    <form  method="POST" role="form" id="form_send_programa">
        <input type="hidden" value="2" name="statePrograma">
        <input type="hidden" value="{{$programa->observaciones}}" id="observacion_programa" name="observaciones">
        <input type="hidden" value="{{$programa->justificacion}}" id="justificacion_programa" name="justificacion">
        {{ csrf_field() }}
    </form>

    <script>
        $(document).ready(function () {
            var programa;
            var errores='{{\Illuminate\Support\Facades\Session::exists('errors')?'true':'false'}}';
            console.log(errores)
            if (errores=='true'){
                $('#planesExistentes').fadeOut();
                $('#agregarPlan').fadeIn();
            }
            else{
                $('#agregarPlan').fadeOut();
            }
            @if(Session::forget('errors'))@endif
{{-- ************************************************************************************************************** --}}

            $(".btn_export").click(function () {
                programa=$(this).data('id');
                $('#modal_export_programa').modal('show');
            });

            $('.btn-exportar').click(function () {
                if ((typeof $('.formato:checked').val() === "undefined") || (typeof $('.aprueba_formato:checked').val() === "undefined")) {
                    $('.formato-exportacion').addClass('has-error');
                    $('.persona-aprueba').addClass('has-error');
                }
                else{
                    var formato = $('.formato:checked').val();
                    var aprueba_formato = $('.aprueba_formato:checked').val();
                    if (formato == 1) window.open('{{url('auditorias/printExcel')}}/'+programa+'/'+aprueba_formato,'_blank',"fullscreen=yes");
                    else window.open('{{url('auditorias/printPrograma')}}/'+programa+'/'+aprueba_formato,'_blank',"fullscreen=yes");
                }
            });

            $('.formato').change(function () {
                $('.formato-exportacion').removeClass('has-error');
            });

            $('.aprueba_formato').click(function () {
                $('.persona-aprueba').removeClass('has-error');
            });

{{-- ************************************************************************************************************** --}}

            {{--$(".btn_print_plan").click(function () {--}}
            {{--    programa=$(this).data('id');--}}
            {{--    $('#modal_print_programa').modal('show');--}}
            {{--});--}}
            {{--$(".btn_print_excel").click(function () {--}}
            {{--    programa=$(this).data('id');--}}
            {{--    $('#modal_print_excel').modal('show');--}}
            {{--});--}}
            {{--$('.btn-print').click(function () {--}}
            {{--    window.open('{{url('auditorias/printPrograma')}}/'+programa+'/'+$('#aprueba').val(),'_blank',"fullscreen=yes");--}}
            {{--});--}}
            {{--$('.btn-save').click(function () {--}}
            {{--    window.open('{{url('auditorias/printExcel')}}/'+programa+'/'+$('#apruebaExcel').val(),'_blank',"fullscreen=yes");--}}
            {{--});--}}
            
            $('.btn_delete_plan').click(function () {
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
                        $("#form_delete_plan").attr("action","/auditorias/planes/"+id)
                        $("#form_delete_plan").submit();
                    }
                    else if (result.dismiss === Swal.DismissReason.cancel) { //Si presionas boton cancelar
                        swal.close()
                    }
                });




            });
            $(".btn_send_programa").click(function(){
                var value=$(this).data('value');
                var id=$(this).data('id');
                swal({
                    title: "¿Seguro que desea rechazar el programa?",
                    text: value,
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Aceptar',
                    input: 'textarea',
                    inputLabel: 'Observación',
                    inputPlaceholder: 'Escriba aquí su observación...',
                    inputAttributes: {
                        'aria-label': 'Escriba aquí su observación'
                    },
                    inputValue: '{{$programa->observaciones??""}}',

                    inputValidator: (value) => {
                        if (!value) {
                            return 'Necesitas escribir una observación!'
                        }
                    }
                })
                    .then((result) => {
                        if (result.value) { //Si presionas boton aceptar

                            $("#observacion_programa").val(result.value)
                            $("#form_send_programa").attr("action","/auditorias/validar_programa/"+id)
                            $("#form_send_programa").submit();
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) { //Si presionas boton cancelar
                            swal.close()
                        }


                    });
            });

            $('.guardar_plan').click(function () {
                var seleccionados=[];
                var datos=[];
                $('input:checkbox:checked').each(function () {
                    seleccionados.push($(this).data('id'));
                });
                $('#procesos').val(JSON.stringify(seleccionados))
                // datos.push({'data' : $('#form_add_plan').serializeArray()});
                // datos.push({'procesos' : seleccionados});
                // console.log($('#form_add_plan').serializeArray())
                {{--$.get('{{url('auditorias/planes/create')}}',{datos:datos});--}}
                $('#form_add_plan').submit();
            });

            $('.clear_selection').click(function () {
                $('input:checkbox').each(function () {
                    $(this).prop("checked", false);
                });
            });

            $('.all_selection').click(function () {
                $('input:checkbox').each(function () {
                    $(this).prop("checked", true);
                });
            });


            $('.add-observacion').click(function () {
                $('#form-add-obs').attr('action','{{url('auditorias/add_observacion')}}/'+$(this).data('id'));
                // $('#id_auditoria_proceso').attr('value',$(this).data('id'))
                $("#modal_add_obs").modal('show');
            });

            $('.edit-observacion').click(function () {
                $('#form-edit-obs').attr('action','{{url('auditorias/edit_observacion')}}/'+$(this).data('id'));
                $('#observacion').html($(this).data('obs'));
                $("#modal_edit_obs").modal('show');
            });

            $('.delete-observacion').click(function () {
                swal({
                    title: "Seguro que desea eliminar?",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Aceptar',
                })
                    .then((result) => {
                        if (result.value) { //Si presionas boton aceptar
                            $.get("{{url('/auditorias/delete_observacion')}}/"+$(this).data('id'),function (data) {
                                location.reload();
                            })
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) { //Si presionas boton cancelar
                            swal.close()
                        }
                    });

            });


            @foreach($programas as $programa)
            $('.input-daterange').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy',
                language : 'es',
                startView: 1,
                startDate: '{{\Carbon\Carbon::parse($programa->fecha_i)->format('d-m-Y')}}',
                endDate: '{{\Carbon\Carbon::parse($programa->fecha_f)->format('d-m-Y')}}'
            });
            @endforeach


            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
@endsection
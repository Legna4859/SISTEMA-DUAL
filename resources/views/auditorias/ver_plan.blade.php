@extends('layouts.app')
@foreach($auditorias as $auditoria)
    @if($auditoria->id_auditoria==$auditoria_id)
    @section('title', 'Detalle auditoria '.\Carbon\Carbon::parse($auditoria->fecha_i)->format('Y').'-'.$loop->iteration)
    @endif
@endforeach
@section('content')
    <?php use \Carbon\Carbon; ?>
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <p>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                    <a href="{{url('/auditorias/programas')}}">Programas de auditoría</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <a href="{{url('/auditorias/programas')}}/{{\Illuminate\Support\Facades\Session::get('id_programa')}}">Detalles del programa</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <a href="{{url('/auditorias/programas')}}/{{\Illuminate\Support\Facades\Session::get('id_programa')}}/edit">Planes del programa</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span>Detalles del plan</span>
                </p>
                @if (session()->has('flash_notification.message'))
                    <div class="alert alert-{{ session('flash_notification.level') }}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! session('flash_notification.message') !!}
                    </div>
                @endif
                @foreach($auditorias as $auditoria)
                    @if($auditoria->id_auditoria==$auditoria_id)
                        <div class="panel panel-info">
                            <div class="panel-heading text-center">
                                Detalles del plan de auditoría {{\Carbon\Carbon::parse($auditoria->fecha_i)->format('Y').'-'.$loop->iteration}}
                                @if($auditoria->objetivo AND $auditoria->alcance AND $auditoria->criterio)
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-10">
                                            @if($esLider)
                                            <a href="{{url("/auditorias/informe").'/'.$auditoria->id_auditoria}}" class="pull-right" dstyle="margin-left: 1.5em;" ata-all="{{$auditoria}}"><span class="glyphicon glyphicon-paste" data-toggle="tooltip" title="Ver el informe de auditoria"></span></a>
                                            @endif
                                        </div>
                                        <div class="col-md-1 ">
                                            <a href="{{url("/auditorias/agenda").'/'.$auditoria->id_auditoria}}" class="pull-right"  style="margin-left: 1.5em;" data-all="{{$auditoria}}"><span class="glyphicon glyphicon-th" data-toggle="tooltip" title="Editar agenda de auditoria"></span></a>
                                        </div>
                                    </div>

                                @endif
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Objetivo</label>
                                        @if($esLider)
                                        <a href="#" class="btn-edit-plan pull-right" data-all="{{$auditoria}}"><span class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Editar plan"></span></a>
                                        @endif
                                        <p>{{$auditoria->objetivo}}</p>
                                    </div>
                                    <div class="col-md-8">
                                        <label>Alcance</label>
                                        <p>{{$auditoria->alcance}}</p>
{{--                                        <p>{{count($procesosE)." procesos"}}</p>--}}
                                    </div>
                                    <div class="col-md-4">
                                        <label>Fechas</label>
                                        <p>Del <strong>{{Carbon::parse($auditoria->fecha_i)->format('d/m/Y')}}</strong> al <strong>{{Carbon::parse($auditoria->fecha_f)->format('d/m/Y')}}</strong></p>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Criterios de auditoría</label>
                                        <p>{{$auditoria->criterio}}</p>

                                    </div>

                                </div>
                                <hr>
                                {{--<a href="#" class="pull-right btn_add_auditores" data-id="{{$auditoria->id_auditoria}}" data-toggle="modal" data-target="#modal_add_auditores"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar Auditores"></span></a>--}}
                                <div class="row">
                                    @if($esLider)
                                    <div class="col-md-12">
                                        <a href="{{url('auditorias/auditores_asignados')}}/{{$auditoria->id_auditoria}}/edit" class="pull-right"><span class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Editar auditores"></span></a>
                                    </div>
                                    @endif
                                    <div class="col-md-6">
                                        <label>Auditor Líder:</label>
                                        @if($lider->isEmpty())
                                            {{--                                        <a href="#" class="btn-add-lider" data-id="{{$auditoria->id_auditoria}}" data-toggle="modal" data-target="#modal_edit_lider"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar lider"></span></a>--}}
                                            <div class="alert alert-danger" role="alert">No se ha agregado un lider</div>
                                        @else
                                            @foreach($lider as $auditores)
                                                @foreach($auditores->getAbr->getAbreviatura as $auditor)
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <span class="col-md-10">{{\App\audParseCase::parseAbr($auditor->titulo).' '.\App\audParseCase::parseNombre($auditores->getName->nombre)}}</span>
                                                            {{--<a href="#" class="btn-edit-lider col-md-1" data-id="{{$auditor->id_asigna_audi}}" data-toggle="modal" data-target="#modal_edit_lider"><span class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Editar lider"></span></a>--}}
                                                            {{--                                                        <a href="#" class="pull-right btn_delete_auditor col-md-1" data-id="{{$auditor->id_auditor_auditoria}}"><span aria-hidden="true" class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar lider"></span></a>--}}
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Equipo de auditores:</label>
                                        {{--                                    <a href="#" class="btn-add-aquipo" data-id="{{$auditoria->id_auditoria}}" data-toggle="modal" data-target="#modal_edit_equipo"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar auditor"></span></a>--}}
                                        @if($equipo=$auditoria->getAuditores($auditoria->id_auditoria, 2) AND sizeof($equipo)<1)
                                            <div class="alert alert-danger" role="alert">No se han agregado auditores al equipo</div>
                                        @else
                                            <ul class="list-group">
                                                @foreach($equipo as $auditor)
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <span class="col-md-10"><label>Auditor {{$loop->iteration}}:</label>{{' '.\App\audParseCase::parseAbr($auditor->titulo).' '.\App\audParseCase::parseNombre($auditor->nombre)}}</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label>Auditores en entrenamiento:</label>
                                        {{--                                    <a href="#" class="btn-add-entrenado" data-id="{{$auditoria->id_auditoria}}" data-toggle="modal" data-target="#modal_edit_entrenado"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar auditor"></span></a>--}}
                                        @if($entrenados=$auditoria->getAuditores($auditoria->id_auditoria, 3) AND sizeof($entrenados)<1)
                                            <div class="alert alert-danger" role="alert">No se han agregado auditores en entrenamiento</div>
                                        @else
                                            <ul class="list-group">
                                                @foreach($entrenados as $auditor)
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <span class="col-md-10"><label>AE {{$loop->iteration}}:</label>{{' '.\App\audParseCase::parseAbr($auditor->titulo).' '.\App\audParseCase::parseNombre($auditor->nombre)}}</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </main>

    <form  method="POST" role="form" id="form_delete">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>

    @foreach($auditorias as $auditoria)
        @if($auditoria->id_auditoria==$auditoria_id)

            <form id="form_edit_aud" class="form" role="form" method="POST" action="{{url('auditorias/planes')}}/{{$auditoria->id_auditoria}}">
                <div class="modal fade" id="modal_edit_aud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel">Editar plan de auditorias</h4>
                            </div>
                            <div class="modal-body">

                                @csrf
                                @method("PUT")
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Periodo</label>
                                            <div class="input-group input-daterange">
                                                <input type="text" class="form-control periodo" placeholder="Fecha de inicio" name="fecha_i" value="{{Carbon::parse($auditoria->fecha_i)->format('d-m-Y')}}">
                                                <div class="input-group-addon">a</div>
                                                <input type="text" class="form-control periodo" placeholder="Fecha de término" name="fecha_f" id="f_fin" value="{{Carbon::parse($auditoria->fecha_f)->format('d-m-Y')}}">
                                            </div>
                                        </div>
                                        {{--                                <label for="fecha_i">Fecha de inicio</label>--}}
                                        {{--                                <input id="fecha_i" name="fecha_i" type="date">--}}
                                        {{--                            </div>--}}
                                        {{--                            <div class="col-md-6">--}}
                                        {{--                                <label for="fecha_f">Fecha de termino</label>--}}
                                        {{--                                <input id="fecha_f" name="fecha_f" type="date">--}}
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="objetivo">Objetivo</label>
                                            <textarea class="form-control" id="objetivo" name="objetivo" placeholder="Objetivo del plan de auditoria">{{$auditoria->objetivo}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="alcance">Alcance</label>
                                            <textarea class="form-control" id="alcance" name="alcance" placeholder="Alcance del plan de auditoria">{{$auditoria->alcance!=""?$auditoria->alcance:\App\audParseCase::parseProceso(implode(", ",$procesosE->pluck('des_proceso')->toArray()))}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="criterios">Criterios</label>
                                            <textarea class="form-control" id="criterios" name="criterios" placeholder="Criterios del plan de auditoria">{{$auditoria->criterio}}</textarea>
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
        @endif

    @endforeach

    <script>
        $(document).ready(function () {
            $('.input-daterange').datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                language: 'es'
            });
        });

        $(".btn-edit-plan").click(function () {
            var data=$(this).data('all');
            $("#modal_edit_aud").modal('show');
        });

        $('[data-toggle="tooltip"]').tooltip();

    </script>
@endsection

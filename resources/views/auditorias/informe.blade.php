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
                    <a href="{{url('/auditorias/planes')}}/{{$auditoria_id}}">Detalles del plan</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span>Informe de la auditoria</span>
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
                                Informe de la auditoría {{\Carbon\Carbon::parse($auditoria->fecha_i)->format('Y').'-'.$loop->iteration}}
                                @if($auditoria->objetivo AND $auditoria->alcance AND $auditoria->criterio)
                                            <a href="#" data-id="{{$auditoria->id_auditoria}}" class="pull-right btn_export"  style="margin-left: 1.5em;" data-all="{{$auditoria}}"><span class="glyphicon glyphicon-print" data-toggle="tooltip" title="Imprimir informe de auditoria"></span></a>
                                @endif
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">Número de auditoría: <strong> {{\Carbon\Carbon::parse($auditoria->fecha_i)->format('Y').'-'.$loop->iteration}} </strong></div>
                                    <div class="col-md-6">Fechas de la auditoría: Del <strong>{{Carbon::parse($auditoria->fecha_i)->format('d/m/Y')}}</strong> al <strong>{{Carbon::parse($auditoria->fecha_f)->format('d/m/Y')}}</strong></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h4>Norma de Referencia:</h4>
                                        <h4>{{$auditoria->criterio}}</h4>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Objetivo</label>

                                        <p>{{$auditoria->objetivo}}</p>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Alcance</label>
                                        <p>{{$auditoria->alcance}}</p>
                                        {{--                                        <p>{{count($procesosE)." procesos"}}</p>--}}
                                    </div>
                                </div>
                                <hr>
                                {{--<a href="#" class="pull-right btn_add_auditores" data-id="{{$auditoria->id_auditoria}}" data-toggle="modal" data-target="#modal_add_auditores"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar Auditores"></span></a>--}}
                                <div class="row">
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


                                        @if(count($entrenados=$auditoria->getAuditores($auditoria->id_auditoria, 3))==0)
                                            <div class="alert alert-danger" role="alert">No se cuenta con auditores en entrenamiento</div>
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>RESUMEN:</h4>
                                        <a href="#" data-id="resumenInforme"  data-field="resumen" class="btnInforme btn btn-primary">Guardar</a><br><br>
                                        <p>
                                            <textarea name="" id="resumenInforme" cols="80" rows="10">{{$informe->resumen}}</textarea>
                                        </p>
                                        <h4>Se contó con la presencia de las siguientes personas:</h4>
                                        @foreach($personas as $persona)
                                            <h5>{{($loop->index+1)."- ".$persona->nombre.", ".$persona->jefe_descripcion}}{{$persona->funciones!=null?" ".$persona->funciones.";":";"}}</h5>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="#" data-id="cierreInforme"  data-field="cierre" class="btnInforme btn btn-primary">Guardar</a><br><br>
                                        <p>
                                            <textarea name="" id="cierreInforme" cols="80" rows="10">{{$informe->cierre}}</textarea>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Reporte de no conformidades levantadas:</h4>
                                        @if(count($noConformidad)>0)
                                        @foreach($noConformidad as $registro)
                                            <h5>{{($loop->index+1)}} <strong>{{$registro->punto_proceso}}</strong> {{$registro->resultado}}</h5>
                                        @endforeach
                                        @else
                                            No se encontraron  No conformidades.
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Fortalezas del sistema:</h4>
                                        @if(count($fortalezas)>0)
                                        @foreach($fortalezas as $registro)
                                            <h5>{{($loop->index+1)}} <strong>{{$registro->punto_proceso}}</strong> {{$registro->resultado}}</h5>
                                        @endforeach
                                        @else
                                            No se detectaron fortalezas.
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Oportunidades:</h4>
                                    @if(count($oportunidades)>0)
                                    @foreach($oportunidades as $registro)
                                        <h5>{{($loop->index+1)}} <strong>{{$registro->punto_proceso}}</strong> {{$registro->resultado}}</h5>
                                    @endforeach
                                    @else
                                        No se detectaron oportunidades.
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Seguimiento de acciones:</h4>
                                    @if(count($oportunidades)>0)
                                    @foreach($seguimientoAcciones as $registro)
                                        <h5>{{($loop->index+1)}} <strong>{{$registro->punto_proceso}}</strong> {{$registro->resultado}}</h5>
                                    @endforeach
                                    @else
                                        No se registraron seguimientos.
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Conclusiones:</h4>
                                    <a href="#" data-id="conclusionesInforme"  data-field="conclusiones" class="btnInforme btn btn-primary">Guardar</a><br><br>
                                    <p>
                                        <textarea name="" id="conclusionesInforme" cols="80" rows="10">{{$informe->conclusiones}}</textarea>
                                    </p>
                                </div>
                            </div>
                        </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </main>

    <form  method="POST" role="form" id="form_informe" action="{{url('auditorias/informe/'.$informe->id_informe)}}">
        {{ csrf_field() }}
        {{ method_field('PUT')}}
        <input type="hidden" name="field" id="fieldInforme">
        <input type="hidden" name="value" id="valueInforme">

    </form>

    <div class="modal fade" id="modal_export_programa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Exportar programa de auditoría</h4>
                </div>
                <div class="modal-body">
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
            $(".btnInforme").click(function(){
                var id=$(this).data('id');
                var field=$(this).data("field")
                $("#valueInforme").val($("#"+id).val())
                $("#fieldInforme").val(field);
                $("#form_informe").submit();
            });

            $(".btn_export").click(function () {
                programa=$(this).data('id');
                $('#modal_export_programa').modal('show');
            });

            $('.btn-exportar').click(function () {
                if ((typeof $('.aprueba_formato:checked').val() === "undefined")) {
                    // $('.formato-exportacion').addClass('has-error');
                    $('.persona-aprueba').addClass('has-error');
                }
                else{
                    var formato = $('.formato:checked').val();
                    var aprueba_formato = $('.aprueba_formato:checked').val();
                    window.open('{{url("auditorias/printinforme")}}/'+programa+'/'+aprueba_formato,'_blank',"fullscreen=yes");
                }
            });

        });

        $(".btn-edit-plan").click(function () {
            var data=$(this).data('all');
            $("#modal_edit_aud").modal('show');
        });

        $('[data-toggle="tooltip"]').tooltip();



    </script>
@endsection

@extends('layouts.app')
@section('title', 'Agenda del Plan')
@section('content')
    @if(\Illuminate\Support\Facades\Session::get('errors'))

        {{dd("ok")}}
        <div class="alert alert-danger" role="alert">
            @foreach(\Illuminate\Support\Facades\Session::get('errors')->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </div>
        @if(\Illuminate\Support\Facades\Session::forget('errors'))@endif
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
                <a href="{{url('/auditorias/planes')}}/{{$auditoria->id_auditoria}}">Detalles del plan</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Agenda del plan</span>
            </p>
            <div class="panel panel-info">
                <div class="panel-heading">
                    @if($porcentaje>=100)
                        {{--<a href="{{url('auditorias/printPlan')}}/{{$auditoria->id_auditoria}}" class="pull-right"><span class="glyphicon glyphicon-print"></span></a>--}}
                        <a href="#" class="btn_export" data-id="{{$auditoria->id_auditoria}}"><span class="pull-right glyphicon glyphicon-download-alt" data-toggle="tooltip" title="Exportar Programa">&nbsp</span></a>

                    @endif
                    @foreach($auditorias as $auditoria_n)
                        @if($auditoria_n->id_auditoria==$auditoria->id_auditoria)
                            <h3 class="panel-title text-center">Agenda del plan {{\Carbon\Carbon::parse($auditoria_n->fecha_i)->format('Y')}}-{{$loop->iteration}}</h3>
                        @endif
                    @endforeach
                </div>
                <div class="panel-body">
                    @if($porcentaje>0)
                        <div class="progress" id="porcentaje">
                            <div class="progress-bar" role="progressbar" aria-valuenow="{{$porcentaje}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentaje}}%;">
{{--                                Agendado el {{$porcentaje}}% de los procesos del plan--}}
                                Agendados  {{sizeof($procesosT).'/'.$procesosAsignados->count()}} procesos del plan
                            </div>
                        </div>
                    @endif
                    <div class="horarios">
                        <div id="exTab2" class="">
                            <ul class="nav nav-tabs">
                                @foreach($fechas as $dia)
                                    <li class="{{$dia==Session::get('dia')?'active':''}} elemento" data-item="{{$dia}}"><a href="#{{$dia}}" class="tab" data-fecha="{{$dia}}" data-toggle="tab" aria-expanded="{{$dia==Session::get('dateUsed')?'true':'false'}}">{{\Jenssegers\Date\Date::parse($dia)->format('d-m-Y')}}</a></li>
                                @endforeach
                            </ul>
                            <div class="tab-content ">
                                @foreach($fechas as $dia)
                                    <div class="tab-pane {{$dia==Session::get('dia')?'active':''}}"  id="{{$dia}}">
                                        <div class="agenda-general panel panel-success">
                                            <div class="panel-heading">
                                                @if($esLider)
                                                <a href="#!" class="pull-right btn-add-agenda" data-fecha="{{$dia}}" data-toggle="tooltip" title="Agregar evento"><span class="glyphicon glyphicon-plus"></span></a>
                                                @endif
                                                <h3 class="panel-title text-center">Agenda del día {{\Jenssegers\Date\Date::parse($dia)->format('d-m-Y')}}</h3>
                                            </div>
                                            <div class="panel-body">
                                                <table class="table table-striped table-bordered table-condensed">
                                                    <thead class="row">
                                                    <th class="col-md-1 text-center">Hora de inicio</th>
                                                    <th class="col-md-1 text-center">Hora de termino</th>
                                                    <th class="col-md-4 text-center">Procesos</th>
                                                    <th class="col-md-1 text-center">Responsable</th>
                                                    <th class="col-md-4 text-center">Areas</th>
                                                    <th class="col-md-1 text-center">Acciones</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($agendaFinal as $agenda)


                                                            @if($agenda['fecha']==$dia)

                                                                @if($esLider OR in_array(Session::get('id_perso'),$agenda['id_auditores']) || Session::get('id_perso')==203||$agenda["tipo"]==2)
                                                                    <tr>
                                                                        <td>{{$agenda['inicio']}}</td>
                                                                        <td>{{$agenda['fin']}}</td>
                                                                        <td colspan="{{sizeof($agenda['responsables'])>0?'':(sizeof($agenda['areas'])>0?'':'3')}}">
                                                                            @if(strlen($agenda['criterios']))
                                                                            <p>{{$agenda['criterios']}}</p>
                                                                            @endif
                                                                            <div class="container-fluid">
                                                                                @if(is_array($agenda['procesos']))
                                                                                    @foreach($agenda['procesos'] as $proceso)
                                                                                        <li>{{$proceso}}</li>
                                                                                    @endforeach
                                                                                @else
                                                                                    <li>{{$agenda['procesos']}}</li>
                                                                                @endif
                                                                            </div>
                                                                        </td>
                                                                            <td>
                                                                                @if(sizeof($agenda['responsables'] )==0||$agenda["tipo"]==2)
                                                                                    Grupo Auditor
                                                                                @else
                                                                                @foreach($agenda['responsables'] as $responsable)
                                                                                    <p>{{$responsable}}</p>
                                                                                @endforeach
                                                                                    @endif
                                                                            </td>
                                                                            <td>
                                                                                <div class="container-fluid">
                                                                                    @foreach($agenda['areas'] as $area)
                                                                                        <li>{{$area}}</li>
                                                                                    @endforeach
                                                                                </div>
                                                                            </td>

                                                                        <td class="text-center">
                                                                            @if($agenda['tipo']==1 and ($esLider || in_array(Session::get('id_perso'),$agenda['id_auditores'])))
                                                                                <a href="{{(sizeof($agenda['id_personal_lider'])>0||in_array(Session::get('id_perso'),$agenda['id_auditores']))?url('/auditorias/hoja_trabajo/').'/'.$agenda['id_agenda']:url('/auditorias/hoja_trabajo/').'/'.$agenda['id_agenda']}}" data-toggle="tooltip" title="{{(sizeof($agenda['id_personal_lider'])>0||in_array(Session::get('id_perso'),$agenda['id_auditores']))?'Hoja':'Ver hoja'}} de trabajo"><span class="glyphicon {{(sizeof($agenda['id_personal_lider'])>0||in_array(Session::get('id_perso'),$agenda['id_auditores']))?'glyphicon-copy':' glyphicon-file '}} pull-left text-success"></span></a>
                                                                                {{-- <a href="{{url('/auditorias/editar_evento').'/'.$agenda['id_agenda']}}/{{$agenda['tipo']}}" class="edit-event" data-id="{{$agenda['id_agenda']}}" data-toggle="tooltip" title="Editar evento"><span class="glyphicon glyphicon-cog"></span></a>--}}
                                                                            @endif
                                                                            @if($esLider)

                                                                                <a href="#" class="delete-event" data-id="{{$agenda['id_agenda']}}" data-type="{{$agenda['tipo']}}" data-toggle="tooltip" title="Eliminar evento"><span class="glyphicon glyphicon-trash pull-right text-danger"></span></a>
                                                                            @endif

                                                                        </td>
                                                                        {{--
                                                                        @elseif(in_array(Session::get('id_perso'),$agenda['id_auditores']))
                                                                            <a href="{{url('/auditorias/hoja_trabajo/').'/'.$agenda['id_agenda']}}" data-toggle="tooltip" title="Hoja de trabajo"><span class="glyphicon glyphicon-copy"></span></a>
                                                                        @endif
                                                                    </td>--}}
                                                                    </tr>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                    {{--<tbody>
                                                    @foreach($agendaT as $agenda)
                                                        @if($agenda->fecha==$dia)
                                                            @if($esLider OR in_array(Session::get('id_perso'),$agenda->id_auditores))
                                                            <tr>
                                                                <td>{{$agenda->hora_i}}</td>
                                                                <td>{{$agenda->hora_f}}</td>
                                                                <td>
                                                                    <p>{{$agenda->criterios}}</p>
                                                                    <div class="container-fluid">
                                                                        @foreach($agenda->procesos as $proceso)
                                                                            <li>{{$proceso}}</li>
                                                                        @endforeach
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    @foreach($agenda->auditores as $auditor)
                                                                        <p>{{$auditor}}</p>
                                                                    @endforeach
                                                                </td>
                                                                <td>
                                                                    <div class="container-fluid">

                                                                        @if(is_array($agenda->areas))
                                                                            @foreach($agenda->areas as $area)
                                                                                <li>{{$area}}</li>
                                                                            @endforeach
                                                                        @else
                                                                            <li>{{$agenda->areas}}</li>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    @if($esLider)
                                                                        <a href="{{sizeof($agenda->id_personal_lider)>0?url('/auditorias/hoja_trabajo/').'/'.$agenda->id_agenda:url('/auditorias/ver_hoja').'/'.$agenda->id_agenda}}" data-toggle="tooltip" title="{{sizeof($agenda->id_personal_lider)>0?'Hoja':'Ver hoja'}} de trabajo"><span class="glyphicon {{sizeof($agenda->id_personal_lider)>0?'glyphicon-paperclip':' glyphicon glyphicon-eye-open '}} pull-left text-success"></span></a>
                                                                        <a href="{{url('/auditorias/editar_evento').'/'.$agenda->id_agenda}}/1" class="edit-event" data-id="{{$agenda->id_agenda}}" data-toggle="tooltip" title="Editar evento"><span class="glyphicon glyphicon-cog"></span></a>
                                                                        <a href="#" class="delete-event" data-id="{{$agenda->id_agenda}}" data-toggle="tooltip" title="Eliminar evento"><span class="glyphicon glyphicon-trash pull-right text-danger"></span></a>
                                                                    @elseif(in_array(Session::get('id_perso'),$agenda->id_auditores))
                                                                        <a href="{{url('/auditorias/hoja_trabajo/').'/'.$agenda->id_agenda}}" data-toggle="tooltip" title="Hoja de trabajo"><span class="glyphicon glyphicon-paperclip"></span></a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    </tbody>--}}
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="modal_add_evento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <form id="form-add-evento" action="{{url('auditorias/agenda')}}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar evento a la agenda</h4>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="id_auditoria" value="{{$auditoria->id_auditoria}}" hidden>
                        <input type="text" name="fecha" id="fecha_agenda" hidden>
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default procesos">
                                <div class="panel-heading" role="tab" id="headingProcesos" data-toggle="collapse" data-parent="#accordion" href="#collapseProcesos" aria-expanded="false" aria-controls="collapseProcesos">
                                    <strong class="pull-right procesos">0 Seleccionados</strong>
                                    <h4 class="panel-title" role="button">
                                        Proceso(s) a auditar / Actividad
                                    </h4>
                                </div>
                                <div id="collapseProcesos" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingProcesos">
                                    <div class="panel-body">
                                        <label for="">Actividades para la Agenda</label>
                                        <div class="row">
                                            @foreach($actividades as $actividad)
                                                <div class="col-md-4">
                                                    <label class="checkbox-inline">
                                                        <input class="actividad" type="checkbox" data-id="{{$actividad->id_actividad}}" data-name="actividad" data-back="proceso">
                                                        {{\App\audParseCase::parseProceso($actividad->descripcion)}}
                                                    </label>
                                                </div>
                                                @if($loop->iteration%3==0)
                                        </div>
                                        <div class="row">
                                            @endif
                                            @endforeach
                                        </div>
                                        <hr>
                                        <label for="">Procesos </label>
                                        <div class="row">
                                            @foreach($procesosAsignados as $proceso)
                                                <div class="col-md-4">
                                                    <label class="checkbox-inline {{in_array($proceso->id_auditoria_proceso,$procesosT)?'bg-success text-success':''}}">
                                                        <input class="proceso" type="checkbox" data-id="{{$proceso->id_auditoria_proceso}}" data-name="proceso" data-back="actividad" data-proceso="{{$proceso->id_proceso}}" data-unidades="{{$proceso->unidades}}">
                                                        <strong>{{$proceso->clave.' '}}</strong>
                                                        {{\App\audParseCase::parseProceso($proceso->des_proceso)}}
                                                    </label>
                                                </div>
                                                @if($loop->iteration%3==0)
                                        </div>
                                        <div class="row">
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default areas">
                                <div class="panel-heading" role="tab" id="headingArea" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <strong class="pull-right areas"></strong>
                                    <h4 class="panel-title" role="button">
                                        Área
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingArea">
                                    <div class="panel-body">
                                        <label for="">Grupos Administrativos</label>
                                        <div class="row">
                                            @foreach($generalAreas as $area)
                                                <div class="col-md-4">
                                                    <label class="checkbox-inline">
                                                        <input class="areaG" type="checkbox" data-id="{{$area->id_area_general}}" data-name="areaG" data-back="area">
                                                        {{$area->descripcion}}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <label for="">Areas</label>
                                        <div class="row">
                                            @foreach($areasT as $area)
                                                <div class="col-md-4">
                                                    <label class="checkbox-inline">
                                                        <input class="area" type="checkbox" data-id="{{$area->id_unidad_admin}}" id="id_unidad_admin{{$area->id_unidad_admin}}" data-name="area" data-back="areaG">
                                                        {{\App\audParseCase::parseNombre($area->nom_departamento)}}
                                                    </label>
                                                </div>
                                                @if($loop->iteration%3==0)
                                        </div>
                                        <div class="row">
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default responsables">
                                <div class="panel-heading" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <strong class="pull-right responsables">0 Seleccionados</strong>
                                    <h4 class="panel-title" role="button">
                                        Responsable
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="panel-body">

                                        <label for="">Grupos de personas</label>
                                        <div class="row">
                                            @foreach($generalPersonales as $personal)
                                                <div class="col-md-4">
                                                    <label class="checkbox-inline">
                                                        <input class="responsableG" type="checkbox" data-id="{{$personal->id_personal_general}}" data-name="responsableG" data-back="responsable">
                                                        {{$personal->descripcion}}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <label for="">Auditores</label>
                                        @php $equipo=1; $entrenamiento=1; @endphp
                                        <div class="row">
                                            @foreach($auditoresT as $auditor)
                                                <div class="col-md-6">
                                                    <label class="checkbox-inline">
                                                        <input class="responsable" type="checkbox" data-id="{{$auditor->id_auditor_auditoria}}" data-name="responsable" data-back="responsableG">
                                                        @if($auditor->id_categoria==1)
                                                            <strong>Auditor Líder</strong>
                                                        @elseif($auditor->id_categoria==2)
                                                            <strong>Auditor {{$equipo}}</strong>
                                                            @php $equipo++; @endphp
                                                        @elseif($auditor->id_categoria==3)
                                                            <strong>AE {{$entrenamiento}}</strong>
                                                            @php $entrenamiento++; @endphp
                                                        @endif
                                                        {{" (".\App\audParseCase::parseAbr($auditor->titulo).' '.\App\audParseCase::parseNombre($auditor->nombre).")"}}
                                                    </label>
                                                </div>
                                                @if($loop->iteration%2==0)
                                        </div>
                                        <div class="row">
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label for="">Puntos de la norma a auditar</label>
                                <textarea class="form-control" name="criterios" id="area_criterios" rows="2" ></textarea>
                            </div>
                            <div class="col-md-2">
                                <br><br><br>
                                <botton class="btn btn-success pull-right programar" data-fecha="{{$dia}}">Ver disponibilidad</botton>
                            </div>
                        </div>
                        <div class="row horas"></div>
                        <input type="text" name="procesos" id="procesos" hidden>
                        <input type="text" name="area" id="area" hidden>
                        <input type="text" name="responsable" id="responsable" hidden>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary guarda_evento hidden" value="Agendar"/>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <form  method="POST" role="form" id="form_delete_evento">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <input type="text" value="" id="tipo" name="tipo" hidden>
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

    <script>
        $(document).ready(function () {
            $(".actividad").click(function(){
                if($(this).prop('checked'))
                    $(".responsable").prop("disabled",true);
                else
                    $(".responsable").prop("disabled",false);

            });
            $(".area").prop("disabled","disabled")
            $('input:checkbox').click(function () {
                seleccionados=0;
                $('.'+$(this).data('name')+':checked').each(function () {
                    seleccionados++;
                });
                if (seleccionados>0){
                    $('.'+$(this).data('back')).attr('disabled',true);
                    $('div.'+$(this).data('back')+'s, div.'+$(this).data('name')+'s').removeClass('panel-defalut').addClass('panel-success');
                }
                else{
                    $('.'+$(this).data('back')).attr('disabled',false);
                    $('div.'+$(this).data('back')+'s, div.'+$(this).data('name')+'s').removeClass('panel-success').addClass('panel-default');
                }
                $('strong.'+$(this).data('back')+'s, strong.'+$(this).data('name')+'s').empty().append(seleccionados+' Seleccionados');
            });

            $('.btn-add-agenda').click(function () {
                $("#form-add-evento").trigger("reset");
                $(".actividad, .proceso, .responsable, .responsableG").prop("disabled",false);
                $('#fecha_agenda').attr('value',$(this).data('fecha'));
                $('#modal_add_evento').modal('show');
                $('#form-add-evento .panel-success').removeClass('panel-success').addClass('panel-default');
                $("#form-add-evento .panel .panel-heading .pull-right").html("0 Seleccionados");
            });
            $(".proceso").click(function(){
                $(".area").prop("checked",false)
                $(".area").prop("disabled","disabled")
                if($(this).prop('checked')) {
                    let unidades_ok = $(this).data('unidades');
                    unidades_ok = unidades_ok.toString().split(",");
                    unidades_ok.forEach(function (valor, indice, array) {
                        $("#id_unidad_admin" + valor).prop("checked", "checked").prop("disabled", false);
                    });
                }
            })

            $('.programar').click(function () {
                var procesos=[];
                var responsables=[];
                var areas=[];
                procesos.push({generales:[], especificos: []});
                responsables.push({generales:[], especificos: []});
                areas.push({generales:[], especificos: []});
                $('.actividad:checked').each(function () {
                    procesos[0].generales.push($(this).data('id'));
                });
                $('.proceso:checked').each(function () {
                    procesos[0].especificos.push($(this).data('id'));
                });
                $('.responsableG:checked').each(function () {
                    responsables[0].generales.push($(this).data('id'));
                });
                $('.responsable:checked').each(function () {
                    responsables[0].especificos.push($(this).data('id'));
                });
                $('.areaG:checked').each(function () {
                    areas[0].generales.push($(this).data('id'))
                });
                $('.area:checked').each(function () {
                    areas[0].especificos.push($(this).data('id'))
                });

                if ((procesos[0].especificos.length>0 &&$("#area_criterios").val()!="")|| procesos[0].generales.length>0){
                    $('#procesos').attr('value',JSON.stringify(procesos));
                    $('#responsable').attr('value',JSON.stringify(responsables));
                    $('#area').attr('value',JSON.stringify(areas));

                    Swal.fire({
                        title: 'Cargando',
                        onBeforeOpen: () => {
                            Swal.showLoading();
                            $.ajax({
                                type: 'get',
                                url: "{{url('auditorias/ver_disponibilidad')}}/{{$auditoria->id_auditoria}}",
                                data: {datos: JSON.stringify($('#form-add-evento').serializeArray())},
                                success: function (data) {
                                    Swal.close();
                                    if (data[0].type=="Error"){
                                        Swal.fire({
                                            title: data[0].type,
                                            text: data[0].message,
                                            timer: 5000
                                        })
                                    }
                                    else{
                                        $('.horas').empty().html(data).addClass('has-error').fadeIn(500);
                                        $('.inicio').change(function () {
                                            Swal.fire({
                                                title: 'Cargando',
                                                onBeforeOpen: () => {
                                                    Swal.showLoading()
                                                    $.ajax({
                                                        type: 'get',
                                                        url: "{{url('auditorias/validar_hora')}}/{{$auditoria->id_auditoria}}",
                                                        data: {datos: JSON.stringify($('#form-add-evento').serializeArray())},
                                                        success: function (data2) {
                                                            Swal.close();
                                                            if (data2){
                                                                $('.h_fin').empty().html(data2);
                                                                $('.horas').addClass('has-error').fadeIn(500);
                                                                setInterval(function () {
                                                                    $('.horas').removeClass('has-error')
                                                                },1000)
                                                                $('.fin').change(function () {
                                                                    $('.guarda_evento').addClass('has-error').removeClass('hidden')
                                                                    setInterval(function () {
                                                                        $('.guarda_evento').removeClass('has-error')
                                                                    },1000)
                                                                });
                                                            }
                                                        },
                                                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                                                            Swal.close();
                                                            Swal.fire({
                                                                icon: 'error',
                                                                title: 'Error al cargar los datos',
                                                                timer: 1500
                                                            })
                                                        }
                                                    })
                                                }
                                            });
                                        });
                                        setInterval(function () {
                                            $('.horas').removeClass('has-error')
                                        },1000)
                                    }
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                    Swal.close();
                                    Swal.fire({
                                        title: 'Error al cargar los datos',
                                        timer: 2500
                                    })
                                }
                            })
                        }
                    });
                }
                else{
                    if($("#area_criterios").val()=="")
                        Swal.fire({
                            title: 'Error',
                            text: 'Captura los puntos para la norma a auditar',
                            timer: 2500
                        });
                    else
                    Swal.fire({
                        title: 'Error',
                        text: 'Selecciona la actividad o proceso para agendar',
                        timer: 2500
                    });
                }

            });

            $('.guarda_evento').click(function () {
                console.log($('#form-add-evento').serializeArray())
            });

            $('.elemento').click(function () {
                $.ajax({
                    type: 'get',
                    url: "{{url('auditorias/setItem')}}/"+$(this).data('item')+'/set',
                    data: { },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al establecer la fecha',
                            timer: 1500
                        })
                    }
                })
            });


            $('.delete-event').click(function () {
                var tipo=$(this).data('type');
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
                            $('#tipo').val(tipo);
                            $("#form_delete_evento").attr("action","/auditorias/agenda/"+id).submit();
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) { //Si presionas boton cancelar
                            swal.close()
                        }
                    });
            });

            $('[data-toggle="tooltip"]').tooltip();

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
                   window.open('{{url('auditorias/printPlan')}}/'+programa+'/'+aprueba_formato,'_blank',"fullscreen=yes");
                }
            });
        })

    </script>

@endsection

@extends('layouts.app')
@section('title', 'Agenda del Plan')
@section('content')
    @if(\Illuminate\Support\Facades\Session::get('errors'))
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

                <a href="{{url('/auditorias/planes')}}/{{isset($agendaT[0])?$agendaT[0]->id_auditoria:0}}">Detalles del plan</a>

                <span class="glyphicon glyphicon-chevron-right"></span>
                <a href="{{url('/auditorias/agenda')}}/{{isset($agendaT[0])?$agendaT[0]->id_auditoria:0}}">Agenda del plan</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Editar evento de la agenda</span>
            </p>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Editar evento</h3>
                </div>
                <div class="panel-body">
                    <form action="{{url('auditorias/actualizaEvento')}}/{{$agendaT[0]->id_agenda}}" method="POST" id="reprogramar">
                        @csrf
                            <div class="modal-body">
                                <input type="text" name="id_auditoria" value="" hidden>
                                <input type="text" name="fecha" id="fecha_agenda" hidden value="{{$agendaT[0]->fecha}}">
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-{{sizeof($procesosT)>0?'success':'default'}} procesos">
                                        <div class="panel-heading" role="tab" id="headingProcesos" data-toggle="collapse" data-parent="#accordion" href="#collapseProcesos" aria-expanded="false" aria-controls="collapseProcesos">
                                            <strong class="pull-right procesos">{{sizeof($procesosT)}} Seleccionados</strong>
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
                                                                <input class="actividad" type="checkbox" {{empty($agendaT[0]->procesos)?'disabled':''}} data-id="{{$actividad->id_actividad}}" data-name="actividad" data-back="proceso">
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
                                                <label for="">Procesos</label>
                                                <div class="row">
                                                    @foreach($procesosAsignados as $proceso)
                                                        <div class="col-md-4">
                                                            <label class="checkbox-inline {{in_array($proceso->id_auditoria_proceso,$procesosT)?'bg-success text-success':''}}">
                                                                <input class="proceso" type="checkbox" {{in_array($proceso->id_auditoria_proceso,$procesosT)?'checked':''}} {{empty($agendaT[0]->procesos)?'disabled':''}} data-id="{{$proceso->id_auditoria_proceso}}" data-name="proceso" data-back="actividad">
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
                                    <div class="panel panel-{{(sizeof($agendaT[0]->areas_generales)+sizeof($agendaT[0]->areas))>0?'success':'default'}} areas">
                                        <div class="panel-heading" role="tab" id="headingArea" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <strong class="pull-right areas">{{sizeof($agendaT[0]->areas_generales)+sizeof($agendaT[0]->areas)}} Seleccionados</strong>
                                            <h4 class="panel-title" role="button">
                                                Área
                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingArea">
                                            <div class="panel-body">
                                                <label for="">Generales</label>
                                                <div class="row">
                                                    @foreach($generalAreas as $area)
                                                        <div class="col-md-4">
                                                            <label class="checkbox-inline {{in_array($area->descripcion,$agendaT[0]->areas_generales)?'bg-success text-success':''}}">
                                                                <input class="areaG" type="checkbox" {{empty($agendaT[0]->areas_generales)?'disabled':''}} {{in_array($area->descripcion,$agendaT[0]->areas_generales)?'checked':''}} data-id="{{$area->id_area_general}}" data-name="areaG" data-back="area">
                                                                {{$area->descripcion}}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <hr>
                                                <label for="">Especificas</label>
                                                <div class="row">
                                                    @foreach($areas as $area)
                                                        <div class="col-md-4">
                                                            <label class="checkbox-inline {{in_array($area->nom_departamento,$agendaT[0]->areas)?'bg-success text-success':''}}">
                                                                <input class="area" type="checkbox" {{empty($agendaT[0]->areas)?'disabled':''}} {{in_array($area->nom_departamento,$agendaT[0]->areas)?'checked':''}} data-id="{{$area->id_unidad_admin}}" data-name="area" data-back="areaG">
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
                                    <div class="panel panel-{{sizeof($agendaT[0]->auditores)>0?'success':'default'}} responsables">
                                        <div class="panel-heading" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <strong class="pull-right responsables">{{sizeof($agendaT[0]->auditores)}} Seleccionados</strong>
                                            <h4 class="panel-title" role="button">
                                                Responsable
                                            </h4>
                                        </div>
                                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                            <div class="panel-body">

                                                <label for="">Generales</label>
                                                <div class="row">
                                                </div>
                                                <hr>
                                                <label for="">Especificos</label>
                                                @php $equipo=1; $entrenamiento=1; @endphp
                                                <div class="row">
                                                    @foreach($auditoresT as $auditor)
                                                        <div class="col-md-6">
                                                            <label class="checkbox-inline {{in_array($auditor->id_auditor_auditoria,$agendaT[0]->id_auditores)?'bg-success text-success':''}}">
                                                                <input class="responsable" type="checkbox" {{in_array($auditor->id_auditor_auditoria,$agendaT[0]->id_auditores)?'checked':''}} data-id="{{$auditor->id_auditor_auditoria}}" data-name="responsable" data-back="responsableG">
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
                                        <textarea class="form-control" name="criterios" id="criterios_agenda" rows="2">{{$agendaT[0]->criterios}}</textarea>
                                    </div>
                                    <div class="col-md-2">
                                        <br><br><br>
                                        <botton class="btn btn-success pull-right programar" data-fecha="">Modificar Horario</botton>
                                    </div>
                                </div>
                                <hr>
                                <div class="row horas">
                                    <div class="col-md-6" id="h_inicio">
                                        <label for="inicio">Hora de inicio</label>
                                        <div class="input-group">
                                            <select name="inicio" id="inicio" class="form-control inicio" disabled="true">
                                                <option value="{{$agendaT[0]->hora_i}}" selected="" >{{$agendaT[0]->hora_i}}</option>
                                            </select>
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 h_fin" id="h_fin">
                                        <label for="fin">Hora de Fin</label>
                                        <div class="input-group">
                                            <select name="fin" id="fin" class="form-control fin" disabled="true">
                                                <option value="{{$agendaT[0]->hora_f}}" selected="" disabled="true">{{$agendaT[0]->hora_f}}</option>
                                            </select>
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                        </div>
                                    </div>


                                </div>
                                <input type="text" name="procesos" id="procesos" hidden>
                                <input type="text" name="area" id="area" hidden>
                                <input type="text" name="responsable" id="responsable" hidden>
                                <input type="text" name="id_evento" id="id_evento" value="{{$agendaT[0]->id_agenda}}" hidden>
                            </div>
                            <div class="modal-footer">
                                <a href="{{url('/auditorias/agenda')}}/{{$agendaT[0]->id_auditoria}}" role="button" class="btn btn-default" data-dismiss="modal">Cancelar</a>
                                <input type="submit" class="btn btn-primary guarda_evento" value="Agendar"/>
                            </div>
                        <button type="submit" class="pull-right btn btn-success guarda_agenda hidden">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <form  method="POST" role="form" id="form_delete_auditor">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>

    <script>
        $(document).ready(function () {
            $("#criterios_agenda").change(function(){
                verifyDisponibilidad();

            });
            $('input:checkbox').click(function () {

                seleccionados=0;
                $('.'+$(this).data('name')).each(function () {
                    if ($(this).prop('checked')==true)
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
                verifyDisponibilidad();
            });


            $('.programar').click(function () {
                verifyDisponibilidad();
            });



        function verifyDisponibilidad(){
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

            if (procesos[0].especificos.length>0 || procesos[0].generales.length>0) {
                $('#procesos').attr('value',JSON.stringify(procesos));
                $('#responsable').attr('value',JSON.stringify(responsables));
                $('#area').attr('value',JSON.stringify(areas));

                Swal.fire({
                    title: 'Cargando',
                    onBeforeOpen: () => {
                        Swal.showLoading();
                        $.ajax({
                            type: 'get',
                            url: "{{url('auditorias/ver_disponibilidad')}}/{{$agendaT[0]->id_auditoria}}",
                            data: {datos: JSON.stringify($('#reprogramar').serializeArray())},
                            success: function (data) {
                                console.log(data)
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
                                                    url: "{{url('auditorias/validar_hora')}}/{{$agendaT[0]->id_auditoria}}",
                                                    data: {datos: JSON.stringify($('#reprogramar').serializeArray())},
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
                Swal.fire({
                    title: 'Error',
                    text: 'Selecciona la actividad o proceso para agendar',
                    timer: 2500
                });
            }
        }


            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>

@endsection
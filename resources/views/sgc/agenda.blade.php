<?php
use Carbon\Carbon;
setlocale(LC_ALL, 'es_ES');
?>
@extends('layouts.app')
@foreach($auditorias as $auditoria)
    @section('title', 'Agenda auditoria '.date('Y',strtotime($auditoria->fecha_i)).'-'.$auditoria->id_auditoria)
@endforeach
@section('content')
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <p>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                    <a href="{{url('/sgc/auditorias')}}">Planes de auditorias</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    @foreach($auditorias as $auditoria)
                        <a href="{{url('sgc/ver_plan_auditoria')}}/{{$auditoria->id_auditoria}}">Detalles del Plan</a>
                    @endforeach
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span>Agenda</span>
                </p>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="#" class="pull-left btn_select_aud">
                                        <span class="glyphicon glyphicon-user" data-toggle="tooltip" title="Seleccionar auditor"></span>
                                        @if(isset($auditorSelected))
                                            @foreach($auditorSelected as $selected)
                                                {{$selected->getAbrPer[0]->getAbreviatura[0]->titulo.' '.$selected->getNombre[0]->nombre}}
                                            @endforeach
                                        @endif
                                    </a>
                                </div>
                                <div class="col-md-4 text-center">
                                    Agenda de la auditoria
                                </div>
                            </div>
                        </h3>
                    </div>
                    <div class="panel-body">
                        @if(!Session::get('auditorUsed'))
                            <div class="alert alert-danger" role="alert">No se ha seleccionado un auditor</div>
                        @else
                            <div id="exTab2" class="">
                                <ul class="nav nav-tabs">
                                    @foreach($fechas as $dia)
                                        <li class="{{$dia==Session::get('dateUsed')?'active':''}}"><a href="#{{$dia}}" class="tab" data-fecha="{{$dia}}" data-toggle="tab" aria-expanded="{{$dia==Session::get('dateUsed')?'true':'false'}}">{{$dia}}</a></li>
                                    @endforeach
                                </ul>
                                <div class="tab-content ">
                                    @foreach($fechas as $dia)
                                        <div class="tab-pane {{$dia==Session::get('dateUsed')?'active':''}}" id="{{$dia}}">
                                            <a href="#!" class="pull-right btn-add-agenda" data-fecha="{{$dia}}" data-toggle="tooltip" title="Agregar evento"><span class="glyphicon glyphicon-plus"></span></a>
                                            <h5>Agenda del día {{$dia}}</h5>
                                            <br>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="col-md-1 text-center">Hora</th>
                                                        <th class="col-md-5 text-center">Procesos</th>
                                                        <th class="col-md-3 text-center">Area responsable</th>
                                                        <th class="col-md-2 text-center">Auditor</th>
                                                        <th class="col-md-1 text-center">Acciones</th>
                                                    </tr>
                                                </thead>
                                                    <tbody>
                                                    @foreach($eventos as $evento)
                                                        @if($evento['id_auditor']==Session::get('auditorUsed'))
                                                        @if($evento['fecha']==$dia AND $evento)
                                                        <tr>
                                                            <td>{{$evento['hora_i']}}</td>
                                                            <td>{{$evento['procesos']}}</td>
                                                            <td>{{$evento['area']}}</td>
                                                            <td>{{$evento['auditor']}}</td>
                                                            <td class="text-center"><a href="{{url('/sgc/hoja_trabajo')}}/{{$evento['id_agenda']}}"><span class="glyphicon glyphicon-copy" data-toggle="tooltip" title="Hoja de trabajo"></span></a></td>
                                                        </tr>
                                                        @endif
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <form id="validaHoras" action='{{url("/sgc/validate")}}/2' method="PUT">@csrf</form>

    <div class="modal fade" id="modal_ag" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Registro de actividad</h4>
                </div>
                <form id="form_add_ag" class="form" role="form" method="POST" action="{{url("/sgc/guarda_evento")}}">
                    <div class="modal-body">
                        @csrf
                        <div id="metodo"></div>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="inicio">Hora de inicio</label>
                                <div class="input-group">
                                    <input id="inicio" class="timepicker form-control" type="text" name="inicio">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                            <div hidden class="col-md-4 hora_final">
                                <label for="fin">Hora de termino</label>
                                <div class="input-group">
                                    <input id="fin" class="timepicker form-control" type="text" name="fin">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Área a auditar</label>
                                <select name="area" id="unidad_auditoria" class="form-control">
                                    <option value="" selected disabled="true">Selecciona...</option>
                                    @foreach($areas as $area)
                                        <option value="{{$area->id_unidad_admin}}">{{$area->nom_departamento}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="procesos">Procesos</label>
                                    <textarea class="form-control" name="procesos" id="procesos" ></textarea>
                                </div>

                            </div>

                            <input type="text" name="fecha" hidden id="fecha" value="">
                            @foreach($auditorias as $auditoria)
                                <input type="text" name="id_auditoria" hidden value="{{$auditoria->id_auditoria}}">
                            @endforeach
                            @if(Session::get('auditorUsed'))
                                @foreach($auditorSelected as $auditor)
                                    <input type="text" name="auditor" hidden value="{{$auditor->id_asigna_audi}}">
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_auditores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Registro de actividad</h4>
                </div>
                <form id="form_selec_aud" class="form" role="form" method="GET" action="">
                    <div class="modal-body">
                        <select id="id_set_auditor" class="form-control">
                            <option value="" selected disabled="true">Selecciona...</option>
                            @foreach($auditores as $auditor)
                                @if(Session::get('auditorUsed'))
                                    @foreach($auditorSelected as $selected)
                                        {{$selected->getAbrPer[0]->getAbreviatura[0]->titulo.' '.$selected->getNombre[0]->nombre}}
                                    @endforeach
                                @endif
                                <option value="{{$auditor->id_auditor}}" {{Session::get('auditorUsed')==$auditor->id_auditor?'selected':''}}>{{$auditor->getAbrPer[0]->getAbreviatura[0]->titulo.' '.$auditor->getNombre[0]->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Ok"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(".btn-add-agenda").click(function () {
                var fecha=$(this).data('fecha');
                $("#fecha").val(fecha);
                $('#metodo').html('<input type="hidden" name="_method" value="PUT" id="met">');
                $.post('{{url("/sgc/validate")}}/2',$('#form_add_ag').serialize(),function (res) {
                    if(res.length>0){
                        $('#inicio').pickatime({
                            min: [9,0],
                            max: [18,0],
                            format: 'HH:i',
                            disable: res,
                            onSet: function () {
                                $('#fin').pickatime({
                                    min: $('#inicio').val(),
                                    format: 'HH:i',
                                    disable: res
                                })
                                $('.hora_final').fadeIn(500);
                            }
                        })
                    }
                    else{
                        $('#inicio').pickatime({
                            min: [9,0],
                            max: [18,0],
                            format: 'HH:i',
                            onSet: function () {
                                $('#fin').pickatime({
                                    min: $('#inicio').val(),
                                    format: 'HH:i',
                                })
                                $('.hora_final').fadeIn(500);
                            }
                        })
                    }

                })
                $("#modal_ag").modal('show');
            });

            $('#unidad_auditoria').change(function () {
                $('#metodo').html('<input type="hidden" name="_method" value="PUT" id="met">');
                $.post('{{url("/sgc/validate")}}/1',$('#form_add_ag').serialize(),function (res) {
                    $('#auditor_area').html(res);
                    $('.auditores_area').fadeIn(500);
                    $('#metodo').empty();
                })
            });

            $(".btn_select_aud").click(function(){
                $("#modal_auditores").modal('show');
            });

            $("#id_set_auditor").change(function () {
                $("#form_selec_aud").attr('action','{{url('/sgc/auditor')}}/'+$(this).val())
            });



            $(".tab").click(function () {
                $.get('{{url('/sgc/setFecha')}}/'+$(this).data('fecha'))
            });



            $('[data-toggle="tooltip"]').tooltip();

        })
    </script>
@endsection

















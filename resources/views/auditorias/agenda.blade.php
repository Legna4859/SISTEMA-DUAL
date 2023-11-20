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
                <a href="{{url('/auditorias/planes')}}/{{$auditoria_id}}">Detalles del plan</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Agenda del plan</span>
            </p>
            <div class="panel panel-info">
                <div class="panel-heading">
                    @if($porcentaje>=100)
                        <a href="{{url('auditorias/printPlan')}}/{{$auditoria_id}}" class="pull-right"><span class="glyphicon glyphicon-print"></span></a>
                    @endif
                    @foreach($auditorias as $auditoria_n)
                        @if($auditoria_n->id_auditoria==$auditoria_id)
                            <h3 class="panel-title text-center">Agenda del plan {{\Carbon\Carbon::parse($auditoria_n->fecha_i)->format('Y')}}-{{$loop->iteration}}</h3>
                        @endif
                    @endforeach
                </div>
                <div class="panel-body">
                    @if($porcentaje>0)
                        <div class="progress" id="porcentaje">
                            <div class="progress-bar" role="progressbar" aria-valuenow="{{$porcentaje}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentaje}}%;">
                                Agendado el {{$porcentaje}}% de los procesos del plan
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
                                        <div class="panel panel-success form_programar{{$dia}}" {{$dia==Session::get('dia')?Session::get('editando'):'hidden'}}>
                                            <div class="panel-heading">
                                                <a href="#" class="pull-right btn-cancelar-agregar" data-fecha="{{$dia}}" data-toggle="tooltip" title="Cancelar"><span class="glyphicon glyphicon-remove"></span></a>
                                                <h3 class="panel-title text-center">Agregar evento a la agenda</h3>
                                            </div>
                                            <div class="panel-body">
                                                <form id="form_programar{{$dia}}" action="{{url('auditorias/agenda')}}" method="POST">
                                                    @csrf
                                                    <input class="opcion" type="text" name="opcion" hidden value="">
                                                    <input type="text" name="fecha" hidden value="{{$dia}}">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="proceso">Proceso(s) a auditar&nbsp;<a href="{{url('auditorias/agenda')}}/{{$auditoria_id}}/{{$dia}}/edit" class="pull-right" data-toggle="tooltip" title="Seleccionar procesos"><span class="glyphicon glyphicon-cog"></span></a></label>
                                                                @if(\Illuminate\Support\Facades\Session::get('dia')==$dia)
                                                                    @foreach($procesos as $proceso)
                                                                        <li class="item list-group-item">{{\App\audParseCase::parseProceso($proceso->des_proceso)}}</li>
                                                                    @endforeach
                                                                @endif
                                                                <input type="text" name="procesos" hidden value="{{json_encode($procesosE)}}">
                                                            </div>
                                                            <div>
                                                                <label for="">Puntos de la norma a auditar</label>
                                                                <textarea class="form-control" name="criterios" id="" rows="2"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="area">Area</label>
                                                                <select class="form-control" name="area" id="area">
                                                                    <option value="" selected disabled="true">Selecciona...</option>
                                                                    @foreach($areas as $area)
                                                                        <option value="{{$area->id_unidad_admin}}">{{\App\audParseCase::parseNombre($area->nom_departamento)}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="area">Auditor Responsable</label>
                                                                <select class="form-control" name="auditor" id="auditor">
                                                                    <option value="" selected disabled="true">Selecciona...</option>
                                                                    <optgroup label="Generales">
                                                                        <option value="">Grupo auditor</option>
                                                                    </optgroup>
                                                                    <optgroup label="Especificos">
                                                                        <option value="{{$auditor_l->id_auditor_auditoria}}">Auditor Lider  ({{\App\audParseCase::parseAbr($auditor_l->titulo).' '.\App\audParseCase::parseNombre($auditor_l->nombre)}})</option>
                                                                        @foreach($auditores as $auditor)
                                                                            <option value="{{$auditor->id_auditor_auditoria}}">Auditor {{$loop->iteration}}  ({{\App\audParseCase::parseAbr($auditor->titulo).' '.\App\audParseCase::parseNombre($auditor->nombre)}})</option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                            @if(sizeof($auditores_entrenamiento)>0)
                                                                <div>
                                                                    <div class="form-group">
                                                                        <label for="area">Auditor en Entrenamiento</label>
                                                                        <select class="form-control" name="" id="auditor_entrenamiento">
                                                                            <option value="" selected disabled="true">Selecciona...</option>
                                                                            @foreach($auditores_entrenamiento as $auditor)
                                                                                <option value="{{$auditor->id_auditor_auditoria}}">{{\App\audParseCase::parseAbr($auditor->titulo).' '.\App\audParseCase::parseNombre($auditor->nombre)}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <botton class="btn btn-success pull-right programar" data-fecha="{{$dia}}">Ver disponibilidad</botton>
                                                        </div>
                                                    </div>
                                                    <div class="row horas" hidden></div>
                                                    <br>
                                                    <button type="submit" class="pull-right btn btn-success guarda_agenda hidden" data-fecha="{{$dia}}">Guardar</button>
                                                    <br>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="agenda-general panel panel-success">
                                            <div class="panel-heading">
                                                <a href="#!" class="pull-right btn-add-agenda" data-fecha="{{$dia}}" data-toggle="tooltip" title="Agregar evento"><span class="glyphicon glyphicon-plus"></span></a>
                                                <h3 class="panel-title text-center">Agenda del día {{$dia}}</h3>
                                            </div>
                                            <table class="panel-body table table-bordered table-hover">
                                                <thead>
                                                <th>Hora inicio</th>
                                                <th>Hora fin</th>
                                                <th>Proceso</th>
                                                <th>Auditor</th>
                                                <th>Area</th>
                                                <th>Acciones</th>
                                                </thead>
                                                <tbody>

                                                @foreach($horasAgenda as $evento)
                                                    @if($evento->fecha==$dia)
                                                        <tr>
                                                            <td>{{\Carbon\Carbon::parse($evento->hora_i)->format('H:i')}}</td>
                                                            <td>{{\Carbon\Carbon::parse($evento->hora_f)->format('H:i')}}</td>
                                                            <td>
                                                                <p>{{$evento->criterios}}</p>
                                                                @foreach(\App\AudAgenda::getProcesos($evento->id_agenda) as $proceso)
                                                                    <p>{{\App\audParseCase::parseProceso($proceso->proceso)}}</p>
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach(\App\AudAgenda::getAuditores($evento->id_agenda) as $auditor)
                                                                    @if($auditor->id_categoria==1)
                                                                        Auditor Lider
                                                                    @else
                                                                        @foreach(\App\AudAuditorias::getAuditores($auditoria_id,2) as $audT)
                                                                            @if($audT->nombre==$auditor->nombre)<p>Auditor {{$loop->iteration}}</p>@endif
                                                                        @endforeach
                                                                        @foreach(\App\AudAuditorias::getAuditores($auditoria_id,3) as $audT)
                                                                            @if($audT->nombre==$auditor->nombre)<p>AE {{$loop->iteration}}</p>@endif
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>{{\App\audParseCase::parseNombre($evento->nom_departamento)}}</td>
                                                            <td>
                                                                <a href="{{url('auditorias/evento')}}/{{$evento->id_agenda}}" class="pull-left" data-id="{{$evento->id_agenda}}"><span class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Configurar evento"></span></a>
                                                                <a href="#" class="pull-right btn_delete_evento" data-id="{{$evento->id_agenda}}"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar evento"></span></a>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                @endforeach
                                                </tbody>
                                            </table>
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
            <form id="form-add-evento" method="POST" action="">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar evento a la agenda</h4>
                    </div>
                    <div class="modal-body">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingProcesos">
                                    <h4 class="panel-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseProcesos" aria-expanded="false" aria-controls="collapseProcesos">
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
                                                    <input class="proceso" type="checkbox" data-id="{{$actividad->id_actividad}}">
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
                                                    <label class="checkbox-inline">
                                                        <input class="proceso" type="checkbox" data-id="{{$proceso->id_auditoria_proceso}}">
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
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingArea">
                                    <h4 class="panel-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Área
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingArea">
                                    <div class="panel-body">
                                        <label for="">Generales</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="checkbox-inline">
                                                    <input class="area" type="checkbox" data-id="-1">
                                                    Jefaturas de División
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="checkbox-inline">
                                                    <input class="area" type="checkbox" data-id="-2">
                                                    Área academica
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="checkbox-inline">
                                                    <input class="area" type="checkbox" data-id="-3">
                                                    Área administrativa
                                                </label>
                                            </div>
                                        </div>
                                        <hr>
                                        <label for="">Especificas</label>
                                        <div class="row">
                                        @foreach($areas as $area)
                                            <div class="col-md-4">
                                                <label class="checkbox-inline">
                                                    <input class="area" type="checkbox" data-id="{{$area->id_unidad_admin}}">
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
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Responsable
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="panel-body">

                                        <label for="">Generales</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="checkbox-inline">
                                                    <input class="area" type="checkbox" data-id="-1">
                                                    Director General
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="checkbox-inline">
                                                    <input class="area" type="checkbox" data-id="-2">
                                                    Grupo Auditor
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="checkbox-inline">
                                                    <input class="area" type="checkbox" data-id="-3">
                                                    Coordinadora del SGC
                                                </label>
                                            </div>
                                        </div>
                                        <hr>
                                        <label for="">Especificos</label>
                                        @php $equipo=1; $entrenamiento=1; @endphp
                                        <div class="row">
                                            @foreach($auditoresT as $auditor)
                                                <div class="col-md-6">
                                                    <label class="checkbox-inline">
                                                        <input class="area" type="checkbox" data-id="{{$auditor->id_auditor_auditoria}}">
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
                        <div>
                            <label for="">Puntos de la norma a auditar</label>
                            <textarea class="form-control" name="criterios" id="" rows="2"></textarea>
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

    <form  method="POST" role="form" id="form_delete_evento">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>

    <script>
        $(document).ready(function () {


            $('#modal_add_evento').modal('show');


            fecha="";
            $('.hora_agenda').click(function () {
                alert($(this).data('inicio')+" - "+$(this).data('fin'))
            });

            $('.btn-add-agenda').click(function () {
                alert("ok");
                $("#form-add-evento input[type=checkbox]").prop( "checked", false );
                $('.agenda-general').fadeOut();
                $('.form_programar'+$(this).data('fecha')).fadeIn();
                fecha=$(this).data('fecha');
            });

            $('.btn-cancelar-agregar').click(function () {
                $('.form_programar'+$(this).data('fecha')).fadeOut();
                $('.agenda-general').fadeIn();
            });
            
            $('.programar').click(function () {
                fecha=$(this).data('fecha');
                $('.opcion').attr('value','1');
                Swal.fire({
                    title: 'Cargando',
                    onBeforeOpen: () => {
                        Swal.showLoading()
                        $.ajax({
                            type: 'get',
                            url: "{{url('auditorias/validar')}}/{{$auditoria_id}}",
                            data: {datos: JSON.stringify($('#form_programar'+fecha).serializeArray())},
                            success: function (data) {
                                if (Array.isArray(data)){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: data[0],
                                    })
                                    return false;
                                }
                                $('.opcion').attr('value','2');
                                Swal.close();
                                if (data){
                                    $('.horas').empty().html(data).addClass('has-error').fadeIn(500);
                                    $('.inicio').change(function () {
                                        Swal.fire({
                                            title: 'Cargando',
                                            onBeforeOpen: () => {
                                                Swal.showLoading()
                                                $.ajax({
                                                    type: 'get',
                                                    url: "{{url('auditorias/validar')}}/{{$auditoria_id}}",
                                                    data: {datos: JSON.stringify($('#form_programar' + fecha).serializeArray())},
                                                    success: function (data2) {
                                                        Swal.close();
                                                        if (data2){
                                                            $('.h_fin').empty().html(data2);
                                                            $('.horas').addClass('has-error').fadeIn(500);
                                                            setInterval(function () {
                                                                $('.horas').removeClass('has-error')
                                                            },1000)
                                                            $('.fin').change(function () {
                                                                $('.guarda_agenda').addClass('has-error').removeClass('hidden')
                                                                setInterval(function () {
                                                                    $('.guarda_agenda').removeClass('has-error')
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
                                else{

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
                })
            });

            $('#auditor').change(function () {
                $('.horas').fadeOut(100);
            });

            $('#auditor_entrenamiento').change(function () {
                $(this).attr('name','auditor_entrenamiento');
                $('.horas').fadeOut(100);
            });

            $('.elemento').click(function () {
                $('.horas').fadeOut();
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

            $('.guarda_agenda').click(function () {
                console.log($('#form_programar'+$(this).data('fecha')).serialize());
            });

            $(".btn_delete_evento").click(function(){
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
                        $("#form_delete_evento").attr("action","/auditorias/evento/"+id)
                        $("#form_delete_evento").submit();
                    }
                    else if (result.dismiss === Swal.DismissReason.cancel) { //Si presionas boton cancelar
                        swal.close()
                    }
                });
            });


            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>

@endsection
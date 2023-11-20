@extends('layouts.app')
@foreach($auditorias as $auditoria)
    @section('title', 'Detalle auditoria '.date('Y',strtotime($auditoria->fecha_i)).'-'.$auditoria->id_auditoria)
@endforeach
@section('content')
    <?php use \Carbon\Carbon; ?>
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <p>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                    <a href="{{url('/sgc/auditorias')}}">Planes de auditorias</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span>Detalles del Plan</span>
                </p>
                @if (session()->has('flash_notification.message'))
                    <div class="alert alert-{{ session('flash_notification.level') }}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! session('flash_notification.message') !!}
                    </div>
                @endif
                @foreach($auditorias as $auditoria)
                <div class="panel panel-info">
                    <div class="panel-heading text-center">
                            Detalles del plan de auditoría {{date('Y',strtotime($auditoria->fecha_i)).'-'.$auditoria->id_auditoria}}
                            <a href="{{url("/sgc/agenda").'/'.$auditoria->id_auditoria}}" class="pull-right" data-all="{{$auditoria}}"><span class="glyphicon glyphicon-th" data-toggle="tooltip" title="Editar agenda de auditoria"></span></a>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Objetivo</label>
                                <a href="#" class="btn-edit-plan pull-right" data-all="{{$auditoria}}"><span class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Editar plan"></span></a>
                                <p>{{$auditoria->objetivo}}</p>
                            </div>
                            <div class="col-md-6">
                                <label>Alcance</label>
                                <p>{{$auditoria->alcance}}</p>
                            </div>
                            <div class="col-md-6">
                                <label>Fechas</label>
                                <p>Del <strong>{{Carbon::parse($auditoria->fecha_i)->format('d/m/Y')}}</strong> al <strong>{{Carbon::parse($auditoria->fecha_f)->format('d/m/Y')}}</strong></p>
                            </div>
                            <div class="col-md-12">
                                <label>Criterios de auditoría</label>
                                <a href="#" class="btn_add_norm" data-id="{{$auditoria->id_auditoria}}" data-toggle="modal" data-target="#modal_add_norm"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar criterio de auditoria"></span></a>
                                <div class="row">
                                    @if(sizeof($criteriosAud)>0)
                                        @foreach($criteriosAud as $criterio)
                                            <div class="col-md-6">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <span class="col-md-11">{{str_limit($criterio->getCriterio[0]->descripcion, $limit = 120, $end = '...')}}</span>
                                                        <a href="#" class="col-md-1 btn_delete_criterio" data-id="{{$criterio->id_normatividad_auditoria}}"><span aria-hidden="true" class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar criterio"></span></a>
                                                    </div>
                                                </li>
                                            </div>

                                        @endforeach
                                    @else
                                        <div class="col-md-12 alert alert-danger" role="alert">No se han agregado los criterios de la auditoria</div>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <hr>
                        {{--<a href="#" class="pull-right btn_add_auditores" data-id="{{$auditoria->id_auditoria}}" data-toggle="modal" data-target="#modal_add_auditores"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar Auditores"></span></a>--}}
                        <div class="row">
                            <div class="col-md-6">
                                <label>Auditor Líder:</label>
                                @if($lider->isEmpty())
                                    <a href="#" class="btn-add-lider" data-id="{{$auditoria->id_auditoria}}" data-toggle="modal" data-target="#modal_edit_lider"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar lider"></span></a>
                                    <div class="alert alert-danger" role="alert">No se ha agregado un lider</div>
                                @else
                                    @foreach($lider as $auditor)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <span class="col-md-10">{{$auditor->getAbrPer[0]->getAbreviatura[0]->titulo.' '.$auditor->getNombre[0]->nombre}}</span>
                                            {{--<a href="#" class="btn-edit-lider col-md-1" data-id="{{$auditor->id_asigna_audi}}" data-toggle="modal" data-target="#modal_edit_lider"><span class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Editar lider"></span></a>--}}
                                            <a href="#" class="pull-right btn_delete_auditor col-md-1" data-id="{{$auditor->id_asigna_audi}}"><span aria-hidden="true" class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar lider"></span></a>
                                        </div>
                                    </li>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Equipo de auditores:</label>
                                <a href="#" class="btn-add-aquipo" data-id="{{$auditoria->id_auditoria}}" data-toggle="modal" data-target="#modal_edit_equipo"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar auditor"></span></a>
                                @if($equipo->isEmpty())
                                    <div class="alert alert-danger" role="alert">No se han agregado auditores al equipo</div>
                                @else
                                    <ul class="list-group">
                                    @foreach($equipo as $auditor)
                                        <li class="list-group-item">
                                            <div class="row">
                                                <span class="col-md-10"><label>Auditor {{$loop->iteration}}:</label>{{' '.$auditor->getAbrPer[0]->getAbreviatura[0]->titulo.' '.$auditor->getNombre[0]->nombre}}</span>
                                                {{--<a href="#" class="btn-edit-equipo col-md-1" data-id="{{$auditor->id_asigna_audi}}" data-toggle="modal" data-target="#modal_edit_equipo"><span class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Editar auditor"></span></a>--}}
{{--                                                <a href="#" class="pull-right btn_delete_auditor col-md-1" data-id="{{$auditor->id_asigna_audi}}"><span aria-hidden="true" class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar auditor"></span></a>--}}
                                            </div>
                                        </li>
                                    @endforeach
                                    </ul>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label>Auditores en entrenamiento:</label>
                                <a href="#" class="btn-add-entrenado" data-id="{{$auditoria->id_auditoria}}" data-toggle="modal" data-target="#modal_edit_entrenado"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar auditor"></span></a>
                                @if($entrenados->isEmpty())
                                    <div class="alert alert-danger" role="alert">No se han agregado auditores en entrenamiento</div>
                                @else
                                    <ul class="list-group">
                                    @foreach($entrenados as $auditor)
                                        <li class="list-group-item">
                                            <div class="row">
                                                <span class="col-md-10"><label>Auditor {{$loop->iteration}}:</label>{{' '.$auditor->getAbrPer[0]->getAbreviatura[0]->titulo.' '.$auditor->getNombre[0]->nombre}}</span>
                                                {{--<a href="#" class="btn-edit-entrenado col-md-1" data-id="{{$auditor->id_asigna_audi}}" data-toggle="modal" data-target="#modal_edit_entrenado"><span class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Editar auditor"></span></a>--}}
{{--                                                <a href="#" class="pull-right btn_delete_auditor col-md-1" data-id="{{$auditor->id_asigna_audi}}"><span aria-hidden="true" class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar auditor"></span></a>--}}
                                            </div>
                                        </li>
                                    @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>


    <form  method="POST" role="form" id="form_delete">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>

    <form  method="POST" role="form" id="form_delete_criterio">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>


    <form action="{{url('/sgc/add_criterio')}}" method="post">
        <div class="modal fade" id="modal_add_norm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar normatividad</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @foreach($auditorias as $auditoria)
                            <input hidden type="text" name="id_auditoria" value="{{$auditoria->id_auditoria}}">
                        @endforeach
                        <select class="form-control" name="id_normatividad" id="id_normatividad">
                            <option value="" selected="true" disabled="true">Selecciona...</option>
                            @foreach($normatividad as $criterio)
                                    <?php $descripcion=explode('.',$criterio->descripcion); ?>
                                    <option {{$criteriosUsed->search($criterio->id_normatividad)>-1?'disabled ':''}} value="{{$criterio->id_normatividad}}">{{$descripcion[0]}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form id="form_edit_aud" class="form" role="form" method="POST" action="">
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
                                    <label for="objetivo">Objetivo</label>
                                    <textarea class="form-control" id="objetivo" name="objetivo" placeholder="Objetivo del plan de auditorias"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="alcance">Alcance</label>
                                    <textarea class="form-control" id="alcance" name="alcance" placeholder="Alcance del plan de auditorias"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_i">Fecha de inicio</label>
                                <input id="fecha_i" name="fecha_i" type="date">
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_f">Fecha de termino</label>
                                <input id="fecha_f" name="fecha_f" type="date">
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
    <form id="form_lider" class="form" role="form" method="POST" action="">
        <div class="modal fade" id="modal_edit_lider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Lider de la auditoria</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method("PUT")
                        <input type="text" name="type" hidden id="type_l" value="">
                        <select class="form-control" name="id_auditor" id="lider">
                            <option value="" selected="true" disabled="true">Selecciona...</option>
                            @if($lider->isEmpty())
                                @foreach($personas as $auditor)
                                    @foreach($auditor->getAbrPer as $AbrPer)
                                        <option value="{{$auditor->id_personal}}" {{$auditores->search($auditor->id_personal)>-1?'disabled ':''}}>{{$AbrPer->getAbreviatura[0]->titulo.' '.$auditor->nombre}}</option>
                                    @endforeach
                                @endforeach
                            @else
                                @foreach($lider as $persona_l)
                                    @foreach($personas as $auditor)
                                        @foreach($auditor->getAbrPer as $AbrPer)
                                            <option value="{{$auditor->id_personal}}" {{$auditores->search($auditor->id_personal)>-1?'disabled ':''}} {{$auditor->id_personal==$persona_l->id_auditor?'selected ':''}}>{{$AbrPer->getAbreviatura[0]->titulo.' '.$auditor->nombre}}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form id="form_equipo" class="form" role="form" method="POST" action="">
        <div class="modal fade" id="modal_edit_equipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Equipo de auditores</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method("PUT")
                        <input type="text" name="type" hidden id="type_eq" value="">
                        <select class="form-control" name="id_auditor" id="equipo">
                            <option value="" selected="true" disabled="true">Selecciona...</option>
                            @foreach($personas as $auditor)
                                @foreach($auditor->getAbrPer as $AbrPer)
                                    <option value="{{$auditor->id_personal}}" {{$auditores->search($auditor->id_personal)>-1?'disabled ':''}}>{{$AbrPer->getAbreviatura[0]->titulo.' '.$auditor->nombre}}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form id="form_entrenado" class="form" role="form" method="POST" action="">
        <div class="modal fade" id="modal_edit_entrenado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Auditores en entrenamiento</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method("PUT")
                        <input type="text" name="type" hidden id="type_en" value="">
                        <select class="form-control" name="id_auditor" id="entrenados">
                            <option value="" selected="true" disabled="true">Selecciona...</option>
                            @foreach($personas as $auditor)
                                @foreach($auditor->getAbrPer as $AbrPer)
                                    <option value="{{$auditor->id_personal}}" {{$auditores->search($auditor->id_personal)>-1?'disabled ':''}}>{{$AbrPer->getAbreviatura[0]->titulo.' '.$auditor->nombre}}</option>
                                @endforeach
                            @endforeach
                        </select>
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
        $(".btn-edit-plan").click(function () {
            var data=$(this).data('all');
            $("#form_edit_aud").attr("action","{{url("/sgc/auditorias")}}/"+data['id_auditoria'])
            $("#objetivo").val(data['objetivo']);
            $("#alcance").val(data['alcance']);
            $("#criterios").val(data['criterios']);
            $("#fecha_i").val(data['fecha_i'])
            $("#fecha_f").val(data['fecha_f'])
            $("#modal_edit_aud").modal('show');
        });

        $(".btn-edit-lider").click(function () {
            var id=$(this).data('id');
            $("#form_lider").attr("action","{{url("/sgc/asignaAudi")}}/"+id)
            $("#type_l").val("edit_lider");
        });
        $(".btn-add-lider").click(function () {
            var id=$(this).data('id');
            $("#form_lider").attr("action","{{url("/sgc/asignaAudi")}}/"+id)
            $("#type_l").val("add_lider");
        });
        $(".btn-add-aquipo").click(function () {
            var id=$(this).data('id');
            $("#form_equipo").attr("action","{{url("/sgc/asignaAudi")}}/"+id)
            $("#type_eq").val("add_equipo");
        });
        $(".btn-edit-aquipo").click(function () {
            var id=$(this).data('id');
            $("#form_equipo").attr("action","{{url("/sgc/asignaAudi")}}/"+id)
            $("#type_eq").val("edit_equipo");
        });
        $(".btn-add-entrenado").click(function () {
            var id=$(this).data('id');
            $("#form_entrenado").attr("action","{{url("/sgc/asignaAudi")}}/"+id)
            $("#type_en").val("add_entrenado");
        });
        $(".btn-edit-entrenado").click(function () {
            var id=$(this).data('id');
            $("#form_entrenado").attr("action","{{url("/sgc/asignaAudi")}}/"+id)
            $("#type_en").val("edit_entrenado");
        });

        $(".btn_delete_auditor").click(function(){
            var id=$(this).data('id');
            swal({
                title: "¿Seguro que desea eliminar?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $("#form_delete").attr("action","{{url('sgc/asignaAudi')}}/"+id)
                        $("#form_delete").submit();
                    }
                });
        });

        $(".btn_delete_criterio").click(function(){
            var id=$(this).data('id');
            swal({
                title: "¿Seguro que desea eliminar?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $("#form_delete_criterio").attr("action","{{url('sgc/delete_criterio')}}/"+id)
                        $("#form_delete_criterio").submit();
                    }
                });
        });

        $('[data-toggle="tooltip"]').tooltip();

    </script>
@endsection
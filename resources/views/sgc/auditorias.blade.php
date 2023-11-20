@extends('layouts.app')
@section('title', 'Auditorias')
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
                    <h3 class="panel-title text-center">Auditorias Internas</h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="col-md-4">Numero de Auditoria</th>
                            <th class="col-md-6">Periodo</th>
                            <th class="col-md-2 text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($auditorias as $data_auditoria)
                            <tr>
                                <td>
                                    <a href="{{url('sgc/ver_plan_auditoria/')}}/{{$data_auditoria->id_auditoria}}">{{date('Y',strtotime($data_auditoria->fecha_i)).'-'.$data_auditoria->id_auditoria}}</a>

                                </td>
                                <td>
                                    <p>{{$data_auditoria->fecha_i}}  al  {{$data_auditoria->fecha_f}}</p>
                                </td>
                                <td class="text-center">
                                    {{--<a href="#" class="pull-left btn_add_auditores" data-id="{{$data_auditoria->id_auditoria}}" data-toggle="modal" data-target="#modal_add_auditores"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar Auditores"></span></a>--}}
                                    {{--<a href="#" class="btn-edit-plan" data-all="{{$data_auditoria}}"><span class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Editar plan"></span></a>--}}
                                    <a href="#" class="btn_delete_plan" data-id="{{$data_auditoria->id_auditoria}}"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar Plan de Auditoria"></span></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            {{--<div id="accordion" class="panel-group">--}}
                {{--@foreach($auditorias as $data_auditoria)--}}
                    {{--<div class="panel ">--}}
                        {{--<div class="panel-heading btn-default">--}}
                            {{--<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$data_auditoria->id_auditoria}}" data-id="{{$data_auditoria->id_auditoria}}" class="btn_open_panel"><span data-toggle="tooltip" title="Mostrar detalles">Plan de auditoria {{date('Y',strtotime($data_auditoria->fecha_i)).'-'.$data_auditoria->id_auditoria}}</span></span></a>--}}
                            {{--<a href="#!" class="pull-right btn_delete_plan" data-id="{{$data_auditoria->id_auditoria}}"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar Plan de Auditoria"></span></a>--}}
                        {{--</div>--}}
                        {{--<div id="collapse{{$data_auditoria->id_auditoria}}" class="panel-collapse collapse ">--}}
                            {{--<div class="panel-body">--}}
                                {{--<div class="col-md-3">--}}
                                    {{--<strong>Objetivo</strong>--}}
                                    {{--<p>{{$data_auditoria->objetivo}}</p>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-3">--}}
                                    {{--<strong>Alcance</strong>--}}
                                    {{--<p>{{$data_auditoria->alcance}}</p>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-3">--}}
                                    {{--<strong>Criterios</strong>--}}
                                    {{--<p>{{$data_auditoria->criterios}}</p>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-3">--}}
                                    {{--<div class="row">--}}
                                        {{--<div class="col-md-6">--}}
                                            {{--<strong>Fecha de inicio</strong>--}}
                                            {{--<p>{{$data_auditoria->fecha_i}}</p>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-md-6">--}}
                                            {{--<strong>Fecha de termino</strong>--}}
                                            {{--<p>{{$data_auditoria->fecha_f}}</p>--}}
                                            {{--<br>--}}
                                            {{--<h4>--}}
                                                {{--<a href="#" class="pull-left btn-edit-plan" data-all="{{$data_auditoria}}"><span class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Editar plan"></span></a>--}}
                                            {{--</h4>--}}
                                            {{--<h4>--}}
                                                {{--<a href="#" class="pull-right btn_add_auditores" data-id="{{$data_auditoria->id_auditoria}}" data-toggle="modal" data-target="#modal_add_auditores"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar Auditores"></span></a>--}}
                                            {{--</h4>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--@endforeach--}}
            {{--</div>--}}
        </div>
    </main>

    <div>
        <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nueva auditoria" data-target="#modal_crea_aud" type="button" class="btn btn-success btn-lg flotante">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
    </div>

    <form id="form_add_aud" class="form" role="form" method="POST" action="{{url("/sgc/auditorias")}}">
        <div class="modal fade" id="modal_crea_aud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Registro de plan de auditorias</h4>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="objetivo">Objetivo</label>
                                    <textarea class="form-control"name="objetivo" placeholder="Objetivo del plan de auditorias"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="alcance">Alcance</label>
                                    <textarea class="form-control"name="alcance" placeholder="Alcance del plan de auditorias"></textarea>
                                </div>
                                {{--<div class="form-group">--}}
                                    {{--<label for="criterios">Criterios</label>--}}
                                    {{--<textarea class="form-control"name="criterios" placeholder="Criterios del plan de auditorias"></textarea>--}}
                                {{--</div>--}}
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_i">Fecha de inicio</label>
                                <input name="fecha_i" type="date">
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_f">Fecha de termino</label>
                                <input name="fecha_f" type="date">
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

    <form id="form_edit_aud" class="form" role="form" method="POST" action="">
        <div class="modal fade" id="modal_edit_aud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Registro de plan de auditorias</h4>
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
                                <div class="form-group">
                                    <label for="criterios">Criterios</label>
                                    <textarea class="form-control" id="criterios" name="criterios" placeholder="Criterios del plan de auditorias"></textarea>
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

    <form id="form_add_auditores" class="form" role="form" method="POST" action="{{url("/sgc/asignaAudi")}}">
        <div class="modal fade" id="modal_add_auditores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Registro de auditores</h4>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <input type="text" name="id_auditoria" id="id_auditoria" hidden>
                        <div class="form-group">
                            <label for="">Lider de la Auditoria</label>
                            <select class="form-control" name="lider">
                                <option value="" selected="true" disabled="true">Selecciona...</option>
                                @foreach($personas as $auditores)
                                    <option value="{{$auditores->id_personal}}">{{$auditores->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Equipo de Auditores</label>
                            </div>
                            <div class="col-xs-3 text-right">
                                <label for="">Número de auditores:</label>
                            </div>
                            <div class="col-xs-3">
                                <select class="form-control" name="num_auditores" id="num_auditores">
                                    <option value="" selected="true" disabled="true">Selecciona...</option>
                                    @for($i = 1; $i<=10; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="row" id="auditores">

                        </div>
                        <hr>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="en_entrenamiento" id="en_entrenamiento">
                                ¿Agregar auditores en entrenamiento?
                            </label>
                        </div>
                        <div hidden class="entrenamiento">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label for="">Número de auditores en entrenamiento:</label>
                                </div>
                                <div class="col-xs-4">
                                    <select class="form-control" name="num_auditores_ent" id="num_auditores_ent">
                                        <option value="" selected="true" disabled="true">Selecciona...</option>
                                        @for($i = 1; $i<=10; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="auditores_ent">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form  method="POST" role="form" id="form_delete">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>

    <script>
        $(document).ready(function () {
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

            $(".btn_delete_plan").click(function(){
                var id=$(this).data('id');
                swal({
                    title: "¿Seguro que desea eliminar?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $("#form_delete").attr("action","{{url('sgc/auditorias')}}/"+id)
                            $("#form_delete").submit();
                        }
                    });
            });

            $(".btn_add_auditores").click(function () {
                $("#id_auditoria").val($(this).data('id'))
            })

            $("#num_auditores").change(function () {
                $("#auditores").empty();
                var num=$(this).val();
                $.get("{{url('/sgc/auditorias/auditores')}}/1/"+$(this).val(),{},function (res) {
                    $("#auditores").append(res);
                });
            });
            $("#num_auditores_ent").change(function () {
                $("#auditores_ent").empty();
                var num=$(this).val();
                $.get("{{url('/sgc/auditorias/auditores')}}/2/"+$(this).val(),{},function (res) {
                    $("#auditores_ent").append(res);
                });
            });

            $("#en_entrenamiento").change(function () {
                if ($(this).is(':checked'))$(".entrenamiento").fadeIn(500);
                else $(".entrenamiento").fadeOut(500);
            });


            $('[data-toggle="tooltip"]').tooltip();

        })
    </script>
@endsection
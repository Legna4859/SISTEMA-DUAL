@extends('layouts.app')
@section('title','Agendar auditorias')
@section('content')

    @foreach($programas as $programa)
        <div class="panel-heading">
            <a href="#" class="btn_add_aud"><span class="pull-right glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar auditoria"></span></a>
            <h3 class="panel-title text-center">Auditorias del programa
                <strong>
                    {{\Jenssegers\Date\Date::parse($programa->fecha_i)->format('F')}} - {{\Jenssegers\Date\Date::parse($programa->fecha_f)->format('F Y')}}
                </strong>
            </h3>
        </div>
        <div class="panel-body">
            <div class="row droptrue" id="sortable1">
                @foreach($procesos as $proceso)
                    <div id="{{$proceso->id_proceso}}" class="col-md-3">
                        <div  class="alert alert-danger" >{{$proceso->des_proceso}}</div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                @foreach($auditorias as $data_auditoria)
                    <div class="col-md-4">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <a href="#" class="btn_delete_plan" data-id="{{$data_auditoria->id_auditoria}}"><span class="pull-right glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar Plan de Auditoria"></span></a>
                                <a href="{{url('sgc/ver_plan_auditoria/')}}/{{$data_auditoria->id_auditoria}}">{{date('Y',strtotime($data_auditoria->fecha_i)).'-'.$loop->iteration}}</a>
                                {{--<p>{{$data_auditoria->fecha_i}}  al  {{$data_auditoria->fecha_f}}</p>--}}
                            </div>
                            <div id="sortable2" class="panel-body elementos row droptrue" data-agenda="{{$data_auditoria->id_auditoria}}" ondrop="drop(event)" ondragover="allowDrop(event)">

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <input type="button" id="ver_elementos" class="btn btn-primary" value="Ver"/>
        </div>
    @endforeach

    <br style="clear:both">

    <script>
        $( function() {
            $( "div.droptrue" ).sortable({
                connectWith: "div",
                cursor: 'grabbing'
            });

            $("#ver_elementos").click(function () {
                $arreglo=[];
                $(".elementos").each(function () {
                    var agenda=$(this).data('agenda');
                    $(this).children().each(function () {
                        $arreglo.push({
                            'agenda': agenda,
                            'proceso': $(this).attr('id')
                        });
                    })
                });
            });

            $( "#sortable1, #sortable2, #sortable3" ).disableSelection();
        } );
    </script>
@endsection
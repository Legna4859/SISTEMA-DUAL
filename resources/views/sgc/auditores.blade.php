@extends('layouts.app')
@section('title', 'Auditores')
@section('content')
    @if(Session::get('errors'))
        <div class="alert alert-danger" role="alert">
            @foreach(Session::get('errors')->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </div>
        @if(Session::forget('errors'))@endif
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
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <a href="#" class="add_auditor_lider pull-right" data-type="1"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar persona"></span></a>
                    <h3 class="panel-title text-center">Auditores Líderes</h3>
                </div>
                @if(sizeof($auditores_l)>0)
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <th>Nombre</th>
                        <th>Acciones</th>
                       </thead>
                        <tbody>
                            @foreach($auditores_l as $auditor)
                                @if($auditor->id_categoria==1)
                                <tr>
                                    <td>{{$auditor->getAbr->abreviaciones->titulo.' '.$auditor->getName->nombre}}</td>
                                    <td class="text-center"><a href="#" class="btn_delete_auditor" data-id="{{$auditor->id_personas_auditoria}}"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar"></span></a></td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <a href="#" class="add_auditor pull-right" data-type="2"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar persona"></span></a>
                    <h3 class="panel-title text-center">Auditores</h3>
                </div>
                @if(sizeof($auditores)>0)
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <th>Nombre</th>
                        <th>Acciones</th>
                        </thead>
                        <tbody>
                        @foreach($auditores as $auditor)
                            @if($auditor->id_categoria==2)
                                <tr>
                                    <td>{{$auditor->getAbr->abreviaciones->titulo.' '.$auditor->getName->nombre}}</td>
                                    <td class="text-center"><a href="#" class="btn_delete_auditor" data-id="{{$auditor->id_personas_auditoria}}"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar"></span></a></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <a href="#" class="add_auditor_entrenamiento pull-right" data-type="3"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar persona"></span></a>
                    <h3 class="panel-title text-center">Auditores en entrenamiento</h3>
                </div>
                @if(sizeof($auditores_e)>0)
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <th>Nombre</th>
                        <th>Acciones</th>
                        </thead>
                        <tbody>
                        @foreach($auditores_e as $auditor)
                            @if($auditor->id_categoria==3)
                                <tr>
                                    <td>{{$auditor->getAbr->abreviaciones->titulo.' '.$auditor->getName->nombre}}</td>
                                    <td class="text-center"><a href="#" class="btn_delete_auditor" data-id="{{$auditor->id_personas_auditoria}}"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar"></span></a></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </main>

    <form  method="POST" role="form" id="form_delete_auditor">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>

    <div class="modal fade" id="modal_add_auditores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Registro de auditores</h4>
                </div>
                <form id="form_add_auditores" class="form" role="form" method="POST" action="{{url('/sgc/auditores')}}">
                    @csrf
                    <div class="modal-body">
                        <input type="text" id="id_categoria" name="id_categoria" hidden>
                        <div class="form-group">
                            <label for="nuevo_auditor">Nuevo Auditor</label>
                            <select name="nuevo_auditor" class="form-control">
                                <option value="" selected disabled="true">Selecciona...</option>
                                @foreach($personas as $persona)
                                    @foreach($persona->abreviaciones_prof as $persona_abr)
                                        <option value="{{$persona->id_personal}}">{{$persona_abr->getAbreviatura[0]->titulo.' '.$persona->nombre}}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
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
            $(".add_auditor_lider, .add_auditor, .add_auditor_entrenamiento").click(function () {
                $("#id_categoria").attr('value',$(this).data('type'));
                $("#modal_add_auditores").modal('show');
            });

            $(".btn_delete_auditor").click(function(){
                var id=$(this).data('id');
                swal({
                    title: "Seguro que desea eliminar?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $("#form_delete_auditor").attr("action","/sgc/auditores/"+id)
                            $("#form_delete_auditor").submit();
                        }
                    });
            });

            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>

@endsection
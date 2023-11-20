@extends('layouts.app')
@section('title', 'Editar Auditores del Plan')
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
                    <a href="{{url('/auditorias/planes')}}/{{$auditoria}}">Detalles del plan</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Editar auditores del plan</span>
            </p>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <a href="#" class="add_auditor pull-right" data-type="2"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar persona"></span></a>
                    @foreach($auditorias as $auditoria_n)
                        @if($auditoria_n->id_auditoria==$auditoria)
                            <h3 class="panel-title text-center">Auditores del plan {{\Carbon\Carbon::parse($auditoria_n->fecha_i)->format('Y')}}-{{$loop->iteration}}</h3>
                        @endif
                    @endforeach
                </div>
                @if(sizeof($auditores)>0)
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <th>Nombre</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                                <td class="text-center">
                                    <div class="row">
                                        <div class="col-md-3">Auditor Líder</div>
                                        <div class="col-md-3">Auditor</div>
                                        <div class="col-md-3">Auditor en Entrenamiento</div>
                                        <div class="col-md-3">Ninguno</div>
                                    </div>
                                </td>
                            </tr>

                            @foreach($auditores as $auditors)
                                @foreach($auditors->getAbr->abreviaciones as $auditor)
                                        <tr>
                                            <td>{{$auditor->titulo.' '.$auditors->getName->nombre}}</td>
                                            <td class="text-center">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <input type="radio" name="rol{{$auditors->id_auditor_auditoria}}" data-id="{{$auditors->id_auditor_auditoria}}" data-value="1" class="form-actions roles" {{$auditors->id_categoria==1?'checked':''}}>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="radio" name="rol{{$auditors->id_auditor_auditoria}}" data-id="{{$auditors->id_auditor_auditoria}}" data-value="2" class="form-actions roles" {{$auditors->id_categoria==2?'checked':''}}>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="radio" name="rol{{$auditors->id_auditor_auditoria}}" data-id="{{$auditors->id_auditor_auditoria}}" data-value="3" class="form-actions roles" {{$auditors->id_categoria==3?'checked':''}}>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="radio" name="rol{{$auditors->id_auditor_auditoria}}" data-id="{{$auditors->id_auditor_auditoria}}" data-value="4" class="form-actions roles" {{$auditors->id_categoria==4?'checked':''}}>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="#!" class="btn_delete_auditor" data-id="{{$auditors->id_auditor_auditoria}}"><span class="glyphicon glyphicon-trash"></span></a>
                                            </td>
                                        </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                        <button class="btn btn-success guardar_roles">Guardar</button>
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
                <form id="form_add_auditores" class="form" role="form" method="POST" action="{{url('/auditorias/auditores_asignados')}}">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="id_auditoria" value="{{$auditoria}}" hidden>
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
                        <div class="form-group">
                            <label for="nuevo_auditor">Rol</label>
                            <select name="id_categoria" class="form-control">
                                <option value="" selected disabled="true">Selecciona...</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{$categoria->id_categoria}}">{{$categoria->descripcion}}</option>
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
            $('.guardar_roles').click(function () {
                var data=[];
                $('input:radio:checked').each(function () {
                    data.push({"id_personas_auditoria":$(this).data('id'),"id_categoria":$(this).data('value')});
                });
                $.ajax({
                    url: '{{url("auditorias/auditores_asignados")}}/'+JSON.stringify(data),
                    method: 'GET',
                    data: {},
                    success: function () {
                        Swal.fire({
                            title: 'Guardado',
                            timer: 1000,
                            showConfirmButton: false,
                            type: 'success'
                        });
                        setTimeout(function () {
                            location.reload();
                        },500);
                    }
                })
            });

            $(".add_auditor").click(function () {
                $("#modal_add_auditores").modal('show');
            });

            $(".btn_delete_auditor").click(function(){
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
                    $("#form_delete_auditor").attr("action","/auditorias/auditores_asignados/"+id)
                    $("#form_delete_auditor").submit();
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
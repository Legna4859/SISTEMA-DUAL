@extends('layouts.app')
    @section('title', 'Hoja de trabajo')
@section('content')
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <p>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                    <a href="{{url('/sgc/auditorias')}}">Planes de auditorias</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <a href="{{url('sgc/ver_plan_auditoria')}}/{{$auditoria->id_auditoria}}">Detalles del Plan</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <a href="{{url('/sgc/agenda')}}/{{$auditoria->id_auditoria}}">Agenda</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span>Hoja de Trabajo</span>
                </p>

                @if(Session::get('errors'))
                    <div class="alert alert-danger" role="alert">
                    @foreach(Session::get('errors')->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                    </div>
                @endif
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Hoja de trabajo</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{url('sgc/hoja_trabajo')}}" method="POST">
                            @csrf
                            <div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <strong>Área:</strong>
                                        @foreach($agenda as $datosA)
                                            {{$datosA->area[0]->nom_departamento}}
                                            <input type="text" name="id_agenda" hidden value="{{$datosA->id_agenda}}">
                                        @endforeach
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Auditoria No.</strong>
                                        {{date('Y',strtotime($auditoria->getAuditoria->fecha_i)).'-'.$auditoria->getAuditoria->id_auditoria}}
                                    </div>
                                    <div class="col-md-8">
                                        <strong>Auditado:</strong>
                                        @foreach($agenda as $datosA)
                                            {{$datosA->area[0]->nom_departamento}}
                                        @endforeach

                                    </div>
                                    <div class="col-md-4">
                                        <strong>Fecha:</strong>
                                        @foreach($agenda as $datosA)
                                            {{$datosA->fecha}}
                                            <input type="text" name="fecha" hidden value="{{$datosA->fecha}}">
                                        @endforeach
                                    </div>
                                </div>
                                @if(!Session::get('id_reporte'))
                                    <input type="submit" class="btn btn-primary pull-right" value="Guardar"/>
                                @endif
                            </div>
                        </form>
                        @if(Session::get('id_reporte'))
                            <hr>
                            @if(isset($array_procesos))
                                <div>
                                    <div class="alert alert-danger" role="alert">
                                        <strong>No se encontro registro de los siguientes procesos: </strong>
                                        @foreach($array_procesos as $proceso)
                                            <p>{{$proceso}}</p>
                                        @endforeach

                                    </div>
                                </div>
                            @else
                                @if(!$notas->isEmpty())
                                    @foreach($agenda as $datosA)
                                        <button class="pull-right btn btn-primary impPage" data-id="{{$datosA->id_agenda}}">Imprimir</button>
                                    @endforeach
                                @endif
                                <br><br>
                            @endif
                            <a href="#" class="pull-right btn_add_nota"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar nota"></span></a>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-md-9 text-center">Notas</th>
                                        <th class="col-md-2"></th>
                                        <th class="col-md-1">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($notas as $nota)
                                    <tr>
                                        <td>{{$nota->proceso}} {{$nota->descripcion}}</td>
                                        <td>{{$nota->getClasificacion->descripcion}}</td>
                                        <td class="text-center"><a href="#"><span class="glyphicon glyphicon-trash"></span></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <form  method="POST" role="form" id="form_delete_norma">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>

    <div class="modal fade" id="modal_add_nota" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form_add_nota" class="form" role="form" method="POST" action="{{url('sgc/notas')}}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar nota a la hoja de trabajo</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="proceso">Proceso auditado</label>
                            <input class="form-control" type="text" name="proceso">
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="procesos">Clasificacion</label>
                            <select class="form-control" name="clasificacion">
                                <option value="" selected disabled>Selecciona...</option>
                                <option value="1">NC</option>
                                <option value="2">AM</option>
                            </select>
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

    <script>
        $(document).ready(function () {

            $(".btn_delete_nota").click(function(){
                var id=$(this).data('id');
                swal({
                    title: "Seguro que desea eliminar?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $("#form_delete_norma").attr("action","/sgc/notas/"+id)
                            $("#form_delete_norma").submit();
                        }
                    });
            });

            $('.btn_add_nota').click(function () {
                $('#modal_add_nota').modal('show');
            });

            $(".impPage").click(function () {
                window.open('{{url('sgc/print_page_job')}}/'+$(this).data('id'),'_blank',"fullscreen=yes");
            });

            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
@endsection

















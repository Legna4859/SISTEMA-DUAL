@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <div class="card-deck mt-3">
        <div class="card col-sm-2 border-0" style="background: #f8fafc"></div>
        <div class="card col-sm-8">
            <div class="card-body">
                <form action="{{route('dep_desarrollo.update',$plan->id_planeacion)}}" method="post">
                    @csrf
                    @method('PUT')
                    @if($plan->comentarios == NULL)
                    @else
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Correciones anteriores</label>
                                <textarea class="form-control" rows="3" disabled>{{$plan->comentarios}}</textarea>
                            </div>
                        </div>
                    @endif
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Fecha Inicio</label>
                            <input type="date" class="form-control" value="{{$plan->fecha_inicio}}" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Fecha Limite</label>
                            <input type="date" class="form-control" value="{{$plan->fecha_fin}}" disabled>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Objetivo</label>
                            <textarea class="form-control" rows="3" disabled>{{$plan->objetivo}}</textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Descripción de la Actividad</label>
                            <textarea class="form-control" rows="3" disabled>{{$plan->desc_actividad}}</textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Instrucciones</label>
                            <textarea class="form-control" rows="3" disabled>{{$plan->instrucciones}}</textarea>
                        </div>
                        <input type="number" class="form-control" name="id_estado" value="1" hidden>
                        <div class="form-group col-md-6">
                            <div align="center"><button type="submit" class="btn" style="background: #e0e0e0">Aprobar</button></div>
                        </div>
                        <div class="form-group col-md-6">
                            <div align="center">
                                <a data-toggle="modal" data-target="#coment" class="btn" style="background: #e0e0e0;color: black">Reenviar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="coment" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Correcciones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('dep_desarrollo.update',$plan->id_planeacion)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                            <div class="form-group col-md-12">
                                <textarea class="form-control" rows="8" name="comentarios"></textarea>
                                <input type="number" class="form-control" name="id_estado" value="0" hidden>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <div align="center"><button type="submit" class="btn" style="background: #e0e0e0">Enviar</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

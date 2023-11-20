@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <div class="card-deck mt-3">
            <div class="card col-sm-2 border-0" style="background: #f8fafc"></div>
            <div class="card col-sm-8">
                <div class="card-body">
                    <form action="{{route('coordina_inst.update',$plan->id_planeacion)}}" method="post">
                        @csrf
                        @method('PUT')
                            @if($plan->comentarios == NULL)
                            @else
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Correciones</label>
                                        <textarea class="form-control" rows="3" disabled>{{$plan->comentarios}}</textarea>
                                    </div>
                                </div>
                            @endif
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Fecha Inicio</label>
                                <input type="date" class="form-control" name="fecha_inicio" value="{{$plan->fecha_inicio}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Fecha Límite</label>
                                <input type="date" class="form-control" name="fecha_fin" value="{{$plan->fecha_fin}}">
                            </div>
                            <div class="form-group col-md-12">
                                <label>Objetivo</label>
                                <textarea class="form-control" rows="3" name="objetivo">{{$plan->objetivo}}</textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Descripción de la Actividad</label>
                                <textarea class="form-control" rows="3"  name="desc_actividad">{{$plan->desc_actividad}}</textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Instrucciones</label>
                                <textarea class="form-control" rows="3" name="instrucciones">{{$plan->instrucciones}}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <div align="center">
                                    <a href="{{ URL::previous() }}" class="btn" style="background: #e0e0e0;color: black">Regresar</a>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div align="center"><button type="submit" class="btn" style="background: #e0e0e0">Actualizar</button></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div>
@endsection

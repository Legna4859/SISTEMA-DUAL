@extends('layouts.app')
@section('title', 'Carreras')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">PROGRAMAS DE ESTUDIO</h3>
                </div>
            <div class="panel-body">
                @if($carreras!=null)
                    <div class="row col-md-12">
                        <div>
                            <ul class="nav nav-pills nav-stacked col-md-4" style="border: 2px solid black; border-radius: 7px; padding-right: 0">
                                @foreach($carreras as $carrera)
                                    <li  style="margin-top: 0px"><a  style="border-bottom: 2px solid black;" data-toggle="pill" data-toggle="pill" href="#{{ $carrera ["id_carrera"] }}">{{ $carrera ["nombre_carrera"] }}</a></li>
                                @endforeach
                            </ul>
                            <div class="tab-content col-md-8">
                                <div class="tab-pane fade in active text-center">
                                    <div class="col-md-4 col-md-offset-3">
                                        <label class=" alert alert-success"  data-toggle="tab" >Seleccione una carrera para consultar sus materias disponibles
                                        </label>
                                    </div>
                                </div>
                                @foreach($carreras as $carrera)
                                    <div id="{{$carrera ["id_carrera"] }}" class="tab-pane">
                                        <table class="table text-center my-0 border-table">
                                            <thead>
                                            <tr class="text-center">
                                                <th class="text-center">NP.</th>
                                                <th class="text-center">Materias</th>
                                                <th class="text-center">Semestre</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($carrera['materias']   as $materia)
                                                <tr>
                                                    <td>{{$materia['contador'] }}</td>
                                                    <td><label for="" class="rounded px-3 border border-success bg-light text-success"><strong>{{$materia["nombre_materia"]}}</strong></label></td>
                                                    <td>{{$materia['nombre_semestre']}}</td>
                                                    <td>
                                                        <span data-toggle="modal" data-target="#modal_grupos_{{$materia['id_materia']}}" data-id=""><a href="#!" class="btn btn-primary tooltip-options link" data-toggle="tooltip" data-placement="top" title="ver"><span class="oi oi-eye"></span></a></span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row col-md-12">
                        <div class="col-md-6 col-md-offset-3">
                            <label class=" alert alert-danger text-center"  data-toggle="tab" ><h3>No tiene materias asignadas para el periodo seleccionado
                            </h3></label>
                        </div>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
    <div>
        @foreach($carreras as $carrera)
            @foreach($carrera['materias']   as $materia)
                <div class="modal fade" id="modal_grupos_{{$materia['id_materia']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">{{$materia['nombre_materia']}}</h4>
                            </div>
                                <div class="modal-body">
                                    <table class="table text-center my-0 border-table">
                                        <thead>
                                        <tr class="text-center">
                                            <th class="text-center">Grupo</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($materia['grupos'] as $grupo)
                                                <tr>
                                                    <td>{{$grupo['grupos']}}</td>
                                                    <td>
                                                        <a href="/docente/acciones/periodo/{{$id_docente}}/{{$materia['id_materia']}}/{{$grupo['id_grupo']}}" class="btn btn-primary tooltip-options link" data-toggle="tooltip" data-placement="top" title="Periodos"><span class="oi oi-calendar"></span></a>
                                                        <a href="/docente/acciones/calificacion/{{$id_docente}}/{{$materia['id_materia']}}/{{$grupo['id_grupo']}}" class="btn btn-primary tooltip-options link" data-toggle="tooltip" data-placement="top" title="Evaluaciones"><span class="oi oi-pencil"></span></a>
                                                        @if($periodo_sumativas)
                                                            <a href="/docente/{{$id_docente}}/{{$materia['id_materia']}}/{{$materia ['id_semestre']}}/{{$grupo['id_grupo']}}/{{$carrera['nombre_carrera']}}/sumativas" class="btn btn-warning tooltip-options link" data-toggle="tooltip" data-placement="top" title="Evaluación sumativa de complementación"><span class="oi oi-pencil"></span></a>
                                                        @else
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
@endsection
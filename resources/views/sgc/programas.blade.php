<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 06/07/2019
 * Time: 03:05 PM
 */
use Jenssegers\Date\Date;
?>
@extends('layouts.app')
@section('title', 'Programa de Auditorias')
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
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Programas de auditorías</h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="col-md-4">Periodo</th>
                                <th class="col-md-6">Lugar</th>
                                <th class="col-md-2 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($programas as $programa)
                            <tr>
                                <td>
                                    <a href="{{url('sgc/programa/')}}/{{$programa->id_programa}}">{{Date::parse($programa->fecha_i)->format('F')}} - {{Date::parse($programa->fecha_f)->format('F Y')}}</a>
                                </td>
                                <td>
                                    {{$programa->lugar}}
                                </td>
                                <td class="text-center">
                                    <a href="{{url('sgc/reporte_programa')}}/{{$programa->id_programa}}/edit" class="pull-leftbtn_informe_programa"><span class="glyphicon glyphicon-edit" data-toggle="tooltip" title="Ver Reporte del Programa de Auditoría"></span></a>
                                    <a href="#" class="btn_delete_programa" data-id="{{$programa->id_programa}}"><span class="pull-right glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar Programa de Auditoría"></span></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <div>
        <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nueva auditoria" data-target="#modal_crea_aud" type="button" class="btn btn-success btn-lg flotante">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
    </div>

    <form  method="POST" role="form" id="form_delete_programa">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>

    <form id="form_add_programa" class="form" role="form" method="POST" action="{{url("/sgc/programa")}}">
        <div class="modal fade" id="modal_crea_aud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Registro de programa de auditorías</h4>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Periodo</label>
                                    <div class="input-group input-daterange">
                                        <input type="text" class="form-control periodo" placeholder="Fecha de inicio" name="inicio">
                                        <div class="input-group-addon">a</div>
                                        <input type="text" class="form-control periodo" placeholder="Fecha de termino" name="fin">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="objetivo">Lugar</label>
                                    <input type="text" class="form-control"name="lugar" placeholder="Lugar de las auditorías" value="Tecnológico de Estudios Superiores de Valle de Bravo">
                                    </input>
                                </div>
                                <div class="form-group">
                                    <label for="alcance">Alcance</label>
                                    <textarea class="form-control"name="alcance" placeholder="Alcance del programa de auditorías">Serán auditados también aquellos cambios que afecten al Tecnológico y los resultados de auditorías anteriores.</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="metodos">Metodos</label>
                                    <textarea class="form-control"name="metodos" placeholder="Metodos a usar">Para el presente programa de auditoría serán utilizados los métodos de:
        1.	Entrevista;
        2.	Muestreo; y
        3.	Revisión documental.</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="alcance">Responsabilidades</label>
                                    <textarea class="form-control"name="responsabilidades" placeholder="Responsabilidades del programa de auditorías">El Director General, el Coordinador del SGC, Auditor Líder y áreas del Tecnológico, intervienen en el proceso de auditorías. Las responsabilidades de cada uno de ellos, respecto del programa de auditoría se encuentran descritas en el Anexo 3, Matriz de responsabilidad y autoridad.</textarea>
                                </div>
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

    <script>
        $(document).ready(function () {
            $('.input-daterange').datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                language: 'es'
            });
            $('#p_inicio').datepicker({
                startDate: 0
            });

            $(".btn_delete_programa").click(function(){
                var id=$(this).data('id');
                swal({
                    title: "Seguro que desea eliminar?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $("#form_delete_programa").attr("action","/sgc/programa/"+id)
                            $("#form_delete_programa").submit();
                        }
                    });
            });

        });
    </script>

@endsection

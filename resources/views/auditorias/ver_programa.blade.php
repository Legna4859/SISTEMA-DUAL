<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 09/07/2019
 * Time: 08:16 PM
 */
?>
@extends('layouts.app')
@section('title','Detalles del programa')
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
                <span>Detalles del programa</span>
            </p>
            <div class="panel panel-info">
                    @foreach($programas as $programa)
                    <div class="panel-heading">
                        @if($programa->requisitos && $programa->recursos && $programa->criterios)
                            <a href="{{url('auditorias/programas')}}/{{$programa->id_programa}}/edit" ><span class="pull-right glyphicon glyphicon-th" data-toggle="tooltip" title="Agendar procesos"></span></a>
                        @endif
                        <h3 class="panel-title text-center">Programa de auditorías
                            <strong>
                                {{\Jenssegers\Date\Date::parse($programa->fecha_i)->format('F')}} - {{\Jenssegers\Date\Date::parse($programa->fecha_f)->format('F Y')}}
                            </strong>
                        </h3>
                    </div>
                    <div class="panel-body">
                        @if($esLider)
                        <a href="#" class="pull-right btn_edit_programa" data-all="{{$programa}}" data-toggle="tooltip" title="Editar Programa"><span class="glyphicon glyphicon-cog"></span></a>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <label>Lugar: </label>
                                <p>{{$programa->lugar}}</p>
                            </div>
                            <div class="col-md-6">
                                <label>Alcance: </label>
                                <p>{{$programa->alcance}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Objetivos</label>
{{--                                <p>{{$programa->objetivo}}</p>--}}
                                @if($numeros=array("1.","2.","3.","4.","5.","6.","7.","8.","9.","10."))
                                    <p>
                                        <?php echo $programa->objetivo=str_replace_array('--',$numeros,str_replace($numeros,'<br>--',$programa->objetivo,$count)); ?>
                                    </p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label>Métodos</label>
{{--                                <p>{{$programa->metodos}}</p>--}}
                                @if($numeros=array("1.","2.","3.","4.","5.","6.","7.","8.","9.","10."))
                                    <p>
                                        <?php echo $programa->metodos=str_replace_array('--',$numeros,str_replace($numeros,'<br>--',$programa->metodos,$count)); ?>
                                    </p>
                                @endif

                                {{--                            <a href="#" class="btn_add_metodo"><span class="glyphicon glyphicon-plus"></span></a>--}}
                                {{--                            <p>Para el presente programa de auditoría serán utilizados los métodos de:</p>--}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Responsabilidades:</label>
                                <p>{{$programa->responsabilidades}}</p>
                            </div>
                        </div>
                        <hr>
                        @if($esLider)
                            <a href="#" class="pull-right btn_edit_programacion" data-all="{{$programa}}" data-toggle="tooltip" title="Editar planeación del programa"><span class="glyphicon glyphicon-cog"></span></a>
                        @endif
                        <label>Planeación: </label>
                        @if($programa->requisitos && $programa->recursos && $programa->criterios)
                            <table class="table table-bordered">
                                <tr>
                                    <td class="col col-md-3">
                                        <p class="text-center"><label>Recursos:</label></p>
                                        @if($numeros=array("2.","3.","4.","5.","6.","7.","8.","9.","10."))
                                            <?php echo $programa->recursos=str_replace_array('--',$numeros,str_replace($numeros,'<br>--',$programa->recursos,$count)); ?>
                                        @endif
                                        {{--                                    {{$programa->recursos}}--}}
                                    </td>
                                    <td class="col col-md-3">
                                        <p class="text-center"><label>Requisitos:</label></p>
                                        {{$programa->requisitos}}
                                    </td>
                                    <td class="col col-md-3">
                                        <p class="text-center"><label>Criterios de aceptacioón:</label></p>
                                        {{$programa->criterios}}
                                    </td>
                                </tr>
                            </table>
                        @else
                            <div class="alert alert-danger" role="alert">No se han definido los datos</div>
                        @endif


                    </div>
                @endforeach
            </div>
        </div>
    </main>


    <div class="modal fade" id="modal_edit_program" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form_edit_programa" class="form" role="form" method="POST" action="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Editar programa de auditorías</h4>
                </div>

                <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Periodo</label>
                                    <div class="input-group input-daterange">
                                        <input type="text" class="form-control periodo" name="inicio">
                                        <div class="input-group-addon">a</div>
                                        <input type="text" class="form-control periodo" name="fin">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lugar">Lugar</label>
                                    <input type="text" class="form-control"name="lugar" value="" />
                                </div>
                                <div class="form-group">
                                    <label for="alcance">Alcance</label>
                                    <textarea class="form-control"name="alcance"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="objetivo">Objetivo</label>
                                    <textarea class="form-control"name="objetivo"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="metodos">Metodos</label>
                                    <textarea class="form-control"name="metodos"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="responsabilidades">Responsabilidades</label>
                                    <textarea class="form-control"name="responsabilidades"></textarea>
                                </div>
                            </div>
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


    <div class="modal fade" id="modal_edit_programacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form_edit_programacion" class="form" role="form" method="POST" action="">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Editar planeación</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="recursos">Recursos:</label>
                                        @if($programa->recursos)
                                        <textarea name="recursos" class="form-control" id="" cols="30" rows="3">{{str_replace('<br>','',$programa->recursos)}}</textarea>
                                        @else
                                        <textarea name="recursos" class="form-control" id="" cols="30" rows="3">1. Equipo de cómputo;
2. Equipo auditor;
3. Papelería.</textarea>
                                        @endif
                                </div>
                                <div class="form-group">
                                    <label for="requisitos">Requisitos:</label>
                                    <textarea name="requisitos" class="form-control" id="" cols="30" rows="3">{{$programa->requisitos!=''?$programa->requisitos:'1. Presentar al auditor la información requerida en la auditoría;'}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="criterios">Criterios de aceptación:</label>
                                    <textarea class="form-control" name="criterios" cols="30" rows="3">{{$programa->criterios!=''?$programa->criterios:'1. Se determinará cumplimiento cuando la información presentada sea conforme con los criterios de la auditoría.'}}</textarea>
                                </div>
                            </div>
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

            $('.btn_add_obj').click(function () {
                $('#modal_add_obj').modal('show');
            });
            $('.btn_add_metodo').click(function () {
                $('#modal_add_metodo').modal('show');
            });

            $('.btn_edit_programa').click(function () {
                var datos=$(this).data('all');
                $('#form_edit_programa').attr('action','{{url('auditorias/programas')}}/'+datos['id_programa'])
                $('[name=inicio]').val(datos['fecha_i']);
                $('[name=fin]').val(datos['fecha_f']);
                $('[name=lugar]').val(datos['lugar']);
                $('[name=alcance]').val(datos['alcance']);
                $('[name=objetivo]').val(datos['objetivo']);
                $('[name=metodos]').val(datos['metodos']);
                $('[name=responsabilidades]').val(datos['responsabilidades']);
                $('#modal_edit_program').modal('show');
            });

            $(".btn_edit_programacion").click(function () {
                var datos=$(this).data('all');
                $('#form_edit_programacion').attr('action','{{url('auditorias/programas')}}/'+datos['id_programa'])
                $("#modal_edit_programacion").modal('show');
            });


            $('.input-daterange').datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                language: 'es'
            });


            $('[data-toggle="tooltip"]').tooltip();

        });
    </script>

@endsection

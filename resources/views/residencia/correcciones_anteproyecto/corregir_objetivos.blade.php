@extends('layouts.app')
@section('title', 'Registrar Anteproyecto')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Corregir Objetivos</h3>
                </div>
                <div class="panel-body">
                    <div class="row">

                        <div class="col-md-2 col-md-offset-3 " style="text-align: center;">
                            <a   href="{{url('/residencia/correcciones_anteproyecto/')}}"><span class="glyphicon glyphicon-arrow-left" style="font-size:45px;color:#458acc"></span><br>Atras</a>
                        </div>
                        <div class="col-md-2 col-md-offset-2 " style="text-align: center;">
                            <a   href="{{url('/residencia/anteproyecto/corregir_alcances')}}"><span class="glyphicon glyphicon-arrow-right" style="font-size:45px;color:#458acc"></span><br>Siguiente</a>
                        </div>
                        <br>
                        <br>
                    </div>
                    <div class="row col-md-12">
                        <div>
                            <div class="col-md-7 col-md-offset-1">

                                <div  class="tab-pane">
                                    <div class="panel panel-primary">

                                            <div class="panel-body">
                                                <form class="form" role="form" action="{{url("/residencia/guardar_correciones_objetivos/")}}" method="POST" id="form_objetivos" >
                                                    {{ csrf_field() }}
                                                <input type="hidden" id="anteproyecto" name="anteproyecto" value="{{$objetivos->id_anteproyecto}}">

                                                <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="objetivo_general">OBJETIVO GENERAL</label>
                                                                <textarea class="form-control"  id="objetivo_general" name="objetivo_general" rows="10" placeholder="Ingresa el Objetivo General " style="" required>{{ $objetivos->obj_general }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="objetivo_especifico">OBJETIVOS ESPECIFICOS</label>
                                                                <textarea class="form-control"  id="objetivo_especifico" name="objetivo_especifico" rows="10" placeholder="Ingresa los Objetivos Especificos " style="" required>{{ $objetivos->obj_especifico }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                        </form>
                                                    @if($objetivos->estado_aceptado_objetivos==1 )
                                                    <div class="row">
                                                        <div class="col-md-4 col-md-offset-4">
                                                            <button id="guardar_objetivos" class="btn btn-primary" disabled>Guardar</button>

                                                        </div>
                                                    </div>
                                                        @else
                                                    <div class="row">
                                                        <div class="col-md-4 col-md-offset-4">
                                                            <button id="guardar_objetivos" class="btn btn-primary" >Guardar</button>

                                                        </div>
                                                    </div>
                                                        @endif

                                            </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="text-align: center">COMENTARIOS

                                    </div>

                                </div>
                            </div>
                            @if($objetivos->estado_aceptado_objetivos == 1)
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="alert alert-danger" role="alert" style="text-align: center;">
                                            Ya te autorizarón los objetivos
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="alert alert-danger" role="alert" style="text-align: center;">
                                            Corrige lo que  se te pide en los comentarios de los revisores
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                @foreach($comentarios_objetivos as $comentarios_objetivos )
                                    @if($comentarios_objetivos->id_estado_evaluacion==1)
                                    <div class="panel  panel-success">
                                        <div class="panel-heading" style="text-align: center"> <b>NOMBRE DEL DOCENTE:</b> {{$comentarios_objetivos->nombre}}<br>
                                                <b>STATUS DEL ANTEPROYECTO: </b>AUTORIZADO
                                        </div>
                                        <div class="panel-body">
                                            {{$comentarios_objetivos->comentario}}

                                        </div>
                                    </div>
                                    @elseif($comentarios_objetivos->id_estado_evaluacion==2)
                                        <div class="panel  panel-warning">
                                            <div class="panel-heading" style="text-align: center"> <b>NOMBRE DEL DOCENTE:</b> {{$comentarios_objetivos->nombre}}<br>
                                                    <b>STATUS DEL ANTEPROYECTO: </b>ACEPTADO CON CAMBIOS
                                            </div>
                                            <div class="panel-body">
                                                {{$comentarios_objetivos->comentario}}

                                            </div>
                                        </div>
                                        @elseif($comentarios_objetivos->id_estado_evaluacion==3)
                                            <div class="panel  panel-warning">
                                                <div class="panel-heading" style="text-align: center"> <b>NOMBRE DEL DOCENTE:</b> {{$comentarios_objetivos->nombre}}<br>
                                                        <b>STATUS DEL ANTEPROYECTO: </b>RECHAZADO
                                                </div>
                                                <div class="panel-body">
                                                    {{$comentarios_objetivos->comentario}}

                                                </div>
                                            </div>
                                    @endif
                                @endforeach
                            </div>
                    </div>


                    </div>
                </div>
            </div>
        </div></div></div></div>
    </div>
    <!-- enviar anteproyecto -->
    <div id="modal_enviar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="{{url("/residencia/enviar_anteproyecto_corregido/")}}" method="POST" role="form" >
                    <div class="modal-body">

                        {{ csrf_field() }}
                        ¿Realmente deseas deseas enviar tu anteproyecto?
                        <input type="hidden" id="id_anteproyecto" name="id_anteproyecto" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input id="confirma_elimina_oficio" type="submit" class="btn btn-danger" value="Aceptar"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script  type="text/javascript">
        $(document).ready( function() {
            $("#guardar_objetivos").click(function(event){
                var objetivo_general = $("#objetivo_general").val();
                var objetivo_especifico = $("#objetivo_especifico").val();
                if (objetivo_general != "" && objetivo_especifico != "" ) {
                    $("#guardar_objetivos").attr("disabled", true);
                    $("#form_objetivos").submit();
                    swal({
                        position: "top",
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
                else{
                    swal({
                        position: "top",
                        type: "warning",
                        title: "El campo se encuentra  vacío.",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });

            $(".enviar").click(function(event){
                var id=$(this).attr('id');
                $('#id_anteproyecto').val(id);
                $('#modal_enviar').modal('show');
            });
        });
    </script>
@endsection
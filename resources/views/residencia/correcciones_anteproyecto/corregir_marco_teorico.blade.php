@extends('layouts.app')
@section('title', 'Registrar Anteproyecto')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Corregir  Marco Teorico</h3>
                </div>
                <div class="panel-body">
                    <div class="row">

                        <div class="col-md-2 col-md-offset-3 " style="text-align: center;">
                            <a   href="{{url('/residencia/anteproyecto/corregir_justificacion')}}"><span class="glyphicon glyphicon-arrow-left" style="font-size:45px;color:#458acc"></span><br>Atras</a>
                        </div>
                        <div class="col-md-2 col-md-offset-2 " style="text-align: center;">
                            <a   href="{{url('/residencia/anteproyecto/corregir_cronograma')}}"><span class="glyphicon glyphicon-arrow-right" style="font-size:45px;color:#458acc"></span><br>Siguiente</a>
                        </div>
                        <br>
                        <br>
                    </div>
                    <div class="row col-md-12">
                        <div>
                            <div class="col-md-7 col-md-offset-1">

                                <div  class="tab-pane">
                                    <div class="panel panel-primary">
                                        <form class="form" id="form_marco_teorico" role="form" method="POST" action="{{url("/residencia/guardar_correciones_marco_teorico/")}}" >
                                            {{ csrf_field() }}
                                            <div class="panel-body">
                                                <input type="hidden" id="id_anteproyecto" name="id_anteproyecto" value="{{ $marco_teorico->id_anteproyecto }}">

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <textarea class="form-control"  id="marco_teorico" name="marco_teorico" rows="25" placeholder="Ingresar marco teorico de tu anteproyecto " style="" required>{{$marco_teorico->marco_teorico }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @if($marco_teorico->estado_aceptado_marco == 1)
                                                    <div class="row">

                                                        <div class="col-md-4 col-md-offset-4">
                                                            <button id="guardar_marco_teorico" class="btn btn-primary" disabled >Guardar</button>

                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="row">

                                                        <div class="col-md-4 col-md-offset-4">
                                                            <button id="guardar_marco_teorico" class="btn btn-primary">Guardar</button>

                                                        </div>
                                                    </div>
                                                @endif


                                            </div>
                                        </form>
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
                                @if($marco_teorico->estado_aceptado_marco == 1)
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <div class="alert alert-danger" role="alert" style="text-align: center;">
                                                Ya te autorizarón Marco Teorico
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
                                    @foreach( $comentarios_marco_teorico as  $comentarios_marco_teorico )
                                        @if( $comentarios_marco_teorico->id_estado_evaluacion==1)
                                        <div class="panel  panel-success">
                                            <div class="panel-heading" style="text-align: center"> <b>NOMBRE DEL DOCENTE:</b> {{ $comentarios_marco_teorico->nombre}}<br>
                                                    <b>STATUS DEL ANTEPROYECTO: </b>AUTORIZADO
                                            </div>
                                            <div class="panel-body">
                                                {{ $comentarios_marco_teorico->comentario}}

                                            </div>
                                        </div>
                                        @elseif( $comentarios_marco_teorico->id_estado_evaluacion==2)
                                            <div class="panel  panel-warning">
                                                <div class="panel-heading" style="text-align: center"> <b>NOMBRE DEL DOCENTE:</b> {{ $comentarios_marco_teorico->nombre}}<br>
                                                        <b>STATUS DEL ANTEPROYECTO: </b>ACEPTADO CON CAMBIOS
                                                </div>
                                                <div class="panel-body">
                                                    {{ $comentarios_marco_teorico->comentario}}

                                                </div>
                                            </div>
                                        @elseif( $comentarios_marco_teorico->id_estado_evaluacion==3)
                                            <div class="panel  panel-warning">
                                                <div class="panel-heading" style="text-align: center"> <b>NOMBRE DEL DOCENTE:</b> {{ $comentarios_marco_teorico->nombre}}<br>
                                                    <b>STATUS DEL ANTEPROYECTO: </b>ACEPTADO CON CAMBIOS
                                                </div>
                                                <div class="panel-body">
                                                    {{ $comentarios_marco_teorico->comentario}}

                                                </div>
                                            </div>
                                        @endif

                                    @endforeach
                                </div>
                            </div>


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
    <script type="text/javascript">
        $(document).ready( function() {
            $("#guardar_marco_teorico").click(function(event){
                var marco_teorico = $("#marco_teorico").val();
                if (marco_teorico != "") {
                    $("#guardar_marco_teorico").attr("disabled", true);
                    $("#form_marco_teorico").submit();
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
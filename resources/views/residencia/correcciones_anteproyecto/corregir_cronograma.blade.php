@extends('layouts.app')
@section('title', 'Corregir Anteproyecto')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Corregir  Cronograma</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="row">

                                <div class="col-md-2 col-md-offset-3 " style="text-align: center;">
                                    <a   href="{{url('/residencia/anteproyecto/corregir_marco_teorico')}}"><span class="glyphicon glyphicon-arrow-left" style="font-size:45px;color:#458acc"></span><br>Atras</a>
                                </div>

                                <div class="col-md-2 col-md-offset-2 " style="text-align: center;">
                                    <a   href="{{url('/residencia/anteproyecto/corregir_enviar_anteproyecto')}}"><span class="glyphicon glyphicon-arrow-right" style="font-size:45px;color:#458acc"></span><br>Siguiente</a>
                                </div>
                                <br>
                                <br>
                            </div>
                            <br>
                            <br>
                        </div>
                    </div>

                    <div class="row col-md-12">
                        <div>
                            <div class="col-md-8 ">

                                <div  class="tab-pane">
                                    <div class="panel panel-primary">
                                        <div class="row"><div class="col-md-6 col-md-offset-3"><h3>Cronograma de Actividades</h3></div></div>
                                        <div class="row">
                                            @foreach( $cronograma as $cronograma)
                                                <div class="col-md-12  text-center" style="margin-bottom: 5px">
                                                    <div style="border: 3px solid #d9edf7;border-radius: 5px; padding: 5px">
                                                        <div class="card-body">
                                                            <h5 class="card-title">
                                                                <strong>SEMANA {{$cronograma->no_semana}}</strong>
                                                            </h5>
                                                            <p class="card-text">
                                                                    <?php  $fecha_inicial=date("d-m-Y ",strtotime($cronograma->f_inicio)) ?>
                                                                    <?php  $fecha_final=date("d-m-Y ",strtotime($cronograma->f_termino)) ?>
                                                                    <b>{{{$fecha_inicial}}}</b> al <b>{{{$fecha_final}}}</b><br>
                                                            <p><b>Actividad(es)</b><br>{{$cronograma->actividad}}</p><br>
                                                            @if($cronograma->estado_aceptado_cronograma == 1)
                                                            <button class="btn btn-primary modificar_actividad" id="{{$cronograma->id_cronograma}}" disabled><i class="glyphicon glyphicon-cog em2"></i></button>
                                                            @else
                                                                <button class="btn btn-primary modificar_actividad" id="{{$cronograma->id_cronograma}}"><i class="glyphicon glyphicon-cog em2"></i></button>

                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
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
                                @if($cronograma->estado_aceptado_cronograma == 1)
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <div class="alert alert-danger" role="alert" style="text-align: center;">
                                                Ya te autorizarón el Cronograma
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
                                    @foreach($comentarios_cronograma as $comentarios_cronograma )
                                        @if($comentarios_cronograma->id_estado_evaluacion==1)
                                        <div class="panel  panel-success">
                                            <div class="panel-heading" style="text-align: center"> <b>NOMBRE DEL DOCENTE:</b> {{$comentarios_cronograma->nombre}}<br>
                                                    <b>STATUS DEL ANTEPROYECTO: </b>AUTORIZADO
                                            </div>
                                            <div class="panel-body">
                                                {{$comentarios_cronograma->comentario}}

                                            </div>
                                        </div>
                                        @elseif($comentarios_cronograma->id_estado_evaluacion==2)
                                            <div class="panel  panel-warning">
                                                <div class="panel-heading" style="text-align: center"> <b>NOMBRE DEL DOCENTE:</b> {{$comentarios_cronograma->nombre}}<br>
                                                        <b>STATUS DEL ANTEPROYECTO: </b>ACEPTADO CON CAMBIOS
                                                </div>
                                                <div class="panel-body">
                                                    {{$comentarios_cronograma->comentario}}

                                                </div>
                                            </div>
                                        @elseif($comentarios_cronograma->id_estado_evaluacion==3)
                                            <div class="panel  panel-warning">
                                                <div class="panel-heading" style="text-align: center"> <b>NOMBRE DEL DOCENTE:</b> {{$comentarios_cronograma->nombre}}<br>
                                                        <b>STATUS DEL ANTEPROYECTO: </b>RECHAZADO
                                                </div>
                                                <div class="panel-body">
                                                    {{$comentarios_cronograma->comentario}}

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

    {{--modificar actividad--}}
    <div class="modal fade" id="modal_modificar_actividad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form_modificar_actividades" class="form" action="{{url("/residencia/guardar_correciones_cronograma/")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar actividad(es)</h4>
                    </div>
                    <div id="contenedor_modificar_actividad">


                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="guarda_actividades" style="" class="btn btn-primary"  >Guardar</button>
                </div>

            </div>

        </div>
    </div>
    <script type="text/javascript">

        $(document).ready( function() {
            $(".modificar_actividad").click(function (event) {
                var id_cronograma=$(this).attr('id');
                $.get("/residencia/anteproyecto/cronograma/modificar_actividad/"+id_cronograma,function(request){
                    $("#contenedor_modificar_actividad").html(request);
                    $("#modal_modificar_actividad").modal('show');
                });
            });
            $("#guarda_actividades").click(function (){
                var actividades = $("#actividades").val();
                if (actividades != "" ) {
                    $("#guarda_actividades").attr("disabled", true);
                    $("#form_modificar_actividades").submit();


                    swal({
                        position: "top",
                        type: "success",
                        title: "Modificación exitosa",
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


        });





    </script>
@endsection
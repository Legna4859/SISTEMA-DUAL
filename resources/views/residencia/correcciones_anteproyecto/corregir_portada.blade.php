
@extends('layouts.app')
@section('title', 'Registrar Anteproyecto')
@section('content')
    @if($modificar == 3)
        <div class="row">
            <div class="col-md-6 col-md-offset-3"  >
                <div class="panel panel-success">
                    <div class="panel-heading" style="text-align: center;">Tu anteproyecto fue aceptado, registra tu empresa y ya puedes imprimir tu dictamen de anteproyecto</div>
                </div>
            </div>
        </div>

    @endif
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Corregir  Portada</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5 " style="text-align: center;">
                        <a   href="{{url('/residencia/anteproyecto/corregir_objetivos')}}"><span class="glyphicon glyphicon-arrow-right" style="font-size:45px;color:#458acc"></span><br>Siguiente</a>
                        </div>
                        <br>
                    </div>

                    <div class="row col-md-12">
                            <div class="col-md-7 col-md-offset-1">

                                <div  class="tab-pane">
                                    <div class="panel panel-primary">

                                            <div class="panel-body">
                                                <form class="form" role="form" action="{{url("/residencia/guardar_correciones_portada/")}}" method="POST" id="form_portada" >
                                                    {{ csrf_field() }}
                                                <div class="row">
                                                    <div class="col-md-7 col-md-offset-3">
                                                        <div class="form-group">
                                                            <label for="nombre_proyecto">NOMBRE DEL RESIDENTE</label>
                                                            <p>{{$datosalumno->nombre}} {{$datosalumno->apaterno}} {{$datosalumno->amaterno}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">PROYECTO:</label>
                                                            <input type="hidden" id="anteproyecto" name="anteproyecto" value="{{$portada->id_anteproyecto}}">
                                                            <select class="form-control" id="tipo_proy" name="tipo_proy" required>
                                                                @foreach($tipo_proyecto as $tipo_proyecto)
                                                                    @if($tipo_proyecto->id_tipo_proyecto==$portada->id_tipo_proyecto)
                                                                        <option value="{{$tipo_proyecto->id_tipo_proyecto}}" selected="selected">{{$tipo_proyecto->descripcion}}</option>

                                                                    @else
                                                                        <option value="{{$tipo_proyecto->id_tipo_proyecto}}" selected="selected">{{$tipo_proyecto->descripcion}}</option>

                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="nombre_proyecto">NOMBRE DEL PROYECTO</label>
                                                            <textarea class="form-control" style="text-transform:uppercase;" id="nombre_proyecto" name="nombre_proyecto" rows="3" placeholder="Ingresa el nombre del proyecto, no se aceptan comillas, ni caracteres " style="" required>{{ $portada->nom_proyecto }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                             @if($portada->estado_aceptado_portada == 1)
                                                    <div class="row">
                                                        <div class="col-md-4 col-md-offset-4">
                                                            <button id="guardar_solicitud" class="btn btn-primary" disabled>Guardar</button>
                                                        </div>
                                                    </div>
                                                 @else
                                                    <div class="row">
                                                        <div class="col-md-4 col-md-offset-4">
                                                            <button id="guardar_solicitud" class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </div>
                                                 @endif


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
                            @if($portada->estado_aceptado_portada == 1)
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="alert alert-danger" role="alert" style="text-align: center;">
                                            Ya te autorizaron portada
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
                                @foreach($comentarios_portada as $comentarios_portada )
                                    @if($comentarios_portada->id_estado_evaluacion==1)
                                    <div class="panel  panel-success">
                                        <div class="panel-heading" style="text-align: center"> <b>NOMBRE DEL DOCENTE:</b> {{$comentarios_portada->nombre}}<br>
                                                <b>STATUS DEL ANTEPROYECTO: </b>AUTORIZADO

                                        </div>
                                        <div class="panel-body">
                                            {{$comentarios_portada->comentario}}

                                        </div>
                                    </div>
                                    @elseif($comentarios_portada->id_estado_evaluacion==2)
                                        <div class="panel  panel-warning">
                                            <div class="panel-heading" style="text-align: center"> <b>NOMBRE DEL DOCENTE:</b> {{$comentarios_portada->nombre}}<br>
                                                    <b>STATUS DEL ANTEPROYECTO: </b>ACEPTADO CON CAMBIOS
                                            </div>
                                            <div class="panel-body">
                                                {{$comentarios_portada->comentario}}

                                            </div>
                                        </div>
                                    @elseif($comentarios_portada->id_estado_evaluacion==3)
                                        <div class="panel  panel-warning">
                                            <div class="panel-heading" style="text-align: center"> <b>NOMBRE DEL DOCENTE:</b> {{$comentarios_portada->nombre}}<br>

                                                    <b>STATUS DEL ANTEPROYECTO: </b>RECHAZADO
                                            </div>
                                            <div class="panel-body">
                                                {{$comentarios_portada->comentario}}

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

    <!-- Mensaje de anteproyecto -->
    <div id="modal_verificar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    <p class="text-center">Primero se debe llenar el apartado de portada</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
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
                </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input id="confirma_elimina_oficio" type="submit" class="btn btn-danger" value="Aceptar"/>
                    </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready( function() {
            $("#guardar_solicitud").click(function(event){
                var nombre_proyecto = $("#nombre_proyecto").val();
                if (nombre_proyecto != "") {
                $("#form_portada").submit();
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

            $("#mensaje").click(function (event) {
                $('#modal_verificar').modal('show');
            });
            $("#mensaje1").click(function (event) {
                $('#modal_verificar').modal('show');
            });
            $("#mensaje2").click(function (event) {
                $('#modal_verificar').modal('show');
            });
            $("#mensaje3").click(function (event) {
                $('#modal_verificar').modal('show');
            });
            $("#mensaje4").click(function (event) {
                $('#modal_verificar').modal('show');
            });
            $(".enviar").click(function (event) {
                var id=$(this).attr('id');
                $('#id_anteproyecto').val(id);
                $('#modal_enviar').modal('show');
            });
        });
    </script>
@endsection
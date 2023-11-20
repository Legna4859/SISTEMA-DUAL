
@extends('layouts.app')
@section('title', 'Registrar Anteproyecto')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Generar  Anteproyecto</h3>
                </div>
                <div class="panel-body">
                    <div class="row col-md-12">
                        <div>
                            <ul class="nav nav-pills nav-stacked col-md-2" style="border: 2px solid black; border-radius: 7px; padding-right: 0">
                                @if($registro_proy ==0)
                                    <li class="active"><a href="#" style="border-bottom: 2px solid black;">Portada</a></li>
                                    <li><a   id="mensaje" style="border-bottom: 2px solid black;">Objetivos</a></li>
                                    <li><a   id="mensaje1" style="border-bottom: 2px solid black;">Alcances</a></li>
                                    <li><a   id="mensaje2" style="border-bottom: 2px solid black;">Justificación</a></li>
                                    <li><a   id="mensaje3" style="border-bottom: 2px solid black;">Marco Teorico</a></li>
                                    <li><a   id="mensaje4" style="border-bottom: 2px solid black;">Cronograma</a></li>

                                @else
                                    <li class="active"><a href="#" style="border-bottom: 2px solid black;">Portada</a></li>
                                    <li><a href="{{url('/residencia/anteproyecto/objetivos')}}" style="border-bottom: 2px solid black;">Objetivos</a></li>
                                    <li><a href="{{url('/residencia/anteproyecto/alcances')}}" style="border-bottom: 2px solid black;">Alcances</a></li>
                                    <li><a href="{{url('/residencia/anteproyecto/justificacion')}}" style="border-bottom: 2px solid black;">Justificación</a></li>
                                    <li><a href="{{url('/residencia/anteproyecto/marco_teorico')}}" style="border-bottom: 2px solid black;">Marco Teorico</a></li>
                                    <li><a href="{{url('/residencia/anteproyecto/cronograma')}}" style="border-bottom: 2px solid black;">Cronograma</a></li>

                                @endif
                            </ul>
                            <div class="col-md-7 col-md-offset-2">

                                <div  class="tab-pane">
                                    <div class="panel panel-primary">
                                        <form class="form" role="form" method="POST" id="form_portada" >
                                            {{ csrf_field() }}
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12 ">
                                                        <div class="form-group">
                                                            <label for="nombre_proyecto">NOMBRE DEL RESIDENTE</label>
                                                            <p>{{$nombres->nombre}} {{$nombres->apaterno}} {{$nombres->amaterno}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="hidden" id="sin_proyecto" name="sin_proyecto" value="{{ $sin_proyecto }}">
                                                            <label for="exampleInputEmail1">PROYECTO:</label>
                                                            <select class="form-control" id="tipo_proy" name="tipo_proy" readonly required>
                                                                @foreach($tipo_proyecto as $tipo_proyecto)
                                                                        <option value="{{$tipo_proyecto->id_tipo_proyecto}}" selected="selected">{{$tipo_proyecto->descripcion}}</option>

                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="nombre_proyecto">NOMBRE DEL PROYECTO</label>
                                                            <textarea class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();"  id="nombre_proyecto" name="nombre_proyecto" rows="3" placeholder="Ingresa el nombre del proyecto, no se aceptan comillas, ni caracteres " style="" required>{{ $nombre }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($enviado_anteproyecto==0)
                                                    @if($sin_proyecto == 0)
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-4">
                                                        <button id="guardar_solicitud" class="btn btn-primary">Guardar</button>
                                                    </div>
                                                </div>
                                                    @else
                                                        <div class="row">
                                                            <div class="col-md-4 col-md-offset-4">
                                                                <button id="modificar_solicitud" class="btn btn-primary" >Guardar</button>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @else
                                                    <div class="row">
                                                        <div class="col-md-4 col-md-offset-4">
                                                            <button id="modificar_solicitud" class="btn btn-primary" disabled>Guardar</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
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

    <script type="text/javascript">
        $(document).ready( function() {
            $("#guardar_solicitud").click(function(event){
                var nombre_proyecto = $("#nombre_proyecto").val();
                if (nombre_proyecto != "") {
                    $("#guardar_solicitud").attr("disabled", true);
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
            $("#modificar_solicitud").click(function(event){
                var nombre_proyecto = $("#nombre_proyecto").val();
                if (nombre_proyecto != "") {
                    $("#modificar_solicitud").attr("disabled", true);
                    $("#form_portada").submit();
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
        });
    </script>
@endsection

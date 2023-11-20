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
                                <li><a href="{{url('/residencia/anteproyecto/portada')}}" style="border-bottom: 2px solid black;">Portada</a></li>
                                <li><a href="{{url('/residencia/anteproyecto/objetivos')}}" style="border-bottom: 2px solid black;">Objetivos</a></li>
                                <li><a href="{{url('/residencia/anteproyecto/alcances')}}" style="border-bottom: 2px solid black;">Alcances</a></li>
                                <li class="active"><a href="#" style="border-bottom: 2px solid black;">Justificación</a></li>
                                <li><a href="{{url('/residencia/anteproyecto/marco_teorico')}}" style="border-bottom: 2px solid black;">Marco Teorico</a></li>
                                <li><a href="{{url('/residencia/anteproyecto/cronograma')}}" style="border-bottom: 2px solid black;">Cronograma</a></li>
                            </ul>
                            <div class="col-md-7 col-md-offset-1">

                                <div  class="tab-pane">
                                    <div class="panel panel-primary">
                                        <form class="form" role="form" method="POST" id="form_justificacion" >
                                            {{ csrf_field() }}
                                            <div class="panel-body">
                                                <input type="hidden" id="sin_justificacion" name="sin_justificacion" value="{{ $sin_justificacion }}">
                                                @if($sin_justificacion==0)
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="justificacion">JUSTIFICACIÓN</label>
                                                                <textarea class="form-control"  id="justificacion" name="justificacion" rows="25" placeholder="Ingresar justificación de tu anteproyecto " style="" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @elseif($sin_justificacion==1)
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="justificacion">JUSTIFICACIÓN</label>
                                                                <textarea class="form-control"  id="justificacion" name="justificacion" rows="25" placeholder="Ingresar justificación de tu anteproyecto " style="" required>{{$justificacion}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($enviado_anteproyecto==0)
                                                    @if($sin_justificacion==0)
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-4">
                                                        <button id="guardar_justificacion" class="btn btn-primary">Guardar</button>
                                                    </div>
                                                </div>
                                                    @else
                                                        <div class="row">
                                                            <div class="col-md-4 col-md-offset-4">
                                                                <button id="modificar_justificacion" class="btn btn-primary">Guardar</button>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @else
                                                    <div class="row">
                                                        <div class="col-md-4 col-md-offset-4">
                                                            <button id="guardar_justificacion" class="btn btn-primary" disabled>Guardar</button>
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
    <script  type="text/javascript">
        $(document).ready( function() {
            $("#guardar_justificacion").click(function(event){
                var justificacion = $("#justificacion").val();
                if (justificacion != "") {
                    $("#guardar_justificacion").attr("disabled", true);
                    $("#form_justificacion").submit();

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
            $("#modificar_justificacion").click(function(event){
                var justificacion = $("#justificacion").val();
                if (justificacion != "") {
                    $("#modificar_justificacion").attr("disabled", true);
                    $("#form_justificacion").submit();

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
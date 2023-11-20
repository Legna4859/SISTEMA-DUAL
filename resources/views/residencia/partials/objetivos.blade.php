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
                                <li class="active"><a href="#" style="border-bottom: 2px solid black;">Objetivos</a></li>
                                <li><a href="{{url('/residencia/anteproyecto/alcances')}}" style="border-bottom: 2px solid black;">Alcances</a></li>
                                <li><a href="{{url('/residencia/anteproyecto/justificacion')}}" style="border-bottom: 2px solid black;">Justificación</a></li>
                                <li><a href="{{url('/residencia/anteproyecto/marco_teorico')}}" style="border-bottom: 2px solid black;">Marco Teorico</a></li>
                                <li><a href="{{url('/residencia/anteproyecto/cronograma')}}" style="border-bottom: 2px solid black;">Cronograma</a></li>
                            </ul>
                            <div class="col-md-8 col-md-offset-1">

                                <div  class="tab-pane">
                                    <div class="panel panel-primary">
                                        <form class="form" role="form" method="POST" id="form_objetivos" >
                                            {{ csrf_field() }}
                                            <div class="panel-body">
                                                <input type="hidden" id="sin_objetivos" name="sin_objetivos" value="{{ $sin_objetivos }}">
                                                @if($sin_objetivos==0)
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="objetivo_general">OBJETIVO GENERAL</label>
                                                                <textarea class="form-control"  id="objetivo_general" name="objetivo_general" rows="10" placeholder="Ingresa el Objetivo General " style="" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="objetivo_especifico">OBJETIVOS ESPECIFICOS</label>
                                                                <textarea class="form-control"  id="objetivo_especifico" name="objetivo_especifico" rows="10" placeholder="Ingresa los Objetivos Especificos " style="" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($sin_objetivos==1)
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="objetivo_general">OBJETIVO GENERAL</label>
                                                                <textarea class="form-control"  id="objetivo_general" name="objetivo_general" rows="10" placeholder="Ingresa el Objetivo General " style="" required>{{ $objetivo_general }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="objetivo_especifico">OBJETIVOS ESPECIFICOS</label>
                                                                <textarea class="form-control"  id="objetivo_especifico" name="objetivo_especifico" rows="10" placeholder="Ingresa los Objetivos Especificos " style="" required>{{ $objetivo_especifico }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @endif
                                                @if($enviado_anteproyecto==0)
                                                    @if($sin_objetivos==0)
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-4">
                                                        <button id="guardar_objetivos" class="btn btn-primary">Guardar</button>

                                                    </div>
                                                </div>
                                                    @else
                                                        <div class="row">
                                                            <div class="col-md-4 col-md-offset-4">
                                                                <button id="modificar_objetivos" class="btn btn-primary">Guardar</button>

                                                            </div>
                                                        </div>
                                                        @endif
                                                    @else
                                                    <div class="row">
                                                        <div class="col-md-4 col-md-offset-4">
                                                            <button id="guardar_objetivos" class="btn btn-primary" disabled>Guardar</button>

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
        </div></div></div></div>
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
            $("#modificar_objetivos").click(function(event){
                var objetivo_general = $("#objetivo_general").val();
                var objetivo_especifico = $("#objetivo_especifico").val();
                if (objetivo_general != "" && objetivo_especifico != "" ) {
                    $("#modificar_objetivos").attr("disabled", true);
                    $("#form_objetivos").submit();
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
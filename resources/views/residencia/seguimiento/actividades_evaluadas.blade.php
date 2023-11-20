@extends('layouts.app')
@section('title', 'Seguimiento de actividades')
@section('content')

    <main class="col-md-12">

        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                @if($terminado_proyecto == 1)
                    @if($promedio_final==0)
                        <button type="button" class="btn btn-primary evaluacion" id="{{{ $id_anteproyecto }}}" title="Enviar">Evaluación de residencia</button>
                    @else


                        <div class="panel panel-default">
                            <div class="panel-heading text-center" >
                                <?php $promedio_residencia=round($promedio_residencia); ?>

                                @if($promedio_residencia < 70)
                                    <button type="button" class="btn btn-danger btn-lg">  <h5 size="">{{  $promedio_residencia }}</h5>   </button>

                                @else
                                    <button type="button" class="btn btn-success btn-lg">  <h5 size="">{{ $promedio_residencia }}</h5>   </button>

                                @endif
                                <br>
                                <b>Promedio Residencia</b>
                                <br>
                                    @if($liberar_depto->id_calificar_departamento == 1)
                                    <button type="button" class="btn btn-primary " onclick="window.open('{{ url('/residencia/acta_calificaciones_residencia/'.$id_anteproyecto ) }}')" title="Acta de Calificaciones de Residencia">Acta de Residencia</button>
                                    @else
                                        <p style="color: #942a25">El Departamento de Servicio Social y Residencia Profesional debe autorizar para poder imprimir la acta de calificaciones. </p>
                                    @endif
                            </div>
                        </div>
                    @endif

                @endif
            </div>
            <div class="col-md-5">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Seguimiento de actividades  <br> {{ $nombre_alumno }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2 " id="imprimir" style="display: block;">
                <div class="panel panel-default">
                    <div class="panel-heading text-center" >
                        <?php $promedio=round($promedio); ?>

                        @if($promedio < 70)
                            <button type="button" class="btn btn-danger btn-lg">  <h5 size="">{{  $promedio }}</h5>   </button>

                        @else
                            <button type="button" class="btn btn-success btn-lg">  <h5 size="">{{  $promedio }}</h5>   </button>

                        @endif
                        <br>
                        <b>Promedio final</b>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        @foreach($semanas as $semana)
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-4 ">
                                    Semana {{$semana['no_semana']}}
                                </div>
                                <div class="col-md-4 col-md-offset-1">
                                    <?php  $fecha_inicial=date("d-m-Y",strtotime($semana['f_inicio'])); ?>
                                    <?php  $fecha_final=date("d-m-Y",strtotime($semana['f_termino'])); ?>
                                    Del {{$fecha_inicial}} al  {{$fecha_final}}
                                </div>
                                @if($semana['estatus'] == 1)
                                    <div class="col-md-2 col-md-offset-1">
                                        @if($semana['promedio'] < 70 )
                                            <button type="button" class="btn btn-danger">
                                                N. A.
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-success">
                                                {{$semana['promedio']}}
                                            </button>
                                        @endif
                                    </div>
                                @elseif($semana['estatus'] == 2)
                                    <div class="col-md-2 col-md-offset-1">
                                        <button type="button" class="btn btn-primary calificar" id="{{ $semana['id_cronograma'] }}">Calificar</button>
                                    </div>
                                @elseif($semana['estatus'] == 3)
                                    <div class="col-md-2 col-md-offset-1">
                                        <button type="button" class="btn btn-primary calificar" disabled >Calificar</button>

                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="panel-body">
                            <b>Actividad(es):</b>  {{$semana['actividad']}}
                        </div>
                    </div>
                </div>

            </div>

            <br>

        @endforeach
        <br>
    </main>


    <div class="modal fade" id="modal_calificar_actividad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Calificar actividad <br>  {{ $nombre_alumno }}</h4>
                </div>
                <div id="contenedor_calificar_actividad">


                </div>



            </div>

        </div>
    </div>


    <div class="modal fade" id="modal_modificar_asesores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar Asesor</h4>
                </div>
                <div id="contenedor_modificar_asesores">


                </div>



            </div>

        </div>
    </div>
    <div class="modal fade" id="modal_formato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Calificar residencia <br>  {{ $nombre_alumno }}</h4>
                </div>

                <div id="contenedor_formato">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input  type="button" id="guardar_datos" class="btn btn-primary" value="Guardar"/>
                </div>


            </div>

        </div>
    </div>



    <script type="text/javascript">

        $(document).ready(function() {

            $(".calificar").click(function(){
                var id_cronograma=$(this).attr("id");
                $.get("/residencia/calificar_anteproyecto/"+id_cronograma,function(request){
                    $("#contenedor_calificar_actividad").html(request);
                    $("#modal_calificar_actividad").modal('show');

                });
            });
            $(".modificar").click(function(){
                var id_anteproyecto=$(this).data("id");
                $.get("/residencia/modificar_asesores_anteproyecto/"+id_anteproyecto,function(request){
                    $("#contenedor_modificar_asesores").html(request);
                    $("#modal_modificar_asesores").modal('show');

                });

            });
            $(".evaluacion").click(function(){
                var id_anteproyecto=$(this).attr("id");
                $.get("/residencia/formato_evaluacion_residencia/"+id_anteproyecto,function(request){
                    $("#contenedor_formato").html(request);
                    $("#modal_formato").modal('show');

                });
            });
            $("#guardar_datos").click(function (){
                var uno = $("#uno").val();
                var dos = $("#dos").val();
                var tres = $("#tres").val();
                var cuatro = $("#cuatro").val();
                var cinco = $("#cinco").val();
                var seis = $("#seis").val();
                var siete = $("#siete").val();
                var ocho = $("#ocho").val();
                var nueve = $("#nueve").val();
                var diez = $("#diez").val();
                var once = $("#once").val();
                var doce = $("#doce").val();
                var observacion= $("#observacion").val();


                if(uno != '' && dos != '' && tres != '' && cuatro != ''&& cinco != ''
                && seis != '' && siete != '' && ocho != '' && nueve != '' && diez != ''
                && once != '' && doce != '' && observacion != ''){


                        $("#formulario_registrar_cal").submit();
                        $("#guardar_datos").attr("disabled", true);
                    swal({
                        position: "top",
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 3500
                    });



                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Algún campo esta vacío",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            });
        });
    </script>
@endsection
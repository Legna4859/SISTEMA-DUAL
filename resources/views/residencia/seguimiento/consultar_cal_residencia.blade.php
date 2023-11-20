@extends('layouts.app')
@section('title', 'Seguimiento de actividades')
@section('content')

    <main class="col-md-12">
        @if($encuesta==0)
            @foreach($semanas as $semana)
        @if($semana['no_semana'] == $ultima and $semana['estatus'] == 1)
            @if($promedio_final== 0)
                <div class="row">
                    <div class="col-md-2 col-md-offset-1" style="text-align: center">
                        <a class="btn btn-primary " href="#"
                           onclick="window.open('{{url('/residencia/pdf_formato_evaluacion/'.$id_anteproyecto)}}')">PDF PARA EVALUACIÓN EXTERNA</a></div>
                </div>
                    @endif
                         <br>

                        <br>
                    </div>
                    <br>
                </div>

            @endif
            @endforeach
           @endif

        @if($encuesta==1)
            <div class="row">
                <div class="col-md-2 col-md-offset-1" style="text-align: center">

                    <button type="button" class="btn btn-primary documentacion" id="{{{ $id_anteproyecto }}}" title="Documentacion">Documentación</button>
                    <br>

                    <br>
                </div>
                <br>
            </div>
        @endif

        @if($promedio_final==1)
            @if($encuesta==0)
                <div class="row">
                    <div class="col-md-2 col-md-offset-1" style="text-align: center">

                        <button type="button" class="btn btn-primary evaluacion"  title="Evaluación Final de Residencia">Evaluación Final de Residencia</button>
                        <br>

                        <br>
                    </div>
                    <br>
                </div>
            @endif
        @endif
        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                @if($promedio_final==1)
                    <div class="panel panel-default">
                        <div class="panel-heading text-center" >
                            <?php $promedio_residencia=round($promedio_residencia); ?>

                            @if($promedio_residencia < 70)
                                <button type="button" class="btn btn-danger btn-lg">  <h5 size="">{{  $promedio_residencia }}</h5>   </button>

                            @else
                                <button type="button" class="btn btn-success btn-lg">  <h5 size="">{{ $promedio_residencia }}</h5>   </button>

                            @endif
                            <br>
                            <b>Promedio General de  Residencia</b>
                            <br>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-5 ">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Seguimiento de actividades </h3>
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
                        <b>Promedio Seguimiento</b>
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
                                @elseif($semana['estatus'] == 3)
                                    <div class="col-md-3 ">
                                        <button type="button" class="btn btn-warning">No se ha asignado calificación</button>
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
            @if($semana['no_semana'] == 4 and $semana['estatus'] == 1)
                <?php  $numero1=4 ?>
                <div class="row">
                    <div class="col-md-2 col-md-offset-5">
                        <button type="button" class="btn btn-primary " onclick="window.open('{{ url('/residencia/seguimiento_residencia/'.$id_anteproyecto.'/'.$numero1 ) }}')" title="Enviar">Imprimir Reporte 1</button>

                    </div>
                </div>
            @endif
            @if($semana['no_semana'] == 8 and $semana['estatus'] == 1)
                <?php  $numero2=8 ?>
                <div class="row">
                    <div class="col-md-2 col-md-offset-5">
                        <button type="button" class="btn btn-primary " onclick="window.open('{{ url('/residencia/seguimiento_residencia/'.$id_anteproyecto.'/'.$numero2 ) }}')" title="Enviar">Imprimir Reporte 2</button>

                    </div>
                </div>
            @endif
            @if($semana['no_semana'] == 12 and $semana['estatus'] == 1)
                <?php  $numero3=12 ?>
                <div class="row">
                    <div class="col-md-2 col-md-offset-5">
                        <button type="button" class="btn btn-primary " onclick="window.open('{{ url('/residencia/seguimiento_residencia/'.$id_anteproyecto.'/'.$numero3 ) }}')" title="Enviar">Imprimir Reporte 3</button>

                    </div>
                </div>
            @endif
            @if($semana['no_semana'] == 16 and $semana['estatus'] == 1)
                <?php  $numero4=16 ?>
                <div class="row">
                    <div class="col-md-2 col-md-offset-5">
                        <button type="button" class="btn btn-primary " onclick="window.open('{{ url('/residencia/seguimiento_residencia/'.$id_anteproyecto.'/'.$numero4 ) }}')" title="Enviar">Imprimir Reporte 4</button>

                    </div>
                </div>
            @endif
            @if($semana['no_semana'] == $ultima and $semana['estatus'] == 1)
                <?php  $numero5=$semana['no_semana'] ?>

                <div class="row">
                    <div class="col-md-2 col-md-offset-5">
                        <button type="button" class="btn btn-primary " onclick="window.open('{{ url('/residencia/ultimo_reporte_residencia/'.$id_anteproyecto.'/'.$numero5 ) }}')" title="Enviar">Imprimir Reporte 5</button>

                    </div>
                </div>

            @endif
            <br>
        @endforeach
        <br>
    </main>


    <div class="modal fade" id="modal_calificar_actividad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Calificar actividad</h4>
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

    <div class="modal fade" id="modal_documentacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Oficios Finales</h4>
                </div>
                <div class="row">
                    <br>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-primary">
                            <div class="panel-body"><a href="#"
                                                       onclick="window.open('{{url('/residencia/seguimiento/oficio_informe_final/'.$id_anteproyecto)}}')">OFICIO DE ACEPTACIÓN DE INFORME FINAL DEL ASESOR INTERNO</a></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-primary">
                            <div class="panel-body"><a href="#"
                                                       onclick="window.open('{{url('/residencia/seguimiento/oficio_aceptacion_externo/'.$id_anteproyecto)}}')">OFICIO DE ACEPTACIÓN DE INFORME FINAL DEL ASESOR EXTERNO</a></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-primary">
                            <div class="panel-body"><a href="#"
                                                       onclick="window.open('{{url('/residencia/formato_evaluacion/'.$id_anteproyecto)}}')">EVALUACIÓN EXTERNA DE RESIDENCIA PROFESIONAL</a></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-primary">
                            <div class="panel-body"><a href="#"
                                                       onclick="window.open('{{url('/residencia/seguimiento/oficio_revisor/'.$id_anteproyecto)}}')">OFICIO DE ACEPTACIÓN DE INFORME FINAL DE REVISOR</a></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-primary">
                            <div class="panel-body"><a href="#"
                                                       onclick="window.open('{{url('/residencia/seguimiento/portada/'.$id_anteproyecto)}}')">PORTADA</a></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-primary">
                            <div class="panel-body"><a href="#"
                                                       onclick="window.open('{{url('/residencia/seguimiento/pdf_encuesta/'.$id_anteproyecto)}}')">ENCUESTA</a></div>
                        </div>
                    </div>
                </div>



                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modal_evaluacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form class="form" action="{{url("/residencia/evaluacion_final_residencia/")}}" role="form" method="POST" >
            {{ csrf_field() }}
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Evaluación Final de Residencia Profesional</h4>
                    </div>
                    <div class="row">
                        <br>
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel-body">Instrucciones: Responda con la mayor sinceridad posible las sigientes preguntas.</div>
                        </div>

                    </div>

                    <div class="row">
                        <input type="hidden" id="id_anteproyecto" name="id_anteproyecto" value="{{$id_anteproyecto}}">

                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="dropdown">
                                            <label for="selectcalidad">1.-¿Se instruyó con el curso de inducción por parte del Departamento de Servicio Social y Residencia Profesional?</label>
                                            <div class="col-md-5 col-md-offset-1">
                                                <select name="pregunta1" class="form-control " required >
                                                    <option disabled selected>Selecciona...</option>
                                                    <option value="Si">Si</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="row">
                        <br>
                        <div class="col-md-10 col-md-offset-1">
                            2.¿Se te instruyo en el curso sobre los siguientes aspectos?

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="dropdown">
                                            <div class="col-md-5">
                                                <label for="selectcalidad">Reglamento de residencia profesional</label>
                                            </div>
                                            <div class="col-md-3 col-md-offset-2 ">
                                                <select name="pregunta2" class="form-control " required >
                                                    <option disabled selected>Selecciona...</option>
                                                    <option value="Si">Si</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="row">
                        <br>
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="dropdown">
                                            <div class="col-md-5">
                                                <label for="selectcalidad">Dependencias para realizar residencia profesional</label>
                                            </div>
                                            <div class="col-md-3 col-md-offset-2">
                                                <select name="pregunta3" class="form-control " required >
                                                    <option disabled selected>Selecciona...</option>
                                                    <option value="Si">Si</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="dropdown">
                                            <div class="col-md-5 ">
                                                <label for="selectcalidad">Procedimiento</label>
                                            </div>
                                            <div class="col-md-3 col-md-offset-2">
                                                <select name="pregunta4" class="form-control " required >
                                                    <option disabled selected>Selecciona...</option>
                                                    <option value="Si">Si</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="row">
                        <br>
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="dropdown">
                                            <div class="col-md-5">
                                                <label for="selectcalidad">Sistema</label>
                                            </div>
                                            <div class="col-md-3 col-md-offset-2">
                                                <select name="pregunta5" class="form-control " required >
                                                    <option disabled selected>Selecciona...</option>
                                                    <option value="Si">Si</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="dropdown">
                                            <label for="selectcalidad">3.-En una escala de 0 a 100, ¿qué tan satisfecho estas con la asesoría por parte del Asesor Interno?</label>
                                            <div class="col-md-5 col-md-offset-1">
                                                <input type="number" name="pregunta6" class="form-control " id="pregunta6" required >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="dropdown">
                                            <label for="selectcalidad">4.-En una escala de 0 a 100 indica, ¿cuál es tu nivel de satisfacción personal al término de residencia profesional?</label>
                                            <div class="col-md-5 col-md-offset-1">
                                                <input type="number" name="pregunta7" class="form-control " id="pregunta7" title="0" required >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="dropdown">
                                            <label for="selectcalidad">Comentarios</label>

                                            <textarea class="form-control" id="comentario" name="comentario"  rows="2" placeholder="Ingresa comentarios"  required></textarea>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input  type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>

                </div>

            </div>
        </form>
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


                $("#modal_evaluacion").modal('show');

            });

            $(".documentacion").click(function(){


                $("#modal_documentacion").modal('show');

            });


        });
    </script>
@endsection
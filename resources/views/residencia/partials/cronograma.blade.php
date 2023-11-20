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
                                <li><a href="{{url('/residencia/anteproyecto/justificacion')}}" style="border-bottom: 2px solid black;">Justificación</a></li>
                                <li><a href="{{url('/residencia/anteproyecto/marco_teorico')}}" style="border-bottom: 2px solid black;">Marco Teorico</a></li>
                                <li class="active"><a href="#" style="border-bottom: 2px solid black;">Cronograma</a></li>
                            </ul>
                            <div class="col-md-10 ">

                                <div  class="tab-pane">
                                    <div class="panel panel-success">
                                        <div class="row"><div class="col-md-6 col-md-offset-3"><h3>Cronograma de Actividades</h3></div></div>
                                        <div class="row">
                                            @foreach( $semanas as $semana)
                                                <div class="col-md-12  text-center" style="margin-bottom: 5px">
                                                    <div style="border: 3px solid #d9edf7;border-radius: 5px; padding: 5px">
                                                        <div class="card-body">
                                                            <h5 class="card-title">
                                                                <strong>SEMANA {{ $semana['no_semana'] }}</strong>
                                                            </h5>
                                                            <p class="card-text">
                                                                @if($semana['estatus']==1)
                                                                    <?php  $fecha_inicial=date("d-m-Y ",strtotime($semana['f_inicio'])) ?>
                                                                    <?php  $fecha_final=date("d-m-Y ",strtotime($semana['f_termino'])) ?>
                                                                    <b>{{{$fecha_inicial}}}</b> al <b>{{{$fecha_final}}}</b><br>
                                                            <p><b>Actividad(es)</b><br>{{$semana['actividad']}}</p><br>
                                                            @if($enviado_anteproyecto==0)
                                                                <button class="btn btn-primary modificar_actividad" id="{{$semana['id_cronograma']}}"><i class="glyphicon glyphicon-cog em2"></i></button>

                                                            @else
                                                            <button class="btn btn-primary "  disabled><i class="glyphicon glyphicon-cog em2"></i></button>
                                                            @endif
                                                            @elseif($semana['estatus']==2)
                                                                <h6 class="text-danger">No se ha asignado actividad(es)</h6>
                                                                <button data-toggle="tooltip" data-placement="top" id="{{$semana['no_semana'] }}" title="Asignar actividad(es)" class="btn btn btn-primary h-primary_m pl-5 pr-5 agregar">Asignar actividad(es)</button></span>

                                                            @elseif($semana['estatus']==3)
                                                                <h6 class="text-danger">No se ha asignado actividad(es)</h6>
                                                                <button data-toggle="tooltip" data-placement="top"   class="btn btn btn-primary h-primary_m pl-5 pr-5" disabled>Asignar actividad(es)</button></span>

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

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div></div></div></div>
    </div>
    {{--registro de actividad--}}
    <div class="modal fade" id="modal_registro_actividad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form_agregar_actividad" class="form"  action="{{url("/residencia/anteproyecto/cronograma/registrar_actividad/")}}" role="form" method="POST" >
                    {{ csrf_field() }}


                        <div id="contenedor_registro_actividad">
                        </div>

                </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  id="guarda_actividad" style="" class="btn btn-primary"  >Guardar</button>
                    </div>

            </div>
        </div>
    </div>
    {{--fin de registro de actividad--}}
    {{--modificar actividad--}}
    <div class="modal fade" id="modal_modificar_actividad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form" id="form_modificar_actividades" action="{{url("/residencia/anteproyecto/cronograma/modificacion_actividad/")}}" role="form" method="POST" >
                    {{ csrf_field() }}

                    <div id="contenedor_modificar_actividad">


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  id="guarda_actividades" style="" class="btn btn-primary"  >Guardar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    {{--fin modificar actividad--}}
    <script type="text/javascript">

        $(document).ready( function() {
            $(".agregar").click(function (event) {
                var idof=$(this).attr('id');
                $.get("/residencia/anteproyecto/cronograma/agregar_actividad/"+idof,function (request) {
                    $("#contenedor_registro_actividad").html(request);
                    $("#modal_registro_actividad").modal('show');
                });
            });
            $(".modificar_actividad").click(function (event) {
                var id_cronograma=$(this).attr('id');
                $.get("/residencia/anteproyecto/cronograma/modificar_actividad/"+id_cronograma,function(request){
                    $("#contenedor_modificar_actividad").html(request);
                    $("#modal_modificar_actividad").modal('show');
                });
            });


        });
        $("#guarda_actividad").click(function (){
            var actividad = $("#actividad").val();
            if (actividad != "" ) {
                $("#guarda_actividad").attr("disabled", true);
                $("#form_agregar_actividad").submit();


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


        var statSend = false;
        function checkSubmit() {
            if (!statSend) {
                statSend = true;
                return true;
            } else {
                alert("El formulario ya se esta enviando...");
                return false;
            }
        }


    </script>
@endsection
@extends('layouts.app')
@section('title', 'Corregir Anteproyecto')
@section('content')
    <div class="row">
        <div class="col-md-5 col-xs-10 col-md-offset-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Enviar Anterpoyecto</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-2">
                            <div class="row">

                                <div class="col-md-1 col-md-offset-1 " style="text-align: center;">
                                    <a   href="{{url('/residencia/anteproyecto/corregir_cronograma')}}"><span class="glyphicon glyphicon-arrow-left" style="font-size:45px;color:#458acc"></span><br>Atras</a>
                                </div>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                    @if($modificar == 3)
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3"  >
                                <div class="panel panel-success">
                                    <div class="panel-heading" style="text-align: center;">Tu anteproyecto fue aceptado, registra tu empresa y ya puedes imprimir tu dictamen de anteproyecto</div>
                                </div>
                            </div>
                        </div>
                  @else


                    <div class="row">
                        <div class="col-md-2 col-md-offset-5">
                            <div class="row">
                                <button type="button" class="btn btn-success enviar" id="{{ $id_anteproyecto }}" title="Enviar">Enviar Anteproyecto</button>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- enviar anteproyecto -->
    <div id="modal_enviar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form id="form_enviar_anteproyecto" action="{{url("/residencia/enviar_anteproyecto_corregido/")}}" method="POST" role="form" >
                    <div class="modal-body">

                        {{ csrf_field() }}
                        ¿Realmente deseas deseas enviar tu anteproyecto?
                        <input type="hidden" id="id_anteproyecto" name="id_anteproyecto" value="">
                    </div>
                </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input id="enviar_anteproyecto" type="submit" class="btn btn-danger" value="Aceptar"/>
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

            $(".enviar").click(function (event) {
                var id=$(this).attr('id');
                $('#id_anteproyecto').val(id);
                $('#modal_enviar').modal('show');
            });
            $("#enviar_anteproyecto").click(function (){
                $("#enviar_anteproyecto").attr("disabled", true);
                $("#form_enviar_anteproyecto").submit();
                swal({
                    position: "top",
                    type: "success",
                    title: "Envio correctamente",
                    showConfirmButton: false,
                    timer: 3500
                });
            });
        });





    </script>
@endsection
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
                                    <li><a href="{{url('/residencia/anteproyecto/portada')}}" style="border-bottom: 2px solid black;">Portada</a></li>
                                    <li><a   id="mensaje" style="border-bottom: 2px solid black;">Objetivos</a></li>
                                    <li><a   id="mensaje1" style="border-bottom: 2px solid black;">Alcances</a></li>
                                    <li><a   id="mensaje2" style="border-bottom: 2px solid black;">Justificación</a></li>
                                    <li><a   id="mensaje3" style="border-bottom: 2px solid black;">Marco Teorico</a></li>
                                    <li><a   id="mensaje4" style="border-bottom: 2px solid black;">Cronograma</a></li>

                                @else
                                    <li><a href="{{url('/residencia/anteproyecto/portada')}}" style="border-bottom: 2px solid black;">Portada</a></li>
                                    <li><a href="{{url('/residencia/anteproyecto/objetivos')}}" style="border-bottom: 2px solid black;">Objetivos</a></li>
                                    <li><a href="{{url('/residencia/anteproyecto/alcances')}}" style="border-bottom: 2px solid black;">Alcances</a></li>
                                    <li><a href="{{url('/residencia/anteproyecto/justificacion')}}" style="border-bottom: 2px solid black;">Justificación</a></li>
                                    <li><a href="{{url('/residencia/anteproyecto/marco_teorico')}}" style="border-bottom: 2px solid black;">Marco Teorico</a></li>
                                    <li><a href="{{url('/residencia/anteproyecto/cronograma')}}" style="border-bottom: 2px solid black;">Cronograma</a></li>

                                @endif
                                   </ul>
                               <div class="tab-content col-md-10">
                                   @if($enviado_anteproyecto ==0)
                                   @if($registro_proy ==0)
                                   <div class="tab-pane fade in active text-center">
                                       <div class="col-md-6 col-md-offset-3">
                                           <label class=" alert alert-success"  data-toggle="tab" >Seleccione rubro de Portada para registrar anteproyecto
                                           </label>
                                       </div>
                                   </div>
                                       @else
                                       @if($autorizar_proyecto==0)
                                           <div class="tab-pane fade in active text-center">
                                               <div class="col-md-6 col-md-offset-3">
                                                   <label class=" alert alert-success"  data-toggle="tab" > Te falta llenar un apartado de tu anteproyecto, verifica.<br>
                                                       <button  type="button" class="btn btn-success btn-lg btn-block" title="Enviar" disabled>Enviar Anteproyecto</button>
                                                   </label>
                                               </div>
                                           </div>
                                           @else
                                           <div class="tab-pane fade in active text-center">
                                               <div class="col-md-6 col-md-offset-3">
                                                   <label class=" alert alert-success"  data-toggle="tab" >    <button type="button" class="btn btn-success btn-lg btn-block enviar" id="{{$reg_proy}}" title="Enviar">Enviar Anteproyecto</button>

                                                   </label>
                                               </div>
                                           </div>

                                           @endif

                                   @endif
                                       @else
                                       <div class="tab-pane fade in active text-center">
                                           <div class="col-md-6 col-md-offset-3">
                                               <label class=" alert alert-success"  data-toggle="tab" > Tu proyecto ya fue enviado, ya no puedes hacer ninguna modificación de registro de anteproyecto.<br>
                                                 </label>
                                           </div>
                                       </div>

                                   @endif

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
                <form id="form_envio_anteproyecto" action="{{url("/residencia/anteproyecto/enviar/")}}" method="POST" role="form" >
                    <div class="modal-body">

                        {{ csrf_field() }}
                        ¿Realmente deseas deseas enviar tu anteproyecto?
                        <input type="hidden" id="id_anteproyecto" name="id_anteproyecto" value="">
                    </div>

                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="confirma_elimina_oficio"  class="btn btn-primary" >Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready( function() {
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
            $("#confirma_elimina_oficio").click(function (){
                $("#confirma_elimina_oficio").attr("disabled", true);
                $("#form_envio_anteproyecto").submit();
                swal({
                    position: "top",
                    type: "success",
                    title: "Envio exitoso",
                    showConfirmButton: false,
                    timer: 3500
                });
            });
        });
    </script>
@endsection
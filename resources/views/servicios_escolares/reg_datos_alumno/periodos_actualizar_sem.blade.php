@extends('layouts.app')
@section('title', 'Servicios escolares')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"> Periodos de actualización de semestre</h3>
                </div>
            </div>
        </div>
    </div>
       @if($periodo_activo != null)
           <div class="row">
               <div class="col-md-6 col-md-offset-3">
                   <div class="panel panel-success">
                       <div class="panel-heading">
                          <h3 style="text-align: center">Periodo activo</h3>
                           <h3 style="text-align: center">Nombre del periodo: {{ $periodo_activo->periodo }}</h3>
                           <p style="text-align: center">          <button data-toggle="tooltip" data-placement="top" id="{{$periodo_activo->id_periodos_sem_act }}" title="Finalizar periodo" class="btn btn btn-danger h-primary_m pl-5 pr-5 finalizar_periodos">Finalizar periodo</button>
                              <br><br> <button data-toggle="tooltip" data-placement="top"  onclick="window.location='{{ url('/servicios_escolares/carreras_act_sem/') }}'" title="Actualizar semestre por carrer" class="btn btn btn-primary h-primary_m pl-5 pr-5 ">Actualizar semestre por carrera</button>

                           </p>
                       </div>
                   </div>
               </div>
           </div>
        @endif

     @if($periodo_activo == null)
        <div class="row">
            <div class="col-md-1 col-md-offset-2">
                <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar periodo" data-target="#modal_crear_periodo" type="button" class="btn btn-success btn-lg flotante">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
                <p><br></p>
            </div>
        </div>
        @endif

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table class="table table-bordered" id="registros_periodos">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Periodo</th>
                    <th>Estado</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; ?>
                @foreach($periodos_semestre as $peri)
                    <tr>
                        <td>{{ $i++ }}</td>

                        <td>{{ $peri->periodo }}</td>

                            @if($peri->id_estado_actualizacion == 0)
                            <td>
                                <button data-toggle="tooltip" data-placement="top" id="{{$peri->id_periodos_sem_act }}" title="Activar periodo" class="btn btn btn-primary h-primary_m pl-5 pr-5 activacion_periodo">Activar periodo</button>
                            </td>
                            @elseif($peri->id_estado_actualizacion == 1)
                                <td>Activo</td>
                           @elseif($peri->id_estado_actualizacion == 2)
                                <td>Finalizado</td>

                            @endif


                    </tr>
                @endforeach



                </tbody>
            </table>
        </div>
    </div>

    {{-- modal crear periodo--}}

    <div class="modal fade" id="modal_crear_periodo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar periodo actualización de semestre</h4>
                </div>
                <div class="modal-body">

                    <form id="form_agregar" class="form" action="{{url("/servicios_escolares/reg_periodo_act_sem")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="dropdown">
                                    <label for="exampleInputEmail1">Selecciona periodo</label>
                                    <select class="form-control  "placeholder="selecciona una Opcion" id="id_periodo" name="id_periodo" required>
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($periodos as $periodo)
                                            <option value="{{$periodo->id_periodo}}" data-esta="{{$periodo->periodo }}">{{ $periodo->periodo }} </option>
                                        @endforeach
                                    </select>
                                    <br>
                                </div>
                            </div>
                            <br>
                        </div>


                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_periodo"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal activar periodo--}}

    <div class="modal fade" id="modal_activar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Activar periodo de actualizacion de semestre </h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_activar">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_activacion_periodo"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal finalizar periodo--}}

    <div class="modal fade" id="modal_finalizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Finalizar periodo de actualizacion de semestre </h4>
                </div>
                <div class="modal-body">
                    <form  id="form_guardar_activar_est" action="{{url("/servicios_escolares/guardar_finalizacion_periodo/")}}" role="form" method="POST" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                        <h4>¿Seguro(a) quieres finalizar periodo?</h4>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit"  class="btn btn-primary" >Aceptar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready( function() {

            $("#guardar_periodo").click(function (){
                var id_periodo = $('#id_periodo').val();
                if(id_periodo != null){

                        $("#form_agregar").submit();
                        $("#guardar_periodo").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Seleccionar periodo para actualizar semestre",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#registros_periodos").on('click','.activacion_periodo',function(){
                var id_periodos_sem_act =$(this).attr('id');

                $.get("/servicios_escolares/activar_periodo_act_sem/"+id_periodos_sem_act,function (request) {
                    $("#contenedor_activar").html(request);
                    $("#modal_activar").modal('show');
                });
            });
           $("#guardar_activacion_periodo").click(function (){
               $("#form_guardar_activar_periodo").submit();
               $("#guardar_activacion_periodo").attr("disabled", true);
           });
            $(".finalizar_periodos").click(function (){

                   $("#modal_finalizar").modal('show');
           });

        });
    </script>

@endsection
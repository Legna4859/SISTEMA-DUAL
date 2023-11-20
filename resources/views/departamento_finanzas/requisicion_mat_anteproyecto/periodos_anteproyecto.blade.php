@extends('layouts.app')
@section('title', 'Periodos de anteproyecto')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"> Periodos de requisiciones de materiales del anteproyecto</h3>
                </div>
            </div>
        </div>
    </div>
            @if($reg_periodo->contar == 0)
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Registrar el periodo de requisiciones de materiales del anteproyecto, ya debe estar registrado el presupuesto del anteproyecto {{ $year }}.</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1 col-md-offset-2">
                        <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar periodo" data-target="#modal_crear_periodo" type="button" class="btn btn-success btn-lg flotante">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            @else


                    @if($activo_periodo->contar == 1)
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <?php   $fecha_i= date('d-m-Y', strtotime( $periodo_activo->fecha_inicio)); ?>
                                        <?php   $fecha_f= date('d-m-Y', strtotime( $periodo_activo->fecha_final)); ?>
                                        <h3 class="panel-title text-center"> Periodo activo <br> {{ $fecha_i }} al {{ $fecha_f }} <br>Año de requisiciones de materiales del anteproyecto :  {{  $periodo_activo->year }}</h3>
                                           <p  style="text-align: center"><button data-toggle="tooltip" data-placement="top" id="{{$periodo_activo->id_peri_anteproyecto }}" title="Modificar periodo" class="btn btn btn-success h-primary_m pl-5 pr-5 modificar_periodo_activo">Modificar periodo</button></p>
                                            <p style="text-align: center">          <button data-toggle="tooltip" data-placement="top" id="{{$periodo_activo->id_peri_anteproyecto }}" title="Finalizar periodo" class="btn btn btn-primary h-primary_m pl-5 pr-5 finalizar_periodo">Finalizar periodo</button>
                                           </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- modal finalizar periodo--}}

                        <div class="modal fade" id="modal_finalizar_periodo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="exampleModalLabel">Periodo de requisiciones de materiales del anteproyecto </h4>
                                    </div>
                                    <div class="modal-body">
                                        <form  class="form" action="{{url("/presupuesto_anteproyecto/guardar_finalizacion_periodos_anteproyecto/".$periodo_activo->id_peri_anteproyecto)}}" role="form" method="POST" >
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-10 col-md-offset-1">
                                                    <h3 style="text-align: center">Finalizar periodo</h3>
                                                </div>
                                            </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                            <button type="submit"  class="btn btn-primary" >Aceptar</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($periodo_finalizado->contar == 1)
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h3 class="panel-title text-center"> El periodo de este año ya se encuentra finalizado.</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <?php   $fecha_i= date('d-m-Y', strtotime( $periodo_activo->fecha_inicio)); ?>
                                        <?php   $fecha_f= date('d-m-Y', strtotime( $periodo_activo->fecha_final)); ?>
                                        <h3 class="panel-title text-center"> Periodo finalizado:  <br> {{ $fecha_i }} al {{ $fecha_f }} <br>Año:  {{  $periodo_activo->year }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @else
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <h3 class="panel-title text-center"> El periodo  ya se encuentra registrado.</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
            @endif
    <div class="row">
        <div class="col-md-10">
            <p><br></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table class="table table-bordered" id="registros_periodos">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Fecha inicial</th>
                    <th>Fecha final</th>
                    <th>Año</th>
                    <th>Modificar</th>
                    <th>Estado</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; ?>
                       @foreach($periodos as $periodo)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <?php   $fecha_i= date('d-m-Y', strtotime( $periodo->fecha_inicio)); ?>
                            <td>{{ $fecha_i }}</td>
                            <?php   $fecha_f= date('d-m-Y', strtotime( $periodo->fecha_final)); ?>
                            <td>{{ $fecha_f }}</td>
                            <td>{{ $periodo->year }}</td>
                                @if($activo_periodo->contar == 1 || $periodo_finalizado->contar == 1)
                                @if($periodo->id_activacion == 2)
                                <td>Finalizado</td>
                                <td>Finalizado</td>
                                @endif
                                    @if($periodo->id_activacion == 1)
                                        <td>Activo</td>
                                        <td>Activo</td>
                                    @endif
                                @else
                                @if($periodo->id_activacion == 0)
                                        <td>
                                            <button data-toggle="tooltip" data-placement="top" id="{{$periodo->id_peri_anteproyecto }}" title="Modificar periodo" class="btn btn btn-success h-primary_m pl-5 pr-5 modificar_periodo">Modificar periodo</button>
                                        </td>
                                        <td>
                                            <button data-toggle="tooltip" data-placement="top" id="{{$periodo->id_peri_anteproyecto }}" title="Activar periodo" class="btn btn btn-primary h-primary_m pl-5 pr-5 activar_periodo">Activar periodo</button>
                                        </td>
                                    @elseif($periodo->id_activacion == 2)
                                    <td>Finalizado</td>
                                    <td>Finalizado</td>
                                @else
                                    <td></td>
                                    <td></td>
                                @endif
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
                    <h4 class="modal-title" id="exampleModalLabel">Agregar periodo de requisiciones de materiales del anteproyecto </h4>
                </div>
                <div class="modal-body">

                    <form id="form_agregar" class="form" action="{{url("/presupuesto_anteproyecto/guardar_periodos_anteproyecto/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label>Seleccionar fecha inicial del periodo</label>
                                    <input class="form-control datepicker fecha_inicio"   type="text"  id="fecha_i" name="fecha_i" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label>Seleccionar fecha final del periodo</label>
                                    <input class="form-control datepicker fecha_final " type="text" id="fecha_f" name="fecha_f" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy">

                                </div>
                            </div>
                        </div>
                        <?php $year_actual = date("Y");
                        $year_actual =$year_actual+1;?>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label>Año de  requesiciones</label>
                                    <input class="form-control " type="text" id="year_actual" name="year_actual" value="{{ $year_actual }}" readonly>

                                </div>
                            </div>
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

    {{-- modal modificar periodo--}}

    <div class="modal fade" id="modal_modificacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar periodo de requisiciones de materiales del anteproyecto </h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_modificacion">

                    </div>

                     <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_modificacion_periodo"  class="btn btn-primary" >Guardar</button>
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
                    <h4 class="modal-title" id="exampleModalLabel">Activar periodo de requisiciones de materiales del anteproyecto </h4>
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

    <script type="text/javascript">
        $(document).ready( function() {
            $( '.fecha_inicio').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: '+0d',

            });
            $( '.fecha_final' ).datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: '+0d',
            });
            $("#guardar_periodo").click(function (){
                var fecha_i = $('#fecha_i').val();
               if(fecha_i != ''){
                   var fecha_f = $('#fecha_f').val();
                   if(fecha_f != ''){
                       $("#form_agregar").submit();
                       $("#guardar_periodo").attr("disabled", true);
                   }else{
                       swal({
                           position: "top",
                           type: "error",
                           title: "La fecha final no debe ser vacia",
                           showConfirmButton: false,
                           timer: 3500
                       });
                   }
               }else{
                   swal({
                       position: "top",
                       type: "error",
                       title: "La fecha inicial no debe ser vacia",
                       showConfirmButton: false,
                       timer: 3500
                   });
               }
            });
            $("#registros_periodos").on('click','.modificar_periodo',function(){
                var id_periodo =$(this).attr('id');

                $.get("/presupuesto_anteproyecto/modificar_periodos_anteproyecto/"+id_periodo,function (request) {
                    $("#contenedor_modificacion").html(request);
                    $("#modal_modificacion").modal('show');
                });
            });
            $("#guardar_modificacion_periodo").click(function (){
                $("#form_modificar_periodo").submit();
                $("#guardar_modificacion_periodo").attr("disabled", true);
            });
            $("#registros_periodos").on('click','.activar_periodo',function (){
                var id_periodo =$(this).attr('id');
                $.get("/presupuesto_anteproyecto/activar_periodo_anteproyecto/"+id_periodo,function (request) {
                    $("#contenedor_activar").html(request);
                    $("#modal_activar").modal('show');
                });
            });
            $("#guardar_activacion_periodo").click(function (){
                $("#form_activar_periodo").submit();
                $("#guardar_activacion_periodo").attr("disabled", true);
            });
            $(".finalizar_periodo").click(function (){
                $("#modal_finalizar_periodo").modal('show');
            });
            $(".modificar_periodo_activo").click(function (){
                var id_periodo =$(this).attr('id');
                $.get("/presupuesto_anteproyecto/modificar_periodos_anteproyecto/"+id_periodo,function (request) {
                    $("#contenedor_modificacion").html(request);
                    $("#modal_modificacion").modal('show');
                });
            });

        });
    </script>
@endsection
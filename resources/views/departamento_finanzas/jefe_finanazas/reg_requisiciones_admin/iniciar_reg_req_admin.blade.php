@extends('layouts.app')
@section('title', 'Requisicion de materiales')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/presupuesto_anteproyecto/proyecto_inicio_anteproyecto/".$proyecto->id_presupuesto)}}">Menu del proyecto del anteproyecto </a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Actividades de requisiciones del anteproyecto .</span>
            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Requisiciones de materiales del proyecto <br> {{$proyecto->nombre_proyecto}} del anteproyecto del {{ $proyecto->year }}</h3>
                </div>
            </div>
        </div>
    </div>
    @if($estado_registro == 0)
        <div class="row">
            <div class="col-md-4  col-md-offset-4 text-center">
                <div class="panel panel-success">
                    <div class="panel-body">
                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal_envia_requisicion">INICIAR REGISTRO DE REQUSICIONES DE MATERIALES</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-1 col-md-offset-2">
                <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nueva requisición de materiales" data-target="#modal_crear_requisicion" type="button" class="btn btn-primary btn-lg flotante">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
            </div>

            <p><br></p>
        </div>
        <div class="row">
            <div class="col-md-1">
                <p><br></p>
            </div>
        </div>
        @foreach($requisiciones2 as $requisicion)
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            @if($requisicion['id_autorizacion'] == 4)
                                <div class="row">
                                    <div class="col-md-4 col-md-offset-4">
                                        <div class="panel panel-success">
                                            <div class="panel-heading"><h4 style="text-align: center">Requisición autorizada</h4></div>

                                        </div>
                                    </div>
                                </div>

                            @else
                            <div class="row">
                                <div class="col-md-2 col-md-offset-10">
                                    <button title="Modificar requisicion de materiales" id="{{ $requisicion['id_actividades_req_ante'] }}"  class="btn btn-primary editar_requisiciones" >
                                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                    </button>
                                    <button title="Eliminar requisicion de materiales" id="{{ $requisicion['id_actividades_req_ante'] }}"  class="btn btn-danger eliminar_requisiciones" >
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <h4 style="text-align: center; color: #0c0c0c">PARTIDA PRESUPUESTAL: <b>{{ $requisicion['nombre_partida'] }}</b></h4>
                                    <h4 style="text-align: center; color: #0c0c0c">MES: <b>{{ $requisicion['mes'] }}</b></h4>
                                    <h5 style="text-align: center; color: #0c0c0c">JUSTIFICACIÓN: <b>{{ $requisicion['justificacion'] }}</b></h5>
                                    <h4 style="text-align: center; color: #0c0c0c">PROYECTO: <b>{{ $requisicion['nombre_proyecto'] }}</b></h4>
                                    <h5 style="text-align: center; color: #0c0c0c">META: <b>{{ $requisicion['meta'] }}</b></h5>
                                </div>
                            </div>
                            @if($requisicion['id_autorizacion'] == 4)
                                @else
                            <div class="row">
                                <div class="col-md-3 col-md-offset-4">
                                    <button class="btn btn-primary btn-lg" onclick="window.location='{{ url('/presupuesto_anteproyecto/agregar_bienes_servicios_ant_admin/'.$requisicion['id_actividades_req_ante'] ) }}'">Agregar documentación o bienes o servicios, etc.</button>
                                </div>

                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-10">
                                    <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th colspan="5" style="text-align: center">Documentación en pdf</th>
                                        </tr>
                                        <tr>
                                            <th>Requisición </th>
                                            <th>Anexo 1</th>
                                            <th>Oficio de suficiencia presupuestal</th>
                                            <th>Justificacion</th>
                                            <th>Cotización</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td style="text-align: center">
                                                @if($requisicion['requisicion_pdf'] == '')
                                                    No hay documento registrado
                                                @else

                                                    <a  target="_blank" href="/finanzas/requisiciones/{{ $requisicion['requisicion_pdf'] }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>

                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if($requisicion['anexo_1_pdf'] == '')
                                                    No hay documento registrado
                                                @else
                                                    <a  target="_blank" href="/finanzas/anexo1/{{ $requisicion['anexo_1_pdf'] }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>

                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if($requisicion['oficio_suficiencia_presupuestal_pdf'] == '')
                                                    No hay documento registrado
                                                @else
                                                    <a  target="_blank" href="/finanzas/oficio_suficiencia/{{ $requisicion['oficio_suficiencia_presupuestal_pdf'] }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if($requisicion['id_estado_justificacion'] == 0)
                                                    No se ha seleccionado respuesta
                                                @else
                                                    @if($requisicion['id_estado_justificacion'] == 1)
                                                        No
                                                    @else
                                                        <a  target="_blank" href="/finanzas/justificacion/{{ $requisicion['justificacion_pdf'] }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                                                    @endif

                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if($requisicion['cotizacion_pdf'] == '')
                                                    No hay documento registrado
                                                @else

                                                    <a  target="_blank" href="/finanzas/cotizaciones/{{ $requisicion['requisicion_pdf'] }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>

                                                @endif
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-md-10 col-md-offset-1">
                                                    <h5 style="text-align: center">BIENES O SERVICIOS, ETC.</h5>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-10 col-md-offset-1">
                                                    <p><br></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 col-md-offset-1">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>N. P</th>
                                                            <th>Descripcion</th>
                                                            <th>Unidad de medida</th>
                                                            <th>Cantidad</th>
                                                            <th>Precio unitario de referencia con IVA incluido</th>
                                                            <th>Importe</th>

                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i=1; ?>
                                                        @foreach($requisicion['servicios'] as $servicio)
                                                            <tr>
                                                                <td>{{ $i++ }}</td>
                                                                <td>{{ $servicio['descripcion'] }}</td>
                                                                <td>{{ $servicio['unidad_medida'] }}</td>
                                                                <td style="text-align: right;"><h3>{{ $servicio['cantidad'] }}</h3></td>
                                                                    <?php
                                                                    $precio_unitario=$servicio['precio_unitario'];
                                                                    $precio_unitario= money_format('%n',$precio_unitario);
                                                                    ?>
                                                                <td style="text-align: right;"><h3>{{ $precio_unitario}}</h3></td>
                                                                    <?php
                                                                    $importe=$servicio['importe'];
                                                                    $importe= money_format('%n',$importe);
                                                                    ?>
                                                                <td style="text-align: right;"><h3>{{ $importe }}</h3></td>


                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="5" style="text-align: right;"> <h3>Total importe</h3></td>
                                                                <?php

                                                                $total_req= money_format('%n',$requisicion['total_importe']);
                                                                ?>
                                                            <td  style="text-align: right;"> <h3>{{ $total_req }}</h3></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>

                @endforeach


        {{-- modal crear requisicion del proyecto--}}

        <div class="modal fade" id="modal_crear_requisicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar nueva requisición de materiales</h4>
                    </div>
                    <div class="modal-body">

                        <form id="form_agregar_requisicion" class="form" action="{{url("/presupuesto_anteproyecto/guardar_req_mat_admin/".$requerimiento_material->id_req_mat_ante)}}" role="form" method="POST" >
                            {{ csrf_field() }}
                            <input type="hidden" id="id_presupuesto" name="id_presupuesto" value="{{ $proyecto->id_presupuesto}}">

                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4>Nombre del proyecto: {{ $proyecto->nombre_proyecto }}</h4>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="dropdown">
                                        <label for="exampleInputEmail1">Elige mes de adquisición</label>
                                        <select class="form-control  "placeholder="selecciona una Opcion" id="id_mes" name="id_mes" required>
                                            <option disabled selected hidden>Selecciona una opción</option>
                                            @foreach($meses as $mes)
                                                <option value="{{$mes->id_mes}}" data-esta="{{$mes->mes}}">{{$mes->mes}} </option>
                                            @endforeach
                                        </select>
                                        <br>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 ">
                                    <div class="form-group">
                                        <label for="justificacion">Ingresa justificación</label>
                                        <textarea class="form-control" id="justificacion" name="justificacion" rows="3" placeholder="Ingresa juestificación" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="dropdown">
                                        <label for="exampleInputEmail1">Elige partida presupuestal</label>
                                        <select class="form-control  "placeholder="selecciona una Opcion" id="id_partida_pres" name="id_partida_pres" required>
                                            <option disabled selected hidden>Selecciona una opción</option>
                                            @foreach($partidas as $partida)
                                                <option value="{{$partida['id_partida_pres']}}" data-esta="{{$partida['nombre_partida']}}">{{$partida['clave_presupuestal']}} {{$partida['nombre_partida']}} </option>
                                            @endforeach
                                        </select>
                                        <br>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="dropdown">
                                        <label for="exampleInputEmail1">Elige partida presupuestal</label>
                                        <select class="form-control  "placeholder="selecciona una Opcion" id="id_meta" name="id_meta" required>
                                            <option disabled selected hidden>Selecciona una opción</option>
                                            @foreach($metas as $meta)
                                                <option value="{{$meta->id_meta}}" data-esta="{{$meta->meta}}">{{$meta->meta}} </option>
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
                            <button id="guardar_partida_presupuestal"  class="btn btn-primary" >Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- fin del modal crear requisicion del proyecto--}}
    @endif
    {{--modal de registro de requisiciones--}}
    <div class="modal fade" id="modal_envia_requisicion" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Notificación de inicio de registro de requisiciones</h4>
                </div>
                <form id="form_envio" class="form" action="{{url("/presupuesto_anteproyecto/registrar_inicio_req_ant_admin/".$proyecto->id_presupuesto)}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>Iniciar registro de requisiciones de materiales </p>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_envio"  class="btn btn-primary" >Aceptar</button>
                </div>
            </div>

        </div>
    </div>
    {{-- modal fin de registro de requisiciones--}}

                {{-- modal modificar requisicion de materiales--}}

                <div class="modal fade" id="modal_mod_req" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel">Modificar requisicion de materiales</h4>
                            </div>
                            <div class="modal-body">
                                <div id="contenedor_mod_req">

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button id="guardar_mod_req"  class="btn btn-primary" >Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- fin modal modificar requisicion de materiales--}}

                {{-- modal eliminar requisicion de materiales--}}

                <div class="modal fade" id="modal_eliminar_req" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel">Eliminar requisicion de materiales</h4>
                            </div>
                            <div class="modal-body">
                                <div id="contenedor_eliminar_req">

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button id="guardar_eliminar_req"  class="btn btn-primary" >Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--fin modal eliminar requisicion--}}


                                <script type="text/javascript">
                                    $(document).ready( function() {
                                        $("#guardar_envio").click(function (){
                                            $("#form_envio").submit();
                                            $("#guardar_envio").attr("disabled", true);
                                        });
                                        $(".editar_requisiciones").click(function (){
                                            var id_actividades_req_ante =$(this).attr('id');

                                            $.get("/presupuesto_anteproyecto/mod_requisicion_mat_admin/"+id_actividades_req_ante+"/{{ $proyecto->id_presupuesto }}",function (request) {
                                                $("#contenedor_mod_req").html(request);
                                                $("#modal_mod_req").modal('show');
                                            });
                                        });
                                        $("#guardar_partida_presupuestal").click(function (){
                                            var id_mes = $("#id_mes").val();
                                            if(id_mes != null){
                                                var justificacion = $("#justificacion").val();
                                                if(justificacion !=''){
                                                    var id_partida_pres = $("#id_partida_pres").val();
                                                    if(id_partida_pres != null){
                                                        var id_meta = $("#id_meta").val();
                                                        if(id_meta != null){
                                                            $("#form_agregar_requisicion").submit();
                                                            $("#guardar_partida_presupuestal").attr("disabled", true);
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
                                                                title: "Selecciona meta",
                                                                showConfirmButton: false,
                                                                timer: 3500
                                                            });
                                                        }
                                                    }else{
                                                        swal({
                                                            position: "top",
                                                            type: "error",
                                                            title: "Selecciona partida presupuestal",
                                                            showConfirmButton: false,
                                                            timer: 3500
                                                        });
                                                    }

                                                }else{
                                                    swal({
                                                        position: "top",
                                                        type: "error",
                                                        title: "Ingresa justificación",
                                                        showConfirmButton: false,
                                                        timer: 3500
                                                    });
                                                }

                                            }else{
                                                swal({
                                                    position: "top",
                                                    type: "error",
                                                    title: "Selecciona mes",
                                                    showConfirmButton: false,
                                                    timer: 3500
                                                });
                                            }
                                        });
                                        $("#guardar_mod_req").click(function (){
                                            $("#form_modificar_requisicion").submit();
                                            $("#guardar_mod_req").attr("disabled", true);
                                        });
                                        $(".eliminar_requisiciones").click(function (){
                                            var id_actividades_req_ante =$(this).attr('id');

                                            $.get("/presupuesto_anteproyecto/eliminar_requisicion_material/"+id_actividades_req_ante,function (request) {
                                                $("#contenedor_eliminar_req").html(request);
                                                $("#modal_eliminar_req").modal('show');
                                            });

                                        });
                                        $("#guardar_eliminar_req").click(function (){

                                            $("#form_eliminar_requisicion").submit();
                                            $("#guardar_eliminar_req").attr("disabled", true);
                                            swal({
                                                position: "top",
                                                type: "warning",
                                                title: "Eliminacion exitosa",
                                                showConfirmButton: false,
                                                timer: 3500
                                            });
                                        });
                                    });
                                </script>


                    @endsection
@extends('layouts.app')
@section('title', 'Requisiciones del departamento')
@section('content')
    <div class="row">
        <div class="col-md-6  col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h5 style="text-align:center">Agregar presupuesto a la requisición del departamento o jefatura de división  del año {{ $year }}</h5>
                    <h5 style="text-align: center">Nombre del departamento o jefatura: {{ $unidad->nom_departamento }}</h5>
                    <h5 style="text-align: center">Nombre del jefe: {{ $unidad->titulo }} {{ $unidad->nombre }}</h5>
                </div>
            </div>
        </div>
    </div>

    @if($estado_anteproyecto == 1)
        <div class="row">
            <div class="col-md-6  col-md-offset-3">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                       <h4 style="text-align: center">Sin requisiciones autorizadas del anteproyecto {{ $year }}</h4>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($estado_anteproyecto == 2)
    <div class="row">
        <div class="col-md-10  col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 style="text-align: center">Requisiciones autorizadas del anteproyecto {{ $year }}</h4>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>CLAVE PRESUPUESTAL</th>
                            <th>DENOMINACIÓN</th>
                            <th>MATERIALES O SERVICIO</th>
                            <th>TOTAL</th>
                            <th>MES</th>
                            <th>AUTORIZAR</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($array_requisiciones as $requisicion)
                        <tr>
                            <td>{{ $requisicion['clave_presupuestal'] }}</td>
                            <td>{{ $requisicion['nombre_partida'] }}</td>
                            <td>
                                    <?php
                                    $total_req=0;
                                    ?>
                                    @foreach($requisicion['materiales'] as $material)
                                        <?php
                                            $importe=$material['cantidad']*$material['precio_unitario'];
                                        $total_req=$total_req+$importe;
                                        ?>
                                    <div class="alert alert-success"><b style="color: black">Materiales o servicios:  </b> <i style="font-size: 16px; color: blue">{{ $material['descripcion'] }}</i> <b style="color: black">Cantidad:  </b> <i style="font-size: 18px; color: blue">{{ $material['cantidad'] }} </i><b style="color: black; ">Precio unitario: </b> <i style="font-size: 18px; color: blue">{{ number_format($material['precio_unitario'], 2, '.', ',')  }}</i> <b style="color: red">Importe:</b><i style="font-size: 18px; color: blue">{{ number_format($importe, 2, '.', ',')  }}</i></div>
                                    @endforeach
                                </ul>
                            </td>
                            <td><b>{{ number_format($total_req, 2, '.', ',')  }}</b>
                            </td>
                                @if($requisicion['id_mes'] == 1)
                                    <td>Enero</td>
                                @endif
                                @if($requisicion['id_mes'] == 2)
                                    <td>Febrero</td>
                                @endif
                                @if($requisicion['id_mes'] == 3)
                                    <td>Marzo</td>
                                @endif
                                @if($requisicion['id_mes'] == 4)
                                    <td>Abril</td>
                                @endif
                                @if($requisicion['id_mes'] == 5)
                                    <td>Mayo</td>
                                @endif
                                @if($requisicion['id_mes'] == 6)
                                    <td>Junio</td>
                                @endif
                                @if($requisicion['id_mes'] == 7)
                                    <td>Julio</td>
                                @endif
                                @if($requisicion['id_mes'] == 8)
                                    <td>Agosto</td>
                                @endif
                                @if($requisicion['id_mes'] == 9)
                                    <td>Septiembre</td>
                                @endif
                                @if($requisicion['id_mes'] == 10)
                                    <td>Octubre</td>
                                @endif
                                @if($requisicion['id_mes'] == 11)
                                    <td>Noviembre</td>
                                @endif
                                @if($requisicion['id_mes'] == 12)
                                    <td>Diciembre</td>
                                @endif
                            <td> <button data-toggle="tooltip" data-placement="top" id="{{$requisicion['id_actividades_req_ante'] }}" title="Autorizar requisición" class="btn btn btn-success h-primary_m  autorizar_req">Autorizar requisición</button>
                            </td>

                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
<div class="row">
    <div class="col-md-6">
        <p><br></p>
    </div>
</div>
    <div class="row">
        <div class="col-md-1 col-md-offset-2">
            <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nueva solicitud" data-target="#modal_agregar_solicitud" type="button" class="btn btn-success btn-lg flotante">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p><br></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-body">
                    <h4 style="text-align: center">Solicitudes de partidas presupuestales</h4>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>NO. SOLICITUD</th>
                            <th>PARTIDAS PRESUPUESTALES</th>
                            <th>TOTAL</th>
                            <th>ENVIAR</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($array_solicitudes as $solicitud)
                        <tr>

                            <td style=" ">
                                @if($solicitud['id_estado_enviado'] == 0)
                                <p style="text-align:right "> <button class="eliminar_solicitud"  data-id="{{ $solicitud['id_solicitud']}}"><span class="glyphicon glyphicon-trash em8"data-toggle="tooltip" title="Eliminar solicitud" style="color: red" aria-hidden="true"></span></button></p>
                                @endif
                                NÚMERO DE SOLICITUD: <b>{{ $solicitud['numero_solicitud'] }}</b> <br>
                            NOMBRE DEL PROYECTO: <b>{{ $solicitud['nombre_proyecto'] }} </b><br>
                            MES: <b>{{ $solicitud['mes'] }} </b><br>
                            META: <b>{{ $solicitud['meta'] }}</b><br>
                            DESCRIPCIÓN DE LA SOLICITUD: <b>{{ $solicitud['descripcion_solicitud'] }}</b>


                        </td>
                        <td>
                            @if($solicitud['id_estado_enviado'] == 0)
                            <p style="text-align: right">  <button title="Agregar partida presupuestal" id="{{ $solicitud['id_solicitud'] }}"   type="button" class="btn btn-success agregar_partida">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </button></p>
                            @endif
                                @if($solicitud['contar_partidas'] == 0)
                                    <?php $suma_total=0; ?>
                                 <p><div class="alert alert-danger">
                               No se ha agregado ninguna partida.
                                </div></p>
                                @else
                                    <?php $suma_total=0; ?>
                                @foreach($solicitud['partidas'] as $partida)
                                        <?php $suma_total=$suma_total+$partida['presupuesto_dado']; ?>
                                    <div class="panel panel-success">
                                        <div class="panel-body" style="background: #e6ebf5">
                                            <p>{{ $partida['clave_presupuestal'] }} {{ $partida['nombre_partida'] }}</p>
                                            @if($partida['id_tipo_requisicion'] == 1)
                                                <p>PRESUPUESTO PEDIDO: <b>${{ number_format( $partida['importe_total'], 2, '.', ',')}}</b></p>
                                            @endif
                                            <p>PRESUPUESTO DADO: <b>${{ number_format( $partida['presupuesto_dado'], 2, '.', ',')}}</b>
                                                @if($solicitud['id_estado_enviado'] == 0)
                                                <a class="editar" data-id="{{ $partida['id_solicitud_partida']}}"><span class="glyphicon glyphicon-edit em2" aria-hidden="true"></span></a>
                                                @endif
                                            </p>
                                            <p>TIPO DE SOLICITUD: @if($partida['id_tipo_requisicion'] == 1)<b>ANTEPROYECTO</b>@endif @if($partida['id_tipo_requisicion'] == 2)<b>PROYECTO AUTORIZADO</b>@endif
                                            </p>
                                            @if($solicitud['id_estado_enviado'] == 0)
                                            <p style="text-align: center"> <button class="eliminar" data-id="{{ $partida['id_solicitud_partida']}}"><span class="glyphicon glyphicon-trash em8"data-toggle="tooltip" title="Eliminar partida" style="color: red" aria-hidden="true"></span></button></p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                @endif
                        </td>
                        <td> <b>${{   number_format( $suma_total, 2, '.', ',')}} </b></td>
                            @if($solicitud['id_estado_enviado'] == 0)
                        <td><button data-toggle="tooltip" data-placement="top" id="{{$solicitud['id_solicitud'] }}" title="Enviar solicitud" class="btn btn btn-primary h-primary_m  enviar_solicitud">Enviar solicitud</button>
                        </td>
                            @endif
                            @if($solicitud['id_estado_enviado'] == 1)
                                <td>Se envio correctamente la solicitud</td>
                            @endif

                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- modal autorizacion de requisición--}}

    <div class="modal  fade" id="modal_aut_req" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Autorizar requisición</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_aut_req">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="aceptar_aut_req"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal agregar solicitud--}}

    <div class="modal fullscreen-modal fade" id="modal_agregar_solicitud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar solicitud</h4>
                </div>
                <div class="modal-body">
                    <form id="form_guardar_nueva_solicitud" class="form" action="{{url("/presupuesto_autorizado/guardar_nueva_solicitud/".$year."/".$id_unidad_admin )}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label>Ingresar descripcion solicitud</label>
                                    <textarea class="form-control" id="descripcion_solicitud" name="descripcion_solicitud" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="dropdown">
                                    <label for="exampleInputEmail1">Selecciona mes</label>
                                    <select class="form-control  "placeholder="selecciona una Opcion" id="id_mes" name="id_mes" required>
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($meses as $mes)
                                            <option value="{{ $mes->id_mes }}" data-esta="{{ $mes->mes }}">{{ $mes->mes }} </option>
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
                                    <label for="exampleInputEmail1">Selecciona proyecto</label>
                                    <select class="form-control  "placeholder="selecciona una Opcion" id="id_proyecto" name="id_proyecto" required>
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($proyectos as $proyecto)
                                            <option value="{{ $proyecto->id_proyecto }}" data-esta="{{ $proyecto->nombre_proyecto }}">{{ $proyecto->nombre_proyecto }} </option>
                                        @endforeach
                                    </select>
                                    <br>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 ">

                                <label for="exampleInputEmail1">Selecciona meta</label>
                                <div id="meta">

                                </div>

                            </div>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_agregar_solicitud"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal agregar partida--}}

    <div class="modal fullscreen-modal fade" id="modal_agregar_partida" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar partida presupuestal a la solicitud</h4>
                </div>
                <div class="modal-body">
                    <form id="form_agregar_partida_solicitud" class="form" action="{{url("/presupuesto_autorizado/guardar_partida_solicitud/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                    <div id="contenedor_agregar_partida">

                    </div>
                    </form>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="aceptar_agregar_partida"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal enviar solicitud--}}

    <div class="modal fullscreen-modal fade" id="modal_enviar_solicitud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Enviar solicitud</h4>
                </div>
                <div class="modal-body">

                        <div id="contenedor_enviar_solicitud">

                        </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="aceptar_enviar_solicitud"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal editar presupuesto--}}

    <div class="modal fullscreen-modal fade" id="modal_editar_pre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Editar presupuesto dado</h4>
                </div>
                <div class="modal-body">

                    <div id="contenedor_editar_pre">

                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="aceptar_editar_pre"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal eliminar partida--}}

    <div class="modal fullscreen-modal fade" id="modal_eliminar_partida" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Eliminar partida presupuestal de la solicitud</h4>
                </div>
                <div class="modal-body">

                    <div id="contenedor_eliminar_partida">

                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="aceptar_eliminar_partida_sol"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal eliminar solicitud--}}

    <div class="modal fullscreen-modal fade" id="modal_eliminar_solicitud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Eliminar solicitud</h4>
                </div>
                <div class="modal-body">

                    <div id="contenedor_eliminar_solicitud">

                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="aceptar_eliminar_solicitud"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".eliminar_solicitud").click(function (){
                var id_solicitud = $(this).data('id');

                $.get("/presupuesto_autorizado/eliminacion_solicitud/" + id_solicitud, function (request) {
                    $("#contenedor_eliminar_solicitud").html(request);
                    $("#modal_eliminar_solicitud").modal('show');
                });
            });
            $("#aceptar_eliminar_solicitud").click(function (){
                $("#form_guardar_eliminacion_solicitud").submit();
                $("#aceptar_eliminar_solicitud").attr("disabled", true);
            });

            $("#aceptar_eliminar_partida_sol").click(function (){
                $("#form_eliminar_partida_solicitud").submit();
                $("#aceptar_eliminar_partida_sol").attr("disabled", true);
            });
            $(".eliminar").click(function (){
                var id_solicitud_partida = $(this).data('id');
                $.get("/presupuesto_autorizado/eliminacion_partida_solicitud/" + id_solicitud_partida, function (request) {
                    $("#contenedor_eliminar_partida").html(request);
                    $("#modal_eliminar_partida").modal('show');
                });
            });

            $("#aceptar_editar_pre").click(function (){
                var estado_pre = $('#estado_pre').val();

                if(estado_pre == 1){
                    swal({
                        position: "top",
                        type: "error",
                        title: "No hay presupuesto en el mes en esta partida",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
                if(estado_pre == 2){
                    var resto_pres =$('#resto_pres').val();
                    var pres_dar =$('#pres_dar').val();
                     var resta_presupuesto = resto_pres - pres_dar;
                    if( resta_presupuesto < 0 ){
                        swal({
                            position: "top",
                            type: "error",
                            title: "No alcanza el presupuesto autorizado del mes de esta partida",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    } else{
                        $("#form_guardar_presupuesto_dado").submit();
                        $("#aceptar_editar_pre").attr("disabled", true);

                    }
                }



            });
            $(".editar").click(function () {
                var id_solicitud_partida = $(this).data('id');

                $.get("/presupuesto_autorizado/editar_presupuesto_partida_dep/" + id_solicitud_partida, function (request) {
                    $("#contenedor_editar_pre").html(request);
                    $("#modal_editar_pre").modal('show');
                });
            });
            $("#id_proyecto").change(function (e) {

                var id_proyecto = e.target.value;
                $.get('/presupuesto_anteproyecto/ver_meta/' + id_proyecto, function (data) {

                    $('#meta').empty();
                    $.each(data, function (datos_alumno, subcatObj) {
                        //   alert(subcatObj);
                        $('#meta').append('<div class="radio"><label><input class="form-check-input"  type="radio" name="meta1" value="'+subcatObj.id_meta+'" required>'+subcatObj.meta+'</label></div>');

                    });
                });
            });

            $(".enviar_solicitud").click(function (){
                var id_solicitud = $(this).attr('id');
                $.get("/presupuesto_autorizado/enviar_solicitud_departamento/"+id_solicitud,function (request) {
                    $("#contenedor_enviar_solicitud").html(request);
                    $("#modal_enviar_solicitud").modal('show');
                });
            });
            $("#aceptar_enviar_solicitud").click(function (){
                var contar_req = $('#contar_req').val();
                var presupuesto_dado = $('#presupuesto_dado').val();
                if( contar_req == 0){
                    swal({
                        position: "top",
                        type: "error",
                        title: "No tiene requisiciones registradas",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }else{
                    if(presupuesto_dado > 0){
                        swal({
                            position: "top",
                            type: "error",
                            title: "No se le ha agregado presupuesto alguna requisición",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else{
                        $("#form_enviar_partida_solicitud").submit();
                        $("#aceptar_enviar_solicitud").attr("disabled", true);
                    }

                }

            })
            $(".autorizar_req").click(function () {

                var id_actividades_req_ante = $(this).attr('id');
                $.get("/presupuesto_autorizado/departamento_ver_pres_autorizar/"+id_actividades_req_ante,function (request) {
                    $("#contenedor_aut_req").html(request);
                    $("#modal_aut_req").modal('show');
                });

            });
            $("#aceptar_aut_req").click(function (){
                var des_solicitud = $('#des_solicitud').val();

                if(des_solicitud != '')
                {
                    $("#form_guardar_aut_req").submit();
                    $("#aceptar_aut_req").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Ingresar descripción de la solicitud",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            });
            $("#guardar_agregar_solicitud").click(function (){
                var id_proyecto = $('#id_proyecto').val();
                var descripcion_solicitud = $('#descripcion_solicitud').val();
                var id_mes = $('#id_mes').val();
                var id_meta = $('input:radio[name=meta1]:checked').val();


                    if(descripcion_solicitud == ''){
                        swal({
                            position: "top",
                            type: "error",
                            title: "Ingresar descripción de la solicitud",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {
                        if(id_mes == null){
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona  mes",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }else{
                        if(id_proyecto == null){
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona  proyecto",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }else {
                            if (id_meta != undefined) {
                                $("#form_guardar_nueva_solicitud").submit();
                                $("#guardar_agregar_solicitud").attr("disabled", true);
                            } else {
                                swal({
                                    position: "top",
                                    type: "error",
                                    title: "Selecciona meta",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }
                        }
                    }
                }

            });
            $(".agregar_partida").click(function (){
                var id_solicitud = $(this).attr('id');
                $.get("/presupuesto_autorizado/agregar_partida_solicitud/"+id_solicitud,function (request) {
                    $("#contenedor_agregar_partida").html(request);
                    $("#modal_agregar_partida").modal('show');
                });
            });
            $("#aceptar_agregar_partida").click(function (){

                var id_presupuesto_aut_copia = $('#id_presupuesto_aut_copia').val();

                var id_estado_sobrante = $('#id_estado_sobrante').val();

                var presupuesto_s = $('#presupuesto_s').val();
                var presupuesto_dar = $('#presupuesto_dar').val();


                    if (id_presupuesto_aut_copia == null) {
                        swal({
                            position: "top",
                            type: "error",
                            title: "Selecciona  partida presupuestal",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    } else {

                            if (id_estado_sobrante == 2) {
                                swal({
                                    position: "top",
                                    type: "error",
                                    title: "No alcanza el presupuesto",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }
                            if (id_estado_sobrante == 1) {
                                var var_resultado = presupuesto_s - presupuesto_dar;
                                if (var_resultado >= 0 ) {
                                    if(presupuesto_dar != '') {
                                        $("#form_agregar_partida_solicitud").submit();
                                        $("#aceptar_agregar_partida").attr("disabled", true);
                                    } else {
                                        swal({
                                            position: "top",
                                            type: "error",
                                            title: "Ingresa el presupuesto a dar",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }

                                } else {
                                    swal({
                                        position: "top",
                                        type: "error",
                                        title: "No alcanza el presupuesto",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }
                    }
                }
            });
        });
    </script>


@endsection
@extends('layouts.app')
@section('title', 'Actividades de requisiciones del anteproyecto')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/presupuesto_anteproyecto/autorizados_mod_jefe_depart")}}">Requisiciones de los departamentos </a>
                 <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Requisiciones revisadas</span>
            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">REQUISICIONES REVISADAS <br>
                        (NOMBRE DEL JEFE(A) DEL DEPARTAMENTO O JEFATURA: <b>{{ $datos_jefe->titulo }} {{ $datos_jefe->nombre }})</b><br>
                        (NOMBRE DEL DEPARTAMENTO O JEFATURA: <b>{{ $datos_jefe->nom_departamento }}</b></h3>
                </div>
            </div>
        </div>
        <br>
    </div>
    <?php setlocale(LC_MONETARY, 'es_MX');

    ?>

    <div class="row">
        <div class="col-md-2 col-md-offset-2">
            <p></p>
        </div>
    </div>

    @foreach($requisiciones2 as $requisicion)
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-warning">
                    <div class="panel-heading">

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <h4 style="text-align: center; color: #0c0c0c">PARTIDA PRESUPUESTAL: <b>{{ $requisicion['nombre_partida'] }}</b></h4>
                                <h4 style="text-align: center; color: #0c0c0c">MES: <b>{{ $requisicion['mes'] }}</b></h4>
                                <h5 style="text-align: center; color: #0c0c0c">JUSTIFICACIÓN: <b>{{ $requisicion['justificacion'] }}</b></h5>
                                <h4 style="text-align: center; color: #0c0c0c">PROYECTO: <b>{{ $requisicion['nombre_proyecto'] }}</b></h4>
                                <h5 style="text-align: center; color: #0c0c0c">META: <b>{{ $requisicion['meta'] }}</b></h5>
                            </div>
                        </div>
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
                                        <th colspan="4" style="text-align: center">Documentación en pdf</th>
                                    </tr>
                                    <tr>
                                        <th>Requisición </th>
                                        <th>Anexo 1</th>
                                        <th>Oficio de suficiencia presupuestal</th>
                                        <th>Justificación</th>
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
                                                <a  target="_blank" href="/finanzas/cotizaciones/{{ $requisicion['cotizacion_pdf'] }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
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
                                                        <th>Descripción</th>
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
                                                            $precio_unitario= "$".number_format($precio_unitario, 2, '.', ',');
                                                            ?>
                                                            <td style="text-align: right;"><h3>{{ $precio_unitario}}</h3></td>
                                                            <?php
                                                            $importe=$servicio['importe'];
                                                            $importe= "$".number_format($importe, 2, '.', ',');
                                                            ?>
                                                            <td style="text-align: right;"><h3>{{ $importe }}</h3></td>


                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="5" style="text-align: right;"> <h3>Total importe</h3></td>
                                                        <?php

                                                        $total_req= "$".number_format($requisicion['total_importe'], 2, '.', ',');
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

            <div class="row">
                <div class="col-md-10">
                    <br>
                </div>
            </div>




            {{-- modal crear proyecto--}}

            <div class="modal fade" id="modal_crear_requisicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Agregar nueva requisición de materiales</h4>
                        </div>
                        <div class="modal-body">

                            <form id="form_agregar" class="form" action="{{url("/presupuesto_anteproyecto/guardar_requisicion_materiales/".$datos_req_envio->id_req_mat_ante)}}" role="form" method="POST" >
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="dropdown">
                                            <label for="exampleInputEmail1">Elige mes de adquisición</label>
                                            <select class="form-control  "placeholder="selecciona una Opcion" id="mes" name="mes" required>
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
                                            <label for="exampleInputEmail1">Elige proyecto</label>
                                            <select class="form-control  "placeholder="selecciona una Opcion" id="proyecto" name="proyecto" required>
                                                <option disabled selected hidden>Selecciona una opción</option>
                                                @foreach($proyectos as $proyecto)
                                                    <option value="{{$proyecto->id_proyecto}}" data-esta="{{$proyecto->nombre_proyecto }}">{{ $proyecto->nombre_proyecto }} </option>
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
                                            <select class="form-control  "placeholder="selecciona una Opcion" id="partida_presupuestal" name="partida_presupuestal" required>
                                                <option disabled selected hidden>Selecciona una opción</option>

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
                                <button id="guardar_partida_presupuestal"  class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- modal modificar requisicion de materiales--}}

            <div class="modal fade" id="modal_modificacion_requisicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Modificar requisicion de materiales</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_modificacion_requisicion">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_modificacion_requisicion"  class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- modal eliminae requisicion de materiales--}}

            <div class="modal fade" id="modal_eliminar_requisicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Eliminar requisicion de materiales</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_eliminar_requisicion">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_eliminar_requisicion"  class="btn btn-primary" >Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- modal enviar requisiciones --}}

            <div class="modal fade" id="modal_enviar_requisiciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Enviar requisiciones</h4>
                        </div>
                        <div class="modal-body">
                            <form id="form_enviar_requisiciones" action="{{url("/presupuesto_anteproyecto/enviar_requisiciones/")}}" method="POST" role="form" >
                                {{ csrf_field() }}
                                <input type="hidden" id="id_req_mat_ante" name="id_req_mat_ante" value="">
                                <h2 style="text-align: center;">¿ Seguro(a) que quieres enviar las requiciones a la Dirección de administración y finanzas</h2>
                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_enviar_requisiciones"  class="btn btn-primary" >Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <script>
                $(document).ready(function() {
                    $(".enviar_requisiciones").click(function (){
                        var id_req_mat_ante =$(this).attr('id');
                        $('#id_req_mat_ante').val(id_req_mat_ante);
                        $("#modal_enviar_requisiciones").modal('show');
                    });
                    $("#guardar_enviar_requisiciones").click(function (){
                        $("#form_enviar_requisiciones").submit();
                        $("#guardar_enviar_requisiciones").attr("disabled", true);
                    });
                    $(".eliminar_bien_servicio").click(function (){
                        var id_reg_material_ant =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/eliminar_servicio/"+id_reg_material_ant,function (request) {
                            $("#contenedor_eliminar_servicio").html(request);
                            $("#modal_eliminar_servicio").modal('show');
                        });
                    });
                    $("#guardar_eliminar_servicio").click(function (){
                        $("#form_mod_bien").submit();
                        $("#guardar_eliminar_servicio").attr("disabled", true);
                    });
                    $(".agregar_bien").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $('#id_act_req_ante').val(id_actividades_req_ante);
                        $('#modal_crear_bien').modal('show');
                    });
                    $(".editar_bien_servicio").click(function (){
                        var id_reg_material_ant =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/modificar_servicio/"+id_reg_material_ant,function (request) {
                            $("#contenedor_mod_servicio").html(request);
                            $("#modal_mod_servicio").modal('show');
                        });

                    });
                    $("#guardar_mod_servicio").click(function (){
                        var bien_servicio = $("#bien_servicio_mod").val();
                        if(bien_servicio != ''){
                            var unidad_medida = $("#unidad_medida_mod").val();
                            if( unidad_medida != ''){

                                var cantidad = $("#cantidad_mod").val();

                                if ( cantidad != ''){

                                    var precio = $("#precio_mod").val();
                                    if ( precio != ''){

                                        $("#form_mod_bien").submit();
                                        $("#guardar_mod_servicio").attr("disabled", true);
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
                                            title: "Ingresa precio unitario de referencia con iva incluido",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }

                                }else{
                                    swal({
                                        position: "top",
                                        type: "error",
                                        title: "Ingresa cantidad correcta",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }

                            }else{
                                swal({
                                    position: "top",
                                    type: "error",
                                    title: "Ingresa unidad de medida",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }
                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Ingresar el nombre del bien o servicio",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $("#guardar_bien").click(function (){
                        var bien_servicio = $("#bien_servicio").val();
                        if(bien_servicio != ''){
                            var unidad_medida = $("#unidad_medida").val();
                            if( unidad_medida != ''){

                                var cantidad = $("#cantidad").val();

                                if ( cantidad != ''){

                                    var precio = $("#precio").val();
                                    if ( precio != ''){

                                        $("#form_agregar_bien").submit();
                                        $("#guardar_bien").attr("disabled", true);
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
                                            title: "Ingresa precio unitario de referencia con iva incluido",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }

                                }else{
                                    swal({
                                        position: "top",
                                        type: "error",
                                        title: "Ingresa cantidad correcta",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }

                            }else{
                                swal({
                                    position: "top",
                                    type: "error",
                                    title: "Ingresa unidad de medida",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }
                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Ingresar el nombre del bien o servicio",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $("#proyecto").change(function (e) {

                        var id_proyecto = e.target.value;
                        $.get('/presupuesto_anteproyecto/ver_partida_presupuestal/'+id_proyecto,function(data){

                            $('#partida_presupuestal').empty();
                            $.each(data,function(datos_alumn,subcatObj){
                                //  alert(subcatObj);
                                $('#partida_presupuestal').append('<option value="'+subcatObj.id_partida_pres+'" data-muni="'+subcatObj.nombre_partida+'" >'+subcatObj.clave_presupuestal+' '+subcatObj.nombre_partida+'</option>');
                            });
                        });
                        $('#meta').empty();
                        $.get('/presupuesto_anteproyecto/ver_partida_presupuestal/' + id_proyecto, function (data) {


                            $.each(data, function (datos_alumno, subcatObj) {
                                //   alert(subcatObj);
                                $('#meta').append('<div class="radio"><label><input class="form-check-input"  type="radio" name="meta1" value="'+subcatObj.id_meta+'" required>'+subcatObj.meta+'</label></div>');

                            });
                        });
                        $.get('/presupuesto_anteproyecto/ver_meta/' + id_proyecto, function (data) {

                            $('#meta').empty();
                            $.each(data, function (datos_alumno, subcatObj) {
                                //   alert(subcatObj);
                                $('#meta').append('<div class="radio"><label><input class="form-check-input"  type="radio" name="meta1" value="'+subcatObj.id_meta+'" required>'+subcatObj.meta+'</label></div>');

                            });
                        });
                    });
                    $("#guardar_partida_presupuestal").click(function (){
                        var partida_presupuestal = $("#partida_presupuestal").val();
                        if(partida_presupuestal != null){
                            var mes = $("#mes").val();
                            if( mes != null){
                                var justificacion = $("#justificacion").val();
                                if(justificacion != ''){
                                    var proyecto = $("#proyecto").val();
                                    if( proyecto != null){
                                        var meta1 =$('input:radio[name=meta1]:checked').val();

                                        if(meta1 != undefined){
                                            $("#form_agregar").submit();
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
                                            title: "Selecciona proyecto",
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
                            }
                            else{
                                swal({
                                    position: "top",
                                    type: "error",
                                    title: "Selecciona mes",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }

                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Agregar partida presupuestal",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $(".editar_requisiciones").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');

                        $.get("/presupuesto_anteproyecto/modificar_requisicion_material/"+id_actividades_req_ante+"/{{ $datos_req_envio->year_requisicion }}",function (request) {
                            $("#contenedor_modificacion_requisicion").html(request);
                            $("#modal_modificacion_requisicion").modal('show');
                        });
                    });

                    $(".eliminar_requisiciones").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');

                        $.get("/presupuesto_anteproyecto/eliminar_requisicion_material/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_eliminar_requisicion").html(request);
                            $("#modal_eliminar_requisicion").modal('show');
                        });

                    });
                    $("#guardar_modificacion_requisicion").click(function (){
                        var partida_presupuestal = $("#partida_presupuestal_mod").val();
                        if(partida_presupuestal != ''){
                            var mes = $("#mes_mod").val();
                            if( mes != null){
                                justificacion_mod
                                var justificacion = $("#justificacion_mod").val();
                                if(justificacion != '') {
                                    var proyecto = $("#proyecto_mod").val();
                                    if (proyecto != null) {
                                        var meta1 = $('input:radio[name=meta_mod]:checked').val();

                                        if (meta1 != undefined) {
                                            $("#form_modificar_requisicion").submit();
                                            $("#guardar_modificacion_requisicion").attr("disabled", true);
                                            swal({
                                                position: "top",
                                                type: "success",
                                                title: "Registro exitoso",
                                                showConfirmButton: false,
                                                timer: 3500
                                            });
                                        } else {
                                            swal({
                                                position: "top",
                                                type: "error",
                                                title: "Selecciona meta",
                                                showConfirmButton: false,
                                                timer: 3500
                                            });
                                        }
                                    } else {
                                        swal({
                                            position: "top",
                                            type: "error",
                                            title: "Selecciona proyecto",
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
                            }
                            else{
                                swal({
                                    position: "top",
                                    type: "error",
                                    title: "Selecciona mes",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }

                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Agregar partida presupuestal",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $("#guardar_eliminar_requisicion").click(function (){

                        $("#form_eliminar_requisicion").submit();
                        $("#guardar_eliminar_requisicion").attr("disabled", true);
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Eliminacion exitosa",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    });
                    $(".agregar_requisicion").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/agregar_requisicion_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_agregar_requisicion_pdf").html(request);
                            $("#modal_agregar_requisicion_pdf").modal('show');
                        });

                    });
                    $("#guardar_requisicion_pdf").click(function (){
                        var requisicion_pdf = $("#requisicion_pdf").val();
                        if( requisicion_pdf != ''){
                            $("#form_guardar_req_pdf").submit();
                            $("#guardar_requisicion_pdf").attr("disabled", true);
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
                                title: "Selecciona documento pdf",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }

                    });
                    $(".agregar_anexo1").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/agregar_anexo1_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_agregar_anexo1_pdf").html(request);
                            $("#modal_agregar_anexo1_pdf").modal('show');
                        });
                    });
                    $("#guardar_anexo1_pdf").click(function (){
                        var anexo1_pdf = $("#anexo1_pdf").val();
                        if( anexo1_pdf != ''){
                            $("#form_guardar_anexo1_pdf").submit();
                            $("#guardar_anexo1_pdf").attr("disabled", true);
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
                                title: "Selecciona documento pdf",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }

                    });
                    $(".agregar_suficiencia").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/agregar_suficiencia_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_agregar_suficiencia_pdf").html(request);
                            $("#modal_agregar_suficiencia_pdf").modal('show');
                        });
                    });
                    $("#guardar_suficiencia_pdf").click(function (){
                        var suficiencia_pdf = $("#suficiencia_pdf").val();
                        if( suficiencia_pdf != ''){
                            $("#form_guardar_deficiencia_pdf").submit();
                            $("#guardar_suficiencia_pdf").attr("disabled", true);
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
                                title: "Selecciona documento pdf",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }

                    });
                    $(".agregar_justificacion").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/agregar_justificacion_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_agregar_justificacion_pdf").html(request);
                            $("#modal_agregar_justificacion_pdf").modal('show');
                        });
                    });
                    $("#guardar_justificacion_pdf").click(function (){
                        var justificacion_pdf = $("#justificacion_pdf").val();

                        if(justificacion_pdf != null){
                            if(justificacion_pdf == 1){
                                $("#form_guardar_justificacion_pdf").submit();
                                $("#guardar_justificacion_pdf").attr("disabled", true);
                                swal({
                                    position: "top",
                                    type: "success",
                                    title: "Registro exitoso",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }
                            if(justificacion_pdf == 2){
                                var doc_justificacion_pdf = $("#doc_justificacion_pdf").val();
                                if(doc_justificacion_pdf == ''){
                                    swal({
                                        position: "top",
                                        type: "error",
                                        title: "Selecciona documento pdf",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }else{
                                    $("#form_guardar_justificacion_pdf").submit();
                                    $("#guardar_justificacion_pdf").attr("disabled", true);
                                    swal({
                                        position: "top",
                                        type: "success",
                                        title: "Registro exitoso",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }

                            }

                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona una opcion",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $(".editar_requisicion_pdf").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/modificar_req_mat_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_modificar_requisicion_pdf").html(request);
                            $("#modal_modificar_requisicion_pdf").modal('show');
                        });
                    });
                    $("#guardar_mod_requisicion_pdf").click(function (){
                        var requisicion_pdf = $("#requisicion_pdf_mod").val();

                        if( requisicion_pdf != ''){
                            $("#form_guardar_mod_req_pdf").submit();
                            $("#guardar_mod_requisicion_pdf").attr("disabled", true);
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
                                title: "Selecciona documento pdf",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $(".editar_anexo1_pdf").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/mod_anexo1_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_mod_anexo1_pdf").html(request);
                            $("#modal_mod_anexo1_pdf").modal('show');
                        });
                    });
                    $("#guardar_mod_anexo1_pdf").click(function (){
                        var anexo1_pdf = $("#mod_anexo1_pdf").val();
                        if( anexo1_pdf != ''){
                            $("#form_guardar_mod_anexo1_pdf").submit();
                            $("#guardar_mod_anexo1_pdf").attr("disabled", true);
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
                                title: "Selecciona documento pdf",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $(".editar_presupuestal_pdf").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/mod_suficiencia_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_mod_suficiencia_pdf").html(request);
                            $("#modal_mod_suficiencia_pdf").modal('show');
                        });
                    });
                    $("#guardar_mod_suficiencia_pdf").click(function (){
                        var suficiencia_pdf = $("#mod_suficiencia_pdf").val();
                        if( suficiencia_pdf != ''){
                            $("#form_guardar_mod_deficiencia_pdf").submit();
                            $("#guardar_mod_suficiencia_pdf").attr("disabled", true);
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
                                title: "Selecciona documento pdf",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $(".editar_justificacion_pdf").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/mod_justificacion_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_mod_justificacion_pdf").html(request);
                            $("#modal_mod_justificacion_pdf").modal('show');
                        });
                    });
                    $("#guardar_mod_justificacion_pdf").click(function (){
                        var justificacion_pdf = $("#mod_justificacion_pdf").val();
                        if(justificacion_pdf != null){
                            if(justificacion_pdf == 1){
                                $("#form_guardar_mod_justificacion_pdf").submit();
                                $("#guardar_mod_justificacion_pdf").attr("disabled", true);
                                swal({
                                    position: "top",
                                    type: "success",
                                    title: "Registro exitoso",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }
                            if(justificacion_pdf == 2){
                                var doc_justificacion_pdf = $("#mod_doc_justificacion_pdf").val();
                                if(doc_justificacion_pdf == ''){
                                    swal({
                                        position: "top",
                                        type: "error",
                                        title: "Selecciona documento pdf",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }else{
                                    $("#form_guardar_mod_justificacion_pdf").submit();
                                    $("#guardar_mod_justificacion_pdf").attr("disabled", true);
                                    swal({
                                        position: "top",
                                        type: "success",
                                        title: "Registro exitoso",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }

                            }

                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona una opcion",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });

                });
            </script>
@endsection
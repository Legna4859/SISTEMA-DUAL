@extends('layouts.app')
@section('title', 'Oportunidad')
@section('content')

 @include("riesgos.partials.msg_ok")
{{--   <a href="{{ redirect()->back()->getTargetUrl()}}" class="btn btn-primary btn-lg text-center">
    <span class="glyphicon glyphicon-circle-arrow-left"  aria-hidden="true" data-toggle="tooltip" title="Regresar"></span>
</a>--}}


    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/riesgos/proceso")}}">Registro Procesos</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <a href="{{url("/riesgos/add_partes")."/".$oportunidades[0]->ri_requisitos[0]->partes[0]->id_proceso}}">Partes interesadas</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Oportunidad</span>
            </p>
            <br>

            <h2 class="text-primary">Oportunidad: {{$oportunidades[0]->des_oportunidad or ""}}</h2>
            <div class="row">
                <div class="col-md-4">
                      <h3 class="text-danger"> Factor de la oportunidad: {{$oportunidades[0]->calificacion * $oportunidades[0]->calif_beneficio}}</h3>
                </div>
                <div class="col-md-4 col-md-offset-4">
                   <h3 class="text-primary"> Calificación limite/umbral: {{$umbral[0]->numero}}</h3>
                </div>
            </div>


            <div class="panel panel-info col-md-12">
                <div class="panel-heading row ">
                    <h3 class="row col-md-12 panel-title">Probabilidad de lograr la oportunidad
                        <span data-toggle="modal" data-target="#modal_modificar_oportunidad" class=""><a href="#!" class="pull-right"><span aria-hidden="true" class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Modificar oportunidad"></span></a></span>
                    </h3>
                </div>
                <div class="panel-body">

                    {{--$oportunidades--}}
                    <div class="row">

                        <div class="col-md-4">
                           Probabilidad
                            <h5 class=""><strong>{{isset($oportunidades[0]->ri_o_probabilidad[0])?$oportunidades[0]->ri_o_probabilidad[0]->des_probabilidad:"Sin datos"}}</strong></h5>

                        </div>
                        <div class="col-md-4">
                            Calificacion de la probabilidad
                            <h5 class="pl-3"><strong>{{$oportunidades[0]->calificacion}}</strong></h5>

                        </div>
                    </div>

                    <div>
                        <div class="row">
                            <div class="col-md-4">
                                Potencial para la apertura de nuevos programas de estudio
                                <h5 class="">
                                   <strong>{{isset($oportunidades[0]->ri_o_potencialapertura[0])?$oportunidades[0]->ri_o_potencialapertura[0]->des_potencialapertura:"Sin datos"}}</strong>


                                </h5>

                            </div>
                            <div class="col-md-8">
                               Potencial del crecimiento de la matricula actual
                                <h5 class="">
                                    <strong>{{isset($oportunidades[0]->ri_o_potencialcrecimiento[0])?$oportunidades[0]->ri_o_potencialcrecimiento[0]->des_potencialcrecimiento:"Sin Datos"}}</strong>

                                </h5>
                               {{--
                                @section('modal_modi_descRiesgo')
                                    @include('riesgos.partials.modal_modi_desRiesgo')
                                @show
                                --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info col-md-12">
                <div class="panel-heading row ">
                    <h3 class="row col-md-12 panel-title">Beneficio Potencial de la oportunidad</h3>
                </div>
                <div class="panel-body">
                    <div class="row">

                        <div class="col-md-4">
                            Mejora potencial en la satisfaccion del cliente
                            <h5 class=""><strong>{{isset($oportunidades[0]->ri_o_mejoracliente[0])?$oportunidades[0]->ri_o_mejoracliente[0]->des_mejoracliente:"Sin Datos"}}</strong></h5>
                        </div>
                        <div class="col-md-4">
                            Mejora potencial de los procesos internos del SGC
                            <h5 class="pl-3"><strong>{{isset($oportunidades[0]->ri_o_mejorasgc[0])?$oportunidades[0]->ri_o_mejorasgc[0]->des_mejorasgc:"Sin Datos"}}</strong></h5>
                        </div>
                        <div class="col-md-4">
                            Calificación del Beneficio
                            <h5 class="pl-3"><strong>{{$oportunidades[0]->calif_beneficio}}</strong></h5>
                        </div>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-md-4">
                                Mejora de la reputación de la Institución
                                <h5 class="">
                                    <strong>{{isset($oportunidades[0]->ri_o_mejorareputacion[0])?$oportunidades[0]->ri_o_mejorareputacion[0]->des_mejorareputacion:"Sin Datos"}}</strong>
                                </h5>
                            </div>
                            <div class="col-md-8">
                                Potencial costo de implementación
                                <h5 class="">
                                    <strong>{{isset($oportunidades[0]->ri_o_potencialcosto[0])?$oportunidades[0]->ri_o_potencialcosto[0]->des_potencialcosto:"Sin Datos"}}</strong>
                                </h5>
                                {{--
                                 @section('modal_modi_descRiesgo')
                                     @include('riesgos.partials.modal_modi_desRiesgo')
                                 @show
                                 --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info col-md-12">
                <div class="panel-heading row ">
                    <h3 class="row col-md-12 panel-title">Plan de Seguimiento de Oportunidades <button data-toggle="modal"  data-tooltip="true"  title="Agregar" data-target="#modal_crear_plan" type="button" class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></h3>
                </div>
                <div class="panel-body">
                    <div class="row">

                        <div class="col-md-10 col-md-offset-1">
                            <ul class="list-group">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center col-md-2">
                                                Fecha inicial
                                            </th>
                                            <th class="text-center col-md-2">
                                                Fecha propuesta
                                            </th>
                                            <th class="col-md-8 text-center">
                                                Accion del plan de seguimiento
                                            </th>
                                            <th class="col-md-1 text-center">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    {{--$oportunidades[0]->ri_o_planseguimiento--}}
                                    @foreach($oportunidades[0]->ri_o_planseguimiento as $plan_seguimiento)

                                        <tr>
                                            <td class="col-md-2 text-center">
                                                {{$plan_seguimiento->fecha_inicial}}
                                            </td>
                                            <td class="col-md-2 text-center">
                                                {{$plan_seguimiento->fecha}}
                                            </td>
                                            <td class="col-md-6">
                                                <h5 class=""><strong>{{$plan_seguimiento->des_planseguimiento}}</strong></h5>
                                            </td>
                                            <td class="col-md-1">
                                                <a class="pull-left btn_delete_plan_seguimiento" data-id="{{$plan_seguimiento->id_planseguimiento}}"><span aria-hidden="true"  class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar accion"></span></a>
                                                <a class="pull-right btn_edit_plan_seguimiento" data-toggle="modal" data-target="#modal_edit_accion" data-url="" data-id="{{$plan_seguimiento->id_planseguimiento}}"><span aria-hidden="true" class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Editar accion"></span></a>

                                                <br>
                                                <a href="#!" class="pull-left btn_add_evidencia_oportunidad" data-id="{{$plan_seguimiento->id_planseguimiento}}" data-toggle="modal" data-target="#modal_add_evidencia" ><span class="glyphicon glyphicon-file" data-toggle="tooltip" data-placement="top" title="Adjuntar evidencia"></span></a>

                                                @if($plan_seguimiento->file!=null)
                                                    <a href="{{asset("storage/".$plan_seguimiento->file)}}" target="_blank" class="pull-right btn_add_evidencia_oportunidad"><span class="glyphicon glyphicon-camera" data-toggle="tooltip" data-placement="top" title="Ver evidencia"></span></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal_crear_plan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Accion para plan de oportunidades
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h5>

                </div>
                <form id="form_plan_oportunidad" class="form" role="form" method="POST" action="{{url("riesgos/planseguimiento")}}">
                    <div class="modal-body">
                        {{ csrf_field() }}

                        <input type="hidden" value="{{$oportunidades[0]->id_oportunidad}}" name="id_oportunidad_plan">
                        <div class="form-group">
                            <label for="des_plan_oportunidad" class="col-form-label">Descripcion</label>
                            <textarea class="form-control" name="des_plan_oportunidad" id="des_plan_oportunidad" cols="3" rows="3"></textarea>
                        </div>
                        <h3 class="alert alert-danger">Después de establecer las fechas no podrá realizar ningún cambio, asegúrese de verificar que sean correctas.</h3>

                        <div class="form-group">
                            <label for="fecha_inicial" class="col-form-label">Fecha inicial</label>
                            <div class="input-group date" id="date_picker_fecha" data-provide="datepicker">
                                <input type="text" class="form-control" id="fecha_inicial" name="fecha_inicial" />
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fecha_entrega" class="col-form-label">Fecha entrega</label>
                            <div class="input-group date" id="date_picker_group" data-provide="datepicker">
                                <input type="text" class="form-control" id="fecha_entrega" name="fecha_entrega" />
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary h-secondary_m" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary h-primary_m">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade " id="modal_modificar_oportunidad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Accion para plan de oportunidades
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h5>

                </div>
                <form id="form_modificar_oportunidad" class="form" role="form" method="POST" action="{{url("riesgos/regoportunidad")."/".$oportunidades[0]->id_oportunidad}}">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="row">
                            <h3>Probabilidad de lograr la oportunidad</h3>
                            <div class="form-group col-md-6">
                                <label for="id_probabilidad" class="col-form-label">Probabilidad</label>
                                <select name="id_probabilidad" id="id_probabilidad" class="form-control">
                                    <option value="" selected disabled>Seleccione un valor</option>
                                    @foreach( $probabilidades as $probabilidad)
                                        <option value="{{$probabilidad->id_probabilidad}}" {{$probabilidad->id_probabilidad==$oportunidades[0]->id_probabilidad?"selected":""}}>{{$probabilidad->des_probabilidad}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="id_ocurrenciap" class="col-form-label">Ocurrecias previas</label>
                                <select name="id_ocurrenciap" id="id_ocurrenciap" class="form-control">
                                    <option value="" selected disabled>Seleccione un valor</option>
                                    @foreach( $ocurrenciaps as $ocurrenciap)
                                        <option value="{{$ocurrenciap->id_ocurrenciap}}" {{$ocurrenciap->id_ocurrenciap==$oportunidades[0]->id_ocurrenciap?"selected":""}}>{{$ocurrenciap->des_ocurrenciasp}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="id_potencialapertura" class="col-form-label">Potencial de apertura de nuevos programas de estudio</label>
                                <select name="id_potencialapertura" id="id_potencialapertura" class="form-control">
                                    <option value="" selected disabled>Seleccione un valor</option>
                                    @foreach( $potencialaperturas as $potencialapertura)
                                        <option value="{{$potencialapertura->id_potencialapertura}}" {{$potencialapertura->id_potencialapertura==$oportunidades[0]->id_potencialapertura?"selected":""}}>{{$potencialapertura->des_potencialapertura}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="id_potencialcreciminto" class="col-form-label">Potencial de crecimiento de la matrícula actual</label>
                                <select name="id_potencialcrecimiento" id="id_potencialcrecimiento" class="form-control">
                                    <option value="" selected disabled>Seleccione un valor</option>
                                    @foreach( $potencialcrecimientos as $potencialcrecimiento)
                                        <option value="{{$potencialcrecimiento->id_potencialcrecimiento}}" {{$potencialcrecimiento->id_potencialcrecimiento==$oportunidades[0]->id_potencialcrecimiento?"selected":""}}>{{$potencialcrecimiento->des_potencialcrecimiento}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <h3>Beneficio potencial de la oportunidad</h3>
                            <div class="form-group col-md-6">
                                <label for="id_mejoracliente" class="col-form-label">Mejora potencial en la satisfaccion del cliente</label>
                                <select name="id_mejoracliente" id="id_mejoracliente" class="form-control">
                                    <option value="" selected disabled>Seleccione un valor</option>
                                    @foreach( $mejoraclientes as $mejoracliente)
                                        <option value="{{$mejoracliente->id_mejoracliente}}" {{$mejoracliente->id_mejoracliente==$oportunidades[0]->id_mejoracliente?"selected":""}}>{{$mejoracliente->des_mejoracliente}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="id_mejorasgc" class="col-form-label">Mejora potencial de los procesos internos del SGC</label>
                                <select name="id_mejorasgc" id="id_mejorasgc" class="form-control">
                                    <option value="" selected disabled>Seleccione un valor</option>
                                    @foreach( $mejorasgcs as $mejorasgc)
                                        <option value="{{$mejorasgc->id_mejorasgc}}" {{$mejorasgc->id_mejorasgc==$oportunidades[0]->id_mejorasgc?"selected":""}}>{{$mejorasgc->des_mejorasgc}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="id_mejorareputacion" class="col-form-label">Mejora de la reputación de la Institución</label>
                                <select name="id_mejorareputacion" id="id_mejorareputacion" class="form-control">
                                    <option value="" selected disabled>Seleccione un valor</option>
                                    @foreach( $mejorareputacions as $mejorareputacion)
                                        <option value="{{$mejorareputacion->id_mejorareputacion}}" {{$mejorareputacion->id_mejorareputacion==$oportunidades[0]->id_mejorareputacion?"selected":""}}>{{$mejorareputacion->des_mejorareputacion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="id_potencialcosto" class="col-form-label">Potencial costo de implementación</label>
                                <select name="id_potencialcosto" id="id_potencialccosto" class="form-control">
                                    <option value="" selected disabled>Seleccione un valor</option>
                                    @foreach( $potencialcostos as $potencialcosto)
                                        <option value="{{$potencialcosto->id_potencialcosto}}" {{$potencialcosto->id_potencialcosto==$oportunidades[0]->id_potencialcosto?"selected":""}}>{{$potencialcosto->des_potencialcosto}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary h-secondary_m" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary h-primary_m">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


{{--Modal form edit accion--}}
    <form id="form_edit_accion" class="form" role="form" method="POST" action="">
        <div class="modal fade" id="modal_edit_accion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Editar accion</h4>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="des_planseguimiento">Accion para plan de oportunidades </label>
                                    <input id="des_planseguimiento" name="des_planseguimiento" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_inicial" class="col-form-label">Fecha inicial</label>
                                    <div class="input-group date" id="date_picker_fecha_inicial" data-provide="datepicker">
                                        <input  class="form-control" id="f_inicial" name="f_inicial" disabled="true"/>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_entrega" class="col-form-label">Fecha entrega</label>
                                    <div class="input-group date" id="date_picker_fecha_final" data-provide="datepicker">
                                        <input  class="form-control" id="f_entrega" name="f_entrega" disabled="true"/>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input id="save_accion" type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{--form delete accion--}}
    <form action="" method="POST" role="form" id="form_delete">
        {{method_field('DELETE') }}
        {{ csrf_field() }}
    </form>

<div class="modal fade" id="modal_add_evidencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog mt-2" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar control de riesgo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_evidencia" class="form" role="form" method="POST" action="" enctype="multipart/form-data" />
            @csrf
            @method("PUT")
            <div class="modal-body">

                <div class="form-group">
                    <label for="" class="col-form-label">Evidencia</label>
                    <input name="evidencia" id="evidencia"  class="form-control" type="file" accept="application/pdf">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary h-secondary_m" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary h-primary_m">Aceptar</button>
            </div>
            </form>
        </div>
    </div>
</div>

    <script type="text/javascript">
    $(document).ready(function() {

        $(".btn_add_evidencia_oportunidad").click(function(){
            $("#form_add_evidencia").attr("action","{{url("riesgos/seguimiento/file_oportunidad/")}}/"+$(this).data("id"));
        });

        $(".btn_edit_plan_seguimiento").click(function(){
            var id=$(this).data("id");
            $.get("/riesgos/planseguimiento/"+id+"/edit",function(res){
                $("#form_edit_accion").attr("action","/riesgos/planseguimiento/"+id);
                $("#des_planseguimiento").val(res.des_planseguimiento);
                $("#f_inicial").val(res.fecha_inicial);
                $("#f_entrega").val(res.fecha);
                $("#modal_edit_accion").modal("show");
            });
        });
        $(".btn_delete_plan_seguimiento").click(function(){
            var id=$(this).data('id');
           // alert(id)




Swal.fire({
                    title: '¿Seguro que desea eliminar?',
            type:'error',
                    showCancelButton: true,
                    confirmButtonText: `Aceptar`,
                    cancelButtonText: `Cancelar`,
                }).then((result) => {
  /* Read more about isConfirmed, isDenied below */
                    if (result.value) {
                        $("#form_delete").attr("action","/riesgos/planseguimiento/"+id)
                        $("#form_delete").submit();
                    }
                });
        });
        $("#form_plan_oportunidad").validate({
            rules: {
                des_plan_oportunidad: {
                    required: true,
                },
                fecha_entrega:{
                    required: true,
                },

            },
        });
        $("#form_modificar_oportunidad").validate({
            rules: {
                id_probabilidad: {
                    required: true,
                },
                id_ocurrenciap:{
                    required: true,
                },

                id_potencialapertura:{
                    required: true,
                },
                id_potencialcrecimiento:{
                    required: true,
                },
                id_mejoracliente:{
                    required: true,
                },
                id_mejorasgc:{
                    required: true,
                },
                id_mejorareputacion:{
                    required: true,
                },
                id_potencialcosto:{
                    required: true,
                },


            },
        });
        $('#date_picker_group').datepicker({
            format: 'yyyy/mm/dd',
            language: 'es',
            autoclose: true,
            startDate: '+1d',

        });
        $('#date_picker_fecha').datepicker({
            format: 'yyyy/mm/dd',
            language: 'es',
            autoclose: true,
            startDate: '+1d',

        });
        $('#date_picker_fecha_inicial').datepicker({
            format: 'yyyy/mm/dd',
            language: 'es',
            autoclose: true,
            startDate: '+1d',

        });
        $('#date_picker_fecha_final').datepicker({
            format: 'yyyy/mm/dd',
            language: 'es',
            autoclose: true,
            startDate: '+1d',

        });

    });
    //var $j = jQuery.noConflict();


    </script>
@endsection
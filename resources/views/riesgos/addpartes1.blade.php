@extends('layouts.app')
@section('title', 'Partes interesadas de la unidad')
@section('content')

<main class="col-md-12">
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            @if (session()->has('flash_notification.message'))
                <div class="alert alert-{{ session('flash_notification.level') }}">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {!! session('flash_notification.message') !!}
                </div>
            @endif
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Partes Interesadas de la unidad administrativa</h3>
                </div>
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div id="accordion" class="panel-group">
                @foreach($partes_unidad as $parte_unidad)
                <div class="panel ">
                    <div class="panel-heading">
                        <h3 class="panel-title row">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$parte_unidad->id_uni_p}}">{{$parte_unidad->parte[0]->des_parte}}</a>
                            {{--Nuevo icono eliminar --}}
                            <a href="#!" class="pull-right btn_delete_unidad_partes" data-id="{{$parte_unidad->id_uni_p}}"><span class="text-danger glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar parte interesada "></span></a>
                        </h3>
                    </div>
                    <div id="collapse{{$parte_unidad->id_uni_p}}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="row text-center">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                         <h3 class="panel-title text-center">Requisitos
                                             <a href="#!" data-toggle="modal"  data-id="{{$parte_unidad->id_uni_p}}" data-target="#modal_crear_requisito" class="pull-right  btn_crear_requisito">
                                                 <span class="text-success glyphicon glyphicon-plus" aria-hidden="true" data-toggle="tooltip" title="Agregar"></span>
                                             </a>
                                         </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <table class="table table-bordered table-resposive">
                                    <thead>
                                        <tr>
                                            <th>Requisitos</th>
                                            <th>Riesgos</th>
                                            <th>Oportunidades</th>
                                           {{-- <th>Información sobre el riesgo</th>--}}
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($parte_unidad->requisitos as $requisito)
                                            <tr>
                                                <td>{{$requisito->des_requisito}}</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a href="#!" data-toggle="modal"  data-id="{{$requisito->id_requisito}}" data-target="#modal_crear_requisito_riesgo" class="btn_crear_requisito_riesgo">
                                                                <span class="text-success glyphicon glyphicon-plus" aria-hidden="true" data-toggle="tooltip" title="Agregar riesgo"></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-10  col-md-offset-1">
                                                            <ul class="list-group">
                                                                @foreach($requisito->riesgos as $riesgo_requisito)
                                                                   <li class="list-group-item">
                                                                       <div class="row">
                                                                           <div class="col-md-8">
                                                                               <a href="{{url('riesgos/registroriesgos')."/".$riesgo_requisito->id_riesgo}}"> {{$riesgo_requisito->des_riesgo}}</a>
                                                                           </div>
                                                                           <div class="col-md-2">
                                                                               <a href="#!" class="btn_delete_riesgo_requisito pull-right" data-id="{{$riesgo_requisito->id_riesgo}}"><span aria-hidden="true" class="text-danger glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar riesgo"></span></a>
                                                                           </div>
                                                                           <div class="col-md-2">
                                                                               <a href="#!" class="pull-right btn_edit_info" data-toggle="modal" data-target="#modal_modificar_datos" data-url="riesgos/riesgo/{{$riesgo_requisito->id_riesgo}}" data-info_edit="{{$riesgo_requisito->des_riesgo}}"><span aria-hidden="true" class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Editar riesgo"></span></a>
                                                                           </div>
                                                                       </div>
                                                                   </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a data-toggle="modal"  data-id="{{$requisito->id_requisito}}" data-target="#modal_crear_requisito_oportunidad" class="btn_crear_requisito_oportunidad">
                                                                <span class="text-success glyphicon glyphicon-plus" aria-hidden="true" data-toggle="tooltip" title="Agregar oportunidad"></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-10  col-md-offset-1">
                                                            <ul class="list-group">
                                                                @foreach($requisito->oportunidades as $riesgo_oportunidad)
                                                                    <li class="list-group-item">
                                                                        <div class="row">
                                                                            <div class="col-md-9">
                                                                                <a href="{{url('riesgos/regoportunidad')."/".$riesgo_oportunidad->id_oportunidad}}" class="">{{$riesgo_oportunidad->des_oportunidad}}</a>
                                                                            </div>
                                                                            <div class="col-md-1"></div>
                                                                            <div class="col-md-1">
                                                                                <a class="btn_delete_oportunidad_requisito pull-right" data-id="{{$riesgo_oportunidad->id_oportunidad}}"><span aria-hidden="true" class="text-danger glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar oportunidad"></span></a>
                                                                            </div>
                                                                            <div class="col-md-1">
                                                                                <a class="pull-right btn_edit_info" data-toggle="modal" data-target="#modal_modificar_datos" data-url="riesgos/regoportunidad/{{$riesgo_oportunidad->id_oportunidad}}" data-info_edit="{{$riesgo_oportunidad->des_oportunidad}}"><span aria-hidden="true" class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Editar oportunidad"></span></a>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                               {{-- <td>{{$requisito->riesgos[0]->des_riesgo}}</td>--}}
                                               {{-- <td>
                                                    <a href="{{url('riesgos/registroriesgos')."/".$requisito->id_riesgo}}" class="btn btn-danger btn-sm"><span aria-hidden="true" class="glyphicon glyphicon-fire"></span></a>

                                                </td>--}}
                                                <td>
                                                    <a class="btn_delete_requisito_riesgo" data-id="{{$requisito->id_requisito}}"><span aria-hidden="true"  class="text-danger glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar requisito"></span></a>
                                                    <a class="pull-right btn_edit_info" data-toggle="modal" data-target="#modal_modificar_datos" data-url="riesgos/requisitos/{{$requisito->id_requisito}}" data-info_edit="{{$requisito->des_requisito}}"><span aria-hidden="true" class="glyphicon glyphicon-cog" data-toggle="tooltip" title="Editar requisito"></span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</main>

<div>
    <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nueva parte interesada" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
    </button>
</div>

<form id="form_parte_crea" class="form" role="form" method="POST" >
    <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar Parte Interesada</h4>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="parte_interesada">Parte Interesada</label>
                                <select class="form-control" name="parte_interesada" id="parte_interesada" >
                                    <option disabled selected>Seleccione una opción</option>
                                    @foreach($partes as $parte)
                                        <option value="{{$parte->id_parte}}">{{$parte->des_parte}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input id="save_unidad" type="submit" class="btn btn-primary" value="Guardar"/>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="form_requisito" class="form" role="form" method="POST" action="{{url('riesgos/requisitos')}}">
    <div class="modal fade" id="modal_crear_requisito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar Requisito</h4>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_uni_p" id="id_uni_p">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="des_parte">Requisito</label>
                                <input type="text" class="form-control"name="requisito" placeholder="Requisito">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-primary" value="Guardar"/>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="form_requisito_riesgo" class="form" role="form" method="POST" action="{{url('riesgos/riesgo')}}">
    <div class="modal fade" id="modal_crear_requisito_riesgo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar Riesgo</h4>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_requisito_riesgo" id="id_requisito_riesgo">
                    <div class="row">
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label for="riesgo">Riesgo</label>
                                 <input type="text" class="form-control" name="riesgo" placeholder="Riesgo">
                             </div>
                         </div>
                     </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-primary" value="Guardar"/>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="form_requisito_oportunidad" class="form" role="form" method="POST" action="{{url('riesgos/regoportunidad')}}">
    <div class="modal fade" id="modal_crear_requisito_oportunidad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar Oportunidad</h4>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_requisito_oportunidad" id="id_requisito_oportunidad">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="riesgo">Oportunidad</label>
                                <input type="text" class="form-control" name="oportunidad" placeholder="Oportunidad">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-primary" value="Guardar"/>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="form_modificar_datos" class="form" role="form" method="POST" >
    <div class="modal fade" id="modal_modificar_datos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar Registro</h4>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="riesgo">Descripción </label>
                                <input type="text" class="form-control" name="des_dato_modificar" id="des_dato_modificar">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-primary" value="Guardar"/>
                </div>
            </div>
        </div>
    </div>
</form>


<form  method="POST" role="form" id="form_delete">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
</form>

<script>
    $(document).ready(function() {
        $(".btn_delete_unidad_partes").click(function(){
            var id=$(this).data('id');




Swal.fire({
                    title: '¿Seguro que desea eliminar?',
            type:'error',
                    showCancelButton: true,
                    confirmButtonText: `Aceptar`,
                    cancelButtonText: `Cancelar`,
                }).then((result) => {
  /* Read more about isConfirmed, isDenied below */
                    if (result.value) {
                        $("#form_delete").attr("action","{{url('riesgos/add_partes')}}/"+id)
                        $("#form_delete").submit();
                    }
                });
        });
        $(".btn_delete_requisito_riesgo").click(function(){
            var id=$(this).data('id');




Swal.fire({
                    title: '¿Seguro que desea eliminar?',
            type:'error',
                    showCancelButton: true,
                    confirmButtonText: `Aceptar`,
                    cancelButtonText: `Cancelar`,
                }).then((result) => {
  /* Read more about isConfirmed, isDenied below */
                    if (result.value) {
                        $("#form_delete").attr("action","{{url('riesgos/requisitos')}}/"+id)
                       // alert($("#form_delete_requisito_riesgo").attr("action"))
                        $("#form_delete").submit();
                    }
                });
        });
        $(".btn_delete_oportunidad_requisito").click(function(){
            var id=$(this).data('id');




Swal.fire({
                    title: '¿Seguro que desea eliminar?',
            type:'error',
                    showCancelButton: true,
                    confirmButtonText: `Aceptar`,
                    cancelButtonText: `Cancelar`,
                }).then((result) => {
  /* Read more about isConfirmed, isDenied below */
                    if (result.value) {
                        $("#form_delete").attr("action","{{url('riesgos/regoportunidad')}}/"+id)
                        // alert($("#form_delete_requisito_riesgo").attr("action"))
                        $("#form_delete").submit();
                    }
                });
        });
        $(".btn_delete_riesgo_requisito").click(function(){
            var id=$(this).data('id');




Swal.fire({
                    title: '¿Seguro que desea eliminar?',
            type:'error',
                    showCancelButton: true,
                    confirmButtonText: `Aceptar`,
                    cancelButtonText: `Cancelar`,
                }).then((result) => {
  /* Read more about isConfirmed, isDenied below */
                    if (result.value) {
                        $("#form_delete").attr("action","{{url('riesgos/riesgo')}}/"+id)
                        // alert($("#form_delete_requisito_riesgo").attr("action"))
                        $("#form_delete").submit();
                    }
                });
        });
        $(".btn_edit_info").click(function(){
           var elemnent=$(this);
           $("#form_modificar_datos").attr("action","{{url("")}}/"+elemnent.data("url"));
           $("#des_dato_modificar").val(elemnent.data("info_edit"));
        });
        $("#form_parte_crea").validate({
            rules: {
                parte_interesada: {
                    required: true,
                },
            },
        });
        $("#form_requisito").validate({
            rules: {
                requisito: {
                    required: true,
                },
                /*riesgo: {
                    required: true,
                },*/
            },
        });
        $("#form_modificar_datos").validate({
            rules: {
                requisito: {
                    required: true,
                },
                /*riesgo: {
                    required: true,
                },*/
            },
        });
        $(".btn_crear_requisito").click(function () {
            //alert("ok")
            $("#id_uni_p").val($(this).data('id'));
        })
        $(".btn_crear_requisito_riesgo").click(function () {
            //alert("ok")
            $("#id_requisito_riesgo").val($(this).data('id'));
        })

        $(".btn_crear_requisito_oportunidad").click(function () {
            //alert("ok")
            $("#id_requisito_oportunidad").val($(this).data('id'));
        })

        $('[data-toggle="tooltip"]').tooltip();

    });
</script>

@endsection
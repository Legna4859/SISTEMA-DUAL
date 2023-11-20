@extends('layouts.app')
@section('title', 'Riesgos')
@section('content')

    @include("riesgos.partials.msg_ok")

    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/riesgos/proceso")}}">Registro Procesos</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <a href="{{url("/riesgos/add_partes")."/".(isset($datos_registro_riesgo[0]->riesgos[0]->getRequisito[0])?$datos_registro_riesgo[0]->riesgos[0]->getRequisito[0]->partes[0]->id_proceso:"")}}">Partes interesadas</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Riesgos del requisito</span>
            </p>
            <br>
            <div class="panel panel-info col-md-12">
                <div class="panel-heading row ">
                    <h3 class="row col-md-12 panel-title">Riesgo del requisito {{isset($datos_registro_riesgo[0]->riesgos[0]->getRequisito[0])?$datos_registro_riesgo[0]->riesgos[0]->getRequisito[0]->des_requisito:""}} </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            Numero de riesgo
                            <h4 class=""><strong>{{isset($datos_registro_riesgo[0]->numero)?$datos_registro_riesgo[0]->numero:""}}</strong></h4>
                        </div>
                        <div class="col-md-4">
                            Unidad administrativa
                            <h5 class="pl-3"><strong>{{isset($datos_registro_riesgo[0]->unidadAdmin[0])?$datos_registro_riesgo[0]->unidadAdmin[0]->nom_departamento:""}}</strong></h5>
                        </div>
                        <div class="col-md-4">
                            Nombre del riesgo
                            <h5 class="pl-3"><strong>{{(isset($datos_registro_riesgo[0]->riesgos[0])?$datos_registro_riesgo[0]->riesgos[0]->des_riesgo:"")}}</strong></h5>
                        </div>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-md-4">
                                Posibles efectos del riesgo
                                <h5 class="">
                                   <strong>{{isset($datos_registro_riesgo[0]->valEfectos[0])?$datos_registro_riesgo[0]->valEfectos[0]->efecto:""}}</strong>
                                </h5>
                                {{--<span data-toggle="modal" data-target="#modal_efectos" class=""><a href="#!" class="btn btn-primary h-primary_m px-5">Modificar</a></span>--}}
                                <h5><a href="#!" data-toggle="modal" data-target="#modal_efectos"><span class="glyphicon glyphicon-cog"></span> </a></h5>
                            </div>
                            <div class="col-md-8">
                                Descripcion del riesgo
                                <h5 class="">
                                    <strong>{{$datos_registro_riesgo[0]->descip_riesgo}}</strong>
                                </h5>
                                <h5>
                                    <a href="#!" data-toggle="modal" data-target="#modal_modi_descRiesgo"><span class="glyphicon glyphicon-cog"></span></a>
                                </h5>
                                {{---
                                @section('modal_modi_descRiesgo')
                                    @include('riesgos.partials.modal_modi_desRiesgo')
                                @show
                                --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-heading row ">
                    <h3 class="row col-md-12 panel-title">Valoracion inicial y estrategia</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table text-center border-table">
                                <thead class="text-center">
                                <tr class="table-active">
                                    <th class="text-center col-md-5">Grado de impacto</th>
                                    <th class="text-center col-md-5">Probabilidad ocurrencia</th>
                                    <th class="text-center col-md-2">Cuadrante</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="col-md-4">{{isset($datos_registro_riesgo[0]->valEfectos[0])?$datos_registro_riesgo[0]->valEfectos[0]->grado_impacto:""}}</td>
                                    <td class="col-md-5">{{isset($datos_registro_riesgo[0]->valEfectos[0])?$datos_registro_riesgo[0]->valEfectos[0]->probabilidad:""}}</td>
                                    @if($datos_registro_riesgo[0]->valEfectos[0]->getCuadrantei()==1)
                                        <td class="cuad_ini col-md-2 btn-danger">I</td>
                                    @elseif($datos_registro_riesgo[0]->valEfectos[0]->getCuadrantei()==2)
                                        <td class="cuad_ini col-md-2 btn-warning">II</td>
                                    @elseif($datos_registro_riesgo[0]->valEfectos[0]->getCuadrantei()==3)
                                        <td class="cuad_ini col-md-2 btn-success">III</td>
                                    @elseif($datos_registro_riesgo[0]->valEfectos[0]->getCuadrantei()==4)
                                        <td class="cuad_ini col-md-2 btn-info">IV</td>
                                    @endif
                                </tr>
                                </tbody>
                            </table>
                            <strong>Estrategia</strong>
                            <h4>
                                @foreach($datos_registro_riesgo[0]->estrategiaRiesgo as $estrategia)
                                <li class="list-group-item">
                                <div class="row">
                                <div class="col-md-10">
                                <h5 class="estrategia_r">{{$estrategia->getEstrategia[0]->descripcion}}</h5>
                                </div>
                                </div>
                                </li>
                                @endforeach
                            </h4>
                        </div>
                    </div>
                </div>
            </div>



            @if(isset($datos_registro_riesgo[0]->estrategiaRiesgo[0]))

            @if(((strtolower($datos_registro_riesgo[0]->estrategiaRiesgo[0]->getEstrategia[0]->descripcion)!="asumir el riesgo")&&(strtoupper($datos_registro_riesgo[0]->riesgos[0]->getRequisito[0]->partes[0]->proceso[0]->sistema[0]->desc_sistema)=="SGC"))||(strtoupper($datos_registro_riesgo[0]->riesgos[0]->getRequisito[0]->partes[0]->proceso[0]->sistema[0]->desc_sistema)=="COCODI"))

                    <div class="panel panel-info col-md-12 adicionales">
                        <div class="panel-heading row ">
                            <h3 class="row col-md-12 panel-title">Factores</h3>
                        </div>
                        <br>
                        <ul class="nav nav-tabs">
                            <div class="tab-content">
                                <div class="tab-pane fade active in text-center" id="factores">
                                    <h5><a href="#" class="pull-right" data-toggle="modal" data-target="#modal_riesgos"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar factor"></span></a></h5>
                                    <br>
                                    <div class="row">
                                        <div class="col-12 col-auto">
                                            <div>
                                                <table>
                                                    <thead class="row">
                                                    <th class="col-md-1 col-lg-1 text-center">No. de factor</th>
                                                    <th class="col-md-4 col-lg-4 text-center">Descripción</th>
                                                    <th class="col-md-3 col-lg-3 text-center">Clasificación</th>
                                                    <th class="col-md-1 col-lg-1 text-center">Tipo</th>
                                                    <th class="col-md-2 col-lg-2 text-center">¿Tiene controles?</th>
                                                    <th class="col-md-1 col-lg-1 text-center">Acciones</th>
                                                    </thead>
                                                </table>

                                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                    {{Session::put('controlado','SI')}}
                                                    @foreach($datos_registro_riesgo[0]->factorRiesgo as $ri_factor)
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="heading{{$ri_factor->id_factor}}">
                                                                <h5 class="panel-title">
                                                                    <div class="row">
                                                                        <div class="col-md-1 col-lg-1  text-center">{{(explode("-",$datos_registro_riesgo[0]->numero)[1]).".".$ri_factor->no_factor}}</div>
                                                                        <div class="col-md-4 col-lg-4  text-center">

                                                                                <a role="button" data-toggle="collapse" data-id="{{$ri_factor->id_factor}}" class="btn_collapse_factor" data-parent="#accordion" href="#collapse{{$ri_factor->id_factor}}" aria-expanded="true" aria-controls="collapse{{$ri_factor->id_factor}}">
                                                                                    {{$ri_factor->descripcion_f}}
                                                                                </a>

                                                                        </div>

                                                                        <div class="col-md-3 col-lg-3  text-center">{{$ri_factor->ri_clasi_f[0]->des_cl_f}}</div>
                                                                        <div class="col-md-1 col-lg-1 text-center">{{$ri_factor->ri_tipof[0]->des_tf}}</div>
                                                                        <div class="col-md-2 col-lg-2 text-center">{{$ri_factor->tiene_controles}}</div>
                                                                        @if($ri_factor->tiene_controles=="NO")
                                                                            {{Session::put('controlado','NO')}}
                                                                        @endif
                                                                        <div class="col-md-1 col-lg-1  text-center">
                                                                            <a href="#!" class="btn_delete_element_riesgo pull-left" data-toggle="tooltip" data-id="{{$ri_factor->id_factor}}" data-url="{{url("riesgos/reg_factor")}}" data-placement="top" title="Eliminar"><span class="glyphicon glyphicon-trash"></span></a>
                                                                            <a href="#!" class="btn_edit_factor pull-right" data-toggle="modal" data-target="#modal_edit_factor" data-id="{{$ri_factor->id_factor}}" data-url="{{url('riesgos/reg_factor')}}" data-descripcion="{{$ri_factor->descripcion_f}}" data-clasificacion="{{$ri_factor->id_cl_f}}" data-tipo="{{$ri_factor->id_tipo_f}}" data-controles="{{$ri_factor->tiene_controles}}" data-toggle="tooltip" data-placement="top" title="modificar"><span class="glyphicon glyphicon-cog"></span></a>
                                                                        </div>
                                                                    </div>
                                                                </h5>
                                                            </div>


                                                            <div id="collapse{{$ri_factor->id_factor}}" class="panel-collapse collapse {{ Session::get('collapseStatefactor')==$ri_factor->id_factor?'in':'' }}" role="tabpanel" aria-labelledby="heading{{$ri_factor->id_factor}}">

                                                                <div class="panel-body">
                                                                    @section('cont_evaluacion_control'.$ri_factor->id_factor)
                                                                        @include('riesgos.partials.evaluacion_control',['id_factor'=>$ri_factor->id_factor])
                                                                    @show

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
                        </ul>
                    </div>
                @endif
            @endif


        <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel-heading row ">
                            <h3 class="row col-md-12 panel-title">Valoracion final</h3>
                        </div>
                        <div class="panel-body">
                            <h5><a href="#!" class="pull-right" data-toggle="modal" data-target="#modal_efectos_final"><span class="glyphicon glyphicon-cog"></span> </a></h5>
                            <div class="row">
                                @if($datos_registro_riesgo[0]->valEfectos[0]->impacto_final!=0 && $datos_registro_riesgo[0]->valEfectos[0]->ocurrencia_final!=0)
                                    <div class="col-md-12">
                                        <table class="table text-center border-table">
                                            <thead class="text-center">
                                            <tr class="table-active">
                                                <th class="text-center col-md-5">Grado impacto</th>
                                                <th class="text-center col-md-5">Probabilidad de ocurrencia</th>
                                                <th class="text-center col-md-2">Cuadrante</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>

                                                <td class="col-md-5">{{$datos_registro_riesgo[0]->valEfectos[0]->impacto_final}}</td>
                                                <td class="col-md-5">{{$datos_registro_riesgo[0]->valEfectos[0]->ocurrencia_final}}</td>
                                                @if($datos_registro_riesgo[0]->valEfectos[0]->getCuadrantef()==1)
                                                    <td class="col-md-2 btn btn-danger">I</td>
                                                @elseif($datos_registro_riesgo[0]->valEfectos[0]->getCuadrantef()==2)
                                                    <td class="col-md-2 btn-warning">II</td>
                                                @elseif($datos_registro_riesgo[0]->valEfectos[0]->getCuadrantef()==3)
                                                    <td class="col-md-2 btn-success">III</td>
                                                @elseif($datos_registro_riesgo[0]->valEfectos[0]->getCuadrantef()==4)
                                                    <td class="col-md-2 btn-info">IV</td>
                                                @endif
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <strong>No se ha asignado la valoracion final</strong>

                                    <br>
                                @endif
                            </div>
                        </div>
                        <div class="panel-heading row ">
                            <h3 class="row col-md-12 panel-title">Riesgo Controlado Suficientemente</h3>
                        </div>
                        <div class="panel-body">
                            @if(Session::get('controlado')=="NO")
                                <h4 class="btn-warning text-center">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">{{Session::get('controlado')}}</div>
                                    </div>
                                </h4>
                            @else
                                <h4 class="btn-success text-center">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">SI</div>
                                    </div>
                                </h4>
                            @endif
                        </div>

                        <form  method="POST" role="form" id="form_delete">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form  method="POST" role="form" id="form_delete_factor">
        @csrf
        @method('DELETE')
    </form>
    <!-- Modal -->
    <!-- Modal efectos-->
   @section('modal_valoracion_efectos')
        @include('riesgos.partials.modal_valoracion_efectos')
   @show

    @section('modal_modiriesgo')
        @include('riesgos.partials.modal_modi_desRiesgo')
    @show
    @section('cont_factores')
        @include('riesgos.partials.factores')
    @show
    @section('cont_modals_control')
        @include('riesgos.partials.modals_control')
    @show
    @section('cont_modals_acciones')
        @include('riesgos.partials.modals_acciones')
    @show

    <div class="modal fade" id="modal_estrategias_riesgo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar estrategias</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_estrategias" class="form" role="form" method="POST" action="{{url('riesgos/riest_riesgo')}}">
                    <div class="modal-body">
                        <div class="form-group">
                            <input hidden type="text" id="id_reg_riesgo" name="id_reg_riesgo" value="{{$datos_registro_riesgo[0]->id_reg_riesgo}}">
                        </div>

                        <div class="form-group">
                            {{ csrf_field() }}
                            <label for="id_estrategia" class="col-form-label">Estrategias</label>
                            <select class="form-control" name="id_estrategia" id="id_estrategia">
                                <option value="" disabled="true" selected="true">Seleccione una opción</option>
                                @foreach($ri_estrategia as $estrategias)
                                    <option value="{{$estrategias->id_estrategia}}">{{$estrategias->descripcion}}</option>
                                @endforeach
                            </select>
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

<script>
    $(document).ready(function () {
        $(".btn_delete_estrategia_ri").click(function(){
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
                        $("#form_delete").attr("action","{{url('riesgos/riest_riesgo')}}/"+id)
                        $("#form_delete").submit();
                    }
                });
        });
        $(".btn_delete_element_riesgo").click(function(){
            var id=$(this).data('id');
            var url=$(this).data("url");




Swal.fire({
                    title: '¿Seguro que desea eliminar?',
            type:'error',
                    showCancelButton: true,
                    confirmButtonText: `Aceptar`,
                    cancelButtonText: `Cancelar`,
                }).then((result) => {
  /* Read more about isConfirmed, isDenied below */
                    if (result.value) {
                        $("#form_delete_factor").attr("action",(url+"/"+id));
                        $("#form_delete_factor").submit();
                    }
                });
        });
        $(".btn_edit_factor").click(function(){
            $("#descripcion_factor_edit").val($(this).data("descripcion"));
            $("#clasi_factor_edit").val($(this).data("clasificacion"));
            $("#tipo_factor_edit").val($(this).data("tipo"));
            $("#have_controls_edit").val($(this).data("controles"));
            $("#form_edit_factor_riesgo").attr("action",($(this).data("url")+"/"+$(this).data("id")));
        });


        $(".btn_collapse_factor").click(function(){
            $.get("{{url('riesgos/registroriesgos/collapse')}}/"+$(this).data("id"));
        });

        $('[data-toggle="tooltip"]').tooltip();

    })
</script>

@endsection
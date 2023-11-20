@section('cont_evaluacion_control'.$id_factor)

    <ul class="nav nav-pills nav-tabs" >
        @if($ri_factor->tiene_controles=="SI")
        <li class="active"><a data-toggle="pill" href="#nav-controles{{$id_factor}}" >Controles</a></li>
        @endif
        <li><a data-toggle="pill" href="#nav-estrategias{{$id_factor}}">Acciones</a></li>
    </ul>
    <div class="tab-content">
        @if($ri_factor->tiene_controles=="SI")
            {{Session::put('controlado','SI')}}
        <div class="tab-pane fade in active text-center" id="nav-controles{{$id_factor}}">
            <div class="row" >
                <div class="row col-md-12">
                    {{--<span data-toggle="modal" data-target="#modal_controles_factores" class=""><a href="#!" class="btn btn-primary h-primary_m px-5 mb-2 btn_add_eva_control" data-id="{{$id_factor}}">Nuevo Control</a></span>--}}
                    <a href="#!" class="pull-right btn_add_eva_control" data-toggle="modal" data-target="#modal_controles_factores" data-id="{{$id_factor}}"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar Control"></span></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                        <table class="table text-center my-0 border-table">
                            <thead class="text-center">
                            <tr class="table-active">
                                <th class="text-center">No. de Control</th>
                                <th class="text-center">Descripción</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Esta documentado</th>
                                <th class="text-center">Esta formalizado</th>
                                <th class="text-center">Se aplica</th>
                                <th class="text-center">Es efectivo</th>
                                <th class="text-center">Resultado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ri_factor->riEvaControl as $eva_control)

                                <tr>
                                    <td>{{(explode("-",$datos_registro_riesgo[0]->numero)[1]).".".$ri_factor->no_factor.".".$eva_control->No_controles_eva}}</td>
                                    <td>
                                        @if($eva_control->resultado=="DEFICIENTE")
                                            <a  href="#!" class="pull-right btn_add_accion" id="add_accion_control"data-toggle="modal" data-target="#modal_acciones_factores" data-id="{{$id_factor}}">
                                                {{$eva_control->descripcion}}
                                            </a>
                                        @else
                                            {{$eva_control->descripcion}}
                                        @endif

                                    </td>
                                    <td>{{$eva_control->tipoEva[0]->des_eva}}</td>
                                    <td>{{$eva_control->documentado}}</td>
                                    <td>{{$eva_control->formalizado}}</td>
                                    <td>{{$eva_control->aplica}}</td>
                                    <td>{{$eva_control->efectivo}}</td>
                                    <td>{{$eva_control->resultado}}</td>
                                    <td>
{{--                                        <span data-toggle="modal" data-target="#modal_controles_factores_edit" ><a href="#!" class="btn btn-primary h-primary_m btn_edit_control_riesgo"  data-efectivo="{{$eva_control->efectivo}}" data-aplica="{{$eva_control->aplica}}" data-formalizado="{{$eva_control->formalizado}}" data-documentado="{{$eva_control->documentado}}" data-tipo_eva="{{$eva_control->id_tipo_eva}}" data-descripcion="{{$eva_control->descripcion}}" data-id="{{$eva_control->id_evaluacion}}" data-toggle="tooltip" data-placement="top" title="modificar"><span class="oi oi-pencil"></span></a></span>--}}
{{--                                        <span><a href="#!" class="btn btn-primary h-primary_m btn_delete_element_riesgo" data-toggle="tooltip" data-placement="top" title="Eliminar" data-id="{{$eva_control->id_evaluacion}}" data-url="{{url("riesgos/rievaluacioncontrol")}}"><span class="oi oi-trash"></span></a></span>--}}
                                        <a href="#!" class="pull-left btn_edit_control_riesgo" data-toggle="modal" data-target="#modal_controles_factores_edit" data-efectivo="{{$eva_control->efectivo}}" data-aplica="{{$eva_control->aplica}}" data-formalizado="{{$eva_control->formalizado}}" data-documentado="{{$eva_control->documentado}}" data-tipo_eva="{{$eva_control->id_tipo_eva}}" data-descripcion="{{$eva_control->descripcion}}" data-id="{{$eva_control->id_evaluacion}}" ><span class="glyphicon glyphicon-cog" data-toggle="tooltip" data-placement="top" title="modificar"></span></a>
                                        <a href="#!" class="pull-right btn_delete_element_riesgo" data-id="{{$eva_control->id_evaluacion}}" data-url="{{url("riesgos/rievaluacioncontrol")}}"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="top" title="Eliminar"></span></a>

                                    </td>
                                </tr>
                                @if($eva_control->documentado=="NO" || $eva_control->formalizado=="NO" || $eva_control->aplica=="NO" || $eva_control->efectivo=="NO")
                                    {{Session::put('controlado','NO')}}
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
        @endif
        <div class="tab-pane fade text-center" id="nav-estrategias{{$id_factor}}">
            <div class="row">
                 <div class="row col-md-12">
                    {{--<span data-toggle="modal" data-target="#modal_acciones_factores" class=""><a href="#!" class="btn btn-primary h-primary_m px-5 mb-2 btn_add_accion" data-id="{{$id_factor}}">Nueva Accion</a></span>--}}
                     <a href="#!" class="pull-right btn_add_accion" data-toggle="modal" data-target="#modal_acciones_factores" data-id="{{$id_factor}}"><span class="glyphicon glyphicon-plus"></span></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table class="table text-center my-0 border-table">
                        <thead class="text-center">
                        <tr class="table-active row">
                            <th class="text-center col-md-8">Accion</th>
                            <th class="text-center col-md-3">Fecha Inicio</th>
                            <th class="text-center col-md-3">Fecha Termino</th>
                            <th class="text-center col-md-3">Unidad Responsable</th>

                            <th class="text-center col-md-1">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ri_factor->riAcciones as $accion_factor)

                            <tr class="row">
                                <td class="col-md-8">{{$accion_factor->accion}}</td>
                                <td class="col-md-3">{{$accion_factor->fecha}}</td>
                                <td class="col-md-3">{{$accion_factor->fecha_final}}</td>
                                <td class="col-md-3">{{isset($accion_factor->getUnidadAdmin[0])?$accion_factor->getUnidadAdmin[0]->nom_departamento:""}}</td>
                                <td class="col-md-1">
                                    <a href="#!" class="pull-left btn_edit_control_riesgo" data-toggle="modal" data-target="#modal_acciones_edit" data-unidad_admin="{{$accion_factor->id_unidad_admin}}"data-fecha_final="{{$accion_factor->fecha_final}}" data-fecha="{{$accion_factor->fecha}}" data-accion="{{$accion_factor->accion}}" data-id="{{$accion_factor->id_estrategia_a}}" ><span class="glyphicon glyphicon-cog" data-toggle="tooltip" data-placement="top" title="modificar"></span></a>
                                    <a href="#!" class="pull-right btn_delete_element_riesgo" data-id="{{$accion_factor->id_estrategia_a}}" data-url="{{url("riesgos/riestrategiaccion")}}"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="top" title="Eliminar"></span></a>
                                    <br>
                                    <a href="#!" class="pull-left btn_add_evidencia_riesgo" data-id="{{$accion_factor->id_estrategia_a}}" data-toggle="modal" data-target="#modal_add_evidencia" ><span class="glyphicon glyphicon-file" data-toggle="tooltip" data-placement="top" title="Adjuntar evidencia"></span></a>
                                    @if($accion_factor->file!=null)

                                    <a href="{{asset("storage/".$accion_factor->file)}}" target="_blank"  class="pull-right  btn_add_evidencia_riesgo"><span class="glyphicon glyphicon-camera" data-toggle="tooltip" data-placement="top" title="Ver evidencia"></span></a>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#add_accion_control").click(function(){
                $('.nav-tabs a[href="#nav-estrategias{{$id_factor}}"]').tab('show');
                $("#cancel_accion_boton").attr("href","#nav-controles{{$id_factor}}");
            });

        })

    </script>
@endsection
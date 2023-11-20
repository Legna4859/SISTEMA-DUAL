@section('cont_modals_control')

<div class="modal fade" id="modal_controles_factores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog mt-2" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo control de riesgo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_eva_control" class="form" role="form" method="POST" action="{{url('riesgos/rievaluacioncontrol')}}"/>
            @csrf
            <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="id_factor_eva" name="id_factor_eva" value="">
                        <label for="" class="col-form-label">Descripcion</label>
                        <textarea class="form-control" name="descripcion_eva_control" id="descripcion_eva_control" cols="3" rows="3"></textarea>
                        <label for="" class="col-form-label">Tipo</label>
                        <select class="form-control" name="tipo_eva_control" id="tipo_eva_control">
                            <option value="" disabled="true" selected="true">Seleccione una opción</option>
                            @foreach($tipos_evas as $tipo_eva)
                                <option value="{{$tipo_eva->id_tipo_eva}}">{{$tipo_eva->des_eva}}</option>
                            @endforeach
                        </select>
                        <label for="" class="col-form-label">¿Está documentado?</label>
                        <select class="form-control" name="documentado_eva_control" id="documentado_eva_control">
                            <option value="" disabled="true" selected="true">Seleccione una opción</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                        <label for="" class="col-form-label">¿Está formalizado?</label>
                        <select class="form-control" name="formalizado_eva_control" id="formalizado_eva_control">
                            <option value="" disabled="true" selected="true">Seleccione una opción</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                        <label for="" class="col-form-label">¿Se aplica?</label>
                        <select class="form-control" name="aplica_eva_control" id="aplica_eva_control">
                            <option value="" disabled="true" selected="true">Seleccione una opción</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                        <label for="" class="col-form-label">¿Es efectivo?</label>
                        <select class="form-control" name="efectivo_eva_control" id="efectivo_eva_control">
                            <option value="" disabled="true" selected="true">Seleccione una opción</option>
                            <option value="SI">SI</option>
                            <option value="No">NO</option>
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
<div class="modal fade" id="modal_controles_factores_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog mt-2" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar control de riesgo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_edit_eva_control" class="form" role="form" method="POST" action=""/>
            @csrf
            @method("PUT")
            <div class="modal-body">
                <div class="form-group">

                    <label for="" class="col-form-label">Descripcion</label>
                    <textarea class="form-control" name="descripcion_eva_control_edit" id="descripcion_eva_control_edit" cols="3" rows="3"></textarea>
                    <label for="" class="col-form-label">Tipo</label>
                    <select class="form-control" name="tipo_eva_control_edit" id="tipo_eva_control_edit">
                        <option value="" disabled="true" selected="true">Seleccione una opción</option>
                        @foreach($tipos_evas as $tipo_eva)
                            <option value="{{$tipo_eva->id_tipo_eva}}">{{$tipo_eva->des_eva}}</option>
                        @endforeach
                    </select>
                    <label for="" class="col-form-label">¿Está documentado?</label>
                    <select class="form-control" name="documentado_eva_control_edit" id="documentado_eva_control_edit">
                        <option value="" disabled="true" selected="true">Seleccione una opción</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                    <label for="" class="col-form-label">¿Está formalizado?</label>
                    <select class="form-control" name="formalizado_eva_control_edit" id="formalizado_eva_control_edit">
                        <option value="" disabled="true" selected="true">Seleccione una opción</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                    <label for="" class="col-form-label">¿Se aplica?</label>
                    <select class="form-control" name="aplica_eva_control_edit" id="aplica_eva_control_edit">
                        <option value="" disabled="true" selected="true">Seleccione una opción</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                    <label for="" class="col-form-label">¿Es efectivo?</label>
                    <select class="form-control" name="efectivo_eva_control_edit" id="efectivo_eva_control_edit">
                        <option value="" disabled="true" selected="true">Seleccione una opción</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
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
    $(document).ready(function() {
        $("#form_add_eva_control").validate({
            rules: {
                descripcion_eva_control:{required:true,},
                tipo_eva_control:{required:true,},
                documentado_eva_control:{required:true,},
                formalizado_eva_control:{required:true,},
                aplica_eva_control:{required:true,},
                efectivo_eva_control:{required:true,},

            },
        });
        $("#form_edit_eva_control").validate({
            rules: {
                descripcion_eva_control_edit:{required:true,},
                tipo_eva_control_edit:{required:true,},
                documentado_eva_control_edit:{required:true,},
                formalizado_eva_control_edit:{required:true,},
                aplica_eva_control_edit:{required:true,},
                efectivo_eva_control_edit:{required:true,},

            },
        });
        $(".btn_edit_control_riesgo").click(function(){
            //console.log($(this).data("descripcion"));
            $("#descripcion_eva_control_edit").val($(this).data("descripcion"));
            $("#tipo_eva_control_edit").val($(this).data("tipo_eva"));
            $("#documentado_eva_control_edit").val($(this).data("documentado"));
            $("#formalizado_eva_control_edit").val($(this).data("formalizado"));
            $("#aplica_eva_control_edit").val($(this).data("aplica"));
            $("#efectivo_eva_control_edit").val($(this).data("efectivo"));
            $("#form_edit_eva_control").attr("action","{{url('riesgos/rievaluacioncontrol')}}/"+$(this).data("id"));
        });

        $(".btn_add_eva_control").click(function(){
            $("#id_factor_eva").val($(this).data("id"));
        });
    });
</script>
@endsection
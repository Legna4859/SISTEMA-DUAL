@section('cont_factores')
<div class="modal fade" id="modal_riesgos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo factor de riesgo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_factor_riesgo" class="form" role="form" method="POST" action="{{url('riesgos/reg_factor')}}"/>
            <div class="modal-body">
                <div class="form-group">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_registro_riesgo" id="id_registro_riesgo" value="{{$datos_registro_riesgo[0]->id_reg_riesgo}}">
                    <label for="" class="col-form-label">Descripcion</label>
                    <textarea class="form-control" name="descripcion_factor" id="descripcion_factor" cols="3" rows="3"></textarea>
                    <label for="" class="col-form-label">Clasificación Factor</label>
                    <select class="form-control" name="clasi_factor" id="clasi_factor">
                        <option value="0" disabled="true" selected="true">Seleccione una opción</option>
                        @foreach($clasificaciones_factor as $clasificacion_factor)
                            <option value="{{$clasificacion_factor->id_cl_f}}">{{$clasificacion_factor->des_cl_f}}</option>
                        @endforeach
                    </select>
                    <label for="" class="col-form-label">Tipo Factor</label>
                    <select class="form-control" name="tipo_factor" id="tipo_factor">
                        <option value="0" disabled="true" selected="true">Seleccione una opción</option>
                        @foreach($tipos_factor as $tipo_factor)
                            <option value="{{$tipo_factor->id_tipo_f}}">{{$tipo_factor->des_tf}}</option>
                        @endforeach
                    </select>
                    <label for="" class="col-form-label">¿Tiene controles?</label>
                    <select class="form-control" name="have_controls" id="have_controls">
                        <option value="0" disabled="true" selected="true">Seleccione una opción</option>
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

<div class="modal fade" id="modal_edit_factor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar factor de riesgo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_edit_factor_riesgo" class="form" role="form" method="POST" action=""/>
            <div class="modal-body">
                <div class="form-group">
                    @csrf
                    @method('PUT')
                    <label for="" class="col-form-label">Descripcion</label>
                    <textarea class="form-control" name="descripcion_factor_edit" id="descripcion_factor_edit" cols="3" rows="3"></textarea>
                    <label for="" class="col-form-label">Clasificación Factor</label>
                    <select class="form-control" name="clasi_factor_edit" id="clasi_factor_edit">
                        <option value="0" disabled="true" selected="true">Seleccione una opción</option>
                        @foreach($clasificaciones_factor as $clasificacion_factor)
                            <option value="{{$clasificacion_factor->id_cl_f}}">{{$clasificacion_factor->des_cl_f}}</option>
                        @endforeach
                    </select>
                    <label for="" class="col-form-label">Tipo Factor</label>
                    <select class="form-control" name="tipo_factor_edit" id="tipo_factor_edit">
                        <option value="0" disabled="true" selected="true">Seleccione una opción</option>
                        @foreach($tipos_factor as $tipo_factor)
                            <option value="{{$tipo_factor->id_tipo_f}}">{{$tipo_factor->des_tf}}</option>
                        @endforeach
                    </select>
                    <label for="" class="col-form-label">¿Tiene controles?</label>
                    <select class="form-control" name="have_controls_edit" id="have_controls_edit">
                        <option value="0" disabled="true" selected="true">Seleccione una opción</option>
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
        $("#form_add_factor_riesgo").validate({
            rules: {
                descripcion_factor: {
                    required: true,
                },
                clasi_factor: {
                    required: true,
                },
                tipo_factor: {
                    required: true,
                },
                have_controls: {
                    required: true,
                },
            },
        });
        $("#form_edit_factor_riesgo").validate({
            rules: {
                descripcion_factor_edit: {
                    required: true,
                },
                clasi_factor_edit: {
                    required: true,
                },
                tipo_factor_edit: {
                    required: true,
                },
                have_controls_edit: {
                    required: true,
                },
            },
        });
    });
</script>
@endsection
@section('modal_modiriesgo')
    <div class="modal fade" id="modal_modi_descRiesgo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Descripción del riesgp</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_modi_descRiesgo" class="form" role="form" method="POST" action="{{url('riesgos/registroriesgos')."/".$datos_registro_riesgo[0]->id_reg_riesgo}}">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group">
                            <label for="descripcion_efecto" class="col-form-label">Descripción del riesgo</label>
                            <textarea class="form-control" name="descripcion_riesgo" id="descripcion_riesgo" cols="3" rows="3"> {{$datos_registro_riesgo[0]->descip_riesgo}}</textarea>
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
            $("#form_modi_descRiesgo").validate({
                rules: {
                    descripcion_riesgo: {
                        required: true,
                    },
                },
            });
        });
    </script>
@endsection
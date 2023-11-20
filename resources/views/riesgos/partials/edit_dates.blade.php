@section('cont_modals_edit_dates')
    <div class="modal fade" id="modal_edit_date_accion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog mt-2" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar fecha</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_edit_date_riesgo" class="form" role="form" method="POST" action=""/>
                @csrf
                @method("PUT")
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="id_date_riesgo" value="">
                        <label for="fecha_final_edit_ri" class="col-form-label">Fecha Final</label>
                        <div class="input-group date" id="date_picker_group" data-provide="datepicker">
                            <input type="text" class="form-control" id="fecha_final_edit_ri" name="fecha_final_edit_ri"  />
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary h-secondary_m" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary h-primary_m" id="update_date_riesgo">Aceptar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection
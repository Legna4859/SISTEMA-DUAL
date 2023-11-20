@section('cont_modals_acciones')

    <div class="modal fade" id="modal_acciones_factores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog mt-2" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo accion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_add_accion" class="form" role="form" method="POST" action="{{url('riesgos/riestrategiaccion')}}"/>
                @csrf
                <div class="modal-body">

                    <input type="hidden" id="id_factor_accion" name="id_factor_accion" value="">

                    <div class="form-group">
                        <label for="" class="col-form-label">Acción</label>
                        <textarea name="desc_accion" id="desc_accion" cols="30" rows="3" class="form-control"></textarea>
                    </div>

                    <h3 class="alert alert-danger">Después de establecer las fechas no podrá realizar ningún cambio, asegúrese de verificar que sean correctas.</h3>
                    <div class="form-group">
                        <label for="fecha_entrega" class="col-form-label">Fecha Inicial</label>
                        <div class="input-group date" id="date_picker_group" data-provide="datepicker">
                            <input type="text" class="form-control" id="fecha_programada" name="fecha_programada" />
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fecha_final" class="col-form-label">Fecha Final</label>
                        <div class="input-group date" id="date_picker_group" data-provide="datepicker">
                            <input type="text" class="form-control" id="fecha_final" name="fecha_final" />
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="unidad_admin" class="col-form-label">Unidad Responsable</label>
                        <select  class="form-control" name="unidad_admin" id="unidad_admin">
                            <option value="0" disabled="true" selected="true">Seleccione una opción</option>

                        @foreach($unidad_administrativa as $unidad_admin)
                                <option value="{{$unidad_admin->id_unidad_admin}}">{{$unidad_admin->nom_departamento}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#!" id="cancel_accion_boton"  class="btn btn-secondary h-secondary_m" data-dismiss="modal">Cancelar</a>
                    <button type="submit" class="btn btn-primary h-primary_m">Aceptar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_acciones_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog mt-2" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar control de riesgo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_edit_accion" class="form" role="form" method="POST" action=""/>
                @csrf
                @method("PUT")
                <div class="modal-body">

                    <div class="form-group">
                        <label for="" class="col-form-label">Acción</label>
                        <textarea name="desc_accion_edit" id="desc_accion_edit" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="fecha_entrega" class="col-form-label">Fecha entrega</label>
                        <div class="input-group date" id="date_picker_group" data-provide="datepicker">
                            <input type="text" class="form-control" id="fecha_programada_edit" name="fecha_programada_edit"  disabled="true" />
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fecha_final_edit" class="col-form-label">Fecha Final</label>
                        <div class="input-group date" id="date_picker_group" data-provide="datepicker">
                            <input type="text" class="form-control" id="fecha_final_edit" name="fecha_final_edit" disabled="true"  />
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="unidad_admin_edit" class="col-form-label">Unidad Responsable</label>
                        <select  class="form-control" name="unidad_admin_edit" id="unidad_admin_edit">
                        <option value="0" disabled="true" selected="true">Seleccione una opción</option>

                        @foreach($unidad_administrativa as $unidad_admin)
                            <option value="{{$unidad_admin->id_unidad_admin}}">{{$unidad_admin->nom_departamento}}</option>
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

    <script>
        $(document).ready(function() {
            $(".btn_add_evidencia_riesgo").click(function(){

                        $("#form_add_evidencia").attr("action","{{url("riesgos/seguimiento/file_riesgo/")}}/"+$(this).data("id"));
            });
            $("#form_add_accion").validate({
                rules: {
                    desc_accion:{required:true,},
                    fecha_programada:{required:true,},
                    fecha_final:{required:true,},
                    unidad_admin:{required:true,},

                },
            });
            $("#form_edit_accion").validate({
                rules: {
                    desc_accion_edit:{required:true,},
                    fecha_programada_edit:{required:true,},
                    fecha_final_edit:{required:true,},
                    unidad_admin_edit:{required:true,},

                },
            });
            $(".btn_edit_control_riesgo").click(function(){
                //console.log($(this).data("descripcion"));
                $("#desc_accion_edit").val($(this).data("accion"));
                $("#fecha_programada_edit").val($(this).data("fecha"));
                $("#fecha_final_edit").val($(this).data("fecha_final"));
                $("#unidad_admin_edit").val($(this).data("unidad_admin"));
                $("#form_edit_accion").attr("action","{{url('riesgos/riestrategiaccion')}}/"+$(this).data("id"));
            });

            $(".btn_add_accion").click(function(){
                $("#id_factor_accion").val($(this).data("id"));
            });

            $('.date').datepicker({
                format: 'yyyy/mm/dd',
                language: 'es',
                autoclose: true,
                startDate: '+1d',

            });
            $("#cancel_accion_boton").click(function(){
                $('.nav-tabs a[href="'+$(this).attr('href')+'"]').tab('show');

                $("#cancel_accion_boton").attr("href","#!");
            });
        });
    </script>
@endsection
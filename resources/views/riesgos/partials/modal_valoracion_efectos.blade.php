@section('modal_valoracion_efectos')

    <div class="modal fade" id="modal_efectos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Evaluación de riesgos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_valoracion_efectos" class="form" role="form" method="POST" action="{{url('riesgos/valoracion_efectos')."/".$datos_registro_riesgo[0]->valEfectos[0]->id_val_efecto}}">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <input type="hidden" name="id_reg_riesgo_val_efec" id="id_reg_riesgo_val_efec" value="{{isset($datos_registro_riesgo[0]->id_reg_riesgo)?$datos_registro_riesgo[0]->id_reg_riesgo:""}}">
                        @foreach($datos_registro_riesgo[0]->estrategiaRiesgo as $estrategia)
                            <input type="hidden" name="id_estrategia_r" id="id_estrategia_r" value="{{$estrategia->id_estrategia_r}}">
                        @endforeach
                        <div class="form-group">
                            <label for="descripcion_efecto" class="col-form-label">Posibles efectos del riesgo</label>
                            <textarea class="form-control" name="descripcion_efecto" id="descripcion_efecto" cols="3" rows="3"> {{isset($datos_registro_riesgo[0]->valEfectos[0])?$datos_registro_riesgo[0]->valEfectos[0]->efecto:""}}</textarea>
                        </div>
                        <hr>
                        <h5 class="text-center">Valoracion inicial</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="grado_impacto" class="col-form-label">Grado de impacto</label>
                                <select class="form-control" name="grado_impacto" id="grado_impacto">
                                    <option value="" disabled="true" selected="true">Seleccione una opción</option>
                                    @for($i=1;$i<=10;$i++)
                                        <option {{($datos_registro_riesgo[0]->valEfectos[0]->grado_impacto==$i)?"selected":""}} value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="probabilidad_ocurrencia" class="col-form-label">Probabilidad de ocurrencia</label>
                                <select class="form-control" name="probabilidad_ocurrencia" id="probabilidad_ocurrencia">
                                    <option value="" disabled="true" selected="true">Seleccione una opción</option>
                                    @for($i=1;$i<=10;$i++)
                                        <option {{($datos_registro_riesgo[0]->valEfectos[0]->probabilidad==$i)?"selected":""}} value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div hidden class="row cuadrantes">
                            <div class="form-group col-md-6">
                                <label for="" class="col-form-label">Cuadrante</label>
                                <h4 class="cuadrante text-center"></h4>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="id_estrategia" class="col-form-label">Estrategias</label>
                                <select class="form-control" name="id_estrategia" id="id_estrategia">
                                    <option value="" disabled="true" selected="true">Seleccione una opción</option>
                                    
                                    @foreach($ri_estrategia as $estrategias)
                                        <option value="{{$estrategias->id_estrategia}}" {{(isset($datos_registro_riesgo[0]->estrategiaRiesgo[0]->getEstrategia[0]->id_estrategia)==$estrategias->id_estrategia)?"selected":""}} >{{$estrategias->descripcion}}</option>
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

    <div class="modal fade" id="modal_efectos_final" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Valoracion Final</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_valoracion_efectos" class="form" role="form" method="POST" action="{{url('riesgos/valoracion_efectos')."/".(isset($datos_registro_riesgo[0]->valEfectos[0])?$datos_registro_riesgo[0]->valEfectos[0]->id_val_efecto:"")}}">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <input type="hidden" name="id_reg_riesgo_val_efec" id="id_reg_riesgo_val_efec" value="{{$datos_registro_riesgo[0]->id_reg_riesgo}}">
                        <h5 class="text-center">Valoracion final</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="impacto_final" class="col-form-label">Grado de impacto</label>
                                <select class="form-control" name="impacto_final" id="impacto_final">
                                    <option value="" disabled="true" selected="true">Seleccione una opción</option>
                                    @for($i=1;$i<=10;$i++)
                                        <option {{($datos_registro_riesgo[0]->valEfectos[0]->impacto_final==$i)?"selected":""}} value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ocurrencia_final" class="col-form-label">Probabilidad de ocurrencia</label>
                                <select class="form-control" name="ocurrencia_final" id="ocurrencia_final">
                                    <option value="" disabled="true" selected="true">Seleccione una opción</option>
                                    @for($i=1;$i<=10;$i++)
                                        <option {{($datos_registro_riesgo[0]->valEfectos[0]->ocurrencia_final==$i)?"selected":""}} value="{{$i}}">{{$i}}</option>
                                    @endfor
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

    <script>
        $(document).ready(function() {
            if($("#probabilidad_ocurrencia").val()>0&&$("#grado_impacto").val()){
                // $(".cuadrantes").fadeIn(0);
                setCuadrante()
            }
            $("#form_valoracion_efectos").validate({
                rules: {
                    probabilidad_ocurrencia: {
                        required: true,
                    },
                    descripcion_efecto: {
                        required: true,
                    },
                    grado_impacto: {
                        required: true,
                    },
                },
            });
            $("#probabilidad_ocurrencia, #grado_impacto").change( function () {
                if ($("#grado_impacto").val()>0 && $("#probabilidad_ocurrencia").val()>0) {
                    setCuadrante();

                }
                $("#id_estrategia").val("");

            });

        });
        function setCuadrante(){
            var ocurrencia=$("#probabilidad_ocurrencia").val();
            var impacto=$("#grado_impacto").val();
            $("option").each(function () {
                if($(this).html().toString().toLowerCase()=="asumir el riesgo"){
                    $(this).hide();
                }
            })
            if (ocurrencia<=5) {
                if(impacto<=5) {
                    $(".cuadrante").html("III").removeClass().addClass('cuadrante text-center btn-success');
                    $("option").each(function () {
                        if($(this).html().toString().toLowerCase()=="asumir el riesgo"){
                            $(this).show();
                        }
                    })
                }
                else $(".cuadrante").html("IV").removeClass().addClass('cuadrante text-center btn-info');
            }
            else {
                if(impacto<=5) $(".cuadrante").html("II").removeClass().addClass('cuadrante text-center btn-warning');
                else $(".cuadrante").html("I").removeClass().addClass('cuadrante text-center btn-danger');
            }
            $(".cuadrantes").fadeIn(500);
        }
    </script>
@endsection
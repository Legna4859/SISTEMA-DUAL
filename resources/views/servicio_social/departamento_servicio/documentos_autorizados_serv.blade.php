
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-success">

            <div class="panel-body">
                <label>No. Cuenta : {{ $registro_tipo_empresa[0]->cuenta }}</label>
                <label>Nombre de  Estudiante: {{ $registro_tipo_empresa[0]->nombre }} {{ $registro_tipo_empresa[0]->apaterno }} {{ $registro_tipo_empresa[0]->amaterno }} </label>
                <label>Tipo de Empresa: {{ $registro_tipo_empresa[0]->tipo_empresa }}</label>

            </div>
        </div>

    </div>
</div>
@if($tipo_empresa == 1)
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        <div class="col-md-7 col-md-offset-1">
                            <label>Carta de aceptación (solo empresa privada): <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_carta_aceptacion)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                        </div>
                </div>
            </div>
        </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        <div class="col-md-7 col-md-offset-1">
                            <label>Anexo Tecnico (solo empresa privada):<a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_anexo_tecnico)}}" class="btn btn-success">Ver PDF</a> </label>

                        </div>

                </div>
            </div>
        </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        <div class="col-md-7 col-md-offset-1">
                            <label>Copia de tu CURP: <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_curp)}}" class="btn btn-success">Ver PDF</a></label>

                        </div>

                </div>
            </div>
        </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        <div class="col-md-7 col-md-offset-1">
                            <label>Copia de tu Carnet: <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_carnet)}}" class="btn btn-success">Ver PDF</a></label>

                        </div>

                </div>
            </div>
        </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        <div class="col-md-7 col-md-offset-1">
                            <label>Constancia original del 50% de creditos: <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_constancia_creditos)}}" class="btn btn-success">Ver PDF</a></label>

                        </div>

                </div>
            </div>
        </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        <div class="col-md-7 col-md-offset-1">
                            <label>Solicitud de registro de autorización: <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_solicitud_reg_autori)}}" class="btn btn-success">Ver PDF</a></label>

                        </div>

                </div>
            </div>
        </div>
        </div>
@elseif($tipo_empresa == 2)

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        <div class="col-md-7 col-md-offset-1">
                            <label>Copia de tu CURP: <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_curp)}}" class="btn btn-success">Ver PDF</a></label>

                        </div>

                </div>
            </div>
        </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="col-md-7 col-md-offset-1">
                                <label>Copia de tu Carnet: <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_carnet)}}" class="btn btn-success">Ver PDF</a></label>

                            </div>

                        </div>
                    </div>
                </div>
            </div>



        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        <div class="col-md-7 col-md-offset-1">
                            <label>Constancia original del 50% de creditos: <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_constancia_creditos)}}" class="btn btn-success">Ver PDF</a></label>

                        </div>

                </div>
            </div>
        </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        <div class="col-md-6 col-md-offset-1">
                            <label>Solicitud de registro de autorización: <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_solicitud_reg_autori)}}" class="btn btn-success">Ver PDF</a></label>

                        </div>

                </div>
            </div>
        </div>

@endif
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-success">

            <div class="panel-body">
                <label>No. Cuenta : {{ $alumno->cuenta }}</label>
                <label>Nombre de  Estudiante: {{ $alumno->nombre }} {{ $alumno->apaterno }} {{ $alumno->amaterno }} </label>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                    <div class="col-md-7 col-md-offset-1">
                        <label>Solicitud de Residencia Profesional: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_solicitud_residencia)}}" class="btn btn-success">Ver PDF</a> </label> </label>

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
                        <label>Constancia de 80% de avance académico: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_constancia_avance_academico)}}" class="btn btn-success">Ver PDF</a> </label> </label>

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
                        <label>Comprobante de seguro médico (IMSS, ISSSTE, ISSEMYM, etc.): <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_comprobante_seguro)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                    </div>

                </div>
               >
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                    <div class="col-md-7 col-md-offset-1">
                        <label>Oficio de Asignación del Proyecto emitido por la Jefatura de División: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_oficio_asignacion_jefatura)}}" class="btn btn-success">Ver PDF</a> </label> </label>

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
                        <label>Oficio de Aceptación por parte de la empresa en hoja Membretada: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_oficio_aceptacion_empresa)}}" class="btn btn-success">Ver PDF</a> </label> </label>

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
                        <label>Oficio de Presentación por parte del TESVB: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_oficio_presentacion_tecnologico)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                    </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                    <div class="col-md-7 col-md-offset-1">
                        <label>Anteproyecto con el Visto Bueno de la Academia: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_anteproyecto)}}" class="btn btn-success">Ver PDF</a> </label> </label>

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
                        <label>Carta de compromiso firmada por el Asesor Interno y revisor: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_carta_compromiso)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($documentos->id_estado_convenio == 1)
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        <div class="col-md-7 col-md-offset-1">
                            <label>Convenio con la empresa (opcional): <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_convenio_empresa)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif




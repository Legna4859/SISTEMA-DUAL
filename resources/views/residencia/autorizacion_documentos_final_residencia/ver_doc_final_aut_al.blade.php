<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-success">

            <div class="panel-body">
                <label>No. Cuenta : {{ $alumno[0]->cuenta }}</label>
                <label>Nombre de  Estudiante: {{ $alumno[0]->alumno }} {{ $alumno[0]->apaterno }} {{ $alumno[0]->amaterno }} </label>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">

                        <div class="col-md-10 col-md-offset-1" >
                            <label>Acta de Calificación de Residencia Profesional: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_acta_calificacion)}}" class="btn btn-success">Ver PDF</a> </label>
                        </div>
                        <input type="hidden" name="acta_calificacion" id="acta_calificacion" value="{{$alumno[0]->estado_acta_calificacion}}" >



                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                        <div class="col-md-10 col-md-offset-1" >
                            <label>Proyecto Completo de Residencia Profesional:  Fue enviado a su correo.</label>
                        </div>



                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">

                        <div class="col-md-10 col-md-offset-1" >
                            <label>Portada de Proyecto de Residencia Profesional: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_portada)}}" class="btn btn-success">Ver PDF</a> </label>

                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                         <div class="col-md-10 col-md-offset-1" >
                            <label>Evaluación Final de Residencia Profesional: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_evaluacion_final_residencia)}}" class="btn btn-success">Ver PDF</a> </label>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                         <div class="col-md-10 col-md-offset-1" >
                            <label>Oficio de Aceptación de Informe  Final del Asesor  Interno: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_oficio_aceptacion_informe_interno)}}" class="btn btn-success">Ver PDF</a> </label>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">

                        <div class="col-md-10 col-md-offset-1" >
                            <label>Formato de Evaluación: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_formato_evaluacion)}}" class="btn btn-success">Ver PDF</a> </label>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                        <div class="col-md-10 col-md-offset-1" >
                            <label>Oficio de Aceptación de Informe Final del Revisor: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_oficio_aceptacion_informe_revisor)}}" class="btn btn-success">Ver PDF</a> </label>

                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                         <div class="col-md-10 col-md-offset-1" >
                            <label>Oficio de Aceptación de Informe Final del Asesor Externo: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_oficio_aceptacion_informe_externo)}}" class="btn btn-success">Ver PDF</a> </label>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                        <div class="col-md-10 col-md-offset-1" >
                            <label>Formato de Horas: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_formato_hora)}}" class="btn btn-success">Ver PDF</a> </label>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                        <div class="col-md-10 col-md-offset-1" >
                            <label>Formato de Seguimiento Interno: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_seguimiento_interno)}}" class="btn btn-success">Ver PDF</a> </label>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                        <div class="col-md-10 col-md-offset-1" >
                            <label>Formato de Seguimiento Externo: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_seguimiento_externo)}}" class="btn btn-success">Ver PDF</a> </label>

                        </div>
                        <input type="hidden" name="seguimiento_externo" id="seguimiento_externo" value="{{$alumno[0]->estado_seguimiento_externo}}" >


                </div>
            </div>
        </div>
    </div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

</div>
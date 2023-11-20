<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-success">

            <div class="panel-body" style="text-align: center">
                <label>No. Cuenta : {{ $alumno[0]->cuenta }}</label>
                <label>Nombre de  Estudiante: {{ $alumno[0]->alumno }} {{ $alumno[0]->apaterno }} {{ $alumno[0]->amaterno }} </label>
            </div>
        </div>
    </div>
</div>
<form class="form" action="{{url("/residencia/enviar_doc_final_dep/".$alumno[0]->id_liberacion_documentos)}}"   role="form" method="POST" >
    {{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="col-md-7 col-md-offset-1">
                    <label>Acta de Calificación de Residencia Profesional: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_acta_calificacion)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                </div>
                <div class="col-md-3" style="text-align: left">
                    <select name="acta_calificacion" id="acta_calificacion" class="form-control" required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">Rechazado</option>
                        <option value="2">Autorizado</option>
                    </select>
                </div>
            </div>
            <div class="row" id="comentario_acta_calificacion" style="display:none;">

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="col-md-7 col-md-offset-1">
                    <label>Proyecto Completo de Residencia Profesional: <b style="color: red">Fue enviado a su correo</b></label>  </label>

                </div>
                <div class="col-md-3" style="text-align: left">
                    <select name="proyecto" id="proyecto" class="form-control" required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">Rechazado</option>
                        <option value="2">Autorizado</option>
                    </select>
                </div>
            </div>
            <div class="row" id="comentario_proyecto" style="display:none;">

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="col-md-7 col-md-offset-1">
                    <label>Portada de Proyecto de Residencia Profesional: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_portada)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                </div>
                <div class="col-md-3" style="text-align: left">
                    <select name="portada" id="portada" class="form-control" required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">Rechazado</option>
                        <option value="2">Autorizado</option>
                    </select>
                </div>
            </div>
            <div class="row" id="comentario_portada" style="display:none;">

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="col-md-7 col-md-offset-1">
                    <label>Evaluación Final de Residencia Profesional: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_evaluacion_final_residencia)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                </div>
                <div class="col-md-3" style="text-align: left">
                    <select name="evaluacion_final_residencia" id="evaluacion_final_residencia" class="form-control" required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">Rechazado</option>
                        <option value="2">Autorizado</option>
                    </select>
                </div>
            </div>
            <div class="row" id="comentario_evaluacion_final_residencia" style="display:none;">

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="col-md-7 col-md-offset-1">
                    <label>Oficio de Aceptación de Informe  Final del Asesor  Interno: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_oficio_aceptacion_informe_interno)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                </div>
                <div class="col-md-3" style="text-align: left">
                    <select name="oficio_aceptacion_informe_interno" id="oficio_aceptacion_informe_interno" class="form-control" required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">Rechazado</option>
                        <option value="2">Autorizado</option>
                    </select>
                </div>
            </div>
            <div class="row" id="comentario_oficio_aceptacion_informe_interno" style="display:none;">

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="col-md-7 col-md-offset-1">
                    <label>Formato de Evaluación: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_formato_evaluacion)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                </div>
                <div class="col-md-3" style="text-align: left">
                    <select name="formato_evaluacion" id="formato_evaluacion" class="form-control" required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">Rechazado</option>
                        <option value="2">Autorizado</option>
                    </select>
                </div>
            </div>
            <div class="row" id="comentario_formato_evaluacion" style="display:none;">

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="col-md-7 col-md-offset-1">
                    <label>Oficio de Aceptación de Informe Final del Revisor: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_oficio_aceptacion_informe_revisor)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                </div>
                <div class="col-md-3" style="text-align: left">
                    <select name="oficio_aceptacion_informe_revisor" id="oficio_aceptacion_informe_revisor" class="form-control" required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">Rechazado</option>
                        <option value="2">Autorizado</option>
                    </select>
                </div>
            </div>
            <div class="row" id="comentario_oficio_aceptacion_informe_revisor" style="display:none;">

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="col-md-7 col-md-offset-1">
                    <label>Oficio de Aceptación de Informe Final del Asesor Externo: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_oficio_aceptacion_informe_externo)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                </div>
                <div class="col-md-3" style="text-align: left">
                    <select name="oficio_aceptacion_informe_externo" id="oficio_aceptacion_informe_externo" class="form-control" required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">Rechazado</option>
                        <option value="2">Autorizado</option>
                    </select>
                </div>
            </div>
            <div class="row" id="comentario_oficio_aceptacion_informe_externo" style="display:none;">

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="col-md-7 col-md-offset-1">
                    <label>Formato de Horas: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_formato_hora)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                </div>
                <div class="col-md-3" style="text-align: left">
                    <select name="formato_hora" id="formato_hora" class="form-control" required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">Rechazado</option>
                        <option value="2">Autorizado</option>
                    </select>
                </div>
            </div>
            <div class="row" id="comentario_formato_hora" style="display:none;">

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="col-md-7 col-md-offset-1">
                    <label>Formato de Seguimiento Interno: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_seguimiento_interno)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                </div>
                <div class="col-md-3" style="text-align: left">
                    <select name="seguimiento_interno" id="seguimiento_interno" class="form-control" required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">Rechazado</option>
                        <option value="2">Autorizado</option>
                    </select>
                </div>
            </div>
            <div class="row" id="comentario_seguimiento_interno" style="display:none;">

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="col-md-7 col-md-offset-1">
                    <label>Formato de Seguimiento Externo: <a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$alumno[0]->pdf_seguimiento_externo)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                </div>
                <div class="col-md-3" style="text-align: left">
                    <select name="seguimiento_externo" id="seguimiento_externo" class="form-control" required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">Rechazado</option>
                        <option value="2">Autorizado</option>
                    </select>
                </div>
            </div>
            <div class="row" id="comentario_seguimiento_externo" style="display:none;">

            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="submit" class="btn btn-primary">Enviar</button>
</div>
</form>
<script type="text/javascript">
    $(document).ready( function() {
        $("#acta_calificacion").change(function (e) {
            var id_acta_calificacion = e.target.value;
            $('#comentario_acta_calificacion').empty();
            if (id_acta_calificacion == 1) {

                $("#comentario_acta_calificacion").css("display", "block");
                $('#comentario_acta_calificacion').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación de la Acta de Calificación de Residencia Profesional</label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_acta_calificacion\" name=\"comentario_acta_calificacion\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_acta_calificacion == 2) {
                $("#comentario_acta_calificacion").css("display", "none");

            }
        });
        $("#proyecto").change(function (e) {
            var id_proyecto = e.target.value;
            $('#comentario_proyecto').empty();
            if (id_proyecto == 1) {

                $("#comentario_proyecto").css("display", "block");
                $('#comentario_proyecto').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para del Proyecto Completo de Residencia Profesional</label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_proyecto\" name=\"comentario_proyecto\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_acta_calificacion == 2) {
                $("#comentario_acta_calificacion").css("display", "none");

            }
        });
        $("#portada").change(function (e) {
            var id_portada = e.target.value;
            $('#comentario_portada').empty();
            if (id_portada == 1) {

                $("#comentario_portada").css("display", "block");
                $('#comentario_portada').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para de la Portada de Proyecto de Residencia Profesional</label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_portada\" name=\"comentario_portada\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_portada == 2) {
                $("#comentario_portada").css("display", "none");

            }
        });
        $("#evaluacion_final_residencia").change(function (e) {
            var id_evaluacion_final_residencia = e.target.value;
            $('#comentario_evaluacion_final_residencia').empty();
            if (id_evaluacion_final_residencia == 1) {

                $("#comentario_evaluacion_final_residencia").css("display", "block");
                $('#comentario_evaluacion_final_residencia').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación de la Evaluación Final de Residencia Profesional</label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_evaluacion_final_residencia\" name=\"comentario_evaluacion_final_residencia\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_evaluacion_final_residencia == 2) {
                $("#comentario_evaluacion_final_residencia").css("display", "none");

            }
        });
        $("#oficio_aceptacion_informe_interno").change(function (e) {
            var id_oficio_aceptacion_informe_interno = e.target.value;
            $('#comentario_oficio_aceptacion_informe_interno').empty();
            if (id_oficio_aceptacion_informe_interno == 1) {

                $("#comentario_oficio_aceptacion_informe_interno").css("display", "block");
                $('#comentario_oficio_aceptacion_informe_interno').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación del Oficio de Aceptación de Informe  Final del Asesor  Interno </label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_oficio_aceptacion_informe_interno\" name=\"comentario_oficio_aceptacion_informe_interno\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_oficio_aceptacion_informe_interno == 2) {
                $("#comentario_oficio_aceptacion_informe_interno").css("display", "none");

            }
        });
        $("#formato_evaluacion").change(function (e) {
            var id_formato_evaluacion = e.target.value;
            $('#comentario_formato_evaluacion').empty();
            if (id_formato_evaluacion == 1) {

                $("#comentario_formato_evaluacion").css("display", "block");
                $('#comentario_formato_evaluacion').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación del Formato de Evaluación </label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_formato_evaluacion\" name=\"comentario_formato_evaluacion\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_formato_evaluacion == 2) {
                $("#comentario_formato_evaluacion").css("display", "none");

            }
        });
        $("#oficio_aceptacion_informe_revisor").change(function (e) {
            var id_oficio_aceptacion_informe_revisor = e.target.value;
            $('#comentario_oficio_aceptacion_informe_revisor').empty();
            if (id_oficio_aceptacion_informe_revisor == 1) {

                $("#comentario_oficio_aceptacion_informe_revisor").css("display", "block");
                $('#comentario_oficio_aceptacion_informe_revisor').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación del Oficio de Aceptación de Informe Final del Revisor </label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_oficio_aceptacion_informe_revisor\" name=\"comentario_oficio_aceptacion_informe_revisor\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_oficio_aceptacion_informe_revisor == 2) {
                $("#comentario_oficio_aceptacion_informe_revisor").css("display", "none");

            }
        });
        $("#oficio_aceptacion_informe_externo").change(function (e) {
            var id_oficio_aceptacion_informe_externo = e.target.value;
            $('#comentario_oficio_aceptacion_informe_externo').empty();
            if (id_oficio_aceptacion_informe_externo == 1) {

                $("#comentario_oficio_aceptacion_informe_externo").css("display", "block");
                $('#comentario_oficio_aceptacion_informe_externo').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación del Oficio de Aceptación de Informe Final del Asesor Externo </label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_oficio_aceptacion_informe_externo\" name=\"comentario_oficio_aceptacion_informe_externo\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_oficio_aceptacion_informe_externo == 2) {
                $("#comentario_oficio_aceptacion_informe_externo").css("display", "none");

            }
        });
        $("#formato_hora").change(function (e) {
            var id_formato_hora = e.target.value;
            $('#comentario_formato_hora').empty();
            if (id_formato_hora == 1) {

                $("#comentario_formato_hora").css("display", "block");
                $('#comentario_formato_hora').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación del Formato de Horas </label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_formato_hora\" name=\"comentario_formato_hora\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_formato_hora == 2) {
                $("#comentario_formato_hora").css("display", "none");

            }
        });
        $("#seguimiento_interno").change(function (e) {
            var id_seguimiento_interno = e.target.value;
            $('#comentario_seguimiento_interno').empty();
            if (id_seguimiento_interno == 1) {

                $("#comentario_seguimiento_interno").css("display", "block");
                $('#comentario_seguimiento_interno').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación del Formato de Seguimiento Interno </label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_seguimiento_interno\" name=\"comentario_seguimiento_interno\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_seguimiento_interno == 2) {
                $("#comentario_seguimiento_interno").css("display", "none");

            }
        });
        $("#seguimiento_externo").change(function (e) {
            var id_seguimiento_externo = e.target.value;
            $('#comentario_seguimiento_externo').empty();
            if (id_seguimiento_externo == 1) {

                $("#comentario_seguimiento_externo").css("display", "block");
                $('#comentario_seguimiento_externo').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación del Formato de Seguimiento Externo </label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_seguimiento_externo\" name=\"comentario_seguimiento_externo\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_seguimiento_externo == 2) {
                $("#comentario_seguimiento_externo").css("display", "none");

            }
        });








    });
</script>
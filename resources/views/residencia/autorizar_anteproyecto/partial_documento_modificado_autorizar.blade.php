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
<form class="form" action="{{url("/residencia/enviar_alumno_documentacion_sin_convenio/".$documentos->id_alumno."/".$documentos->id_periodo."/".$documentos->id_estado_convenio)}}"  id="formulario_empresa_privada" role="form" method="POST" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                    @if($documentos->solicitud_residencia == 2)
                        <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                            <label>Solicitud de Residencia Profesional: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_solicitud_residencia)}}" class="btn btn-success">Ver PDF</a> </label> </label>
                        <b>Autorizado</b>
                        </div>
                        <input type="hidden" name="solicitud_residencia" id="solicitud_residencia" value="{{$documentos->solicitud_residencia}}" >

                    @else
                    <div class="col-md-7 col-md-offset-1">
                        <label>Solicitud de Residencia Profesional: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_solicitud_residencia)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                    </div>
                        <div class="col-md-3" style="text-align: left">

                            <select name="solicitud_residencia" id="solicitud_residencia" class="form-control" required>
                                    <option value=1 selected="selected">Rechazado</option>
                                    <option value="2">Autorizado</option>
                            </select>
                        </div>

                <div class="row" id="comentario_solicitud_residencia" style="">
                    <div class="col-md-10 col-md-offset-1 ">
                        <div class="form-group">
                            <label for="domicilio3">Comentario para la modificación de la Solicitud de Residencia Profesional</label>
                            <textarea class="form-control" id="comentario_solicitud_residencia" name="comentario_solicitud_residencia" rows="2"   required>{{ $documentos->comentario_solicitud_residencia }}</textarea>
                        </div>
                    </div>
                </div>

                @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                    @if($documentos->constancia_avance_academico == 2)
                        <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                            <label>Constancia de 80% de avance académico: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_constancia_avance_academico)}}" class="btn btn-success">Ver PDF</a> </label> </label>
                            <b>Autorizado</b>
                        </div>
                        <input type="hidden" name="constancia_avance_academico" id="constancia_avance_academico" value="{{$documentos->constancia_avance_academico}}" >

                    @else
                    <div class="col-md-7 col-md-offset-1">
                        <label>Constancia de 80% de avance académico: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_constancia_avance_academico)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                    </div>
                        <div class="col-md-3" style="text-align: left">

                            <select name="constancia_avance_academico" id="constancia_avance_academico" class="form-control" required>
                                <option value=1 selected="selected">Rechazado</option>
                                <option value="2">Autorizado</option>
                            </select>
                        </div>

                        <div class="row" id="comentario_constancia_avance_academico" style="">
                            <div class="col-md-10 col-md-offset-1 ">
                                <div class="form-group">
                                    <label for="domicilio3">Comentario para la modificación de la Constancia de 80% de avance académico</label>
                                    <textarea class="form-control" id="comentario_constancia_avance_academico" name="comentario_constancia_avance_academico" rows="2"   required>{{ $documentos->comentario_constancia_avance_academico }}</textarea>
                                </div>
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                    @if($documentos->comprobante_seguro == 2)
                        <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                            <label>Comprobante de seguro médico (IMSS, ISSSTE, ISSEMYM, etc.): <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_comprobante_seguro)}}" class="btn btn-success">Ver PDF</a> </label> </label>
                            <b>Autorizado</b>
                        </div>
                        <input type="hidden" name="comprobante_seguro" id="comprobante_seguro" value="{{$documentos->comprobante_seguro}}" >

                    @else
                    <div class="col-md-7 col-md-offset-1">
                        <label>Comprobante de seguro médico (IMSS, ISSSTE, ISSEMYM, etc.): <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_comprobante_seguro)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                    </div>
                        <div class="col-md-3" style="text-align: left">

                            <select name="comprobante_seguro" id="comprobante_seguro" class="form-control" required>
                                <option value=1 selected="selected">Rechazado</option>
                                <option value="2">Autorizado</option>
                            </select>
                        </div>

                        <div class="row" id="comentario_comprobante_seguro" style="">
                            <div class="col-md-10 col-md-offset-1 ">
                                <div class="form-group">
                                    <label for="domicilio3">Comentario para la modificación del Comprobante de seguro médico (IMSS, ISSSTE, ISSEMYM, etc.)</label>
                                    <textarea class="form-control" id="comentario_comprobante_seguro" name="comentario_comprobante_seguro" rows="2"   required>{{ $documentos->comentario_comprobante_seguro }}</textarea>
                                </div>
                            </div>
                        </div>

                    @endif
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                    @if($documentos->oficio_asignacion_jefatura == 2)
                        <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                            <label>Oficio de Asignación del Proyecto emitido por la Jefatura de División: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_oficio_asignacion_jefatura)}}" class="btn btn-success">Ver PDF</a> </label> </label>
                            <b>Autorizado</b>
                        </div>
                        <input type="hidden" name="oficio_asignacion_jefatura" id="oficio_asignacion_jefatura" value="{{$documentos->oficio_asignacion_jefatura}}" >

                    @else
                    <div class="col-md-7 col-md-offset-1">

                    </div>
                        <div class="col-md-3" style="text-align: left">

                            <select name="oficio_asignacion_jefatura" id="oficio_asignacion_jefatura" class="form-control" required>
                                <option value=1 selected="selected">Rechazado</option>
                                <option value="2">Autorizado</option>
                            </select>
                        </div>

                        <div class="row" id="comentario_oficio_asignacion_jefatura" style="">
                            <div class="col-md-10 col-md-offset-1 ">
                                <div class="form-group">
                                    <label for="domicilio3">Comentario para la modificación del Oficio de Asignación del Proyecto emitido por la Jefatura de División</label>
                                    <textarea class="form-control" id="comentario_oficio_asignacion_jefatura" name="comentario_oficio_asignacion_jefatura" rows="2"   required>{{ $documentos->comentario_oficio_asignacion_jefatura }}</textarea>
                                </div>
                            </div>
                        </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                    @if($documentos->oficio_aceptacion_empresa == 2)
                        <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                            <label>Oficio de Aceptación por parte de la empresa en hoja Membretada: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_oficio_aceptacion_empresa)}}" class="btn btn-success">Ver PDF</a> </label> </label>
                            <b>Autorizado</b>
                        </div>
                        <input type="hidden" name="oficio_aceptacion_empresa" id="oficio_aceptacion_empresa" value="{{$documentos->oficio_aceptacion_empresa}}" >

                    @else
                    <div class="col-md-7 col-md-offset-1">
                        <label>Oficio de Aceptación por parte de la empresa en hoja Membretada: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_oficio_aceptacion_empresa)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                    </div>
                        <div class="col-md-3" style="text-align: left">

                            <select name="oficio_aceptacion_empresa" id="oficio_aceptacion_empresa" class="form-control" required>
                                <option value=1 selected="selected">Rechazado</option>
                                <option value="2">Autorizado</option>
                            </select>
                        </div>

                        <div class="row" id="comentario_oficio_aceptacion_empresa" style="">
                            <div class="col-md-10 col-md-offset-1 ">
                                <div class="form-group">
                                    <label for="domicilio3">Comentario para la modificación del Oficio de Aceptación por parte de la empresa en hoja Membretada</label>
                                    <textarea class="form-control" id="comentario_oficio_aceptacion_empresa" name="comentario_oficio_aceptacion_empresa" rows="2"   required>{{ $documentos->comentario_oficio_aceptacion_empresa }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                    @if($documentos->oficio_presentacion_tecnologico == 2)
                        <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                            <label>Oficio de Presentación por parte del TESVB: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_oficio_presentacion_tecnologico)}}" class="btn btn-success">Ver PDF</a> </label> </label>
                            <b>Autorizado</b>
                        </div>
                        <input type="hidden" name="oficio_presentacion_tecnologico" id="oficio_presentacion_tecnologico" value="{{$documentos->oficio_presentacion_tecnologico}}" >

                    @else
                    <div class="col-md-7 col-md-offset-1">
                        <label>Oficio de Presentación por parte del TESVB: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_oficio_presentacion_tecnologico)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                    </div>
                        <div class="col-md-3" style="text-align: left">

                            <select name="oficio_presentacion_tecnologico" id="oficio_presentacion_tecnologico" class="form-control" required>
                                <option value=1 selected="selected">Rechazado</option>
                                <option value="2">Autorizado</option>
                            </select>
                        </div>

                        <div class="row" id="comentario_oficio_presentacion_tecnologico" style="">
                            <div class="col-md-10 col-md-offset-1 ">
                                <div class="form-group">
                                    <label for="domicilio3">Comentario para la modificación del Oficio de Presentación por parte del TESVB</label>
                                    <textarea class="form-control" id="comentario_oficio_presentacion_tecnologico" name="comentario_oficio_presentacion_tecnologico" rows="2"   required>{{ $documentos->comentario_oficio_presentacion_tecnologico }}</textarea>
                                </div>
                            </div>
                        </div>
                   @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                    @if($documentos->anteproyecto == 2)
                        <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                            <label>Anteproyecto con el Visto Bueno de la Academia: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_anteproyecto)}}" class="btn btn-success">Ver PDF</a> </label> </label>
                            <b>Autorizado</b>
                        </div>
                        <input type="hidden" name="anteproyecto" id="anteproyecto" value="{{$documentos->anteproyecto}}" >

                    @else
                    <div class="col-md-7 col-md-offset-1">
                        <label>Anteproyecto con el Visto Bueno de la Academia: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_anteproyecto)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                    </div>
                        <div class="col-md-3" style="text-align: left">

                            <select name="anteproyecto" id="anteproyecto" class="form-control" required>
                                <option value=1 selected="selected">Rechazado</option>
                                <option value="2">Autorizado</option>
                            </select>
                        </div>

                        <div class="row" id="comentario_anteproyecto" style="">
                            <div class="col-md-10 col-md-offset-1 ">
                                <div class="form-group">
                                    <label for="domicilio3">Comentario para la modificación del Anteproyecto con el Visto Bueno de la Academia</label>
                                    <textarea class="form-control" id="comentario_anteproyecto" name="comentario_anteproyecto" rows="2"   required>{{ $documentos->comentario_anteproyecto }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                    @if($documentos->carta_compromiso == 2)
                        <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                            <label>Carta de compromiso firmada por el Asesor Interno y revisor: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_carta_compromiso)}}" class="btn btn-success">Ver PDF</a> </label> </label>
                            <b>Autorizado</b>
                        </div>
                        <input type="hidden" name="carta_compromiso" id="carta_compromiso" value="{{$documentos->carta_compromiso}}" >

                    @else
                    <div class="col-md-7 col-md-offset-1">
                        <label>Carta de compromiso firmada por el Asesor Interno y revisor: <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_carta_compromiso)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                    </div>
                        <div class="col-md-3" style="text-align: left">

                            <select name="carta_compromiso" id="carta_compromiso" class="form-control" required>
                                <option value=1 selected="selected">Rechazado</option>
                                <option value="2">Autorizado</option>
                            </select>
                        </div>

                        <div class="row" id="comentario_carta_compromiso" style="">
                            <div class="col-md-10 col-md-offset-1 ">
                                <div class="form-group">
                                    <label for="domicilio3">Comentario para la modificación de la Carta de compromiso firmada por el Asesor Interno y revisor</label>
                                    <textarea class="form-control" id="comentario_carta_compromiso" name="comentario_carta_compromiso" rows="2"   required>{{ $documentos->comentario_carta_compromiso }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($documentos->id_estado_convenio == 1)
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        @if($documentos->convenio_empresa == 2)
                            <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                                <label>Convenio con la empresa (opcional): <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_convenio_empresa)}}" class="btn btn-success">Ver PDF</a> </label> </label>
                                <b>Autorizado</b>
                            </div>
                            <input type="hidden" name="convenio_empresa" id="convenio_empresa" value="{{$documentos->convenio_empresa}}" >

                        @else
                        <div class="col-md-7 col-md-offset-1">
                            <label>Convenio con la empresa (opcional): <a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos->pdf_convenio_empresa)}}" class="btn btn-success">Ver PDF</a> </label> </label>

                        </div>
                            <div class="col-md-3" style="text-align: left">

                                <select name="convenio_empresa" id="convenio_empresa" class="form-control" required>
                                    <option value=1 selected="selected">Rechazado</option>
                                    <option value="2">Autorizado</option>
                                </select>
                            </div>

                            <div class="row" id="comentario_convenio_empresa" style="">
                                <div class="col-md-10 col-md-offset-1 ">
                                    <div class="form-group">
                                        <label for="domicilio3">Comentario para la modificación del Convenio con la empresa (opcional)</label>
                                        <textarea class="form-control" id="comentario_convenio_empresa" name="comentario_convenio_empresa" rows="2"   required>{{ $documentos->comentario_convenio_empresa }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </div>

</form>
<script type="text/javascript">
    $(document).ready( function() {
        $("#solicitud_residencia").change(function (e) {
            var id_solicitud_residencia = e.target.value;
            $('#comentario_solicitud_residencia').empty();
            if (id_solicitud_residencia == 1) {

                $("#comentario_solicitud_residencia").css("display", "block");
                $('#comentario_solicitud_residencia').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación de la Solicitud de Residencia Profesional</label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_solicitud_residencia\" name=\"comentario_solicitud_residencia\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_solicitud_residencia == 2) {
                $("#comentario_solicitud_residencia").css("display", "none");

            }
        });

        $("#constancia_avance_academico").change(function (e) {
            var id_constancia_avance_academico = e.target.value;
            $('#comentario_constancia_avance_academico').empty();
            if (id_constancia_avance_academico == 1) {

                $("#comentario_constancia_avance_academico").css("display", "block");
                $('#comentario_constancia_avance_academico').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación de la Constancia de 80% de avance académico</label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_constancia_avance_academico\" name=\"comentario_constancia_avance_academico\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_solicitud_residencia == 2) {
                $("#comentario_constancia_avance_academico").css("display", "none");

            }
        });

        $("#comprobante_seguro").change(function (e) {
            var id_comprobante_seguro = e.target.value;
            $('#comentario_comprobante_seguro').empty();
            if (id_comprobante_seguro == 1) {

                $("#comentario_comprobante_seguro").css("display", "block");
                $('#comentario_comprobante_seguro').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación del Comprobante de seguro médico (IMSS, ISSSTE, ISSEMYM, etc.)</label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_comprobante_seguro\" name=\"comentario_comprobante_seguro\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_solicitud_residencia == 2) {
                $("#comentario_comprobante_seguro").css("display", "none");

            }
        });

        $("#oficio_asignacion_jefatura").change(function (e) {
            var id_oficio_asignacion_jefatura = e.target.value;
            $('#comentario_oficio_asignacion_jefatura').empty();
            if (id_oficio_asignacion_jefatura == 1) {

                $("#comentario_oficio_asignacion_jefatura").css("display", "block");
                $('#comentario_oficio_asignacion_jefatura').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación del Oficio de Asignación del Proyecto emitido por la Jefatura de División</label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_oficio_asignacion_jefatura\" name=\"comentario_oficio_asignacion_jefatura\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_oficio_asignacion_jefatura == 2) {
                $("#comentario_oficio_asignacion_jefatura").css("display", "none");

            }
        });
        $("#oficio_aceptacion_empresa").change(function (e) {
            var id_oficio_aceptacion_empresa = e.target.value;
            $('#comentario_oficio_aceptacion_empresa').empty();
            if (id_oficio_aceptacion_empresa == 1) {

                $("#comentario_oficio_aceptacion_empresa").css("display", "block");
                $('#comentario_oficio_aceptacion_empresa').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación del Oficio de Aceptación por parte de la empresa en hoja Membretada</label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_oficio_aceptacion_empresa\" name=\"comentario_oficio_aceptacion_empresa\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_oficio_aceptacion_empresa == 2) {
                $("#comentario_oficio_aceptacion_empresa").css("display", "none");

            }
        });

        $("#oficio_presentacion_tecnologico").change(function (e) {
            var id_oficio_presentacion_tecnologico = e.target.value;
            $('#comentario_oficio_presentacion_tecnologico').empty();
            if (id_oficio_presentacion_tecnologico == 1) {

                $("#comentario_oficio_presentacion_tecnologico").css("display", "block");
                $('#comentario_oficio_presentacion_tecnologico').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación del Oficio de Presentación por parte del TESVB</label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_oficio_presentacion_tecnologico\" name=\"comentario_oficio_presentacion_tecnologico\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_oficio_presentacion_tecnologico == 2) {
                $("#comentario_oficio_presentacion_tecnologico").css("display", "none");

            }
        });

        $("#anteproyecto").change(function (e) {
            var id_anteproyecto = e.target.value;
            $('#comentario_anteproyecto').empty();
            if (id_anteproyecto == 1) {

                $("#comentario_anteproyecto").css("display", "block");
                $('#comentario_anteproyecto').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación del Anteproyecto con el Visto Bueno de la Academia</label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_anteproyecto\" name=\"comentario_anteproyecto\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_anteproyecto == 2) {
                $("#comentario_anteproyecto").css("display", "none");

            }
        });

        $("#carta_compromiso").change(function (e) {
            var id_carta_compromiso = e.target.value;
            $('#comentario_carta_compromiso').empty();
            if (id_carta_compromiso == 1) {

                $("#comentario_carta_compromiso").css("display", "block");
                $('#comentario_carta_compromiso').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación de la Carta de compromiso firmada por el Asesor Interno y revisor</label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_carta_compromiso\" name=\"comentario_carta_compromiso\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_carta_compromiso == 2) {
                $("#comentario_carta_compromiso").css("display", "none");

            }
        });
        $("#convenio_empresa").change(function (e) {
            var id_convenio_empresa = e.target.value;
            $('#comentario_convenio_empresa').empty();
            if (id_convenio_empresa == 1) {

                $("#comentario_convenio_empresa").css("display", "block");
                $('#comentario_convenio_empresa').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación de la Carta de compromiso firmada por el Asesor Interno y revisor</label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_convenio_empresa\" name=\"comentario_convenio_empresa\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_convenio_empresa == 2) {
                $("#comentario_convenio_empresa").css("display", "none");

            }
        });
    });
</script>
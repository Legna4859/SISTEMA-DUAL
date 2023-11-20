
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
    <form class="form" action="{{url("/servicio_social/enviar_primeraetapa/".$registro_tipo_empresa[0]->id_datos_alumnos)}}"  id="formulario_empresa_privada" role="form" method="POST" >
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        @if($documentacion[0]->est_carta_aceptacion == 2)
                            <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                                <label>Carta de aceptación (solo empresa privada): Autorizado </label>
                                 <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_carta_aceptacion)}}" class="btn btn-success">Ver PDF</a>

                            </div>
                            <input type="hidden" name="carta_aceptacion" id="carta_aceptacion" value="{{$documentacion[0]->est_carta_aceptacion}}" >
                    </div>
                            @else
                               <div class="col-md-7 col-md-offset-1">
                                 <label>Carta de aceptación (solo empresa privada):  <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_carta_aceptacion)}}" class="btn btn-success">Ver PDF</a> </label>

                              </div>
                        <div class="col-md-3" style="text-align: left">

                            <select name="carta_aceptacion" id="carta_aceptacion" class="form-control" required>
                                @if($documentacion[0]->est_carta_aceptacion  == 1)
                                    <option value=1 selected="selected">Rechazado</option>
                                    <option value="2">Autorizado</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row" id="comentario_carta" style="">
                        <div class="col-md-10 col-md-offset-1 ">
                            <div class="form-group">
                             <label for="domicilio3">Comentario para la modificación de la Carta de aceptacion</label>
                            <textarea class="form-control" id="comentario_carta" name="comentario_carta" rows="2"   required>{{ $documentacion[0]->coment_carta_aceptacion }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        @if($documentacion[0]->est_anexo_tecnico == 2)
                            <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                                <label>Anexo Tecnico (solo empresa privada): Autorizado <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_anexo_tecnico)}}" class="btn btn-success">Ver PDF</a></label>
                                <input type="hidden" name="anexo_tecnico" id="anexo_tecnico" value="{{$documentacion[0]->est_anexo_tecnico}}" >

                            </div>
                    </div>
                        @else
                        <div class="col-md-7 col-md-offset-1">
                            <label>Anexo Tecnico (solo empresa privada): <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_anexo_tecnico)}}" class="btn btn-success">Ver PDF</a></label>
                        </div>
                        <div class="col-md-3" style="text-align: left">
                            <select name="anexo_tecnico" id="anexo_tecnico" class="form-control" required>
                                @if($documentacion[0]->est_anexo_tecnico  == 1)

                                    <option value=1 selected="selected">Rechazado</option>
                                    <option value="2">Autorizado</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row" id="comentario_anexo" >
                        <div class="col-md-10 col-md-offset-1 ">
                            <div class="form-group">
                                <label for="domicilio3">Comentario para la modificación del Anexo Tecnico</label>
                                <textarea class="form-control" id="comentario_anexo" name="comentario_anexo" rows="2"   required>{{ $documentacion[0]->coment_anexo_tecnico }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        @if($documentacion[0]->est_curp  == 2)
                            <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                                <label>Copia de tu CURP: Autorizado <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_curp)}}" class="btn btn-success">Ver PDF</a></label>
                                <input type="hidden" name="curp" id="curp"  value="{{$documentacion[0]->est_curp }}" >


                            </div>
                    </div>
                        @else
                        <div class="col-md-7 col-md-offset-1">
                            <label>Copia de tu CURP: <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_curp)}}" class="btn btn-success">Ver PDF</a></label>

                        </div>
                        <div class="col-md-3" style="text-align: left">
                            <select name="curp" id="curp" class="form-control" required>
                                @if($documentacion[0]->est_curp   == 1)

                                    <option value=1 selected="selected">Rechazado</option>
                                    <option value="2">Autorizado</option>

                                @else
                                    <option value="1">Rechazado</option>
                                    <option  value=2 selected="selected">Autorizado</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row" id="comentario_curp" style="">
                        <div class="col-md-10 col-md-offset-1 ">
                            <div class="form-group">
                                <label for="domicilio3">Comentario para la modificación de la Copia de tu CURP:</label>
                                <textarea class="form-control" id="comentario_curp" name="comentario_curp" rows="2"   required>{{ $documentacion[0]->coment_curp }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        @if($documentacion[0]->est_carnet == 2)
                            <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                                <label>Copia de tu Carnet: Autorizado <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_carnet)}}" class="btn btn-success">Ver PDF</a></label>
                                <input type="hidden" name="carnet" id="carnet"  value="{{$documentacion[0]->est_carnet }}" >


                            </div>
                    </div>
                        @else
                        <div class="col-md-7 col-md-offset-1">
                            <label>Copia de tu Carnet: <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_carnet)}}" class="btn btn-success">Ver PDF</a> </label>

                        </div>
                        <div class="col-md-3" style="text-align: left">
                            <select name="carnet" id="carnet" class="form-control" required>
                                @if($documentacion[0]->est_carnet == 1)
                                    <option value=1 selected="selected">Rechazado</option>
                                    <option value="2">Autorizado</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row" id="comentario_carnet" style="">
                        <div class="col-md-10 col-md-offset-1 ">
                            <div class="form-group">
                                <label for="domicilio3">Comentario para la modificación de la Copia de tu Carnet:</label>
                                <textarea class="form-control" id="comentario_carnet" name="comentario_carnet" rows="2"   required>{{ $documentacion[0]->coment_carnet }}</textarea>
                            </div>
                        </div>

                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        @if($documentacion[0]->est_constancia_creditos == 2)
                            <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                                <label>Constancia original del 50% de creditos: Autorizado <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_constancia_creditos)}}" class="btn btn-success">Ver PDF</a></label>
                                <input type="hidden" name="constancia_creditos" id="constancia_creditos"  value="{{$documentacion[0]->est_constancia_creditos }}" >

                            </div>
                    </div>
                        @else
                        <div class="col-md-7 col-md-offset-1">
                            <label>Constancia original del 50% de creditos: <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_constancia_creditos)}}" class="btn btn-success">Ver PDF</a></label>

                        </div>
                        <div class="col-md-3" style="text-align: left">
                            <select name="constancia_creditos" id="constancia_creditos" class="form-control" required>
                                @if($documentacion[0]->est_constancia_creditos == 1)
                                    <option value=1 selected="selected">Rechazado</option>
                                    <option value="2">Autorizado</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row" id="comentario_constancia_creditos" style="">
                        <div class="col-md-10 col-md-offset-1 ">
                            <div class="form-group">
                                <label for="domicilio3">Comentario para la modificación de la Constancia original del 50% de creditos :</label>
                                <textarea class="form-control" id="comentario_constancia_creditos" name="comentario_constancia_creditos" rows="2"   required>{{ $documentacion[0]->coment_costancia_creditos }}</textarea>
                            </div>
                        </div>

                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        @if($documentacion[0]->est_solicitud_reg_autori == 2)
                            <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                                <label>Solicitud de registro de autorización: Autorizado <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_solicitud_reg_autori)}}" class="btn btn-success">Ver PDF</a></label>
                                <input type="hidden" name="solicitud_registro" id="solicitud_registro"  value="{{$documentacion[0]->est_solicitud_reg_autori }}" >


                            </div>
                    </div>
                        @else
                        <div class="col-md-7 col-md-offset-1">
                            <label>Solicitud de registro de autorización: <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_solicitud_reg_autori)}}" class="btn btn-success">Ver PDF</a></label>

                        </div>
                        <div class="col-md-3" style="text-align: left">
                            <select name="solicitud_registro" id="solicitud_registro" class="form-control" required>
                                @if($documentacion[0]->est_solicitud_reg_autori == 1)
                                    <option value=1 selected="selected">Rechazado</option>
                                    <option value="2">Autorizado</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row" id="comentario_solicitud_registro" style="">
                        <div class="col-md-10 col-md-offset-1 ">
                            <div class="form-group">
                                <label for="domicilio3">Comentario para la modificación de la solicitud de Registro :</label>
                                <textarea class="form-control" id="comentario_solicitud_registro" name="comentario_solicitud_registro" rows="2"   required>{{ $documentacion[0]->coment_solicitud_reg_autori }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>



        <div class="row" >
            <div class="col-md-2 col-md-offset-5">
                <button  id="aceptar_empresa_privada"  class="btn btn-primary" >Enviar</button>
            </div>
            <br>
            <br><p></p>
        </div>
    </form>

@elseif($tipo_empresa == 2)
    <form class="form" action="{{url("/servicio_social/enviar_primeraetapa/".$registro_tipo_empresa[0]->id_datos_alumnos)}}"  id="formulario_empresa_publica" role="form" method="POST" >
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        @if($documentacion[0]->est_curp  == 2)
                            <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                                <label>Copia de tu CURP: Autorizado <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_curp)}}" class="btn btn-success">Ver PDF</a></label>
                                <input type="hidden" name="curp" id="curp"  value="{{$documentacion[0]->est_curp }}" >


                            </div>
                    </div>
                    @else
                        <div class="col-md-7 col-md-offset-1">
                            <label>Copia de tu CURP: <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_curp)}}" class="btn btn-success">Ver PDF</a></label>

                        </div>
                        <div class="col-md-3" style="text-align: left">
                            <select name="curp" id="curp" class="form-control" required>
                                @if($documentacion[0]->est_curp   == 1)

                                    <option value=1 selected="selected">Rechazado</option>
                                    <option value="2">Autorizado</option>

                                @else
                                    <option value="1">Rechazado</option>
                                    <option  value=2 selected="selected">Autorizado</option>
                                @endif
                            </select>
                        </div>
                </div>
                <div class="row" id="comentario_curp" style="">
                    <div class="col-md-10 col-md-offset-1 ">
                        <div class="form-group">
                            <label for="domicilio3">Comentario para la modificación de la Copia de tu CURP:</label>
                            <textarea class="form-control" id="comentario_curp" name="comentario_curp" rows="2"   required>{{ $documentacion[0]->coment_curp }}</textarea>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        @if($documentacion[0]->est_carnet == 2)
                            <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                                <label>Copia de tu Carnet: Autorizado <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_carnet)}}" class="btn btn-success">Ver PDF</a></label>
                                <input type="hidden" name="carnet" id="carnet"  value="{{$documentacion[0]->est_carnet }}" >


                            </div>
                    </div>
                    @else
                        <div class="col-md-7 col-md-offset-1">
                            <label>Copia de tu Carnet: <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_carnet)}}" class="btn btn-success">Ver PDF</a></label>

                        </div>
                        <div class="col-md-3" style="text-align: left">
                            <select name="carnet" id="carnet" class="form-control" required>
                                @if($documentacion[0]->est_carnet == 1)
                                    <option value=1 selected="selected">Rechazado</option>
                                    <option value="2">Autorizado</option>
                                @endif
                            </select>
                        </div>
                </div>
                <div class="row" id="comentario_carnet" style="">
                    <div class="col-md-10 col-md-offset-1 ">
                        <div class="form-group">
                            <label for="domicilio3">Comentario para la modificación de la Copia de tu Carnet:</label>
                            <textarea class="form-control" id="comentario_carnet" name="comentario_carnet" rows="2"   required>{{ $documentacion[0]->coment_carnet }}</textarea>
                        </div>
                    </div>

                </div>
                @endif
            </div>
        </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        @if($documentacion[0]->est_constancia_creditos == 2)
                            <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                                <label>Constancia original del 50% de creditos: Autorizado <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_carnet)}}" class="btn btn-success">Ver PDF</a> </label>
                                <input type="hidden" name="constancia_creditos" id="constancia_creditos"  value="{{$documentacion[0]->est_constancia_creditos }}" >

                            </div>
                          </div>
                    @else
                        <div class="col-md-7 col-md-offset-1">
                            <label>Constancia original del 50% de creditos: <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_carnet)}}" class="btn btn-success">Ver PDF</a></label>

                        </div>
                        <div class="col-md-3" style="text-align: left">
                            <select name="constancia_creditos" id="constancia_creditos" class="form-control" required>
                                @if($documentacion[0]->est_constancia_creditos == 1)
                                    <option value=1 selected="selected">Rechazado</option>
                                    <option value="2">Autorizado</option>
                                @endif
                            </select>
                        </div>
                </div>
                <div class="row" id="comentario_constancia_creditos" style="">
                    <div class="col-md-10 col-md-offset-1 ">
                        <div class="form-group">
                            <label for="domicilio3">Comentario para la modificación de la Constancia original del 50% de creditos :</label>
                            <textarea class="form-control" id="comentario_constancia_creditos" name="comentario_constancia_creditos" rows="2"   required>{{ $documentacion[0]->coment_constancia_creditos }}</textarea>
                        </div>
                    </div>

                </div>
                @endif
            </div>
        </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        @if($documentacion[0]->est_solicitud_reg_autori  == 2)
                            <div class="col-md-10 col-md-offset-1" style="color: #FF0000">
                                <label>Solicitud de registro de autorización: Autorizado <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_solicitud_reg_autori)}}" class="btn btn-success">Ver PDF</a></label>
                                <input type="hidden" name="solicitud_registro" id="solicitud_registro"  value="{{$documentacion[0]->est_solicitud_reg_autori   }}" >


                            </div>
                    </div>
                    @else
                        <div class="col-md-7 col-md-offset-1">
                            <label>Solicitud de registro de autorización: <a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$documentacion[0]->pdf_solicitud_reg_autori)}}" class="btn btn-success">Ver PDF</a></label>

                        </div>
                        <div class="col-md-3" style="text-align: left">
                            <select name="solicitud_registro" id="solicitud_registro" class="form-control" required>
                                @if($documentacion[0]->est_solicitud_reg_autori  == 1)
                                    <option value=1 selected="selected">Rechazado</option>
                                    <option value="2">Autorizado</option>
                                @endif
                            </select>
                        </div>
                </div>
                <div class="row" id="comentario_solicitud_registro" style="">
                    <div class="col-md-10 col-md-offset-1 ">
                        <div class="form-group">
                            <label for="domicilio3">Comentario para la modificación de la solicitud de Registro :</label>
                            <textarea class="form-control" id="comentario_solicitud_registro" name="comentario_solicitud_registro" rows="2"   required>{{ $documentacion[0]->coment_solicitud_reg_autori }}</textarea>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        </div>




        <div class="row" >
            <div class="col-md-2 col-md-offset-5">
                <button  id="aceptar_empresa_publica"  class="btn btn-primary" >Enviar</button>
            </div>
            <br>
            <br><p></p>
        </div>
    </form>

@endif
<script type="text/javascript">
    $(document).ready( function() {
        $("#carta_aceptacion").change(function (e) {
            var id_carta_aceptacion = e.target.value;
            if (id_carta_aceptacion == 1) {
                $('#comentario_carta').empty();
                $("#comentario_carta").css("display", "block");
                $('#comentario_carta').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                <div class=\"form-group\">\n" +
                    "                    <label for=\"domicilio3\">Comentario para la modificación de la Carta de aceptacion</label>\n" +
                    "                    <textarea class=\"form-control\" id=\"comentario_carta\" name=\"comentario_carta\" rows=\"2\"  style=\"\" required></textarea>\n" +
                    "                </div>\n" +
                    "            </div>");

            }
            if (id_carta_aceptacion == 2) {
                $("#comentario_carta").css("display", "none");

            }
        });
        $("#anexo_tecnico").change(function (e) {

            var id_anexo_tecnico = e.target.value;
            if (id_anexo_tecnico == 1) {
                $('#comentario_anexo').empty();
                $("#comentario_anexo").css({ "display": "block"});
                $('#comentario_anexo').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                        <div class=\"form-group\">\n" +
                    "                            <label for=\"domicilio3\">Comentario para la modificación del Anexo Tecnico</label>\n" +
                    "                            <textarea class=\"form-control\" id=\"comentario_anexo\" name=\"comentario_anexo\" rows=\"2\"  style=\"\" required></textarea>\n" +
                    "                        </div>\n" +
                    "                    </div>");

            }
            if (id_anexo_tecnico == 2) {
                $("#comentario_anexo").css("display", "none");

            }
        });
        $("#curp").change(function (e) {
            var id_curp = e.target.value;
            if (id_curp == 1) {
                $('#comentario_curp').empty();
                $("#comentario_curp").css({ "display": "block"});
                $('#comentario_curp').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                        <div class=\"form-group\">\n" +
                    "                            <label for=\"domicilio3\">Comentario para la modificación de la Copia de tu CURP:</label>\n" +
                    "                            <textarea class=\"form-control\" id=\"comentario_curp\" name=\"comentario_curp\" rows=\"2\"  style=\"\" required></textarea>\n" +
                    "                        </div>\n" +
                    "                    </div>");

            }
            if (id_curp == 2) {
                $("#comentario_curp").css("display", "none");

            }
        });
        $("#carnet").change(function (e) {
            var id_carnet = e.target.value;
            if (id_carnet == 1) {
                $('#comentario_carnet').empty();
                $("#comentario_carnet").css({ "display": "block"});
                $('#comentario_carnet').append(" <div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                        <div class=\"form-group\">\n" +
                    "                            <label for=\"domicilio3\">Comentario para la modificación de la Copia de tu Carnet:</label>\n" +
                    "                            <textarea class=\"form-control\" id=\"comentario_carnet\" name=\"comentario_carnet\" rows=\"2\"  style=\"\" required></textarea>\n" +
                    "                        </div>\n" +
                    "                    </div>");

            }
            if (id_carnet == 2) {
                $("#comentario_carnet").css("display", "none");

            }
        });
        $("#constancia_creditos").change(function (e) {
            var id_constancia_creditos = e.target.value;
            if (id_constancia_creditos == 1) {
                $('#comentario_constancia_creditos').empty();
                $("#comentario_constancia_creditos").css({ "display": "block"});
                $('#comentario_constancia_creditos').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                        <div class=\"form-group\">\n" +
                    "                            <label for=\"domicilio3\">Comentario para la modificación de la Constancia original del 50% de creditos :</label>\n" +
                    "                            <textarea class=\"form-control\" id=\"comentario_constancia_creditos\" name=\"comentario_constancia_creditos\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                        </div>\n" +
                    "                    </div>");

            }
            if (id_constancia_creditos == 2) {
                $("#comentario_constancia_creditos").css("display", "none");

            }
        });
        $("#solicitud_registro").change(function (e) {
            var id_solicitud_registro = e.target.value;
            if (id_solicitud_registro == 1) {
                $('#comentario_solicitud_registro').empty();
                $("#comentario_solicitud_registro").css({ "display": "block"});

                $('#comentario_solicitud_registro').append("<div class=\"col-md-10 col-md-offset-1 \">\n" +
                    "                        <div class=\"form-group\">\n" +
                    "                            <label for=\"domicilio3\">Comentario para la modificación de la solicitud de Registro :</label>\n" +
                    "                            <textarea class=\"form-control\" id=\"comentario_solicitud_registro\" name=\"comentario_solicitud_registro\" rows=\"1\"  style=\"\" required></textarea>\n" +
                    "                        </div>\n" +
                    "                    </div>");

            }
            if (id_solicitud_registro == 2) {
                $("#comentario_solicitud_registro").css("display", "none");

            }
        });
        $("#aceptar_empresa_privada").click(function(event){
            var carta_aceptacion = $('#carta_aceptacion').val();
            var anexo_tecnico = $('#anexo_tecnico').val();
            var curp = $('#curp').val();
            var carnet = $('#carnet').val();
            var curp = $('#curp').val();
            var constancia_creditos = $('#constancia_creditos').val();
            var solicitud_registro = $('#solicitud_registro').val();

            if(carta_aceptacion != null && anexo_tecnico != null && curp != null && carnet != null && constancia_creditos != null && solicitud_registro !=null ){
                if(carta_aceptacion ==2  && anexo_tecnico == 2 && curp == 2 && carnet == 2 && constancia_creditos == 2 && solicitud_registro ==2 ){

                    swal({
                        position: "top",
                        type: "acept",
                        title: "La documentacion del alumno fue aceptada",
                        showConfirmButton: false,
                        timer: 3500
                    });
                    $("#formulario_empresa_privada").submit();

                }
                else{

                    $("#formulario_empresa_privada").submit();

                }
                $("#aceptar_empresa_privada").attr("disabled", true);
            }
            else{


                swal({
                    position: "top",
                    type: "error",
                    title: "Hay un campo no seleccionado en el formulario",
                    showConfirmButton: false,
                    timer: 3500
                });

            }
        });
        $("#aceptar_empresa_publica").click(function(event){
            var curp = $('#curp').val();
            var carnet = $('#carnet').val();
            var curp = $('#curp').val();
            var constancia_creditos = $('#constancia_creditos').val();
            var solicitud_registro = $('#solicitud_registro').val();

            if( curp != null && carnet != null && constancia_creditos != null && solicitud_registro !=null ){
                if( curp == 2 && carnet == 2 && constancia_creditos == 2 && solicitud_registro ==2 ){

                    swal({
                        position: "top",
                        type: "acept",
                        title: "La documentacion del alumno fue aceptada",
                        showConfirmButton: false,
                        timer: 3500
                    });
                    $("#formulario_empresa_publica").submit();

                }
                else{

                    $("#formulario_empresa_publica").submit();

                }


            }
            else{


                swal({
                    position: "top",
                    type: "error",
                    title: "Hay un campo no seleccionado en el formulario",
                    showConfirmButton: false,
                    timer: 3500
                });

            }
        });

    });
</script>
@extends('layouts.app')
@section('title', 'Documentación de alta de residenciaa')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Enviar Documentación de Alta de Residencia</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <form class="form" id="formulario_modificar_correo" action="{{url("/residencia/modificar_correo_documentacion")}}" role="form" method="POST" >
                            {{ csrf_field() }}
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <label for="nombre_proyecto">Nombre del alumno:</label>
                                            <p>{{$datosalumno->nombre}} {{$datosalumno->apaterno}} {{$datosalumno->amaterno}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <label for="nombre_proyecto">Modificar tu correo electronico.</label>
                                            <input class="form-control"  id="id_alta_residencia" name="id_alta_residencia" type="hidden"   value="{{$documentos_alta->id_alta_residencia}}" required/>
                                            <input class="form-control"  id="correo_electronico_doc" name="correo_electronico_doc" type="email"  placeholder="Ingresa tu correo electronico" value="{{$documentos_alta->correo}}" required/>
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-1 col-md-offset-5 ">
                                        <button id="modificar_correo_alta" class="btn btn-primary">Modificar correo</button>
                                    </div>
                                </div>

                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-success">
                    <div class="panel-body" style="text-align: justify">
                        <p style="color: #FF0000"><b>Nota: El documento se deben escanear y guardar en un pdf legible</b></p>

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Nombre del documento</th>
                                <th> Agregar o ver PDF</th>
                                <th>Guardar o modificar PDF</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Solicitud de Residencia Profesional</td>
                                @if($documentos_alta->pdf_solicitud_residencia  == "" )
                                    <td>
                                        <form class="form" id="form_solicitud_residencia" action="{{url("/residencia/registrar_solicitud_residencia/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                                            {{ csrf_field() }}
                                            <input class="form-control"  id="solicitud_residencia" name="solicitud_residencia" type="file"   accept="application/pdf" required/>
                                        </form>
                                    </td>
                                    <td>
                                        <button  id="guardar_solicitud_residencia" class="btn btn-primary" >Guardar</button>
                                    </td>
                                @else

                                    <td><a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos_alta->pdf_solicitud_residencia)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                    <td>
                                        <button   id="id_solicitud_residencia"  class="btn btn-primary" >Modificar</button>

                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td>Constancia de 80% de avance académico, no adeudo de asignatura en curso especial,
                                haber acreditado  el servicio social y haber acrdeitado los 5 creditos  de actividades complementarias
                                emitido por la Subdirección de Servicios Escolares del TESVB.</td>
                                @if($documentos_alta->pdf_constancia_avance_academico   == "" )
                                    <td>
                                        <form class="form" id="form_constancia_avance_academico" action="{{url("/residencia/registrar_constancia_avance_academico/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                                            {{ csrf_field() }}
                                            <input class="form-control"  id="constancia_avance_academico" name="constancia_avance_academico" type="file"   accept="application/pdf" required/>
                                        </form>
                                    </td>
                                    <td>
                                        <button  id="guardar_constancia_avance_academico" class="btn btn-primary" >Guardar</button>
                                    </td>
                                @else

                                    <td><a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos_alta->pdf_constancia_avance_academico)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                    <td>
                                        <button   id="id_constancia_avance_academico"  class="btn btn-primary" >Modificar</button>

                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td>Comprobante de seguro médico (IMSS, ISSSTE, ISSEMYM, etc.)</td>
                                @if($documentos_alta->pdf_comprobante_seguro == "" )
                                    <td>
                                        <form class="form" id="form_comprobante_seguro" action="{{url("/residencia/registrar_comprobante_seguro/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                                            {{ csrf_field() }}
                                            <input class="form-control"  id="comprobante_seguro" name="comprobante_seguro" type="file"   accept="application/pdf" required/>
                                        </form>
                                    </td>
                                    <td>
                                        <button  id="guardar_comprobante_seguro" class="btn btn-primary" >Guardar</button>
                                    </td>
                                @else

                                    <td><a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos_alta->pdf_comprobante_seguro)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                    <td>
                                        <button   id="id_comprobante_seguro"  class="btn btn-primary" >Modificar</button>

                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td>Oficio de Asignación del Proyecto emitido por la Jefatura de División</td>
                                @if($documentos_alta->pdf_oficio_asignacion_jefatura  == "" )
                                    <td>
                                        <form class="form" id="form_oficio_asignacion_jefatura" action="{{url("/residencia/registrar_oficio_asignacion_jefatura/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                                            {{ csrf_field() }}
                                            <input class="form-control"  id="oficio_asignacion_jefatura" name="oficio_asignacion_jefatura" type="file"   accept="application/pdf" required/>
                                        </form>
                                    </td>
                                    <td>
                                        <button  id="guardar_oficio_asignacion_jefatura" class="btn btn-primary" >Guardar</button>
                                    </td>
                                @else

                                    <td><a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos_alta->pdf_oficio_asignacion_jefatura)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                    <td>
                                        <button   id="id_oficio_asignacion_jefatura"  class="btn btn-primary" >Modificar</button>

                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td>Oficio de Aceptación por parte de la empresa en hoja Membretada</td>
                                @if($documentos_alta->pdf_oficio_aceptacion_empresa   == "" )
                                    <td>
                                        <form class="form" id="form_oficio_aceptacion_empresa" action="{{url("/residencia/registrar_oficio_aceptacion_empresa/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                                            {{ csrf_field() }}
                                            <input class="form-control"  id="oficio_aceptacion_empresa" name="oficio_aceptacion_empresa" type="file"   accept="application/pdf" required/>
                                        </form>
                                    </td>
                                    <td>
                                        <button  id="guardar_oficio_aceptacion_empresa" class="btn btn-primary" >Guardar</button>
                                    </td>
                                @else

                                    <td><a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos_alta->pdf_oficio_aceptacion_empresa)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                    <td>
                                        <button   id="id_oficio_aceptacion_empresa"  class="btn btn-primary" >Modificar</button>

                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td>Oficio de Presentación por parte del TESVB</td>
                                @if($documentos_alta->pdf_oficio_presentacion_tecnologico == "" )
                                    <td>
                                        <form class="form" id="form_oficio_presentacion_tecnologico" action="{{url("/residencia/registrar_oficio_presentacion_tecnologico/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                                            {{ csrf_field() }}
                                            <input class="form-control"  id="oficio_presentacion_tecnologico" name="oficio_presentacion_tecnologico" type="file"   accept="application/pdf" required/>
                                        </form>
                                    </td>
                                    <td>
                                        <button  id="guardar_oficio_presentacion_tecnologico" class="btn btn-primary" >Guardar</button>
                                    </td>
                                @else

                                    <td><a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos_alta->pdf_oficio_presentacion_tecnologico)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                    <td>
                                        <button   id="id_oficio_presentacion_tecnologico"  class="btn btn-primary" >Modificar</button>

                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td>Anteproyecto con el Visto Bueno de la Academia</td>
                                @if($documentos_alta->pdf_anteproyecto  == "" )
                                    <td>
                                        <form class="form" id="form_anteproyecto" action="{{url("/residencia/registrar_anteproyectos/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                                            {{ csrf_field() }}
                                            <input class="form-control"  id="anteproyecto" name="anteproyecto" type="file"   accept="application/pdf" required/>
                                        </form>
                                    </td>
                                    <td>
                                        <button  id="guardar_anteproyecto" class="btn btn-primary" >Guardar</button>
                                    </td>
                                @else

                                    <td><a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos_alta->pdf_anteproyecto)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                    <td>
                                        <button   id="id_anteproyecto"  class="btn btn-primary" >Modificar</button>

                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td>Carta de compromiso firmada por el Asesor Interno y revisor</td>
                                @if($documentos_alta->pdf_carta_compromiso  == "" )
                                    <td>
                                        <form class="form" id="form_carta_compromiso" action="{{url("/residencia/registrar_carta_compromiso/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                                            {{ csrf_field() }}
                                            <input class="form-control"  id="carta_compromiso" name="carta_compromiso" type="file"   accept="application/pdf" required/>
                                        </form>
                                    </td>
                                    <td>
                                        <button  id="guardar_carta_compromiso" class="btn btn-primary" >Guardar</button>
                                    </td>
                                @else

                                    <td><a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos_alta->pdf_carta_compromiso)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                    <td>
                                        <button   id="id_carta_compromiso"  class="btn btn-primary" >Modificar</button>

                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td style="color: red">Convenio con la empresa (opcional)</td>
                                @if($documentos_alta->pdf_convenio_empresa   == "" )
                                    <td>
                                        <form class="form" id="form_convenio_empresa" action="{{url("/residencia/registrar_convenio_empresa/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                                            {{ csrf_field() }}
                                            <input class="form-control"  id="convenio_empresa" name="convenio_empresa" type="file"   accept="application/pdf" required/>
                                        </form>
                                    </td>
                                    <td>
                                        <button  id="guardar_convenio_empresa" class="btn btn-primary" >Guardar</button>
                                    </td>
                                @else

                                    <td><a  target="_blank" href="{{asset('/residencia_pdf/'.$documentos_alta->pdf_convenio_empresa)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                    <td>
                                        <button   id="id_convenio_empresa"  class="btn btn-primary" >Modificar</button>

                                    </td>
                                @endif
                            </tr>
                            </tbody>
                        </table>
                        <div class="row">

                                @if($documentos_alta->pdf_solicitud_residencia  != "" && $documentos_alta->pdf_constancia_avance_academico  != "" && $documentos_alta->pdf_comprobante_seguro  != "" && $documentos_alta->pdf_oficio_asignacion_jefatura  != "" && $documentos_alta->pdf_oficio_aceptacion_empresa  != "" && $documentos_alta->pdf_oficio_presentacion_tecnologico  != "" && $documentos_alta->pdf_anteproyecto  != "" && $documentos_alta->pdf_carta_compromiso   != "")
                                    <div class="col-md-2 col-md-offset-5">
                                        <button   class="btn btn-success  " title="Enviar documentacion" data-toggle="modal" data-target="#enviar_documentacion_residencia">Enviar documentación</button>

                                    </div>
                                @endif

                        </div>



                    </div>
                </div>

            </div>
        </div>


    </main>
    {{--modificar solicitud de residencia --}}
    <div class="modal fade" id="modal_modificar_solicitud_residencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar Solicitud de Residencia Profesional</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="nombre_proyecto">Ingresar nuevo PDF con la Solicitud de Residencia Profesional.<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_solicitud_residencia" action="{{url("/residencia/registrar_solicitud_residencia/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="solicitud_residencia" name="solicitud_residencia" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_solicitud_residencia" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar solicitud de residencia--}}

    {{--modificar constancia_avance_academico --}}
    <div class="modal fade" id="modal_modificar_constancia_avance_academico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar Constancia de 80% de avance académico</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="nombre_proyecto">Ingresar nuevo PDF con la Constancia de 80% de avance académico.<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_constancia_avance_academico" action="{{url("/residencia/registrar_constancia_avance_academico/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="constancia_avance_academico" name="constancia_avance_academico" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_constancia_avance_academico" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar constancia_avance_academico--}}
    {{--modificar comprobante_seguro --}}
    <div class="modal fade" id="modal_modificar_comprobante_seguro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar el Comprobante de seguro médico (IMSS, ISSSTE, ISSEMYM, etc.)</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="nombre_proyecto">Ingresar nuevo PDF con el Comprobante de seguro médico (IMSS, ISSSTE, ISSEMYM, etc.)<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_comprobante_seguro" action="{{url("/residencia/registrar_comprobante_seguro/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="comprobante_seguro" name="comprobante_seguro" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_comprobante_seguro" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar comprobante_seguro--}}
    {{--modificar oficio_asignacion_jefatura --}}
    <div class="modal fade" id="modal_modificar_oficio_asignacion_jefatura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar el Oficio de Asignación del Proyecto emitido por la Jefatura de División</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="nombre_proyecto">Ingresar nuevo PDF con Oficio de Asignación del Proyecto emitido por la Jefatura de División<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_oficio_asignacion_jefatura" action="{{url("/residencia/registrar_oficio_asignacion_jefatura/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="oficio_asignacion_jefatura" name="oficio_asignacion_jefatura" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_oficio_asignacion_jefatura" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar oficio_asignacion_jefatura--}}
    {{--modificar oficio_aceptacion_empresa --}}
    <div class="modal fade" id="modal_modificar_oficio_aceptacion_empresa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar el Oficio de Aceptación por parte de la empresa en hoja Membretada</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="nombre_proyecto">Ingresar nuevo PDF con el Oficio de Aceptación por parte de la empresa en hoja Membretada<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_oficio_aceptacion_empresa" action="{{url("/residencia/registrar_oficio_aceptacion_empresa/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="oficio_aceptacion_empresa" name="oficio_aceptacion_empresa" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_oficio_aceptacion_empresa" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar oficio_aceptacion_empresa--}}
    {{--modificar oficio_presentacion_tecnologico --}}
    <div class="modal fade" id="modal_modificar_oficio_presentacion_tecnologico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar el Oficio de Presentación por parte del TESVB</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="nombre_proyecto">Ingresar nuevo PDF con el Oficio de Presentación por parte del TESVB<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_oficio_presentacion_tecnologico" action="{{url("/residencia/registrar_oficio_presentacion_tecnologico/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="oficio_presentacion_tecnologico" name="oficio_presentacion_tecnologico" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_oficio_presentacion_tecnologico" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar oficio_presentacion_tecnologico--}}
    {{--modificar anteproyecto --}}
    <div class="modal fade" id="modal_modificar_anteproyecto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar el Anteproyecto con el Visto Bueno de la Academia</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="nombre_proyecto">Ingresar nuevo PDF con el Anteproyecto con el Visto Bueno de la Academia<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_anteproyecto" action="{{url("/residencia/registrar_anteproyectos/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="anteproyecto" name="anteproyecto" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_anteproyecto" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar anteproyecto--}}
    {{--modificar carta_compromiso --}}
    <div class="modal fade" id="modal_modificar_carta_compromiso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar la Carta de compromiso firmada por el Asesor Interno y revisor</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="nombre_proyecto">Ingresar nuevo PDF con la Carta de compromiso firmada por el Asesor Interno y revisor<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_carta_compromiso" action="{{url("/residencia/registrar_carta_compromiso/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="carta_compromiso" name="carta_compromiso" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_carta_compromiso" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar carta_compromiso--}}
    {{--modificar carta_compromiso --}}
    <div class="modal fade" id="modal_modificar_convenio_empresa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar el Convenio con la empresa (opcional)</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="nombre_proyecto">Ingresar nuevo PDF con el Convenio con la empresa (opcional)<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_convenio_empresa" action="{{url("/residencia/registrar_convenio_empresa/".$documentos_alta->id_alta_residencia)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="convenio_empresa" name="convenio_empresa" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_convenio_empresa" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar carta_compromiso--}}

    <div class="modal fade" id="enviar_documentacion_residencia" role="dialog">

        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="POST" id="enviar_doc" action="{{url("/residencia/envio_documento_residencia/".$documentos_alta->id_alta_residencia)}}">
                    @csrf
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Enviar documentos</h4>
                    </div>
                    <div class="modal-body">
                        <p>¿Seguro que quieres, enviar tus documentos al Departamento de Servicio Social y Residencia Profesional para su revisión?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  type="submit" class="btn btn-primary" >Aceptar</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
    <script type="text/javascript">
        $(document).ready( function() {

            $("#modificar_correo_alta").click(function (event) {
                var correo_electronico_doc = $("#correo_electronico_doc").val();
                if(correo_electronico_doc != ""){
                    $("#formulario_modificar_correo").submit();
                    $("#modificar_correo_alta").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Ingresa tu correo electronico.",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            });
            $("#guardar_solicitud_residencia").click(function (event) {
                var solicitud_residencia = $("#solicitud_residencia").val();
                if(solicitud_residencia != ""){
                    $("#form_solicitud_residencia").submit();
                    $("#guardar_solicitud_residencia").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Solicitud de Residencia Profesional",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_constancia_avance_academico").click(function (event) {
                var constancia_avance_academico = $("#constancia_avance_academico").val();
                if(constancia_avance_academico != ""){
                    $("#form_constancia_avance_academico").submit();
                    $("#guardar_constancia_avance_academico").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Constancia de 80% de avance académico, no adeudo de asignatura en curso especial,\n" +
                            "                                haber acreditado  el servicio social y haber acrdeitado los 5 creditos  de actividades complementarias\n" +
                            "                                emitido por la Subdirección de Servicios Escolares del TESVB.",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_comprobante_seguro").click(function (event) {
                var comprobante_seguro = $("#comprobante_seguro").val();
                if(comprobante_seguro != ""){
                    $("#form_comprobante_seguro").submit();
                    $("#guardar_comprobante_seguro").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Comprobante de seguro médico (IMSS, ISSSTE, ISSEMYM, etc.)" ,
                            showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_oficio_asignacion_jefatura").click(function (event) {
                var oficio_asignacion_jefatura = $("#oficio_asignacion_jefatura").val();
                if(oficio_asignacion_jefatura != ""){
                    $("#form_oficio_asignacion_jefatura").submit();
                    $("#guardar_oficio_asignacion_jefatura").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Oficio de Asignación del Proyecto emitido por la Jefatura de División" ,
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_oficio_aceptacion_empresa").click(function (event) {
                var oficio_aceptacion_empresa = $("#oficio_aceptacion_empresa").val();
                if(oficio_aceptacion_empresa != ""){
                    $("#form_oficio_aceptacion_empresa").submit();
                    $("#guardar_oficio_aceptacion_empresa").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Oficio de Aceptación por parte de la empresa en hoja Membretada" ,
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_oficio_presentacion_tecnologico").click(function (event) {
                var oficio_presentacion_tecnologico = $("#oficio_presentacion_tecnologico").val();
                if(oficio_presentacion_tecnologico != ""){
                    $("#form_oficio_presentacion_tecnologico").submit();
                    $("#guardar_oficio_presentacion_tecnologico").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Oficio de Presentación por parte del TESVB" ,
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_anteproyecto").click(function (event) {
                var anteproyecto = $("#anteproyecto").val();
                if(anteproyecto != ""){
                    $("#form_anteproyecto").submit();
                    $("#guardar_anteproyecto").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Anteproyecto con el Visto Bueno de la Academia" ,
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_carta_compromiso").click(function (event) {
                var  carta_compromiso = $("#carta_compromiso").val();
                if( carta_compromiso != ""){
                    $("#form_carta_compromiso").submit();
                    $("#guardar_carta_compromiso").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Carta de compromiso firmada por el Asesor Interno y revisor" ,
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_convenio_empresa ").click(function (event) {
                var  convenio_empresa  = $("#convenio_empresa ").val();
                if( convenio_empresa  != ""){
                    $("#form_convenio_empresa").submit();
                    $("#guardar_convenio_empresa").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Convenio con la empresa (opcional)" ,
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#id_solicitud_residencia").click(function (event) {
                //alert('hola');
                $("#modal_modificar_solicitud_residencia").modal('show');
            });
            $("#id_constancia_avance_academico").click(function (event) {
                //alert('hola');
                $("#modal_modificar_constancia_avance_academico").modal('show');
            });
            $("#id_comprobante_seguro").click(function (event) {
                //alert('hola');
                $("#modal_modificar_comprobante_seguro").modal('show');
            });
            $("#id_oficio_asignacion_jefatura").click(function (event) {
                //alert('hola');
                $("#modal_modificar_oficio_asignacion_jefatura").modal('show');
            });
            $("#id_oficio_aceptacion_empresa").click(function (event) {
                //alert('hola');
                $("#modal_modificar_oficio_aceptacion_empresa").modal('show');
            });
            $("#id_oficio_presentacion_tecnologico").click(function (event) {
                //alert('hola');
                $("#modal_modificar_oficio_presentacion_tecnologico").modal('show');
            });
            $("#id_anteproyecto").click(function (event) {
                //alert('hola');
                $("#modal_modificar_anteproyecto").modal('show');
            });
            $("#id_carta_compromiso").click(function (event) {
                //alert('hola');
                $("#modal_modificar_carta_compromiso").modal('show');
            });
            $("#id_convenio_empresa").click(function (event) {
                //alert('hola');
                $("#modal_modificar_convenio_empresa").modal('show');
            });


            $("#modificar_solicitud_residencia").click(function (event) {

                var solicitud_residencia = $("#solicitud_residencia").val();
                if(solicitud_residencia != ""){
                    $("#form_modificar_solicitud_residencia").submit();
                    $("#modificar_solicitud_residencia").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Solicitud de Residencia Profesional",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_constancia_avance_academico").click(function (event) {

                var constancia_avance_academico = $("#constancia_avance_academico").val();
                if(constancia_avance_academico != ""){
                    $("#form_modificar_constancia_avance_academico").submit();
                    $("#modificar_constancia_avance_academico").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Constancia de 80% de avance académico, no adeudo de asignatura en curso especial,\n" +
                            "                                haber acreditado  el servicio social y haber acrdeitado los 5 creditos  de actividades complementarias\n" +
                            "                                emitido por la Subdirección de Servicios Escolares del TESVB.",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_comprobante_seguro").click(function (event) {

                var comprobante_seguro = $("#comprobante_seguro").val();
                if(comprobante_seguro != ""){
                    $("#form_modificar_comprobante_seguro").submit();
                    $("#modificar_comprobante_seguro").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Comprobante de seguro médico (IMSS, ISSSTE, ISSEMYM, etc.)",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_oficio_asignacion_jefatura").click(function (event) {

                var oficio_asignacion_jefatura = $("#oficio_asignacion_jefatura").val();
                if(oficio_asignacion_jefatura != ""){
                    $("#form_modificar_oficio_asignacion_jefatura").submit();
                    $("#modificar_oficio_asignacion_jefatura").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Oficio de Asignación del Proyecto emitido por la Jefatura de División",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_oficio_aceptacion_empresa").click(function (event) {

                var oficio_aceptacion_empresa = $("#oficio_aceptacion_empresa").val();
                if(oficio_aceptacion_empresa != ""){
                    $("#form_modificar_oficio_aceptacion_empresa").submit();
                    $("#modificar_oficio_aceptacion_empresa").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Oficio de Aceptación por parte de la empresa en hoja Membretada",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_oficio_presentacion_tecnologico").click(function (event) {

                var oficio_presentacion_tecnologico = $("#oficio_presentacion_tecnologico").val();
                if(oficio_presentacion_tecnologico != ""){
                    $("#form_modificar_oficio_presentacion_tecnologico").submit();
                    $("#modificar_oficio_presentacion_tecnologico").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Oficio de Presentación por parte del TESVB",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_anteproyecto").click(function (event) {

                var anteproyecto = $("#anteproyecto").val();
                if(anteproyecto != ""){
                    $("#form_modificar_anteproyecto").submit();
                    $("#modificar_anteproyecto").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Anteproyecto con el Visto Bueno de la Academia",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_carta_compromiso").click(function (event) {

                var carta_compromiso = $("#carta_compromiso").val();
                if(carta_compromiso != ""){
                    $("#form_modificar_carta_compromiso").submit();
                    $("#modificar_carta_compromiso").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Carta de compromiso firmada por el Asesor Interno y revisor",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_convenio_empresa").click(function (event) {

                var convenio_empresa = $("#convenio_empresa").val();
                if(convenio_empresa != ""){
                    $("#form_modificar_convenio_empresa").submit();
                    $("#modificar_convenio_empresa").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Convenio con la empresa (opcional)",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
        });
    </script>



@endsection
@extends('layouts.app')
@section('title', 'Documentación final de residenciaa')
@section('content')
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Enviar Documentación de Liberación de Residencia</h3>
                    </div>
                </div>
            </div>
        </div>
        @if( $estado_enviado == 0)
        @if( $estado_documentacion->correo_electronico == "")
         <div class="row">
             <div class="col-md-6 col-md-offset-3">
                 <div class="panel panel-info">
                     <div class="panel-body">
                         <form class="form" id="formulario_modificar_correo" action="{{url("/residencia/modificar_correo_documentacionfinal/alumno")}}" role="form" method="POST" >
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
                                             <label for="nombre_proyecto">Ingresar tu correo electronico.</label>
                                             <input class="form-control"  id="id_liberacion_documentos" name="id_liberacion_documentos" type="hidden"   value="{{$estado_documentacion->id_liberacion_documentos}}" required/>
                                             <input class="form-control"  id="correo_electronico_doc" name="correo_electronico_doc" type="email"  placeholder="Ingresa tu correo electronico" value="{{$estado_documentacion->correo_electronico}}" required/>
                                         </div>
                                     </div>
                                 </div>



                                 <div class="row">
                                     <div class="col-md-1 col-md-offset-5 ">
                                         <button id="modificar_correo_alta" class="btn btn-primary">Guardar</button>
                                     </div>
                                 </div>

                             </div>
                         </form>


                     </div>
                 </div>
             </div>
         </div>
            @else
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <form class="form" id="formulario_modificar_correo" action="{{url("/residencia/modificar_correo_documentacionfinal/alumno")}}" role="form" method="POST" >
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
                                                    <input class="form-control"  id="id_liberacion_documentos" name="id_liberacion_documentos" type="hidden"   value="{{$estado_documentacion->id_liberacion_documentos}}" required/>
                                                    <input class="form-control"  id="correo_electronico_doc" name="correo_electronico_doc" type="email"  placeholder="Ingresa tu correo electronico" value="{{$estado_documentacion->correo_electronico}}" required/>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-md-1 col-md-offset-5 ">
                                                <button id="modificar_correo_alta" class="btn btn-success">Modificar correo</button>
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
                                <p style="color: #FF0000"><b>Nota: El documento se deben escanear y guardar en un pdf legible,<br>
                                       Tambien igual el Proyecto Completo de Residencia Profesional se debe enviar al correo del Depto. de Servicio Social y Residencia Profesional</b></p>

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
                                        <td>Acta de Calificación de Residencia Profesional</td>
                                        @if($estado_documentacion->pdf_acta_calificacion  == "" )
                                            <td>
                                                <form class="form" id="form_acta_calificacion" action="{{url("/residencia/acta_calificacion/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}
                                                    <input class="form-control"  id="acta_calificacion" name="acta_calificacion" type="file"   accept="application/pdf" required/>
                                                </form>
                                            </td>
                                            <td>
                                                <button  id="guardar_acta_calificacion" class="btn btn-primary" >Guardar</button>
                                            </td>
                                        @else

                                            <td><a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$estado_documentacion->pdf_acta_calificacion)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                            <td>
                                                <button   id="id_acta_calificacion"  class="btn btn-primary" >Modificar</button>

                                            </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Portada del Proyecto de Residencia Profesional</td>
                                        @if($estado_documentacion->pdf_portada   == "" )
                                            <td>
                                                <form class="form" id="form_portada" action="{{url("/residencia/portada/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}
                                                    <input class="form-control"  id="portada" name="portada" type="file"   accept="application/pdf" required/>
                                                </form>
                                            </td>
                                            <td>
                                                <button  id="guardar_portada" class="btn btn-primary" >Guardar</button>
                                            </td>
                                        @else

                                            <td><a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$estado_documentacion->pdf_portada)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                            <td>
                                                <button   id="id_portada"  class="btn btn-primary" >Modificar</button>

                                            </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Evaluación Final de Residencia Profesional</td>
                                        @if($estado_documentacion->pdf_evaluacion_final_residencia   == "" )
                                            <td>
                                                <form class="form" id="form_evaluacion_final_residencia" action="{{url("/residencia/evaluacion_final_residencia/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}
                                                    <input class="form-control"  id="evaluacion_final_residencia" name="evaluacion_final_residencia" type="file"   accept="application/pdf" required/>
                                                </form>
                                            </td>
                                            <td>
                                                <button  id="guardar_evaluacion_final_residencia" class="btn btn-primary" >Guardar</button>
                                            </td>
                                        @else

                                            <td><a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$estado_documentacion->pdf_evaluacion_final_residencia)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                            <td>
                                                <button   id="id_evaluacion_final_residencia"  class="btn btn-primary" >Modificar</button>

                                            </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Oficio de Aceptación de Informe Final del Asesor Interno</td>
                                        @if($estado_documentacion->pdf_oficio_aceptacion_informe_interno    == "" )
                                            <td>
                                                <form class="form" id="form_oficio_aceptacion_informe_interno" action="{{url("/residencia/oficio_aceptacion_informe_interno/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}
                                                    <input class="form-control"  id="oficio_aceptacion_informe_interno" name="oficio_aceptacion_informe_interno" type="file"   accept="application/pdf" required/>
                                                </form>
                                            </td>
                                            <td>
                                                <button  id="guardar_oficio_aceptacion_informe_interno" class="btn btn-primary" >Guardar</button>
                                            </td>
                                        @else

                                            <td><a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$estado_documentacion->pdf_oficio_aceptacion_informe_interno)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                            <td>
                                                <button   id="id_oficio_aceptacion_informe_interno"  class="btn btn-primary" >Modificar</button>

                                            </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Formato de Evaluación</td>
                                        @if($estado_documentacion->pdf_formato_evaluacion     == "" )
                                            <td>
                                                <form class="form" id="form_formato_evaluacion" action="{{url("/residencia/formato_evaluacion/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}
                                                    <input class="form-control"  id="formato_evaluacion" name="formato_evaluacion" type="file"   accept="application/pdf" required/>
                                                </form>
                                            </td>
                                            <td>
                                                <button  id="guardar_formato_evaluacion" class="btn btn-primary" >Guardar</button>
                                            </td>
                                        @else

                                            <td><a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$estado_documentacion->pdf_formato_evaluacion)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                            <td>
                                                <button   id="id_formato_evaluacion"  class="btn btn-primary" >Modificar</button>

                                            </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Oficio de Aceptación de Informe Final del Revisor</td>
                                        @if($estado_documentacion->pdf_oficio_aceptacion_informe_revisor == "" )
                                            <td>
                                                <form class="form" id="form_oficio_aceptacion_informe_revisor" action="{{url("/residencia/oficio_aceptacion_informe_revisor/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}
                                                    <input class="form-control"  id="oficio_aceptacion_informe_revisor" name="oficio_aceptacion_informe_revisor" type="file"   accept="application/pdf" required/>
                                                </form>
                                            </td>
                                            <td>
                                                <button  id="guardar_oficio_aceptacion_informe_revisor" class="btn btn-primary" >Guardar</button>
                                            </td>
                                        @else
                                            <td><a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$estado_documentacion->pdf_oficio_aceptacion_informe_revisor)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                            <td>
                                                <button   id="id_oficio_aceptacion_informe_revisor"  class="btn btn-primary" >Modificar</button>
                                            </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Oficio de Aceptación de Informe Final del Asesor Externo</td>
                                        @if($estado_documentacion->pdf_oficio_aceptacion_informe_externo == "" )
                                            <td>
                                                <form class="form" id="form_oficio_aceptacion_informe_externo" action="{{url("/residencia/oficio_aceptacion_informe_externo/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}
                                                    <input class="form-control"  id="oficio_aceptacion_informe_externo" name="oficio_aceptacion_informe_externo" type="file"   accept="application/pdf" required/>
                                                </form>
                                            </td>
                                            <td>
                                                <button  id="guardar_oficio_aceptacion_informe_externo" class="btn btn-primary" >Guardar</button>
                                            </td>
                                        @else
                                            <td><a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$estado_documentacion->pdf_oficio_aceptacion_informe_externo)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                            <td>
                                                <button   id="id_oficio_aceptacion_informe_externo"  class="btn btn-primary" >Modificar</button>
                                            </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Formato de Horas</td>
                                        @if($estado_documentacion->pdf_formato_hora == "" )
                                            <td>
                                                <form class="form" id="form_formato_hora" action="{{url("/residencia/formato_hora/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}
                                                    <input class="form-control"  id="formato_hora" name="formato_hora" type="file"   accept="application/pdf" required/>
                                                </form>
                                            </td>
                                            <td>
                                                <button  id="guardar_formato_hora" class="btn btn-primary" >Guardar</button>
                                            </td>
                                        @else
                                            <td><a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$estado_documentacion->pdf_formato_hora)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                            <td>
                                                <button   id="id_formato_hora"  class="btn btn-primary" >Modificar</button>
                                            </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Formato de Seguimiento Interno</td>
                                        @if($estado_documentacion->pdf_seguimiento_interno  == "" )
                                            <td>
                                                <form class="form" id="form_seguimiento_interno" action="{{url("/residencia/seguimiento_interno/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}
                                                    <input class="form-control"  id="seguimiento_interno" name="seguimiento_interno" type="file"   accept="application/pdf" required/>
                                                </form>
                                            </td>
                                            <td>
                                                <button  id="guardar_seguimiento_interno" class="btn btn-primary" >Guardar</button>
                                            </td>
                                        @else
                                            <td><a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$estado_documentacion->pdf_seguimiento_interno)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                            <td>
                                                <button   id="id_seguimiento_interno"  class="btn btn-primary" >Modificar</button>
                                            </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Formato de Seguimiento Externo</td>
                                        @if($estado_documentacion->pdf_seguimiento_externo  == "" )
                                            <td>
                                                <form class="form" id="form_seguimiento_externo" action="{{url("/residencia/seguimiento_externo/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}
                                                    <input class="form-control"  id="seguimiento_externo" name="seguimiento_externo" type="file"   accept="application/pdf" required/>
                                                </form>
                                            </td>
                                            <td>
                                                <button  id="guardar_seguimiento_externo" class="btn btn-primary" >Guardar</button>
                                            </td>
                                        @else
                                            <td><a  target="_blank" href="{{asset('/residencia_pdf_doc_final/'.$estado_documentacion->pdf_seguimiento_externo)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                            <td>
                                                <button   id="id_seguimiento_externo"  class="btn btn-primary" >Modificar</button>
                                            </td>
                                        @endif
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    @if($estado_documentacion->pdf_acta_calificacion  != "" &&
                                         $estado_documentacion->pdf_portada   != "" &&
                                         $estado_documentacion->pdf_evaluacion_final_residencia  != "" &&
                                         $estado_documentacion->pdf_oficio_aceptacion_informe_interno  != "" &&
                                         $estado_documentacion->pdf_formato_evaluacion   != "" &&
                                         $estado_documentacion->pdf_oficio_aceptacion_informe_revisor  != "" &&
                                         $estado_documentacion->pdf_oficio_aceptacion_informe_externo   != "" &&
                                         $estado_documentacion->pdf_formato_hora   != "" &&
                                         $estado_documentacion->pdf_seguimiento_interno   != "" &&
                                         $estado_documentacion->pdf_seguimiento_externo   != "" )
                                        <div class="col-md-2 col-md-offset-5">
                                            <button   class="btn btn-success  " title="Enviar documentacion" data-toggle="modal" data-target="#enviar_documentacion_residencia_final">Enviar documentación</button>

                                        </div>
                                    @endif


                                </div>



                            </div>
                        </div>

                    </div>
                </div>

            @endif
     @endif
 </main>
    {{--modificar acta de calificacion --}}
    <div class="modal fade" id="modal_modificar_acta_calificacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar la Acta de Calificación de Residencia Profesional</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="acta_calificacion">Ingresar nuevo PDF con la Acta de Calificación de Residencia Profesional<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_acta_calificacion" action="{{url("/residencia/acta_calificacion/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="acta_calificacion" name="acta_calificacion" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_acta_calificacion" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar acta de calificacion--}}
    {{--modificar portada --}}
    <div class="modal fade" id="modal_modificar_portada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar la Portada del Proyecto de Residencia Profesional</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="acta_calificacion">Ingresar nuevo PDF con la Portada del Proyecto de Residencia Profesional<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_portada" action="{{url("/residencia/portada/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="portada" name="portada" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_portada" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar portada--}}
    {{--modificar evaluacion final --}}
    <div class="modal fade" id="modal_modificar_evaluacion_final_residencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar la Evaluación Final de Residencia Profesional</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="evaluacion_final_residencia">Ingresar nuevo PDF con la Evaluación Final de Residencia Profesional<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_evaluacion_final_residencia" action="{{url("/residencia/evaluacion_final_residencia/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="evaluacion_final_residencia" name="evaluacion_final_residencia" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_evaluacion_final_residencia" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar evaluacion final--}}
    {{--modificar oficio_aceptacion_informe_interno --}}
    <div class="modal fade" id="modal_modificar_oficio_aceptacion_informe_interno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar el Oficio de Aceptación de Informe Final del Asesor Interno</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="oficio_aceptacion_informe_interno">Ingresar nuevo PDF con el Oficio de Aceptación de Informe Final del Asesor Interno<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_oficio_aceptacion_informe_interno" action="{{url("/residencia/oficio_aceptacion_informe_interno/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="oficio_aceptacion_informe_interno" name="oficio_aceptacion_informe_interno" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_oficio_aceptacion_informe_interno" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar oficio_aceptacion_informe_interno--}}
    {{--modificar formato_evaluacion --}}
    <div class="modal fade" id="modal_modificar_formato_evaluacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar el Formato de Evaluación</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="formato_evaluacion">Ingresar nuevo PDF con el Formato de Evaluación<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_formato_evaluacion" action="{{url("/residencia/formato_evaluacion/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="formato_evaluacion" name="formato_evaluacion" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_formato_evaluacion" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar formato_evaluacion--}}
    {{--modificar oficio_aceptacion_informe_revisor --}}
    <div class="modal fade" id="modal_modificar_oficio_aceptacion_informe_revisor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar el Oficio de Aceptación de Informe Final del Revisor</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="oficio_aceptacion_informe_revisor">Ingresar nuevo PDF con el Oficio de Aceptación de Informe Final del Revisor<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_oficio_aceptacion_informe_revisor" action="{{url("/residencia/oficio_aceptacion_informe_revisor/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="oficio_aceptacion_informe_revisor" name="oficio_aceptacion_informe_revisor" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_oficio_aceptacion_informe_revisor" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar oficio_aceptacion_informe_revisor--}}
    {{--modificar oficio_aceptacion_informe_externo --}}
    <div class="modal fade" id="modal_modificar_oficio_aceptacion_informe_externo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar el Oficio de Aceptación de Informe Final del Asesor Externo</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="oficio_aceptacion_informe_externo">Ingresar nuevo PDF con el Oficio de Aceptación de Informe Final del Asesor Externo<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_oficio_aceptacion_informe_externo" action="{{url("/residencia/oficio_aceptacion_informe_externo/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="oficio_aceptacion_informe_externo" name="oficio_aceptacion_informe_externo" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_oficio_aceptacion_informe_externo" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar oficio_aceptacion_informe_revisor--}}
    {{--modificar formato_hora --}}
    <div class="modal fade" id="modal_modificar_formato_hora" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar el Oficio de Aceptación de Informe Final del Asesor Externo</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="formato_hora">Ingresar nuevo PDF con el Oficio de Aceptación de Informe Final del Asesor Externo<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_formato_hora" action="{{url("/residencia/formato_hora/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="formato_hora" name="formato_hora" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_formato_hora" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar formato_hora--}}
    {{--modificar seguimiento_interno --}}
    <div class="modal fade" id="modal_modificar_seguimiento_interno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar el Formato de Seguimiento Interno</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="seguimiento_interno">Ingresar nuevo PDF con el Formato de Seguimiento Interno<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_seguimiento_interno" action="{{url("/residencia/seguimiento_interno/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="seguimiento_interno" name="seguimiento_interno" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_seguimiento_interno" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar seguimiento_interno--}}
    {{--modificar seguimiento_externo --}}
    <div class="modal fade" id="modal_modificar_seguimiento_externo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar el Formato de Seguimiento Externo</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>
                            <label for="seguimiento_externo">Ingresar nuevo PDF con el Formato de Seguimiento Externo<b style="color:red; font-size:23px;">*</b></label>
                        <form class="form" id="form_modificar_seguimiento_externo" action="{{url("/residencia/seguimiento_externo/documentacionfinal/".$estado_documentacion->id_liberacion_documentos)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <input class="form-control"  id="seguimiento_externo" name="seguimiento_externo" type="file"   accept="application/pdf" required/>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  id="modificar_seguimiento_externo" class="btn btn-primary" >Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--modificar seguimiento_externo--}}
    <div class="modal fade" id="enviar_documentacion_residencia_final" role="dialog">

        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="POST" id="enviar_doc" action="{{url("/residencia/envio_documento_residencia_final/".$estado_documentacion->id_liberacion_documentos)}}">
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


            $("#guardar_acta_calificacion").click(function (event) {
                var acta_calificacion = $("#acta_calificacion").val();
                if(acta_calificacion != ""){
                    $("#form_acta_calificacion").submit();
                    $("#guardar_acta_calificacion").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Acta de Calificación de Residencia Profesional",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });

            $("#guardar_portada").click(function (event) {
                var portada = $("#portada").val();
                if(portada != ""){
                    $("#form_portada").submit();
                    $("#guardar_portada").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Portada del Proyecto de Residencia Profesional",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_evaluacion_final_residencia").click(function (event) {
                var evaluacion_final_residencia = $("#evaluacion_final_residencia").val();
                if(evaluacion_final_residencia != ""){
                    $("#form_evaluacion_final_residencia").submit();
                    $("#guardar_evaluacion_final_residencia").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Evaluación Final de Residencia Profesional",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_oficio_aceptacion_informe_interno").click(function (event) {
                var oficio_aceptacion_informe_interno = $("#oficio_aceptacion_informe_interno").val();
                if(oficio_aceptacion_informe_interno != ""){
                    $("#form_oficio_aceptacion_informe_interno").submit();
                    $("#guardar_oficio_aceptacion_informe_interno").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Oficio de Aceptación de Informe Final del Asesor Interno",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_formato_evaluacion").click(function (event) {
                var formato_evaluacion = $("#formato_evaluacion").val();
                if(formato_evaluacion != ""){
                    $("#form_formato_evaluacion").submit();
                    $("#guardar_formato_evaluacion").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Formato de Evaluación",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_oficio_aceptacion_informe_revisor").click(function (event) {
                var oficio_aceptacion_informe_revisor = $("#oficio_aceptacion_informe_revisor").val();
                //alert(oficio_aceptacion_informe_revisor);
                if(oficio_aceptacion_informe_revisor != ""){
                    $("#form_oficio_aceptacion_informe_revisor").submit();
                    $("#guardar_oficio_aceptacion_informe_revisor").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Oficio de Aceptación de Informe Final del Revisor",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_oficio_aceptacion_informe_externo").click(function (event) {
                var oficio_aceptacion_informe_externo = $("#oficio_aceptacion_informe_externo").val();
                //alert(oficio_aceptacion_informe_revisor);
                if(oficio_aceptacion_informe_externo != ""){
                    $("#form_oficio_aceptacion_informe_externo").submit();
                    $("#guardar_oficio_aceptacion_informe_externo").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Oficio de Aceptación de Informe Final del Asesor Externo",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_formato_hora").click(function (event) {
                var formato_hora = $("#formato_hora").val();
                //alert(oficio_aceptacion_informe_revisor);
                if(formato_hora != ""){
                    $("#form_formato_hora").submit();
                    $("#guardar_formato_hora").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Formato de Horas",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_seguimiento_interno").click(function (event) {
                var seguimiento_interno = $("#seguimiento_interno").val();
                //alert(oficio_aceptacion_informe_revisor);
                if(seguimiento_interno != ""){
                    $("#form_seguimiento_interno").submit();
                    $("#guardar_seguimiento_interno").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Formato de Seguimiento Interno",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#guardar_seguimiento_externo").click(function (event) {
                var seguimiento_externo = $("#seguimiento_externo").val();
                //alert(oficio_aceptacion_informe_revisor);
                if(seguimiento_externo != ""){
                    $("#form_seguimiento_externo").submit();
                    $("#guardar_seguimiento_externo").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Formato de Seguimiento Externo",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });



            $("#id_acta_calificacion").click(function (event) {
                //alert('hola');
                $("#modal_modificar_acta_calificacion").modal('show');
            });
            $("#id_portada").click(function (event) {
                //alert('hola');
                $("#modal_modificar_portada").modal('show');
            });
            $("#id_evaluacion_final_residencia").click(function (event) {
                //alert('hola');
                $("#modal_modificar_evaluacion_final_residencia").modal('show');
            });
            $("#id_oficio_aceptacion_informe_interno").click(function (event) {
                //alert('hola');
                $("#modal_modificar_oficio_aceptacion_informe_interno").modal('show');
            });
            $("#id_formato_evaluacion").click(function (event) {
                //alert('hola');
                $("#modal_modificar_formato_evaluacion").modal('show');
            });
            $("#id_oficio_aceptacion_informe_revisor").click(function (event) {
                //alert('hola');
                $("#modal_modificar_oficio_aceptacion_informe_revisor").modal('show');
            });
            $("#id_oficio_aceptacion_informe_externo").click(function (event) {
                //alert('hola');
                $("#modal_modificar_oficio_aceptacion_informe_externo").modal('show');
            });
            $("#id_formato_hora").click(function (event) {
                //alert('hola');
                $("#modal_modificar_formato_hora").modal('show');
            });
            $("#id_seguimiento_interno").click(function (event) {
                //alert('hola');
                $("#modal_modificar_seguimiento_interno").modal('show');
            });
            $("#id_seguimiento_externo").click(function (event) {
                //alert('hola');
                $("#modal_modificar_seguimiento_externo").modal('show');
            });

            $("#modificar_acta_calificacion").click(function (event) {

                var acta_calificacion = $("#acta_calificacion").val();
                if(acta_calificacion != ""){
                    $("#form_modificar_acta_calificacion").submit();
                    $("#modificar_acta_calificacion").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Acta de Calificación de Residencia Profesional",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_portada").click(function (event) {

                var portada = $("#portada").val();
                if(portada != ""){
                    $("#form_modificar_portada").submit();
                    $("#modificar_portada").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Portada del Proyecto de Residencia Profesional",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_evaluacion_final_residencia").click(function (event) {

                var evaluacion_final_residencia = $("#evaluacion_final_residencia").val();
                if(evaluacion_final_residencia != ""){
                    $("#form_modificar_evaluacion_final_residencia").submit();
                    $("#modificar_evaluacion_final_residencia").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Evaluación Final de Residencia Profesional",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_oficio_aceptacion_informe_interno").click(function (event) {
                var oficio_aceptacion_informe_interno = $("#oficio_aceptacion_informe_interno").val();
                if(oficio_aceptacion_informe_interno != ""){
                    $("#form_modificar_oficio_aceptacion_informe_interno").submit();
                    $("#modificar_oficio_aceptacion_informe_interno").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Oficio de Aceptación de Informe Final del Asesor Interno",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_formato_evaluacion").click(function (event) {
                var formato_evaluacion = $("#formato_evaluacion").val();
                if(formato_evaluacion != ""){
                    $("#form_modificar_formato_evaluacion").submit();
                    $("#modificar_formato_evaluacion").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Formato de Evaluación",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_oficio_aceptacion_informe_revisor").click(function (event) {
                var oficio_aceptacion_informe_revisor = $("#oficio_aceptacion_informe_revisor").val();
                //alert(oficio_aceptacion_informe_revisor);
                if(oficio_aceptacion_informe_revisor != ""){
                    $("#form_modificar_oficio_aceptacion_informe_revisor").submit();
                    $("#modificar_oficio_aceptacion_informe_revisor").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Oficio de Aceptación de Informe Final del Revisor",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_oficio_aceptacion_informe_externo").click(function (event) {
                var oficio_aceptacion_informe_externo = $("#oficio_aceptacion_informe_externo").val();
                //alert(oficio_aceptacion_informe_revisor);
                if(oficio_aceptacion_informe_externo != ""){
                    $("#form_modificar_oficio_aceptacion_informe_externo").submit();
                    $("#modificar_oficio_aceptacion_informe_externo").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Oficio de Aceptación de Informe Final del Asesor Externo",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_formato_hora").click(function (event) {
                var formato_hora = $("#formato_hora").val();
                //alert(oficio_aceptacion_informe_revisor);
                if(formato_hora != ""){
                    $("#form_modificar_formato_hora").submit();
                    $("#modificar_formato_hora").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Formato de Horas",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_seguimiento_interno").click(function (event) {
                var seguimiento_interno = $("#seguimiento_interno").val();
                //alert(oficio_aceptacion_informe_revisor);
                if(seguimiento_interno != ""){
                    $("#form_modificar_seguimiento_interno").submit();
                    $("#modificar_seguimiento_interno").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Formato de Seguimiento Interno",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_seguimiento_externo").click(function (event) {
                var seguimiento_externo = $("#seguimiento_externo").val();
                //alert(oficio_aceptacion_informe_revisor);
                if(seguimiento_externo != ""){
                    $("#form_modificar_seguimiento_externo").submit();
                    $("#modificar_seguimiento_externo").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el Formato de Seguimiento Externo",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
        });
    </script>
@endsection
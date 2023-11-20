@extends('layouts.app')
@section('title', 'Servicio social')
@section('content')

    <main class="col-md-12">
        @if($registro_servicio == 0)
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Registro de la primera etapa del Servicio Social</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <form class="form" id="formulario_registrar_tipo" action="{{url("/servicio_social/registro_tipo_empresa/")}}" role="form" method="POST" >
                            {{ csrf_field() }}
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="nombre_proyecto">Nombre del alumno:</label>
                                            <p>{{$alumno[0]->nombre}} {{$alumno[0]->apaterno}} {{$alumno[0]->amaterno}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nombre_proyecto">Ingresa tu correo electronico. (En el se te notificará, el estado que se encuentra tu documentación, si tienes que corregir o se encuentra autorizada).<b style="color:red; font-size:23px;">*</b></label>
                                            <input class="form-control"  id="correo_electronico" name="correo_electronico" type="email"  placeholder="Ingresa tu correo electronico" style="" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="dropdown">
                                            <label for="exampleInputEmail1">La empresa donde llevaras a cabo tu servicio social es:<b style="color:red; font-size:23px;">*</b></label>
                                            <select class="form-control  "placeholder="selecciona una Opcion" id="tipo_empresa" name="tipo_empresa" required>
                                                <option disabled selected hidden>Selecciona una opción</option>
                                                @foreach($tipos_empresas as $tipo_empresa)
                                                    <option value="{{$tipo_empresa->id_tipo_empresa}}" data-esta="{{$tipo_empresa->tipo_empresa}}">{{$tipo_empresa->tipo_empresa}}</option>
                                                @endforeach
                                            </select>
                                            <br>
                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 col-md-offset-5 ">
                                        <button id="guardar_datos" class="btn btn-primary">Aceptar</button>
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
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Documentos de la primera etapa del Servicio Social</h3>
                        </div>
                    </div>
                </div>
            </div>
            @if($registro_tipo_empresa[0]->id_tipo_empresa == 1)
                @if($registro_tipo_empresa[0]->id_estado_enviado== 0)
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-success">
                        <div class="panel-body" style="text-align: center">
                            <p><b>No. Cuenta: </b> {{$registro_tipo_empresa[0]->cuenta}}  <b>      Nombre del alumno:</b> {{$registro_tipo_empresa[0]->nombre}} {{$registro_tipo_empresa[0]->apaterno}} {{$registro_tipo_empresa[0]->amaterno}}</p>
                            <p><b>Correo electronico:</b> {{$registro_tipo_empresa[0]->correo_electronico}}  <b>     Tipo de empresa:</b> {{$registro_tipo_empresa[0]->tipo_empresa}}</p>
                            @if($verificacion_registro_empresa == 0)
                                <button class="btn btn-primary modificar_datos_alumnos" id="{{$registro_tipo_empresa[0]->id_datos_alumnos}}"><i class="glyphicon glyphicon-cog em2"></i></button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
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
                                            <td>Carta de aceptación </td>
                                            @if($datos_empresa[0]->pdf_carta_aceptacion == "" )
                                                <td>
                                                    <form class="form" id="form_carta_aceptacion" action="{{url("/servicio_social/registrar_carta_aceptacion/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                        {{ csrf_field() }}
                                                        <input class="form-control"  id="carta_aceptacion" name="carta_aceptacion" type="file"   accept="application/pdf" required/>
                                                    </form>
                                                </td>
                                                <td>
                                                    <button  id="guardar_carta_aceptacion" class="btn btn-primary" >Guardar</button>
                                                </td>
                                            @else

                                                <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_carta_aceptacion)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                                <td>
                                                    <button   id="id_modificar_carta_aceptacion"  class="btn btn-primary" >Modificar</button>

                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Anexo Tecnico </td>
                                            @if($datos_empresa[0]->pdf_anexo_tecnico == "" )
                                                <form class="form" id="form_anexo_tecnico" action="{{url("/servicio_social/registrar_anexo_tecnico/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}
                                                    <td>
                                                        <input class="form-control"  id="anexo_tecnico" name="anexo_tecnico" type="file"   accept="application/pdf" required/>
                                                    </td>
                                                </form>

                                                <td>
                                                    <button  id="guardar_anexo_tecnico" class="btn btn-primary" >Guardar</button>
                                                </td>
                                            @else
                                                <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_anexo_tecnico)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                                <td>
                                                    <button   id="id_modificar_anexo_tecnico"  class="btn btn-primary" >Modificar</button>

                                                </td>
                                            @endif

                                        </tr>
                                        <tr>
                                            <td>Copia de tu CURP</td>
                                            @if($datos_empresa[0]->pdf_curp == "" )
                                                <form class="form" id="form_curp" action="{{url("/servicio_social/registrar_curp/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}

                                                    <td>
                                                        <input class="form-control"   id="curp" name="curp" type="file"   accept="application/pdf" required/>
                                                    </td>
                                                </form>
                                                <td>
                                                    <button  id="guardar_curp" class="btn btn-primary" >Guardar</button>
                                                </td>
                                            @else
                                                <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_curp)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                                <td>
                                                    <button   id="id_modificar_curp"  class="btn btn-primary" >Modificar</button>

                                                </td>
                                            @endif

                                        </tr>
                                        <tr>
                                            <td>Copia de tu Carnet</td>
                                            @if($datos_empresa[0]->pdf_carnet == "" )
                                                <form class="form" id="form_carnet" action="{{url("/servicio_social/registrar_carnet/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}

                                                    <td>
                                                        <input class="form-control"   id="carnet" name="carnet" type="file"   accept="application/pdf" required/>
                                                    </td>
                                                </form>
                                                <td>
                                                    <button  id="guardar_carnet" class="btn btn-primary" >Guardar</button>
                                                </td>
                                            @else
                                                <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_carnet)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                                <td>
                                                    <button   id="id_modificar_carnet"  class="btn btn-primary" >Modificar</button>

                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Constancia original del 50% de creditos</td>
                                            @if($datos_empresa[0]->pdf_constancia_creditos == "" )
                                                <form class="form" id="form_costancia_creditos" action="{{url("/servicio_social/registrar_costancia_creditos/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}

                                                    <td>
                                                        <input class="form-control"   id="costancia_creditos" name="costancia_creditos" type="file"   accept="application/pdf" required/>
                                                    </td>
                                                </form>
                                                <td>
                                                    <button  id="guardar_costancia_creditos" class="btn btn-primary" >Guardar</button>
                                                </td>
                                            @else
                                                <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_constancia_creditos)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                                <td>
                                                    <button   id="id_modificar_costancia_creditos"  class="btn btn-primary" >Modificar</button>

                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Solicitud de registro de autorización</td>
                                            @if($datos_empresa[0]->pdf_solicitud_reg_autori == "" )
                                                <form class="form" id="form_solicitud_registro" action="{{url("/servicio_social/registrar_solicitud_registro/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}

                                                    <td>
                                                        <input class="form-control"   id="solicitud_registro" name="solicitud_registro" type="file"   accept="application/pdf" required/>
                                                    </td>
                                                </form>
                                                <td>
                                                    <button  id="guardar_solicitud_registro" class="btn btn-primary" >Guardar</button>
                                                </td>
                                            @else
                                                <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_solicitud_reg_autori)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                                <td>
                                                    <button   id="id_modificar_solicitud_registro"  class="btn btn-primary" >Modificar</button>

                                                </td>
                                            @endif

                                        </tr>

                                        </tbody>
                                    </table>

                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-3">
                                            <button   class="btn btn-danger  " title="Eliminar registro" data-toggle="modal" data-target="#eliminar_empresa_privada"><i class="glyphicon glyphicon-trash em56"></i></button>
                                        </div>
                                        @if($datos_empresa[0]->pdf_carta_aceptacion !=" " && $datos_empresa[0]->pdf_anexo_tecnico != "" && $datos_empresa[0]->pdf_curp != "" && $datos_empresa[0]->pdf_carnet != "" && $datos_empresa[0]->pdf_constancia_creditos != "" && $datos_empresa[0]->pdf_solicitud_reg_autori != ""  )
                                            <div class="col-md-2 col-md-offset-2">
                                                <button   class="btn btn-success  " title="Enviar documentacion" data-toggle="modal" data-target="#enviar_registro_servicio">Enviar documentación</button>

                                            </div>
                                        @endif
                                    </div>




                                </div>
                            </div>

                        </div>
                    </div>
                @elseif($registro_tipo_empresa[0]->id_estado_enviado== 1)
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title text-center">Se envío correctamente la documentación al Departamento del Servicio Social y Residencia.</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
            @if($registro_tipo_empresa[0]->id_tipo_empresa == 2)
                @if($registro_tipo_empresa[0]->id_estado_enviado== 0)
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
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
                                            <td>Copia de tu CURP</td>
                                            @if($datos_empresa[0]->pdf_curp == "" )
                                                <form class="form" id="form_curp" action="{{url("/servicio_social/registrar_curp/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}

                                                    <td>
                                                        <input class="form-control"   id="curp" name="curp" type="file"   accept="application/pdf" required/>
                                                    </td>
                                                </form>
                                                <td>
                                                    <button  id="guardar_curp" class="btn btn-primary" >Guardar</button>
                                                </td>
                                            @else
                                                <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_curp)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                                <td>
                                                    <button   id="id_modificar_curp"  class="btn btn-primary" >Modificar</button>

                                                </td>
                                            @endif

                                        </tr>
                                        <tr>
                                            <td>Copia de tu Carnet</td>
                                            @if($datos_empresa[0]->pdf_carnet == "" )
                                                <form class="form" id="form_carnet" action="{{url("/servicio_social/registrar_carnet/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}

                                                    <td>
                                                        <input class="form-control"   id="carnet" name="carnet" type="file"   accept="application/pdf" required/>
                                                    </td>
                                                </form>
                                                <td>
                                                    <button  id="guardar_carnet" class="btn btn-primary" >Guardar</button>
                                                </td>
                                            @else
                                                <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_carnet)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                                <td>
                                                    <button   id="id_modificar_carnet"  class="btn btn-primary" >Modificar</button>

                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Constancia original del 50% de creditos</td>
                                            @if($datos_empresa[0]->pdf_constancia_creditos == "" )
                                                <form class="form" id="form_costancia_creditos" action="{{url("/servicio_social/registrar_costancia_creditos/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}

                                                    <td>
                                                        <input class="form-control"   id="costancia_creditos" name="costancia_creditos" type="file"   accept="application/pdf" required/>
                                                    </td>
                                                </form>
                                                <td>
                                                    <button  id="guardar_costancia_creditos" class="btn btn-primary" >Guardar</button>
                                                </td>
                                            @else
                                                <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_constancia_creditos)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                                <td>
                                                    <button   id="id_modificar_costancia_creditos"  class="btn btn-primary" >Modificar</button>

                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Solicitud de registro de autorización</td>
                                            @if($datos_empresa[0]->pdf_solicitud_reg_autori == "" )
                                                <form class="form" id="form_solicitud_registro" action="{{url("/servicio_social/registrar_solicitud_registro/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                                    {{ csrf_field() }}

                                                    <td>
                                                        <input class="form-control"   id="solicitud_registro" name="solicitud_registro" type="file"   accept="application/pdf" required/>
                                                    </td>
                                                </form>
                                                <td>
                                                    <button  id="guardar_solicitud_registro" class="btn btn-primary" >Guardar</button>
                                                </td>
                                            @else
                                                <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_solicitud_reg_autori)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                                <td>
                                                    <button   id="id_modificar_solicitud_registro"  class="btn btn-primary" >Modificar</button>

                                                </td>
                                            @endif

                                        </tr>

                                        </tbody>
                                    </table>

                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-3">
                                            <button   class="btn btn-danger  " title="Eliminar registro" data-toggle="modal" data-target="#eliminar_empresa_privada"><i class="glyphicon glyphicon-trash em56"></i></button>
                                        </div>
                                        @if($datos_empresa[0]->pdf_curp != "" && $datos_empresa[0]->pdf_carnet != "" && $datos_empresa[0]->pdf_constancia_creditos != "" && $datos_empresa[0]->pdf_solicitud_reg_autori != ""  )
                                        <div class="col-md-2 col-md-offset-2">
                                            <button   class="btn btn-success  " title="Enviar documentacion" data-toggle="modal" data-target="#enviar_registro_servicio">Enviar documentación</button>

                                        </div>
                                        @endif
                                    </div>





                                </div>
                            </div>

                        </div>
                    </div>
                    @elseif($registro_tipo_empresa[0]->id_estado_enviado== 1)
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title text-center">Se envío correctamente la documentación al Departamento del Servicio Social y Residencia.</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{--modificar carta aceptacion --}}
            <div class="modal fade" id="modal_modificar_carta_aceptacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Modificar Carta Aceptación</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <p>
                                    <label for="nombre_proyecto">Ingresar nuevo PDF con la Carta Aceptación.<b style="color:red; font-size:23px;">*</b></label>
                                <form class="form" id="form_modificar_carta_aceptacion" action="{{url("/servicio_social/registrar_carta_aceptacion/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                    {{ csrf_field() }}
                                    <input class="form-control"  id="carta_aceptacion" name="carta_aceptacion" type="file"   accept="application/pdf" required/>
                                </form>
                                </p>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button  id="modificar_carta_aceptacion" class="btn btn-primary" >Modificar</button>

                        </div>
                    </div>
                </div>
            </div>
            {{--modificar anexo tecnico --}}
            <div class="modal fade" id="modal_modificar_anexo_tecnico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Modificar Anexo Tecnico</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <p>
                                    <label for="nombre_proyecto">Ingresar nuevo PDF con el Anexo Tecnico.<b style="color:red; font-size:23px;">*</b></label>
                                <form class="form" id="form_modificar_anexo_tecnico"action="{{url("/servicio_social/registrar_anexo_tecnico/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                    {{ csrf_field() }}
                                    <input class="form-control"  id="anexo_tecnico" name="anexo_tecnico" type="file"   accept="application/pdf" required/>
                                </form>
                                </p>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button  id="modificar_anexo_tecnico" class="btn btn-primary" >Modificar</button>

                        </div>
                    </div>
                </div>
            </div>
            {{--modificar curp --}}
            <div class="modal fade" id="modal_modificar_curp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Modificar Curp</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <p>
                                    <label for="nombre_proyecto">Ingresar nuevo PDF con la Curp.<b style="color:red; font-size:23px;">*</b></label>
                                <form class="form" id="form_modificar_curp"action="{{url("/servicio_social/registrar_curp/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                    {{ csrf_field() }}
                                    <input class="form-control"  id="curp" name="curp" type="file"   accept="application/pdf" required/>
                                </form>
                                </p>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button  id="modificar_curp" class="btn btn-primary" >Modificar</button>

                        </div>
                    </div>
                </div>
            </div>

            {{--modificar carnet --}}
            <div class="modal fade" id="modal_modificar_carnet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Modificar Carnet</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <p>
                                    <label for="nombre_proyecto">Ingresar nuevo PDF con el Carnet.<b style="color:red; font-size:23px;">*</b></label>
                                <form class="form" id="form_modificar_carnet"action="{{url("/servicio_social/registrar_carnet/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                    {{ csrf_field() }}
                                    <input class="form-control"  id="carnet" name="carnet" type="file"   accept="application/pdf" required/>
                                </form>
                                </p>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button  id="modificar_carnet" class="btn btn-primary" >Modificar</button>

                        </div>
                    </div>
                </div>
            </div>

            {{--modificar carnet --}}
            <div class="modal fade" id="modal_modificar_costancia_creditos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Modificar Costancia de Creditos</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <p>
                                    <label for="nombre_proyecto">Ingresar nuevo PDF con la Constancia de Creditos.<b style="color:red; font-size:23px;">*</b></label>
                                <form class="form" id="form_modificar_costancia_creditos"action="{{url("/servicio_social/registrar_costancia_creditos/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                    {{ csrf_field() }}
                                    <input class="form-control"  id="costancia_creditos" name="costancia_creditos" type="file"   accept="application/pdf" required/>
                                </form>
                                </p>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button  id="modificar_costancia_creditos" class="btn btn-primary" >Modificar</button>

                        </div>
                    </div>
                </div>
            </div>
            {{--modificar solicitud_registro --}}
            <div class="modal fade" id="modal_modificar_solicitud_registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Modificar Solicitud de registro de autorización</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <p>
                                    <label for="nombre_proyecto">Ingresar nuevo PDF con la Solicitud de registro de autorización.<b style="color:red; font-size:23px;">*</b></label>
                                <form class="form" id="form_modificar_solicitud_registro"action="{{url("/servicio_social/registrar_solicitud_registro/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                    {{ csrf_field() }}
                                    <input class="form-control"  id="solicitud_registro" name="solicitud_registro" type="file"   accept="application/pdf" required/>
                                </form>
                                </p>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button  id="modificar_solicitud_registro" class="btn btn-primary" >Modificar</button>

                        </div>
                    </div>
                </div>
            </div>

            {{--modificar registro tipo_empresa--}}
            <div class="modal fade" id="modal_modificar_datos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form class="form" action="{{url("/servicio_social/modificacion_tipo_empresa/")}}" role="form" method="POST" >
                            {{ csrf_field() }}
                            <div class="modal-header bg-info">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-center" id="myModalLabel">Modificar Datos</h4>
                            </div>
                            <div id="contenedor_modificar_datos">


                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button  type="submit" class="btn btn-primary" >guardar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            {{--fin modificar actividad--}}
            {{--inicio Eliminar registro de empresa  privada--}}
            <div class="modal fade" id="eliminar_empresa_privada" role="dialog">
                <form method="POST" action="{{ url("/servicio_social/eliminar_registro_servicio/{$registro_tipo_empresa[0]->id_datos_alumnos}") }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Eliminar Registro</h4>
                            </div>
                            <div class="modal-body">
                                <p>¿Seguro que quieres, eliminar tu registro de la primera etapa del Servicio Social?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button  type="submit" class="btn btn-primary" >Aceptar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- fin de Eliminar registro de empresa  privada--}}

            {{--inicio Enviar registro de empresa  privada--}}
            <div class="modal fade" id="enviar_registro_servicio" role="dialog">

                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <form method="POST" id="enviar_doc" action="{{ url("/servicio_social/enviar_registro_servicio/{$registro_tipo_empresa[0]->id_datos_alumnos}") }}">
                            @csrf
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Enviar documentos</h4>
                            </div>
                            <div class="modal-body">
                                <p>¿Seguro que quieres, enviar tus documentos de la primera etapa del Servicio Social al Departamento de Servicio Social y Residencia Profesional para su revisión?</p>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button  id="documentacion" class="btn btn-primary" >Aceptar</button>
                        </div>
                    </div>
                </div>

            </div>

            {{-- fin de Enviar registro de empresa  privada--}}
            @endif

    </main>

    <script type="text/javascript">
        $(document).ready( function() {

            $("#guardar_carta_aceptacion").click(function (event) {
                var carta_aceptacion = $("#carta_aceptacion").val();
                if(carta_aceptacion != ""){
                    $("#form_carta_aceptacion").submit();
                    $("#guardar_carta_aceptacion").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Carta de Aceptación",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            });
            $("#guardar_anexo_tecnico").click(function (event) {
                var anexo_tecnico = $("#anexo_tecnico").val();
                if(anexo_tecnico != ""){
                    $("#form_anexo_tecnico").submit();
                    $("#guardar_anexo_tecnico").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el anexo tecnico",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            });
            $("#guardar_curp").click(function (event) {
                var curp = $("#curp").val();
                //alert(curp);
                if(curp != ""){
                    $("#form_curp").submit();
                    $("#guardar_curp").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con tu Curp",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            });
            $("#guardar_carnet").click(function (event) {
                var carnet = $("#carnet").val();
                if(carnet != ""){
                    $("#form_carnet").submit();
                    $("#guardar_carnet").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con el carnet",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            });
            $("#guardar_costancia_creditos").click(function (event) {
                var costancia_creditos = $("#costancia_creditos").val();
                if(costancia_creditos != ""){
                    $("#form_costancia_creditos").submit();
                    $("#guardar_costancia_creditos").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Constancia original del 50% de creditos",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            });

            $("#guardar_solicitud_registro").click(function (event) {
                var solicitud_registro = $("#solicitud_registro").val();
                if(solicitud_registro != ""){
                    $("#form_solicitud_registro").submit();
                    $("#guardar_solicitud_registro").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Solicitud de registro de autorización",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            });


            $("#id_modificar_carta_aceptacion").click(function (event) {
                //alert('hola');
                $("#modal_modificar_carta_aceptacion").modal('show');
            });
            $("#id_modificar_anexo_tecnico").click(function (event) {
                //alert('hola');
                $("#modal_modificar_anexo_tecnico").modal('show');
            });
            $("#id_modificar_curp").click(function (event) {
                //alert('hola');
                $("#modal_modificar_curp").modal('show');
            });
            $("#id_modificar_carnet").click(function (event) {
                //alert('hola');
                $("#modal_modificar_carnet").modal('show');
            });
            $("#id_modificar_costancia_creditos").click(function (event) {
                //alert('hola');
                $("#modal_modificar_costancia_creditos").modal('show');
            });
            $("#id_modificar_solicitud_registro").click(function (event) {
                //alert('hola');
                $("#modal_modificar_solicitud_registro").modal('show');
            });


            $("#modificar_carta_aceptacion").click(function (event) {

                var carta_aceptacion = $("#carta_aceptacion").val();
                if(carta_aceptacion != ""){
                    $("#form_modificar_carta_aceptacion").submit();
                    $("#modificar_carta_aceptacion").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Carta de Aceptación",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_anexo_tecnico").click(function (event) {

                var anexo_tecnico = $("#anexo_tecnico").val();
                if(anexo_tecnico != ""){
                    $("#form_modificar_anexo_tecnico").submit();
                    $("#modificar_anexo_tecnico").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con anexo_tecnico",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_curp").click(function (event) {

                var curp = $("#curp").val();
                if(curp != ""){
                    $("#form_modificar_curp").submit();
                    $("#modificar_curp").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con tu curp",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_carnet").click(function (event) {

                var carnet = $("#carnet").val();
                if(carnet != ""){
                    $("#form_modificar_carnet").submit();
                    $("#modificar_carnet").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con tu carnet",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_costancia_creditos").click(function (event) {

                var costancia_creditos = $("#costancia_creditos").val();
                if(costancia_creditos != ""){
                    $("#form_modificar_costancia_creditos").submit();
                    $("#modificar_costancia_creditos").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con tu Constancia de creditos ",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_solicitud_registro").click(function (event) {

                var solicitud_registro = $("#solicitud_registro").val();
                if(solicitud_registro != ""){
                    $("#form_modificar_solicitud_registro").submit();
                    $("#modificar_solicitud_registro").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con tu Solicitud de registro de autorización ",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });


            $("#guardar_datos").click(function (event) {
                var correo_electronico = $("#correo_electronico").val();
                var tipo_empresa = $("#tipo_empresa").val();

                if(correo_electronico != "" && tipo_empresa == 1 || correo_electronico != " " && tipo_empresa ==2 )
                {
                    $("#formulario_registrar_tipo").submit();
                    $("#guardar_datos").attr("disabled", true);
                }
            });
            $(".modificar_datos_alumnos").click(function (event) {
                var id_datos_alumnos=$(this).attr('id');
                $.get("/servicio_social/modificar_tipo_empresa/"+id_datos_alumnos,function(request){
                    $("#contenedor_modificar_datos").html(request);
                    $("#modal_modificar_datos").modal('show');
                });
            });
            $("#documentacion").click(function (event) {
                $("#enviar_doc").submit();
                $("#documentacion").attr("disabled", true);
            });

        });
    </script>



@endsection
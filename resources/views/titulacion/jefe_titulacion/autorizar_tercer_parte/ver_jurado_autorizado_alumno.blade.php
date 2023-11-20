@extends('layouts.app')
@section('title', 'Titulación')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <p>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                    <a href="{{url("/titulacion/autorizados_jurado/".$datos_alumno->id_carrera)}}"> Estudiantes con jurado autorizado</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span>Jurado de Titulación del Estudiante</span>
                </p>
                <br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h1 class="panel-title text-center">Jurado de Titulación del Estudiante</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <h4 for="deparamento">Número de cuenta: {{ $datos_alumno->no_cuenta}}  </h4>
                        <h4 for="deparamento"> Nombre del estudiante: {{ $datos_alumno->nombre_al }} {{ $datos_alumno->apaterno }} {{ $datos_alumno->amaterno }}</h4>
                        <h4 for="deparamento"> Carrera: {{ $datos_alumno->carrera}}</h4>
                        <h4 for="deparamento"> Telefono: {{ $datos_alumno->telefono}}</h4>
                        <h4 for="deparamento"> Correo electronico: {{ $datos_alumno->correo_electronico}}</h4>
                        <h4 for="deparamento"> Nombre de la sala: {{ $datos_alumno->nombre_sala }}</h4>

                    </div>
                </div>
            </div>
        </div>
        @if($datos_alumno->honorifica == 1)
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Con Mención honorifica<br>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Nombre del documento </th>
                                <th>Acción</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Oficio de notificación del Jurado (Jefe de División) </td>
                                @if($datos_alumno->id_oficio_noti_jurado_jefe == 0)
                                    <td><button id="capturar_dat_jefe" class="btn btn-primary">Capturar fecha y número de oficio</button></td>
                                @elseif($datos_alumno->id_oficio_noti_jurado_jefe == 1)
                                    <td>
                                        Fecha del oficio: <b>{{ $datos_alumno->fecha_oficio_noti_jurado_jefe }}</b> <br>
                                        Número de oficio: <b>{{ $datos_alumno->oficio_noti_jurado_jefe }}</b> <br>
                                        <button id="editar_dat_jefe" class="btn btn-primary">Modificar</button>
                                        <button id="autorizar_dat_jefe" class="btn btn-success">Autorizar</button>
                                    </td>
                                @elseif($datos_alumno->id_oficio_noti_jurado_jefe == 2)

                                    <td>
                                        Fecha del oficio: <b>{{ $datos_alumno->fecha_oficio_noti_jurado_jefe }}</b> <br>
                                        Número de oficio: <b>{{ $datos_alumno->oficio_noti_jurado_jefe }}</b> <br>
                                        <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/pdf_oficio_notificacion_jefe/'.$datos_alumno->id_fecha_jurado_alumn)}}')">Imprimir oficio</button>


                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td>Oficio de notificación del Jurado (Estudiante) </td>
                                @if($datos_alumno->id_oficio_noti_jurado_estudiante  == 0)
                                    <td><button id="capturar_dat_estudiante" class="btn btn-primary">Capturar fecha y número de oficio</button></td>
                                @elseif($datos_alumno->id_oficio_noti_jurado_estudiante  == 1)
                                    <td>
                                        Fecha del oficio: <b>{{ $datos_alumno->fecha_oficio_noti_jurado_estudiante }}</b> <br>
                                        Número de oficio: <b>{{ $datos_alumno->oficio_noti_jurado_estudiante }}</b> <br>
                                        <button id="editar_dat_estudiante" class="btn btn-primary">Modificar</button>
                                        <button id="autorizar_dat_estudiante" class="btn btn-success">Autorizar</button>
                                    </td>
                                @elseif($datos_alumno->id_oficio_noti_jurado_estudiante == 2)

                                    <td>
                                        Fecha del oficio: <b>{{ $datos_alumno->fecha_oficio_noti_jurado_estudiante }}</b> <br>
                                        Número de oficio: <b>{{ $datos_alumno->oficio_noti_jurado_estudiante }}</b> <br>
                                        <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/pdf_oficio_notificacion_estudiante/'.$datos_alumno->id_fecha_jurado_alumn)}}')">Imprimir oficio</button>


                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td>Carta de compromiso</td>
                                <td>
                                <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/pdf_carta_compromiso/'.$datos_alumno->id_fecha_jurado_alumn)}}')">Imprimir oficio</button>
                                </td>

                            </tr>
                                @if($datos_alumno->honorifica == 1)
                               <tr>
                                <td>Mención honorifica</td>
                                   @if($datos_alumno->id_mencion_honorifica  == 0)
                                       <td><button id="capturar_dat_honorifica" class="btn btn-primary">Capturar fecha y número de oficio</button></td>
                                   @elseif($datos_alumno->id_mencion_honorifica  == 1)
                                       <td>
                                           Fecha del oficio: <b>{{ $datos_alumno->fecha_mencion_honorifica }}</b> <br>
                                           Número de oficio: <b>{{ $datos_alumno->mencion_honorifica }}</b> <br>
                                           <button id="editar_dat_honorifica" class="btn btn-primary">Modificar</button>
                                           <button id="autorizar_dat_honorifica" class="btn btn-success">Autorizar</button>
                                       </td>
                                   @elseif($datos_alumno->id_mencion_honorifica == 2)

                                       <td>
                                           Fecha del oficio: <b>{{ $datos_alumno->fecha_mencion_honorifica }}</b> <br>
                                           Número de oficio: <b>{{ $datos_alumno->mencion_honorifica }}</b> <br>
                                           <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/pdf_mencion_honorifica/'.$datos_alumno->id_fecha_jurado_alumn)}}')">Imprimir oficio</button>


                                       </td>
                                   @endif
                               </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-body">
                         <h2 for="deparamento">Fecha Titulación: {{ $datos_alumno->fecha_titulacion }}</h2>
                        <h2 for="deparamento">Horario de titulación: {{ $hora->horario_dia }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Jurado</th>
                                <th>Nombre del integrante de jurado</th>
                                <th>Acción</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Presidente </td>
                                <td>{{ $dato_presidente->nombre }}</td>
                                <td><button id="modificar_presidente" class="btn btn-primary">Modificar presidente</button></td>

                               </tr>
                            <tr>
                                <td>Secretario</td>

                                <td>{{ $dato_secretario->nombre }}</td>
                                <td><button id="modificar_secretario" class="btn btn-primary">Modificar secretario</button></td>
                             </tr>
                            <tr>
                                <td>Vocal</td>
                                <td>{{ $dato_vocal->nombre }}</td>
                                <td><button id="modificar_vocal" class="btn btn-primary">Modificar vocal</button></td>


                            </tr>
                            <tr>
                                <td>Suplente</td>
                                <td>{{ $dato_suplente->nombre }}</td>
                                <td><button id="modificar_suplente" class="btn btn-primary">Modificar suplente</button></td>
                               </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

        </div>
        <div class="row">
            <p></p>

        </div>





    </main>
    {{--agregar fecha y nuemero de oficio  del oficio de notificacionjefe de division--}}
    <div class="modal fade" id="modal_agregar_dat_jefe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Oficio de notificación del Jurado (Jefe de División) </h4>
                </div>
                <div class="modal-body">
                    <form id="form_agregar_dat_jefe" class="form" action="{{url("/titulacion/guardar_datos_oficio_notificacion_jefe/".$datos_alumno->id_fecha_jurado_alumn)}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="deparamento">Selecciona fecha del oficio de notificacion del jurado (Jefe de División)</label>
                                    <div class='input-group date' style='font-size: 25px; size: 25px;' data-date-format="dd-mm-yyyy" id='datetimepicker11' >
                                        <input type='text' id="fecha_oficio_jefe" name="fecha_oficio_jefe" class="form-control" required />
                                        <span class="input-group-addon" >
                                        <span class="glyphicon glyphicon-calendar">
                                     </span>
                                    </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="nombre_proyecto">Número de oficio de notificacion del jurado (Jefe de División)<b style="color:red; font-size:23px;">*</b></label>
                                    <input class="form-control"  id="numero_oficio_jefe" name="numero_oficio_jefe" type="text"   placeholder="Ingresa número de oficio de notificacion del jurado (Jefe de División)"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>

                                </div>
                            </div>
                        </div>


                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_agregar_dat_jefe" class="btn btn-primary">Guardar</button>

                </div>
            </div>
        </div>
    </div>

    {{--fin agregar fecha y nuemero de oficio  del oficio de notificacionjefe de division--}}
    {{--editar fecha y nuemero de oficio  del oficio de notificacionjefe de division--}}
    <div class="modal fade" id="modal_editar_dat_jefe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar datos del oficio de notificación del jurado (Jefe de División) </h4>
                </div>
                <div class="modal-body">
                    <form id="form_editar_dat_jefe" class="form" action="{{url("/titulacion/guardar_editar_datos_oficio_notificacion_jefe/".$datos_alumno->id_fecha_jurado_alumn)}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="deparamento">Selecciona fecha del oficio de notificacion del jurado (Jefe de visión)</label>
                                    <div class='input-group date' style='font-size: 25px; size: 25px;' data-date-format="dd-mm-yyyy" id='datetimepicker12' >
                                        <input type='text' id="fecha_oficio_jefes" name="fecha_oficio_jefes"  value="{{ $datos_alumno->fecha_oficio_noti_jurado_jefe}}" class="form-control" required />
                                        <span class="input-group-addon" >
                                        <span class="glyphicon glyphicon-calendar">
                                     </span>
                                    </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="nombre_proyecto">Número de oficio de notificacion del jurado (Jefe de visión)<b style="color:red; font-size:23px;">*</b></label>
                                    <input class="form-control"  id="numero_oficio_jefes" name="numero_oficio_jefes" type="text"   placeholder="Ingresa número de oficio de notificacion del jurado (Jefe de visión)"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{ $datos_alumno->oficio_noti_jurado_jefe }}"  required/>

                                </div>
                            </div>
                        </div>


                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_editar_agregar_dat_jefe" class="btn btn-primary">Guardar</button>

                </div>
            </div>
        </div>
    </div>

    {{--fin editar fecha y nuemero de oficio  del oficio de notificacionjefe de division--}}
    {{--autorizar fecha y nuemero de oficio  del oficio de notificacionjefe de division --}}

    <div class="modal fade" id="modal_autorizar_oficio_jefe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Autorizar fecha y número de oficio de notificacion (jefe de division)</h4>
                </div>
                <div class="modal-body">
                    <form id="form_autorizar_oficio_jefe" class="form" action="{{url("/titulacion/autorizar_datos_oficio_notificacion_jefe/".$datos_alumno->id_fecha_jurado_alumn)}}" role="form" method="POST" >
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <h3>¿Seguro que quieres autorizar fecha y número, ya no podras hacer ninguna modificación? </h3>
                            </div>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_autorizar_oficio_jefe" class="btn btn-success">Aceptar</button>

                </div>
            </div>
        </div>
    </div>

    {{--autorizar fecha y nuemero de oficio  del oficio de notificacionjefe de division--}}

    {{--agregar fecha y nuemero de oficio  del oficio de notificacion estudiante--}}
    <div class="modal fade" id="modal_agregar_dat_estudiante" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Oficio de notificación del Jurado (Estudiante) </h4>
                </div>
                <div class="modal-body">
                    <form id="form_agregar_dat_estudiante" class="form" action="{{url("/titulacion/guardar_datos_oficio_notificacion_estudiante/".$datos_alumno->id_fecha_jurado_alumn)}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="deparamento">Selecciona fecha del oficio de notificacion del jurado (Estudiante)</label>
                                    <div class='input-group date' style='font-size: 25px; size: 25px;' data-date-format="dd-mm-yyyy" id='datetimepicker13' >
                                        <input type='text' id="fecha_oficio_estudiante" name="fecha_oficio_estudiante" class="form-control" required />
                                        <span class="input-group-addon" >
                                        <span class="glyphicon glyphicon-calendar">
                                     </span>
                                    </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="nombre_proyecto">Número de oficio de notificacion del jurado (Estudiante)<b style="color:red; font-size:23px;">*</b></label>
                                    <input class="form-control"  id="numero_oficio_estudiante" name="numero_oficio_estudiante" type="text"   placeholder="Ingresa número de oficio de notificacion del jurado (Estudiante)"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>

                                </div>
                            </div>
                        </div>


                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_agregar_dat_estudiante" class="btn btn-primary">Guardar</button>

                </div>
            </div>
        </div>
    </div>

    {{--fin agregar fecha y nuemero de oficio  del oficio de notificacionjefe de division--}}

    {{--editar fecha y nuemero de oficio  del oficio de notificacion estudiantes--}}
    <div class="modal fade" id="modal_editar_dat_estudiante" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar datos del oficio de notificación del jurado (Estudiante) </h4>
                </div>
                <div class="modal-body">
                    <form id="form_editar_dat_estudiante" class="form" action="{{url("/titulacion/guardar_editar_datos_oficio_notificacion_estudiante/".$datos_alumno->id_fecha_jurado_alumn)}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="deparamento">Selecciona fecha del oficio de notificacion del jurado (Estudiante)</label>
                                    <div class='input-group date' style='font-size: 25px; size: 25px;' data-date-format="dd-mm-yyyy" id='datetimepicker14' >
                                        <input type='text' id="fecha_oficio_estudiantes" name="fecha_oficio_estudiantes"  value="{{ $datos_alumno->fecha_oficio_noti_jurado_estudiante}}" class="form-control" required />
                                        <span class="input-group-addon" >
                                        <span class="glyphicon glyphicon-calendar">
                                     </span>
                                    </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="nombre_proyecto">Número de oficio de notificacion del jurado (Estudiante)<b style="color:red; font-size:23px;">*</b></label>
                                    <input class="form-control"  id="numero_oficio_estudiantes" name="numero_oficio_estudiantes" type="text"   placeholder="Ingresa número de oficio de notificacion del jurado (Estudiante)"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{ $datos_alumno->oficio_noti_jurado_estudiante }}"  required/>

                                </div>
                            </div>
                        </div>


                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_editar_agregar_dat_estudiante" class="btn btn-primary">Guardar</button>

                </div>
            </div>
        </div>
    </div>

    {{--fin editar fecha y nuemero de oficio  del oficio de notificacion estudiantes--}}
    {{--autorizar fecha y nuemero de oficio  del oficio de notificacion estudiante --}}

    <div class="modal fade" id="modal_autorizar_oficio_estudiante" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Autorizar fecha y número de oficio de notificacion (estudiante)</h4>
                </div>
                <div class="modal-body">
                    <form id="form_autorizar_oficio_estudiante" class="form" action="{{url("/titulacion/autorizar_datos_oficio_notificacion_estudiante/".$datos_alumno->id_fecha_jurado_alumn)}}" role="form" method="POST" >
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <h3>¿Seguro que quieres autorizar fecha y número, ya no podras hacer ninguna modificación? </h3>
                            </div>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_autorizar_oficio_estudiante" class="btn btn-success">Aceptar</button>

                </div>
            </div>
        </div>
    </div>

    {{--autorizar fecha y nuemero de oficio  del oficio de notificacionjefe de estudiante--}}

    {{--agregar mencion honorifica--}}
    <div class="modal fade" id="modal_agregar_dat_honorifica" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Mención honorifica </h4>
                </div>
                <div class="modal-body">
                    <form id="form_agregar_dat_honorifica" class="form" action="{{url("/titulacion/guardar_datos_mencion_honorifica/".$datos_alumno->id_fecha_jurado_alumn)}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="deparamento">Selecciona fecha del oficio de la mención honorifica</label>
                                    <div class='input-group date' style='font-size: 25px; size: 25px;' data-date-format="dd-mm-yyyy" id='datetimepicker15' >
                                        <input type='text' id="fecha_honorifica" name="fecha_honorifica" class="form-control" required />
                                        <span class="input-group-addon" >
                                        <span class="glyphicon glyphicon-calendar">
                                     </span>
                                    </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="nombre_proyecto">Número del oficio de la mención honorifica<b style="color:red; font-size:23px;">*</b></label>
                                    <input class="form-control"  id="numero_honorifica" name="numero_honorifica" type="text"   placeholder="Ingresa número del oficio de la mención honorifica"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>

                                </div>
                            </div>
                        </div>


                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_agregar_dat_honorifica" class="btn btn-primary">Guardar</button>

                </div>
            </div>
        </div>
    </div>

    {{--fin agregar mencion honorifica--}}
    {{--editar fecha y nuemero de oficio honorifica--}}
    <div class="modal fade" id="modal_editar_dat_honorifica" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar datos del oficio de la mención honorifica </h4>
                </div>
                <div class="modal-body">
                    <form id="form_editar_dat_honorifica" class="form" action="{{url("/titulacion/guardar_editar_datos_oficio_mencion_honorifica/".$datos_alumno->id_fecha_jurado_alumn)}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="deparamento">Selecciona fecha del oficio de la mención honorifica</label>
                                    <div class='input-group date' style='font-size: 25px; size: 25px;' data-date-format="dd-mm-yyyy" id='datetimepicker16' >
                                        <input type='text' id="fecha_honorificas" name="fecha_honorificas"  value="{{ $datos_alumno->fecha_mencion_honorifica}}" class="form-control" required />
                                        <span class="input-group-addon" >
                                        <span class="glyphicon glyphicon-calendar">
                                     </span>
                                    </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="nombre_proyecto">Número de oficio de notificacion del jurado (Estudiante)<b style="color:red; font-size:23px;">*</b></label>
                                    <input class="form-control"  id="numero_honorificas" name="numero_honorificas" type="text"   placeholder="Ingresa número del oficio de la mención honorifica"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{ $datos_alumno->mencion_honorifica }}"  required/>

                                </div>
                            </div>
                        </div>


                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_editar_agregar_dat_honorifica" class="btn btn-primary">Guardar</button>

                </div>
            </div>
        </div>
    </div>

    {{--fin editar fecha y nuemero de oficio  honorifica--}}
    {{--autorizar fecha y nuemero de oficio  mencion honorifica --}}

    <div class="modal fade" id="modal_autorizar_oficio_honorifica" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Autorizar fecha y número del oficio de la mención honorifica</h4>
                </div>
                <div class="modal-body">
                    <form id="form_autorizar_oficio_honorifica" class="form" action="{{url("/titulacion/autorizar_oficio_mencion_honorifica/".$datos_alumno->id_fecha_jurado_alumn)}}" role="form" method="POST" >
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <h3>¿Seguro que quieres autorizar fecha y número, ya no podras hacer ninguna modificación? </h3>
                            </div>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_autorizar_oficio_honorifica" class="btn btn-success">Aceptar</button>

                </div>
            </div>
        </div>
    </div>

    {{--autorizar fecha y nuemero de oficio  mencion honorifica--}}
    {{--modificar presidente--}}

    <div class="modal fade" id="modal_modificar_presidente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar Presidente</h4>
                </div>
                <div class="modal-body">
                    <form id="form_modificar_presidente" class="form" action="{{url("/titulacion/guardar_modificacion_presidente/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div id="contenedor_modificar_presidente">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_modificar_presidente" class="btn btn-primary">Guardar</button>

                </div>
            </div>
        </div>
    </div>

    {{--fin de modificar presidente--}}

    {{--modificar secretario--}}

    <div class="modal fade" id="modal_modificar_secretario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar Secretario</h4>
                </div>
                <div class="modal-body">
                    <form id="form_modificar_secretario" class="form" action="{{url("/titulacion/guardar_modificacion_secretario/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div id="contenedor_modificar_secretario">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_modificar_secretario" class="btn btn-primary">Guardar</button>

                </div>
            </div>
        </div>
    </div>

    {{--fin de modificar secretario--}}

    {{--modificar vocal--}}

    <div class="modal fade" id="modal_modificar_vocal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar Vocal</h4>
                </div>
                <div class="modal-body">
                    <form id="form_modificar_vocal" class="form" action="{{url("/titulacion/guardar_modificacion_vocal/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div id="contenedor_modificar_vocal">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_modificar_vocal" class="btn btn-primary">Guardar</button>

                </div>
            </div>
        </div>
    </div>

    {{--fin de modificar vocal--}}

    {{--modificar suplente--}}

    <div class="modal fade" id="modal_modificar_suplente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar Suplente</h4>
                </div>
                <div class="modal-body">
                    <form id="form_modificar_suplente" class="form" action="{{url("/titulacion/guardar_modificacion_suplente/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div id="contenedor_modificar_suplente">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_modificar_suplente" class="btn btn-primary">Guardar</button>

                </div>
            </div>
        </div>
    </div>

    {{--fin de modificar suplente--}}
    <script type="text/javascript">
        $(document).ready(function (){
            $("#modificar_presidente").click(function(){

                $.get("/titulacion/modificar_presidente/{{ $id_alumno }}",function (request) {
                    $("#contenedor_modificar_presidente").html(request);
                    $("#modal_modificar_presidente").modal('show');
                });
            });

            $("#modificar_secretario").click(function (){
                $.get("/titulacion/modificar_secretario/{{ $id_alumno }}",function (request) {
                    $("#contenedor_modificar_secretario").html(request);
                    $("#modal_modificar_secretario").modal('show');
                });
            });
            $("#guardar_modificar_presidente").click(function (){
                var presidente=$("#presidente").val();
                if(presidente == null){
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona presidente",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }else{
                    $("#form_modificar_presidente").submit();
                    $("#guardar_modificar_presidente").attr("disabled", true);
                    swal({
                        type: "success",
                        title: "Modificación exitosa",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });

            $("#guardar_modificar_secretario").click(function (){
                var secretario=$("#secretario").val();
                if(secretario == null){
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona secretario",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }else{
                    $("#form_modificar_secretario").submit();
                    $("#guardar_modificar_secretario").attr("disabled", true);
                    swal({
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });

            $("#guardar_modificar_vocal").click(function (){
                var vocal=$("#vocal").val();
                if(vocal == null){
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona vocal",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }else{
                    $("#form_modificar_vocal").submit();
                    $("#guardar_modificar_vocal").attr("disabled", true);
                    swal({
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });


            $("#guardar_modificar_suplente").click(function (){
                var suplente=$("#suplente").val();
                if(suplente == null){
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona suplente",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }else{
                    $("#form_modificar_suplente").submit();
                    $("#guardar_modificar_suplente").attr("disabled", true);
                    swal({
                        type: "success",
                        title: "Modificación exitosa",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });

            $("#modificar_suplente").click(function (){

                $.get("/titulacion/modificar_suplente/{{ $id_alumno }}",function (request) {
                    $("#contenedor_modificar_suplente").html(request);
                    $("#modal_modificar_suplente").modal('show');
                });
            });
            $("#modificar_vocal").click(function (){
                $.get("/titulacion/modificar_vocal/{{ $id_alumno }}",function (request) {
                    $("#contenedor_modificar_vocal").html(request);
                    $("#modal_modificar_vocal").modal('show');
                });
            });
            $('#datetimepicker11').datepicker({
                daysOfWeekDisabled: [0,6],
                autoclose: true,
                language: 'es',
            });
            $('#datetimepicker12').datepicker({
                daysOfWeekDisabled: [0,6],
                autoclose: true,
                language: 'es',
            });
            $('#datetimepicker13').datepicker({
                daysOfWeekDisabled: [0,6],
                autoclose: true,
                language: 'es',
            });
            $('#datetimepicker14').datepicker({
                daysOfWeekDisabled: [0,6],
                autoclose: true,
                language: 'es',
            });
            $('#datetimepicker15').datepicker({
                daysOfWeekDisabled: [0,6],
                autoclose: true,
                language: 'es',
            });
            $('#datetimepicker16').datepicker({
                daysOfWeekDisabled: [0,6],
                autoclose: true,
                language: 'es',
            });
            $("#capturar_dat_jefe").click(function (){
                $("#modal_agregar_dat_jefe").modal('show');
            });
            $("#guardar_agregar_dat_jefe").click(function (){
                var fecha = $("#fecha_oficio_jefe").val();
                var numero_jefe = $("#numero_oficio_jefe").val();
               if(fecha != ''){
                  if(numero_jefe != ''){
                      $("#form_agregar_dat_jefe").submit();
                      $("#guardar_agregar_dat_jefe").attr("disabled",true);
                      swal({
                          type: "success",
                          title: "Registro exitoso",
                          showConfirmButton: false,
                          timer: 1500
                      });

                  } else{
                      swal({
                          position: "top",
                          type: "error",
                          title: "Ingresa número de oficio de notificacion del jurado (Jefe de visión)",
                          showConfirmButton: false,
                          timer: 3500
                      });
                  }

               }else{
                   swal({
                       position: "top",
                       type: "error",
                       title: "Selecciona fecha del oficio de notificacion del jurado (Jefe de visión)",
                       showConfirmButton: false,
                       timer: 3500
                   });
               }
            });
            $("#editar_dat_jefe").click(function (){
                $("#modal_editar_dat_jefe").modal('show');
            });
            $("#guardar_editar_agregar_dat_jefe").click(function (){
                var fecha = $("#fecha_oficio_jefes").val();

                var numero_jefe = $("#numero_oficio_jefes").val();
                if(fecha != ''){
                    if(numero_jefe != ''){
                        $("#form_editar_dat_jefe").submit();
                        $("#guardar_editar_agregar_dat_jefe").attr("disabled",true);
                        swal({
                            type: "success",
                            title: "Modificación exitosa",
                            showConfirmButton: false,
                            timer: 1500
                        });

                    } else{
                        swal({
                            position: "top",
                            type: "error",
                            title: "Ingresa número de oficio de notificacion del jurado (Jefe de visión)",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona fecha del oficio de notificacion del jurado (Jefe de visión)",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#autorizar_dat_jefe").click(function (){

                $("#modal_autorizar_oficio_jefe").modal('show');
            });
            $("#guardar_autorizar_oficio_jefe").click(function (){
                $("#form_autorizar_oficio_jefe").submit();
                $("#guardar_autorizar_oficio_jefe").attr("disabled",true);
                swal({
                    type: "success",
                    title: "Autorización exitosa",
                    showConfirmButton: false,
                    timer: 1500
                });

            });
            $("#capturar_dat_estudiante").click(function (){
                $("#modal_agregar_dat_estudiante").modal('show');
            });

            $("#guardar_agregar_dat_estudiante").click(function (){
                var fecha = $("#fecha_oficio_estudiante").val();
                var numero_estudiante = $("#numero_oficio_estudiante").val();
                if(fecha != ''){
                    if(numero_estudiante != ''){
                        $("#form_agregar_dat_estudiante").submit();
                        $("#guardar_agregar_dat_estudiante").attr("disabled",true);
                        swal({
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 1500
                        });

                    } else{
                        swal({
                            position: "top",
                            type: "error",
                            title: "Ingresa número de oficio de notificacion del jurado (Estudiante)",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona fecha del oficio de notificacion del jurado (Estudiante)",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }


            });
            $("#editar_dat_estudiante").click(function (){
                $("#modal_editar_dat_estudiante").modal('show');
            });
            $("#guardar_editar_agregar_dat_estudiante").click(function (){
                var fecha = $("#fecha_oficio_estudiantes").val();
                var numero_estudiantes = $("#numero_oficio_estudiantes").val();
                if(fecha != ''){
                    if(numero_estudiantes != ''){
                        $("#form_editar_dat_estudiante").submit();
                        $("#guardar_editar_agregar_dat_estudiante").attr("disabled",true);
                        swal({
                            type: "success",
                            title: "Modificación exitosa",
                            showConfirmButton: false,
                            timer: 1500
                        });

                    } else{
                        swal({
                            position: "top",
                            type: "error",
                            title: "Ingresa número de oficio de notificacion del jurado (Estudiante)",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona fecha del oficio de notificacion del jurado (Estudiante)",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#autorizar_dat_estudiante").click(function (){
                $("#modal_autorizar_oficio_estudiante").modal('show');
            });
            $("#guardar_autorizar_oficio_estudiante").click(function (){
                $("#form_autorizar_oficio_estudiante").submit();
                $("#guardar_autorizar_oficio_estudiante").attr("disabled",true);
                swal({
                    type: "success",
                    title: "Autorización exitosa",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
            $("#capturar_dat_honorifica").click(function (){
                $("#modal_agregar_dat_honorifica").modal('show');
            });
            $("#guardar_agregar_dat_honorifica").click(function (){
                var fecha = $("#fecha_honorifica").val();
                var numero_honorifica = $("#numero_honorifica").val();
                if(fecha != ''){
                    if(numero_honorifica != ''){
                        $("#form_agregar_dat_honorifica").submit();
                        $("#guardar_agregar_dat_honorifica").attr("disabled",true);
                        swal({
                            type: "success",
                            title: "Modificación exitosa",
                            showConfirmButton: false,
                            timer: 1500
                        });

                    } else{
                        swal({
                            position: "top",
                            type: "error",
                            title: "Ingresa número del oficio de la mención honorifica",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona fecha del oficio de la mención honorifica ",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#editar_dat_honorifica").click(function (){
                $("#modal_editar_dat_honorifica").modal('show');
            });
            $("#guardar_editar_agregar_dat_honorifica").click(function (){
                var fecha = $("#fecha_honorificas").val();
                var numero_honorifica = $("#numero_honorificas").val();
                if(fecha != ''){
                    if(numero_honorifica != ''){
                        $("#form_editar_dat_honorifica").submit();
                        $("#guardar_editar_agregar_dat_honorifica").attr("disabled",true);
                        swal({
                            type: "success",
                            title: "Modificación exitosa",
                            showConfirmButton: false,
                            timer: 1500
                        });

                    } else{
                        swal({
                            position: "top",
                            type: "error",
                            title: "Ingresa número del oficio de la mención honorifica",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona fecha del oficio de la mención honorifica ",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });

            $("#autorizar_dat_honorifica").click(function (){
                $("#modal_autorizar_oficio_honorifica").modal('show');
            });
            $("#guardar_autorizar_oficio_honorifica").click(function (){
                $("#form_autorizar_oficio_honorifica").submit();
                $("#guardar_autorizar_oficio_honorifica").attr("disabled",true);
                swal({
                    type: "success",
                    title: "Autorización exitosa",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        });

    </script>
@endsection
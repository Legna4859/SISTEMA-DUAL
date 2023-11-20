@extends('layouts.app')
@section('title', 'Titulación')
@section('content')

    <main class="col-md-12">


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h1 class="panel-title text-center">Enviar registro de jurado y fecha de titulación</h1>
                    </div>
                </div>
            </div>
        </div>

        @if($estado == 0)

            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <form id="form_guardar_fecha" class="form" action="{{url("/titulacion/registrar_fecha_jurado/".$id_alumno)}}" role="form" method="POST" >
                                {{ csrf_field() }}
                            <div class="form-group">
                                <h2 for="deparamento">Selecciona fecha Titulación</h2>
                                <div class='input-group date' style='font-size: 25px; size: 25px;' data-date-format="dd-mm-yyyy" id='datetimepicker11' >
                                    <input type='text' id="fecha_titulacion" name="fecha_titulacion" class="form-control" required />
                                    <span class="input-group-addon" >
                                        <span class="glyphicon glyphicon-calendar">
                                     </span>
                                    </span>
                                </div>

                            </div>
                                <div class="form-group">
                                    <div class="dropdown">
                                        <h2 for="hora">Selecciona sala de titulación</h2>
                                        <select name="sala_titulacion" id="sala_titulacion" class="form-control " >
                                            <option  disabled selected hidden>Sala de titulación</option>
                                            @foreach($salas as $sala)
                                                <option disabled selected hidden>Selecciona una opción</option>
                                                <option value="{{$sala->id_sala}}" >{{$sala->nombre_sala}}</option>
                                            @endforeach
                                        </select>
                                        <br>
                                    </div>
                                </div>



            </form>

                            <p style="text-align: center">  <button id="consultar_horario_titulacion" class="btn btn-primary">Consultar hora disponible</button></p>


                        </div>
                    </div>
                </div>

            </div>


        @endif
        @if($estado == 1)
            @if($registro_fecha->id_estado_enviado == 0 || $registro_fecha->id_estado_enviado == 2)
                    @if($registro_fecha->id_estado_enviado == 2)
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                   <h3>Correcciones:</h3>
                                    <h2>{{ $registro_fecha->comentario }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <h2 for="deparamento">Fecha Titulación: {{ $registro_fecha->fecha_titulacion }}</h2>
                                <h2 for="deparamento">Horario de titulación: {{ $registro_fecha->horario_dia }}</h2>
                                <p style="text-align: center">  <button id="eliminar_fecha" class="btn btn-danger">Eliminar Fecha</button></p>
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
                                        @if($presidente == 0)
                                            <td></td>
                                            <td><button id="agregar_presidente" class="btn btn-primary">Agregar presidente</button></td>
                                        @else
                                            <td>{{ $dato_presidente->nombre }}</td>
                                            <td></td>
                                            @endif

                                    </tr>
                                    <tr>
                                        <td>Secretario</td>
                                        @if($secretario == 0)
                                            <td></td>
                                            <td><button id="agregar_secretario" class="btn btn-primary">Agregar secretario</button></td>
                                        @else
                                            <td>{{ $dato_secretario->nombre }}</td>
                                            <td></td>

                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Vocal</td>
                                        @if($vocal == 0)
                                            <td></td>
                                            <td><button id="agregar_vocal" class="btn btn-primary">Agregar vocal</button></td>
                                        @else
                                            <td>{{ $dato_vocal->nombre }}</td>
                                            <td><button id="modificar_vocal" class="btn btn-primary">Modificar vocal</button></td>

                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Suplente</td>
                                        @if($suplente == 0)
                                            <td></td>
                                            <td><button id="agregar_suplente" class="btn btn-primary">Agregar suplente</button></td>
                                        @else
                                            <td>{{ $dato_suplente->nombre }}</td>
                                            <td><button id="modificar_suplente" class="btn btn-primary">Modificar suplente</button></td>

                                        @endif
                                    </tr>
                                    </tbody>
                                </table>
                                @if($presidente == 1 && $secretario == 1 && $vocal == 1 && $suplente == 1 && $registro_fecha->id_estado_enviado == 0 )
                                <p style ="text-align: center;"><button id="enviar_jurado" class="btn btn-success">Enviar jurado</button></p>
                                    @elseif($presidente == 1 && $secretario == 1 && $vocal == 1 && $suplente == 1 && $registro_fecha->id_estado_enviado == 2 )
                                        <p style ="text-align: center;"><button id="enviar_jurado_modificaciones" class="btn btn-success">Enviar jurado con las modificaciones</button></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @elseif($registro_fecha->id_estado_enviado == 1)
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Se envio correctamente tu jurado para su revisión   por el Departamento de Titulación</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($registro_fecha->id_estado_enviado == 3)
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Se envio correctamente la modificación de tu jurado para su revisión   por el Departamento de Titulación</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($registro_fecha->id_estado_enviado == 4)
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Tu jurado fue autorizado  por el Departamento de Titulación</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Fecha de titulación: {{ $registro_fecha->fecha_titulacion }}</h3>
                                <h3 class="panel-title text-center">Hora de titulación: {{ $registro_fecha->horario_dia }}</h3>
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
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Presidente </td>
                                            <td>{{ $dato_presidente->nombre }}</td>

                                    </tr>
                                    <tr>
                                        <td>Secretario</td>
                                        <td>{{ $dato_secretario->nombre }}</td>

                                    </tr>
                                    <tr>
                                        <td>Vocal</td>
                                        <td>{{ $dato_vocal->nombre }}</td>

                                    </tr>
                                    <tr>
                                        <td>Suplente</td>
                                        <td>{{ $dato_suplente->nombre }}</td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                @endif

        @endif



    </main>
    <form id="form_editar_fecha" class="form" action="{{url("/titulacion/editar_fecha_jurado/")}}" role="form" method="POST" >
        {{ csrf_field() }}
    <div class="modal fade" id="modal_modificar_fecha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar fecha de titulación</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_modificar_fecha">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                     <button id="guardar_modificacion_fecha" class="btn btn-primary">Guardar modificación</button>

                </div>
            </div>
        </div>
    </div>
    </form>

        {{--agregar presidente--}}

        <div class="modal fade" id="modal_agregar_presidente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Agregar Presidente</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_agregar_presidente" class="form" action="{{url("/titulacion/guardar_presidente/")}}" role="form" method="POST" >
                            {{ csrf_field() }}
                        <div id="contenedor_agregar_presidente">
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button id="guardar_agregar_presidente" class="btn btn-primary">Guardar</button>

                    </div>
                </div>
            </div>
        </div>

    {{--fin de agregar presidente--}}
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

    {{--agregar secretario--}}
        <div class="modal fade" id="modal_agregar_secretario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Agregar secretario</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_agregar_secretario" class="form" action="{{url("/titulacion/guardar_secretario/")}}" role="form" method="POST" >
                            {{ csrf_field() }}
                        <div id="contenedor_agregar_secretario">
                        </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button id="guardar_agregar_secretario" class="btn btn-primary">Guardar</button>

                    </div>
                </div>
            </div>
        </div>

    {{--fin de agregar secretario--}}
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

    {{--agregar vocal--}}

        <div class="modal fade" id="modal_agregar_vocal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Agregar vocal</h4>
                    </div>
                    <form id="form_agregar_vocal" class="form" action="{{url("/titulacion/guardar_vocal/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                    <div class="modal-body">
                        <div id="contenedor_agregar_vocal">
                        </div>
                    </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button id="guardar_agregar_vocal" class="btn btn-primary">Guardar</button>

                    </div>
                </div>
            </div>
        </div>

    {{--fin de agregar vocal--}}
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
    {{--agregar suplente--}}

        <div class="modal fade" id="modal_agregar_suplente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Agregar suplente</h4>
                    </div>
                    <form id="form_agregar_suplente" class="form" action="{{url("/titulacion/guardar_suplente/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                    <div class="modal-body">
                        <div id="contenedor_agregar_suplente">
                        </div>
                    </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button id="guardar_agregar_suplente" class="btn btn-primary">Guardar</button>

                    </div>
                </div>
            </div>
        </div>

    {{--fin de agregar suplente--}}
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
    {{--enviar --}}

    <div class="modal fade" id="modal_enviar_jurado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Enviar jurado</h4>
                </div>
                <div class="modal-body">
                    <form id="form_enviar_jurado" class="form" action="{{url("/titulacion/enviar_jurado/".$id_alumno)}}" role="form" method="POST" >
                        {{ csrf_field() }}

                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <h3>Seguro que quieres enviar tu jurado de titulación al Departamento de Titulación para su autorización </h3>
                                </div>
                            </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_enviar_jurado" class="btn btn-success">Enviar</button>

                </div>
            </div>
        </div>
    </div>

    {{--enviar--}}
    {{--enviar jurado con modificaciones --}}

    <div class="modal fade" id="modal_enviar_jurado_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Enviar jurado</h4>
                </div>
                <div class="modal-body">
                    <form id="form_enviar_jurado_mod" class="form" action="{{url("/titulacion/enviar_jurado_mod/".$id_alumno)}}" role="form" method="POST" >
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <h3>Seguro que quieres enviar tu jurado de titulación con las modificaciones al Departamento de Titulación para su autorización </h3>
                            </div>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_enviar_jurado_mod" class="btn btn-success">Enviar</button>

                </div>
            </div>
        </div>
    </div>

    {{--enviar--}}
    {{--eliminar la fecha de titulación --}}

    <div class="modal fade" id="modal_eliminar_fecha_jurado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Eliminar la fecha de titulación</h4>
                </div>
                <form id="form_eliminar_fecha_jurado" class="form" action="{{url("/titulacion/eliminar_fecha_titulacion/".$id_alumno)}}" role="form" method="POST" >
                    {{ csrf_field() }}
                <div class="modal-body">


                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <h3>Seguro que quiere eliminar la fecha de titulación </h3>
                            </div>
                        </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Aceptar</button>

                </div>
                </form>
            </div>
        </div>
    </div>

    {{--fin de eliminar fecha de titulación--}}

    <script type="text/javascript">
        $(document).ready( function() {
            $('#datetimepicker11').datepicker({
                daysOfWeekDisabled: [0,6],
                autoclose: true,
                language: 'es',
                startDate: '+7d',
            });
            $("#fecha_titulacion").change(function(e){
                var fecha_titulacion= e.target.value;

                $.get('/titulacion/fecha_titulacion_alumnos/'+ fecha_titulacion,function(data){


                    $('#municipio3').empty();

                    $.each(data,function(datos_alumno,subcatObj){
                        //  alert(subcatObj);
                        $('#municipio3').append('<option value="'+subcatObj.id_municipio+'" data-muni="'+subcatObj.nombre_municipio+'" >'+subcatObj.nombre_municipio+'</option>');

                    });
                });

            });
            $("#consultar_horario_titulacion").click(function () {
                var fecha_titulacion=$("#fecha_titulacion").val();
                var sala_titulacion=$("#sala_titulacion").val();

                if(fecha_titulacion !='') {
                    if (sala_titulacion == null) {
                        swal({
                            position: "top",
                            type: "error",
                            title: "Selecciona sala de  Titulación",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    } else {
                        window.location.href = '/titulacion/fecha_titulacion_alumnos/' + fecha_titulacion + '/' + sala_titulacion;

                    }
                }
                 else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona fecha Titulación",
                        showConfirmButton: false,
                        timer: 3500
                    });
               }
            });
            $("#guardar_modificacion_fecha").click(function (event) {
                var fecha_titulacion=$("#fecha_titulacion").val();
                var horario=$("#horario").val();

                if(fecha_titulacion !=''){
                    if(horario == null ){
                        swal({
                            position: "top",
                            type: "error",
                            title: "Selecciona hora Titulación",
                            showConfirmButton: false,
                        });
                    }else{
                        $("#form_editar_fecha").submit();
                        $("#guardar_modificacion_fecha").attr("disabled", true);
                        swal({
                            type: "success",
                            title: "Modificación exitosa",
                            showConfirmButton: false,
                            timer: 1500
                        });

                    }
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona fecha Titulación",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#editar_fecha").click(function(){
                $.get("/titulacion/modificar_fecha_titulacion/{{ $id_alumno }}",function (request) {
                    $("#contenedor_modificar_fecha").html(request);
                    $("#modal_modificar_fecha").modal('show');
                });
            });
            $("#eliminar_fecha").click(function (){
                $("#modal_eliminar_fecha_jurado").modal('show');
            });
            $("#agregar_presidente").click(function(){
                $.get("/titulacion/agregar_presidente/{{ $id_alumno }}",function (request) {
                    $("#contenedor_agregar_presidente").html(request);
                    $("#modal_agregar_presidente").modal('show');
                });
            });
            $("#modificar_presidente").click(function(){

                $.get("/titulacion/modificar_presidente/{{ $id_alumno }}",function (request) {
                    $("#contenedor_modificar_presidente").html(request);
                    $("#modal_modificar_presidente").modal('show');
                });
            });
            $("#agregar_secretario").click(function(){
                $.get("/titulacion/agregar_secretario/{{ $id_alumno }}",function (request) {
                    $("#contenedor_agregar_secretario").html(request);
                    $("#modal_agregar_secretario").modal('show');
                });
            });
            $("#modificar_secretario").click(function (){
                $.get("/titulacion/modificar_secretario/{{ $id_alumno }}",function (request) {
                    $("#contenedor_modificar_secretario").html(request);
                    $("#modal_modificar_secretario").modal('show');
                });
            });
            $("#guardar_agregar_presidente").click(function (){
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
                    $("#form_agregar_presidente").submit();
                    $("#guardar_agregar_presidente").attr("disabled", true);
                    swal({
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
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
            $("#guardar_agregar_secretario").click(function (){
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
                    $("#form_agregar_secretario").submit();
                    $("#guardar_agregar_secretario").attr("disabled", true);
                    swal({
                        type: "success",
                        title: "Registro exitoso",
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
            $("#guardar_agregar_vocal").click(function (){
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
                    $("#form_agregar_vocal").submit();
                    $("#guardar_agregar_vocal").attr("disabled", true);
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

            $("#guardar_agregar_suplente").click(function (){
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
                    $("#form_agregar_suplente").submit();
                    $("#guardar_agregar_suplente").attr("disabled", true);
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
            $("#agregar_vocal").click(function(){
                $.get("/titulacion/agregar_vocal/{{ $id_alumno }}",function (request) {
                    $("#contenedor_agregar_vocal").html(request);
                    $("#modal_agregar_vocal").modal('show');
                });
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
            $("#agregar_suplente").click(function(){
                $.get("/titulacion/agregar_suplente/{{ $id_alumno }}",function (request) {
                    $("#contenedor_agregar_suplente").html(request);
                    $("#modal_agregar_suplente").modal('show');
                });
            });
            $("#enviar_jurado").click(function (){


                    $("#modal_enviar_jurado").modal('show');
            });
            $("#enviar_jurado_modificaciones").click(function (){
                $("#modal_enviar_jurado_mod").modal('show');
            });
            $("#guardar_enviar_jurado").click(function (){
                $("#form_enviar_jurado").submit();
                $("#guardar_enviar_jurado").attr("disabled", true);
                swal({
                    type: "success",
                    title: "Envio exitoso",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
            $("#guardar_enviar_jurado_mod").click(function (){
                $("#form_enviar_jurado_mod").submit();
                $("#guardar_enviar_jurado_mod").attr("disabled", true);
                swal({
                    type: "success",
                    title: "Envio exitoso",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        });

    </script>

    <style>
        .mostrar{
            display: list-item;
            opacity: 1;
            background: rgba(44,38,75,0.849);
        }
    </style>

@endsection
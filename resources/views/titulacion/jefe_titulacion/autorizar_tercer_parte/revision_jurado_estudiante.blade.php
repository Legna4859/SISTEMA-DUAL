@extends('layouts.app')
@section('title', 'Titulación')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <p>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                    <a href="{{url("/titulacion/autorizar_jurado_estudiantes")}}">Autorización de  jurado de titulación</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span>Revision de jurado de Titulación del Estudiante</span>
                </p>
                <br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h1 class="panel-title text-center">Revision de jurado de Titulación del Estudiante</h1>
                    </div>
                </div>
            </div>
        </div>
       @if($datos_alumno->mencion_honorifica == 1)
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
                        <h4 for="deparamento">Número de cuenta: {{ $datos_alumno->no_cuenta}}  </h4>
                        <h4 for="deparamento"> Nombre del estudiante: {{ $datos_alumno->nombre_al }} {{ $datos_alumno->apaterno }} {{ $datos_alumno->amaterno }}</h4>
                        <h4 for="deparamento"> Carrera: {{ $datos_alumno->carrera}}</h4>
                        <h4 for="deparamento"> Telefono: {{ $datos_alumno->telefono}}</h4>
                        <h4 for="deparamento"> Correo electronico: {{ $datos_alumno->correo_electronico}}</h4>

                    </div>
                </div>
            </div>
        </div>

                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <p style="text-align: center">  <button id="consultar_dia_titulacion" class="btn btn-info">Consultar titulaciones del dia {{ $datos_alumno->fecha_titulacion }} </button></p>
                                <h2 for="deparamento">Fecha Titulación: {{ $datos_alumno->fecha_titulacion }}</h2>
                                <h2 for="deparamento">Horario de titulación: {{ $hora->horario_dia }}</h2>
                                <h2 for="deparamento">Nombre de sala: {{ $datos_alumno->nombre_sala }}</h2>
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
                                        <th>Cedula</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Presidente </td>
                                            <td>{{ $dato_presidente->titulo }} {{ $dato_presidente->nombre }}</td>
                                            <td>{{ $dato_presidente->cedula }}</td>
                                            <td><button id="modificar_presidente" class="btn btn-primary">Modificar presidente</button></td>
                                    </tr>
                                    <tr>
                                        <td>Secretario</td>

                                            <td>{{ $dato_secretario->titulo }} {{ $dato_secretario->nombre }}</td>
                                            <td>{{ $dato_secretario->cedula }}</td>
                                            <td><button id="modificar_secretario" class="btn btn-primary">Modificar secretario</button></td>
                                    </tr>
                                    <tr>
                                        <td>Vocal</td>
                                            <td>{{ $dato_vocal->titulo }} {{ $dato_vocal->nombre }} <br> </td>
                                            <td>{{ $dato_vocal->cedula }}</td>
                                            <td><button id="modificar_vocal" class="btn btn-primary">Modificar vocal</button></td>


                                    </tr>
                                    <tr>
                                        <td>Suplente</td>
                                            <td>{{ $dato_suplente->titulo }} {{ $dato_suplente->nombre }}</td>
                                             <td>{{ $dato_suplente->cedula }}</td>
                                            <td><button id="modificar_suplente" class="btn btn-primary">Modificar suplente</button></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-2 col-md-offset-4">
                    <button id="enviar_modificaciones" class="btn btn-warning">Enviar modificaciones</button>
                </div>
                <div class="col-md-2">
                    <button id="enviar_autorizacion" class="btn btn-success">Autorizar jurado del estudiante</button>
                </div>
                <p><br></p>
            </div>
        <div class="row">
            <p></p>

        </div>





    </main>

        <div class="modal fade" id="modal_modificar_fecha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar fecha de titulación</h4>
                    </div>
                    <form id="form_editar_fecha" class="form" action="{{url("/titulacion/editar_fecha_jurado/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                    <div class="modal-body">
                        <div id="contenedor_modificar_fecha">
                        </div>
                    </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button id="guardar_modificacion_fecha" class="btn btn-primary">Guardar modificación</button>

                    </div>
                </div>
            </div>
        </div>



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

    {{--consultar titulacion --}}

    <div class="modal fullscreen-modal fade" id="modal_dia_titulacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h2 class="modal-title" id="myModalLabel" style="text-align: center">Consultar titulaciones del dia {{ $datos_alumno->fecha_titulacion }}</h2>
                    <h3 style="text-align: center">Nombre de la sala: {{ $datos_alumno->nombre_sala }}</h3>
                </div>
                <div class="modal-body">
                    <div id="contenedor_dia_titulacion">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    {{--consultar titulacion--}}
    {{--enviar modificaciones titulacion --}}

    <div class="modal fade" id="modal_enviar_modificaciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Enviar modificacion de jurado de titulación</h4>
                </div>
                <div class="modal-body">
                    <form id="form_enviar_modificaciones" class="form" action="{{url("/titulacion/guardar_modificaciones_jurado/".$id_alumno)}}" role="form" method="POST" >
                        {{ csrf_field() }}

                        <div id="contenedor_enviar_modificaciones">

                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_enviar_modificaciones" class="btn btn-success">Enviar</button>

                </div>
            </div>
        </div>
    </div>

    {{--enviar modificaciones titulacion--}}
    {{--enviar autorizacion titulacion --}}

    <div class="modal fade" id="modal_enviar_autorizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Enviar autorización de jurado de titulación</h4>
                </div>
                <div class="modal-body">
                    <form id="form_enviar_autorizacion" class="form" action="{{url("/titulacion/guardar_autorizacion_jurado/".$id_alumno)}}" role="form" method="POST" >
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <h4>¿ Seguro que quieres autorizar el jurado del estudiante ?</h4>
                            </div>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_enviar_autorizacion" class="btn btn-success">Enviar</button>

                </div>
            </div>
        </div>
    </div>

    {{--enviar autorizacion titulacion--}}

    <script type="text/javascript">
        $(document).ready( function() {
            $('#datetimepicker11').datepicker({
                daysOfWeekDisabled: [0,6],
                autoclose: true,
                language: 'es',
                startDate: '+0d',
            });
            $("#enviar_modificaciones").click(function (){
                $.get("/titulacion/enviar_modificaciones_jurado/{{ $id_alumno }}",function (request) {
                    $("#contenedor_enviar_modificaciones").html(request);
                    $("#modal_enviar_modificaciones").modal('show');
                });
            });
            $("#guardar_enviar_modificaciones").click(function (){
                var comentario_modificacion=$("#comentario_modificacion").val();
                if(comentario_modificacion == ''){
                    swal({
                        position: "top",
                        type: "error",
                        title: "Ingrese las modificaciones",
                        showConfirmButton: false,
                    });
                }else{
                    $("#form_enviar_modificaciones").submit();
                    $("#guardar_enviar_modificaciones").attr("disabled", true);
                    swal({
                        type: "success",
                        title: "Envio de modificaciones exitosas",
                        showConfirmButton: false,
                        timer: 1500
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

            $("#enviar_jurado").click(function (){


                $("#modal_enviar_jurado").modal('show');
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
            $("#enviar_autorizacion").click(function (){
                $("#modal_enviar_autorizacion").modal('show');
            });
            $("#guardar_enviar_autorizacion").click(function (){
                $("#form_enviar_autorizacion").submit();
                $("#guardar_enviar_autorizacion").attr("disabled", true);
                swal({
                    type: "success",
                    title: "Envio exitoso de la autorización",
                    showConfirmButton: false,
                    timer: 1500
                });
            });

            $("#consultar_dia_titulacion").click(function (){
                $.get("/titulacion/dia_titulacion/{{ $datos_alumno->fecha_titulacion }}/{{ $id_alumno }}/{{ $datos_alumno->id_sala }}",function (request) {
                    $("#contenedor_dia_titulacion").html(request);
                    $("#modal_dia_titulacion").modal('show');
                });
            });
        });

    </script>

    <style>
        /*
Full screen Modal
*/
        .fullscreen-modal .modal-dialog {
            margin: 0;
            margin-right: auto;
            margin-left: auto;
            width: 100%;
        }
        @media (min-width: 768px) {
            .fullscreen-modal .modal-dialog {
                width: 750px;
            }
        }
        @media (min-width: 992px) {
            .fullscreen-modal .modal-dialog {
                width: 970px;
            }
        }
        @media (min-width: 1200px) {
            .fullscreen-modal .modal-dialog {
                width: 1170px;
            }
        }
    </style>

@endsection
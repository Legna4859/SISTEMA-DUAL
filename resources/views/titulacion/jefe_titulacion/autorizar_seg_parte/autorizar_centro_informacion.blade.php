@extends('layouts.app')
@section('title', 'Titulacion')
@section('content')

    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Autorizar entrega de PDF </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Estudiantes para autorizar </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="tabla_alumnos" class="table table-bordered " Style="background: white;" >
                        <thead>
                        <tr>
                            <th>NO. CUENTA</th>
                            <th>NOMBRE DEL ALUMNO</th>
                            <th>OPCIÓN DE TITULACIÓN</th>
                            <th>REGISTRAR DATOS </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($alumnos as $alumno)
                            <tr>
                                <td>{{$alumno->no_cuenta }} </td>
                                <td>{{$alumno->nombre_al }} {{ $alumno->apaterno }}  {{ $alumno->amaterno }}</td>
                                <td>{{$alumno->opcion_titulacion }} </td>
                                <td><button type="button" class="btn btn-success autorizar_alumno" data-id="{{ $alumno->id_reg_dato_alum }}">Registrar</button></td>
                            </tr>
                        @endforeach



                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Estudiantes enviar autorizacion </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="tabla_titulacion" class="table table-bordered " Style="background: white;" >
                        <thead>
                        <tr>
                            <th>NO. CUENTA</th>
                            <th>NOMBRE DEL ALUMNO</th>
                            <th>OPCIÓN DE TITULACIÓN</th>
                            <th>ASESOR INTERNO</th>
                            <th>REVISOR INTERNO</th>
                            <th>VER PDF</th>
                            <th>EDITAR DATOS</th>
                            <th>AUTORIZAR</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reg_titulacion as $titulacion)
                            <tr>
                                <td>{{$titulacion['no_cuenta'] }} </td>
                                <td>{{$titulacion['nombre']}}</td>
                                <td>{{$titulacion['opcion_titulacion']}}</td>
                                <td>{{$titulacion['presidente']}}</td>
                                <td>{{$titulacion['secretario']}}</td>
                                @if($titulacion['estado_archivo'] == 1)
                                <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/'.$titulacion['pdf_reporte_titulacion'])}}')">Ver Documento </button></td>
                                @else
                                    <td>No nesecita PDF</td>
                                @endif
                                    @if($titulacion['id_enviado_biblioteca']  == 0)
                                    <td><button type="button" class="btn btn-warning editar_reporte" data-id="{{ $titulacion['id_alumno'] }}">Editar</button></td>
                                @else
                                    <td></td>
                                    <td></td>
                                @endif
                                @if($titulacion['id_enviado_biblioteca']  == 0)
                                    <td><button type="button" class="btn btn-primary enviar_reporte" data-id="{{ $titulacion['id_alumno'] }}">Autorizar</button></td>
                                @else
                                    <td> Autorizado correctamente</td>
                                @endif
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--Modal de agregar--}}
    <div class="modal fade" id="modal_agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Registrar estudiante</h4>
                </div>
                <form id="form_autorizacion" class="form" action="{{url("/titulacion/autorizar_estudiante/")}}" role="form" method="POST" enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div id="contenedor_agregar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button  id="guardar_autorizacion" type="button" style="" class="btn btn-primary"  >Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--Modal de modificar--}}
    <div class="modal fade" id="modal_modificar_reporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Editar estudiante</h4>
                </div>
                <form id="form_modificacion_reporte" class="form" action="{{url("/titulacion/modificar_datos_estudiante/")}}" role="form" method="POST" enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div id="contenedor_modificar_reporte">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button  id="guardar_modificacion_reporte" type="button" style="" class="btn btn-primary"  >Guardar modificación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--Modal enviar--}}
    <div class="modal fade" id="modal_enviar_reporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Autorizar los datos del estudiante registrados</h4>
                </div>
                <form id="form_enviar_reporte" class="form" action="{{url("/titulacion/guardar_enviar_datos_estudiante_informacion/")}}" role="form" method="POST" enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div id="contenedor_enviar_reporte">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button  id="aceptar_envio_reporte" type="button" style="" class="btn btn-primary"  >Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tabla_alumnos').DataTable();
            $('#tabla_titulacion').DataTable();
        } );
        $("#tabla_alumnos").on('click','.autorizar_alumno',function(){
            var id_reg_dato_alum=$(this).data('id');

            $.get("/titulacion/mostrar_datos_alumno_informacion/"+id_reg_dato_alum,function (request) {
                $("#contenedor_agregar").html(request);
                $("#modal_agregar").modal('show');
            });
        });
        $("#guardar_autorizacion").click(function(event) {

            var presidente = $("#presidente").val();
            var secretario = $("#secretario").val();
            var estado_archivo = $("#estado_archivo").val();
            if(presidente != null){
                if(secretario != null){
                   /* if(id_opcion_titulacion == 7){
                        $("#form_autorizacion").submit();
                        $("#guardar_autorizacion").attr("disabled", true);
                        swal({
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }else{*/
                    if(estado_archivo == 1){
                        var file = $("#file").val();
                        if(file == ''){
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona el PDF del documento",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }else{

                            $("#form_autorizacion").submit();
                            $("#guardar_autorizacion").attr("disabled", true);
                            swal({
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }else{

                        $("#form_autorizacion").submit();
                        $("#guardar_autorizacion").attr("disabled", true);
                        swal({
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona revisor interno",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }else{
                swal({
                    position: "top",
                    type: "error",
                    title: "Selecciona asesor interno",
                    showConfirmButton: false,
                    timer: 1500
                });
            }





        });
        $("#tabla_titulacion").on('click','.editar_reporte',function(){
            var id_alumno = $(this).data('id');
            $.get("/titulacion/editar_reporte_titulacion/"+id_alumno,function (request) {
                $("#contenedor_modificar_reporte").html(request);
                $("#modal_modificar_reporte").modal('show');
            });

        });
        $("#tabla_titulacion").on('click','.enviar_reporte',function(){
            var id_alumno = $(this).data('id');
            $.get("/titulacion/enviar_reporte_titulacion/"+id_alumno,function (request) {
                $("#contenedor_enviar_reporte").html(request);
                $("#modal_enviar_reporte").modal('show');
            });

        });

        $("#guardar_modificacion_reporte").click(function(event) {

            var presidente = $("#presidente").val();
            var secretario = $("#secretario").val();
            var id_opcion_titulacion = $("#id_opcion_titulacion").val();
            var estado_archivo = $("#estado_archivo").val();
            if(presidente != null){
                if(secretario != null){
                    if(estado_archivo == 0){
                        $("#form_modificacion_reporte").submit();
                        $("#guardar_modificacion_reporte").attr("disabled", true);
                        swal({
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }else{
                        var file = $("#file").val();
                        if(file == ''){
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona el PDF del documento",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }else{

                            $("#form_modificacion_reporte").submit();
                            $("#guardar_modificacion_reporte").attr("disabled", true);
                            swal({
                                type: "success",
                                title: "Modificación exitosa",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona revisor interno",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }else{
                swal({
                    position: "top",
                    type: "error",
                    title: "Selecciona asesor interno",
                    showConfirmButton: false,
                    timer: 1500
                });
            }


        });
        $("#aceptar_envio_reporte").click(function(event) {
            $("#form_enviar_reporte").submit();
            $("#aceptar_envio_reporte").attr("disabled", true);
            swal({
                type: "success",
                title: "Aceptación exitosa",
                showConfirmButton: false,
                timer: 1500
            });


        });

    </script>

@endsection
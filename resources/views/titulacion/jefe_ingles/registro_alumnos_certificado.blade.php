@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Certificado de Acreditación')
@section('content')

    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">CARRERA: {{$carrera->nombre}}  </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/titulacion/ingles_carreras")}}">Programas de Estudios</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Estudiantes </span>

            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-1">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Estudiantes de la carrera  </h3>
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
                            <th>AGREGAR</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($alumnos as $alumno)
                            <tr>
                                <td>{{$alumno->cuenta }} </td>
                                <td>{{$alumno->nombre }} {{ $alumno->apaterno }}  {{ $alumno->amaterno }}</td>
                                <td><button type="button" class="btn btn-success registrar_certificado" data-id="{{ $alumno->id_alumno }}">Agregar certificado</button></td>
                            </tr>
                        @endforeach



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Estudiantes con Certificado de Acreditación del Idioma Ingles</h3>
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
                            <th>FECHA DE REGISTRO</th>
                            <th>VER</th>
                            <th>EDITAR</th>
                            <th>ELIMINAR</th>
                            <th>ENVIAR</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($registro_certificado as $registro)
                            <tr>
                                <td>{{$registro->cuenta }} </td>
                                <td>{{$registro->nombre }} {{ $registro->apaterno }}  {{ $registro->amaterno }}</td>
                                <td>{{ $registro->fecha_registro}}</td>
                                <td><a  target="_blank" href="{{asset('/certificado_ingles/'.$registro->pdf_certificado)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>
                                @if($registro->enviado == 0)
                                <td><button type="button" class="btn btn-warning editar_certificado" data-id="{{ $registro->id_certificado_acreditacion }}">Editar</button></td>
                                <td><button type="button" class="btn btn-danger eliminar_certificado" data-id="{{ $registro->id_certificado_acreditacion }}">Eliminar</button></td>
                                @else
                                    <td></td>
                                    <td></td>
                                    @endif
                                @if($registro->enviado == 0)
                                <td><button type="button" class="btn btn-primary enviar_certificado" data-id="{{ $registro->id_certificado_acreditacion }}">Enviar</button></td>
                                @else
                                   <td> Se envio correctamente</td>
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
                    <h4 class="modal-title text-center" id="myModalLabel">Agregar Certificado</h4>
                </div>
                <form id="form_agregar_certificado" class="form" action="{{url("/titulacion/guardar_certificado_alumno/")}}" role="form" method="POST" enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div id="contenedor_agregar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button  id="guardar_certificado" type="button" style="" class="btn btn-primary"  >Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--Modal de editar--}}
    <div class="modal fade" id="modal_editar_certificado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Editar Datos del Alumno</h4>
                </div>
                <form id="form_modificar_certificado" class="form" action="{{url("/titulacion/modificar_edicion_datos_alumno/")}}" role="form" method="POST" enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div id="contenedor_editar_certificado">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button  id="guardar_editar_certificado" type="button" style="" class="btn btn-primary"  >Modificar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--Modal de eliminar--}}
    <div class="modal fade" id="modal_eliminar_certificado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Eliminar Registro</h4>
                </div>
                <form id="form_eliminar_certificado" class="form" action="{{url("/titulacion/eliminacion_certificado/")}}" role="form" method="POST" enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div id="contenedor_eliminar_certificado">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button  id="guardar_eliminar_certificado" type="button" style="" class="btn btn-primary"  >Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--Modal de enviar--}}
    <div class="modal fade" id="modal_enviar_certificado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Enviar Certificado de Acreditación de Idioma Ingles</h4>
                </div>
                <form id="form_enviar_certificado" class="form" action="{{url("/titulacion/aceptar_envio_certificado/")}}" role="form" method="POST" enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div id="contenedor_enviar_certificado">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button  id="guardar_enviar_certificado" type="button" style="" class="btn btn-primary"  >Aceptar</button>
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
        $("#tabla_alumnos").on('click','.registrar_certificado',function(){
            var id_alumno=$(this).data('id');
            $.get("/titulacion/agregar_certificado/"+id_alumno,function (request) {
                $("#contenedor_agregar").html(request);
                $("#modal_agregar").modal('show');
            });
        });
        $("#guardar_certificado").click(function(event) {
            var documento = $("#documento").val();
            if(documento != ""){
                $("#form_agregar_certificado").submit();
                $("#guardar_certificado").attr("disabled", true);
                swal({
                    type: "success",
                    title: "Registro exitoso",
                    showConfirmButton: false,
                    timer: 1500
                });
            }else{
                swal({
                    position: "top",
                    type: "error",
                    title: "Ingresar PDF con el Certificado de Acreditación",
                    showConfirmButton: false,
                    timer: 3500
                });
            }
        });
        $("#tabla_titulacion").on('click','.editar_certificado',function(){
            var id_certificado_acreditacion = $(this).data('id');
            $.get("/titulacion/editar_certificado/"+id_certificado_acreditacion,function (request) {
                $("#contenedor_editar_certificado").html(request);
                $("#modal_editar_certificado").modal('show');
            });

        });
        $("#tabla_titulacion").on('click','.eliminar_certificado',function(){
            var id_certificado_acreditacion = $(this).data('id');
            $.get("/titulacion/eliminar_certificado/"+id_certificado_acreditacion,function (request) {
                $("#contenedor_eliminar_certificado").html(request);
                $("#modal_eliminar_certificado").modal('show');
            });

        });
        $("#tabla_titulacion").on('click','.enviar_certificado',function(){
            var id_certificado_acreditacion = $(this).data('id');
            $.get("/titulacion/enviar_certificado/"+id_certificado_acreditacion,function (request) {
                $("#contenedor_enviar_certificado").html(request);
                $("#modal_enviar_certificado").modal('show');
            });

        });
        $("#tabla_titulacion").on('click','.eliminar_alumno',function(){
            var id_certificado_acreditacion = $(this).data('id');

        });
        $("#tabla_titulacion").on('click','.enviar_alumno',function(){
            var id_certificado_acreditacion = $(this).data('id');

        });
        $("#guardar_editar_certificado").click(function(event) {

            var documento = $("#documento").val();

            if(documento != ""){
                $("#form_modificar_certificado").submit();
                $("#guardar_editar_certificado").attr("disabled", true);
                swal({
                    type: "success",
                    title: "Registro exitoso",
                    showConfirmButton: false,
                    timer: 1500
                });
            }else{
                swal({
                    position: "top",
                    type: "error",
                    title: "Ingresar PDF con el Certificado de Acreditación",
                    showConfirmButton: false,
                    timer: 3500
                });
            }

        });

        $("#guardar_eliminar_certificado").click(function(event) {


                $("#form_eliminar_certificado").submit();
                $("#guardar_eliminar_certificado").attr("disabled", true);
                swal({
                    type: "danger",
                    title: "Eliminación exitosa",
                    showConfirmButton: false,
                    timer: 1500
                });
        });
        $("#guardar_enviar_certificado").click(function(event) {


            $("#form_enviar_certificado").submit();
            $("#guardar_enviar_certificado").attr("disabled", true);
            swal({
                type: "danger",
                title: "Envio correctamente",
                showConfirmButton: false,
                timer: 1500
            });
        });


    </script>

@endsection
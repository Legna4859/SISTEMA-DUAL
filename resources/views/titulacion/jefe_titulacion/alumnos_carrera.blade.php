@extends('layouts.app')
@section('title', 'Titulacion')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/titulacion/registro_alumnos_titulacion")}}">Programas de Estudios</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Estudiantes de Titulación </span>

            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Registrar alumnos para titulación <br> (CARRERA: {{$carrera->nombre}})  </h3>
                </div>
            </div>
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
                        <td><button type="button" class="btn btn-success agregar_alumno" data-id="{{ $alumno->id_alumno }}">Agregar</button></td>
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
                            <h3 class="panel-title text-center">Estudiantes registrados para Titulación  </h3>
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
                    <th>NOMBRE DEL O DE LA ESTUDIANTE</th>
                    <th>DESCUENTO</th>
                    <th>TELEFONO</th>
                    <th>VER DATOS COMPLETOS</th>
                    <th>EDITAR</th>
                    <th>ELIMINAR</th>
                </tr>
                </thead>
                <tbody>
                @foreach($registro_titulacion as $titulacion)
                    <tr>
                        <td>{{$titulacion->cuenta }} </td>
                        <td>{{$titulacion->nombre }} {{ $titulacion->apaterno }}  {{ $titulacion->amaterno }}</td>
                        <td>{{ $titulacion->tipo_desc }}</td>
                        <td>{{ $titulacion->telefono }}</td>
                        @if($titulacion->id_liberado )
                            <td><button type="button" class="btn btn-primary ver_alumno" data-id="{{ $titulacion->id_descuento_alum }}">Ver datos</button></td>
                            <td>Ya entrego documentación</td>
                            <td>Autorizado(a)</td>
                            @else
                            <td><button type="button" class="btn btn-primary ver_alumno" data-id="{{ $titulacion->id_descuento_alum }}">Ver datos</button></td>
                            <td><button type="button" class="btn btn-warning editar_alumno" data-id="{{ $titulacion->id_descuento_alum }}">Editar</button></td>
                        <td><button type="button" class="btn btn-danger eliminar_alumno" data-id="{{ $titulacion->id_descuento_alum }}">Eliminar</button></td>
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
                    <h4 class="modal-title text-center" id="myModalLabel">Agregar estudiante</h4>
                </div>
                <form id="form_agregar_alumno" class="form" action="{{url("/titulacion/guardar_datos_alumno/")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                <div class="modal-body">

                    <div id="contenedor_agregar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button  id="guardar_registro" type="button" style="" class="btn btn-primary"  >Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{--Modal de editar--}}
    <div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Editar datos del o de la estudiante</h4>
                </div>
                <form id="form_editar_alumno" class="form" action="{{url("/titulacion/guardar_edicion_datos_alumno/")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div id="contenedor_editar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button  id="guardar_editar" type="button" style="" class="btn btn-primary"  >guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--Modal de eliminar--}}
    <div class="modal fade" id="modal_eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Eliminar datos del o de la estudiante</h4>
                </div>
                <form id="form_eliminar_alumno" class="form" action="{{url("/titulacion/eliminacion_edicion_datos_alumno/")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div id="contenedor_eliminar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button  id="guardar_eliminar" type="button" style="" class="btn btn-primary"  >Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--Modal ver--}}
    <div class="modal fade" id="modal_ver_datos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Ver datos registrados del o de la estudiante</h4>
                </div>
                    <div class="modal-body">

                        <div id="contenedor_ver_datos">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">



        $(document).ready(function() {
            $('#tabla_alumnos').DataTable();
            $('#tabla_titulacion').DataTable();
        } );
        $("#tabla_alumnos").on('click','.agregar_alumno',function(){
            var id_alumno=$(this).data('id');
            $.get("/titulacion/mostrar_datos_alumno/"+id_alumno,function (request) {
                $("#contenedor_agregar").html(request);
                $("#modal_agregar").modal('show');
            });
        });
        $("#guardar_registro").click(function(event) {
            var id_tipo_descuento = $("#id_tipo_descuento").val();
            var telefono = $("#telefono").val();
            var id_preparatoria = $("#id_preparatoria").val();
            var valoresAceptados = /^[0-9]+$/;
            if(id_tipo_descuento != null && telefono != ""  && id_preparatoria != null){
                if (telefono.match(valoresAceptados)) {
                    if(telefono.length == 10) {

                        $("#guardar_registro").attr("disabled", true);
                        $("#form_agregar_alumno").submit();

                        swal({
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    else{
                        swal({
                            position: "top",
                            type: "error",
                            title: "El numero de telefono es incorrecto",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "El numero de telefono es incorrecto",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            }else{
                swal({
                    position: "top",
                    type: "error",
                    title: "Campo(s) vacio(s)",
                    showConfirmButton: false,
                    timer: 3500
                });
            }
        });
        $("#tabla_titulacion").on('click','.ver_alumno',function(){
            var id_descuento_alum = $(this).data('id');
            $.get("/titulacion/ver_datos_alumno/"+id_descuento_alum,function (request) {
                $("#contenedor_ver_datos").html(request);
                $("#modal_ver_datos").modal('show');
            });

        });
        $("#tabla_titulacion").on('click','.editar_alumno',function(){
            var id_descuento_alum = $(this).data('id');
            $.get("/titulacion/editar_datos_alumno/"+id_descuento_alum,function (request) {
                $("#contenedor_editar").html(request);
                $("#modal_editar").modal('show');
            });

        });
        $("#tabla_titulacion").on('click','.eliminar_alumno',function(){
            var id_descuento_alum = $(this).data('id');
            $.get("/titulacion/eliminar_datos_alumno/"+id_descuento_alum,function (request) {
                $("#contenedor_eliminar").html(request);
                $("#modal_eliminar").modal('show');
            });

        });
        $("#guardar_editar").click(function(event) {

                $("#form_editar_alumno").submit();
                $("#guardar_editar").attr("disabled", true);
            swal({
                type: "success",
                title: "Registro exitoso",
                showConfirmButton: false,
                timer: 1500
            });

        });
        $("#guardar_eliminar").click(function(event) {

            $("#form_eliminar_alumno").submit();
            $("#guardar_eliminar").attr("disabled", true);
            swal({
                type: "success",
                title: "Eliminación exitosa",
                showConfirmButton: false,
                timer: 1500
            });

        });

    </script>

@endsection
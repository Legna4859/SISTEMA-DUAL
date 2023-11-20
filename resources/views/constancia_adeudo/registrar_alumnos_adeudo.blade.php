@extends('layouts.app')
@section('title', 'Registrar Estudiantes con Adeudo')
@section('content')
    <main class="col-md-12">

        <div class="row">

            <div class="col-md-6 col-md-offset-3 ">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Registrar Estudiante con Adeudo</h3>
                    </div>
                </div>
            </div>

        </div>

            @if($estado == 1)
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="dropdown">
                            <label for="exampleInputEmail1">Elige carrrera<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control  "placeholder="selecciona una Opcion" id="carrera" name="carrera" required>
                                <option disabled selected hidden>Selecciona una opción</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{$carrera->id_carrera}}" data-esta="{{$carrera->nombre}}">{{$carrera->nombre}}</option>
                                @endforeach
                            </select>
                            <br>
                        </div>
                    </div>
                    <br>
                </div>
                @elseif($estado == 2)
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="dropdown">
                            <label for="exampleInputEmail1">Elige carrrera<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control  "placeholder="selecciona una Opcion" id="carrera" name="carrera" required>
                                <option disabled selected hidden>Selecciona una opción</option>
                                @foreach($carreras as $carrera)
                                    @if($carrera->id_carrera==$id_carrera)
                                        <option value="{{$carrera->id_carrera}}" selected="selected">{{$carrera->nombre}}</option>
                                    @else
                                        <option value="{{$carrera->id_carrera}}" >{{$carrera->nombre}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <br>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="row">
                    <div class="col-md-5 ">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Estudiantes de la carrera</h3>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-body">

                                <table id="table_enviado" class="table table-bordered table-resposive">
                                    <thead>
                                    <tr>
                                        <th>No. Cuenta</th>
                                        <th>Nombre del Estudiante</th>
                                        <th>Semestre</th>
                                        <th>Agregar Estudiante deudor</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($alumnos as $alumno)

                                        <tr>
                                            <td>{{ $alumno->cuenta }}</td>
                                            <td> {{ $alumno->apaterno }} {{ $alumno->amaterno }} {{ $alumno->nombre }}</td>
                                            <td>{{ $alumno->semestre }}</td>
                                            <td>  <button type="button" class="btn btn-success  btn-block enviar" data-id_alumno="{{$alumno->id_alumno}}" data-nombre="{{ $alumno->apaterno }} {{ $alumno->amaterno }} {{ $alumno->nombre }}" title="Agregar ">Agregar</button></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 ">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Estudiantes con adeudo </h3>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-body">

                                <table id="table_adeudos" class="table table-bordered table-resposive">
                                    <thead>
                                    <tr>
                                        <th>No. Cuenta</th>
                                        <th>Nombre del Estudiante</th>
                                        <th>Semestre</th>
                                        <th>Fecha de registro</th>
                                        <th>Adeudo</th>
                                        <th>Editar</th>
                                        <th>Eliminar del adeudo</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($alumnos_adeudo as $alumnos_adeudo)

                                        <tr>
                                            <td>{{ $alumnos_adeudo->cuenta }}</td>
                                            <td> {{ $alumnos_adeudo->apaterno }} {{ $alumnos_adeudo->amaterno }} {{ $alumnos_adeudo->nombre }}</td>
                                            <td>{{ $alumnos_adeudo->semestre }}</td>
                                            <td>{{ $alumnos_adeudo->fecha_registro }}</td>
                                            <td>{{ $alumnos_adeudo->comentario }}</td>

                                            <td>   <a class=" editar" id="{{ $alumnos_adeudo->id_adeudo_departamento }}"><i class="glyphicon glyphicon-edit"></i></a>
                                            </td>
                                            <td>  <button type="button" class="btn btn-danger  btn-block eliminar" id="{{$alumnos_adeudo->id_adeudo_departamento}}" title="Eliminar de adeudo">Eliminar </button></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="modal_enviar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                                 <div class="modal-body">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                    <input type="button" id="nombre" name="nombre" value=""> se registrara por adeudo de?
                                    <input type="hidden" id="id_alumno" name="id_alumno" value="">
                                        <input type="hidden" id="id_carrera" name="id_carrera" value="{{$id_carrera}}">
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea class="form-control" type="text" id="comentario" name="comentario" required></textarea>
                                        </div>
                                    </div>

                                     </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button id="aceptar_registro"  class="btn btn-danger" value="Aceptar">Aceptar</button>
                                </div>

                        </div>
                    </div>
                </div>

                <div id="modal_eliminar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <form action="{{url("/eliminar_alumno_adeudo/$id_carrera")}}" method="POST" role="form" >
                                <div class="modal-body">
                                    {{ csrf_field() }}
                                    ¿Eliminar alumno del adeudo?
                                    <input type="hidden" id="id_adeudo_carrera" name="id_adeudo_carrera" value="">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <input  type="submit" class="btn btn-danger" value="Aceptar"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @endif




    </main>
    <div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Editar comentario</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_editar">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_enviado').DataTable( );
            $('#table_adeudos').DataTable( );
            $("#carrera").on('change',function(e){
                var carrera= $("#carrera").val();
                window.location.href='/solicitud_alumno_adeudo/'+carrera ;


            });
            $("#aceptar_registro").click(function ()
            {
                var comentario = $("#comentario").val();
               if(comentario == ""){
                   swal({
                       position: "top",
                       type: "error",
                       title: "hay un campo vacio",
                       showConfirmButton: false,
                       timer: 3500
                   });
               }
               else{
                   $("#aceptar_registro").attr("disabled", true);
                   var id_alumno = $("#id_alumno").val();
                   var id_carrera = $("#id_carrera").val();
                   window.location.href='/registrar_alumno_adeudo/'+id_carrera+"/"+id_alumno+"/"+comentario;
               }
            });

            $("#table_enviado").on('click','.enviar',function(){
                var id=$(this).data('id_alumno');
                var nombre= $(this).data('nombre');

                $('#id_alumno').val(id);
                $('#nombre').val(nombre);
                $('#modal_enviar').modal('show');
            });


            $("#table_adeudos").on('click','.eliminar',function(){
                var id=$(this).attr('id');
                $('#id_adeudo_carrera').val(id);
                $('#modal_eliminar').modal('show');
            });


            $("#table_adeudos").on('click','.editar',function(){
                var id=$(this).attr('id');

                $.get("/constancia_alumno_editar/"+id,function (request) {
                    $("#contenedor_editar").html(request);
                    $("#modal_editar").modal('show');
                });
            });

        });
    </script>

@endsection
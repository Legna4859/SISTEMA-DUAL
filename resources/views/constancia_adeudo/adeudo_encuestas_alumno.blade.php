@extends('layouts.app')
@section('title', 'Registrar Estudiantes con Adeudo')
@section('content')
    <main class="col-md-12">

        <div class="row">

            <div class="col-md-6 col-md-offset-3 ">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Registrar Estudiantes con Adeudo de Firma de Encuesta</h3>
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

                            <table id="table_alumnos_carrera" class="table table-bordered table-resposive">
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
                                        <td>  <button type="button" class="btn btn-success  btn-block enviar_alumno" data-id_alumno="{{$alumno->id_alumno}}" data-nombre="{{ $alumno->apaterno }} {{ $alumno->amaterno }} {{ $alumno->nombre }}" title="Agregar ">Agregar</button></td>
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
                            <h3 class="panel-title text-center">Estudiantes con adeudo  de firma de encuestas</h3>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-body">

                            <table id="table_adeudos_encuestas" class="table table-bordered table-resposive">
                                <thead>
                                <tr>
                                    <th>No. Cuenta</th>
                                    <th>Nombre del Estudiante</th>
                                    <th>Semestre</th>
                                    <th>Fecha de registro</th>
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

                                        <td>  <button type="button" class="btn btn-danger  btn-block eliminar_adeudo"  data-id_adeudo="{{$alumnos_adeudo->id_adeudo_constancia}}" data-nombres="{{ $alumnos_adeudo->apaterno }} {{ $alumnos_adeudo->amaterno }} {{ $alumnos_adeudo->nombre }}" title="Eliminar de adeudo">Eliminar </button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="modal_enviar_encuesta" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="button" id="nombre" name="nombre" value=""> Se registrara por adeudo de Firma de encuesta?
                                    <input type="hidden" id="id_alumno" name="id_alumno" value="">
                                    <input type="hidden" id="id_carrera" name="id_carrera" value="{{$id_carrera}}">
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="aceptar_registro_encuesta"  class="btn btn-danger" value="Aceptar">Aceptar</button>
                        </div>

                    </div>
                </div>
            </div>

            <div id="modal_eliminar_adeudo_encuestas" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <form action="{{url("/encuestas_adeudo/eliminar_datos_encuesta/$id_carrera")}}" method="POST" role="form" >
                            <div class="modal-body">
                                {{ csrf_field() }}
                                <input type="button" id="nombres" name="nombres" value="">
                                ¿Eliminar alumno del adeudo de firma de encuesta?
                                <input type="hidden" id="id_adeudo_encuestas" name="id_adeudo_encuestas" value="">

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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_alumnos_carrera').DataTable( );
            $('#table_adeudos_encuestas').DataTable( );
            $("#carrera").on('change',function(e){
                var id_carrera= $("#carrera").val();
                window.location.href='/encuestas_adeudo/ver_alumnos_encuestas_adeudo/'+id_carrera ;


            });
            $("#aceptar_registro_encuesta").click(function ()
            {
                    $("#aceptar_registro_encuesta").attr("disabled", true);
                    var id_alumno = $("#id_alumno").val();
                    
                    var id_carrera = $("#id_carrera").val();
                    window.location.href='/encuestas_adeudo/enviar_datos_encuesta/'+id_carrera+"/"+id_alumno;

            });

            $("#table_alumnos_carrera").on('click','.enviar_alumno',function(){
                var id=$(this).data('id_alumno');
                var nombre= $(this).data('nombre');


                $('#id_alumno').val(id);
                $('#nombre').val(nombre);
                $('#modal_enviar_encuesta').modal('show');
            });


            $("#table_adeudos_encuestas").on('click','.eliminar_adeudo',function(){
                var id=$(this).data('id_adeudo');
                var nombre=$(this).data('nombres');

                $('#id_adeudo_encuestas').val(id);
                $('#nombres').val(nombre);
                $('#modal_eliminar_adeudo_encuestas').modal('show');
            });



        });
    </script>

@endsection
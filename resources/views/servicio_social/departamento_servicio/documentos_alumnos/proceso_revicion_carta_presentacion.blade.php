@extends('layouts.app')
@section('title', 'Servicio Social')
@section('content')
    <main>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Carta de Presentación-Aceptación</h3>
                    </div>
                </div>
            </div>

            <div class="row col-md-11 col-md-offset-1">
                <ul class="nav nav-tabs">
                    <li><a href="{{ url('/servicio_social/ingresar_contancia/departamento/' ) }}" >Enviar Carta de Presentación</a></li>
                    <li>
                        <a href="{{ url('/servicio_social/proceso_modificacion_cartapresentacion/departamento/' ) }}" >En proceso de Modificación</a>
                    </li>
                    <li class="active"><a href="#">Estudiantes para Revisión Carta P.</a>
                    </li>
                    <li>
                        <a href="{{ url('/servicio_social/proceso_autorizadas_cartapresentacion/departamento/' ) }}" >Cartas de presentación Autorizadas</a>
                    </li>



                </ul>

                <div class="tab-content ">
                    <div role="tabpanel" class="tab-pane active" id="uno">

                        <div class=" col-md-12 ">

                            </br></br></br>

                            <table class="table table-bordered " Style="background: white;" id="tabla_revicion_costancia">
                                <thead>
                                <tr>
                                    <th>No. CUENTA</th>
                                    <th>NOMBRE DE ALUMNO(A)</th>
                                    <th>CARRERA</th>
                                    <th>CORREO ELECTRONICO</th>
                                    <th>NOMBRE DEL PERIODO</th>
                                    <th>VER</th>
                                    <th>AUTORIZACIÓN</th>


                                </tr>
                                </thead>
                                <tbody>

                                @foreach($alumnos as $alumno)
                                    <tr>
                                        <th>{{$alumno["cuenta"]}}</th>
                                        <td>{{$alumno["nombre"]}} </td>
                                        <td>{{$alumno["carrera"]}}</td>
                                        <td>{{$alumno["correo_electronico"]}}</td>
                                        <td>{{$alumno["nombre_periodo"]}}</td>
                                        <td><a target="_blank" href="{{asset('/servicio_social_pdf/carta_presentacion/'.$alumno["pdf_constancia_presentacion"])}}"> <i class="glyphicon glyphicon glyphicon-file"></i></a></td>
                                        <td><button  id="{{$alumno["id_datos_alumnos"] }}" class="btn btn-success  autorizar_carta">Autorizar</button><br>
                                            <br><button  id="{{$alumno["id_datos_alumnos"] }}" class="btn btn-danger  rechazar_carta">Rechazar</button></td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>



                </div>
            </div>

        </div>

        <div class="modal fade" id="modal_autorizar_carta" role="dialog">

            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form method="POST" id="form_autorizar" action="{{ url("/servicio_social/autorizar_cartapresentacionalumno/alumno/") }}">
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Autorización de la Carta de Presentación-Aceptación al Estudiante</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id_dat" name="id_dat" value="">
                            <p>¿Seguro que quieres autorizar la Carta de Presentación-Aceptación del Estudiante?</p>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  id="autorizar_carta_alumno" class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="modal_rechazar_carta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Rechazar la Carta de Presentación-Aceptación del Estudiante</h4>
                    </div>
                    <div id="contenedor_rechazar_carta">


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  id="rech_carta_presentacion" class="btn btn-success" >Enviar</button>
                    </div>
                </div>


            </div>
        </div>
    </main>
    <script type="text/javascript">
        $(document).ready(function() {


            $('#tabla_revicion_costancia').on('click','.autorizar_carta',function(){
                var id_datos_alumnos=$(this).attr('id');
                $('#id_dat').val(id_datos_alumnos);
                $("#modal_autorizar_carta").modal('show');
                
            });
            $("#autorizar_carta_alumno").click(function (event) {
                $("#form_autorizar").submit();
                $("#autorizar_carta_alumno").attr("disabled", true);
            });
            $('#tabla_revicion_costancia').DataTable();
            $('#tabla_revicion_costancia').on('click','.rechazar_carta',function(){
                var id_datos_alumnos=$(this).attr('id');
                // alert(id_datos_alumnos);
                $.get('/servicio_social/rechazar_cartapresentacionalumno/'+id_datos_alumnos,function(request){
                    $('#contenedor_rechazar_carta').html(request);
                    $('#modal_rechazar_carta').modal('show');
                });
            });
            $("#rech_carta_presentacion").click(function (event) {
                var comentario_carta = $('#comentario_carta').val();
                var s=comentario_carta.length;
                 if(s> 0){
                     $("#form_rechar_carta_presentcion").submit();
                     $("#rech_carta_presentacion").attr("disabled", true);
                 }else{

                     swal({
                         position: "top",
                         type: "error",
                         title: "Hay un campo no seleccionado en el formulario",
                         showConfirmButton: false,
                         timer: 3500
                     });
                 }
            });


        });
    </script>
@endsection
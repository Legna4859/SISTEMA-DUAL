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
                    <li class="active"><a href="#">Enviar Carta de Presentación</a></li>
                    <li>
                        <a href="{{ url('/servicio_social/proceso_modificacion_cartapresentacion/departamento/' ) }}" >En proceso de Modificación</a>
                    </li>
                    <li>
                        <a href="{{ url('/servicio_social/proceso_revicion_cartapresentacion/departamento/' ) }}" >Estudiantes para Revisión Carta P.</a>
                    </li>
                    <li>
                        <a href="{{ url('/servicio_social/proceso_autorizadas_cartapresentacion/departamento/' ) }}" >Cartas de presentación Autorizadas</a>
                    </li>



                </ul>

                <div class="tab-content ">
                    <div role="tabpanel" class="tab-pane active" id="uno">

                        <div class=" col-md-9 col-md-offset-1">

                            </br></br></br>

                            <table class="table table-bordered " Style="background: white;" id="tabla_enviar_costancia">
                                <thead>
                                <tr>
                                    <th>No. CUENTA</th>
                                    <th>NOMBRE DE ALUMNO(A)</th>
                                    <th>CARRERA</th>
                                    <th>REGISTRAR CARTA PRESENTACIÓN</th>
                                    <th>ENVIAR CARTA PRESENTACIÓN</th>


                                </tr>
                                </thead>
                                <tbody>

                                @foreach($autorizados as $autorizados)
                                    <tr>
                                        <th>{{$autorizados->cuenta}}</th>
                                        <td>{{$autorizados->nombre}} {{$autorizados->apaterno}} {{$autorizados->amaterno}}</td>
                                        <td>{{$autorizados->carrera}}</td>
                                        @if($autorizados->id_estado_presentacion == 0)
                                        <td style="text-align: center;"><button  id="{{ $autorizados->id_datos_alumnos }}" class="btn btn-primary registrar_presentacion"><i class="glyphicon glyphicon-plus "></i></button></td>
                                            <td></td>
                                        @elseif($autorizados->id_estado_presentacion == 1)
                                            <td style="text-align: center;"><button  id="{{ $autorizados->id_datos_alumnos }}" class="btn btn-primary  modificar_presentacion"><i class="glyphicon glyphicon-edit "></i></button>
                                                <button  id="{{ $autorizados->id_datos_alumnos }}" class="btn btn-success  ver_presentacion"><i class="glyphicon glyphicon glyphicon-file"></i></button></td>
                                            <td><button  id="{{ $autorizados->id_datos_alumnos }}" class="btn btn-success  enviar_presentacion">Enviar</button></td>


                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>



                </div>
            </div>

        </div>


   <div class="modal fade" id="modal_registrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Registrar  Carta de Presentación-Aceptación del Estudiante</h4>
                    </div>
                    <div id="contenedor_registrar">


                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-3">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button   type="button" id="reg_pre" class="btn btn-primary" >guardar</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5">
                         <p></p>   </div>
                    </div>

                </div>

            </div>
        </div>
        {{--fin autorizar--}}

        <div class="modal fade" id="modal_modificar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar  Carta de Presentación-Aceptación del Estudiante</h4>
                    </div>
                    <div id="contenedor_modificar">


                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-3">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button   type="button" id="modificar_carta" class="btn btn-primary" >Modificar</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5">
                            <p></p>   </div>
                    </div>

                </div>

            </div>
        </div>
        {{--fin autorizar--}}
        <div class="modal fade" id="modal_ver" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Ver  Carta de Presentación-Aceptación del Estudiante</h4>
                    </div>
                    <div id="contenedor_ver">


                    </div>
                    <div class="row">
                        <div class="col-md-2 col-md-offset-8">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5">
                            <p></p>   </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="modal fade" id="enviar_peresentacion" role="dialog">

            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form method="POST" id="enviar_doc_carta" action="{{ url("/servicio_social/enviar_carta_presentacion/") }}">
                        @csrf
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Enviar Carta de Presentación-Aceptación al Estudiante</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id_datos_alumnos_m" name="id_datos_alumnos_m" value="">
                            <p>¿Seguro que quieres, enviar el documento?</p>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  id="enviar_carta_presentacion" class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <script type="text/javascript">
        $(document).ready(function() {


            $('#tabla_enviar_costancia').on('click','.registrar_presentacion',function(){
                var id_datos_alumnos=$(this).attr('id');
                       // alert(id_datos_alumnos);
                $.get('/servicio_social/registrar_constancia/departamento/'+id_datos_alumnos,function(request){
                    $('#contenedor_registrar').html(request);
                    $('#modal_registrar').modal('show');
                });
            });
            $("#reg_pre").click(function (event) {
                var pdf_documento_carta = $("#pdf_documento_carta").val();
                var id_periodo = $("#id_periodo").val();

                var ls=pdf_documento_carta.length;
                var l=id_periodo.length;

                //alert(ls);
               if(ls > 0 && l > 0 ){
                   $("#formulario_carta_presentacion").submit();
                   $("#reg_pre").attr("disabled", true);
               }else{
                   swal({
                       position: "top",
                       type: "error",
                       title: "hay un campo vacio",
                       showConfirmButton: false,
                       timer: 3500
                   });
               }
            });
            $('#tabla_enviar_costancia').DataTable();
            $('#tabla_enviar_costancia').on('click','.modificar_presentacion',function(){
                var id_datos_alumnos=$(this).attr('id');
                // alert(id_datos_alumnos);
                $.get('/servicio_social/modificar_carta_presentacion/'+id_datos_alumnos,function(request){
                    $('#contenedor_modificar').html(request);
                    $('#modal_modificar').modal('show');
                });
            });
            $("#modificar_carta").click(function (event) {
                var pdf_documento_carta = $("#pdf_documento_carta").val();
                var id_periodo = $("#id_periodo").val();

                var ls=pdf_documento_carta.length;
                var l=id_periodo.length;

                //alert(ls);
                if(ls > 0 && l > 0 ){
                    $("#formulario_modificar_carta_presentacion").submit();
                    $("#modificar_carta").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "hay un campo vacio",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $('#tabla_enviar_costancia').on('click','.ver_presentacion',function(){
                var id_datos_alumnos=$(this).attr('id');
                 //alert(id_datos_alumnos);
                $.get('/servicio_social/ver_carta_presentacion/'+id_datos_alumnos,function(request){
                    $('#contenedor_ver').html(request);
                    $('#modal_ver').modal('show');
                });
            });
            $('#tabla_enviar_costancia').on('click','.enviar_presentacion',function(){
                var id_datos_alumnos=$(this).attr('id');
                //alert(id_datos_alumnos);
                $('#id_datos_alumnos_m').val(id_datos_alumnos);
                    $('#enviar_peresentacion').modal('show');

            });



            $("#enviar_carta_presentacion").click(function (event) {

                    $("#enviar_doc_carta").submit();
                    $("#enviar_carta_presentacion").attr("disabled", true);
            });
        });
    </script>
@endsection
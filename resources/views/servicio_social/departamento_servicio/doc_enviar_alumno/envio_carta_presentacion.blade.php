@extends('layouts.app')
@section('title', 'Servicio Social')
@section('content')
    <main>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Envío de Carta de Presentación-Aceptación</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-success">
            <div class="panel-heading">Descargar  Carta de Presentación-Aceptación</div>
            <div class="panel-body">
                <p> NO. CUENTA: <b>{{ $carta_presentacion[0]->cuenta }}</b></p>
                <p> NOMBRE DEL ESTUDIANTE: <b>{{ $carta_presentacion[0]->nombre }}</b> <b>{{ $carta_presentacion[0]->apaterno }}</b> <b>{{ $carta_presentacion[0]->amaterno }}</b></p>
                <label>Descargar  Carta de Presentación-Aceptación</label>
                <a  target="_blank" href="{{asset('/servicio_social_pdf/carta_presentacion/'.$carta_presentacion[0]->pdf_constancia_presentacion)}}" class="btn btn-primary "><i class="glyphicon glyphicon glyphicon-file"></i></a>

            </div>
        </div>
        </div>
        </div>
        @if($carta_alumno == 0)
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Enviar la  Carta de Presentación-Aceptación</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <form class="form" id="guardar_carta_presentacion" action="{{url("/servicio_social/guardarcartapresentacionalumno/alumno/")}}" role="form" method="POST" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                    <input type="hidden"  id="id_alumno" name="id_alumno" value="{{{$carta_presentacion[0]->id_alumno}}}"   required/>
                                    <input class="form-control"  id="ls_pdf_documento_carta_alumno" name="ls_pdf_documento_alumno" type="file"   accept="application/pdf" required/>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <p></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-md-offset-5">
                                <button  id="guardar_carta_presentacion_estado" class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif($carta_alumno == 1)
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-success">
                        <div class="panel-heading">Enviar la  Carta de Presentación-Aceptación</div>
                        <div class="panel-body" style="text-align: center">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Ver PDF</th>
                                    <th>Modificar PDF</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Carta de Presentación-Aceptación</td>
                                    <td><a  target="_blank" href="{{asset('/servicio_social_pdf/carta_presentacion/'.$carta_alumno_presentacion[0]->pdf_carta_presentacion)}}" class="btn btn-primary btn-lg"><i class="glyphicon glyphicon-pencil em56"></i></a></td>
                                    <td><button  id="{{ $carta_alumno_presentacion[0]->id_alumno }}" class="btn btn-primary btn-lg modificar_alumno_carta_presentacion"><i class="glyphicon glyphicon-edit em56"></i></button></td>

                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                       <p></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-md-offset-5">
                        <button   class="btn btn-success  " title="Enviar" data-toggle="modal" data-target="#enviar_cp_a">Enviar Carta de Presentación-Aceptación </button>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <p></p>
                    </div>
                </div>
            </div>
        {{---enviar--}}
            <div class="modal fade" id="enviar_cp_a" role="dialog">

                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <form method="POST" id="enviar_cart_p" action="{{ url("/servicio_social/enviar_cartapresentacionalumno/alumno/{$datos_alumnos[0]->id_datos_alumnos}") }}">
                            @csrf
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Enviar Carta de Presentación-Aceptación</h4>
                            </div>
                            <div class="modal-body">
                                <p>¿Seguro que quieres, enviar tu Carta de Presentación-Aceptación al Departamento de Servicio Social y Residencia Profesional para su revisión?</p>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button  id="car_presentacion" class="btn btn-primary" >Aceptar</button>
                        </div>
                    </div>
                </div>

            </div>
            {{---enviar--}}
            <div class="modal fade" id="modal_modificar_carta_alumno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Modificar Carta de Presentación-Aceptación</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <form class="form" id="formulario_modificar_carta_presentacion_alumno" action="{{url("/servicio_social/modificar_cartapresentacionalumno/alumno/")}}" role="form" method="POST" enctype="multipart/form-data" >
                                    {{ csrf_field() }}
                                    <label>Modificar pdf</label>
                                    <input type="hidden"  id="id_al" name="id_al" value=" "   required/>
                                    <input class="form-control"  id="mod_pdf_documento_carta_alumno" name="mod_pdf_documento_carta_alumno" type="file"   accept="application/pdf" required/>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-md-offset-5">
                                <p></p>   </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-3">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button   type="button" id="modificar_carta_alumno" class="btn btn-primary" >Modificar</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-md-offset-5">
                                <p></p>   </div>
                        </div>

                    </div>

                </div>
            </div>

        @endif


    </main>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#guardar_carta_presentacion_estado").click(function (event) {
                var pdf_documento_carta_alumno = $("#ls_pdf_documento_carta_alumno").val();

                var ls=pdf_documento_carta_alumno.length;


                //alert(ls);
                if(ls > 0){
                    $("#guardar_carta_presentacion").submit();
                    $("#guardar_carta_presentacion_estado").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Ingresar tu Carta de Presentación-Aceptación",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });

            $(".modificar_alumno_carta_presentacion").click(function (event) {
                var id_constancia_presentacion_alumno=$(this).attr('id');
                $('#id_al').val(id_constancia_presentacion_alumno);
                    $("#modal_modificar_carta_alumno").modal('show');


            });
            $("#modificar_carta_alumno").click(function (event) {
                var mod_pdf_documento_carta_alumno = $("#mod_pdf_documento_carta_alumno").val();


                var ls=mod_pdf_documento_carta_alumno.length;


                //alert(ls);
                if(ls > 0 ){
                    $("#formulario_modificar_carta_presentacion_alumno").submit();
                    $("#modificar_carta_alumno").attr("disabled", true);
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
            $("#car_presentacion").click(function (event) {

                $("#enviar_cart_p").submit();
                $("#car_presentacion").attr("disabled", true);
            });
        });
    </script>

@endsection
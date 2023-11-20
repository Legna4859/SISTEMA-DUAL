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
        @if($estado_servicio == 0)
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">No se encontró ningún registro.</h3>
                    </div>
                </div>
            </div>
           </div>
            @elseif($estado_servicio == 1 && $estado_carta == 0)
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Para realizar este tramite, tus documentos de la primera etapa deben estar autorizados y el Departamento de Servicio Social y Residencia Profesional debe enviarte tu Carta de Presentación-Aceptación. .</h3>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($estado_servicio == 2 && $estado_carta == 1)
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Tus documentos de la primera etapa ya se encuentran autorizados, Para realizar este tramite el Departamento de Servicio Social y Residencia Profesional debe enviarte tu Carta de Presentación-Aceptación. </h3>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($estado_servicio == 2 && $estado_carta == 2)
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Tus documentos de la primera etapa ya se encuentran autorizados, Para realizar este tramite el Departamento de Servicio Social y Residencia Profesional debe enviarte tu Carta de Presentación-Aceptación. </h3>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($estado_servicio == 2 && $estado_carta == 4)
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Tu Carta de Presentación-Aceptación se envío correctamente al Departamento de Servicio Social y Residencia Profesional</h3>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($estado_servicio == 2 && $estado_carta == 5)
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Tu Carta de Presentación-Aceptación se encuentra Autorizada por el Departamento de Servicio Social y Residencia Profesional</h3>
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


        });
    </script>

@endsection
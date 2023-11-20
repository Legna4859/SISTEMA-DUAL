@extends('layouts.app')
@section('title', 'Documentación de alta de residenciaa')
@section('content')

    <main class="col-md-12">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Enviar Documentación de Alta de Residencia</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <form class="form" id="formulario_registrar_correo" action="{{url("/residencia/registrar_correo_documentacion")}}" role="form" method="POST" >
                                {{ csrf_field() }}
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <div class="form-group">
                                                <label for="nombre_proyecto">Nombre del alumno:</label>
                                                <p>{{$datosalumno->nombre}} {{$datosalumno->apaterno}} {{$datosalumno->amaterno}}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="nombre_proyecto">Ingresa tu correo electronico. (En el se te notificará, el estado que se encuentra tu documentación, si tienes que corregir o se encuentra autorizada).<b style="color:red; font-size:23px;">*</b></label>
                                                <input class="form-control"  id="correo_electronico_doc" name="correo_electronico_doc" type="email"  placeholder="Ingresa tu correo electronico" style="" required/>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-5 ">
                                            <button id="guardar_correo_alta" class="btn btn-primary">Aceptar</button>
                                        </div>
                                    </div>

                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>


    </main>

    <script type="text/javascript">
        $(document).ready( function() {

            $("#guardar_correo_alta").click(function (event) {
                var correo_electronico_doc = $("#correo_electronico_doc").val();
                if(correo_electronico_doc != ""){
                    $("#formulario_registrar_correo").submit();
                    $("#guardar_correo_alta").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Ingresa tu correo electronico.",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            });

        });
    </script>



@endsection
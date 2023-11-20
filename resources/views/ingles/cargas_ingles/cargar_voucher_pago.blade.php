@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Cargar vouchers de pago')
@section('content')

    <main class="col-md-12">

        <div class="row">

            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><b>Cargar Voucher de Pago</b></h3>
                    </div>
                </div>
            </div>
        </div>

    {{--por si no ha subido su baucher--}}
    @if($id_estado_carga_voucher==0)
    @if($estado_periodo==0)
   <div class="container" style="width: 30%; height: 5%; margin-top: 1em; margin-bottom: 1em">
            <div>
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><b>¡¡¡EL PERIODO NO SE ENCUENTRA ACTIVO PARA INGRESAR EL VOUCHER!!!</b></h3>
                    </div>
                </div>

            </div>
        </div>

    @else

        <div class="container" style="width: 30%; height: 5%; margin-top: 1em; margin-bottom: 1em">
            <div>
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><b>¡¡¡EL ARCHIVO DEBE ESTAR EN FORMATO PDF!!!</b></h3>
                    </div>
                </div>

            </div>
        </div>

        <div class="container" style="width: 40%">
            <div>
                <form action="{{url("/ingles_horarios/cargar_voucher_pago/")}}" method="post" enctype="multipart/form-data" id="formulario_guardar_voucher">
                @csrf
                    <input type="file" id="voucher" name="voucher" class="form-control" style="align-items: center" accept="application/pdf" required/>

                    {{--validar el tamaño del pdf--}}
                    <script>
                        const MAXIMO_TAMANIO_BYTES = 10000000; // 1MB = 1 millón de bytes, se asigna de tamaño 10 MB

                        // Obtener referencia al elemento
                        const $voucher = document.querySelector("#voucher");

                        $voucher.addEventListener("change", function () {
                            // si no hay archivos, regresamos
                            if (this.files.length <= 0) return;

                            // Validar el archivo
                            const archivo = this.files[0];
                            if (archivo.size > MAXIMO_TAMANIO_BYTES) {
                                const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
                                alert(`Tu archivo excede el tamaño permitido, el tamaño máximo de tu archivo debe ser de ${tamanioEnMb} MB`);
                                // Limpiar
                                $voucher.value = "";
                            } else {
                                // Validación pasada. Envía el formulario o haz lo que tengas que hacer
                            }
                        });
                    </script>

                    <label style="margin-top: 1.5em"> Ingresa la línea de captura de tu voucher de pago</label>
                    <input type="text" id="val_linea_voucher" name="val_linea_voucher" placeholder="¡¡¡Ingrese los 27 digitos de su linea de captura!!!" class="form-control" style="align-items: center" required/>

                    <label style="margin-top: 1em"> Fecha de cambio del recibo</label>
                    <input type="date" id="fecha_cambio" name="fecha_cambio" class="form-control" style="align-items: center" {{--value="{{$fecha->format('Y-m-d')}}" readonly--}} required/>

                    <input id="linea_captura" type="hidden" class="form-control" name="linea_captura" value="">
                    <input id="id_tipo_voucher" type="hidden" class="form-control" name="id_tipo_voucher" value="">

                </form>
                <div style="padding: 1.5em;">
                        <div class="d-grid gap-2 d-md-flex" style="size: 25px; margin-top: 1.5em; margin-bottom: 1.5em; align-items: center; display: flex; justify-content: center">
                            <button type="button" id="boton_rojo" class="btn" style="background-color: crimson; position:absolute;left: 30%;width:250px; height:50px; border-radius: 2em">
                                <strong style="color:white;"><b>Cargar Sello Rojo (¡¡¡ORIGINAL!!!)</b></strong>
                            </button>
                            <button type="button" id="boton_azul" class="btn btn-primary" style="position:absolute;right: 30%;width:250px; height:50px; border-radius: 2em;">
                                    <strong><b>Cargar Sello Azul (¡¡¡COPIA!!!)</b></strong>
                                </button>
                        </div>
                    </div>
                </div>
        </div>
    @endif
    {{--por si ya ha subido su baucher--}}
    @elseif($id_estado_carga_voucher==1)
    @if($dato_voucher->id_estado_valida_voucher==1)
            <div class="container" style="margin-top: 1em; margin-bottom: 1em">
                <div class="row">

                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center"><b>Ya se envio tu voucher a departamento de actividades complementarias</b></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 1em; align-items: center; display: flex; justify-content: center">

                    {{--<iframe src="{{asset($ruta)}}" type="application/pdf" width="420px" height="430px" frameborder="0"></iframe>
                    <button type="submit" class="btn btn-warning" onclick="location.href = {{asset($ruta)}}"><b>Ver archivo</b></button>--}}
                    {{--Visualiza el archivo en una nueva ventana y deja descargarlo--}}
                    <button type="submit" class="btn" style="background-color:#d9edf7; border-radius: 2em;">
                        <a  onclick="window.open('{{url($ruta)  }}')"  href="#" style="text-decoration: none;"><b>Ver voucher</b></a>
                    </button>
                </div>
            </div>
    @elseif($dato_voucher->id_estado_valida_voucher==3)
           <div class="container" style="margin-top: 1em; margin-bottom: 1em">
                <div class="row">

                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Comentario de Rechazo:
                                    {{$dato_voucher->comentario}}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container" style="width: 40%">
            <div>
                <form action="{{url("/ingles_horarios/cargar_voucher_modificar/".$dato_voucher->id_voucher)}}" method="post" enctype="multipart/form-data" id="formulario_modificacion_voucher">
                @csrf
                    <input type="file" id="voucher_mod" name="voucher_mod" class="form-control" style="align-items: center" accept="application/pdf" required/>

                    {{--validar el tamaño del pdf--}}
                    <script>
                        const MAXIMO_TAMANIO_BYTES = 10000000; // 1MB = 1 millón de bytes, se asigna de tamaño 10 MB

                        // Obtener referencia al elemento
                        const $voucher = document.querySelector("#voucher_mod");

                        $voucher.addEventListener("change", function () {
                            // si no hay archivos, regresamos
                            if (this.files.length <= 0) return;

                            // Validar el archivo
                            const archivo = this.files[0];
                            if (archivo.size > MAXIMO_TAMANIO_BYTES) {
                                const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
                                alert(`Tu archivo excede el tamaño permitido, el tamaño máximo de tu archivo debe ser de ${tamanioEnMb} MB`);
                                // Limpiar
                                $voucher.value = "";
                            } else {
                                // Validación pasada. Envía el formulario o haz lo que tengas que hacer
                            }
                        });
                    </script>

                    <label style="margin-top: 1.5em;color: black;">      Ingresa la línea de captura de tu voucher de pago</label>
                    <input type="text" id="val_linea_voucher_mod" name="val_linea_voucher_mod" placeholder="¡¡¡Ingrese los 27 digitos de su linea de captura!!!" value="{{$dato_voucher->linea_captura}}" class="form-control" style="align-items: center" required/>

                    <label style="margin-top: 1em;color: black;">         Fecha de cambio del recibo</label>
                    <input type="date" id="fecha_cambio_mod" name="fecha_cambio_mod" class="form-control" style="align-items: center" value="{{$dato_voucher->fecha_cambio}}" required/>

                    <input id="linea_captura_mod" type="hidden" class="form-control" name="linea_captura_mod" value="{{$dato_voucher->linea_captura}}">
                    <input id="id_tipo_voucher_mod" type="hidden" class="form-control" name="id_tipo_voucher_mod" value="">

                </form>
                <div style="padding: 1.5em;">
                        <div class="d-grid gap-2 d-md-flex" style="size: 25px; margin-top: 1.5em; margin-bottom: 1.5em; align-items: center; display: flex; justify-content: center">
                            <button type="button" id="boton_rojo_mod" class="btn" style="background-color: crimson; position:absolute;left: 30%;width:250; height:50px; border-radius: 2em">
                                <strong style="color:white;"><b>Cargar Sello Rojo (¡¡¡ORIGNINAL!!!)</b></strong>
                            </button>
                            <button type="button" id="boton_azul_mod" class="btn btn-primary" style="position:absolute;right: 30%;width:250; height:50px; border-radius: 2em;">
                                    <strong><b>Cargar Sello Azul (¡¡¡COPIA!!!)</b></strong>
                                </button>    
                        </div>
                    </div>
                </div>
        </div>
        @elseif($dato_voucher->id_estado_valida_voucher==2)
        <div class="row">

                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center"><b>Tu voucher ya fue autorizado por el coordinador de lenguas extranjeras, favor de llenar tu carga academica</b></h3>
                            </div>
                        </div>
                    </div>
    @endif
    @endif
    </main>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#boton_azul").click(function(){
            var voucher = $ ("#voucher").val();
            if (voucher != '') {
               var val_linea_voucher = $("#val_linea_voucher").val();
               
               if (val_linea_voucher != '') {
                    var val_linea_voucher = val_linea_voucher.replace(/ /g, "");

                    var contar_linea = val_linea_voucher.length;
                   // alert(contar_linea);
                    if (contar_linea == 27) {
                        $ ("#linea_captura").val(val_linea_voucher);
                        $ ("#id_tipo_voucher").val(2);
                         var fecha_cambio = $ ("#fecha_cambio").val();
                         if (fecha_cambio != '') {
                            $ ("#formulario_guardar_voucher").submit();
                            $ ("#boton_azul").attr("disabled",true);
                            swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                            });
                         }
                         else{
                            swal({
                            position: "top",
                            type: "error",
                            title: "Ingresa la fecha de cambio",
                            showConfirmButton: false,
                            timer: 3500
                            });
                         }
                    }
                    else{
                    swal({
                    position: "top",
                    type: "error",
                    title: "La linea de captura no es correcta debe tener 27 digitos",
                    showConfirmButton: false,
                    timer: 3500
                });
                    }
               }
               else{
                swal({
                    position: "top",
                    type: "error",
                    title: "Ingresa la linea de captura sin espacio de tu voucher",
                    showConfirmButton: false,
                    timer: 3500
                });
               }
            }
            else{
                swal({
                    position: "top",
                    type: "error",
                    title: "selecciona documento pdf",
                    showConfirmButton: false,
                    timer: 3500
                });
            }
            });

            $("#boton_rojo").click(function(){
            var voucher = $ ("#voucher").val();
            if (voucher != '') {
               var val_linea_voucher = $("#val_linea_voucher").val();
               
               if (val_linea_voucher != '') {
                    var val_linea_voucher = val_linea_voucher.replace(/ /g, "");

                    var contar_linea = val_linea_voucher.length;
                    if (contar_linea == 27) {
                        $ ("#linea_captura").val(val_linea_voucher);
                        $ ("#id_tipo_voucher").val(1);
                         var fecha_cambio = $ ("#fecha_cambio").val();
                         if (fecha_cambio != '') {
                            $ ("#formulario_guardar_voucher").submit();
                            $ ("#boton_rojo").attr("disabled",true);
                            swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                            });
                         }
                         else{
                            swal({
                            position: "top",
                            type: "error",
                            title: "Ingresa la fecha de cambio",
                            showConfirmButton: false,
                            timer: 3500
                            });
                         }
                    }
                    else{
                    swal({
                    position: "top",
                    type: "error",
                    title: "La linea de captura no es correcta debe tener 27 digitos",
                    showConfirmButton: false,
                    timer: 3500
                });
                    }
               }
               else{
                swal({
                    position: "top",
                    type: "error",
                    title: "Ingresa la linea de captura sin espacio de tu voucher",
                    showConfirmButton: false,
                    timer: 3500
                });
               }
            }
            else{
                swal({
                    position: "top",
                    type: "error",
                    title: "selecciona documento pdf",
                    showConfirmButton: false,
                    timer: 3500
                });
            }
            });

             $("#boton_azul_mod").click(function(){
            var voucher = $ ("#voucher_mod").val();
            if (voucher != '') {
               var val_linea_voucher_mod = $("#val_linea_voucher_mod").val();
               
               if (val_linea_voucher_mod != '') {
                    var val_linea_voucher_mod = val_linea_voucher_mod.replace(/ /g, "");

                    var contar_linea_mod = val_linea_voucher_mod.length;
                    if (contar_linea_mod == 27) {
                        $ ("#linea_captura_mod").val(val_linea_voucher_mod);
                        $ ("#id_tipo_voucher_mod").val(2);
                         var fecha_cambio_mod = $ ("#fecha_cambio_mod").val();
                         if (fecha_cambio_mod != '') {
                            $ ("#formulario_modificacion_voucher").submit();
                            $ ("#boton_azul_mod").attr("disabled",true);
                            swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                            });
                         }
                         else{
                            swal({
                            position: "top",
                            type: "error",
                            title: "Ingresa la fecha de cambio",
                            showConfirmButton: false,
                            timer: 3500
                            });
                         }
                    }
                    else{
                    swal({
                    position: "top",
                    type: "error",
                    title: "La linea de captura no es correcta debe tener 27 digitos",
                    showConfirmButton: false,
                    timer: 3500
                });
                    }
               }
               else{
                swal({
                    position: "top",
                    type: "error",
                    title: "Ingresa la linea de captura sin espacio de tu voucher",
                    showConfirmButton: false,
                    timer: 3500
                });
               }
            }
            else{
                swal({
                    position: "top",
                    type: "error",
                    title: "selecciona documento pdf",
                    showConfirmButton: false,
                    timer: 3500
                });
            }
            });

            $("#boton_rojo_mod").click(function(){
            var voucher = $ ("#voucher_mod").val();
            if (voucher != '') {
               var val_linea_voucher_mod = $("#val_linea_voucher_mod").val();
               
               if (val_linea_voucher_mod != '') {
                    var val_linea_voucher_mod = val_linea_voucher_mod.replace(/ /g, "");

                    var contar_linea_mod = val_linea_voucher_mod.length;
                    if (contar_linea_mod == 27) {
                        $ ("#linea_captura_mod").val(val_linea_voucher_mod);
                        $ ("#id_tipo_voucher_mod").val(1);
                         var fecha_cambio_mod = $ ("#fecha_cambio_mod").val();
                         if (fecha_cambio_mod != '') {
                            $ ("#formulario_modificacion_voucher").submit();
                            $ ("#boton_rojo_mod").attr("disabled",true);
                            swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                            });
                         }
                         else{
                            swal({
                            position: "top",
                            type: "error",
                            title: "Ingresa la fecha de cambio",
                            showConfirmButton: false,
                            timer: 3500
                            });
                         }
                    }
                    else{
                    swal({
                    position: "top",
                    type: "error",
                    title: "La linea de captura no es correcta debe tener 27 digitos",
                    showConfirmButton: false,
                    timer: 3500
                });
                    }
               }
               else{
                swal({
                    position: "top",
                    type: "error",
                    title: "Ingresa la linea de captura sin espacio de tu voucher",
                    showConfirmButton: false,
                    timer: 3500
                });
               }
            }
            else{
                swal({
                    position: "top",
                    type: "error",
                    title: "selecciona documento pdf",
                    showConfirmButton: false,
                    timer: 3500
                });
            }
            });
        });
        
        
    </script>

@endsection









































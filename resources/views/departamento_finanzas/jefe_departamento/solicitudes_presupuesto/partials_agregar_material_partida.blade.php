<form id="form_agregar_material_servicio" class="form" action="{{url("/presupuesto_autorizado/guardar_material_partida_solicitud/".$id_solicitud_partida)}}" role="form" method="POST" >
    {{ csrf_field() }}

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Ingresar el nombre del bien o servicio, etc.</label>
                <textarea class="form-control" id="bien_servicio" name="bien_servicio" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();" required></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa unidad de medida</label>
                <input class="form-control" id="unidad_medida" name="unidad_medida" type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" required></input>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa cantidad del bien o servicio, etc.</label>
                <input class="form-control" id="cantidad" name="cantidad" type="number" pattern="[0-9]+"  required></input>
            </div>
        </div>
    </div>
    <div class="row" style="display: none;" id="mostrar_precio">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa precio unitario de referencia con iva incluido</label>
                <input class="form-control" id="precio" name="precio" type="number" step=".01"  required></input>
            </div>
            <div id="pesos_precio">

            </div>
        </div>
    </div>
    <div class="row" id="mensaje_no_pre" style="display: none;">
        <div class="col-md-10 col-md-offset-1">
            <h4 style="color: red;">No alcanza el presupuesto dado</h4>
        </div>
    </div>
</form>
<div id="mostrar_cerrar" style="display: block">
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
</div>
   <div id="mostrar_guardar" style="display: none">
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button id="guardar_material_partida"  class="btn btn-primary" >Guardar</button>
        </div>
    </div>

<script>
    $(document).ready(function() {
        $("#cantidad").change(function (){
            var cantidad = event.target.value;
           if(cantidad != ''){
               $("#mostrar_precio").css("display","block");
           }else{
               $("#mostrar_precio").css("display","none");
           }
        });
        $("#precio").change(function (event) {
            var precio = event.target.value;
            if (isNaN(precio)) {
                alert("el precio debe ser un numero");
                $('#pesos_precio').empty();

            } else {
                var cantidad = $("#cantidad").val();

                var precio_total = cantidad*precio;
                var resto_presupuesto = {{ $resto_presupuesto }};
                if( precio_total <= resto_presupuesto){
                    $("#mensaje_no_pre").css("display","none");
                    $("#mostrar_guardar").css("display","block");
                    $("#mostrar_cerrar").css("display","none");
                    var p_precio = new Intl.NumberFormat("es-MX", {
                        style: "currency",
                        currency: "MXN"
                    }).format(precio);
                    $('#pesos_precio').empty();
                    $('#pesos_precio').append('<h2>' + p_precio + '</option>');
                }else {
                    $("#mensaje_no_pre").css("display","block");
                    $("#mostrar_guardar").css("display","none");
                    $("#mostrar_cerrar").css("display","block");
                }

            }
        });
        $("#guardar_material_partida").click(function (){

            var bien_servicio = $("#bien_servicio").val();
            if(bien_servicio != ''){
                var unidad_medida = $("#unidad_medida").val();
                if( unidad_medida != ''){

                    var cantidad = $("#cantidad").val();

                    if ( cantidad != ''){

                        var precio = $("#precio").val();
                        if ( precio != ''){

                            $("#form_agregar_material_servicio").submit();
                            $("#guardar_material_partida").attr("disabled", true);
                            swal({
                                position: "top",
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Ingresa precio unitario de referencia con iva incluido",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }

                    }else{
                        swal({
                            position: "top",
                            type: "error",
                            title: "Ingresa cantidad correcta",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Ingresa unidad de medida",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            }else{
                swal({
                    position: "top",
                    type: "error",
                    title: "Ingresar el nombre del bien o servicio",
                    showConfirmButton: false,
                    timer: 3500
                });
            }
        });

    });
</script>
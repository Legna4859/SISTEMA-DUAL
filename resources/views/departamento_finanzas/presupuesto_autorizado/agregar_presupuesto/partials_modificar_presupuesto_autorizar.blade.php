<form id="form_mod_mes_partida" class="form" action="{{url("/presupuesto_autorizado/guardar_mod_partida_mes_presupuesto/".$id_presupuesto_aut_copia."/".$id_mes)}}" role="form" method="POST" >
    {{ csrf_field() }}

    <div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4 style="text-align: center">Nombre de la partida: {{ $requisicion->clave_presupuestal}} {{ $requisicion->nombre_partida}}</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4 style="text-align: center">Nombre del mes: {{ $nombre_mes }}</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4 style="text-align: center">Presupuesto sobrante: ${{ number_format($presupuesto_sobrante, 2, '.', ',') }}</h4>
        <input class="form-control" id="presupuesto_sobrante" name="presupuesto_sobrante" type="hidden" value="{{ $presupuesto_sobrante }}"></input>
    </div>
</div>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="exampleInputEmail1">Seleccionar mes a dar presupesto</label>
            <select class="form-control  "placeholder="selecciona una Opcion" id="id_mes" name="id_mes" required>
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($meses as $mes)
                    <option value="{{$mes->id_mes}}" data-esta="{{$mes->mes }}">{{ $mes->mes }} </option>
                @endforeach
            </select>
            <br>
        </div>
    </div>
    <br>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label>Ingresa presupuesto a dar</label>
            <input class="form-control" id="presupuesto_dado" name="presupuesto_dado" type="presupuesto_dado" pattern="[0-9]+"  required></input>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div id="pesos_precio">

        </div>
    </div>
</div>
</form>
<script>
    $(document).ready(function() {
            $("#presupuesto_dado").change(function (event){
                    var presupuesto_dado= event.target.value;

                    if(isNaN(presupuesto_dado)){
                    alert( "el precio debe ser un numero");
                    $('#pesos_precio').empty();

                    }else {
                        var presupuesto_sobrante={{ $presupuesto_sobrante }};

                        if(presupuesto_dado > presupuesto_sobrante){
                            swal({
                                position: "top",
                                type: "error",
                                title: "No alcanza el presupuesto",
                                showConfirmButton: false,
                                timer: 3500
                            });
                            $('#pesos_precio').empty();
                        }
                        else{
                            var p_precio= new Intl.NumberFormat("es-MX", {
                                style: "currency",
                                currency: "MXN"
                            }).format(presupuesto_dado);
                            $('#pesos_precio').empty();
                            $('#pesos_precio').append('<h2>' + p_precio+ '</option>');
                        }
                        }
            });
    });
</script>
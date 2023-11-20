<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-warning">
            <h4 style="text-align: center;">AÑO: {{ $solicitud->year_presupuesto }} </h4>
            <h4 style="text-align: center;">NO. SOLICITUD: {{ $solicitud->numero_solicitud }} </h4>
            <h4 style="text-align: center;">NOMBRE DEL PROYECTO: {{ $solicitud->nombre_proyecto }} </h4>
            <h4 style="text-align: center">MES: {{ $solicitud->mes }}</h4>
        </div>
    </div>
</div>
<input class="form-control" id="id_solicitud" name="id_solicitud" type="hidden"  value="{{ $id_solicitud }}" required>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="exampleInputEmail1">Selecciona partida presupuestal</label>
            <select class="form-control  "placeholder="selecciona una Opcion" id="id_presupuesto_aut_copia" name="id_presupuesto_aut_copia" required>
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($partidas as $partida)
                    <option value="{{ $partida->id_presupuesto_aut_copia }}" data-esta="{{ $partida->nombre_partida }}">{{ $partida->clave_presupuestal }} {{ $partida->nombre_partida }} </option>
                @endforeach
            </select>
            <br>
        </div>
    </div>
    <br>
</div>


<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <div id="pesos_sobrante">

        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div id="pesos_presupuesto_dado">

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <label for="presupuesto_dar">Ingresar presupuesto a dar</label>
        <input class="form-control" id="presupuesto_dar" name="presupuesto_dar" type="number" step=".01" value="" required>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div id="pesos_presupuesto_dar">

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#id_presupuesto_aut_copia").change(function(e) {
            var id_presupuesto = e.target.value;
            var id_mes = {{ $solicitud->id_mes }};
            if(id_mes !== null ){
                $.get('/presupuesto_autorizado/ver_presupuesto_partida/' + id_presupuesto+'/'+id_mes,function(data){
                    var  presupuesto_sobrante = data;
                    var p_sobrante = new Intl.NumberFormat("es-MX", {
                        style: "currency",
                        currency: "MXN"
                    }).format(presupuesto_sobrante);
                    $('#pesos_sobrante').empty();
                    if(presupuesto_sobrante > 0){
                        $('#pesos_sobrante').append(' <div class="alert alert-success"><h5 style="text-align: center">Presupuesto sobrante<br>'+ p_sobrante + '</h5></div> ' +
                            ' <br>' +
                            '<input class="form-control required" id="id_estado_sobrante" name="id_estado_sobrante" value="1"  type="hidden"   />'+
                            '<input class="form-control required" id="presupuesto_s" name="presupuesto_s" value="'+presupuesto_sobrante+'" type="hidden" />');
                    }else{
                        $('#pesos_sobrante').append(' <div class="alert alert-danger"><h5 style="text-align: center">' + p_sobrante + '<br>No alcanza el presupuesto</h5></div>' +
                            ' <input class="form-control required" id="id_estado_sobrante" name="id_estado_sobrante" value="2" type="hidden" />');
                    }

                });
            }
        });

        $("#presupuesto_dar").change(function (event) {
            var p_dar = event.target.value;
            if (isNaN(p_dar)) {
                alert("el presupuesto debe ser un numero");
                $('#pesos_presupuesto_dar').empty();
            } else {
                var p_dar1 = new Intl.NumberFormat("es-MX", {
                    style: "currency",
                    currency: "MXN"
                }).format(p_dar);
                $('#pesos_presupuesto_dar').empty();
                $('#pesos_presupuesto_dar').append('<h2>' + p_dar1 + '</option>');
            }
        });

    });

</script>

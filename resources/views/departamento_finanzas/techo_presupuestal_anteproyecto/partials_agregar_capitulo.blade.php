
<form id="form_agregar_capitulo" class="form" action="{{url("/presupuesto_anteproyecto/techo_presupuestal/guardar_fuentes_financiamiento/".$proyecto->id_presupuesto )}}" role="form" method="POST" >
    {{ csrf_field() }}

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-warning">
                <h4 style="text-align: center;">AÑO: {{ $proyecto->year}} </h4>
                <h4 style="text-align: center;">NOMBRE DEL PROYECTO: {{ $proyecto->nombre_proyecto }} </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="dropdown">
                <label for="exampleInputEmail1">Selecciona capitulo</label>
                <select class="form-control  "placeholder="selecciona una Opcion" id="id_capitulo" name="id_capitulo" required>
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($capitulos as $capitulo)
                        <option value="{{ $capitulo->id_capitulo }}" data-esta="{{ $capitulo->capitulo }}">{{ $capitulo->capitulo }} </option>
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
                <label>Ingresa importe de fuente de financiamiento estatal </label>
                <input class="form-control" id="presupuesto_estatal"  name="presupuesto_estatal" type="number-only"   required />
                <div id="pesos_presupuesto_estatal">

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa importe de fuente de financiamiento federal</label>
                <input class="form-control" id="presupuesto_federal" name="presupuesto_federal" type="number-only"   required />
                <div id="pesos_presupuesto_federal">

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa importe de fuente de financiamiento propios </label>
                <input class="form-control" id="presupuesto_propios" name="presupuesto_propios" type="number-only"  required />
                <div id="pesos_presupuesto_propios">

                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready( function() {
       $("#presupuesto_estatal").change(function (event){
           var presupuesto_estatal_pesos= event.target.value;
           if(isNaN(presupuesto_estatal_pesos)){
               alert( "La cantidad de fuente de financiamiento estatal debe ser un numero");
               $('#pesos_presupuesto_estatal').empty();

           }else {
               var p_estatal_peso_mexicano = new Intl.NumberFormat("es-MX", {
                   style: "currency",
                   currency: "MXN"
               }).format(presupuesto_estatal_pesos);
               $('#pesos_presupuesto_estatal').empty();
               $('#pesos_presupuesto_estatal').append('<h2>' + p_estatal_peso_mexicano + '</option>');
           }
       });
        $("#presupuesto_federal").change(function (event){
            var presupuesto_federal_pesos= event.target.value;
            if(isNaN(presupuesto_federal_pesos)){
                alert( "La cantidad de fuente de financiamiento federal debe ser un numero");
                $('#pesos_presupuesto_federal').empty();

            }else {
                var p_federal_peso_mexicano = new Intl.NumberFormat("es-MX", {
                    style: "currency",
                    currency: "MXN"
                }).format(presupuesto_federal_pesos);
                $('#pesos_presupuesto_federal').empty();
                $('#pesos_presupuesto_federal').append('<h2>' + p_federal_peso_mexicano + '</option>');
            }
        });
        $("#presupuesto_propios").change(function (event){
            var presupuesto_propios_pesos= event.target.value;
            if(isNaN(presupuesto_propios_pesos)){
                alert( "La cantidad de fuente de financiamiento propios debe ser un numero");
                $('#pesos_presupuesto_propios').empty();

            }else {
                var p_propios_peso_mexicano = new Intl.NumberFormat("es-MX", {
                    style: "currency",
                    currency: "MXN"
                }).format(presupuesto_propios_pesos);
                $('#pesos_presupuesto_propios').empty();
                $('#pesos_presupuesto_propios').append('<h2>' + p_propios_peso_mexicano + '</option>');
            }
        });
    });
</script>

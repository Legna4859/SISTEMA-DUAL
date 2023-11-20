<form class="form" id="guardar_mod_no_oficio" action="{{url("/residencia/guardar_mod_no_oficio/".$profesor->id_asesores)}}" role="form" method="POST" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h4>No. cuenta: {{ $profesor->cuenta }} <br>
                Nombre del estudiante: {{  $profesor->nombre }} {{  $profesor->apaterno }}{{  $profesor->amaterno }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <div class="form-group">
                <div class="form-group">
                    <label for="asesor">Número de oficio</label>
                    <input class="form-control"  id="mod_numero_oficio" name="mod_numero_oficio" value="{{ $numero_oficio->numero_oficio }}"  placeholder="Ingresa el número de oficio"  onkeyup="javascript:this.value=this.value.toUpperCase();"  required>
                </div>
            </div>
        </div>
        <br>
    </div>
</form>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <h3>Número del folio titulo: {{  $folio_titulo->numero_titulo }}</h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="descripcion_oficio">Abreviatura del folio titulo</label>
            <input type="hidden" id="id_numero_titulo" name="id_numero_titulo" value="{{ $folio_titulo->id_numero_titulo }}">

            <input class="form-control" type="text" id="folio_titulo" name="folio_titulo" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{ $folio_titulo->abreviatura_folio_titulo }}" required>

        </div>
    </div>
</div>
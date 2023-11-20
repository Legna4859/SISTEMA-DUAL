
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <p style="text-align: center"><b>PROFESOR: {{ $profesor->nombre }}</b></p>

    </div>
</div>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <input type="hidden" class="form-control" id="id_personal"  name="id_personal" value="{{ $profesor->id_personal }}" required>
        <label>Ingresa cedula</label>
        <input type="int" class="form-control" id="cedula"  name="cedula" value="{{ $profesor->cedula }}" required>
        <br>
    </div>

</div>
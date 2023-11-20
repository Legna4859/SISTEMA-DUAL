<div class="row">
    <div class="col-md-3  col-md-offset-1">
        <div class="form-group">
            <label for="numero_acta_titulación">Número de la acta de titulación</label>
            <input class="form-control"   type="hidden"  id="id_acta_titulacion" name="id_acta_titulacion"  value="{{ $datos_acta->id_acta_titulacion }}"  required>

            <input class="form-control"   type="text"  id="numero_acta_titulacion" name="numero_acta_titulacion"  readonly value="{{ $datos_acta->numero_acta_titulacion }}"  required>

        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="numero_libro_acta_titulacion	">Número del libro de actas de titulación</label>
            <input class="form-control required" id="numero_libro_acta_titulacion" name="numero_libro_acta_titulacion" readonly value="{{ $datos_acta->numero_libro_acta_titulacion }}"  type="text"   value="" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="foja_acta_titulacion">Número de foja de la acta de titulación</label>
            <input class="form-control"   type="text"  id="foja_acta_titulacion" name="foja_acta_titulacion" readonly value="{{ $datos_acta->foja_acta_titulacion }}"    required>

        </div>
    </div>

</div>
<div class="row">

    <div class="col-md-5  col-md-offset-1">
        <div class="form-group">
            <label for="hora_conformidad_acta">Hora de conformidad de la acta  de titulación</label>
            <input id="hora_conformidad_acta" class="form-control time" type="time" value="{{ $datos_acta->hora_conformidad_acta }}" name="hora_conformidad_acta"  />
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for="hora_levantamiento_acta">Hora de levantamiento de la acta  de titulación</label>
            <input id="hora_levantamiento_acta" class="form-control time" type="time" value="{{ $datos_acta->hora_levantamiento_acta }}" name="hora_levantamiento_acta"  />
        </div>
    </div>


</div>


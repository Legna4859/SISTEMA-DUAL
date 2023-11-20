<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label for="descripcion_oficio">Nombre de la escuela</label>
                <input type="hidden" id="id_escuela" name="id_escuela" value="{{ $escuela[0]->id_escuela_procedencia }}">
                <textarea class="form-control" id="nombre_escuela" name="nombre_escuela" rows="3"  required>{{ $escuela[0]->nombre_escuela }}</textarea>
            </div>
        </div>
</div>
<div class="row" >
    <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label for="">Nombre del municipio</label>
                <input  class="form-control" type="text" id="municipio" name="municipio" value="{{ $escuela[0]->municipio}}" required>
            </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label for="descripcion_oficio">Nombre del Estado</label>
                <input  class="form-control" type="text" id="estado" name="estado" value="{{ $escuela[0]->estado}}" required>
            </div>
        </div>

</div>
<script type="text/javascript">
    $(document).ready( function() {

    });
</script>
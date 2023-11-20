
<div class="row" >
<div class="col-md-8 col-md-offset-2">
<p>NO. CUENTA: <b>{{ $alumno[0]->cuenta }}</b></p>
    <p>NOMBRE DEL ESTUDIANTE: <b>{{ $alumno[0]->nombre }} {{ $alumno[0]->apaterno }} {{ $alumno[0]->amaterno }}</b></p>
</div>
</div>

<form id="form_rechar_carta_presentcion" action="{{url("/servicio_social/envio_rechazar_cartapresentacion/")}}" class="form" role="form" method="POST">
    {{ csrf_field() }}
    <input type="hidden" id="id_constancia_presentacion_alumno" name="id_constancia_presentacion_alumno" value="{{ $constancia_presentacion[0]->id_constancia_presentacion_alumno }}">
    <input type="hidden" id="id_dat_alumn" name="id_dat_alumn" value="{{ $id_datos_alumnos }}">

    <div class="row" >
    <div class="col-md-8 col-md-offset-2">
        <div class="form-group">
            <label for="descripcion">Ingresa la correción que debe hacer en el documento el estudiante</label>
            <textarea class="form-control" id="comentario_carta" name="comentario_carta" rows="3" placeholder="Ingresa la correción que debe hacer en el documento el estudiante " style="" required></textarea>
        </div>
    </div>
</div>
</form>
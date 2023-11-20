<form class="form" action="{{url("/residencia/guardar_asesores_anteproyecto/")}}" role="form" method="POST" >
    {{ csrf_field() }}
<div class="row">

    <div class="col-md-6 col-md-offset-3">
        <input type="hidden" id="id_anteproyecto" name="id_anteproyecto" value="{{$id_anteproyecto}}">
        <div class="dropdown">
            <label for="selectPersonal">Profesores</label>
            <select class="form-control" id="selectPersonal" name="selectPersonal" >
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($plantillas as $plantilla)
                    <option value="{{$plantilla->id_personal}}"> {{$plantilla->nombre}}</option>
                @endforeach
            </select>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <input  type="submit" class="btn btn-primary" value="Guardar"/>
</div>
</form>
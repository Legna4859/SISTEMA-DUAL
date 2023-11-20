<form class="form" action="{{url("/residencia/modificacion_asesores_anteproyecto/")}}" role="form" method="POST" >
{{ csrf_field() }}
<div class="row">
    <input type="hidden" id="id_anteproyecto" name="id_anteproyecto" value="{{$asesores->id_anteproyecto}}">
    <div class="col-md-8 col-md-offset-2">
        <div class="form-group">
            <div class="dropdown">
                <label for="nivel_ingles">Nombre de los profesores</label>
                <select name="id_profesor" id="id_profesor" class="form-control " required>
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($plantillas as $plantilla)
                        @if($asesores->id_profesor==$plantilla->id_personal)
                            <option value="{{$plantilla->id_personal}}" selected="selected" >{{$plantilla->nombre}}</option>
                        @else
                            <option value="{{$plantilla->id_personal}}"> {{$plantilla->nombre }}</option>
                        @endif
                    @endforeach

                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <input  type="submit" class="btn btn-primary" value="Guardar"/>
</div>
</form>

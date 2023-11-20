<form id="form_modificar_meta" class="form" action="{{url("/presupuesto_anteproyecto/guardar_modificacion_meta/".$meta->id_meta)}}" role="form" method="POST" >
    {{ csrf_field() }}

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Agregar nombre de la meta</label>
                <textarea class="form-control" id="nombre_meta_mod" name="nombre_meta_mod" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();" required>{{ $meta->meta }}</textarea>


            </div>
        </div>
    </div>

</form>

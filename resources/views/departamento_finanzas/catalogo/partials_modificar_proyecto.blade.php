<form id="form_modificar_proyecto" class="form" action="{{url("/presupuesto_anteproyecto/guardar_modificacion_proyecto/".$proyecto->id_proyecto)}}" role="form" method="POST" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Agregar nombre del proyecto</label>
                <input class="form-control "   type="text"  id="nombre_proyecto_mod"  onkeyup="javascript:this.value=this.value.toUpperCase();" name="nombre_proyecto_mod" value="{{ $proyecto->nombre_proyecto }}"  >
            </div>
        </div>
    </div>

</form>


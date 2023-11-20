<form id="form_modificar_partida" class="form" action="{{url("/presupuesto_anteproyecto/guardar_modificacion_partida/".$partida->id_partida_pres)}}" role="form" method="POST" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Agregar clave de la partida presupuestal</label>
                <input class="form-control "   type="number"  id="clave_partida_mod" name="clave_partida_mod" value="{{ $partida->clave_presupuestal }}" >
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Agregar nombre de la partida presupuestal</label>
                <input class="form-control "   type="text"  id="nombre_partida_mod"  onkeyup="javascript:this.value=this.value.toUpperCase();" name="nombre_partida_mod" value="{{ $partida->nombre_partida }}"  >
            </div>
        </div>
    </div>

</form>


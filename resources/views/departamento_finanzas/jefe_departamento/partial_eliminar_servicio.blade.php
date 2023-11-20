<form id="form_mod_bien" class="form" action="{{url("/presupuesto_anteproyecto/guardar_eliminar_bien/".$servicio->id_reg_material_ant)}}" role="form" method="POST" >
    {{ csrf_field() }}
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>Descripcion del servicio o bien: <b>{{ $servicio->descripcion }}</b></h4>
        <h4>Unidad de medida: <b>{{ $servicio->unidad_medida }}</b></h4>
        <h4>Cantidad: <b>{{ $servicio->cantidad }}</b></h4>
        <h4>Precio unitario de referencia con IVA incluido: <b>{{ $servicio->precio_unitario }}</b></h4>
    </div>
</div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="alert alert-danger">
                <strong style="text-align: center">Seguro(a) que quieres eliminar el bien o servicio</strong>
            </div>
        </div>
    </div>
</form>
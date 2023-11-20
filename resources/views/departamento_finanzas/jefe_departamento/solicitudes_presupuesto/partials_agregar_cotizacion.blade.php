<form  id="form_guardar_cotizacion" action="{{url("/presupuesto_autorizado/guardar_cotizacion/".$id_solicitud)}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}

    <input class="form-control" id="estado_solicitud" name="estado_solicitud" type="hidden"  value="{{ $estado_solicitud }}" required>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <label>Seleccionar cotizacion</label>
                    <input class="form-control"  id="cotizacion_pdf" name="cotizacion_pdf" type="file"   accept="application/pdf" required/>
                </div>
            </div>
        </div>
    </div>
</form>
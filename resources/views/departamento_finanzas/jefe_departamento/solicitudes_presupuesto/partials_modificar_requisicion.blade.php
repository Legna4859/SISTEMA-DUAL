<form  id="form_guardar_mod_requisicion" action="{{url("/presupuesto_autorizado/guardar_requisicion/".$id_solicitud)}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}

    <input class="form-control" id="estado_solicitud" name="estado_solicitud" type="hidden"  value="{{ $estado_solicitud }}" required>
    <input class="form-control" id="id_solicitud_documento" name="id_solicitud_documento" type="hidden"  value="{{ $id_solicitud_documento}}" required>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <label>Seleccionar la requisición</label>
                    <input class="form-control"  id="requisicion_mod_pdf" name="requisicion_mod_pdf" type="file"   accept="application/pdf" required/>
                </div>
            </div>
        </div>
    </div>
</form>
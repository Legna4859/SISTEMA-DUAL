<form  id="form_guardar_mod_anexo1" action="{{url("/presupuesto_autorizado/guardar_anexo1/".$id_solicitud)}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}
    <input class="form-control" id="id_solicitud_documento" name="id_solicitud_documento" type="hidden"  value="{{ $id_solicitud_documento}}" required>
    <input class="form-control" id="estado_solicitud" name="estado_solicitud" type="hidden"  value="{{ $estado_solicitud }}" required>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <label>Seleccionar anexo 1</label>
                    <input class="form-control"  id="anexo_mod_pdf" name="anexo_mod_pdf" type="file"   accept="application/pdf" required/>
                </div>
            </div>
        </div>
    </div>
</form>
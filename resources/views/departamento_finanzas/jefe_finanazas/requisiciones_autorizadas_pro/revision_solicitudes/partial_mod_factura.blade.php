<form  id="form_guardar_mod_factura" action="{{url("/presupuesto_autorizado/guardar_factura/".$documentos->id_solicitud_documento)}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}


    <div class="row" >
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <label>Selecciona la factura</label>
                    <input class="form-control"  id="doc_factura" name="doc_factura" type="file"   accept="application/pdf" required/>
                </div>
            </div>
        </div>
    </div>
</form>
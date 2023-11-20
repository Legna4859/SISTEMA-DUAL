<form  id="form_guardar_solicitud_pago" action="{{url("/presupuesto_autorizado/guardar_solicitud_pago/".$documentos->id_solicitud_documento)}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}


    <div class="row" >
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <label>Selecciona documento pdf de la solicitud de pago</label>
                    <input class="form-control"  id="doc_solicitud_pago" name="doc_solicitud_pago" type="file"   accept="application/pdf" required/>
                </div>
            </div>
        </div>
    </div>
</form>

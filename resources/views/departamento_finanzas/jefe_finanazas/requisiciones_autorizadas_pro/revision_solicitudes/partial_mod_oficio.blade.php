<form  id="form_guardar_mod_oficio" action="{{url("/presupuesto_autorizado/guardar_oficio/".$documentos->id_solicitud_documento)}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}


    <div class="row" >
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <label>Selecciona documento pdf del oficio de entrega</label>
                    <input class="form-control"  id="doc_oficio" name="doc_oficio" type="file"   accept="application/pdf" required/>
                </div>
            </div>
        </div>
    </div>
</form>

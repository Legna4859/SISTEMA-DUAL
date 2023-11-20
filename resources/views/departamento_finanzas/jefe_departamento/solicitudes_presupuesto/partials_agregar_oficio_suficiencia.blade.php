<form  id="form_guardar_suficiencia" action="{{url("/presupuesto_autorizado/guardar_suficiencia/".$id_solicitud)}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}

    <input class="form-control" id="estado_solicitud" name="estado_solicitud" type="hidden"  value="{{ $estado_solicitud }}" required>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <label>Seleccionar oficio de suficiencia pdf</label>
                    <input class="form-control"  id="suficiencia_pdf" name="suficiencia_pdf" type="file"   accept="application/pdf" required/>
                </div>
            </div>
        </div>
    </div>
</form>
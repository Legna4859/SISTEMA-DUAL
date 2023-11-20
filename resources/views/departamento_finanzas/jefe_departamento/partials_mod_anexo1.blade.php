<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>PARTIDA PRESUPUESTAL: {{ $requisicion->clave_presupuestal }}  {{ $requisicion->nombre_partida }}</h4>
        <h4>MES Y AÑO DE ADQUISICIÓN: {{ $requisicion->mes }}</h4>
        <h4>PROYECTO: {{ $requisicion->nombre_proyecto }}</h4>
        <h5>META: {{ $requisicion->meta }}</h5>
    </div>
</div>
<form  id="form_guardar_mod_anexo1_pdf" action="{{url("/presupuesto_anteproyecto/guardar_mod_anexo1_pdf/".$requisicion->id_actividades_req_ante)}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <label>Seleccionar anexo 1</label>
                    <input class="form-control"  id="mod_anexo1_pdf" name="mod_anexo1_pdf" type="file"   accept="application/pdf" required/>
                </div>
            </div>
        </div>
    </div>
</form>

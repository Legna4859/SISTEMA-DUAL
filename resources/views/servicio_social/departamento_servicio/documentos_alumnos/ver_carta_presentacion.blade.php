<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <p><b>No. Cuenta: </b> {{$registro[0]->cuenta}}  <b>      Nombre del alumno:</b> {{$registro[0]->nombre}} {{$registro[0]->apaterno}} {{$registro[0]->amaterno}}</p>
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <label>Ver  Carta de Presentación-Aceptación</label>
        <a  target="_blank" href="{{asset('/servicio_social_pdf/carta_presentacion/'.$datos_constancia[0]->pdf_constancia_presentacion)}}" class="btn btn-primary "><i class="glyphicon glyphicon glyphicon-file"></i></a>
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <p><b>Nombre del Periodo: </b>  {{$datos_constancia[0]->periodo}}</p>

    </div>
</div>
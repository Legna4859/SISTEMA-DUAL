<form id="form_activar_proyecto" class="form" action="{{url("/presupuesto_anteproyecto/guardar_activacion_proyecto/".$proyecto->id_proyecto)}}" role="form" method="POST" >
    {{ csrf_field() }}
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4 style="text-align: center">NOMBRE DEL PROYECTO:{{ $proyecto->nombre_proyecto }}</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h2 style="text-align: center">Desea activar el proyecto</h2>
    </div>
</div>
</form>
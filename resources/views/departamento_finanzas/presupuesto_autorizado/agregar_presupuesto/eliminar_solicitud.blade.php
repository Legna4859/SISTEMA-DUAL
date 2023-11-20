<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p>NÚMERO DE SOLICITUD:<b>{{ $solicitud->numero_solicitud }}</b> </p>
                <p>DEPARTAMENTO O JEFATURA: <b> {{ $solicitud->nom_departamento }}</b> </p>
                <p>NOMBRE DEL PROYECTO:  <b>{{ $solicitud->nombre_proyecto }}</b> </p>
                <p>AÑO DEL PRESUPUESTO:  <b>{{ $solicitud->year_presupuesto }}</b></p>
                <p>DESCRIPCIÓN DE SOLICITUD: <b>{{ $solicitud->descripcion_solicitud }}</b> </p>

            </div>
        </div>
    </div>
</div>
<form id="form_guardar_eliminacion_solicitud" class="form" action="{{url("/presupuesto_autorizado/guardar_eliminacion_solicitud/".$solicitud->id_solicitud)}}" role="form" method="POST" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h4 style="text-align: center">¿Segura (o) que quiere eliminar la solicitud?</h4>
        </div>
    </div>
</form>



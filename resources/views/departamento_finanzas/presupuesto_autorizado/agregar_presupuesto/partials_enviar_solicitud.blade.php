<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p>NÚMERO DE SOLICITUD:<b>{{ $solicitud->numero_solicitud }}</b> </p>
        <p>DEPARTAMENTO O JEFATURA: <b> {{ $solicitud->nom_departamento }}</b> </p>
        <p>NOMBRE DEL PROYECTO:  <b>{{ $solicitud->nombre_proyecto }}</b> </p>
                <p>AÑO DEL PRESUPUESTO:  <b>{{ $solicitud->year_presupuesto }}</b></p>
                <p>DESCRIPCIÓN DE LA SOLICITUD: <b>{{ $solicitud->descripcion_solicitud }}</b> </p>

            </div>
        </div>
    </div>
</div>
<form id="form_enviar_partida_solicitud" class="form" action="{{url("/presupuesto_autorizado/guardar_enviar_solicitud/".$solicitud->id_solicitud)}}" role="form" method="POST" >
    {{ csrf_field() }}
    <input class="form-control" id="contar_req" name="contar_req" type="hidden"  value="{{ $contar_req }}" required>
    <input class="form-control" id="presupuesto_dado" name="presupuesto_dado" type="hidden"  value="{{ $presupuesto_dado }}" required>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
     <h4 style="text-align: center">¿Segura (o) que quiere enviar la solicitud?</h4>
    </div>
</div>
</form>
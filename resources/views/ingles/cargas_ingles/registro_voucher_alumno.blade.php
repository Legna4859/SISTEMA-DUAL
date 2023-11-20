<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <p>No. Cuenta: {{ $alumno->cuenta }}</p>
        <p>Nombre del usuario: {{ $alumno->nombre }} {{ $alumno->apaterno }} {{ $alumno->amaterno }}</p>
    </div>
</div>
<form id="form_enviar_registro" class="form" action="{{url("/ingles/guardar_reg_alumno_excel_voucher/".$alumno->id_voucher)}}" role="form" method="POST" >
    {{ csrf_field() }}

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <p>Desea agregar este usuario pendiente al excel para descargar</p>
    </div>
</div>
</form>
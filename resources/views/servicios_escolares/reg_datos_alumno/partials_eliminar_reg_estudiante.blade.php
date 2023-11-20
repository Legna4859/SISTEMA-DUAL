
<form  id="form_guardar_eliminar_sem" action="{{url("/servicios_escolares/guardar_eliminar_semestre_al/".$alumno->id_semestres_al)}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>NO. CUENTA: {{ $alumno->cuenta }}</h4>
        <h4>NOMBRE DEL ESTUDIANTE: {{$alumno->nombre}} {{$alumno->apaterno}} {{$alumno->amaterno}}</h4>
        <h3>¿Seguro(a) que quieres eliminar al estudiante?</h3>
    </div>

</div>
</form>
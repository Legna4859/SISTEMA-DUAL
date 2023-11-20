<form  id="form_guardar_desactivar_est" action="{{url("/servicios_escolares/guardar_desactivar_estudiante/".$alumno->id_alumno)}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h4>NO. CUENTA: {{ $alumno->cuenta }}</h4>
            <h4>NOMBRE DEL ESTUDIANTE: {{$alumno->nombre}} {{$alumno->apaterno}} {{$alumno->amaterno}}</h4>
            <h3>¿Seguro(a) que quieres desactivar al estudiante?</h3>
        </div>

    </div>
</form>
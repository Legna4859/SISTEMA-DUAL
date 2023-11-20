<form  id="form_autorizar_semestre" action="{{url("/servicios_escolares/guardar_autorizar_semestre_al/".$id_semestres_al)}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <h3>¿Seguro(a) que quieres autorizar el semestre y periodo que el estudiante ingreso al TESVB?</h3>
        </div>

    </div>
</form>
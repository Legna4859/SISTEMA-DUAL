<form  id="form_guardar_activar_periodo" action="{{url("/servicios_escolares/guardar_activar_periodo/".$periodo->id_periodos_sem_act)}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h4>PERIODO: {{ $periodo->periodo }}</h4>
            <h4>¿Seguro(a) que quieres activar el periodo?</h4>
        </div>

    </div>
</form>
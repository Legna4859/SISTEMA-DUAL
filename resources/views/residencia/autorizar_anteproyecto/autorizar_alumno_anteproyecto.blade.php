<form class="form" action="{{url("/residencia/autorizacion_anteproyecto/")}}" role="form" method="POST" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="text-align: center">
           <p>NO.  DE CUENTA: {{ $anteproyecto[0]->cuenta }}</p>
            <p>NOMBRE DEL ALUMNO: {{ $anteproyecto[0]->alumno }} {{ $anteproyecto[0]->apaterno }} {{ $anteproyecto[0]->amaterno }}</p>
        </div>
    </div>
    <div class="row">
        <input type="hidden" id="id_anteproyecto" name="id_anteproyecto" value="{{ $anteproyecto[0]->id_anteproyecto }}">
        <div class="col-md-6 col-md-offset-3">
            <button type="submit" class="btn btn-primary">Autorizar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

        </div>

    </div>
</form>
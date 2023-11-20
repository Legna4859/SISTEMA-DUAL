<form  id="form_guardar_mod_semestre" action="{{url("/servicios_escolares/guardar_mod_semestre_al/".$datos_actu->id_semestres_al)}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="exampleInputEmail1">Selecciona periodo que ingreso el estudiante al TESVB </label>
            <select class="form-control  "placeholder="selecciona una Opcion" id="mod_id_periodo" name="mod_id_periodo" required>
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($periodos as $periodo)
                    @if($periodo->id_periodo==$datos_actu->id_periodo)
                        <option value="{{$periodo->id_periodo}}" selected="selected" >{{$periodo->periodo}}</option>
                    @else
                        <option value="{{$periodo->id_periodo}}"> {{$periodo->periodo}}</option>
                    @endif
                @endforeach
            </select>
            <br>
        </div>
    </div>
    <br>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="exampleInputEmail1">Selecciona semestre que ingreso el estudiante al TESVB </label>
            <select class="form-control  "placeholder="selecciona una Opcion" id="mod_id_semestre" name="mod_id_semestre" required>
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($semestres as $semestre)
                    @if($semestre->id_semestre==$datos_actu->id_semestre)
                        <option value="{{$semestre->id_semestre}}" selected="selected" >{{$semestre->descripcion}}</option>
                    @else
                        <option value="{{$semestre->id_semestre}}"> {{$semestre->descripcion}}</option>
                    @endif
                @endforeach
            </select>
            <br>
        </div>
    </div>
    <br>
</div>
</form>
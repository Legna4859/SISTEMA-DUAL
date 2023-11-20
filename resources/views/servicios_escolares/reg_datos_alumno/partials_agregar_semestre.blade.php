<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>NO. CUENTA: {{ $alumno->cuenta }}</h4>
        <h4>NOMBRE DEL ESTUDIANTE: {{$alumno->nombre}} {{$alumno->apaterno}} {{$alumno->amaterno}}</h4>

    </div>
</div>
<form  id="form_guardar_semestre" action="{{url("/servicios_escolares/guardar_semestre_al/".$alumno->id_alumno."/1")}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="dropdown">
                <label for="exampleInputEmail1">Selecciona periodo que ingreso el estudiante</label>
                <select class="form-control  "placeholder="selecciona una Opcion" id="id_periodo" name="id_periodo" required>
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($periodos as $periodo)
                        <option value="{{$periodo->id_periodo}}" data-esta="{{$periodo->periodo }}">{{ $periodo->periodo }} </option>
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
                <label for="exampleInputEmail1">Selecciona semestre que ingreso</label>
                <select class="form-control  "placeholder="selecciona una Opcion" id="id_semestre" name="id_semestre" required>
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($semestres as $semestre)
                        <option value="{{$semestre->id_semestre}}" data-esta="{{$semestre->descripcion }}">{{ $semestre->descripcion }} </option>
                    @endforeach
                </select>
                <br>
            </div>
        </div>
        <br>
    </div>

</form>
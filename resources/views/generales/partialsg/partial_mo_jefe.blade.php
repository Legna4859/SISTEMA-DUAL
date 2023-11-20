@section('modifica_jefatura')

<main>
<div class="modal fade" id="modal_modifica" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Modificación Jefaturas de División</h4>
      </div>
      <div class="modal-body">
<form class="form-horizontal" role="form" method="POST" action="/generales/jefaturas/{{ $jefe_edit->id_jefe_periodo }}" novalidate>
  <input type="hidden" name="_method" value="PUT" />
          {{ csrf_field() }}
<div class="row">
              <div class="col-md-12">
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group"> 
                <label for="selectCarrera">Carrera</label> 
                <select name="selectCarrera" class="form-control ">
                <option disabled selected>Elige...</option>
                  @foreach($carreras as $carrera)
                  @if($carrera->id_carrera==$jefe_edit->id_carrera)
                  <option value="{{ $carrera->id_carrera }}" selected="selected">{{ $carrera->nombre }}</option>
                  @else
                  <option value="{{ $carrera->id_carrera }}">{{ $carrera->nombre }}</option>
                  @endif
                  @endforeach
                </select> 
            </div>
        </div>
            </div>
            <div class="col-md-12">
                      <div class="col-md-5 cont">
            <div class="form-group"> 
                <label for="selectPersonal">Personal</label> 
                <select name="selectPersonal" class="form-control ">
                <option disabled selected>Elige...</option>
                  @foreach($docentes as $docente)
                  @if($docente->id_personal==$jefe_edit->id_personal)
                  <option value="{{ $docente->id_personal }}" selected="selected">{{ $docente->nombre }}</option>
                  @else
                  <option value="{{ $docente->id_personal }}">{{ $docente->nombre }}</option>
                  @endif
                  @endforeach
                </select> 
            </div>
        </div>
                                      <div class="col-md-4 col-md-offset-1">
            <div class="form-group"> 
                <label for="selectCargo">Cargo</label> 
                <select name="selectCargo" class="form-control ">
                <option disabled selected>Elige...</option>
                @if($jefe_edit->tipo_cargo==1)
                  <option value="1" selected="selected">JEFE</option>
                  <option value="2">ENCARGADO</option>
                @else
                  @if($jefe_edit->tipo_cargo==2)
                  <option value="2" selected="selected">ENCARGADO</option>
                  <option value="1">JEFE</option>
                  @else
                  <option value="1">JEFE</option>
                  <option value="2">ENCARGADO</option>
                  @endif
                @endif
                </select> 
            </div>
        </div>
            </div>
            <div class="col-md-12">
                                <div class="col-md-8 col-md-offset-2">
              <div class="form-group">
                  <label for="nombre_periodo">Periodo</label>
                  <input disabled type="text" class="form-control" name="nombre_periodo" value="{{ $periodo }}">
              </div>
          </div>
            </div>
</div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" href="" id="modifica_situacion">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
      </form>
    </div>
  </div>
</div>
</main>

<script>
  $(document).ready(function(){

    $("#modal_modifica").modal("show");

  });

</script>

@endsection
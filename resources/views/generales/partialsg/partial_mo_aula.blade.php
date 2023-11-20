@section('modifica_aula')

<main>
<div class="modal fade" id="modal_modifica" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Modificación de Aulas</h4>
      </div>
      <div class="modal-body">
<form class="form-horizontal" role="form" method="POST" action="/generales/aulas/{{ $aula_edit->id_aula }}" novalidate>
  <input type="hidden" name="_method" value="PUT" />
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-5 cont">
                <div class="form-group">
                    <label for="nombre_aula">Nombre del Aula</label>
                    <input type="text" value="{{ $aula_edit->nombre }}" class="form-control" id="caja-error" name="nombre_aula" placeholder="Nombre..." style="text-transform:uppercase">
                    @if($errors -> has ('nombre_aula'))
                        <span style="color:red;">{{ $errors -> first('nombre_aula') }}</span>
                        <style>
                        #caja-error
                        {
                          border:solid 1px red;
                        }
                        </style>
                    @endif
                </div>
              </div>
                                    <div class="col-md-5" >
                        <div class="btn-group">
                          <label for="selectEstado">Estado</label>
                                <select name="selectEstado" class="form-control ">
                                  <option disabled selected>Selecciona...........</option>
                                    @if($aula_edit->comp==1)
                                      <option value="1" selected="selected">Compartida</option>
                                      <option value="0">No Compartida</option>
                                      @else
                                        @if($aula_edit->comp==0)
                                          <option value="0" selected="selected">No Compartida</option>
                                          <option value="1">Compartida</option>
                                          @endif
                                    @endif
                                </select>
                        </div>
                      </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-5 cont" >
                        <div class="btn-group">
                          <label for="selectEdificio">Edificio</label>
                                <select name="selectEdificio" class="form-control ">
                                  <option disabled selected>Selecciona...</option>
                                    @foreach($edificios as $edificio)
                                      @if($aula_edit->id_edificio==$edificio->id_edificio)
                                            <option value="{{$edificio->id_edificio}}" selected="selected">{{$edificio->nombre}}</option>
                                      @else
                                      <option value="{{$edificio->id_edificio}}">{{$edificio->nombre}}</option>
                                      @endif
                                    @endforeach
                                </select>
                        </div>
                      </div>
                      <div class="col-md-5" >
                        <div class="btn-group">
                          <label for="dropdown">Carrera</label>
                                <select name="selectCarrera" class="form-control ">
                                  <option disabled selected>Selecciona...</option>
                                    @foreach($carreras as $carrera)
                                    @if($aula_edit->id_carrera==$carrera->id_carrera)
                                            <option value="{{$carrera->id_carrera}}" selected="selected">{{$carrera->nombre}}</option>
                                      @else
                                        <option value="{{$carrera->id_carrera}}" >{{$carrera->nombre}}</option>
                                    @endif
                                    @endforeach
                                </select>
                        </div>
                      </div> 
            </div>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="modifica_situacion">Guardar</button>
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
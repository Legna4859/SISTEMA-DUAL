@section('modifica_cargo')

<main>
<div class="modal fade" id="modal_modifica" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Modificación Cargo</h4>
      </div>
      <div class="modal-body">
<form class="form-horizontal" role="form" method="POST" action="/generales/cargos/{{ $cargo_edit->id_cargo }}" novalidate>
  <input type="hidden" name="_method" value="PUT" />
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-12">
                          <div class="col-md-6 col-md-offset-1">
                     <div class="form-group">
                      <label for="nombre_cargo">Descripción</label>
                      <input type="text" value="{{ $cargo_edit->cargo }}" class="form-control " id="caja-error1" name="nombre_cargo" placeholder="Nombre..." style="text-transform:uppercase">
                      @if($errors -> has ('nombre_cargo'))
                          <span style="color:red;">{{ $errors -> first('nombre_cargo') }}</span>
                         <style>
                          #caja-error1
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
            </div>
                              <div class="col-md-3 col-md-offset-1">
                    <div class="form-group">
                      <label for="nombre_abrevia">Abreviatura</label>
                      <input type="text" value="{{ $cargo_edit->abre }}" class="form-control" maxlength="5" id="caja-error" name="nombre_abrevia" placeholder="Abreviacion..." style="text-transform:uppercase">
                     @if($errors -> has ('nombre_abrevia'))
                          <span style="color:red;">{{ $errors -> first('nombre_abrevia') }}</span>
                         <style>
                          #caja-error
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div>          
            </div>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" href="" id="modifica_cargo">Guardar</button>
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
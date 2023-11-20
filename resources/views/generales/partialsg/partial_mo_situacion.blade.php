@section('modifica_situacion')

<main>
<div class="modal fade" id="modal_modifica" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Modificación Situación Profesional</h4>
      </div>
      <div class="modal-body">
<form class="form-horizontal" role="form" method="POST" action="/generales/situaciones/{{ $situacion_edit->id_situacion }}" novalidate>
  <input type="hidden" name="_method" value="PUT" />
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-12">
                          <div class="col-md-6 col-md-offset-1">
                     <div class="form-group">
                      <label for="nombre_situacion">Descripción</label>
                      <input type="text" value="{{ $situacion_edit->situacion }}" class="form-control " id="caja-error" name="nombre_situacion" placeholder="Nombre..." style="text-transform:uppercase">
                      @if($errors -> has ('nombre_situacion'))
                          <span style="color:red;">{{ $errors -> first('nombre_situacion') }}</span>
                         <style>
                          #caja-error
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
            </div>          
                  <div class="col-md-3 col-md-offset-1">
                    <div class="form-group">
                      <label for="abre_situacion">Abreviatura</label>
                      <input type="text" value="{{ $situacion_edit->abrevia }}" class="form-control" maxlength="5" id="caja-error" name="abre_situacion" placeholder="Abreviacion..." style="text-transform:uppercase">
                     @if($errors -> has ('abre_situacion'))
                          <span style="color:red;">{{ $errors -> first('abre_situacion') }}</span>
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
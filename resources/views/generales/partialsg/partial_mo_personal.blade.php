@section('modifica_personal')

<main>
<div class="modal fade" id="modal_modifica" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Modificación Tipo de Personal</h4>
      </div>
      <div class="modal-body">
<form class="form-horizontal" role="form" method="POST" action="/generales/personales/{{ $personal_edit->id_tipo_personal }}" novalidate>
  <input type="hidden" name="_method" value="PUT" />
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-12">
                          <div class="col-md-10 col-md-offset-1">
                     <div class="form-group">
                      <label for="nombre_personal">Descripción</label>
                      <input type="text" value="{{ $personal_edit->descripcion }}" class="form-control " id="caja-error" name="nombre_personal" placeholder="Nombre..." style="text-transform:uppercase">
                      @if($errors -> has ('nombre_personal'))
                          <span style="color:red;">{{ $errors -> first('nombre_personal') }}</span>
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
        <button type="submit" class="btn btn-primary" href="" id="modifica_personal">Guardar</button>
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
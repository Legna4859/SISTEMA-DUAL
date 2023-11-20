@section('modifica_carrera')

<main>
<div class="modal fade" id="modal_modifica" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Modificación Carreras</h4>
      </div>
      <div class="modal-body">
<form class="form-horizontal" role="form" method="POST" action="/generales/carreras/{{ $carrera_edit->id_carrera }}" novalidate>
  <input type="hidden" name="_method" value="PUT" />
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-12">
                          <div class="col-md-6 col-md-offset-1">
                     <div class="form-group">
                      <label for="nombre_carrera">Descripción</label>
                      <input type="text" value="{{ $carrera_edit->nombre }}" class="form-control " id="caja-error1" name="nombre_carrera" placeholder="Nombre..." style="text-transform:uppercase">
                      @if($errors -> has ('nombre_carrera'))
                          <span style="color:red;">{{ $errors -> first('nombre_carrera') }}</span>
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
                      <label for="color">Color</label>
                     <div id="cp1" class="input-group colorpicker-component">
                        <input name="color" type="text" value="{{ $carrera_edit->COLOR }}"class="form-control" style="text-transform:uppercase" />
                        <span class="input-group-addon"><i></i></span>
                      </div>
                     @if($errors -> has ('color'))
                          <span style="color:red;">{{ $errors -> first('color') }}</span>
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
        <button type="submit" class="btn btn-primary" href="" id="modifica_carrera">Guardar</button>
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
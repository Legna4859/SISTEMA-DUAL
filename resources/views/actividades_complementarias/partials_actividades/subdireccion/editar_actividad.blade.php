@section('editar_actividad')

<main class="col-md-12">
  <div class="row">
    <div class="col-md-12 col-md-offset-1">
      <div class="modal fade" id="modal_edit_activad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
              <h3 class="modal-title text-center" id="myModalLabel">Modificación de Actividad</h3>
          </div>
            <div class="modal-body">
              <div class="panel panel-info">
                <div class="panel-body">

                  <form class="form-horizontal" id="modificar_actividad" role="form" method="POST" action="/nueva_actividad/{{ $actividad->id_actividad_comple}}" novalidate>
                    <input type="hidden" name="_method" value="PUT" />
                      {{csrf_field()}} 

                        <div class="col-md-12" >
                          <div class="col-md-5" >
                            <div class="form-group">
                              <label >Nombre de Actividad</label>
                                <input class="form-control" id="" type="text" value="{{$actividad->descripcion}}" name="actividad_sub">
                            </div>      
                          </div>

                          <div class="col-md-6 col-md-offset-1">
                            <div class="form-group">
                              <label >Categoría</label>
                                <div class="dropdown">
                                  <select class="form-control" name="categoria_sub">
                                    <option disabled selected hidden> Selecciona Opción...</option>
                                      @foreach($categorias as $categoria)
                                        @if($actividad->id_categoria==$categoria->id_categoria)
                                          <option value="{{$categoria->id_categoria}}" selected="selected">{{$categoria->descripcion_cat}}</option>
                                          @else
                                          <option value="{{$categoria->id_categoria}}">{{$categoria->descripcion_cat}}</option>
                                          @endif
                                      @endforeach
                                  </select>
                                </div>
                            </div>
                          </div>
                        </div>


                        <div class="col-md-12" >
                          <div class="col-md-5">
                            <div class="form-group">
                              <label >Número de Horas</label>
                                <div class="dropdown">
                                  <select class="form-control" name="horas_sub">
                                    <option disabled selected hidden>Selecciona Opción...</option>
                                      @if($actividad->horas==20)
                                        <option value="20" selected="selected">20</option>
                                        <option value="40">40</option> 
                                      @else
                                        <option value="40" selected="selected">40</option> 
                                        <option value="20">20</option>
                                      @endif  
                                  </select>
                              </div>
                            </div>
                          </div>


                          <div class="col-md-6 col-md-offset-1">
                            <div class="form-group">
                              <label >Departamento Encargado</label>
                                <div class="dropdown">
                                  <select class="form-control" name="jefatura_sub">
                                    <option disabled selected hidden>Selecciona Opción...</option>
                                      @foreach($jefaturascar as $jefatura)
                                        @if($actividad->id_jefatura==$jefatura->id_jefatura)
                                           <option value="{{$jefatura->id_jefatura}}" selected="selected">{{$jefatura->nom_jefatura}}</option>
                                        @else
                                           <option value="{{$jefatura->id_jefatura}}">{{$jefatura->nom_jefatura}}</option>
                                        @endif
                                      @endforeach
                                  </select>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="modal-footer" >
                          <button type="submit" class="btn btn-primary" href="" id="modificaact_sub">Guardar</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>


<script>
  $(document).ready(function(){

    $("#modal_edit_activad").modal("show");

  $("#modificaact_sub").click(function(event){
    
    $("#modificar_actividad").submit();
        
        });

          $("#modificar_actividad").validate({
            rules:{
              actividad_sub:
              {
                required: true,
                minlength: 8
              },
              categoria_sub:"required",
              horas_sub:"required",
              jefatura_sub:"required",
            },


      });


  });   
</script>
@endsection
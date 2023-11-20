@section('editar_docente')

<main class="col-md-12">
  <div class="row">
    <div class="col-md-12 col-md-offset-1">
      <div class="modal fade" id="modal_edit_docente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
              <h3 class="modal-title text-center" id="myModalLabel">Modificación de Docente</h3>
          </div>
            <div class="modal-body">
              <div class="panel panel-info">
                <div class="panel-body">

                  <form class="form-horizontal" id="modificar_docente" role="form" method="POST" action="/docente_actividad/{{ $doce->id_docente_actividad}}" novalidate>
                    <input type="hidden" name="_method" value="PUT" />
                      {{csrf_field()}}  

                            <div class="col-md-12">
                              <div class="col-md-5">
                                 <div class="form-group">
                                   <label >Actividad</label>
                                     <div class="dropdown">
                                       <select class="form-control" name="actividad_docente" id="actividad_docente">
                                           <option disabled selected hidden>Selecciona Opción...</option>
                                            @foreach($actividades as $actividades)
                                              @if($doce->id_actividad_comple==$actividades->id_actividad_comple)
                                              <option value="{{$actividades->id_actividad_comple}}" selected="selected">{{$actividades->descripcion}}</option>
                                              @else
                                              <option value="{{$actividades->id_actividad_comple}}">{{$actividades->descripcion}}</option>
                                              @endif
                                            @endforeach
                                        </select>
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-6 col-md-offset-1">
                                <div class="form-group">
                                  <label >Docente Asignado</label>
                                    <div class="dropdown">
                                      <select class="form-control" name="docente">
                                        <option disabled selected hidden>Selecciona Opción...</option>
                                          @foreach($docentes as $docentes)
                                            @if($doce->id_personal==$docentes->id_personal)
                                              <option value="{{$docentes->id_personal}}" selected="selected">{{$docentes->titulo}} {{$docentes->nombre}}</option>
                                            @else
                                              <option value="{{$docentes->id_personal}}">{{$docentes->titulo}} {{$docentes->nombre}}</option>
                                            @endif
                                          @endforeach
                                      </select>
                                    </div>
                                </div>
                              </div>
                          </div>
                        </form>
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer" >
                      <button type="submit" class="btn btn-primary" id="modifica_docente" href="">Guardar</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
</main>


<script>
  $(document).ready(function(){
    $("#modal_edit_docente").modal("show");

  $("#modifica_docente").click(function(event){
    
    $("#modificar_docente").submit();
        
        });

          $("#modificar_docente").validate({
            rules:{
              actividad_docente:"required",
              docente: "required",
            },
      });
  });   
</script>
@endsection
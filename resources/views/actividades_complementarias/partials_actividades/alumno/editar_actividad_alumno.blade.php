@section('editar_actalu')

<main class="col-md-12">
  <div class="row">
    <div class="col-md-12 col-md-offset-1">
      <div class="modal fade" id="modal_edit_actalu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
              <h3 class="modal-title text-center" id="myModalLabel">Modificar Actividad</h3>
          </div>
            <div class="modal-body">
              <div class="panel panel-info">
                <div class="panel-body">

                  <form class="form-horizontal" id="modificar_actalu" role="form" method="POST" action="/consulta_actividades/{{ $editar_actalu->id_registro_alumno}}" novalidate>
                    <input type="hidden" name="_method" value="PUT" />
                      {{csrf_field()}}  

                            <div class="col-md-12">
                              <div class="col-md-6">
                                 <div class="form-group">
                                   <label >Actividad</label>
                                     <div class="dropdown">
                                      <select class="form-control" name="actividad_alumnos" id="actividad_alumnos">
                                        <option disabled selected hidden>Selecciona Opción...</option>
                                          @foreach($docente_actividad as $docente_actividad)
                                            @if($editar_actalu->id_docente_actividad==$docente_actividad->id_docente_actividad)
                                              <option selected="selected" value="{{$docente_actividad->id_actividad_comple}}" data-horas="{{$docente_actividad->horas}}" data-docente="{{$docente_actividad->titulo}}  {{$docente_actividad->nombre}}" data-profesoresedit="{{$docente_actividad->nombre}}">{{$docente_actividad->descripcion}}</option>
                                            @else
                                              <option value="{{$docente_actividad->id_actividad_comple}}" data-horas="{{$docente_actividad->horas}}" data-docente="{{$docente_actividad->titulo}}  {{$docente_actividad->nombre}}" data-profesoresedit="{{$docente_actividad->nombre}}">{{$docente_actividad->descripcion}}</option>
                                            @endif
                                          @endforeach
                                      </select>
                                    </div>
                                  </div>
                              </div>

                              <div class="col-md-5 col-md-offset-1">
                                <div class="form-group">
                                  <label >Número de Horas</label>
                                    <input class="form-control" id="horas_alumno" type="text" placeholder="Horas" name="horas_alumno" disabled>
                                    <input class="form-control" id="horas_alumnoo" type="hidden" placeholder="Horas" name="horas_alumnoo">

                                </div>
                              </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="col-md-9">
                                  <div class="form-group">
                                    <label >Encargado</label>
                                      <input class="form-control" id="docente" type="text" placeholder="Encargado" name="docente" disabled>
                                       <input id="profesoredit" type="hidden"  value="" name="profesoredit">
                                    </div>
                                </div>
                              </div>
                            
                            </div>     
                          </div>
                        </div>
                       <div class="modal-footer" >
                        <button type="submit" class="btn btn-primary" href="!#" id="modifica_actalu">Modificar</button>
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
    $("#modal_edit_actalu").modal("show");


   $('#actividad_alumnos').on('change',function(){

       var selected = $(this).find('option:selected');
       var horas = selected.data('horas'); 
       var titulo = selected.data('docente'); 
       var nom_docenteedit=selected.data('profesoresedit');
      
       $("#docente").val(titulo);
       $("#horas_alumno").val(horas + " Horas");
        $("#horas_alumnoo").val(horas);

       $("#profesoredit").val(nom_docenteedit);
      });

  $("#modifica_actalu").click(function(event){
    
    $("#modificar_docente").submit();
        
        });

      var selected = $(this).find('option:selected');
      var horas = selected.data('horas'); 
      var titulo = selected.data('docente'); 
      var nom_docenteedit=selected.data('profesoresedit');
      
      $("#docente").val(titulo);
      $("#horas_alumno").val(horas + " Horas");
      $("#profesoredit").val(nom_docenteedit);

    $("#modificar_actalu").validate({
            rules:{
              actividad_alumnos: "required"
            }
      });
    });
</script>
@endsection
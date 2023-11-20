@section('editar_planeacion')

<main class="col-md-12">
  <div class="row">
    <div class="col-md-12 ">
      <div class="modal fade" id="modal_edit_planeacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
              <h3 class="modal-title text-center" id="myModalLabel">Modificación de Planeación</h3>
          </div>
            <div class="modal-body">
              <div class="panel panel-info">
                <div class="panel-body">

                  <form class="form-horizontal" id="modificar_planeacion" role="form" method="POST" action="/planeacion_actividad/{{ $planeacion->id_reg_coordinador}}" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT" />
                      {{csrf_field()}} 

                          <div class="col-md-12">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label >Número de evidencias</label>
                                  <input class="form-control" name="evidencias_doc" type="text" value="{{$planeacion->no_evidencias}}"  placeholder="Evidencias">
                              </div>
                            </div>
                            <div class="col-md-6">
                                  <label >Desea cambiar el archivo</label>
                                  <input value="{{$planeacion->rubrica}}" class="form-control col-md-12" type="text" size="1" id="nombre" name="nombre")></input>
                                  <p id="demo"></p>
                              <input type="checkbox" name="mayor_edad" value="1" id="si"> Sí
                                <div class="form-group" id="formulariomayores" style="display: none;">
                                  <label >Rúbrica de evaluación</label>
                                  <input type="file"  name="urlImg" id="urlImg"  accept=".pdf" required >
                                  <input type="text"  name="oculto" id="oculto"  value="" style="visibility:hidden">
                              </div>
                            </div>
                          </div> 
                        </div>
                      </div>
                    </div>

                        <div class="modal-footer" >
                          <button type="submit" class="btn btn-primary" href="!#" id="modifica_planeacion">Guardar</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                      </div>
                     </div>
                   </div>
                <input name="fecha" type="text" id="fecha"  value="<?php echo date("Y/m/d"); ?>" style="visibility:hidden"/>
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>


<script>
  $(document).ready(function(){
        $("#si").click(function(evento){
          $("#formulariomayores").css("display", "block");
      
   });


  $("#modal_edit_planeacion").modal("show");

    $("#modifica_planeacion").click(function(event){
      if($('input[name=mayor_edad]').is(':checked')){
            
            var valor=1;

            $('#oculto').val(valor);    
        }
        else
        {
           var valor=2;
           $('#oculto').val(valor);
         
        }

    $("#modificar_planeacion").submit();
        });
          $("#modificar_planeacion").validate({
            rules:{
              evidencias_doc: 
              {
                required:true,
                digits: true,
                minlength: 1,
                maxlength:1,
              },
              actividad_docen: "required",
            },

    
      });


  });   
</script>
@endsection
@section('editar_carga')

<main>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="modal fade" id="modal_edit_actalu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
       <div class="modal-dialog" role="document">
        <div class="modal-content">


          <div class="modal-header bg-info">
          {{--  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            --}}
              <h3 class="modal-title text-center" id="myModalLabel">Modificación de Actividad</h3>
          </div>


            <div class="modal-body">
              <div class="panel panel-info">
                <div class="panel-body">

                  <form class="form-horizontal"  id="modificar_actalu" role="form" method="POST" action="/checar_cargau/{{$consultaedit->id_carga_academica}}" novalidate>
                    <input type="hidden" name="_method" value="PUT"/>
                      {{csrf_field()}}  

                      <div class="col-md-12">
                        
                          <div class="col-md-4">
                                  <label >Status</label>
                                  <select class="form-control" name="status" id="status">
                                   @if($consultaedit->id_status_materia==1)
                                      <option value="1" selected="selected">ALTA</option>
                                  @endif
                                  @if($consultaedit->id_status_materia==2)
                                      <option value="1">ALTA</option>
                                  @endif
                                  </select>


                          </div>

                          <div class="col-md-4">
                                  <label >Tipo Cursa</label>
                        <select class="form-control" name="tipo" id="tipo">
                      @if($consultaedit->id_tipo_curso==1)
                        <option value="1" selected="selected">Normal</option>
                        <option value="2">Repeticion</option>
                        <option value="3">Especial</option>
                        <option value="4">Gloval</option>
                        @endif
                           @if($consultaedit->id_tipo_curso==2)
                        <option value="1" >Normal</option>
                        <option value="2" selected="selected">Repeticion</option>
                        <option value="3">Especial</option>
                        <option value="4">Gloval</option>
                        @endif
                           @if($consultaedit->id_tipo_curso==3)
                        <option value="1">Normal</option>
                        <option value="2">Repeticion</option>
                        <option value="3" selected="selected">Especial</option>
                        <option value="4">Gloval</option>
                        @endif
                           @if($consultaedit->id_tipo_curso==4)
                        <option value="1">Normal</option>
                        <option value="2">Repeticion</option>
                        <option value="3">Especial</option>
                        <option value="4" selected="selected">Global</option>
                        @endif
                      </select>


                          </div>

                          <div class="col-md-4">
                              <label >Grupo</label>
                        <select class="form-control" name="grupo" id="grupo">
                      @if($consultaedit->grupo==1)
                        <option value="1" selected="selected">{{$semestre->id_semestre}}01</option>
                        <option value="2">{{$semestre->id_semestre}}02</option>
                        <option value="3">{{$semestre->id_semestre}}03</option>
                        
                        @endif
                           @if($consultaedit->grupo==2)
                        <option value="1" >{{$semestre->id_semestre}}01</option>
                        <option value="2" selected="selected">{{$semestre->id_semestre}}02</option>
                        <option value="3">{{$semestre->id_semestre}}03</option>
                       
                        @endif
                           @if($consultaedit->grupo==3)
                        <option value="1">{{$semestre->id_semestre}}01</option>
                        <option value="2">{{$semestre->id_semestre}}02</option>
                        <option value="3" selected="selected">{{$semestre->id_semestre}}03</option>
                      
                        @endif
                       
                        </select>

                          </div>     
                      </div>



              </div>
            </div>

             
                                

             <div class="modal-footer" >
              <button type="submit" class="btn btn-primary"  id="modifica_actalu">Guardar</button>
              <button type="button" class="btn btn-secondary" id="cerrar_modal">Cancelar</button>
            </div>

            </form>

              


          </div>
        </div>
      </div>
    </div>
  </div>
</main>


<script>
  $(document).ready(function(){

     $("#modal_edit_actalu").modal("show");
      $('#modal_edit_actalu').modal({backdrop: 'static', keyboard: false})

      $("#cerrar_modal").click(function (){
          var link="/checar_carga";
          window.location.href=link;
      });

  
       

    


    });
</script>
@endsection

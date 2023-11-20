@section('editar_personal')

<main>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="modal fade" id="modal_edit_actalu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
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

                  <form class="form-horizontal"  id="modificar_actalu" role="form" method="POST" action="/personalesu/{{$consultaedit->id_personal}}" novalidate>
                    <input type="hidden" name="_method" value="PUT"/>
                      {{csrf_field()}}  

                      <div class=" form-group col-md-12">
                        <div class="col-md-12">
                          <label for="exampleInputEmail1">{{$consultaedit->nombre}}</label>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label for="exampleInputEmail1">Tipo de Permiso<b style="color:red; font-size:23px;">*</b></label>
                    <select class="form-control "placeholder="selecciona una Opcion" name="permiso">

                        @if($consultaedit->id_departamento==0)
                        <option  value="0">sin permisos</option>

                          @foreach($combo as$co)
                       
                            <option  value="{{$co->id_departamento}}">{{$co->nombre_departamento}}</option>
                           @endforeach
                       
                        @else
                       <option  value="0">sin permisos</option>

                       @foreach($combo as$co)
                             @if($consultaedit->id_departamento == $co->id_departamento)
                             <option  selected value="{{$co->id_departamento}}">{{$co->nombre_departamento}}</option>
                             @else
                             <option  value="{{$co->id_departamento}}">{{$co->nombre_departamento}}</option>
                            
                             @endif
                         @endforeach
                      @endif
                    </select>
                    </div>
                     </div>



                      
             
                                
                    
             <div class="modal-footer" >
              <button type="submit" class="btn btn-primary" href="" id="modifica_actalu">Aceptar</button>
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

     $("#modal_edit_actalu").modal("show");

  
       

    


    });
</script>
@endsection

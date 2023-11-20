
<div>
<form id="form_update_docente" class="form-horizontal" role="form" method="POST">
          {{ csrf_field() }}
              <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                     <div class="form-group">
                      <label for="nombre_docente">Nombre Completo:</label>
                      <input type="text" value="{{ $docente_edit->nombre }}" disabled class="form-control" id="caja-errorm" name="nombre_docente">
                    </div>
                  </div>          
                  <div class="col-md-5" style="margin-left: 32px;">
                    <div class="form-group">
                      <label for="clave">Clave docente:</label>
                      <input type="text" value="{{ $docente_edit->clave }}" disabled class="form-control" id="caja-error" name="clave">
                    </div>
                  </div>
                                  <div class="col-md-4 cont">
                    <div class="form-group">
                      <label for="hrs_max">Horas Maximas</label>
                      <input type="number" class="form-control" value="{{ $docente_edit->horas_maxima }}" id="caja-error12" name="hrs_max" placeholder="Horas M..">
                      @if($errors -> has ('hrs_max'))
                          <span style="color:red;">{{ $errors -> first('hrs_max') }}</span>
                         <style>
                          #caja-error12
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div>
              </div>
<div class="row">
  <div class="col-md-12">
                  <div class="col-md-6" style="margin-left: 32px;"> 
                    <div class="form-group">  
                      <div class="dropdown">
                        <label for="selectCargo">Cargo</label>
                                <select name="selectCargo" id="selectCargo"class="form-control ">
                                  <option disabled selected>Selecciona...</option>
                                    @foreach($cargos as $cargo)
                                      @if($cargo->id_cargo==$docente_edit->id_cargo)
                                        <option value="{{$cargo->id_cargo}}" selected="selected" >{{$cargo->cargo}}</option>
                                      @else
                                        <option value="{{$cargo->id_cargo}}" >{{$cargo->cargo}}</option>
                                      @endif
                                    @endforeach
                                </select>
                    </div>  
                  </div>
                  </div>
               <div class="col-md-4 cont">
                    <div class="form-group">
                      <label for="hrs_max_ingles">Hrs Max. Ingles</label>
                      <input type="number" class="form-control"  value="{{ $docente_edit->maximo_horas_ingles }}" id="caja-error13" name="hrs_max_ingles" placeholder="Horas M..">
                      @if($errors -> has ('hrs_max_ingles'))
                          <span style="color:red;">{{ $errors -> first('hrs_max_ingles') }}</span>
                         <style>
                          #caja-error13
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div> 
  </div>
</div>
</form>
</div>



<script>
$(document).ready(function(){
    
  });
</script>
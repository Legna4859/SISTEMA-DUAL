
<div>
<form id="form_update_materia" class="form-horizontal" role="form" method="POST" action="/reticulass/{{ $materia_edit->id_materia }}">
  <input type="hidden" name="_method" value="PUT" />
          {{ csrf_field() }}
              <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                     <div class="form-group">
                      <label for="nombre_materia">Nombre de la Materia:</label>
                      <input type="text" value="{{ $materia_edit->nombre }}" class="form-control" id="nombrem" name="nombre_materia"placeholder="Materia" style="text-transform:uppercase">
                      @if($errors -> has ('nombre_materia'))
                          <span style="color:red;">{{ $errors -> first('nombre_materia') }}</span>
                         <style>
                          #nombrem
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div>          
                  <div class="col-md-10 col-md-offset-1">
                    <div class="form-group">
                      <label for="clave_materia">Clave de la Materia:</label>
                      <input type="text" value="{{ $materia_edit->clave }}" class="form-control" id="clavem" name="clave_materia" placeholder="Clave" style="text-transform:uppercase">
                      @if($errors -> has ('clave_materia'))
                          <span style="color:red;">{{ $errors -> first('clave_materia') }}</span>
                         <style>
                          #clavem
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div>
              </div>
<div class="row">
  <div class="col-md-12 cont">
                       <div class="col-md-3 ml"> 
                  <div class="form-group">              
                         <label for="creditos">Creditos</label> 
                                <select name="creditos" id="creditos" class="form-control ">
                                  <option disabled selected >Elige...</option>
                                  @for ($i = 1; $i <=10; $i++)
                                    @if($i==$materia_edit->creditos)
                                    <option value="{{ $i }}" selected="selected">{{ $i }}</option>
                                    @else
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endif
                                  @endfor
                                </select> 
                    </div> 
                  </div>

                  <div class="col-md-3 cont ml">
                      <div class="form-group">
                          <label for="hrs_t">Hrs.Teoria</label>
                          <select name="hrs_t" id="hrs_t" class="form-control ">
                              <option disabled selected >Elige...</option>
                              @for ($i = 0; $i <=6; $i++)
                                  @if($i==$materia_edit->hrs_teoria)
                                      <option value="{{ $i }}" selected="selected">{{ $i }}</option>
                                  @else
                                      <option value="{{ $i }}">{{ $i }}</option>
                                  @endif
                              @endfor
                          </select>
                      </div>

                  </div>
                  <div class="col-md-3 ml cont">
                      <div class="form-group">
                          <label for="hrs_p">Hrs.Practicas</label>
                          <select name="hrs_p" id="hrs_p" class="form-control ">
                              <option disabled selected>Elige...</option>
                              @for ($i = 0; $i <=6; $i++)
                                  @if($i==$materia_edit->hrs_practicas)
                                      <option value="{{ $i }}" selected="selected">{{ $i }}</option>
                                  @else
                                      <option value="{{ $i }}">{{ $i }}</option>
                                  @endif
                              @endfor
                          </select>
                      </div>
                  </div>
  </div>
</div>
<div class="row">
  <div clas="col-md-12">
    <div class="col-md-3 col-md-offset-1 ml">
                  <div class="form-group">              
                         <label for="uni">Unidades</label> 
                                <select name="uni" id="unidades" class="form-control ">
                                  <option disabled selected >Elige...</option>
                                  @for ($i = 1; $i <=10; $i++)
                                    @if($i==$materia_edit->unidades)
                                    <option value="{{ $i }}" selected="selected">{{ $i }}</option>
                                    @else
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endif
                                  @endfor
                                </select> 
                    </div> 
                  </div>
                    <div class="col-md-3 ml cont"> 
                  <div class="form-group">              
                         <label for="especial">Especial</label> 
                                <select name="especial" id="espe" class="form-control ">
                                  <option disabled selected >Elige...</option>
                                    @if($materia_edit->especial==1)
                                      <option value="1" selected="selected">Si</option>
                                      <option value="0">No </option>
                                      @else
                                        @if($materia_edit->especial==0)
                                          <option value="0" selected="selected">No </option>
                                          <option value="1">Si</option>
                                          @endif
                                    @endif
                                </select> 
                    </div> 
                  </div> 
                      <div class="col-md-3 cont ml" style="<?php if($no_ver==1){ echo "display:none"; } ?>">
                         <div class="form-group"> 
                         <label for="semestre">Semestre</label> 
                                <select name="semestre" id="sem" class="form-control ">
                                  <option disabled selected>Elige...</option>
                                  @foreach($semestres as $semestre)
                                      @if($materia_edit->id_semestre==$semestre->id_semestre)
                                            <option value="{{$semestre->id_semestre}}" selected="selected">{{$semestre->descripcion}}</option>
                                      @else
                                      <option value="{{$semestre->id_semestre}}">{{$semestre->descripcion}}</option>
                                      @endif
                                    @endforeach
                                </select> 
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
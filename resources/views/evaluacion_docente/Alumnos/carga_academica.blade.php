
@extends('layouts.app')
@section('title', 'Inicio')
@section('content')
        @if($status_per ==0)
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Registrar carga academica</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">El periodo que seleccionaste no es el requerido.</h3>
                        </div>
                    </div>
                </div>
            </div>
        @else
        @if($adeudo == 0)
        <?php
          $direccion=Session::get('ip');
        ?>

        <script>
         $(document).ready(function(){

                 $("#enviar").click(function () {

                   var checkboxValues=[];
                   var tu_array=[];
                   $('input[name="orderBox[]"]:checked').each(function() {

                       checkboxValues[checkboxValues.length] = $(this).val();
                   // alert(checkboxValues);

                       tu_array[tu_array.length]=$(this).parent().closest("p").children("select").val();

                     });
                     var $marcados =$("input:checked");
                     var numero= $marcados.length;
                     var suma=numero+numero;
                      // alert(numero);
                     var arreglo=[];
                     var j=0;

                    for (var i = 0; i < numero; i++) {

                              arreglo[i]=checkboxValues[i];
                    };

                  for (var e = numero; e < suma; e++) {

                          arreglo[e]=tu_array[j];
                          j++;
                   };
                    if ($marcados.length > 0)
                    {
                         var direccion="{{$direccion}}";
                              window.location.href = "/ajax/"+arreglo;
                          // alert("SELECCIONADOS " +$marcados.length);
                         }
                        else {
                         alert("NINGUNA SELECCION");
                        }
                   });
                   /////////////////////////////////////reticula
                    $("#reti").on('change',function(e){
                            var reti=$('#reti').val();
                            var direccion="{{$direccion}}";
                            //$("#form_reticulas").submit();
                          window.location.href = "/reticulas/"+reti;
                         });
                    });
 </script>
<main>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Registrar carga academica</h3>
                </div>
            </div>
        </div>
    </div>
    <div clas="row">
      <div class="col-md-12 text_algin center" id="rajita" align="center">
        <h6 style="color: #0c0c0c">{{$carre}}</h6>
      </div>
    </div>
   <div class="row col-md-10 col-md-offset-1">
  <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#uno" aria-controls="home" role="tab" data-toggle="tab">Primero</a></li>
                <li role="presentation"><a href="#dos" aria-controls="dos" role="tab" data-toggle="tab">Segundo</a></li>
                <li role="presentation"><a href="#tres" aria-controls="tres" role="tab" data-toggle="tab">Tercero</a></li>
                <li role="presentation"><a href="#cuatro" aria-controls="cuatro" role="tab" data-toggle="tab">Cuarto</a></li>
                <li role="presentation"><a href="#sinco" aria-controls="sinco" role="tab" data-toggle="tab">Quinto</a></li>
                <li role="presentation"><a href="#seis" aria-controls="seis" role="tab" data-toggle="tab">Sexto</a></li>
                <li role="presentation"><a href="#siete" aria-controls="siete" role="tab" data-toggle="tab">Septimo</a></li>
                <li role="presentation"><a href="#ocho" aria-controls="ocho" role="tab" data-toggle="tab">Octavo</a></li>
                <li role="presentation"><a href="#nueve" aria-controls="nueve" role="tab" data-toggle="tab">Noveno</a></li>
   </ul>

  <!-- Tab panes -->
    <div class="tab-content ">
         <div role="tabpanel" class="tab-pane active" id="uno">
             <br>
             <div class="col-md-3 col-md-offset-4" align="center">
                 <h4 style="color: #0c0c0c ">Primer semestre</h4>
             </div>
             <div class="col-md-12" align="center">

             </div>
             <?php $i=0; ?>
              @foreach($materias as $materias)
                 <?php $i++; ?>
                  <div class="col-md-4 card col-md-offset-1 carmaterias" align="center" style="background:gainsboro;" id="carmaterias">
                  <h5 style="color: #0c0c0c" values="{{$materias->id_materia}}">{{$materias->nombre}}</h5>
                  <p>
                    <input type="checkbox" id="test1" value="{{$materias->id_materia}}" class="col-md-12" name="orderBox[]"/>
                    <br>
                     <select name="color1[]" class="input-field col-md-8 col-md-offset-2">
                     <option value="1">Normal</option>
                     <option value="2">Repeticion</option>
                     <option value="3">Epecial</option>
                     <option value="4">Global</option>
                     </select>
                      <br>
                   </p>
                 </div>
                 @if($i == 2)
                     <div class="col-md-12">
                         <p><br></p>
                     </div>
                     <?php $i=0; ?>
                 @endif
                 @endforeach
                 @if($i == 1)
                     <div class="col-md-12">
                         <p><br></p>
                     </div>
                     <?php $i=0; ?>
                 @endif

        </div>

        <div role="tabpanel" class="tab-pane " id="dos">
                  <br>
                  <div class="col-md-3 col-md-offset-4" align="center">
                      <h4 style="color: #0c0c0c ">Segundo semestre</h4>
                  </div>
                    <div class="col-md-12" align="center">

                    </div>
                  <?php $i=0; ?>
                  @foreach($materias2 as $materias2)
                    <?php $i++; ?>
                   <div class="col-md-4 cardd col-md-offset-1 carmaterias" align="center" style="background:gainsboro;"  id="carmaterias">
                      <h5 values="{{$materias2->id_materia}}">{{$materias2->nombre}}</h5>
                         <p>
                             <input type="checkbox" id="test1" value="{{$materias2->id_materia}}" class="col-md-12" name="orderBox[]"/>
                             <br>
                             <select name="color1[]" class="input-field col-md-8 col-md-offset-2">
                             <option value="1">Normal</option>
                             <option value="2">Repeticion</option>
                             <option value="3">Epecial</option>
                             <option value="4">Global</option>
                             </select>
                             <br>
                         </p>
                   </div>
                        @if($i == 2)
                             <div class="col-md-12">
                                 <p><br></p>
                             </div>
                            <?php $i=0; ?>
                        @endif
                 @endforeach
                @if($i == 1)
                    <div class="col-md-12">
                        <p><br></p>
                    </div>
                    <?php $i=0; ?>
                @endif

        </div>

        <div role="tabpanel" class="tab-pane " id="tres">
                <br>
                <div class="col-md-3 col-md-offset-4" align="center">
                    <h4 style="color: #0c0c0c ">Tercer semestre</h4>
                </div>
                <div class="col-md-12" align="center">

                </div>
                <?php $i=0; ?>
                @foreach($materias3 as $materias3)
                    <?php $i++; ?>
               <div class="col-md-4 cardd col-md-offset-1 carmaterias" align="center" style="background:gainsboro;" id="carmaterias">

                  <h5 values="{{$materias3->id_materia}}">{{$materias3->nombre}}</h5>
                  <p>
                    <input type="checkbox" id="test1" value="{{$materias3->id_materia}}" class="col-md-12" name="orderBox[]"/>
                    <br>
                     <select name="color1[]" class="input-field col-md-8 col-md-offset-2">
                     <option value="1">Normal</option>
                     <option value="2">Repeticion</option>
                     <option value="3">Epecial</option>
                     <option value="4">Global</option>
                     </select>
                      <br>
                  </p>
               </div>
                        @if($i == 2)
                            <div class="col-md-12">
                                <p><br></p>
                            </div>
                            <?php $i=0; ?>
                        @endif
                @endforeach
                @if($i == 1)
                    <div class="col-md-12">
                        <p><br></p>
                    </div>
                    <?php $i=0; ?>
                @endif
        </div>
         <div role="tabpanel" class="tab-pane " id="cuatro">
                 <br>
                 <div class="col-md-3 col-md-offset-4" align="center">
                     <h4 style="color: #0c0c0c ">Cuarto semestre</h4>
                 </div>
                 <div class="col-md-12" align="center">
                 </div>
                 <?php $i=0; ?>
                 @foreach($materias4 as $materias4)
                     <?php $i++; ?>
                     <div class="col-md-4 cardd col-md-offset-1 carmaterias" align="center" style="background:gainsboro;" id="carmaterias">

                         <h5 values="{{$materias4->id_materia}}">{{$materias4->nombre}}</h5>
                         <p>
                         <input type="checkbox" id="test1" value="{{$materias4->id_materia}}" class="col-md-12" name="orderBox[]"/>
                         <br>
                         <select name="color1[]" class="input-field col-md-8 col-md-offset-2">
                         <option value="1">Normal</option>
                         <option value="2">Repeticion</option>
                         <option value="3">Epecial</option>
                         <option value="4">Global</option>
                         </select>
                             <br>
                       </p>
                     </div>
                         @if($i == 2)
                             <div class="col-md-12">
                                 <p><br></p>
                             </div>
                             <?php $i=0; ?>
                         @endif
                 @endforeach
                 @if($i == 1)
                     <div class="col-md-12">
                         <p><br></p>
                     </div>
                     <?php $i=0; ?>
                 @endif
        </div>

        <div role="tabpanel" class="tab-pane " id="sinco">
                 <br>
                 <div class="col-md-3 col-md-offset-4" align="center">
                     <h4 style="color: #0c0c0c ">Quinto semestre</h4>
                 </div>
                 <div class="col-md-12" align="center">
                 </div>
                 <?php $i=0; ?>
                   @foreach($materias5 as $materias5)
                     <?php $i++; ?>
                   <div class="col-md-4 cardd col-md-offset-1 carmaterias" align="center" style="background:gainsboro;" id="carmaterias">

                      <h5 values="{{$materias5->id_materia}}">{{$materias5->nombre}}</h5>
                      <p>
                        <input type="checkbox" id="test1" value="{{$materias5->id_materia}}" class="col-md-12" name="orderBox[]"/>
                        <br>
                         <select name="color1[]" class="input-field col-md-8 col-md-offset-2">
                         <option value="1">Normal</option>
                         <option value="2">Repeticion</option>
                         <option value="3">Epecial</option>
                         <option value="4">Global</option>
                         </select>
                          <br>
                      </p>
                   </div>
                         @if($i == 2)
                             <div class="col-md-12">
                                 <p><br></p>
                             </div>
                             <?php $i=0; ?>
                         @endif
                    @endforeach
                     @if($i == 1)
                         <div class="col-md-12">
                             <p><br></p>
                         </div>
                         <?php $i=0; ?>
                     @endif
        </div>
     <div role="tabpanel" class="tab-pane " id="seis">
             <br>
             <div class="col-md-3 col-md-offset-4" align="center">
                 <h4 style="color: #0c0c0c ">Sexto semestre</h4>
             </div>
             <div class="col-md-12" align="center">
             </div>
             <?php $i=0; ?>
            @foreach($materias6 as $materias6)
             <?php $i++; ?>
           <div class="col-md-4 cardd col-md-offset-1 carmaterias" align="center" style="background:gainsboro;" id="carmaterias">

              <h5 values="{{$materias6->id_materia}}">{{$materias6->nombre}}</h5>
              <p>
                <input type="checkbox" id="test1" value="{{$materias6->id_materia}}" class="col-md-12" name="orderBox[]"/>
                <br>

                 <select name="color1[]" class="input-field col-md-8 col-md-offset-2">
                 <option value="1">Normal</option>
                 <option value="2">Repeticion</option>
                 <option value="3">Epecial</option>
                 <option value="4">Global</option>
                 </select>
                  <br>
              </p>
           </div>
                 @if($i == 2)
                     <div class="col-md-12">
                         <p><br></p>
                     </div>
                     <?php $i=0; ?>
                 @endif
            @endforeach
             @if($i == 1)
                 <div class="col-md-12">
                     <p><br></p>
                 </div>
                 <?php $i=0; ?>
             @endif

    </div>
     <div role="tabpanel" class="tab-pane" id="siete">
             <br>
             <div class="col-md-3 col-md-offset-4" align="center">
                 <h4 style="color: #0c0c0c ">Septimo semestre</h4>
             </div>
             <div class="col-md-12" align="center">
             </div>
             <?php $i=0; ?>
                 @foreach($materias7 as $materias7)
                 <?php $i++; ?>
               <div class="col-md-4 cardd col-md-offset-1 carmaterias" align="center" style="background:gainsboro;" id="carmaterias">

                  <h5 values="{{$materias7->id_materia}}">{{$materias7->nombre}}</h5>
                  <p>
                    <input type="checkbox" id="test1" value="{{$materias7->id_materia}}" class="col-md-12" name="orderBox[]"/>
                    <br>
                     <select name="color1[]" class="input-field col-md-8 col-md-offset-2">
                     <option value="1">Normal</option>
                     <option value="2">Repeticion</option>
                     <option value="3">Epecial</option>
                     <option value="4">Global</option>
                     </select>
                      <br>
                  </p>
               </div>
                     @if($i == 2)
                         <div class="col-md-12">
                             <p><br></p>
                         </div>
                         <?php $i=0; ?>
                     @endif
                @endforeach
                 @if($i == 1)
                     <div class="col-md-12">
                         <p><br></p>
                     </div>
                     <?php $i=0; ?>
                 @endif

    </div>
     <div role="tabpanel" class="tab-pane" id="ocho">
             <br>
             <div class="col-md-3 col-md-offset-4" align="center">
                 <h4 style="color: #0c0c0c ">Octavo semestre</h4>
             </div>
             <div class="col-md-12" align="center">
             </div>
             <?php $i=0; ?>
            @foreach($materias8 as $materias8)
                 <?php $i++; ?>
               <div class="col-md-4 cardd col-md-offset-1 carmaterias" align="center" style="background:gainsboro;" id="carmaterias">

                <h5 values="{{$materias8->id_materia}}">{{$materias8->nombre}}</h5>
                  <p>
                    <input type="checkbox" id="test1" value="{{$materias8->id_materia}}" class="col-md-12" name="orderBox[]"/>
                    <br>
                     <select name="color1[]" class="input-field col-md-8 col-md-offset-2">
                     <option value="1">Normal</option>
                     <option value="2">Repeticion</option>
                     <option value="3">Epecial</option>
                     <option value="4">Global</option>
                     </select>
                      <br>
                   </p>
                </div>
                     @if($i == 2)
                         <div class="col-md-12">
                             <p><br></p>
                         </div>
                         <?php $i=0; ?>
                     @endif
                @endforeach
                 @if($i == 1)
                     <div class="col-md-12">
                         <p><br></p>
                     </div>
                     <?php $i=0; ?>
                 @endif
     </div>
     <div role="tabpanel" class="tab-pane" id="nueve">
             <br>
             <div class="col-md-3 col-md-offset-4" align="center">
                 <h4 style="color: #0c0c0c ">Noveno semestre</h4>
             </div>
             <div class="col-md-12" align="center">
             </div>
             <?php $i=0; ?>
                 @foreach($materias9 as $materias9)
                 <?php $i++; ?>
               <div class="col-md-4 cardd col-md-offset-1 carmaterias" align="center" style="background:gainsboro;" id="carmaterias">
                
                  <h5 values="{{$materias9->id_materia}}">{{$materias9->nombre}}</h5>
                  <p>
                    <input type="checkbox" id="test1" value="{{$materias9->id_materia}}" class="col-md-12" name="orderBox[]"/>
                    <br>
                     <select name="color1[]" class="input-field col-md-8 col-md-offset-2">
                     <option value="1">Normal</option>
                     <option value="2">Repeticion</option>
                     <option value="3">Epecial</option>
                     <option value="4">Global</option>
                     </select>
                      <br>
                  </p>
               </div>
                     @if($i == 2)
                         <div class="col-md-12">
                             <p><br></p>
                         </div>
                         <?php $i=0; ?>
                     @endif
                @endforeach
                 @if($i == 1)
                     <div class="col-md-12">
                         <p><br></p>
                     </div>
                     <?php $i=0; ?>
                 @endif

    </div>






</div>
    <div class="row">
       <p><br></p>
    </div>
</div>
    @if($des == 0 || $des == 3 || $des == 4 )

     <div>
  
    <a class=" btn btn-primary flotante" id="enviar" type="button" ><span class="glyphicon glyphicon-ok " aria-hidden="true"/></a>
     </div>
        @else
        <div>

            <a class=" btn btn-primary flotante"  type="button" disabled><span class="glyphicon glyphicon-ok " aria-hidden="true"/></a>
        </div>
    @endif

</main>
        @else
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Registrar carga academica</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title ">Contacta a los siguientes Departamentos o Jefaturas porque cuentas con un adeudo (por ejemplo: préstamo de material o instrumentos, o un documento), por lo contrario, no podrás registrar tu carga académica:</h3><br>
                        @foreach($departamento_carrera as $departamento_carrera)
                            <p><strong>Nombre del departamento o jefatura : {{$departamento_carrera['nombre']}}</strong><br> <b>¿Qué  es lo que adeudas en el departamento? </b>{{$departamento_carrera['comentario']}}</p><hr>
                        @endforeach
                    </div>
                </div>
            </div>
            </div>
        @endif
@endif
        <div class="row">
            <p><br></p>
        </div>
@endsection

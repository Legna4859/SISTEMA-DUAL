
@extends('layouts.app')
@section('title', 'Inicio')
@section('content')
<?php
  $direccion=Session::get('ip');
?>
<script>


  $(document).ready(function(){


  	$("#sig").click(function()
  	{


      
//obtiene el puntaje que se le asigno a cada docente

        var valor=[];
        var ciclos=$("#ciclos").val();
         var total = $("input:checked").length;
        var condicion=total-ciclos;

        if(condicion==ciclos){


        for (var i = 0; i <ciclos; i++)
         {
         
             valor[i]=$('input:radio[name=radio'+(i+1)+']:checked').val();
             
            
        }
//      alert(valor);


  			checkboxValues=[];

  			var id_pregunta=parseInt($('#pregunta').val());
  			var id_tabla=$('#tabla').val();

  			var arreglo=[];
  			
  			
  			id_pregunta++;
          //  alert(id_pregunta);
  			

  			arreglo[0]=id_pregunta;
  			arreglo[1]=id_tabla;
  			//los primeros 2 valores de checkbox values seran la pregunta y el id que se modificaran
  			checkboxValues[checkboxValues.length]=arreglo[0];
  			checkboxValues[checkboxValues.length]=arreglo[1];

  				
  			 $('input[name="orderBoxx[]"]:checked').each(function() {

                    checkboxValues[checkboxValues.length] = $(this).val() ;
                 

                      // tu_array[tu_array.length]=$(this).parent().closest("p").children("select").val();
                   

                     });

          for (var i = 0; i <ciclos; i++)
         {

             checkboxValues[checkboxValues.length]=valor[i];
            
        }
        
          var direccion="{{$direccion}}";
        window.location.href = "/insertar/"+checkboxValues;
            $("#sig").attr("disabled", true);
  			}
        else
        {
            //alert("no has seleccionado algun docente");
             $('#mensaje').modal('show');
             setTimeout(myFunction, 2000); 

              function myFunction(){
              $('#mensaje').modal('hide');
            }
        }
//alert(checkboxValues);
  	//		


  		
  	});
  $("#iniciar").click(function(){

      $('#macep').modal('show');
  });


  	$("#acep").click(function(){
        $("#acep").attr("disabled", true);
 $('#macep').modal('hide');
  			var direccion="{{$direccion}}";
  			 		  

checkboxValues=[];
checkboxRadio=[];

  			var id_pregunta=$('#pregunta').val();
  			var id_tabla=$('#tabla').val();//contiene el id de la tabla validacion alumno para poder saver que alumno se modificara

  			var arreglo=[];

  			arreglo[0]=id_pregunta;
  			arreglo[1]=id_tabla;


  			checkboxValues[checkboxValues.length]=arreglo[0];
  			checkboxValues[checkboxValues.length]=arreglo[1];

  				var fallo=0;
  			 $('input[name="orderBox[]"]:checked').each(function() {
                    checkboxValues[checkboxValues.length] = $(this).val() ;
                      // tu_array[tu_array.length]=$(this).parent().closest("p").children("select").val();
                     });

                    @foreach($condicion as$con)
                     if($("input:radio[name={{$con->id_materia}}]").is(':checked')) 
                     {   
                      checkboxRadio[checkboxRadio.length]=($('input:radio[name={{$con->id_materia}}]:checked').val());
                   
                     } 
                     else 
                     {  
                       fallo=fallo+1;
                     }  

                      
                    @endforeach
          if (fallo==0) 
          {
            
            for (var i = 0; i < checkboxRadio.length; i++) 
             {
               checkboxValues[checkboxValues.length]=checkboxRadio[i];

             }      
              window.location.href = "/insertaralumno_materia/"+checkboxValues;

          }     
          else
          {
             $('#fallo').modal('show');
             setTimeout(myFunction, 3000); 

              function myFunction(){
              $('#fallo').modal('hide');
               }
          }
  		
//  			
  	});


  });
</script>

<main>

	@if($estado==1)

		<style type="text/css">
			.iniciar
			{
				display:none;
				

			}
			</style>
	
		<div class="col-md-12 " >	
			<div class="col-md-6 col-md-offset-3">
			<label class=" alert alert-danger"  data-toggle="tab" >Mientras tu carga academica no este validada no podras relizar evaluacion</label> 
			</div>
 	    </div>
    @endif

	@if($no==0)
	

		<style type="text/css">
			.condicion
			{
				display:none;
				

			}
		</style>	

		<div class="col-md-12 iniciar " >	
			<div class="col-md-8 col-md-offset-2">
				<table class="table table-bordered " Style="background: white;">
                                   <thead>
                                          <tr>
                                                  
                                                 <th class="col-md-4 ">DOCENTE</th>
                                                  <th class="col-md-7 ">MATERIAS</th>
                                                  <th class="col-md-1 ">GRUPO</th>
                                                  
                                           </tr>
                                    </thead>
                                    <tbody>
                                             @foreach($docentes as$docentes)
                                          <tr>
                                                  <td>{{$docentes->nombre}}</td>
                                                  <td>{{$docentes->materias}}</td>
                                                  <td>{{$docentes->id_semestre}}0{{$docentes->grupo}}</td>
                                                  <td style="display:none;" ><input checked type="checkbox" id="test1" value="{{$docentes->id_hrs_profesor}}" class="col-md-12" name="orderBox[]"/></td>
                                                  
                                          </tr>
                                          @endforeach
                                          

                                         
    
                                   </tbody>
                            </table>

          
                    @if($materiase==1)

                    <div><p class="bg-danger">MATERIAS ESPECIALES : Solo se puede selccionar un docente por materia</p></div>

                            <table class="table table-bordered " Style="background: white;">
                                   <thead>
                                          <tr>
                                                 <th class="col-md-4 ">DOCENTE</th>
                                                  <th class="col-md-6 ">MATERIAS</th>
                                                  <th class="col-md-1 ">GRUPO</th>
                                                   <th class="col-md-1 ">    </th>
                                           </tr>
                                    </thead>
                                    <tbody>
                                             

                                               @foreach($docentes_especial as $docee)
                                          <tr>
                                                  <td>{{$docee->nombre}}</td>
                                                  <td>{{$docee->materias}}</td>
                                                  <td>{{$docee->id_semestre}}0{{$docee->grupo}}</td>
                                                  <td><input type="radio" name="{{$docee->id}}"  value="{{$docee->id_hrs_profesor}}"></td>
                                          </tr>
                                             @endforeach
                                          

                                         
    
                                   </tbody>
                            </table>
                            @endif

			</div>


			<div class="col-md-2 col-md-offset-5">
			<button type="button" class="btn btn-primary" id="iniciar" data-toggle="tab" >Iniciar evaluación</button> 
			</div>
      </br></br></br>
 	    </div>
    @endif
    @if($id_pregunta==49)
    

				<style type="text/css">
			.condicion
			{
				display:none;
				

			}
		</style>
		<div class="col-md-12 " >	
			<div class="col-md-2 col-md-offset-5">
					{{$pregunta}}
			</div>
 	    </div>
    	</br></br></br>
    
    @endif

	<div class="condicion" id="condicion" >
		
</br></br>

			<div class="col-md-12">
				<input class="" id="tabla" style="display:none;" value="{{$id_tabla}}">
				<input class="" id="pregunta" style="display:none;" value="{{$id_pregunta}}">
				<p class="bg-primary" style="font-size: 20px;" >
					{{$id_pregunta}} .- ¿ {{$pregunta}} ?
				</p>
        <!--contiene el numero de docentes evaluados-->
        <input id="ciclos"class="bg-primary" style="font-size: 16px; display:none;" value="{{$num}}">
         
        </input>
			</div>
	


			</br>
			</br></br></br>

			<div class="col-md-9  ">
				<table class="table table-bordered " Style="background: white;">
                                   <thead>
                                          <tr>
                                                  <th class="col-md-5">MATERIA</th >
                                                  <th class="col-md-4">DOCENTE</th >
                                                  <th>1</th>
                                                  <th>2</th>
                                                  <th>3</th>
                                                  <th>4</th>
                                                  <th>5</th>
                                                  
                                           </tr>
                                    </thead>
                                    <tbody>
                                      
                                             @foreach($profesores as$profesores)
                                                
                                          <tr>
                                                  <th>{{$profesores->ma}} </th>
                                                  <th>{{$profesores->p}} <td style="display:none;" ><input checked type="checkbox" id="test1" value="{{$profesores->id_alumno_materia}}" class="col-md-12" name="orderBoxx[]"/></td></th>
                                                  @for($i = 0; $i < 5; $i++)
                                                        

                                                  
                                                  <th><input type="radio" id="test1"  class="col-md-12" name="radio{{$profesores->indice}}" value="{{$i+1}}"/>
                                                  </th>
                                                  
                                                  @endfor
                                                  


                                                  <!--<th><input type="radio" id="test2"  class="col-md-12" name="radio2"/>
                                                  </th>
                                                  <th><input type="radio" id="test3"  class="col-md-12" name="radio3"/>
                                                  </th>
                                                  <th><input type="radio" id="test4"  class="col-md-12" name="radio4"/>
                                                  </th>
                                                  <th><input type="radio" id="test5"  class="col-md-12" name="radio5"/>
                                                  </th>-->
                                                  
                                          </tr>
                                          @endforeach
                                          

                                         
    
                                   </tbody>
                            </table>

			</div>

			<div id="rajita" class="col-md-3">
					<div class=" col-md-12">
						<h5>CRITERIOS:</h5>	
					</div>
					<div class=" col-md-12">
						1.-Totalmente en desacuerdo 	
					</div>
					<div class=" col-md-12">
						2.-En desacuerdo 	
					</div>

					<div class=" col-md-12">
						3.-Indeciso	
				    </div>

					<div class=" col-md-12">
						4.-De Acuerdo 	
					</div>
					<div class=" col-md-12">
						5.-Totalmente De Acuerdo 	
					</div>

   
	</br></br></br>

			</div>
				</br></br></br>
				</br></br>
			<div class="col-md-12 ">
				</br>
			</br>
 				<div class="col-md-12">
 					<div class="col-md-1 col-md-offset-8 ">	
						<button type="button" class="btn btn-primary" id="sig" data-toggle="tab" >Siguiente</button> 
 					</div>
  						</br> </br> </br> </br> </br> </br> </br>
  				</div>
			</div>

	</div>



<div id="mensaje" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body text-warning">
        <p style="font-weight: bold; color:#BA0000; text-align:center;">Aún no has evaluado a todos los docentes</p>
      </div>
    </div>
  </div>
</div>
	

	
<div id="fallo" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body text-warning">
        <p style="font-weight: bold; color:#BA0000; text-align:center;">Falta por seleccionar docente(s) de materia(s) Especial(es)</p>
      </div>
    </div>
  </div>
</div>













<div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="modal fade" id="macep" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
        <div class="modal-content">


          <div class="modal-header bg-info">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
              <h3 class="modal-title text-center" id="myModalLabel">Alerta</h3>
          </div>


            <div class="modal-body">
              <div class="panel panel-info">
                <div class="panel-body">
                      
                      <p class="bg-danger">UNA VEZ INICIADA LA EVALUACION NO SE PODRA REALIZAR NINGUN CAMBIO</p>
  


            </div>
          </div>
        </div>
                      
             
                                
                    
             <div class="modal-footer" >
              <button type="button" class="btn btn-primary" href="" id="acep">Aceptar</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>


    
              

                
          </div>
        </div>
      </div>
    </div>
  </div>
</main>	
@endsection
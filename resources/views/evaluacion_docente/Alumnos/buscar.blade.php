@extends('layouts.app')
@section('title', 'Inicio')
@section('content')


<?php
  $direccion=Session::get('ip');
?>

<script type="text/javascript">



  $(document).ready(function() {

      $('#ejemplo1').DataTable();
      $('#ejemplo2').DataTable();
      $('#ejemplo3').DataTable();
      $('#ejemplo4').DataTable();
      $('#ejemplo5').DataTable();
      $('#ejemplo6').DataTable();
      $('#ejemplo7').DataTable();
      $('#ejemplo8').DataTable();
      $('#ejemplo9').DataTable();
      $('#ejemplo10').DataTable();
      $('#ejemplo11').DataTable();
      $('#ejemplo12').DataTable();
      $('#ejemplo13').DataTable();
      $('#ejemplo14').DataTable();
      $('#ejemplo15').DataTable();

      $('#ejemplos1').DataTable();
      $('#ejemplos2').DataTable();
      $('#ejemplos3').DataTable();
      $('#ejemplos4').DataTable();
      $('#ejemplos5').DataTable();
      $('#ejemplos6').DataTable();
      $('#ejemplos7').DataTable();
      $('#ejemplos8').DataTable();
      $('#ejemplos9').DataTable();
      $('#ejemplos10').DataTable();
      $('#ejemplos11').DataTable();
      $('#ejemplos12').DataTable();
      $('#ejemplos13').DataTable();
      $('#ejemplos14').DataTable();
      $('#ejemplos15').DataTable();



 $("#evaluar").click(function(){

      $('#modal_evaluar').modal('show');
  });
 $("#confirma_evaluar").click(function(){

     // $('#modal_confirma_evaluar').modal('show');
  //});
//$("#verificar").click(function(){

  //    var verifica=$("#contra").val();

    //  if (verifica==101918)
     //{
     $("#activar").attr("disabled","disabled");
        var direccion="{{$direccion}}";
         $('#modal_evaluar').modal('hide');
          $('#modal_confirma_evaluar').modal('hide');
           $('#mensaje').modal('show');
        window.location.href = "/Migrar";

      //}
      //else{
        //alert("contraseña incorrecta");
      //}
      
  });


  
} );


</script>

<main>
  
<div class=" row col-md-8 col-md-offset-2">
    <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title text-center">ALUMNOS EVALUACIÓN DOCENTE</h3>
        </div>         
    </div>
  </div>


<div class="row col-md-2 col-md-offset-8">
                                        @if($activa_eva==1)
                          <div class="col-md-3">
                            <a class=" btn btn-success "  type="button" href="/activar">Activar Evaluación <span class="glyphicon glyphicon-ok " aria-hidden="true"></a>
                          </div>

                                           @else
                          <div class="col-md-3">
                            <a class=" btn btn-danger"  type="button" href="/activar">Desactivar Evaluación <span class="glyphicon glyphicon-remove " aria-hidden="true"></a>
                          </div>
                                          @endif
</div>
<div class="row col-md-2">
                                        @if($evaluar==1)
                          <div class="col-md-3">
                              <a  class=" btn btn-success " id="evaluar" type="button">Evaluar<span class="glyphicon glyphicon-ok " aria-hidden="true"></span></a>
                          </div>
                                           @else
                          <div class="col-md-3">
                              <a disabled="disabled" class=" btn btn-danger"  type="button" >Evaluar<span class="glyphicon glyphicon-ok " aria-hidden="true"></span></a>
                          </div>
                                          @endif
</div>
</br></br></br></br></br></br>
<div class="row col-md-10 col-md-offset-1">


 <div class="panel-group" id="accordion">
    @foreach($carreras as$carrera)
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
                          <div> 
                            <div class="col-md-6">
                              <a data-toggle="collapse" data-parent="#accordion" href="#carrera_{{$carrera->id_carrera}} ">
                            {{$carrera->nombre}}</a>
                          </div>
                            @if($carrera->por>=0&&$carrera->por<=33)
                            <div class="progress ">
                                   <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$carrera->por}}%;color:black;">
                                     {{$carrera->por}}%  
                                  </div>
                              </div>
                              @endif
                                @if($carrera->por>=34&&$carrera->por<=66)
                            <div class="progress ">
                                   <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$carrera->por}}%;color:black;">
                                    {{$carrera->por}}%  
                                  </div>
                              </div>
                              @endif
                                 @if($carrera->por>=67&&$carrera->por<=100)
                            <div class="progress ">
                                   <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$carrera->por}}%;color:black;">
                                    {{$carrera->por}}%  
                                  </div>
                              </div>
                              @endif
                         
                            </div>
                                                
                        </h4>
      </div>
  <div id="carrera_{{$carrera->id_carrera}}" class="panel-collapse collapse">
        <div class="panel-body">



           <div>TOTAL DE ALUMNOS: {{$carrera->total}}  </div>
                          <div>ALUMNOS QUE YA EVALUARON: {{$carrera->ya}}</div>
                         </br>
                        </br>

                      

<div class="container col-md-12">
  
  <ul class="nav nav-tabs">
    <li><a data-toggle="tab" href="#si{{$carrera->id_carrera}}">Alumnos que ya evaluaron</a></li>
    <li><a data-toggle="tab" href="#no{{$carrera->id_carrera}}">Alumnos que no han evaluado</a></li>
  </ul>
</br></br>
  <div class="tab-content" >
   
        <div id="si{{$carrera->id_carrera}}" class="tab-pane active">
          <table id="ejemplo{{$carrera->id_carrera}}" class="table table-bordered " Style="background: white;" >
                                   <thead>
                                          <tr>
                                                  <th class="col-md-2">No. Cuenta</th>
                                                
                                                  <th class="col-md-5">Alumno(a)</th>
                                                  <th class="col-md-1">Semestre</th>
                                                  <th class="col-md-4">Estado</th>

                                                  
                                           </tr>
                                    </thead>
                                    <tbody>
                                             @foreach($alumnos as $alu)
                                             @if($carrera->id_carrera==$alu->id_carrera&& $alu->no_pregunta==1000)
                                          <tr>

                                                  <th class="col-md-2">{{$alu->cuenta}}</th>
                                                  <th class="col-md-5">{{$alu->nombre}} {{$alu->apaterno}} {{$alu->amaterno}}</th>
                                                  <th class="col-md-1">{{$alu->id_semestre}}</th>
                                                  @if($alu->no_pregunta==1000)
                                                  <th class="col-md-4">
                                                    <div class="col-md-10">
                                                    <div class="progress ">
                                                      <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                            100%
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                      <span class="glyphicon glyphicon-ok-sign "style="color:green; font-size:18px;" aria-hidden="true"></span>
                                                      </div>
                                                    </th>
                                                    
                                                   @endif
                                                 
                                          </tr>
                                          @endif
                                          @endforeach
                                       

                                         
    
                                   </tbody>
                            </table>
     

        </div>
        <div id="no{{$carrera->id_carrera}}" class="tab-pane ">

                   <table id="ejemplos{{$carrera->id_carrera}}" class="table table-bordered " Style="background: white;" >
                                   <thead>
                                          <tr>
                                                  <th class="col-md-2">No. Cuenta</th>
                                                
                                                  <th class="col-md-5">Alumno(a)</th>
                                                  <th class="col-md-1">Semestre</th>
                                                  <th class="col-md-4">Estado</th>

                                                  
                                           </tr>
                                    </thead>
                                    <tbody>
                                             @foreach($alumnoss as $aluu)
                                             @if($carrera->id_carrera==$aluu->id_carrera&& $aluu->no_pregunta < 1000)
                                          <tr>

                                                  <th class="col-md-2">{{$aluu->cuenta}}</th>
                                                  <th class="col-md-5">{{$aluu->nombre}} {{$aluu->apaterno}} {{$aluu->amaterno}}</th>
                                                  <th class="col-md-1">{{$aluu->id_semestre}}</th>
                                                  @if($aluu->no_pregunta==1000)
                                                  <th class="col-md-4">
                                                    <div class="col-md-10">
                                                    <div class="progress ">
                                                      <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                            100%
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                      <span class="glyphicon glyphicon-ok-sign "style="color:green; font-size:18px;" aria-hidden="true"></span>
                                                      </div>
                                                    </th>
                                                    
                                                        @endif
                                                  @if($aluu->no_pregunta==0)
                                                  <th class="col-md-4"> 
                                                     <div class="col-md-10">
                                                    <div class="progress ">
                                                      <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;color:black;">
                                                            0%
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                      <span class="glyphicon glyphicon-remove-sign" style="color:red; font-size:18px;" aria-hidden="true"></span>
                                                      </div>
                                                    </th>
                     
                                                  @endif
                                                  @if($aluu->no_pregunta>=1 && $aluu->no_pregunta <=99)

                                                  <th class="col-md-4">
                                                      <div class="col-md-10">
                                                    <div class="progress">
                                                      <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$aluu->no_pregunta}}%;color:black;">
                                                            {{$aluu->no_pregunta}}%
                                                    </div>
                                                    </div>
                                                  </div>


                                                  </th>
                                                  @endif
                                          </tr>
                                          @endif
                                          @endforeach
                                       

                                         
    
                                   </tbody>
                            </table>
         
        </div>
  </div>
</div>


        </div>
      </div>
    </div>
   @endforeach
  </div>
   
</div>
    
</div>

<!--        -->
<div id="modal_evaluar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body">
        
       
                Una vez que se realicen los cálculos de la evaluación docente no se podrá realizar ningún cambio en este periodo   </div>
                    <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <input id="confirma_evaluar" type="button" class="btn btn-danger" value="Aceptar"></input>
              </div>
      
      </div>
    </div>
  </div>
</div>

<div id="modal_confirma_evaluar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body">
        
       <div class="form-group">
  <label for="pwd">Contraseña:</label>
  <input type="password" class="form-control" id="contra">
</div>

                    <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <input id="verificar" type="button" class="btn btn-danger" value="Aceptar"></input>
              </div>
      
      </div>
    </div>
  </div>
</div>


<div id="mensaje" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body">
  
         Este proceso puede demorar algunos minutos...
    <img id="logo1" src="img/loading.gif">
  
      
      </div>
    </div>
  </div>
</div>





</main>
@endsection
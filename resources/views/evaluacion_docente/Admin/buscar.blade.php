@extends('layouts.app')
@section('title', 'Inicio')
@section('content')




<script type="text/javascript">



  $(document).ready(function() {


      $('#ejemplo').DataTable();



  
} );

</script>

<main>

<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title text-center">PROFESORES EVALUACIÓN DOCENTE</h3>
        </div>         
    </div>
  </div>


  <div class=" col-md-8 col-md-offset-2">

      


                            <table id="ejemplo" class="table table-bordered " Style="background: white;" >
                                   <thead>
                                          <tr>
                                                  <th>DOCENTES</th>
                                                
                                                  <th>CONSULTAR</th>

                                                  
                                           </tr>
                                    </thead>
                                    <tbody>
                                             @foreach($profesores as$profesores)
                                          <tr>
                                                  <th>{{$profesores->nombre}}</th>
                                                 
                                                  <th class="text-center"><a href="/reportes2/{{$profesores->id_personal}}/{{1}}/{{0}}" target="_blank"><span class="glyphicon glyphicon-list-alt em6" aria-hidden="true" ></span></a></th>
                                                  
                                          </tr>
                                          @endforeach
                                       

                                         
    
                                   </tbody>
                            </table>

                
       </div>




  
</main>
@endsection
@extends('layouts.app')
@section('title', 'EvaluacionActividad')
@section('content')

<main class="col-md-12">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-info">
        <div class="panel-heading">Evaluación</div>
      </div>
    </div>
  </div>
   <form>
         <div class="row">
              <div class="col-md-10 col-md-offset-1">
               <table class="table table-bordered tabla-grande2" id="paginacion">
                  <thead>
                  <tr>
                    <th>Cuenta</th>
                    <th>Alumno</th>
                    <th>Semestre</th>
                    <th>Carrera</th>
                    <th>Actividad</th>
                    <th>Horas</th>
                    <th>No. Evidencias</th>
                    <th>Rúbrica</th>
                    <th>Promedio</th>
                    <th>Estado</th>

                  </tr>
                </thead>
                <tbody>

                  @foreach($evaluacioon as $eevaluacion)
                  <tr>
                    <td>{{$eevaluacion->cuenta}}</td>
                    <td>{{$eevaluacion->nombre}} {{$eevaluacion->apaterno}} {{$eevaluacion->amaterno}}</td>
                    <td>{{$eevaluacion->semestre}}</td>
                    <td>{{$eevaluacion->carrera}}</td>
                    <td>{{$eevaluacion->actividad}}</td>
                    <td>{{$eevaluacion->horas}}</td>
                    <td>{{$eevaluacion->evidencias}}</td>                 
                    <td><a href="{{url("/ArchivosDocentes",$eevaluacion->rubrica)}}" target="_blank"><span class="glyphicon glyphicon-file em" aria-hidden="true"></span></a> {{$eevaluacion->rubrica}}</td>
                    <td>{{$eevaluacion->promedio}}</td>
                    @if($eevaluacion->promedio == 0)
                      <td> 
                        <a type="button" class="btn btn-primary" href="{{url("/consulta_general",($eevaluacion->id_registro_alumno."/"."edit"))}}">Evaluar</a>
                      </td>
                    @endif
                    @if($eevaluacion->promedio > 0 and $eevaluacion->promedio < 101 )
                    <td>
                      Evaluado
                    </td>
                    @endif



                  </tr>
                 @endforeach 
           
                </tbody>
              </table>
            </div>
          </div>

  @if(isset($evaluacionnn))
    @section('evaluacionnn')
    @include('actividades_complementarias.profesor.evaluacion_evidencias')
    @show
  @endif
</form>


</main>

<script>
    $(document).ready(function(){
      $("#registra").click(function(event){
        $("#evalua_doc").submit();
        });

     $('#paginacion').DataTable();

    

   



    });
</script>

@endsection
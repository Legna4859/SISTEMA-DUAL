@extends('layouts.app')
@section('title', 'EvidenciasAlumnos')
@section('content')


<main class="col-md-12">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-info">
        <div class="panel-heading">Evidencias</div>
      </div>
    </div>
  </div>
@if($existe_id == 1)
@else

         <div class="row">
              <div class="col-md-10 col-md-offset-1">
               <table class="table table-bordered tabla-grande2">
                  <thead>
                  <tr>
                    <th>Actividad</th>
                    <th>Categoría</th>
                    <th>Horas</th>
                    <th>Créditos</th>
                    <th>No. Evidencias</th>
                    <th>Rúbrica</th>
                    <th></th>
                    <th>Carga Evidencias</th>
                  </tr>
                </thead>
                    <tbody>
                      @foreach($alumnos as $alumnos)
                        <tr>
                          <td>{{$alumnos->descripcion}}</td>
                          <td>{{$alumnos->descripcion_cat}}</td>
                          <td>{{$alumnos->horas}}</td>
                          <td>{{$alumnos->creditos}}</td>
                          <td>{{$alumnos->no_evidencias}}
                          </td>
                          <td>{{$alumnos->rubrica}}</td>
                          <td><a href="{{url("/ArchivosDocentes/",$alumnos->rubrica)}}" target="_blank"><span class="glyphicon glyphicon-file em"  aria-hidden="true"></span></a></td>
                          <td>

                          @for ($i=0; $i < $alumnos->faltan ; $i++)
                          <form method="POST" role="form" class="form" id="agrega_evidencia{{$i}}" enctype="multipart/form-data">
                              {{csrf_field()}}  
                            <input type="file"  name="urlImg[]" id="archivo{{$i}}" accept=""><br>
                            <button name="id_registro" type="submit" class="btn registra" href="!#" id="{{$alumnos->id_registro_alumno}}"><span class="glyphicon glyphicon-ok"  aria-hidden="true"></span></button>  <label>SUBIR EVIDENCIA</label><br>
                            <input style="display:none" id="registro_alumno" value="{{$alumnos->id_registro_alumno}}" name="registro_alumno"><br>
                          </form>
                          @endfor
                          </td>
                        </tr>
                       @endforeach
                       @endif 
                  </tbody>
          </table>
        </div>
      </div>

</main>

<script >

function bloqueo()
{
    $.blockUI({
  });
}

  $(document).ready(function(){

  @if($existe_id==0)
    @for ($i = 0; $i < ($alumnos->no_evidencias); $i++) 

                $('#archivo{{$i}}').bind('change', function() {
                  if(this.files[0].size > 2097152)
                  {
                  alert("No superar los 2MB"); 
                  this.value="";
                  
                  };
              });

//bloqueo();
    @endfor

      $('.registra').click(function(){
        var uno=$(this).attr('id');
         //alert(uno);
        bloqueo();
      });
    
@endif

 

 });

</script>

@endsection
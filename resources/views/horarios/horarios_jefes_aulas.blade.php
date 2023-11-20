@extends('layouts.app')
@section('title', 'Horarios Aulas')
@section('content')


<main class="col-md-12">
<div class="row">
  <div class="col-md-5 col-md-offset-3">
    <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title text-center">HORARIOS AULAS</h3>
        </div>
              <div class="panel-body">
                            <div class="dropdown col-md-7 col-md-offset-3">
                                <select name="selectAula" id="selectAula" class="form-control">
                                  <option disabled selected>Selecciona...</option>
                                @foreach($aulas as $aula)
                                  <option value="{{$aula->id_aula}}">{{ $aula->nombre }}</option>
                                @endforeach
                                </select>
                            </div>
                </div>
    </div>  
  </div>
</div>

@if(isset($ver))
      @section('horario_aula')
      @include('horarios.partialsh.partial_ver_aulas_jefes')
      @show
@endif

</main>

<script>
  $(document).ready(function() {

$("#selectAula").on('change',function(e){
  var aula=$("#selectAula").val();

window.location.href='/horarios_aulas/jefes/'+aula;
});

});

</script>

@endsection



@extends('layouts.app')
@section('title', 'Horarios Grupos')
@section('content')

    <script>
      $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  e.target // newly activated tab
  e.relatedTarget // previous active tab
})
    </script>

<main class="col-md-12">
<div class="row">
  <div class="col-md-5 col-md-offset-3">
    <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title text-center">HORARIOS GRUPOS</h3>
        </div>
              <div class="panel-body">
                            <div class="dropdown col-md-7 col-md-offset-3">
                                <select name="selectGrupo" id="selectGrupo" class="form-control">
                                  <option disabled selected>Selecciona...</option>
                                @foreach($grupos as $grupo)
                                  <option value="{{$grupo->id_semestre}}" name="{{$grupo->grupo}}">{{$grupo->id_semestre}}0{{$grupo->grupo}}</option>
                                @endforeach
                                </select>
                            </div>
                </div>
    </div>  
  </div>
</div>


@if(isset($ver))
      @section('horario_grupo')
      @include('horarios.partialsh.partial_ver_grupos_jefes')
      @show
@endif

</main>
<script>
$(document).ready(function(){

$("#selectGrupo").on('change',function(e){
  var semestre=$("#selectGrupo").val();
  var grupo=$("#selectGrupo option:selected").attr('name');

window.location.href='/horarios_grupos/jefes/'+semestre+'/'+grupo;
});

  });

</script>
@endsection



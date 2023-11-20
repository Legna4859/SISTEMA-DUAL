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
	<div class="col-md-7 col-md-offset-3">
		<div class="panel panel-info">
	  		<div class="panel-heading">
	    		<h3 class="panel-title text-center">HORARIOS GRUPOS</h3>
	  		</div>
		</div>	
	</div> 
</div>	

<div clas="row">
     <div class="list-group col-md-3 cont">
  @foreach($carreras as $carrera)
        <a href="#{{ $carrera ["id_carrera"] }}" role="tab" data-toggle="tab" class="list-group-item">{{ $carrera ["nombre_carrera"]}}</a>
  @endforeach   
    </div> 
        <div class="tab-content">
            @foreach($carreras as $carrera)
          <div role="tabpanel" class="tab-pane fade" id="{{ $carrera ["id_carrera"] }}">
            <div class="col-md-5 col-md-offset-1">
                  <h5 class="col-md-offset-2"><strong>{{ $carrera ["nombre_carrera"] }}</strong></h5>
                    
                      <table class="table table-bordered ml">
                          <tbody>
                            @foreach($carrera["grupos"] as $grupo) 
                            <tr>
                                <td>{{ $grupo ["id_semestre"] }}0{{ $grupo ["grupo"] }}</td>
                                <td>
                                    <a href="/horarios_grupos/{{ $grupo ["id_semestre"] }}/{{ $grupo ["grupo"] }}/{{ $carrera ["id_carrera"] }}"><span class="glyphicon glyphicon-list-alt em" aria-hidden="true"></span></a>
                                </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                        
            </div>
          </div>
                  
  @endforeach
        </div>
</div>

@if(isset($ver))
      @section('horario_grupo')
      @include('horarios.partialsh.partial_ver_grupos')
      @show
@endif

</main>

@endsection



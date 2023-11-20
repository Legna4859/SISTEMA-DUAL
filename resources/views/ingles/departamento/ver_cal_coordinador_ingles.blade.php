@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Calificaciones de Ingles')
@section('content')
<diV class="row">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">
                              <b>Calificaciones del Periodo {{$periodo->periodo_ingles}}</b>
                            </h3>
                        </div>
                    </div>
                </div>
      </div>

      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
            @foreach($carreras as $carrera)
            <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" href="#" onclick="window.location='{{ url('/ingles/departamento/mostrar_calificacion_ingles_coordinador/'.$carrera->id_carrera ) }}'" >   {{$carrera->nombre}}</a></li>
            @endforeach
          </ul>
        </div>    
      </div> 
      <div class="row">
        <p>
          <br>
          <br>
        </p>
      </div>
</diV>
@endsection

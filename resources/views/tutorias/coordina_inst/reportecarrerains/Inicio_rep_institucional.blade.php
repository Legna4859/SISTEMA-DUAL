@extends('tutorias.app_tutorias')
@section('content')
<div class="row">
                    <div class="col-3 offset-3">
                        <h3>Reporte semestral</h3>
                    </div>
</div>
<div class="row">
                    <div class="col-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <h6>{{ $carrera->nombre }}</h6>
                            <p style="text-alingn: center"> <button class="btn btn-primary" onclick= "window.location=('{{ url('')}}')" >Mostrar
                            </button></p>
                        </div>
                         </div>
                    </div>
</div>
@endsection
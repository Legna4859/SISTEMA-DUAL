@extends('tutorias.app_tutorias')
@section('content')

<div class="row">
    <div class="col-5 offset-3">
        <div class="card bg-success text-dark text-center">
            <h3 >Comentario</h3>
        </div>
    </div>
</div>
<div>
    <p></p>
</div>
<form action="{{ url('/seguimiento_tutorias/formulario/comentario/') }}" class="form" role="form" method="POST">
    {{ csrf_field() }}
    <input class="form-control" type="hidden" id="per" name="per" value=" {{ $come->per }}">
    <input class="form-control" type="hidden" id="id_asigna_tutor" name="id_asigna_tutor" value=" {{ $come->id_asigna_tutor }}">
    <div>
        <p>Observaciones:</p>
        <p>En caso de No cumplir describir en Observaciones las causas</p>
        <textarea class="form-control" rows="3" name="comentarios" id="comentarios" required></textarea>
        <p><br></p>
    </div>
    <div class="row">
        <div class="col-md-2 col-md-offset-9">
            <button type="submit" id="siguiente" class="btn btn-success">Guardar</button>
        </div>
    </div>
</form>
@endsection
@extends('tutorias.app_tutorias')
@section('content')
<form action="{{ url('/tutoras_evaluacion/auto_eveluacion/comentario/')}}" class="form" role="form" method="POST">
    {{ csrf_field() }}
    <input class="form-control" type="hidden" id="id_asigna_tutor" name="id_asigna_tutor" value=" {{ $tutores->id_asigna_tutor }}">
        <div>
            <p>Si marcó alguna de las preguntas de factores que afectan el desempeño como tutor con Nada de Acuerdo, escriba su comentario al respecto</p>
            <p>Comentarios u opiniones: A continuación, podrás expresar tus comentarios u opiniones, respecto a Fortalezas del Programa de Tutorias.</p>
            <textarea class="form-control" rows="3" name="comentario" id="comentario" required></textarea>
        <p><br></p>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-9">
                <button type="submit" id="siguiente" class="btn btn-success">Siguiente</button>
            </div>
        </div>
    </form>
@endsection
@extends('tutorias.app_tutorias')
@section('content')
<div class="row">
    <div class="col-10 offset-1">
        <div class="card bg-info text-white text-center">
            <h4 >Tutores sin registro</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-10 offset-1">
        <table class="table table-bordered table-responsive-lg">
            <tr>
                <th>Nombre del tutor</th>
            </tr>
            @foreach ($tutores as $turor)
                <tr>
                    <td>{{$turor->nombre_tutor}}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
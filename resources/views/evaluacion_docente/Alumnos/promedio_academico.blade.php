@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">PROMEDIO ACADÉMICO</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">{{$promedio_alumno}}</h3>
                </div>
            </div>
            <br>
            <br>
            <p></p>
        </div>
        <br>
        <br>
        <p></p>
    </div>


@endsection
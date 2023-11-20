@extends('layouts.app')
@section('content')
    <div align="center">
        <h2>Canalización de Tutorados</h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @foreach($datos as $carrera)
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#target_{{$carrera->id_carrera}}" aria-expanded="true" aria-controls="ISC">
                                {{$carrera->nombre}}
                            </button>
                        @endforeach
                    </div>
                    <div class="card-body row" id="content-info">
                        @foreach($carreras as $carrera)
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div id="target_{{$carrera->id_carrera}}" class="collapse" data-parent="#accordionExample">
                                        <div class="card-title">
                                            <h2 align="center">{{$carrera->grupo}}</h2>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Carrera</th>
                                                    <th scope="col">Grupo</th>
                                                    <th scope="col">Canalizar</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>{{$carrera->nombre}} {{$carrera->apaterno}} {{$carrera->amaterno}}</td>
                                                    <td>{{$carrera->siglas}}</td>
                                                    <td>{{$carrera->grupo}}</td>
                                                    <td><a href="{{url('/canalizacion/'.$carrera->id_alumno)}}">Canalizar</a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div id="container" style="width:100%; height:400px;"></div>
    </div>
@endsection
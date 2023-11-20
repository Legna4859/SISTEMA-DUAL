@extends('layouts.app')
@section('title', 'Constancias de no Adeudo')
@section('content')
    <main class="col-md-12">

        <div class="row">

            <div class="col-md-6 col-md-offset-3 ">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Verificación si tienes algun adeudo.</h3>
                    </div>
                </div>
            </div>

        </div>
        @if($adeudo == 0)
            <div class="row">

                <div class="col-md-6 col-md-offset-3 ">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">No tienes ningun adeudo puedes tramitar tu constancia de no adeudo, para los tramites correspondientes, en los departamentos: </h3>
                            <h3>Subdireccion de servicios escolares:</h3>
                            <p>-  Para tramite de Credencial</p>
                            <p>-  Para tramite Certificado </p>
                            <p></p>
                            <h3>Departamento de Titulacion:</h3>
                            <p>-  Para tramite de Titulacion</p>
                        </div>
                    </div>
                </div>

            </div>

            @elseif($adeudo == 1)
            <div class="row">

                <div class="col-md-6 col-md-offset-3 ">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">No puedes tramitar tus constancia de no adeudo para tu tramite, porque tienes adeudo con los siguientes departamentos: </h3>
                           @foreach($departamento_carrera as $departamento)

                            <h4>{{ $departamento['nombre'] }}</h4>
                            <p>{{$departamento['comentario']}}</p>

                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        @endif

    </main>

@endsection
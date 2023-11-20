@extends('layouts.app')
@section('title', 'Bienes Excel')
@section('content')
    <main class="main">
        <div class="container">
            <div class="panel panel-info">
                <div class="panel-heading center-block">
                    <h2 class="panel-title text-center" style="font-size: large">Reportes en Excel de Bienes del TESVB</h2>
                </div>
            </div>
            <div class="form-group col-md-12" align="center">

            <div class="form-group col-md-12">
                <a href="{{ url('exportar/xlsx') }}"><button class="btn btn-success">Descargar Excel formato xlsx</button></a>
            </div>
            </div>
        </div>

    </main>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>

@endsection



















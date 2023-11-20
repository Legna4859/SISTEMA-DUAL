@extends('layouts.app')
@section('title', 'Padron de Bienes')
@section('content')
    <main class="main">

        <div class="container">
            <div class="panel panel-info">

                <div class="panel-heading center-block">
                    <h2 class="panel-title text-center" style="font-size: large">Consulta de Bienes por Dependencia</h2>
                </div>
            </div>
            <div align="center" class="container-fluid">
                <!-- Formulario para Busqueda -->
                <form action="{{route('pdfp')}}" method="get" target="_blank">
                    @csrf
                    <button class="btn  btn-info"  type="submit">Imprimir Padron

                    </button>
                </form>

                <!-- Fin formulario -->
            </div>
            <br><br>
        </div>

        <div class="container-fluid" >
            <div class="container">

                <div class="card-body">
                    @if($resguardos->isEmpty())
                        <div style="text-align: center; background-color: lightgoldenrodyellow">No hay Sectores Públicos</div><br>
                    @else
                        <table class="table table-bordered table-striped table-sm" style="color: black;text-align: center; background-color: lightyellow" >
                            <thead>
                            <tr>
                                <th style="text-align: center">Departamento:</th>
                                <th style="text-align: center">Resguardatario:</th>
                                <th style="text-align: center">Puesto:</th>
                                <th style="text-align: center">Nombre del Bien:</th>
                                <th style="text-align: center">Fecha Registro:</th>
                                <th style="text-align: center">Estado Bien:</th>



                            </tr>
                            </thead>

                            <tbody>
                            @foreach($resguardos as $res)<!-- se crea un objeto para acceder a los datos-->
                            @foreach($res->bienes as $bien)
                                @foreach($res->sectores as $sector)
                                <tr>
                                    <td>{{$sector->departamentos->nom_departamento}}</td>
                                    <td>{{$sector->nombre}}</td>
                                    <td>{{$sector->puesto}}</td>
                                    <td>{{$bien->nombre}}</td>
                                    <td>{{$res->fecha}}</td>
                                    <td>
                                        @if($bien->condicion == 1)
                                            <span class="text-success">Activo</span>
                                        @else
                                            <span class="text-danger">Desactivado</span>
                                        @endif
                                    </td>
                                </tr>
                                 @endforeach
                                @endforeach
                            @endforeach
                        </table>
                        {{$resguardos->links()}}<!--para la paginacion-->

                    @endif
                </div>
            </div>
        </div>


    </main>



@endsection
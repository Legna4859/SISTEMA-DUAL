@extends('layouts.app')
@section('title', 'Tarjetas de Resguardos')
@section('content')
    <main class="main">

        <div class="container">
            <div class="panel panel-info">

                <div class="panel-heading center-block">
                    <h2 class="panel-title text-center" style="font-size: large">Impresión y Consulta de Tarjetas de Resguardo</h2>
                </div>
            </div>
            <div align="center" class="container-fluid">
                <!-- Formulario para Busqueda -->

                <!-- Fin formulario -->
            </div>
            <br>
        <div class="container-fluid" >
            <div class="container-fluid">
                <div class="card-body">
                        <table class="table table-bordered table-striped table-sm" style="color: black;text-align: center; background-color: lightyellow"  >
                            <thead>
                            <tr>

                                <th style="text-align: center">Resguardatario:</th>
                                <th style="text-align: center">Categoría:</th>
                                <th style="text-align: center">Nombre del Bien:</th>
                                <th style="text-align: center">Fecha de Resguardo:
                                <th style="text-align: center">Imprimir:</th>

                            </tr>
                            </thead>

                            <tbody>
                            @foreach($resguardos as $res)<!-- se crea un objeto para acceder a los datos-->
                            @foreach($res->sectores as $sect)
                                @foreach($res->bienes as $bien)<!-- se crea un objeto para acceder a los datos-->
                            <tr>
                                <td>{{$sect->nombre}}</td>
                                <td>{{$bien->categorias->nombre}}</td>
                                <td>{{$bien->nombre}}</td>
                                <td>{{$res->fecha}}</td>
                                <td>
                                    <form action="{{route('pdfrest',$res->id)}}" method="get" target="_blank">
                                        @csrf
                                    <button class="btn btn-sm btn-info"  type="submit">Tarjeta de Resguardo

                                    </button>
                                    </form>
                                </td>

                                <!--lo borrado-->
                            </tr>
                            @endforeach
                            @endforeach
                            @endforeach
                        </table>
                        {{$resguardos->links()}}<!--para la paginacion-->
                </div>
            </div>
        </div>

    </div>


    </main>



@endsection
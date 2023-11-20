@extends('layouts.app')
@section('title', 'Horas Docentes')
@section('content')


    <main class="col-md-12">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Horas docente por materia de las carreras <br> {{ $nombre_periodo1->periodo }}, {{ $nombre_periodo2->periodo }}</h3>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-2">
                <p><br></p>
                <a href="/formatos/excel_horas_docentes/" class="btn btn-primary" target="_blank"><span class="glyphicon glyphicon-export"  aria-hidden="true"></span>Exportar Excel</a>
                <p><br></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="c tabla-grande table-responsive">
                    <table class="table table-bordered tabla-grande3">
                        <tr>
                            <th>PE</th>
                            <th>Categoria</th>
                            <th>Docente</th>
                            <th>Periodo</th>
                            <th>Semestre</th>
                            <th>Asignatura</th>
                            <th>Grupos</th>
                            <th>Horas X Asignatura</th>
                            <th>Total</th>
                        </tr>


                        @foreach($carreras_periodo as $carreras)
                            @foreach($carreras["docentes"] as $docente)
                                @foreach($docente["materias"] as $materia)
                                <tr>
                                    <td>{{ $carreras["nombre_carrera"] }}</td>
                                    <td>{{ $docente["cargo"] }}</td>
                                    <td>{{ $docente["nombre"] }}</td>
                                    <td>{{ $docente["nombre_periodo"] }}</td>
                                    <td>{{ $materia["id_semestre"] }}</td>
                                    <td>{{ $materia["nombre_materia"] }}</td>
                                    <td>{{ $materia["no_grupos"] }}</td>
                                    <?php $suma_horas= $materia["hrs_practica"]+$materia["hrs_teoria"];?>
                                    <td>{{ $suma_horas }}</td>
                                    <td>{{ $materia["t_lic"] }}</td>

                                </tr>
                                @endforeach
                            @endforeach
                        @endforeach

                    </table>
                </div>

            </div>


        <!--<div class="col-md-3 col-md-offset-5 ml">
               <button type="button" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
        </div>-->

        </div>
    </main>


@endsection

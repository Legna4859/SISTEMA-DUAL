@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
                            <div class="row">
                                <div class="col-md-10 col-xs-10 col-md-offset-1">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h3 class="panel-title text-center">PROMEDIOS DE LOS ALUMNOS POR PERIODO <br> {{$nombre_carrera}}</h3>
                                            <?php $nperiodo = Session::get('nombre_periodo');?>
                                            <h5 class="panel-title text-center">({{$id_semestre}} SEMESTRE) <br> PERIODO:{{ $nperiodo }} </h5>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 col-md-offset-6">
                                    <a href="/servicios_escolares/promedio_alumnos_semestres_excel/{{$id_carrera}}/{{$id_semestre}}/" class="btn btn-success">Exportar Promedios <span class="oi oi-document p-1"></span></a>


                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-xs-10 col-md-offset-2">
                                <table class="table table-striped col-md-12">
                                    <thead class="">
                                    <tr class="text-center">
                                        <th  >NP.</th>
                                        <th  >No. CTA</th>
                                        <th >ALUMNO</th>
                                        <th >PROMEDIO</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($array_datos_alumnos as $alumno)
                                        <tr class="">
                                            <td>{{$alumno['numero1']}}</td>
                                            <td>{{$alumno['cuenta']}}</td>
                                            <td>{{$alumno['apaterno']}} {{$alumno['amaterno']}} {{$alumno['nombre']}}</td>
                                            <td >{{$alumno['promedio_final']}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                            </div>

@endsection
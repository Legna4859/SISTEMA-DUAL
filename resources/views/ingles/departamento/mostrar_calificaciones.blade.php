@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Historial de Calificaciones de ingles')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">HISTORIAL DE CALIFICACIONES <br>DE LA CARRERA:  {{ $carrera->nombre }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/ingles/historial_academico_alumno")}}">Programa de Estudio </a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Historial de Calificaciones</span>
            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-md-offset-6">
            <a href="/ingles/historial_calificaciones_excel/{{$id_carrera}}" class="btn btn-success">Exportar concentrado <span class="oi oi-document p-1"></span></a>


        </div>
    </div>

        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <table class="table table-bordered col-md-12" id="mostrar_calificaciones">
                        <thead class="">
                        <tr class="text-center">
                            <th class="text-center">NP.</th>
                            <th class="text-center">No. CTA</th>
                            <th class="text-center">ALUMNO</th>
                           @foreach($periodos as $periodo)
                                <th class="text-center">NIVEL Y GRUPO</th>
                                <th class="text-center">{{ $periodo->periodo_ingles }}
                                </th>
                            @endforeach


                        </tr>
                        <tbody>

                        @foreach($array_alumnos as $alumno)

                            <tr class="text-center" style=" color: #0c0c0c">
                                <td class="text-center">{{$alumno['numero']}}</td>
                                <td class="text-center "> {{$alumno['cuenta']}}</td>
                                <td class="text-left">{{$alumno['nombre']}}</td>

                                @foreach($alumno['calificaciones'] as $calificacion)
                                    @if($calificacion['estado_periodo'] == 0)
                                        <td class="text-left" style="color: #942a25; background: orange" >No registro </td>
                                        <td class="text-left" style="color: #942a25; background: orange">No registro </td>
                                        @else
                                        <td class="text-left">{{$calificacion['descripcion']}}</td>
                                        @if($calificacion['calificacion'] >= 80)
                                            <td class="text-left">{{$calificacion['calificacion']}}</td>
                                        @else
                                            <td class="text-left" style="background:red">{{$calificacion['calificacion']}}</td>
                                        @endif
                                    @endif
                                @endforeach

                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <script type="text/javascript">
        $(document).ready(function()
        {
            $('#mostrar_calificaciones').DataTable();
        });
    </script>
@endsection

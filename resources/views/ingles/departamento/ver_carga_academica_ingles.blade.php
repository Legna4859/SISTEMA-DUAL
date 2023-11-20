@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Revisión de Carga academica ingles')
@section('content')
    <main class="col-md-12">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Carga Academica de  Ingles del estudiante: {{ $datosalumno[0]->nombre }} {{ $datosalumno[0]->apaterno }} {{ $datosalumno[0]->amaterno }} <br>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Facilitador: {{ $profesor->nombre }} {{ $profesor->apellido_paterno }} {{ $profesor->apellido_materno }} <br>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
            <div class="row" id="consultar">
                <div class="col-md-10 col-md-offset-1">
                    <br>
                    <table id="table_enviado" class="table table-bordered text-center" style="table-layout:fixed;">
                        <thead>
                        <tr>
                            <th>Hora/Día</th>
                            <th>Lunes </th>
                            <th>Martes</th>
                            <th>Miercoles</th>
                            <th>Jueves</th>
                            <th>Viernes</th>
                            <th>Sabado</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $contador=1 ?>

                        @foreach($semanas as $semana)
                            @if($contador==1)
                                <tr>
                                    <td class="horario">{{ $semana->hora }}</td>
                                    @endif
                                    <td id="{{ $semana->id_semana }}" class="horario">
                                        @foreach($array_ingles as $horario_ingles)
                                            @if($horario_ingles['id_semana']==$semana->id_semana)
                                                @if($horario_ingles['disponibilidad'] ==2)

                                                    <div class="bg-success">{{$horario_ingles['nivel']}} <br><b>GRUPO:</b>{{$horario_ingles['grupo']}}<br>

                                                    </div>
                                                @elseif($horario_ingles['disponibilidad'] == 3 )
                                                    <div class="">
                                                    </div>

                                                @endif



                                            @endif
                                        @endforeach

                                    </td>


                                    <?php $contador++?>
                                    @if($contador==7)
                                    <?php $contador=1 ?>
                                    </td>


                                </tr>
                            @endif

                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
    </main>


@endsection
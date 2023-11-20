@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Faciltadores de ingles')
@section('content')
    <main class="col-md-12">

        <div class="row">
            <div class="col-md-2  col-md-offset-1 ">

                        <a href="{{url('/ingles/mostrar_horarios_profesores')}}"><span class="glyphicon glyphicon-circle-arrow-left" style="font-size: 25px; margin: 5px;" aria-hidden="true"></span>Regresar </a>



            </div>

            <div class="col-md-6 ">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Horario de {{ $profesor->nombre}} {{$profesor->apellido_paterno }} {{$profesor->apellido_materno }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2 " id="imprimir" style="display: block;">
                <div class="panel panel-default">
                    <div class="panel-heading text-center" >
                        <a href="/ingles_horarios/pdf_profesor_horarios/{{ $profesor->id_profesores }}" class="btn btn-primary crear" target="_blank"><span class="glyphicon glyphicon-print"  aria-hidden="true"></span> Imprimir</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="consultar">
            <div class="col-md-11 col-md-offset-1">

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
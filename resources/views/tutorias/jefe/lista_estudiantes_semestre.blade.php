@extends('tutorias.app_tutorias')
@section('content')
    <div class="row">
        <div class="col-md-10 offset-1">
            <div class="alert alert-primary">
                <h3 style="text-align: center"> Lista de asistencia del periodo {{ $nombre_periodo->periodo }}</h3>
                <h4 style="text-align: center"> Carrera: {{ $nombre_periodo->carrera }}</h4>
                <h4 style="text-align: center"> Grupo: {{ $datos_grupo->grup }}</h4>
                <p style="text-align: center">   <button type="button" class="btn btn-success" onclick="window.open('{{ url('/tutorias/descargar_lista_asistenacia/'.$id_asigna_tutor ) }}')">Lista de asistencia</button></p>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 offset-1">
            <table class="table table-bordered table-sm">
                <thead>
                <tr>
                    <th>NO.</th>
                    <th>NO. CTA</th>
                    <th>NOMBRE DEL ESTUDIANTE</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1?>
                @foreach($estudiantes as $estudiante)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $estudiante->cuenta }}</td>
                    <td>{{ $estudiante->apaterno }} {{ $estudiante->amaterno }} {{ $estudiante->nombre }}</td>

                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endsection
<table class="table table-bordered col-md-12">
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
                    <td class="text-left" style="color: #942a25; " >No registro </td>
                    <td class="text-left" style="color: #942a25;">No registro </td>
                @else
                    <td class="text-left">{{$calificacion['descripcion']}}</td>
                    @if($calificacion['calificacion'] >= 80)
                        <td class="text-left">{{$calificacion['calificacion']}}</td>
                    @else
                        <td class="text-left" style="background: #942a25">{{$calificacion['calificacion']}}</td>
                    @endif
                @endif
            @endforeach

        </tr>

    @endforeach

    </tbody>
</table>
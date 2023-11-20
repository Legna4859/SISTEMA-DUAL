<table id="table_enviado" class="table table-bordered text-center" style="table-layout:fixed;">
    <thead>
    <tr>
        <th style="text-align: center; color: black;"> No. cuenta</th>
        <th style="text-align: center; color: black;"> Nombre del Estudiante</th>
        <th style="text-align: center; color: black;"> Linea de Captura</th>
        <th style="text-align: center; color: black;"> Fecha de Entrega (Finanzas)</th>
        <th style="text-align: center; color: black;"> Tipo de Formato de Pago</th>
    </tr>
    </thead>
    <tbody>
    @foreach($alumnos as $alumno)
        <tr>
            <td>{{ $alumno->cuenta }}</td>
            <td style="text-align: center;text-transform: capitalize !important;color: black;">{{ $alumno->nombre }} {{ $alumno->apaterno }} {{ $alumno->amaterno }}</td>
            <td style="text-align: center;color: black;">{{ $alumno->linea_captura}}</td>
            <td style="text-align: center; color: black;">{{ $alumno->fecha_cambio }}</td>
            @if($alumno->id_tipo_voucher == 1)
                <td style="text-align: center; color: black;">Original</td>
            @elseif($alumno->id_tipo_voucher == 2)
                <td style="text-align: center; color: black;">Copia</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
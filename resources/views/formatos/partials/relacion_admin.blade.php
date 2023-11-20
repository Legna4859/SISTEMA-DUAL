<table>
  <tr>
    <th>Carrera: </th>
    <th>{{ $ncarrera }}</th>
  </tr>
  <tr>
    <th>RELACIÓN DE PERSONAL DOCENTE</th>
  </tr>
</table>

<table class="table table-bordered tabla-grande3">
<tr>
        <th rowspan="2">NO CONTROL</th>
        <th>PERIODO ESCOlAR: {{ $periodo }}</th>
        <th rowspan="2">NOMBRAMIENTO</th>
        <th rowspan="2">FECHA DE INGRESO AL I.T.S</th>
        <th rowspan="2">CODIGO DE PLAZA</th>
        <th rowspan="2">TOTAL DE HORAS POR NOMBRAMINTO</th>
        <th colspan="2">NUMERO DE HORAS FRENTE A GRUPO</th>
        <th colspan="2">FACTIBILIDAD DE INCREMENTAR HORAS FRENTE A GRUPO CONFORME A SU CATEGORIA</th>
        <th rowspan="2">MATERIAS QUE IMPARTE</th>
        <th rowspan="2">DIVISION O DPTO</th>
        <th colspan="2">HORAS SEMESTRES POR MATERIA</th>
        <th rowspan="2">CANTIDAD DE GRUPOS</th>
        <th rowspan="2">CARRERA</th> 
        <th rowspan="2"> ESCOLARIDAD DEL PROFESOR</th>

    </tr>    
    <tr>
      <th></th>
        <th>NOMBRE DEL PROFESOR</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>LIC.</th>
        <th>POSG.</th>
        <th>SI/NO</th>
        <th>CAUSA</th>
        <th></th>
        <th></th>
        <th>T</th>
        <th>P</th>

    </tr>

    @foreach($docentes as $docente)
      @foreach($docente["materias"] as $mates)
  <tr>
    <td>{{ $docente["clave"] }}</td>
    <td>{{ $docente["nombre"] }}</td>
    <td class="text-center">{{ $docente["nombramiento"] }}</td>
    <td>{{ $docente["fecha_ingreso"] }}</td>
    <td>{{ $docente["codigo"] }}</td>
    <td>{{ $docente["hrs_max"] }}</td>
    <td>{{ $mates["t_lic"] }}</td>
    <td>0</td>
    <td>{{ $docente["caso"] }}</td>
    <td>{{ $docente["causa"] }}</td>
    <td>{{ $mates["nombre_materia"] }}</td>
    <td>{{ $ncarrera }}</td>
    <td>{{ $mates["hrs_teoria"] }}</td>
    <td>{{ $mates["hrs_practica"] }}</td>
    <td>{{ $mates["no_grupos"] }}</td>
    <td>{{ $ncarrera }}</td>
    <td>{{ $docente["escolaridad"] }}</td>
  </tr>
    @endforeach
  @endforeach
<tr>
  <td colspan="2">TOTALES</td>
  <td></td>
  <td></td>
  <td></td>
  <td>{{ $t_nombra }}</td>
  <td>{{ $total_lic }}</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td colspan="2">{{ $t_hrs }}</td>
  <td></td>
  <td></td>

</tr>

</table> 


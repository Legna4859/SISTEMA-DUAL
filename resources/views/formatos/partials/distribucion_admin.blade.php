<table>
  <tr>
    <th>Carrera: </th>
    <th>{{ $carreran }}</th>
  </tr>
  <tr>
    <th>DISTRIBUCIÓN DE HORAS FRENTE A GRUPO CUBIERTAS Y DE NECESIDAD</th>
  </tr>
</table>

  <table class="table table-bordered table-hover tabla-grande3 ">
  <tr>
    <th rowspan="2">SEMESTRE</th>
    <th>PERIODO ESCOlAR: {{ $periodo }}</th>
    <th rowspan="2">HRS SEMESTRALES POR MATERIA</th>
    <th rowspan="2">NO. GRUPOS POR MATERIAS</th>
    <th rowspan="2">CANTIDAD TOTAL DE ALUMNOS POR MATERIA</th>
    <th rowspan="2">CUANDO EN LOS GUPOS EXISTAN ALUMNOS DE OTRAS CARRERAS INDICAR EL NOMBRE DE ESTAS PARA EVITAR QUE LOS GRUPOS SE DUPLIQUEN</th>
    <th rowspan="2">INDICAR EL NUMERO DEL PROFESOR QUE IMPARTE LA MATERIA SEGUN GRUPOS QUE ATIENDA. EL NUMERO DE PROFESOR DEBERA CONICIDIR CON EL ASIGNADO EN LA RELACION DE PERSONAL DOCENTE (FORMATO 03,04,05 ó 06)</th>
    <th colspan="4">TOTAL DE HORAS FRENTE A GRUPO CUBIERTAS POR PERSONAL CON CATEGORIA:</th>
  </tr>
  <tr>
    <th>NOMBRE DE LAS MATERIAS QUE SE OFRECEN POR SEMESTRE</th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th>DOCENTE</th>
    <th>DIRECTIVO</th>
    <th>ATM</th>
    <th>HONORARIOS</th>
  </tr>
  @foreach($materiass as $materia)
      <?php $num_col=count($materia["claves"]); 
          $first=true;
    ?>
        @foreach($materia["claves"] as $mat_clave)
@if($first)
  <?php $first=false;?>

  <tr>
    <td rowspan="{{ $num_col }}">{{ $materia ["id_semestre"] }}</td>
    <td rowspan="{{ $num_col }}">{{ $materia ["nombre_materia"] }}</td>
    <td rowspan="{{ $num_col }}">{{ $materia ["horas_totales"] }}</td>
    <td rowspan="{{ $num_col }}">{{ $materia ["no_grupos"] }}</td>
    <td rowspan="{{ $num_col }}">{{ $materia ["cantidad"] }}</td>
    <td rowspan="{{ $num_col }}">0</td>
    <td>{{ $mat_clave["clave"] }} <br></td>
    <td rowspan="{{ $num_col }}">{{ $materia ["total"] }}<br></br> </td>
    <td rowspan="{{ $num_col }}">0</td>
    <td rowspan="{{ $num_col }}">0</td>
    <td rowspan="{{ $num_col }}">0</td>
  </tr>
@else
<tr>
    <td>{{ $mat_clave["clave"] }}</td>
</tr>
@endif
      @endforeach
@endforeach
  <tr>
    <td>9</td>
    <td>RESIDENCIA PROFESIONAL</td>
    <td>{{ $resi_hrs }}</td>
    <td>{{ "N.A" }}</td>
    <td>0</td>
    <td>0</td>
    <td>
      @foreach($residencia as $resi)
        {{ $resi["claver"] }} <br></br>
      @endforeach
      </td>
    <td>{{ $resi_hrs }}</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
  </tr>
  <tr>
    <td colspan="2" class="text-center">TOTALES</td>
    <td>{{ $total_matr }}</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>{{ $t_tr }}</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table> 


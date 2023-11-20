<table>
  <tr></tr>
  <tr></tr>
  <tr></tr>
  <tr></tr>
  <tr></tr>
</table>
<table>
  <tr>
    <th></th>
    <th></th>
    <th></th>
    <th>{{ $etiqueta->descripcion }}</th>
  </tr>
  <tr>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th>PLANTILLA DOCENTE</th>
    </tr>
    <tr></tr>
    <tr>
    <th></th>
    <th>CARGO:  {{$impr_cargo}}</th>
    <th></th><th></th><th></th><th></th>
    <th></th><th></th><th></th><th></th>
    <th>PERIODO:  {{$periodo}}</th>
  </tr>
</table>
    <table class="table table-bordered table-hover tabla-grande">
  <tr>
    <th></th>
    <th>Nombre</th>
    <th>Asignatura</th>
    <th>No. Grupos</th>
    <th>NO. HORAS X ASIGNATURA</th>
    <th>TOTAL HORAS X ASIGNATURA</th>
    <th>TOTAL HORAS DOCENTE</th>
    <th>RFC</th>
    <th>CLAVE ISSEMYM</th>
    <th>FECHA INGRESO TESVB</th>
    <th>FECHA NUEVO C.</th>
    <th>PERFIL</th>
    <th>OBSERVACIONES</th>
  </tr>
 
@foreach($docentes as $docente)
    <?php
    $num_col=count($docente["materias"]);
    $first=true;
    ?>
  @foreach($docente["materias"] as $dat_materia)
  
    @if($first)
    <?php $first=false;?>
    <tr>
      <td></td>

      <td rowspan="{{ $num_col }}" valign="middle">{{ $docente["nombre"]}}</td>
      <td>{{ $dat_materia['nombre_materia'] }}</td>
      <td>{{ $dat_materia['no_grupos'] }}</td>
      <td>{{ $dat_materia['horas_totales'] }}</td>
      <td>{{ $dat_materia['total'] }}</td>
      <td valign="middle" rowspan="{{ $num_col }}">{{ $docente["f_total"]}}</td>
      <td valign="middle" rowspan="{{ $num_col }}">{{ $docente["rfc"]}}</td>
      <td valign="middle" rowspan="{{ $num_col }}">{{ $docente["clave"]}}</td>
      <td valign="middle" rowspan="{{ $num_col }}">{{ $docente["fch_ingreso_tesvb"]}}</td>
      <td valign="middle" rowspan="{{ $num_col }}">{{ $fecha_nuevo }}</td>
      <td valign="middle" rowspan="{{ $num_col }}">{{ $docente["descripcion"]}}</td>
      <td valign="middle" rowspan="{{ $num_col }}">{{ $docente["observaciones"] }}</td>
    </tr>
    @else
    <tr>
      <td></td>
      <td></td>
      <td>{{ $dat_materia['nombre_materia'] }}</td>   
      <td>{{ $dat_materia['no_grupos'] }}</td>
      <td>{{ $dat_materia['horas_totales'] }}</td>
      <td>{{ $dat_materia['total'] }}</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    @endif
  @endforeach
@endforeach
</table>

<table>
  <tr>
    <th></th>
    <th align="right">Totales:</th>
    <th align="left">{{$total_plantilla}}</th>
  </tr>
</table>

<table>
  <tr>
    <th></th>
    <th></th>
    <th align="center">{{"ELABORÓ"}}</th>
    <th></th>
    <th></th>
    <th align="center">{{"REVISÓ"}}</th>
    <th></th>
    <th></th>
    <th></th>
    <th align="center">{{"AUTORIZÓ"}}</th>
  </tr>
  <tr></tr>
  <tr></tr>
  <tr></tr>
  <tr>
    <th></th>
    <th></th>
    <th align="center">{{$jefe}}</th>
    <th></th>
    <th></th>
    <th align="center">{{"I.Q. LORENA GUADARRAMA SALAZAR"}}</th>
    <th></th>
    <th></th>
    <th></th>
    <th align="center">{{"DR. LÁZARO ABNER HERNÁNDEZ REYES"}}</th>
  </tr>
  <tr>
    <th></th>
    <th></th>
    <th align="center">{{$jefatura}}</th>
    <th></th>
    <th></th>
    <th align="center">{{"SUBDIRECCIÓN DE ESTUDIOS PROFESIONALES"}}</th>
    <th></th>
    <th></th>
    <th></th>
    <th align="center">{{"DIRECCIÓN ACADÉMICA"}}</th>
  </tr>
</table>
  
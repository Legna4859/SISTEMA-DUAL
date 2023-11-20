<table  class="table table-bordered tabla-grande3">

    <thead>
    <tr>
        <th>No.</th>
        <th>NO. CUENTA</th>
        <th>NOMBRE DEL ALUMNO</th>
        <th>PROMEDIO</th>

    </tr>

    </thead>
    <tbody>
    @foreach($array_datos_alumnos as $alumno)
    <tr class="">
        <td>{{$alumno['numero1']}}</td>
        <td > {{$alumno['cuenta']}}</td>
        <td > {{$alumno['apaterno']}} {{$alumno['amaterno']}} {{$alumno['nombre']}} </td>
        <td >{{$alumno['promedio_final']}}</td>


    </tr>
    @endforeach



    </tbody>






</table>
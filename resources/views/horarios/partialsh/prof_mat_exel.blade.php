
    <table id="paginar_table" class="table table-bordered">
                          <thead>
                            <tr>
                                <th>No.</th>
                                <th>Grado</th>  
                                <th>Nombre Completo</th> 
                                <th>Cédula</th>
                                <th>Materias</th>
                                <th>Unidades</th>
                                <th>Grupo</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $contador=1;  ?>
                            @foreach($relacion as $rel)
                            <tr>
                              <td>{{ $contador }}</td>
                              <td>{{$rel->descripcion}}</td>
                              <td>{{$rel->nombre}}</td>
                              <td>{{$rel->cedula}}</td>
                              <td>{{$rel->materia}}</td>
                              <td>{{$rel->unidades}}</td>
                              <td>{{$rel->grupo}}</td>
                              <?php $contador++; ?>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>  


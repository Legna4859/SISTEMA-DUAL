<table  class="table table-bordered tabla-grande3">
    <?php $num_celda=($mat_calificada*2)+1 ?>
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            @foreach($array_mat as $mat)
                <th style="background: #a3b0c9"> {{$mat['clave']}}</th>
                <th></th>
            @endforeach
            <th>CLAVE MAT</th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            @foreach($array_mat as $mat)
                <th style="background: #a3b0c9"> {{$mat['nombre']}}</th>
                <th></th>
            @endforeach
            <th>DOCENTE</th>
        </tr>


        <tr>
        <th >NP.</th>
        <th>No. CTA</th>
        <th>ALUMNO</th>
            @foreach($array_mat as $mat)
                <th style="background: #a3b0c9">{{$mat['nombre_materia']}}</th>
                <th>TE</th>
            @endforeach
            <th>PROMEDIO</th>
        </tr>
    </thead>
    <tbody>
    @foreach($materias_calificaciones as $alumno)
        <tr class="">
            <td>{{$alumno['numero']}}</td>
            <td class="text-center" style=" {!! $alumno['estado_alumno']==2 ? 'background:#ffee62; color:FFA500' : ($alumno['estado_alumno']==3 ? 'background:#a94442; color:#FFFFFF' : '') !!} "> {{$alumno['cuenta']}}</td>
            <td >{{$alumno['nombre']}}</td>
            @foreach($alumno['l'] as $calificacion)
                @if($calificacion['estado'] == 1)

                    <td style="background: #000000; color: #FFFFFF; text-align: center;">NO cursa</td>
                    <td style="background: black; color: white;text-align: center;"></td>
                @else
                    @if($calificacion['promedio'] < 70)
                        <td style="background: #FF0000; color: #FFFFFF;text-align: center;">N.A.</td>
                    @else

                        <td style="text-align: center;">{{$calificacion['promedio']}}</td>
                    @endif
                    <td style="text-align: center;">{{$calificacion['te']}}</td>
                @endif

            @endforeach
            @if($alumno['estado_validacion'] == 10)
                <td style="background: #FF0000; color:#000000;text-align: center;">BAJA</td>

            @else
                @if($alumno['promedio_f'] < 70)
                    <td style="background: #FF0000; color: #000000;text-align: center;">{{ $alumno['promedio_f']  }}</td>
                @else
                    <td style="text-align: center;">{{$alumno['promedio_f']}}</td>
                @endif
            @endif

        </tr>
    @endforeach
    <?php  $numero_materia=0;
    $creditos_finales=0;
    $total_creditos_grupo=0;
    $total_aprobados_grupo=0;
    ?>
    <tr>
        <td colspan="3" class="text-right" >
            Meta real
        </td>
        @foreach($com as $califi)
            <td class="text-right" >
                <?php  $numero_materia++;
                $creditos_finales+=$califi['creditos'];?>

                @if($califi['aprobados']==0)
                    0%
                @else
                    <?php $meta_real=($califi['aprobados']*100)/$califi['total'];
                    $meta_real=number_format($meta_real, 2, '.', ' ');?>
                    {{ $meta_real }}%
                @endif


            </td>
            <td></td>
        @endforeach
        <td><?php $indice_final_aprobacion=($numero_promedio_aprobado*100)/$numero_alumno;
            $indice_final_aprobacion=number_format($indice_final_aprobacion, 2, '.', ' ');?>
            {{ $indice_final_aprobacion }}%
        </td>
    </tr>
    <tr>
        <td colspan="3" class="text-right" >
            Alumnos que cursan la materia
        </td>
        @foreach($com as $califi)
            <td class="text-right" >
                {{$califi['total']}}
            </td>
            <td></td>
        @endforeach
        <td>{{ $numero_alumno }}</td>
    </tr>
    <tr>
        <td colspan="3" class="text-right" >
            Alumnos aprobados
        </td>
        @foreach($com as $califi)
            <td class="text-right" >
                {{$califi['aprobados']}}
            </td>
            <td></td>
        @endforeach
        <td>{{ $numero_promedio_aprobado }}</td>
    </tr>
    <tr>
        <td colspan="3" class="text-right" >
            Alumnos reprobados
        </td>
        @foreach($com as $califi)
            <td class="text-right" >
                {{$califi['reprobados']}}
            </td>
            <td></td>
        @endforeach
        <td>{{ $numero_promedio_reprobado }}</td>
    </tr>
    <tr>
        <td colspan="3" class="text-right" >
            Indice de Reprobación
        </td>
        @foreach($com as $califi)
            <td class="text-right" >
                @if($califi['reprobados']==0)
                    0%
                @else
                    <?php $indice_r=($califi['reprobados']*100)/$califi['total'];
                    $indice_r=number_format($indice_r, 2, '.', ' ');?>
                    {{ $indice_r }}%
                @endif
            </td>
            <td></td>
        @endforeach
        <td>
            <?php $indice_final_reprobacion=($numero_promedio_reprobado*100)/$numero_alumno;
            $indice_final_reprobacion=number_format($indice_final_reprobacion, 2, '.', ' ');?>

            {{ $indice_final_reprobacion }}%
        </td>
    </tr>
    <tr>
        <td colspan="3" class="text-right" >
            Promedio de la materia
        </td>
        @foreach($com as $califi)
            <td class="text-right" >
                @if($califi['total']==0)
                    0.00
                @else
                    <?php $promedio=($califi['suma_promedios'])/$califi['total'];
                    $promedio=number_format($promedio, 2, '.', ' '); ?>
                    {{ $promedio }}
                @endif
            </td>
            <td></td>
        @endforeach
        <td>
            @if($promedio_general ==0)
                0.00
            @else
                <?php  $pro_f=$promedio_general;
                $pro_f=number_format($pro_f, 2, '.', ' ');?>
                {{$pro_f}}
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="3" class="text-right" >
            Alumnos baja
        </td>
        @foreach($com as $califi)
            <td class="text-right" >
                {{$califi['bajas']}}
            </td>
            <td></td>
        @endforeach
        <td> {{ $bajas }}</td>
    </tr>
    <tr>
        <td colspan="3" class="text-right" >
            Indice de Deserción
        </td>
        @foreach($com as $califi)
            <td class="text-right" >
                @if($califi['bajas']==0)
                    0%
                @else
                    <?php $indice_desercion=($califi['bajas']*100)/($califi['total']+$califi['bajas']);
                    $indice_desercion=number_format($indice_desercion, 2, '.', ' ');?>
                    {{ $indice_desercion }}%
                @endif
            </td>
            <td></td>
        @endforeach
        <td>
            @if($bajas ==0)
                0.00 %
            @else
                <?php  $total_al=$numero_alumno+$bajas;
                $indice_desercion_final=($bajas*100)/$total_al;
                $indice_desercion_final=number_format($indice_desercion_final, 2, '.', ' ');?>
                {{ $indice_desercion_final }} %
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="3" >
            Creditos por materia
        </td>
        @foreach($com as $califi)
            <td >
                {{$califi['creditos']}}
            </td>
            <td></td>
        @endforeach
        <td>{{ $creditos_finales }}</td>
    </tr>
    <tr>
        <td colspan="3"  >
            Total de creditos cursados en la materia
        </td>
        @foreach($com as $califi)
            <td>
                <?php $total_creditos=$califi['creditos']*$califi['total']; $total_creditos_grupo+=$total_creditos;?>{{$total_creditos}}
            </td>
            <td></td>
        @endforeach
        <td>{{$total_creditos_grupo}}</td>
    </tr>
    <tr>
        <td colspan="3"  >
            Total de creditos aprobados
        </td>
        @foreach($com as $califi)
            <td  >
                <?php $total_creditos_a=$califi['creditos']*$califi['aprobados']; $total_aprobados_grupo+=$total_creditos_a;?>{{$total_creditos_a}}  </td>
            <td></td>
        @endforeach
        <td>{{ $total_aprobados_grupo }}</td>
    </tr>
    <tr>





    <tr>

    </tbody>






</table>
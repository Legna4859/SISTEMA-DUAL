<table>
    <tr><th ></th>
        <th >Profesor</th>
        <th >{{ $nom_docente }}</th>

    </tr>
    <tr><th ></th>
        <th >Materia</th>
        <th >{{ $nom_materia }}</th>

    </tr>
    <tr> <th ></th>
        <th >Grupo:</th>
        <th >{{ $grupo }}</th>

    </tr>
    <tr> <th ></th>
        <th >Carrera:</th>
        <th >{{ $nom_carrera }}</th>

    </tr>
    <tr> <th ></th>


    </tr>

</table>
<table>
    <thead >
    <tr >
        <th >NP.</th>
        <th >No. CTA</th>
        <th >ALUMNO</th>
        @for ($i = 0; $i < $unidades; $i++)
            <th >UNIDAD
                {{($i==0 ? 'I' :
                    ($i==1 ? 'II' :
                        ($i==2 ? 'III' :
                            ($i==3 ? 'IV' :
                                ($i==4 ? 'V' :
                                    ($i==5 ? 'VI' :
                                        ($i==6 ? 'VII' :
                                            ($i==7 ? 'VIII' :
                                                ($i==8 ? 'IX' :
                                                    ($i==9 ? 'X' :
                                                        ($i==10 ? 'XI' :
                                                            ($i==11 ? 'XII' :
                                                                ($i==12 ? 'XIII' :
                                                                    ($i==13 ? 'XIV' :
                                                                        ($i==14 ? 'XV' : ' ' )))))))))))))))}}
            </th>
        @endfor
        <th >PROMEDIO</th>
        <th>T.E.</th>
    </tr>
    <tbody>
    <?php  $porcentaje_gen=0; $cont_gen=0;?>
    @foreach($alumnos as $alumno)
        <tr >
            <td >{{$alumno['np']}}</td>
            <td style=" {!! $alumno['curso']=='REPETICION' ? 'background:#ffee62; color:orange' : ($alumno['curso']=='ESPECIAL' ? 'background:#a94442; color:white' : '') !!} "> {{$alumno['cuenta']}}</td>
            @if($alumno['estado_validacion'] == 9)
                <td class="text-left" style="background: #0089ec;">{{$alumno['nombre']}}</td>
            @else
                <td >{{$alumno['nombre']}}</td>
            @endif
            <?php  $cont=0; ?>
            @forelse($alumno['calificaciones'] as $calificacion)
                <?php  $cont++; ?>
                @if(($cont)<=$unidades)
                    @if( ($cont)==$calificacion['id_unidad'])
                        <td style="background: {{ $calificacion['calificacion']>=70 ? 'background:#FFFFFF; ' : '#FFEE62' }}" data-id-eval="{{ $calificacion['id_evaluacion'] }}" data-id-unidad="{{ $calificacion['id_unidad'] }}">
                            {{ $calificacion['calificacion']>=70 ? $calificacion['calificacion'] : 'N.A'  }}
                        </td>
                    @else

                    @endif
                @else

                @endif
            @empty

            @endforelse
            <?php  $unidades_restantes=$unidades-$cont; ?>
            @for ($i = 0; $i < $unidades_restantes; $i++)
                @if($alumno['baja'] == 1)
                    <td style="background:#ffff00;">N.A</td>
                @else
                    <td>0</td>
                @endif
            @endfor
            @if($alumno['baja'] == 1)
                <td style="background:#FF0000;">BAJA</td>
            @else
                @if($alumno['promedio']>=70 and $alumno['repeticion'] == false)
                    <td>{{ $alumno['promedio'] }}</td>
                @else
                    <td style="background: #a94442; ">N.A</td>
                @endif   @endif
            <td>{!! $alumno['curso']=='NORMAL' && $alumno['esc_alumno'] ? 'ESC'  : ( $alumno['curso']=='NORMAL' ? 'O'  : ($alumno['curso']=='REPETICION' && $alumno['esc_alumno'] ? 'ESC2' : ($alumno['curso']=='REPETICION' ? 'O2' : ($alumno['curso']=='ESPECIAL' ? 'CE' : ($alumno['curso']=='GLOBAL' ? 'EG': '' )))))!!}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="3"></td>
        @foreach($porcentajes as $porcentaje)
            <td  style="background: {{ $porcentaje['porcentaje']>=70 ? '#3c763d' : '#a94442' }}; color: #ffffff">{{ round($porcentaje['porcentaje'],2) }}%</td>
        @endforeach

        <td  style="background: {{ $imp_porcentaje>=70 ? '#3c763d' : '#a94442' }}; color: #ffffff">{{ round($imp_porcentaje,2) }}%</td>
    </tr>
    </tbody>
</table>
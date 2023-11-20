<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="list-group">
            <a  class="list-group-item active" style="text-align: center; background: #95999c; font-size: 25px;">{{ $horas[0]->horario_dia }}</a>
            @foreach($alumnos as $alumno)
                @if($horas[0]->id_horarios_dias == $alumno['id_horarios_dias'])
                    <a  class="list-group-item">
                        <h3 style="color: #2b2b2b">NO. CUENTA:  {{ $alumno['no_cuenta'] }}</h3>
                        <h4> NOMBRE DEL ESTUDIANTE: {{ $alumno['nombre_al'] }} {{ $alumno['apaterno'] }}  {{ $alumno['amaterno'] }}</h4>
                        <h5>CARRERA: {{ $alumno['carrera'] }} </h5>
                        <p>PRESIDENTE: {{ $alumno['presidente'] }}</p>
                        <p>SECRETARIO: {{ $alumno['secretario'] }}</p>
                        <p>VOCAL: {{ $alumno['vocal'] }}</p>
                        <p>SUPLENTE: {{ $alumno['suplente'] }}</p>
                    </a>
                @endif


            @endforeach

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="list-group">
            <a  class="list-group-item active" style="text-align: center; background: #95999c; font-size: 25px;">{{ $horas[1]->horario_dia }}</a>

        @foreach($alumnos as $alumno)
                @if($horas[1]->id_horarios_dias == $alumno['id_horarios_dias'])
                    <a  class="list-group-item">
                        <h3 style="color: #2b2b2b">NO. CUENTA:  {{ $alumno['no_cuenta'] }}</h3>
                        <h5> NOMBRE DEL ESTUDIANTE: {{ $alumno['nombre_al'] }} {{ $alumno['apaterno'] }}  {{ $alumno['amaterno'] }}</h5>
                        <h4>CARRERA: {{ $alumno['carrera'] }} </h4>
                        <p>PRESIDENTE: {{ $alumno['presidente'] }}</p>
                        <p>SECRETARIO: {{ $alumno['secretario'] }}</p>
                        <p>VOCAL: {{ $alumno['vocal'] }}</p>
                        <p>SUPLENTE: {{ $alumno['suplente'] }}</p>

                    </a>
                @endif


            @endforeach

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="list-group">
            <a  class="list-group-item active" style="text-align: center; background: #95999c; font-size: 25px;">{{ $horas[2]->horario_dia }}</a>

        @foreach($alumnos as $alumno)
                @if($horas[2]->id_horarios_dias == $alumno['id_horarios_dias'])
                    <a  class="list-group-item">
                        <h3 style="color: #2b2b2b">NO. CUENTA:  {{ $alumno['no_cuenta'] }}</h3>
                        <h5> NOMBRE DEL ESTUDIANTE: {{ $alumno['nombre_al'] }} {{ $alumno['apaterno'] }}  {{ $alumno['amaterno'] }}</h5>
                        <h4>CARRERA: {{ $alumno['carrera'] }} </h4>
                        <p>PRESIDENTE: {{ $alumno['presidente'] }}</p>
                        <p>SECRETARIO: {{ $alumno['secretario'] }}</p>
                        <p>VOCAL: {{ $alumno['vocal'] }}</p>
                        <p>SUPLENTE: {{ $alumno['suplente'] }}</p>

                    </a>
                @endif


            @endforeach

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="list-group">
            <a  class="list-group-item active" style="text-align: center; background: #95999c; font-size: 25px;">{{ $horas[3]->horario_dia }}</a>

        @foreach($alumnos as $alumno)
                @if($horas[3]->id_horarios_dias == $alumno['id_horarios_dias'])
                    <a  class="list-group-item">
                        <h3 style="color: #2b2b2b">NO. CUENTA:  {{ $alumno['no_cuenta'] }}</h3>
                        <h5> NOMBRE DEL ESTUDIANTE: {{ $alumno['nombre_al'] }} {{ $alumno['apaterno'] }}  {{ $alumno['amaterno'] }}</h5>
                        <h4>CARRERA: {{ $alumno['carrera'] }} </h4>
                        <p>PRESIDENTE: {{ $alumno['presidente'] }}</p>
                        <p>SECRETARIO: {{ $alumno['secretario'] }}</p>
                        <p>VOCAL: {{ $alumno['vocal'] }}</p>
                        <p>SUPLENTE: {{ $alumno['suplente'] }}</p>

                    </a>
                @endif


            @endforeach

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="list-group">
            <a  class="list-group-item active" style="text-align: center; background: #95999c; font-size: 25px;">{{ $horas[4]->horario_dia }}</a>

            @foreach($alumnos as $alumno)
                @if($horas[4]->id_horarios_dias == $alumno['id_horarios_dias'])
                    <a  class="list-group-item">
                        <h3 style="color: #2b2b2b">NO. CUENTA:  {{ $alumno['no_cuenta'] }}</h3>
                        <h5> NOMBRE DEL ESTUDIANTE: {{ $alumno['nombre_al'] }} {{ $alumno['apaterno'] }}  {{ $alumno['amaterno'] }}</h5>
                        <h4>CARRERA: {{ $alumno['carrera'] }} </h4>
                        <p>PRESIDENTE: {{ $alumno['presidente'] }}</p>
                        <p>SECRETARIO: {{ $alumno['secretario'] }}</p>
                        <p>VOCAL: {{ $alumno['vocal'] }}</p>
                        <p>SUPLENTE: {{ $alumno['suplente'] }}</p>

                    </a>
                @endif


            @endforeach

        </div>
    </div>
</div>
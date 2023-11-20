
<div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1" >
            <p>Nombre: <b>{{$personales->titulo}} </b> {{$personales->nombre}}</p>
        </div>
    </div>
    @if($personales->automovil == 2)
        <div class="row">
            <div class="col-md-10 col-md-offset-1" >
                <p>Automovil</p>
                <table  class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Placas</th>
                        <th>Modelo</th>
                        <th>Licencia</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td>{{ $personales->placas }}</td>
                        <td>{{ $personales->modelo }}</td>
                        <td>{{ $personales->licencia }}</td>


                    </tr>


                    </tbody>
                </table>
            </div>
        </div>
    @endif
    <div class="row">

        <div class="col-md-10 col-md-offset-1" >
            <p align="justify"><b>Motivo de la comisión:</b> <br>{{ $oficios->desc_comision }}</p>
        </div>
        <div class="col-md-10 col-md-offset-1" >
            <table id="table_envio" class="table table-bordered table-resposive">
                <thead>
                <tr>
                    <th>Dependencias de la comisión</th>
                    <th>Domicilio de la comision</th>
                    <th>Municipio</th>
                    <th>Estado</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dependencias as $dependencias)
                    <tr>
                        <td>{{ $dependencias->dependencia }}</td>
                        <td>{{ $dependencias->domicilio }}</td>
                        <td>{{ $dependencias->nombre_municipio }}</td>
                        <td>{{ $dependencias->nombre_estado }}</td>

                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <div class="col-md-4 col-md-offset-1" >
            <p align="center"><b>Fecha de salida:</b> <br>{{ $oficios->fecha_salida }}<br><b>Hora: </b>{{$oficios->hora_s}}</p>
        </div>
        <div class="col-md-4 col-md-offset-1" >
            <p align="center"><b>Fecha de regreso:</b> <br>{{ $oficios->fecha_regreso }}<br><b>Hora: </b>{{$oficios->hora_r}}</p>
        </div>
        <div class="col-md-4 col-md-offset-1" >
            <p align="center"><b>Lugar salida:</b> {{ $lugar_s->descripcion }}</p>
        </div>
        <div class="col-md-4 col-md-offset-1" >
            <p align="center"><b>Lugar regreso:</b> {{ $lugar_r->descripcion }}</p>
        </div>



    </div>



</div>


<div>


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table id="table_envio" class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Nombre del Comisionado</th>
                        <th>Viaticos</th>
                        <th>Auto</th>
                    </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td><b>{{ $personal->titulo }}</b> {{ $personal->nombre }}</td>
                            @if(($personal->viaticos==1))
                                <td class="text-center">NO</td>
                            @endif
                            @if(($personal->viaticos==2))
                                <td class="text-center">SI</td>
                            @endif
                            @if(($personal->automovil==1))
                                <td class="text-center">NO</td>
                                @endif
                            @if(($personal->automovil==2))
                                <td class="text-center"><b>Modelo:</b>{{$personal->modelo}}<br><b>Placas:</b>{{$personal->placas}}<br><b>Licencia:</b>{{$personal->licencia}}</td>
                            @endif
                        </tr>
                    

                    </tbody>
                </table>
            </div>
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
                <?php $fecha_salida = date("d-m-Y", strtotime($oficios->fecha_salida));?>
                <p align="center"><b>Fecha de salida:</b> <br>{{ $fecha_salida }}<br><b>Hora: </b>{{$oficios->hora_s}}</p>
            </div>
            <div class="col-md-4 col-md-offset-1" >
                <?php $fecha_regreso = date("d-m-Y", strtotime($oficios->fecha_regreso));?>
                <p align="center"><b>Fecha de regreso:</b> <br>{{ $fecha_regreso }}<br><b>Hora: </b>{{$oficios->hora_r}}</p>
            </div>
            <div class="col-md-4 col-md-offset-1" >
                <p align="center"><b>Lugar salida:</b> {{ $lugar_s->descripcion }}</p>
            </div>
            <div class="col-md-4 col-md-offset-1" >
                <p align="center"><b>Lugar regreso:</b> {{ $lugar_r->descripcion }}</p>
            </div>



        </div>



</div>

